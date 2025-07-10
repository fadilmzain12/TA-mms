<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MemberController extends Controller
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
     * Show the member dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function dashboard()
    {
        $user = Auth::user();
        $member = Member::where('user_id', $user->id)->first();
        $documents = Document::where('is_public', true)->get();
        
        return view('member.dashboard', compact('user', 'member', 'documents'));
    }

    /**
     * Show the member profile.
     *
     * @return \Illuminate\View\View
     */
    public function profile()
    {
        $user = Auth::user();
        $member = Member::where('user_id', $user->id)->with(['division', 'position'])->first();
        
        return view('member.profile', compact('user', 'member'));
    }

    /**
     * Show the member documents.
     *
     * @return \Illuminate\View\View
     */
    public function documents()
    {
        $user = Auth::user();
        $member = Member::where('user_id', $user->id)->first();
        $documents = Document::all();
        
        return view('member.documents', compact('user', 'member', 'documents'));
    }

    /**
     * Show a specific document.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function showDocument($id)
    {
        $document = Document::findOrFail($id);
        
        // Check if document is public or user has special access
        if (!$document->is_public) {
            // Logic for restricted documents can be added here
            return redirect()->route('member.documents')
                ->with('error', 'You do not have access to this document.');
        }
        
        return view('member.document-view', compact('document'));
    }
}
