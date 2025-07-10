<?php

namespace App\Http\Controllers;

use App\Models\Position;
use Illuminate\Http\Request;

class AdminPositionController extends Controller
{
    /**
     * Display a listing of the positions.
     */
    public function index()
    {
        $positions = Position::withCount('members')->orderBy('name')->paginate(10);
        
        return view('admin.positions.index', compact('positions'));
    }

    /**
     * Show the form for creating a new position.
     */
    public function create()
    {
        return view('admin.positions.create');
    }

    /**
     * Store a newly created position in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100|unique:positions,name',
            'description' => 'nullable|string',
        ]);
        
        Position::create($request->all());
        
        return redirect()->route('admin.positions.index')
            ->with('success', 'Position created successfully.');
    }

    /**
     * Show the form for editing the specified position.
     */
    public function edit(Position $position)
    {
        return view('admin.positions.edit', compact('position'));
    }

    /**
     * Update the specified position in storage.
     */
    public function update(Request $request, Position $position)
    {
        $request->validate([
            'name' => 'required|string|max:100|unique:positions,name,' . $position->id,
            'description' => 'nullable|string',
        ]);
        
        $position->update($request->all());
        
        return redirect()->route('admin.positions.index')
            ->with('success', 'Position updated successfully.');
    }

    /**
     * Remove the specified position from storage.
     */
    public function destroy(Position $position)
    {
        // Check if position has members
        if ($position->members()->count() > 0) {
            return redirect()->route('admin.positions.index')
                ->with('error', 'Cannot delete position because it still has members assigned to it.');
        }
        
        $position->delete();
        
        return redirect()->route('admin.positions.index')
            ->with('success', 'Position deleted successfully.');
    }
}