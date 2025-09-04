<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Carbon\Carbon;

class Test extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'title',
        'description',
        'categories_questions',
        'duration_minutes',
        'start_time',
        'end_time',
        'max_attempts',
        'is_active'
    ];

    protected $casts = [
        'categories_questions' => 'array',
        'start_time' => 'datetime',
        'end_time' => 'datetime',
        'is_active' => 'boolean',
    ];

    public function testResults(): HasMany
    {
        return $this->hasMany(TestResult::class);
    }

    public function userTestAttempts(): HasMany
    {
        return $this->hasMany(UserTestAttempt::class);
    }

    public function isAvailable(): bool
    {
        $now = Carbon::now();
        return $this->is_active && 
               $now->between($this->start_time, $this->end_time);
    }

    public function canUserTakeTest($userId): bool
    {
        if (!$this->isAvailable()) {
            return false;
        }

        $attempt = UserTestAttempt::where('user_id', $userId)
                                 ->where('test_id', $this->id)
                                 ->first();

        return !$attempt || $attempt->attempts_count < $this->max_attempts;
    }

    public function generateQuestions(): array
    {
        $questions = [];
        
        foreach ($this->categories_questions as $categoryId => $count) {
            $categoryQuestions = Question::where('category_id', $categoryId)
                                       ->where('is_active', true)
                                       ->inRandomOrder()
                                       ->limit($count)
                                       ->get();
            
            $questions = array_merge($questions, $categoryQuestions->toArray());
        }
        
        shuffle($questions);
        return $questions;
    }
}
