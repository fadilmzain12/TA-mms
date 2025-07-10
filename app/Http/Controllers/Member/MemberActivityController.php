<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MemberActivityController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // Only authenticated users (members) can access these routes
        $this->middleware('auth');
    }

    /**
     * Display a listing of the activities for members.
     */
    public function index(Request $request)
    {
        // Get search query if it exists
        $search = $request->query('search');
        
        // Get category filter if it exists
        $categoryId = $request->query('category');
        
        // Query builder for activities
        $query = Activity::with(['user', 'category', 'comments' => function($query) {
            $query->latest()->take(3)->with('member');
        }]);
        
        // Apply search filter if search parameter exists
        if ($search) {
            $query->where('title', 'like', '%' . $search . '%');
        }
        
        // Apply category filter if category parameter exists
        if ($categoryId) {
            $query->where('category_id', $categoryId);
        }
        
        // Get activities with most recent first
        $activities = $query->latest()->paginate(10);
        
        // Get all categories for filter dropdown
        $categories = \App\Models\ActivityCategory::all();
        
        return view('member.activities.index', compact('activities', 'categories', 'search', 'categoryId'));
    }

    /**
     * Display the specified activity for members.
     */
    public function show(Activity $activity)
    {
        // Load relationships with explicit ordering
        $activity->load([
            'user',
            'category',
            'comments' => function($query) {
                // Regular members should not see hidden comments
                $query->where('is_hidden', false)
                      ->with([
                          'member.user', 
                          'replies' => function($replyQuery) {
                              $replyQuery->with(['member.user', 'likes'])
                                        ->orderBy('created_at', 'asc');
                          },
                          'likes'
                      ])
                      ->orderBy('created_at', 'desc');
            },
            'likes'
        ]);
        
        // Check if current user has liked this activity
        $hasLiked = false;
        if (Auth::user()->member) {
            $hasLiked = $activity->likes()->where('member_id', Auth::user()->member->id)->exists();
        }
        
        return view('member.activities.show', compact('activity', 'hasLiked'));
    }
}
