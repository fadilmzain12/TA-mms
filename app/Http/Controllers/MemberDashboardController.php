<?php

namespace App\Http\Controllers;

use App\Models\Division;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class MemberDashboardController extends Controller
{
    public function index(Request $request)
    {
        // Get filter period and grouping (default: 6 months, monthly grouping)
        $period = $request->get('period', '6months');
        $groupBy = $request->get('groupBy', 'monthly');
        $currentYear = date('Y');
        
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
        $registrationsQuery = Member::query();
        
        // Apply start date if not 'all'
        if ($startDate) {
            $registrationsQuery->where('created_at', '>=', $startDate);
        }
        
        // Apply grouping (daily, monthly, yearly)
        switch($groupBy) {
            case 'daily':
                $registrationsQuery->selectRaw('DATE(created_at) as date, COUNT(*) as count')
                ->groupBy('date')
                ->orderBy('date', 'asc');
                $groupByLabel = 'Daily';
                break;
                
            case 'yearly':
                $registrationsQuery->selectRaw('YEAR(created_at) as year, COUNT(*) as count')
                ->groupBy('year')
                ->orderBy('year', 'asc');
                $groupByLabel = 'Yearly';
                break;
                
            case 'monthly':
            default:
                $registrationsQuery->selectRaw('MONTH(created_at) as month, YEAR(created_at) as year, COUNT(*) as count')
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
        $monthCounts = [];
        
        if ($groupBy === 'daily') {
            foreach ($registrationsData as $data) {
                $date = Carbon::parse($data->date);
                $labels[] = $date->format('M d');
                $monthCounts[] = $data->count;
            }
            $chartTitle = 'Daily Registrations';
        } elseif ($groupBy === 'yearly') {
            foreach ($registrationsData as $data) {
                $labels[] = $data->year;
                $monthCounts[] = $data->count;
            }
            $chartTitle = 'Yearly Registrations';
        } else {
            foreach ($registrationsData as $data) {
                $monthName = date('M', mktime(0, 0, 0, $data->month, 10));
                $labels[] = $monthName . ' ' . $data->year;
                $monthCounts[] = $data->count;
            }
            $chartTitle = 'Monthly Registrations';
        }

        // Get Division statistics
        $divisions = Division::withCount('members')
            ->orderByDesc('members_count')
            ->get();

        // Get City statistics
        $cities = Member::select('city', DB::raw('count(*) as total'))
            ->whereNotNull('city')
            ->groupBy('city')
            ->orderByDesc('total')
            ->limit(10)
            ->get();

        // Get current member info
        $member = Auth::user()->member;
        
        return view('member.dashboard', compact(
            'labels', 
            'monthCounts', 
            'divisions', 
            'cities', 
            'member', 
            'period', 
            'periodLabel',
            'groupBy',
            'groupByLabel',
            'chartTitle'
        ));
    }
}