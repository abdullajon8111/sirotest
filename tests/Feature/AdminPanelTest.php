<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Category;
use App\Models\Question;
use App\Models\Test;

class AdminPanelTest extends TestCase
{
    use RefreshDatabase;

    protected $admin;
    protected $user;

    public function setUp(): void
    {
        parent::setUp();
        
        $this->admin = User::factory()->create([
            'role' => 'admin',
            'is_active' => true
        ]);
        
        $this->user = User::factory()->create([
            'role' => 'user',
            'is_active' => true
        ]);
    }

    /** @test */
    public function admin_can_access_admin_dashboard()
    {
        $response = $this->actingAs($this->admin)->get('/admin/dashboard');
        $response->assertStatus(200)
                ->assertViewIs('admin.dashboard');
    }

    /** @test */
    public function user_cannot_access_admin_dashboard()
    {
        $response = $this->actingAs($this->user)->get('/admin/dashboard');
        $response->assertRedirect('/login');
    }

    /** @test */
    public function guest_cannot_access_admin_dashboard()
    {
        $response = $this->get('/admin/dashboard');
        $response->assertRedirect('/login');
    }

    /** @test */
    public function admin_can_view_categories_index()
    {
        Category::factory()->create(['name' => 'Test Category']);
        
        $response = $this->actingAs($this->admin)->get('/admin/categories');
        $response->assertStatus(200)
                ->assertSee('Test Category');
    }

    /** @test */
    public function admin_can_create_category()
    {
        $response = $this->actingAs($this->admin)->post('/admin/categories', [
            'name' => 'New Category',
            'description' => 'Test description',
            'is_active' => true
        ]);

        $response->assertRedirect('/admin/categories');
        $this->assertDatabaseHas('categories', [
            'name' => 'New Category',
            'description' => 'Test description'
        ]);
    }

    /** @test */
    public function admin_can_update_category()
    {
        $category = Category::factory()->create(['name' => 'Old Name']);
        
        $response = $this->actingAs($this->admin)
                        ->put("/admin/categories/{$category->id}", [
                            'name' => 'New Name',
                            'description' => 'Updated description',
                            'is_active' => true
                        ]);

        $response->assertRedirect('/admin/categories');
        $this->assertDatabaseHas('categories', [
            'id' => $category->id,
            'name' => 'New Name'
        ]);
    }

    /** @test */
    public function admin_can_delete_category()
    {
        $category = Category::factory()->create();
        
        $response = $this->actingAs($this->admin)
                        ->delete("/admin/categories/{$category->id}");

        $response->assertRedirect('/admin/categories');
        $this->assertDatabaseMissing('categories', ['id' => $category->id]);
    }

    /** @test */
    public function admin_can_create_question()
    {
        $category = Category::factory()->create();
        
        $response = $this->actingAs($this->admin)->post('/admin/questions', [
            'category_id' => $category->id,
            'question' => 'Test question?',
            'option_a' => 'Option A',
            'option_b' => 'Option B',
            'option_c' => 'Option C',
            'option_d' => 'Option D',
            'correct_answer' => 'a',
            'is_active' => true
        ]);

        $response->assertRedirect('/admin/questions');
        $this->assertDatabaseHas('questions', [
            'question' => 'Test question?',
            'correct_answer' => 'a'
        ]);
    }

    /** @test */
    public function admin_can_create_test()
    {
        $category = Category::factory()->create();
        
        $response = $this->actingAs($this->admin)->post('/admin/tests', [
            'title' => 'Test Title',
            'description' => 'Test Description',
            'duration_minutes' => 30,
            'start_time' => now()->format('Y-m-d H:i:s'),
            'end_time' => now()->addDays(7)->format('Y-m-d H:i:s'),
            'max_attempts' => 3,
            'is_active' => true,
            'categories' => [$category->id => 5]
        ]);

        $response->assertRedirect('/admin/tests');
        $this->assertDatabaseHas('tests', [
            'title' => 'Test Title',
            'duration_minutes' => 30
        ]);
    }
}
