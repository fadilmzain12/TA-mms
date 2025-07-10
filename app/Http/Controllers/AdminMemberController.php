<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\Division;
use App\Models\Position;
use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AdminMemberController extends Controller
{
    /**
     * Display a listing of members.
     */
    public function index(Request $request)
    {
        $query = Member::query()->with(['division', 'position']);
        
        // Apply search if provided
        if ($request->has('search') && $request->search) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('full_name', 'like', "%{$searchTerm}%")
                  ->orWhere('registration_number', 'like', "%{$searchTerm}%")
                  ->orWhere('nik', 'like', "%{$searchTerm}%")
                  ->orWhere('phone', 'like', "%{$searchTerm}%");
            });
        }
        
        // Apply status filter if provided
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }
        
        // Get paginated results
        $members = $query->orderBy('created_at', 'desc')->paginate(10);
        
        return view('admin.members.index', compact('members'));
    }

    /**
     * Show the form for creating a new member.
     */
    public function create()
    {
        $divisions = Division::all();
        $positions = Position::all();
        
        return view('admin.members.create', compact('divisions', 'positions'));
    }

    /**
     * Store a newly created member in storage.
     */
    public function store(Request $request)
    {
        // Validate the request
        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'nik' => 'required|string|max:20|unique:members,nik',
            'gender' => 'required|in:male,female',
            'birth_place' => 'required|string|max:100',
            'birth_date' => 'required|date',
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
            'city' => 'required|string|max:100',
            'occupation' => 'required|string|max:100',
            'job_title' => 'nullable|string|max:100',
            'division_id' => 'nullable|exists:divisions,id',
            'position_id' => 'nullable|exists:positions,id',
            'status' => 'required|in:pending,active,inactive,rejected',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'ktp_document' => 'nullable|file|mimes:jpeg,png,jpg,pdf|max:2048',
        ]);
        
        // Generate registration number
        $registrationNumber = 'MMS-' . date('Ym') . '-' . strtoupper(Str::random(6));
        
        // Create the member
        $member = new Member();
        $member->fill($validated);
        $member->registration_number = $registrationNumber;
        $member->save();
        
        // Handle document uploads
        if ($request->hasFile('photo')) {
            $photoFile = $request->file('photo');
            $photoPath = $photoFile->store('members/photos', 'public');
            
            $photoDocument = new Document();
            $photoDocument->member_id = $member->id;
            $photoDocument->type = 'photo';
            $photoDocument->file_path = $photoPath;
            $photoDocument->file_name = pathinfo($photoPath, PATHINFO_BASENAME);
            $photoDocument->original_name = $photoFile->getClientOriginalName();
            $photoDocument->mime_type = $photoFile->getClientMimeType();
            $photoDocument->file_size = $photoFile->getSize();
            $photoDocument->verified = true; // Admin-uploaded documents are auto-verified
            $photoDocument->save();
        }
        
        if ($request->hasFile('ktp_document')) {
            $ktpFile = $request->file('ktp_document');
            $ktpPath = $ktpFile->store('members/documents', 'public');
            
            $ktpDocument = new Document();
            $ktpDocument->member_id = $member->id;
            $ktpDocument->type = 'ktp';
            $ktpDocument->file_path = $ktpPath;
            $ktpDocument->file_name = pathinfo($ktpPath, PATHINFO_BASENAME);
            $ktpDocument->original_name = $ktpFile->getClientOriginalName();
            $ktpDocument->mime_type = $ktpFile->getClientMimeType();
            $ktpDocument->file_size = $ktpFile->getSize();
            $ktpDocument->verified = true; // Admin-uploaded documents are auto-verified
            $ktpDocument->save();
        }
        
        return redirect()->route('admin.members.index')
            ->with('success', 'Member created successfully with registration number: ' . $registrationNumber);
    }

    /**
     * Display the specified member.
     */
    public function show(Member $member)
    {
        // Load relationships
        $member->load(['division', 'position', 'documents', 'user']);
        
        return view('admin.members.show', compact('member'));
    }

    /**
     * Show the form for editing the specified member.
     */
    public function edit(Member $member)
    {
        $divisions = Division::all();
        $positions = Position::all();
        
        // Load documents
        $member->load('documents');
        
        return view('admin.members.edit', compact('member', 'divisions', 'positions'));
    }

    /**
     * Update the specified member in storage.
     */
    public function update(Request $request, Member $member)
    {
        // Validate the request
        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'nik' => 'required|string|max:20|unique:members,nik,' . $member->id,
            'gender' => 'required|in:male,female',
            'birth_place' => 'required|string|max:100',
            'birth_date' => 'required|date',
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
            'city' => 'required|string|max:100',
            'occupation' => 'required|string|max:100',
            'job_title' => 'nullable|string|max:100',
            'division_id' => 'nullable|exists:divisions,id',
            'position_id' => 'nullable|exists:positions,id',
            'status' => 'required|in:pending,active,inactive,rejected',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'ktp_document' => 'nullable|file|mimes:jpeg,png,jpg,pdf|max:2048',
        ]);
        
        // Update the member
        $member->update($validated);
        
        // Handle document uploads
        if ($request->hasFile('photo')) {
            // Check if there's an existing photo
            $existingPhoto = $member->documents()->where('type', 'photo')->first();
            
            // Delete old photo if exists
            if ($existingPhoto) {
                Storage::disk('public')->delete($existingPhoto->file_path);
                $existingPhoto->delete();
            }
            
            // Store new photo
            $photoFile = $request->file('photo');
            $photoPath = $photoFile->store('members/photos', 'public');
            
            $photoDocument = new Document();
            $photoDocument->member_id = $member->id;
            $photoDocument->type = 'photo';
            $photoDocument->file_path = $photoPath;
            $photoDocument->file_name = pathinfo($photoPath, PATHINFO_BASENAME);
            $photoDocument->original_name = $photoFile->getClientOriginalName();
            $photoDocument->mime_type = $photoFile->getClientMimeType();
            $photoDocument->file_size = $photoFile->getSize();
            $photoDocument->verified = true; // Admin-uploaded documents are auto-verified
            $photoDocument->save();
        }
        
        if ($request->hasFile('ktp_document')) {
            // Check if there's an existing KTP document
            $existingKTP = $member->documents()->where('type', 'ktp')->first();
            
            // Delete old KTP document if exists
            if ($existingKTP) {
                Storage::disk('public')->delete($existingKTP->file_path);
                $existingKTP->delete();
            }
            
            // Store new KTP document
            $ktpFile = $request->file('ktp_document');
            $ktpPath = $ktpFile->store('members/documents', 'public');
            
            $ktpDocument = new Document();
            $ktpDocument->member_id = $member->id;
            $ktpDocument->type = 'ktp';
            $ktpDocument->file_path = $ktpPath;
            $ktpDocument->file_name = pathinfo($ktpPath, PATHINFO_BASENAME);
            $ktpDocument->original_name = $ktpFile->getClientOriginalName();
            $ktpDocument->mime_type = $ktpFile->getClientMimeType();
            $ktpDocument->file_size = $ktpFile->getSize();
            $ktpDocument->verified = true; // Admin-uploaded documents are auto-verified
            $ktpDocument->save();
        }
        
        return redirect()->route('admin.members.show', $member->id)
            ->with('success', 'Member updated successfully.');
    }

    /**
     * Remove the specified member from storage.
     */
    public function destroy(Member $member)
    {
        // Delete documents first
        foreach ($member->documents as $document) {
            Storage::disk('public')->delete($document->file_path);
            $document->delete();
        }
        
        // Delete the member
        $member->delete();
        
        return redirect()->route('admin.members.index')
            ->with('success', 'Member deleted successfully.');
    }
    
    /**
     * Export members data.
     */
    public function export()
    {
        // TODO: Implement export functionality
        return redirect()->route('admin.members.index')
            ->with('info', 'Export functionality will be implemented soon.');
    }
}