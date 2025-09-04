<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Question;
use App\Models\Category;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    public function index()
    {
        $questions = Question::with('category')
                           ->orderBy('created_at', 'desc')
                           ->paginate(20);
        return view('admin.questions.index', compact('questions'));
    }

    public function create()
    {
        $categories = Category::where('is_active', true)->get();
        return view('admin.questions.create', compact('categories'));
    }

    public function store(Request $request)
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

    public function show(Question $question)
    {
        $question->load('category');
        return view('admin.questions.show', compact('question'));
    }

    public function edit(Question $question)
    {
        $categories = Category::where('is_active', true)->get();
        return view('admin.questions.edit', compact('question', 'categories'));
    }

    public function update(Request $request, Question $question)
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

    public function destroy(Question $question)
    {
        $question->delete();

        return redirect()->route('admin.questions.index')
                        ->with('success', 'Savol muvaffaqiyatli o\'chirildi.');
    }
}
