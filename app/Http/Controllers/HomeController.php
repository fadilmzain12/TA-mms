<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = Auth::user();
        
        // If user is admin, show admin dashboard
        if ($user->is_admin) {
            return redirect()->route('admin.dashboard');
        }
        
        // Check if user has a member profile
        $member = $user->member;
        
        // If no member profile, redirect to registration
        if (!$member) {
            return redirect()->route('registration.step1')
                ->with('status', 'Please complete your registration to access all features.');
        }
        
        // Check member status and set appropriate notifications
        switch ($member->status) {
            case Member::STATUS_PENDING:
                session()->flash('approval_status', 'Your account is pending approval. You will be notified once your account is approved.');
                break;
                
            case Member::STATUS_ACTIVE:
                session()->flash('approval_status', 'Your account has been approved. You can now generate your membership card.');
                break;
                
            case Member::STATUS_INACTIVE:
                session()->flash('approval_status', 'Your account is currently inactive. Please contact administration for assistance.');
                break;
        }
        
        // Redirect to member dashboard page
        return redirect()->route('member.dashboard');
    }
}
