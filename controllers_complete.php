<?php

// CategoryController
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class CategoryController extends Controller
{
    public function index(): View
    {
        $categories = Category::orderBy('created_at', 'desc')->get();
        return view('admin.categories.index', compact('categories'));
    }

    public function create(): View
    {
        return view('admin.categories.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'is_active' => 'boolean'
        ]);

        Category::create($validated);

        return redirect()->route('admin.categories.index')
                        ->with('success', 'Kategoriya muvaffaqiyatli yaratildi.');
    }

    public function show(Category $category): View
    {
        $category->load('questions');
        return view('admin.categories.show', compact('category'));
    }

    public function edit(Category $category): View
    {
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'is_active' => 'boolean'
        ]);

        $category->update($validated);

        return redirect()->route('admin.categories.index')
                        ->with('success', 'Kategoriya muvaffaqiyatli yangilandi.');
    }

    public function destroy(Category $category): RedirectResponse
    {
        $category->delete();

        return redirect()->route('admin.categories.index')
                        ->with('success', 'Kategoriya muvaffaqiyatli o\'chirildi.');
    }
}

// QuestionController
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Question;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class QuestionController extends Controller
{
    public function index(): View
    {
        $questions = Question::with('category')
                           ->orderBy('created_at', 'desc')
                           ->paginate(20);
        return view('admin.questions.index', compact('questions'));
    }

    public function create(): View
    {
        $categories = Category::where('is_active', true)->get();
        return view('admin.questions.create', compact('categories'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'question' => 'required|string',
            'option_a' => 'required|string',
            'option_b' => 'required|string',
            'option_c' => 'required|string',
            'option_d' => 'required|string',
            'correct_answer' => 'required|in:a,b,c,d',
            'is_active' => 'boolean'
        ]);

        Question::create($validated);

        return redirect()->route('admin.questions.index')
                        ->with('success', 'Savol muvaffaqiyatli yaratildi.');
    }

    public function show(Question $question): View
    {
        $question->load('category');
        return view('admin.questions.show', compact('question'));
    }

    public function edit(Question $question): View
    {
        $categories = Category::where('is_active', true)->get();
        return view('admin.questions.edit', compact('question', 'categories'));
    }

    public function update(Request $request, Question $question): RedirectResponse
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'question' => 'required|string',
            'option_a' => 'required|string',
            'option_b' => 'required|string',
            'option_c' => 'required|string',
            'option_d' => 'required|string',
            'correct_answer' => 'required|in:a,b,c,d',
            'is_active' => 'boolean'
        ]);

        $question->update($validated);

        return redirect()->route('admin.questions.index')
                        ->with('success', 'Savol muvaffaqiyatli yangilandi.');
    }

    public function destroy(Question $question): RedirectResponse
    {
        $question->delete();

        return redirect()->route('admin.questions.index')
                        ->with('success', 'Savol muvaffaqiyatli o\'chirildi.');
    }
}

// TestController
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Test;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class TestController extends Controller
{
    public function index(): View
    {
        $tests = Test::orderBy('created_at', 'desc')->paginate(20);
        return view('admin.tests.index', compact('tests'));
    }

    public function create(): View
    {
        $categories = Category::where('is_active', true)->with('activeQuestions')->get();
        return view('admin.tests.create', compact('categories'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'duration_minutes' => 'required|integer|min:1',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
            'max_attempts' => 'required|integer|min:1',
            'is_active' => 'boolean',
            'categories' => 'required|array',
            'categories.*' => 'required|integer|min:1'
        ]);

        $categoriesQuestions = [];
        foreach ($validated['categories'] as $categoryId => $count) {
            $categoriesQuestions[$categoryId] = $count;
        }

        $testData = $validated;
        $testData['categories_questions'] = $categoriesQuestions;
        unset($testData['categories']);

        Test::create($testData);

        return redirect()->route('admin.tests.index')
                        ->with('success', 'Test muvaffaqiyatli yaratildi.');
    }

    public function show(Test $test): View
    {
        return view('admin.tests.show', compact('test'));
    }

    public function edit(Test $test): View
    {
        $categories = Category::where('is_active', true)->with('activeQuestions')->get();
        return view('admin.tests.edit', compact('test', 'categories'));
    }

    public function update(Request $request, Test $test): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'duration_minutes' => 'required|integer|min:1',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
            'max_attempts' => 'required|integer|min:1',
            'is_active' => 'boolean',
            'categories' => 'required|array',
            'categories.*' => 'required|integer|min:1'
        ]);

        $categoriesQuestions = [];
        foreach ($validated['categories'] as $categoryId => $count) {
            $categoriesQuestions[$categoryId] = $count;
        }

        $testData = $validated;
        $testData['categories_questions'] = $categoriesQuestions;
        unset($testData['categories']);

        $test->update($testData);

        return redirect()->route('admin.tests.index')
                        ->with('success', 'Test muvaffaqiyatli yangilandi.');
    }

    public function destroy(Test $test): RedirectResponse
    {
        $test->delete();

        return redirect()->route('admin.tests.index')
                        ->with('success', 'Test muvaffaqiyatli o\'chirildi.');
    }
}

// UserController (Admin)
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(): View
    {
        $users = User::where('role', 'user')
                    ->orderBy('created_at', 'desc')
                    ->paginate(20);
        return view('admin.users.index', compact('users'));
    }

    public function create(): View
    {
        return view('admin.users.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'is_active' => 'boolean'
        ]);

        $validated['password'] = Hash::make($validated['password']);
        $validated['role'] = 'user';

        User::create($validated);

        return redirect()->route('admin.users.index')
                        ->with('success', 'Foydalanuvchi muvaffaqiyatli yaratildi.');
    }

    public function show(User $user): View
    {
        $user->load(['testResults.test', 'userTestAttempts.test']);
        return view('admin.users.show', compact('user'));
    }

    public function edit(User $user): View
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'is_active' => 'boolean'
        ]);

        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);

        return redirect()->route('admin.users.index')
                        ->with('success', 'Foydalanuvchi muvaffaqiyatli yangilandi.');
    }

    public function destroy(User $user): RedirectResponse
    {
        $user->delete();

        return redirect()->route('admin.users.index')
                        ->with('success', 'Foydalanuvchi muvaffaqiyatli o\'chirildi.');
    }
}

// DashboardController (User)
namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Test;
use App\Models\TestResult;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(): View
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

// TestTakingController (User)
namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Test;
use App\Models\TestResult;
use App\Models\UserTestAttempt;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class TestTakingController extends Controller
{
    public function show(Test $test): View
    {
        $user = Auth::user();
        
        if (!$test->canUserTakeTest($user->id)) {
            abort(403, 'Bu testni topshira olmaysiz.');
        }

        return view('user.test-start', compact('test'));
    }

    public function start(Test $test): RedirectResponse
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

    public function take(TestResult $testResult): View
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

    public function saveAnswer(Request $request, TestResult $testResult): JsonResponse
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

    public function finish(TestResult $testResult): RedirectResponse
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

    public function result(TestResult $testResult): View
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

// LoginController
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm(): View
    {
        return view('auth.login');
    }

    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();

            $user = Auth::user();
            
            if (!$user->is_active) {
                Auth::logout();
                return redirect()->route('login')
                               ->withErrors(['email' => 'Hisobingiz faol emas.']);
            }

            if ($user->isAdmin()) {
                return redirect()->intended(route('admin.dashboard'));
            } else {
                return redirect()->intended(route('user.dashboard'));
            }
        }

        return back()->withErrors([
            'email' => 'Kiritilgan ma\'lumotlar noto\'g\'ri.',
        ])->onlyInput('email');
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
