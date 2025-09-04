<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Category;
use App\Models\Question;
use App\Models\Test;
use App\Models\TestResult;
use App\Models\UserTestAttempt;

class TestTakingTest extends TestCase
{
    use RefreshDatabase;

    protected $user;
    protected $admin;
    protected $test;
    protected $category;
    protected $questions;

    public function setUp(): void
    {
        parent::setUp();
        
        $this->user = User::factory()->create([
            'role' => 'user',
            'is_active' => true
        ]);
        
        $this->admin = User::factory()->create([
            'role' => 'admin',
            'is_active' => true
        ]);
        
        $this->category = Category::factory()->create([
            'name' => 'Math',
            'is_active' => true
        ]);
        
        $this->questions = Question::factory()->count(5)->create([
            'category_id' => $this->category->id,
            'is_active' => true
        ]);
        
        $this->test = Test::factory()->create([
            'title' => 'Test Math',
            'categories_questions' => [$this->category->id => 3],
            'duration_minutes' => 10,
            'start_time' => now()->subHour(),
            'end_time' => now()->addHour(),
            'max_attempts' => 2,
            'is_active' => true
        ]);
    }

    /** @test */
    public function user_can_access_user_dashboard()
    {
        $response = $this->actingAs($this->user)->get('/user/dashboard');
        $response->assertStatus(200)
                ->assertViewIs('user.dashboard');
    }

    /** @test */
    public function admin_cannot_access_user_dashboard()
    {
        $response = $this->actingAs($this->admin)->get('/user/dashboard');
        $response->assertRedirect('/login');
    }

    /** @test */
    public function user_can_view_available_test()
    {
        $response = $this->actingAs($this->user)->get("/user/test/{$this->test->id}");
        $response->assertStatus(200)
                ->assertViewIs('user.test-start')
                ->assertSee($this->test->title);
    }

    /** @test */
    public function user_can_start_test()
    {
        $response = $this->actingAs($this->user)
                        ->post("/user/test/{$this->test->id}/start");
        
        $response->assertRedirect();
        $this->assertDatabaseHas('test_results', [
            'user_id' => $this->user->id,
            'test_id' => $this->test->id,
            'is_completed' => false
        ]);
        
        $this->assertDatabaseHas('user_test_attempts', [
            'user_id' => $this->user->id,
            'test_id' => $this->test->id,
            'attempts_count' => 1
        ]);
    }

    /** @test */
    public function user_cannot_exceed_max_attempts()
    {
        // Create max attempts
        UserTestAttempt::create([
            'user_id' => $this->user->id,
            'test_id' => $this->test->id,
            'attempts_count' => $this->test->max_attempts
        ]);
        
        $response = $this->actingAs($this->user)
                        ->post("/user/test/{$this->test->id}/start");
        
        $response->assertRedirect('/user/dashboard')
                ->assertSessionHas('error');
    }

    /** @test */
    public function user_can_save_answer()
    {
        // Start a test first
        $testResult = TestResult::create([
            'user_id' => $this->user->id,
            'test_id' => $this->test->id,
            'questions' => $this->questions->take(3)->toArray(),
            'started_at' => now(),
            'is_completed' => false
        ]);
        
        $question = $this->questions->first();
        
        $response = $this->actingAs($this->user)
                        ->postJson("/user/test-result/{$testResult->id}/answer", [
                            'question_id' => $question->id,
                            'answer' => 'a'
                        ]);
        
        $response->assertJson(['success' => true]);
        
        $testResult->refresh();
        $this->assertEquals('a', $testResult->answers[$question->id]);
    }

    /** @test */
    public function user_can_finish_test()
    {
        $testResult = TestResult::create([
            'user_id' => $this->user->id,
            'test_id' => $this->test->id,
            'questions' => $this->questions->take(3)->toArray(),
            'started_at' => now(),
            'is_completed' => false
        ]);
        
        $response = $this->actingAs($this->user)
                        ->post("/user/test-result/{$testResult->id}/finish");
        
        $response->assertRedirect("/user/test-result/{$testResult->id}");
        
        $testResult->refresh();
        $this->assertTrue($testResult->is_completed);
        $this->assertNotNull($testResult->finished_at);
    }

    /** @test */
    public function user_can_view_test_result()
    {
        $testResult = TestResult::create([
            'user_id' => $this->user->id,
            'test_id' => $this->test->id,
            'questions' => $this->questions->take(3)->toArray(),
            'started_at' => now(),
            'finished_at' => now(),
            'is_completed' => true,
            'correct_answers' => 2,
            'wrong_answers' => 1,
            'score' => 66.67
        ]);
        
        $response = $this->actingAs($this->user)
                        ->get("/user/test-result/{$testResult->id}");
        
        $response->assertStatus(200)
                ->assertViewIs('user.test-result')
                ->assertSee('66.67');
    }

    /** @test */
    public function user_cannot_access_other_users_test_result()
    {
        $otherUser = User::factory()->create(['role' => 'user']);
        
        $testResult = TestResult::create([
            'user_id' => $otherUser->id,
            'test_id' => $this->test->id,
            'questions' => $this->questions->take(3)->toArray(),
            'started_at' => now(),
            'is_completed' => true
        ]);
        
        $response = $this->actingAs($this->user)
                        ->get("/user/test-result/{$testResult->id}");
        
        $response->assertStatus(403);
    }
}
