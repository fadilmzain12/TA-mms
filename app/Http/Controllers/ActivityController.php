<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ActivityController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // Only admins can create, update and delete activities
        $this->middleware('admin')->except(['index', 'show']);
    }

    /**
     * Display a listing of the activities.
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
        
        // Keep the search and category parameters for pagination links
        $activities->appends([
            'search' => $search,
            'category' => $categoryId
        ]);
        
        // Get all categories for filter dropdown
        $categories = \App\Models\ActivityCategory::all();
        
        return view('admin.activities.index', compact('activities', 'search', 'categories', 'categoryId'));
    }

    /**
     * Show the form for creating a new activity.
     */
    public function create()
    {
        $categories = \App\Models\ActivityCategory::orderBy('name')->get();
        return view('activities.create', compact('categories'));
    }

    /**
     * Store a newly created activity in storage.
     */
    public function store(Request $request)
    {
        // Validate request
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category_id' => 'nullable|exists:activity_categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        
        // Handle image upload if provided
        $imagePath = null;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $imagePath = $image->storeAs('activities', $imageName, 'public');
        }
        
        // Create new activity
        Activity::create([
            'user_id' => Auth::id(),
            'category_id' => $request->category_id,
            'title' => $request->title,
            'description' => $request->description,
            'image_path' => $imagePath,
        ]);
        
        return redirect()->route('activities.index')
            ->with('success', 'Kegiatan berhasil dipublikasikan');
    }

    /**
     * Display the specified activity.
     */
    public function show(Activity $activity)
    {
        // Get the authenticated user
        $user = Auth::user();
        
        // Load activity with user, comments with their member authors and replies
        $activity->load([
            'user', 
            'comments' => function($query) use ($user) {
                // Regular users should not see hidden comments
                // Admin can see all comments
                if (!$user->is_admin) {
                    $query->where('is_hidden', false);
                }
                
                $query->orderBy('created_at', 'desc')
                      ->with(['member', 'replies' => function($q) {
                          $q->with('member');
                      }]);
            }
        ]);
        
        $user = Auth::user();
        $hasLiked = false;
        
        // Special handling for admin users
        if ($user->is_admin) {
            $adminMember = $user->member;
            if (!$adminMember) {
                // Check if admin liked this activity using system member ID
                $hasLiked = $activity->likes()->where('member_id', 1)->exists();
            } else {
                // Admin has a member profile, check normally
                $hasLiked = $activity->likes()->where('member_id', $adminMember->id)->exists();
            }
        } 
        // Regular member check
        elseif ($member = $user->member) {
            $hasLiked = $activity->likes()->where('member_id', $member->id)->exists();
        }
        
        return view('admin.activities.show', compact('activity', 'hasLiked'));
    }

    /**
     * Show the form for editing the specified activity.
     */
    public function edit(Activity $activity)
    {
        $categories = \App\Models\ActivityCategory::orderBy('name')->get();
        return view('activities.edit', compact('activity', 'categories'));
    }

    /**
     * Update the specified activity in storage.
     */
    public function update(Request $request, Activity $activity)
    {
        // Validate request
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category_id' => 'nullable|exists:activity_categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        
        // Handle image upload if provided
        if ($request->hasFile('image')) {
            // Delete old image if it exists
            if ($activity->image_path) {
                Storage::disk('public')->delete($activity->image_path);
            }
            
            // Store new image
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $imagePath = $image->storeAs('activities', $imageName, 'public');
            
            $activity->image_path = $imagePath;
        }
        
        // Update activity
        $activity->title = $request->title;
        $activity->description = $request->description;
        $activity->category_id = $request->category_id;
        $activity->save();
        
        return redirect()->route('activities.index')
            ->with('success', 'Kegiatan berhasil diperbarui');
    }

    /**
     * Remove the specified activity from storage.
     */
    public function destroy(Activity $activity)
    {
        // Delete image if it exists
        if ($activity->image_path) {
            Storage::disk('public')->delete($activity->image_path);
        }
        
        $activity->delete();
        
        return redirect()->route('activities.index')
            ->with('success', 'Kegiatan berhasil dihapus');
    }
}
