<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\Division;
use App\Models\Position;
use App\Models\Registration;
use App\Models\User;
use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AdminDashboardController extends Controller
{
    /**
     * Display admin dashboard with statistics and overview data.
     */
    public function index(Request $request)
    {
        // Get filter period and grouping (default: 6 months, monthly grouping)
        $period = $request->get('period', '6months');
        $groupBy = $request->get('groupBy', 'monthly');
        $currentYear = date('Y');
        
        // Get member statistics
        $totalMembers = Member::count();
        $activeMembers = Member::where('status', 'active')->count();
        $pendingMembersCount = Member::where('status', 'pending')->count();
        $inactiveMembers = Member::where('status', 'inactive')->count();
        
        // Apply period filter
        switch($period) {
            case '7days':
                $startDate = now()->subDays(7)->startOfDay();
                $periodLabel = 'Last 7 Days';
                break;
            case '30days':
                $startDate = now()->subDays(30)->startOfDay();
                $periodLabel = 'Last 30 Days';
                break;
            case '3months':
                $startDate = now()->subMonths(3)->startOfDay();
                $periodLabel = 'Last 3 Months';
                break;
            case '6months':
                $startDate = now()->subMonths(6)->startOfDay();
                $periodLabel = 'Last 6 Months';
                break;
            case '1year':
                $startDate = now()->subYear()->startOfDay();
                $periodLabel = 'Last Year';
                break;
            case 'current_year':
                $startDate = Carbon::createFromDate($currentYear, 1, 1)->startOfDay();
                $periodLabel = 'Current Year (' . $currentYear . ')';
                break;
            case 'all':
                $startDate = null;
                $periodLabel = 'All Time';
                break;
            default:
                $startDate = now()->subMonths(6)->startOfDay();
                $period = '6months';
                $periodLabel = 'Last 6 Months';
                break;
        }
        
        // Initialize query for registrations
        $registrationsQuery = DB::table('members');
        
        // Apply start date if not 'all'
        if ($startDate) {
            $registrationsQuery->where('created_at', '>=', $startDate);
        }
        
        // Apply grouping (daily, monthly, yearly)
        switch($groupBy) {
            case 'daily':
                $registrationsQuery->select(
                    DB::raw('DATE(created_at) as date'),
                    DB::raw('COUNT(*) as count')
                )
                ->groupBy('date')
                ->orderBy('date', 'asc');
                $groupByLabel = 'Daily';
                break;
                
            case 'yearly':
                $registrationsQuery->select(
                    DB::raw('YEAR(created_at) as year'),
                    DB::raw('COUNT(*) as count')
                )
                ->groupBy('year')
                ->orderBy('year', 'asc');
                $groupByLabel = 'Yearly';
                break;
                
            case 'monthly':
            default:
                $registrationsQuery->select(
                    DB::raw('MONTH(created_at) as month'),
                    DB::raw('YEAR(created_at) as year'),
                    DB::raw('COUNT(*) as count')
                )
                ->groupBy('year', 'month')
                ->orderBy('year', 'asc')
                ->orderBy('month', 'asc');
                $groupBy = 'monthly';
                $groupByLabel = 'Monthly';
                break;
        }
        
        $registrationsData = $registrationsQuery->get();
        
        // Format data for chart based on grouping
        $labels = [];
        $registrationCounts = [];
        
        if ($groupBy === 'daily') {
            foreach ($registrationsData as $data) {
                $date = Carbon::parse($data->date);
                $labels[] = $date->format('M d');
                $registrationCounts[] = $data->count;
            }
            $chartTitle = 'Daily Registrations';
        } elseif ($groupBy === 'yearly') {
            foreach ($registrationsData as $data) {
                $labels[] = $data->year;
                $registrationCounts[] = $data->count;
            }
            $chartTitle = 'Yearly Registrations';
        } else {
            foreach ($registrationsData as $data) {
                $monthName = date('M', mktime(0, 0, 0, $data->month, 10));
                $labels[] = $monthName . ' ' . $data->year;
                $registrationCounts[] = $data->count;
            }
            $chartTitle = 'Monthly Registrations';
        }
        
        // Get division statistics
        $divisions = Division::withCount('members')->get();
          // Get city statistics
        $cities = DB::table('members')
            ->select('city', DB::raw('count(*) as total'))
            ->whereNotNull('city')
            ->groupBy('city')
            ->orderBy('total', 'desc')
            ->get();
            
        // Get activity category statistics
        $activityCategories = \App\Models\ActivityCategory::withCount('activities')
            ->orderBy('activities_count', 'desc')
            ->get();
        
        // Get recent registrations
        $recentMembers = Member::with(['division', 'position', 'user'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
            
        // Get pending members for approval
        $pendingMembers = Member::where('status', 'pending')
            ->with(['division', 'position', 'user'])
            ->orderBy('created_at', 'asc')
            ->limit(5)
            ->get();
          return view('admin.dashboard', compact(
            'totalMembers', 
            'activeMembers', 
            'pendingMembersCount', 
            'inactiveMembers',
            'labels',
            'registrationCounts',
            'divisions',
            'cities',
            'activityCategories',
            'recentMembers',
            'pendingMembers',
            'period',
            'periodLabel',
            'groupBy',
            'groupByLabel',
            'chartTitle'
        ));
    }
}