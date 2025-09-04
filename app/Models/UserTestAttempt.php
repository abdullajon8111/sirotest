<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserTestAttempt extends Model
{
    protected $fillable = [
        'user_id',
        'test_id',
        'attempts_count'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function test(): BelongsTo
    {
        return $this->belongsTo(Test::class);
    }

    public function incrementAttempt(): void
    {
        $this->increment('attempts_count');
    }
}
