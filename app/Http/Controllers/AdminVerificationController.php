<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\Registration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminVerificationController extends Controller
{
    /**
     * Display a listing of pending registrations
     */
    public function index(Request $request)
    {
        $query = Registration::where('status', 'submitted')
            ->with(['member', 'member.user']);
            
        // Apply search filters if provided
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('registration_number', 'like', "%{$search}%")
                  ->orWhereHas('member', function ($mq) use ($search) {
                      $mq->where('full_name', 'like', "%{$search}%")
                         ->orWhere('nik', 'like', "%{$search}%")
                         ->orWhereHas('user', function ($uq) use ($search) {
                             $uq->where('email', 'like', "%{$search}%");
                         });
                  });
            });
        }
        
        // Apply date filters if provided
        if ($request->has('date_from') && !empty($request->date_from)) {
            $query->whereDate('submitted_at', '>=', $request->date_from);
        }
        
        if ($request->has('date_to') && !empty($request->date_to)) {
            $query->whereDate('submitted_at', '<=', $request->date_to);
        }
        
        $registrations = $query->orderBy('submitted_at', 'asc')->paginate(10);
            
        return view('admin.verifications.index', compact('registrations'));
    }
    
    /**
     * Show the verification form for a specific registration
     */
    public function show($id)
    {
        $registration = Registration::with(['member', 'member.documents', 'member.user'])
            ->findOrFail($id);
            
        return view('admin.verifications.show', compact('registration'));
    }
    
    /**
     * Verify a registration
     */
    public function verify(Request $request, $id)
    {
        $request->validate([
            'verification_notes' => 'nullable|string',
        ]);
        
        $registration = Registration::findOrFail($id);
        
        // Verify all documents
        foreach ($registration->member->documents as $document) {
            $document->update([
                'verified' => true,
            ]);
        }
        
        // Mark registration as verified
        $registration->markAsVerified(
            Auth::id(),
            $request->verification_notes
        );
        
        // Update member status to active
        $registration->member->update(['status' => 'active']);
        
        return redirect()->route('admin.verifications.index')
            ->with('success', 'Pendaftaran berhasil diverifikasi.');
    }
    
    /**
     * Reject a registration
     */
    public function reject(Request $request, $id)
    {
        $request->validate([
            'rejection_reason' => 'required|string',
        ]);
        
        $registration = Registration::findOrFail($id);
        
        // Reject the registration
        $registration->reject($request->rejection_reason);
        
        // Update member status
        $registration->member->update(['status' => 'rejected']);
        
        return redirect()->route('admin.verifications.index')
            ->with('success', 'Pendaftaran berhasil ditolak.');
    }
    
    /**
     * Display a listing of verified registrations
     */
    public function verified(Request $request)
    {
        $query = Registration::where('status', 'verified')
            ->with(['member', 'member.user', 'verifier']);
            
        // Apply search filters if provided
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('registration_number', 'like', "%{$search}%")
                  ->orWhereHas('member', function ($mq) use ($search) {
                      $mq->where('full_name', 'like', "%{$search}%")
                         ->orWhere('nik', 'like', "%{$search}%")
                         ->orWhereHas('user', function ($uq) use ($search) {
                             $uq->where('email', 'like', "%{$search}%");
                         });
                  });
            });
        }
        
        $verifiedRegistrations = $query->latest()->paginate(10);
        
        return view('admin.verifications.verified', compact('verifiedRegistrations'));
    }
    
    /**
     * Display a listing of rejected registrations
     */
    public function rejected(Request $request)
    {
        $query = Registration::where('status', 'rejected')
            ->with(['member', 'member.user']);
            
        // Apply search filters if provided
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('registration_number', 'like', "%{$search}%")
                  ->orWhereHas('member', function ($mq) use ($search) {
                      $mq->where('full_name', 'like', "%{$search}%")
                         ->orWhere('nik', 'like', "%{$search}%")
                         ->orWhereHas('user', function ($uq) use ($search) {
                             $uq->where('email', 'like', "%{$search}%");
                         });
                  });
            });
        }
        
        // Apply date filters if provided
        if ($request->has('date_from') && !empty($request->date_from)) {
            $query->whereDate('updated_at', '>=', $request->date_from);
        }
        
        if ($request->has('date_to') && !empty($request->date_to)) {
            $query->whereDate('updated_at', '<=', $request->date_to);
        }
        
        $rejectedRegistrations = $query->latest()->paginate(10);
        
        return view('admin.verifications.rejected', compact('rejectedRegistrations'));
    }
}
