<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Category;
use App\Models\Question;
use App\Models\Test;
use App\Models\TestResult;
use App\Models\UserTestAttempt;

class ModelTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_model_has_correct_roles()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $user = User::factory()->create(['role' => 'user']);
        
        $this->assertTrue($admin->isAdmin());
        $this->assertFalse($admin->isUser());
        
        $this->assertTrue($user->isUser());
        $this->assertFalse($user->isAdmin());
    }

    /** @test */
    public function category_has_questions_relationship()
    {
        $category = Category::factory()->create();
        $question = Question::factory()->create(['category_id' => $category->id]);
        
        $this->assertTrue($category->questions->contains($question));
        $this->assertEquals($category->id, $question->category_id);
    }

    /** @test */
    public function question_has_options_attribute()
    {
        $question = Question::factory()->create([
            'option_a' => 'Option A',
            'option_b' => 'Option B', 
            'option_c' => 'Option C',
            'option_d' => 'Option D'
        ]);
        
        $options = $question->getOptionsAttribute();
        
        $this->assertEquals('Option A', $options['a']);
        $this->assertEquals('Option B', $options['b']);
        $this->assertEquals('Option C', $options['c']);
        $this->assertEquals('Option D', $options['d']);
    }

    /** @test */
    public function test_model_can_check_availability()
    {
        $activeTest = Test::factory()->create([
            'is_active' => true,
            'start_time' => now()->subHour(),
            'end_time' => now()->addHour()
        ]);
        
        $inactiveTest = Test::factory()->create([
            'is_active' => false,
            'start_time' => now()->subHour(),
            'end_time' => now()->addHour()
        ]);
        
        $expiredTest = Test::factory()->create([
            'is_active' => true,
            'start_time' => now()->subDay(),
            'end_time' => now()->subHour()
        ]);
        
        $this->assertTrue($activeTest->isAvailable());
        $this->assertFalse($inactiveTest->isAvailable());
        $this->assertFalse($expiredTest->isAvailable());
    }

    /** @test */
    public function test_model_can_generate_questions()
    {
        $category1 = Category::factory()->create(['is_active' => true]);
        $category2 = Category::factory()->create(['is_active' => true]);
        
        Question::factory()->count(5)->create([
            'category_id' => $category1->id,
            'is_active' => true
        ]);
        
        Question::factory()->count(3)->create([
            'category_id' => $category2->id,
            'is_active' => true
        ]);
        
        $test = Test::factory()->create([
            'categories_questions' => [
                $category1->id => 3,
                $category2->id => 2
            ]
        ]);
        
        $questions = $test->generateQuestions();
        
        $this->assertCount(5, $questions);
    }

    /** @test */
    public function test_result_can_calculate_results()
    {
        $user = User::factory()->create();
        $test = Test::factory()->create();
        
        $questions = [
            ['id' => 1, 'correct_answer' => 'a'],
            ['id' => 2, 'correct_answer' => 'b'],
            ['id' => 3, 'correct_answer' => 'c'],
            ['id' => 4, 'correct_answer' => 'd']
        ];
        
        $answers = [
            1 => 'a', // correct
            2 => 'b', // correct
            3 => 'x', // wrong
            // 4 is unanswered
        ];
        
        $testResult = TestResult::create([
            'user_id' => $user->id,
            'test_id' => $test->id,
            'questions' => $questions,
            'answers' => $answers,
            'started_at' => now(),
            'is_completed' => true
        ]);
        
        $testResult->calculateResults();
        $testResult->refresh();
        
        $this->assertEquals(2, $testResult->correct_answers);
        $this->assertEquals(1, $testResult->wrong_answers);
        $this->assertEquals(3, $testResult->answered_questions);
        $this->assertEquals(1, $testResult->unanswered_questions);
        $this->assertEquals(50.0, $testResult->score); // 2 correct out of 4 = 50%
    }

    /** @test */
    public function user_test_attempt_can_increment()
    {
        $user = User::factory()->create();
        $test = Test::factory()->create();
        
        $attempt = UserTestAttempt::create([
            'user_id' => $user->id,
            'test_id' => $test->id,
            'attempts_count' => 1
        ]);
        
        $attempt->incrementAttempt();
        $attempt->refresh();
        
        $this->assertEquals(2, $attempt->attempts_count);
    }

    /** @test */
    public function test_can_check_user_eligibility()
    {
        $user = User::factory()->create();
        $test = Test::factory()->create([
            'is_active' => true,
            'start_time' => now()->subHour(),
            'end_time' => now()->addHour(),
            'max_attempts' => 2
        ]);
        
        // User can take test initially
        $this->assertTrue($test->canUserTakeTest($user->id));
        
        // After max attempts reached
        UserTestAttempt::create([
            'user_id' => $user->id,
            'test_id' => $test->id,
            'attempts_count' => 2
        ]);
        
        $this->assertFalse($test->canUserTakeTest($user->id));
    }
}
