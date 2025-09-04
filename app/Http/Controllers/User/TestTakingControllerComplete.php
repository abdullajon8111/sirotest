<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Test;
use App\Models\TestResult;
use App\Models\UserTestAttempt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class TestTakingController extends Controller
{
    public function show(Test $test)
    {
        $user = Auth::user();
        
        if (!$test->canUserTakeTest($user->id)) {
            abort(403, 'Bu testni topshira olmaysiz.');
        }

        return view('user.test-start', compact('test'));
    }

    public function start(Test $test)
    {
        $user = Auth::user();
        
        if (!$test->canUserTakeTest($user->id)) {
            return redirect()->route('user.dashboard')
                           ->with('error', 'Bu testni topshira olmaysiz.');
        }

        // Urinish sonini oshirish
        $attempt = UserTestAttempt::firstOrCreate([
            'user_id' => $user->id,
            'test_id' => $test->id
        ]);
        $attempt->incrementAttempt();

        // Test natijasini yaratish
        $questions = $test->generateQuestions();
        
        $testResult = TestResult::create([
            'user_id' => $user->id,
            'test_id' => $test->id,
            'questions' => $questions,
            'started_at' => now(),
            'is_completed' => false
        ]);

        return redirect()->route('user.test.take', $testResult);
    }

    public function take(TestResult $testResult)
    {
        if ($testResult->user_id !== Auth::id()) {
            abort(403);
        }

        if ($testResult->is_completed) {
            return redirect()->route('user.test.result', $testResult);
        }

        // Vaqt tugaganligini tekshirish
        $timeElapsed = $testResult->started_at->diffInMinutes(now());
        if ($timeElapsed >= $testResult->test->duration_minutes) {
            $this->finishTest($testResult);
            return redirect()->route('user.test.result', $testResult);
        }

        return view('user.test-taking', compact('testResult'));
    }

    public function saveAnswer(Request $request, TestResult $testResult)
    {
        if ($testResult->user_id !== Auth::id() || $testResult->is_completed) {
            return response()->json(['error' => 'Xatolik'], 403);
        }

        $validated = $request->validate([
            'question_id' => 'required|integer',
            'answer' => 'required|in:a,b,c,d'
        ]);

        $answers = $testResult->answers ?? [];
        $answers[$validated['question_id']] = $validated['answer'];
        
        $testResult->update(['answers' => $answers]);

        return response()->json(['success' => true]);
    }

    public function finish(TestResult $testResult)
    {
        if ($testResult->user_id !== Auth::id()) {
            abort(403);
        }

        $this->finishTest($testResult);

        return redirect()->route('user.test.result', $testResult);
    }

    private function finishTest(TestResult $testResult): void
    {
        $testResult->update([
            'finished_at' => now(),
            'is_completed' => true
        ]);

        $testResult->calculateResults();
    }

    public function result(TestResult $testResult)
    {
        if ($testResult->user_id !== Auth::id()) {
            abort(403);
        }

        if (!$testResult->is_completed) {
            return redirect()->route('user.test.take', $testResult);
        }

        $detailedResults = $testResult->getDetailedResults();

        return view('user.test-result', compact('testResult', 'detailedResults'));
    }
}
