<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Test;
use App\Models\Category;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function index()
    {
        $tests = Test::orderBy('created_at', 'desc')->paginate(20);
        return view('admin.tests.index', compact('tests'));
    }

    public function create()
    {
        $categories = Category::where('is_active', true)->with('activeQuestions')->get();
        return view('admin.tests.create', compact('categories'));
    }

    public function store(Request $request)
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

    public function show(Test $test)
    {
        return view('admin.tests.show', compact('test'));
    }

    public function edit(Test $test)
    {
        $categories = Category::where('is_active', true)->with('activeQuestions')->get();
        return view('admin.tests.edit', compact('test', 'categories'));
    }

    public function update(Request $request, Test $test)
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

    public function destroy(Test $test)
    {
        $test->delete();

        return redirect()->route('admin.tests.index')
                        ->with('success', 'Test muvaffaqiyatli o\'chirildi.');
    }
}
