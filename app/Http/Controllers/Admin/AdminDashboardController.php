<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Division;
use App\Models\Member;
use App\Models\Position;
use App\Models\Registration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // Member statistics
        $totalMembers = Member::count();
        $activeMembers = Member::where('status', 'active')->count();
        $inactiveMembers = Member::where('status', 'inactive')->count();
        
        // Registration statistics
        $totalRegistrations = Registration::count();
        $pendingRegistrations = Registration::where('status', 'pending')->count();
        $approvedRegistrations = Registration::where('status', 'approved')->count();
        $rejectedRegistrations = Registration::where('status', 'rejected')->count();
        
        // Division statistics
        $divisions = Division::withCount('members')->get();
        
        // Position statistics
        $positions = Position::withCount('members')->get();
        
        // Member demographic
        $membersByGender = DB::table('members')
            ->select('gender', DB::raw('count(*) as total'))
            ->groupBy('gender')
            ->pluck('total', 'gender')
            ->toArray();
            
        // Member registration trend (last 6 months)
        $registrationTrend = Registration::select(
                DB::raw('MONTH(created_at) as month'), 
                DB::raw('YEAR(created_at) as year'),
                DB::raw('count(*) as total')
            )
            ->where('created_at', '>=', now()->subMonths(6))
            ->groupBy('year', 'month')
            ->orderBy('year')
            ->orderBy('month')
            ->get()
            ->map(function ($item) {
                return [
                    'month' => date('F', mktime(0, 0, 0, $item->month, 1)),
                    'total' => $item->total
                ];
            });
            
        // Recent registrations
        $recentRegistrations = Registration::with('member')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();
        
        return view('admin.dashboard', compact(
            'totalMembers',
            'activeMembers',
            'inactiveMembers',
            'totalRegistrations',
            'pendingRegistrations',
            'approvedRegistrations',
            'rejectedRegistrations',
            'divisions',
            'positions',
            'membersByGender',
            'registrationTrend',
            'recentRegistrations'
        ));
    }
}