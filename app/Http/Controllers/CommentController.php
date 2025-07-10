<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
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
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created comment in storage.
     */
    public function store(Request $request, Activity $activity)
    {
        // Validate request
        $request->validate([
            'content' => 'required|string',
        ]);
        
        $user = Auth::user();
        $member = $user->member;
        
        // Special handling for admin users without member profile
        if (!$member && $user->is_admin) {
            // Find the system member or create it
            $systemMember = \App\Models\Member::where('id', 1)->first();
            if (!$systemMember) {
                // Either find member with ID 1 or use any existing member as admin representative
                $systemMember = \App\Models\Member::first();
                
                // If no members exist, return error
                if (!$systemMember) {
                    if ($request->ajax()) {
                        return response()->json([
                            'error' => 'No member profile found for admin comment'
                        ], 422);
                    }
                    return redirect()->back()->with('error', 'No member profile found for admin comment');
                }
            }
            
            // Create a comment with system details
            $comment = $activity->comments()->create([
                'member_id' => $systemMember->id,
                'content' => $request->content,
            ]);
            
            // Update comments count on the activity
            $activity->comments_count = $activity->comments()->count();
            $activity->save();
            
            if ($request->ajax()) {
                // Load the member relation for the newly created comment
                $comment->load('member');
                
                return response()->json([
                    'comment' => $comment,
                    'comments_count' => $activity->comments_count
                ]);
            }
            
            return redirect()->back()->with('success', 'Komentar telah ditambahkan');
        }
        
        // Regular user flow - require a member profile
        if (!$member) {
            if ($request->ajax()) {
                return response()->json([
                    'error' => 'You need to complete your member profile first'
                ], 422);
            }
            return redirect()->route('registration.step1')
                ->with('error', 'Please complete your registration to access all features.');
        }
        
        // Create the comment
        $comment = $activity->comments()->create([
            'member_id' => $member->id,
            'content' => $request->content,
        ]);
        
        // Increment comments count on the activity
        $activity->comments_count = $activity->comments_count + 1;
        $activity->save();
        
        return redirect()->back()->with('success', 'Komentar berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified comment in storage.
     */
    public function update(Request $request, Comment $comment)
    {
        // Validate request
        $request->validate([
            'content' => 'required|string',
        ]);
        
        $user = Auth::user();
        
        // Allow admin users to edit any comment
        if (!$user->is_admin) {
            // For regular users, check if they own the comment
            if (!$user->member || $comment->member_id != $user->member->id) {
                return redirect()->back()->with('error', 'Anda tidak berhak mengedit komentar ini');
            }
        }
        
        // Update the comment
        $comment->content = $request->content;
        $comment->save();
        
        return redirect()->back()->with('success', 'Komentar berhasil diperbarui');
    }

    /**
     * Remove the specified comment from storage.
     */
    public function destroy(Comment $comment)
    {
        $activity = $comment->activity;
        
        $user = Auth::user();
        
        // Check if the user is the owner of this comment or an admin
        // Skip member check for admin users entirely
        if (!$user->is_admin) {
            // For regular users, check if they own the comment
            if (!$user->member || $comment->member_id != $user->member->id) {
                return redirect()->back()->with('error', 'Anda tidak berhak menghapus komentar ini');
            }
        }
        
        // Delete the comment
        $comment->delete();
        
        // Decrement comments count on the activity
        $activity->comments_count = max(0, $activity->comments_count - 1);
        $activity->save();
        
        return redirect()->back()->with('success', 'Komentar berhasil dihapus');
    }

    /**
     * Toggle like on a comment.
     */
    public function like(Request $request, Comment $comment)
    {
        $user = Auth::user();
        
        // Special handling for admin users
        if ($user->is_admin) {
            // For admins without a member profile, use system member ID
            $adminMember = $user->member;
            if (!$adminMember) {
                // Check if system member already liked this comment
                $alreadyLiked = $comment->likes()->where('member_id', 1)->exists();
                
                if ($alreadyLiked) {
                    // Unlike the comment
                    $comment->likes()->where('member_id', 1)->delete();
                    $comment->likes_count = max(0, $comment->likes_count - 1);
                    $comment->save();
                    $message = 'Komentar telah batal disukai';
                } else {
                    // Like the comment
                    $comment->likes()->create([
                        'member_id' => 1 // Use system/admin member ID
                    ]);
                    $comment->likes_count = $comment->likes_count + 1;
                    $comment->save();
                    $message = 'Komentar telah disukai';
                }
                
                if ($request->ajax()) {
                    return response()->json([
                        'likes_count' => $comment->likes_count,
                        'liked' => !$alreadyLiked
                    ]);
                }
                
                return redirect()->back()->with('success', $message);
            }
        }
        
        // For regular members, check if user has a member profile
        $member = $user->member;
        if (!$member) {
            return redirect()->back()->with('error', 'Anda harus memiliki profil member untuk dapat menyukai komentar.');
        }
        
        // Check if member has already liked this comment
        $alreadyLiked = $comment->likes()->where('member_id', $member->id)->exists();
        
        if ($alreadyLiked) {
            // Unlike the comment
            $comment->likes()->where('member_id', $member->id)->delete();
            $comment->likes_count = max(0, $comment->likes_count - 1);
            $comment->save();
            $message = 'Komentar telah batal disukai';
        } else {
            // Like the comment
            $comment->likes()->create([
                'member_id' => $member->id
            ]);
            $comment->likes_count = $comment->likes_count + 1;
            $comment->save();
            $message = 'Komentar telah disukai';
        }
        
        if ($request->ajax()) {
            return response()->json([
                'likes_count' => $comment->likes_count,
                'liked' => !$alreadyLiked
            ]);
        }
        
        return redirect()->back()->with('success', $message);
    }
    
    /**
     * Toggle the visibility of a comment (hide/unhide)
     * Only admins can perform this action
     */
    public function toggleVisibility(Comment $comment)
    {
        // Check if user is admin
        if (!auth()->user()->is_admin) {
            return redirect()->back()->with('error', 'Anda tidak memiliki izin untuk melakukan tindakan ini.');
        }

        // Toggle visibility
        $comment->is_hidden = !$comment->is_hidden;
        $comment->save();

        $status = $comment->is_hidden ? 'disembunyikan' : 'ditampilkan';
        return redirect()->back()->with('success', "Komentar telah $status.");
    }
}
