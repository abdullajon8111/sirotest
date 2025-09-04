<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Question;
use App\Models\Test;
use App\Models\TestResult;
use App\Models\User;

class AdminController extends Controller
{
    public function index()
    {
        $stats = [
            'total_users' => User::where('role', 'user')->count(),
            'total_categories' => Category::count(),
            'total_questions' => Question::count(),
            'total_tests' => Test::count(),
            'total_test_results' => TestResult::count(),
            'active_tests' => Test::where('is_active', true)->count(),
        ];

        $recent_results = TestResult::with(['user', 'test'])
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        return view('admin.dashboard', compact('stats', 'recent_results'));
    }
}
