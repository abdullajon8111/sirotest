<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Services\QuestionImportService;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::orderBy('created_at', 'desc')->get();
        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(Request $request)
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

    public function show(Category $category)
    {
        $category->load('questions');
        return view('admin.categories.show', compact('category'));
    }

    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
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

    public function destroy(Category $category)
    {
        $category->delete();

        return redirect()->route('admin.categories.index')
                        ->with('success', 'Kategoriya muvaffaqiyatli o\'chirildi.');
    }
    
    public function import(Request $request, Category $category)
    {
        $request->validate([
            'docx_file' => 'required|file|mimes:docx|max:10240' // Max 10MB
        ]);
        
        try {
            $file = $request->file('docx_file');
            $tempPath = $file->getPathname();
            
            $importService = new QuestionImportService();
            $result = $importService->importFromDocx($tempPath, $category->id);
            
            if ($result['success']) {
                return redirect()->route('admin.categories.show', $category)
                    ->with('success', $result['message'])
                    ->with('import_details', [
                        'imported' => $result['imported_count'],
                        'errors' => $result['errors']
                    ]);
            } else {
                return redirect()->route('admin.categories.show', $category)
                    ->with('error', $result['message'])
                    ->with('import_errors', $result['errors']);
            }
            
        } catch (\Exception $e) {
            return redirect()->route('admin.categories.show', $category)
                ->with('error', 'Import xatoligi: ' . $e->getMessage());
        }
    }
}
