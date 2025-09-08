<?php

namespace App\Services;

use App\Models\Question;
use App\Models\Category;
use PhpOffice\PhpWord\IOFactory;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class QuestionImportService
{
    /**
     * Import questions from .docx file into specified category
     *
     * @param string $filePath
     * @param int $categoryId
     * @return array
     */
    public function importFromDocx(string $filePath, int $categoryId): array
    {
        try {
            // Verify category exists
            $category = Category::findOrFail($categoryId);
            
            // Read docx file content
            $content = $this->readDocxFile($filePath);
            
            if (!$content) {
                return [
                    'success' => false,
                    'message' => 'Could not read file content',
                    'imported_count' => 0,
                    'errors' => ['File could not be read']
                ];
            }
            
            // Parse questions from content
            $questions = $this->parseQuestions($content);
            
            if (empty($questions)) {
                return [
                    'success' => false,
                    'message' => 'No valid questions found in file',
                    'imported_count' => 0,
                    'errors' => ['No questions found matching the expected format']
                ];
            }
            
            // Import questions to database
            $result = $this->importQuestions($questions, $categoryId);
            
            return [
                'success' => true,
                'message' => "Successfully imported {$result['imported']} questions into {$category->name}",
                'imported_count' => $result['imported'],
                'errors' => $result['errors'],
                'category' => $category->name
            ];
            
        } catch (Exception $e) {
            Log::error('Question import failed: ' . $e->getMessage());
            
            return [
                'success' => false,
                'message' => 'Import failed: ' . $e->getMessage(),
                'imported_count' => 0,
                'errors' => [$e->getMessage()]
            ];
        }
    }
    
    /**
     * Read content from .docx file
     *
     * @param string $filePath
     * @return string|false
     */
    private function readDocxFile(string $filePath)
    {
        try {
            $phpWord = IOFactory::load($filePath);
            $text = '';
            
            foreach ($phpWord->getSections() as $section) {
                foreach ($section->getElements() as $element) {
                    if (method_exists($element, 'getText')) {
                        $text .= $element->getText() . "\n";
                    } else if (method_exists($element, 'getElements')) {
                        // Handle nested elements (paragraphs, etc.)
                        $this->extractTextFromElements($element->getElements(), $text);
                    }
                }
            }
            
            return $text;
        } catch (Exception $e) {
            Log::error('Error reading docx file: ' . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Recursively extract text from nested elements
     */
    private function extractTextFromElements($elements, &$text)
    {
        foreach ($elements as $element) {
            if (method_exists($element, 'getText')) {
                $text .= $element->getText() . "\n";
            } else if (method_exists($element, 'getElements')) {
                $this->extractTextFromElements($element->getElements(), $text);
            }
        }
    }
    
    /**
     * Parse questions from file content based on the pattern:
     * ++++ starts a new question (and ends previous one)
     * ==== starts an answer option
     * # at the beginning of answer marks it as correct
     * 
     * @param string $content
     * @return array
     */
    private function parseQuestions(string $content): array
    {
        $lines = explode("\n", $content);
        $questions = [];
        $currentQuestion = null;
        $currentAnswers = [];
        $i = 0;
        
        while ($i < count($lines)) {
            $line = trim($lines[$i]);
            
            // Skip empty lines
            if (empty($line)) {
                $i++;
                continue;
            }
            
            // Start of new question (++++)
            if (strpos($line, '++++') === 0) {
                // Save previous question if exists
                if ($currentQuestion !== null && !empty($currentAnswers)) {
                    $questions[] = [
                        'text' => $currentQuestion,
                        'answers' => $currentAnswers
                    ];
                }
                
                // Get question text (everything after ++++)
                $questionText = trim(substr($line, 4));
                
                // If no text after ++++, get from next line
                if (empty($questionText) && ($i + 1) < count($lines)) {
                    $nextLine = trim($lines[$i + 1]);
                    if (!empty($nextLine) && strpos($nextLine, '====') !== 0 && strpos($nextLine, '=====') !== 0 && strpos($nextLine, '++++') !== 0) {
                        $questionText = $nextLine;
                    }
                }
                
                // If still no question text, break (end of questions)
                if (empty($questionText)) {
                    break;
                }
                
                $currentQuestion = $questionText;
                $currentAnswers = [];
                $i++;
                continue;
            }
            
            // Start of answer option (==== or =====)
            if (strpos($line, '====') === 0 || strpos($line, '=====') === 0) {
                $equalSigns = strpos($line, '=====') === 0 ? 5 : 4;
                $answerText = trim(substr($line, $equalSigns));
                
                // If no text after ====, get from next line
                if (empty($answerText) && ($i + 1) < count($lines)) {
                    $nextLine = trim($lines[$i + 1]);
                    if (!empty($nextLine) && strpos($nextLine, '====') !== 0 && strpos($nextLine, '=====') !== 0 && strpos($nextLine, '++++') !== 0) {
                        $answerText = $nextLine;
                    }
                }
                
                // Skip if still no answer text
                if (empty($answerText)) {
                    $i++;
                    continue;
                }
                
                // Check if this is correct answer (starts with #)
                $isCorrect = false;
                if (strpos($answerText, '#') === 0) {
                    $isCorrect = true;
                    $answerText = trim(substr($answerText, 1));
                }
                
                if (!empty(trim($answerText))) {
                    $currentAnswers[] = [
                        'text' => $answerText,
                        'is_correct' => $isCorrect
                    ];
                }
                $i++;
                continue;
            }
            
            $i++;
        }
        
        // Don't forget the last question
        if ($currentQuestion !== null && !empty($currentAnswers)) {
            $questions[] = [
                'text' => $currentQuestion,
                'answers' => $currentAnswers
            ];
        }
        
        return $this->validateQuestions($questions);
    }
    
    /**
     * Validate parsed questions
     */
    private function validateQuestions(array $questions): array
    {
        $validQuestions = [];
        
        foreach ($questions as $index => $question) {
            // Skip if question text is empty
            if (empty(trim($question['text']))) {
                continue;
            }
            
            // Skip if no answers
            if (empty($question['answers']) || count($question['answers']) < 2) {
                continue;
            }
            
            // Check if at least one correct answer exists
            $hasCorrectAnswer = false;
            $validAnswers = [];
            
            foreach ($question['answers'] as $answer) {
                if (!empty(trim($answer['text']))) {
                    $validAnswers[] = $answer;
                    if ($answer['is_correct']) {
                        $hasCorrectAnswer = true;
                    }
                }
            }
            
            // Skip if no correct answer or less than 2 valid answers
            if (!$hasCorrectAnswer || count($validAnswers) < 2) {
                continue;
            }
            
            $validQuestions[] = [
                'text' => trim($question['text']),
                'answers' => $validAnswers
            ];
        }
        
        return $validQuestions;
    }
    
    /**
     * Import questions into database
     */
    private function importQuestions(array $questions, int $categoryId): array
    {
        $imported = 0;
        $errors = [];
        
        DB::beginTransaction();
        
        try {
            foreach ($questions as $index => $questionData) {
                try {
                    $question = Question::create([
                        'category_id' => $categoryId,
                        'question' => $questionData['text'],
                        'option_a' => $questionData['answers'][0]['text'] ?? '',
                        'option_b' => $questionData['answers'][1]['text'] ?? '',
                        'option_c' => $questionData['answers'][2]['text'] ?? '',
                        'option_d' => $questionData['answers'][3]['text'] ?? '',
                        'correct_answer' => $this->getCorrectAnswer($questionData['answers']),
                    ]);
                    
                    $imported++;
                } catch (Exception $e) {
                    $errors[] = "Question " . ($index + 1) . ": " . $e->getMessage();
                }
            }
            
            DB::commit();
            
            return [
                'imported' => $imported,
                'errors' => $errors
            ];
            
        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }
    }
    
    /**
     * Determine correct answer letter based on answers array
     */
    private function getCorrectAnswer(array $answers): string
    {
        foreach ($answers as $index => $answer) {
            if ($answer['is_correct']) {
                return strtolower(chr(65 + $index)); // a, b, c, d
            }
        }
        
        return 'a'; // Default fallback
    }
}
