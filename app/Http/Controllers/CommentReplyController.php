<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\CommentReply;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentReplyController extends Controller
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
     * Store a newly created reply in storage.
     */
    public function store(Request $request, Comment $comment)
    {
        // Validate request
        $request->validate([
            'content' => 'required|string',
        ]);
        
        $user = Auth::user();
        
        // Special handling for admin users
        if ($user->is_admin) {
            // For admins without a member profile, create a system reply
            $adminMember = $user->member;
            if (!$adminMember) {
                // Create a reply with system details
                $reply = $comment->replies()->create([
                    'member_id' => 1, // Use system/admin member ID
                    'content' => $request->content,
                ]);
                
                // Increment replies count on the comment
                $comment->replies_count = $comment->replies_count + 1;
                $comment->save();
                
                return redirect()->back()->with('success', 'Balasan admin berhasil ditambahkan');
            }
        }
        
        // For regular members, check if user has a member profile
        $member = Auth::user()->member;
        if (!$member) {
            return redirect()->back()->with('error', 'Anda harus memiliki profil member untuk dapat membalas komentar.');
        }
        
        // Create the reply
        $reply = $comment->replies()->create([
            'member_id' => $member->id,
            'content' => $request->content,
        ]);
        
        // Increment replies count on the comment
        $comment->replies_count = $comment->replies_count + 1;
        $comment->save();
        
        return redirect()->back()->with('success', 'Balasan berhasil ditambahkan');
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
     * Update the specified reply in storage.
     */
    public function update(Request $request, CommentReply $reply)
    {
        // Validate request
        $request->validate([
            'content' => 'required|string',
        ]);
        
        $user = Auth::user();
        
        // Allow admin users to edit any reply
        if (!$user->is_admin) {
            // For regular users, check if they own the reply
            if (!$user->member || $reply->member_id != $user->member->id) {
                return redirect()->back()->with('error', 'Anda tidak berhak mengedit balasan ini');
            }
        }
        
        // Update the reply
        $reply->content = $request->content;
        $reply->save();
        
        return redirect()->back()->with('success', 'Balasan berhasil diperbarui');
    }

    /**
     * Remove the specified reply from storage.
     */
    public function destroy(CommentReply $reply)
    {
        $comment = $reply->comment;
        
        $user = Auth::user();
        
        // Check if the user is the owner of this reply or an admin
        // Skip member check for admin users entirely
        if (!$user->is_admin) {
            // For regular users, check if they own the reply
            if (!$user->member || $reply->member_id != $user->member->id) {
                return redirect()->back()->with('error', 'Anda tidak berhak menghapus balasan ini');
            }
        }
        
        // Delete the reply
        $reply->delete();
        
        // Decrement replies count on the comment
        $comment->replies_count = max(0, $comment->replies_count - 1);
        $comment->save();
        
        return redirect()->back()->with('success', 'Balasan berhasil dihapus');
    }

    /**
     * Toggle like on a reply.
     */
    public function like(Request $request, CommentReply $reply)
    {
        $user = Auth::user();
        
        // Special handling for admin users
        if ($user->is_admin) {
            // For admins without a member profile, use system member ID
            $adminMember = $user->member;
            if (!$adminMember) {
                // Check if system member already liked this reply
                $alreadyLiked = $reply->likes()->where('member_id', 1)->exists();
                
                if ($alreadyLiked) {
                    // Unlike the reply
                    $reply->likes()->where('member_id', 1)->delete();
                    $reply->likes_count = max(0, $reply->likes_count - 1);
                    $reply->save();
                    $message = 'Balasan telah batal disukai';
                } else {
                    // Like the reply
                    $reply->likes()->create([
                        'member_id' => 1 // Use system/admin member ID
                    ]);
                    $reply->likes_count = $reply->likes_count + 1;
                    $reply->save();
                    $message = 'Balasan telah disukai';
                }
                
                if ($request->ajax()) {
                    return response()->json([
                        'likes_count' => $reply->likes_count,
                        'liked' => !$alreadyLiked
                    ]);
                }
                
                return redirect()->back()->with('success', $message);
            }
        }
        
        // For regular members, check if user has a member profile
        $member = Auth::user()->member;
        if (!$member) {
            return redirect()->back()->with('error', 'Anda harus memiliki profil member untuk dapat menyukai balasan.');
        }
        
        // Check if member has already liked this reply
        $alreadyLiked = $reply->likes()->where('member_id', $member->id)->exists();
        
        if ($alreadyLiked) {
            // Unlike the reply
            $reply->likes()->where('member_id', $member->id)->delete();
            $reply->likes_count = max(0, $reply->likes_count - 1);
            $reply->save();
            $message = 'Balasan telah batal disukai';
        } else {
            // Like the reply
            $reply->likes()->create([
                'member_id' => $member->id
            ]);
            $reply->likes_count = $reply->likes_count + 1;
            $reply->save();
            $message = 'Balasan telah disukai';
        }
        
        if ($request->ajax()) {
            return response()->json([
                'likes_count' => $reply->likes_count,
                'liked' => !$alreadyLiked
            ]);
        }
        
        return redirect()->back()->with('success', $message);
    }
}
