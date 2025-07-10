<?php

namespace App\Http\Controllers;

use App\Models\Division;
use Illuminate\Http\Request;

class AdminDivisionController extends Controller
{
    /**
     * Display a listing of the divisions.
     */
    public function index()
    {
        $divisions = Division::withCount('members')->orderBy('name')->paginate(10);
        
        return view('admin.divisions.index', compact('divisions'));
    }

    /**
     * Store a newly created division in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100|unique:divisions,name',
            'code' => 'required|string|max:20|unique:divisions,code',
            'description' => 'nullable|string',
            'is_active' => 'sometimes|boolean',
        ]);
        
        $data = $request->all();
        // Set is_active to false if not present in the request
        $data['is_active'] = $request->has('is_active') ? true : false;
        
        Division::create($data);
        
        return redirect()->route('admin.divisions.index')
            ->with('success', 'Divisi berhasil dibuat.');
    }

    /**
     * Update the specified division in storage.
     */
    public function update(Request $request, Division $division)
    {
        $request->validate([
            'name' => 'required|string|max:100|unique:divisions,name,' . $division->id,
            'code' => 'required|string|max:20|unique:divisions,code,' . $division->id,
            'description' => 'nullable|string',
            'is_active' => 'sometimes|boolean',
        ]);
        
        $data = $request->all();
        // Set is_active to false if not present in the request
        $data['is_active'] = $request->has('is_active') ? true : false;
        
        $division->update($data);
        
        return redirect()->route('admin.divisions.index')
            ->with('success', 'Divisi berhasil diperbarui.');
    }

    /**
     * Remove the specified division from storage.
     */
    public function destroy(Division $division)
    {
        // Check if division has members
        if ($division->members()->count() > 0) {
            // We'll allow deletion but warn the user in the view
            $division->delete();
            return redirect()->route('admin.divisions.index')
                ->with('success', 'Divisi berhasil dihapus. Anggota yang terkait dengan divisi ini telah diupdate.');
        }
        
        $division->delete();
        
        return redirect()->route('admin.divisions.index')
            ->with('success', 'Divisi berhasil dihapus.');
    }
}