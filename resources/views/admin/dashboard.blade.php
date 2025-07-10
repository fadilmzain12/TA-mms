@extends('admin.layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Dashboard</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-2">
            <a href="{{ route('admin.members.index') }}" class="btn btn-sm btn-outline-primary">
                <i class="bi bi-people"></i> View All Members
            </a>
        </div>
    </div>
</div>

<!-- Statistics Cards -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card card-admin shadow-sm">
            <div class="card-body p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted mb-1">Total Members</h6>
                        <h3 class="mb-0">{{ $totalMembers }}</h3>
                    </div>
                    <div class="bg-primary bg-opacity-10 p-3 rounded-circle">
                        <i class="bi bi-people fs-4 text-primary"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card card-admin shadow-sm">
            <div class="card-body p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted mb-1">Active Members</h6>
                        <h3 class="mb-0">{{ $activeMembers }}</h3>
                    </div>
                    <div class="bg-success bg-opacity-10 p-3 rounded-circle">
                        <i class="bi bi-person-check fs-4 text-success"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card card-admin shadow-sm">
            <div class="card-body p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted mb-1">Pending Approvals</h6>
                        <h3 class="mb-0">{{ $pendingMembersCount }}</h3>
                    </div>
                    <div class="bg-warning bg-opacity-10 p-3 rounded-circle">
                        <i class="bi bi-hourglass-split fs-4 text-warning"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card card-admin shadow-sm">
            <div class="card-body p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted mb-1">Inactive Members</h6>
                        <h3 class="mb-0">{{ $inactiveMembers }}</h3>
                    </div>
                    <div class="bg-secondary bg-opacity-10 p-3 rounded-circle">
                        <i class="bi bi-person-dash fs-4 text-secondary"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mb-4">
    <!-- Registration Chart -->
    <div class="col-md-12">
        <div class="card card-admin shadow-sm h-100">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">{{ $chartTitle }}</h5>
                <div class="d-flex">
                    <!-- Group By Filter -->
                    <div class="btn-group me-2">
                        <a href="{{ route('admin.dashboard', ['period' => $period, 'groupBy' => 'daily']) }}" class="btn btn-sm btn-outline-{{ $groupBy == 'daily' ? 'primary' : 'secondary' }}">
                            Daily
                        </a>
                        <a href="{{ route('admin.dashboard', ['period' => $period, 'groupBy' => 'monthly']) }}" class="btn btn-sm btn-outline-{{ $groupBy == 'monthly' ? 'primary' : 'secondary' }}">
                            Monthly
                        </a>
                        <a href="{{ route('admin.dashboard', ['period' => $period, 'groupBy' => 'yearly']) }}" class="btn btn-sm btn-outline-{{ $groupBy == 'yearly' ? 'primary' : 'secondary' }}">
                            Yearly
                        </a>
                    </div>
                    
                    <!-- Period Filter -->
                  
                </div>
            </div>
            <div class="card-body">
                <canvas id="registrationsChart" height="250"></canvas>
            </div>
        </div>
    </div>
</div>

<div class="row mb-4">
    <!-- Division Distribution -->
    <div class="col-md-6">
        <div class="card card-admin shadow-sm h-100">
            <div class="card-header">
                <h5 class="mb-0">Members by Division</h5>
            </div>
            <div class="card-body">
                <canvas id="divisionsChart" height="250"></canvas>
            </div>
        </div>
    </div>
    
    <!-- City Distribution -->
    <div class="col-md-6">
        <div class="card card-admin shadow-sm h-100">
            <div class="card-header">
                <h5 class="mb-0">Members by City</h5>
            </div>
            <div class="card-body">
                <canvas id="citiesChart" height="250"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Activity Categories Distribution -->
<div class="row mt-4">
    <div class="col-12">
        <div class="card card-admin shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Posts by Activity Category</h5>
                <a href="{{ route('admin.activity-categories.index') }}" class="btn btn-sm btn-outline-primary">Manage Categories</a>
            </div>
            <div class="card-body">
                @if($activityCategories->count() > 0)
                    <canvas id="categoriesChart" height="150"></canvas>
                @else
                    <div class="text-center py-4">
                        <i class="bi bi-bar-chart display-4 text-muted"></i>
                        <p class="mt-3 text-muted">No activity categories available yet.</p>
                        <a href="{{ route('admin.activity-categories.create') }}" class="btn btn-sm btn-outline-primary">
                            Create First Category
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <!-- Recent Members -->
    <div class="col-md-8">
        <div class="card card-admin shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Recent Members</h5>
                <a href="{{ route('admin.members.index') }}" class="btn btn-sm btn-outline-primary">View All</a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Name</th>
                                <th>Division</th>
                                <th>Position</th>
                                <th>Status</th>
                                <th>Joined</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentMembers as $member)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="bg-light rounded-circle p-2 me-2">
                                            <i class="bi bi-person"></i>
                                        </div>
                                        <div>
                                            <a href="{{ route('admin.members.show', $member->id) }}" class="text-decoration-none">
                                                {{ $member->full_name }}
                                            </a>
                                            <div class="text-muted small">{{ $member->user->email ?? 'No Email' }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $member->division->name ?? 'N/A' }}</td>
                                <td>{{ $member->position->name ?? 'N/A' }}</td>
                                <td>
                                    @if($member->status == 'active')
                                        <span class="status-badge status-active">Active</span>
                                    @elseif($member->status == 'pending')
                                        <span class="status-badge status-pending">Pending</span>
                                    @elseif($member->status == 'inactive')
                                        <span class="status-badge status-inactive">Inactive</span>
                                    @elseif($member->status == 'rejected')
                                        <span class="status-badge status-rejected">Rejected</span>
                                    @endif
                                </td>
                                <td>{{ $member->created_at->format('M d, Y') }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center py-3">No recent members found.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Pending Verifications -->
    <div class="col-md-4">
        <div class="card card-admin shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Pending Approvals</h5>
                <a href="{{ route('admin.members.index') }}?status=pending" class="btn btn-sm btn-outline-primary">View All</a>
            </div>
            <div class="card-body p-0">
                <div class="list-group list-group-flush">
                    @forelse($pendingMembers as $member)
                    <div class="list-group-item">
                        <div class="d-flex w-100 justify-content-between align-items-center">
                            <div>
                                <h6 class="mb-1">{{ $member->full_name }}</h6>
                                <p class="mb-1 small text-muted">Joined: {{ $member->created_at->format('M d, Y') }}</p>
                            </div>
                            <a href="{{ route('admin.members.show', $member->id) }}" class="btn btn-sm btn-outline-primary">
                                View
                            </a>
                        </div>
                    </div>
                    @empty
                    <div class="list-group-item text-center py-3">
                        No pending approvals.
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Registration Chart
    const registrationsChart = new Chart(
        document.getElementById('registrationsChart'),
        {
            type: 'line',
            data: {
                labels: {!! json_encode($labels) !!},
                datasets: [{
                    label: 'New Registrations',
                    data: {!! json_encode($registrationCounts) !!},
                    fill: false,
                    borderColor: '#0d6efd',
                    tension: 0.1,
                    backgroundColor: '#0d6efd'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0
                        }
                    }
                }
            }
        }
    );

    // Divisions Chart
    const divisionsData = {
        labels: {!! json_encode($divisions->pluck('name')) !!},
        datasets: [{
            label: 'Members Count',
            data: {!! json_encode($divisions->pluck('members_count')) !!},
            backgroundColor: [
                '#0d6efd',
                '#6610f2',
                '#6f42c1',
                '#d63384',
                '#dc3545',
                '#fd7e14',
                '#ffc107',
                '#198754',
            ],
            hoverOffset: 4
        }]
    };

    const divisionsChart = new Chart(
        document.getElementById('divisionsChart'),
        {
            type: 'doughnut',
            data: divisionsData,
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                    }
                }
            }
        }
    );
    
    // Cities Chart
    const citiesData = {
        labels: {!! json_encode($cities->pluck('city')) !!},
        datasets: [{
            label: 'Members Count',
            data: {!! json_encode($cities->pluck('total')) !!},
            backgroundColor: [
                '#20c997',
                '#0dcaf0',
                '#6610f2',
                '#fd7e14',
                '#d63384',
                '#dc3545',
                '#ffc107',
                '#198754',
                '#0d6efd',
                '#adb5bd'
            ],
            hoverOffset: 4
        }]
    };

    const citiesChart = new Chart(
        document.getElementById('citiesChart'),
        {
            type: 'doughnut',
            data: citiesData,
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        display: true,
                    }
                }
            }
        }    );
      // Activity Categories Chart    @if(isset($activityCategories) && $activityCategories->count() > 0)
    // Chart.js code for categories
    (function() {
        const categoriesLabels = {!! json_encode($activityCategories->pluck('name')) !!};
        const categoriesValues = {!! json_encode($activityCategories->pluck('activities_count')) !!};
        const categoriesColors = {!! json_encode($activityCategories->pluck('color')) !!};
        
        const categoriesData = {
            labels: categoriesLabels,
            datasets: [{
                label: 'Posts Count',
                data: categoriesValues,
                backgroundColor: categoriesColors,
                hoverOffset: 4
            }]
        };

        const categoriesChart = new Chart(
            document.getElementById('categoriesChart'),
            {
                type: 'bar',
                data: categoriesData,
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                precision: 0
                            }
                        }
                    }
                }
            }
        );
    })();    @endif
</script>
@endsection