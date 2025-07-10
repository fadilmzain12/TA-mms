<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\Registration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MemberActivationController extends Controller
{
    /**
     * Display a listing of members pending activation
     */
    public function index()
    {
        $pendingActivations = Registration::where('status', 'verified')
            ->with(['member', 'verifier'])
            ->orderBy('verified_at', 'asc')
            ->paginate(10);
            
        return view('admin.activation.index', compact('pendingActivations'));
    }
    
    /**
     * Show the activation form for a specific member
     */
    public function show($id)
    {
        $registration = Registration::with(['member', 'member.documents', 'verifier'])
            ->findOrFail($id);
            
        return view('admin.activation.show', compact('registration'));
    }
    
    /**
     * Activate a member
     */
    public function activate(Request $request, $id)
    {
        $request->validate([
            'division_id' => 'required|exists:divisions,id',
            'position_id' => 'required|exists:positions,id',
        ]);
        
        $registration = Registration::findOrFail($id);
        $member = $registration->member;
        
        // Update division and position
        $member->update([
            'division_id' => $request->division_id,
            'position_id' => $request->position_id,
        ]);
        
        // Activate member using the new method
        $member->activate();
        
        // Mark registration as approved
        $registration->markAsApproved(Auth::id());
        
        return redirect()->route('admin.activations.index')
            ->with('success', 'Member activated successfully.');
    }
    
    /**
     * Directly activate a member from the member detail page
     */
    public function directActivate($id)
    {
        $member = Member::findOrFail($id);
        
        // Check if the member already has division and position
        if (!$member->division_id || !$member->position_id) {
            return redirect()->route('admin.members.show', $member->id)
                ->with('error', 'Cannot directly activate this member. Please assign division and position first.');
        }
        
        // Update member status using the new activate method
        $member->activate();
        
        // If there's a registration record, mark it as approved
        if ($member->registration) {
            $member->registration->markAsApproved(Auth::id());
        }
        
        return redirect()->route('admin.members.show', $member->id)
            ->with('success', 'Member activated successfully.');
    }
    
    /**
     * Display a listing of active members
     */
    public function active()
    {
        $activeMembers = Member::where('status', 'active')
            ->with(['division', 'position', 'user'])
            ->orderBy('updated_at', 'desc')
            ->paginate(10);
            
        return view('admin.activation.active', compact('activeMembers'));
    }
}
