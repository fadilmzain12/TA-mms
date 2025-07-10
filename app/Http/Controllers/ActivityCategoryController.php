<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ActivityCategoryController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // Only admins can manage activity categories
        $this->middleware('admin');
    }

    /**
     * Display a listing of the activity categories.
     */
    public function index()
    {
        $categories = \App\Models\ActivityCategory::withCount('activities')->orderBy('name')->get();
        return view('admin.activity_categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new activity category.
     */
    public function create()
    {
        return view('admin.activity_categories.create');
    }

    /**
     * Store a newly created activity category in storage.
     */
    public function store(Request $request)
    {
        // Validate request
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'color' => 'required|string|max:7',
        ]);
        
        // Create new activity category
        \App\Models\ActivityCategory::create([
            'name' => $request->name,
            'description' => $request->description,
            'color' => $request->color,
        ]);
        
        return redirect()->route('admin.activity-categories.index')
            ->with('success', 'Kategori kegiatan berhasil ditambahkan');
    }

    /**
     * Display the specified activity category.
     */
    public function show($id)
    {
        $category = \App\Models\ActivityCategory::with('activities')->findOrFail($id);
        return view('admin.activity_categories.show', compact('category'));
    }

    /**
     * Show the form for editing the specified activity category.
     */
    public function edit($id)
    {
        $category = \App\Models\ActivityCategory::findOrFail($id);
        return view('admin.activity_categories.edit', compact('category'));
    }

    /**
     * Update the specified activity category in storage.
     */
    public function update(Request $request, $id)
    {
        // Validate request
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'color' => 'required|string|max:7',
        ]);
        
        // Update activity category
        $category = \App\Models\ActivityCategory::findOrFail($id);
        $category->update([
            'name' => $request->name,
            'description' => $request->description,
            'color' => $request->color,
        ]);
        
        return redirect()->route('admin.activity-categories.index')
            ->with('success', 'Kategori kegiatan berhasil diperbarui');
    }

    /**
     * Remove the specified activity category from storage.
     */
    public function destroy($id)
    {
        $category = \App\Models\ActivityCategory::findOrFail($id);
        
        // Check if there are activities using this category
        if ($category->activities()->count() > 0) {
            return redirect()->route('admin.activity-categories.index')
                ->with('error', 'Kategori ini tidak dapat dihapus karena masih digunakan oleh beberapa kegiatan');
        }
        
        $category->delete();
        
        return redirect()->route('admin.activity-categories.index')
            ->with('success', 'Kategori kegiatan berhasil dihapus');
    }
}
