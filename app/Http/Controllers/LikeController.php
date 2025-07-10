<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
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
     * Toggle like on an activity.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Activity  $activity
     * @return \Illuminate\Http\Response
     */
    public function toggleLike(Request $request, Activity $activity)
    {
        $user = Auth::user();
        
        // Get member associated with user
        $member = $user->member;
        
        // If no member found and user is admin, use or create system member
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
                            'error' => 'No member profile found for admin action'
                        ], 422);
                    }
                    return redirect()->back()->with('error', 'No member profile found for admin action');
                }
            }
            
            $memberId = $systemMember->id;
            
            // Check if system member already liked this activity
            $alreadyLiked = $activity->likes()->where('member_id', $memberId)->exists();
            
            if ($alreadyLiked) {
                // Unlike the activity
                $activity->likes()->where('member_id', $memberId)->delete();
                $activity->likes_count = max(0, $activity->likes_count - 1);
                $activity->save();
                $message = 'Kegiatan telah batal disukai';
            } else {
                // Like the activity
                $activity->likes()->create([
                    'member_id' => $memberId
                ]);
                $activity->likes_count = $activity->likes_count + 1;
                $activity->save();
                $message = 'Kegiatan telah disukai';
            }
            
            if ($request->ajax()) {
                return response()->json([
                    'likes_count' => $activity->likes_count,
                    'liked' => !$alreadyLiked
                ]);
            }
            
            return redirect()->back()->with('success', $message);
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
        
        // Check if member has already liked this activity
        $alreadyLiked = $activity->likes()->where('member_id', $member->id)->exists();
        
        if ($alreadyLiked) {
            // Unlike the activity
            $activity->likes()->where('member_id', $member->id)->delete();
            $activity->likes_count = max(0, $activity->likes_count - 1);
            $activity->save();
            $message = 'Kegiatan telah batal disukai';
        } else {
            // Like the activity
            $activity->likes()->create([
                'member_id' => $member->id
            ]);
            $activity->likes_count = $activity->likes_count + 1;
            $activity->save();
            $message = 'Kegiatan telah disukai';
        }
        
        if ($request->ajax()) {
            return response()->json([
                'likes_count' => $activity->likes_count,
                'liked' => !$alreadyLiked
            ]);
        }
        
        return redirect()->back()->with('success', $message);
    }
}
