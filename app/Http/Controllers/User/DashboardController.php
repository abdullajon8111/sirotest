<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Test;
use App\Models\TestResult;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        $availableTests = Test::where('is_active', true)
                             ->where('start_time', '<=', now())
                             ->where('end_time', '>=', now())
                             ->get()
                             ->filter(function($test) use ($user) {
                                 return $test->canUserTakeTest($user->id);
                             });

        $completedTests = TestResult::where('user_id', $user->id)
                                   ->where('is_completed', true)
                                   ->with('test')
                                   ->orderBy('created_at', 'desc')
                                   ->limit(10)
                                   ->get();

        return view('user.dashboard', compact('availableTests', 'completedTests'));
    }
}
