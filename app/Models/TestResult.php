<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TestResult extends Model
{
    protected $fillable = [
        'user_id',
        'test_id',
        'questions',
        'answers',
        'correct_answers',
        'wrong_answers',
        'answered_questions',
        'unanswered_questions',
        'score',
        'started_at',
        'finished_at',
        'is_completed'
    ];

    protected $casts = [
        'questions' => 'array',
        'answers' => 'array',
        'started_at' => 'datetime',
        'finished_at' => 'datetime',
        'is_completed' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function test(): BelongsTo
    {
        return $this->belongsTo(Test::class);
    }

    public function calculateResults(): void
    {
        $correctAnswers = 0;
        $answeredQuestions = 0;
        $answers = $this->answers ?? [];
        
        foreach ($this->questions as $question) {
            if (isset($answers[$question['id']])) {
                $answeredQuestions++;
                if ($answers[$question['id']] === $question['correct_answer']) {
                    $correctAnswers++;
                }
            }
        }
        
        $this->update([
            'correct_answers' => $correctAnswers,
            'wrong_answers' => $answeredQuestions - $correctAnswers,
            'answered_questions' => $answeredQuestions,
            'unanswered_questions' => count($this->questions) - $answeredQuestions,
            'score' => round(($correctAnswers / count($this->questions)) * 100, 2)
        ]);
    }

    public function getDetailedResults(): array
    {
        $results = [];
        $answers = $this->answers ?? [];
        
        foreach ($this->questions as $question) {
            $userAnswer = $answers[$question['id']] ?? null;
            $results[] = [
                'question' => $question,
                'user_answer' => $userAnswer,
                'is_correct' => $userAnswer === $question['correct_answer'],
                'correct_answer' => $question['correct_answer']
            ];
        }
        
        return $results;
    }
}
