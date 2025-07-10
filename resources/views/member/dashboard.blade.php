@extends('member.layouts.app')

@section('title', 'Beranda')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Beranda</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-2">
            <button type="button" class="btn btn-sm btn-outline-secondary" onclick="window.print()">
                <i class="bi bi-printer"></i> Cetak
            </button>
        </div>
        <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle">
            <i class="bi bi-calendar3"></i> {{ Carbon\Carbon::now()->format('F Y') }}
        </button>
    </div>
</div>

<!-- Member Welcome Card -->
<div class="card card-member shadow mb-4">
    <div class="card-body">
        <div class="row align-items-center">
            <div class="col-md-2 text-center mb-3 mb-md-0">
                @php
                    $photoDocument = $member->documents()->where('type', 'photo')->first();
                @endphp
                
                @if($photoDocument)
                    <img src="{{ asset('storage/' . $photoDocument->file_path) }}" 
                         class="img-fluid rounded-circle" 
                         alt="Foto Profil"
                         style="width: 100px; height: 100px; object-fit: cover; border: 3px solid #6610f2;">
                @else
                    <div class="rounded-circle mx-auto d-flex align-items-center justify-content-center bg-light"
                         style="width: 100px; height: 100px; border: 3px solid #6610f2;">
                        <i class="bi bi-person-fill text-secondary" style="font-size: 3rem;"></i>
                    </div>
                @endif
            </div>
            <div class="col-md-10">
                <h4>Selamat datang, {{ $member->full_name }}!</h4>
                <p class="mb-1">ID Keanggotaan: <span class="fw-bold">{{ $member->registration_number }}</span></p>
                <p class="mb-1">Status: 
                    <span class="badge {{ $member->status == 'active' ? 'status-active' : ($member->status == 'pending' ? 'status-pending' : ($member->status == 'rejected' ? 'status-rejected' : 'status-inactive')) }}">
                        {{ $member->status == 'active' ? 'Aktif' : ($member->status == 'pending' ? 'Menunggu' : ($member->status == 'rejected' ? 'Ditolak' : 'Tidak Aktif')) }}
                    </span>
                </p>
                @if($member->division)
                <p class="mb-1">Divisi: {{ $member->division->name }}</p>
                @endif
                @if($member->position)
                <p class="mb-0">Position: {{ $member->position->name }}</p>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Registration Chart (Full Width) -->
<div class="row mb-4">
    <div class="col-md-12">
        <div class="card card-member shadow h-100">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 fw-bold">{{ $chartTitle }}</h6>
                <div class="d-flex">
                    <!-- Group By Filter -->
                    <div class="btn-group me-2">
                        <a href="{{ route('member.dashboard', ['period' => $period, 'groupBy' => 'daily']) }}" class="btn btn-sm btn-outline-{{ $groupBy == 'daily' ? 'primary' : 'secondary' }}">
                            Daily
                        </a>
                        <a href="{{ route('member.dashboard', ['period' => $period, 'groupBy' => 'monthly']) }}" class="btn btn-sm btn-outline-{{ $groupBy == 'monthly' ? 'primary' : 'secondary' }}">
                            Monthly
                        </a>
                        <a href="{{ route('member.dashboard', ['period' => $period, 'groupBy' => 'yearly']) }}" class="btn btn-sm btn-outline-{{ $groupBy == 'yearly' ? 'primary' : 'secondary' }}">
                            Yearly
                        </a>
                    </div>
                    
                    <!-- Period Filter -->
                    <div class="dropdown">
                        <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" id="periodDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            {{ $periodLabel }}
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="periodDropdown">
                            <li><a class="dropdown-item {{ $period == '7days' ? 'active' : '' }}" href="{{ route('member.dashboard', ['period' => '7days', 'groupBy' => $groupBy]) }}">Last 7 Days</a></li>
                            <li><a class="dropdown-item {{ $period == '30days' ? 'active' : '' }}" href="{{ route('member.dashboard', ['period' => '30days', 'groupBy' => $groupBy]) }}">Last 30 Days</a></li>
                            <li><a class="dropdown-item {{ $period == '3months' ? 'active' : '' }}" href="{{ route('member.dashboard', ['period' => '3months', 'groupBy' => $groupBy]) }}">Last 3 Months</a></li>
                            <li><a class="dropdown-item {{ $period == '6months' ? 'active' : '' }}" href="{{ route('member.dashboard', ['period' => '6months', 'groupBy' => $groupBy]) }}">Last 6 Months</a></li>
                            <li><a class="dropdown-item {{ $period == '1year' ? 'active' : '' }}" href="{{ route('member.dashboard', ['period' => '1year', 'groupBy' => $groupBy]) }}">Last Year</a></li>
                            <li><a class="dropdown-item {{ $period == 'current_year' ? 'active' : '' }}" href="{{ route('member.dashboard', ['period' => 'current_year', 'groupBy' => $groupBy]) }}">Current Year ({{ date('Y') }})</a></li>
                            <li><a class="dropdown-item {{ $period == 'all' ? 'active' : '' }}" href="{{ route('member.dashboard', ['period' => 'all', 'groupBy' => $groupBy]) }}">All Time</a></li>
                        </ul>
                    </div>
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
        <div class="card card-member shadow h-100">
            <div class="card-header py-3">
                <h6 class="m-0 fw-bold">Members by Division</h6>
            </div>
            <div class="card-body">
                <canvas id="divisionChart" height="250"></canvas>
            </div>
        </div>
    </div>
    
    <!-- City Distribution -->
    <div class="col-md-6">
        <div class="card card-member shadow h-100">
            <div class="card-header py-3">
                <h6 class="m-0 fw-bold">Members by City</h6>
            </div>
            <div class="card-body">
                <canvas id="cityChart" height="250"></canvas>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Registrations Chart
    const registrationsCtx = document.getElementById('registrationsChart');
    const registrationsData = {
        labels: @json($labels),
        datasets: [{
            label: 'Registrations',
            data: @json($monthCounts),
            backgroundColor: 'rgba(102, 16, 242, 0.2)',
            borderColor: '#6610f2',
            borderWidth: 2,
            pointBackgroundColor: '#6610f2',
            pointRadius: 4,
            tension: 0.3
        }]
    };
    
    const registrationsConfig = {
        type: 'line',
        data: registrationsData,
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
        },
    };
    
    new Chart(registrationsCtx, registrationsConfig);
    
    // Division Chart (in bottom row)
    const divisionLabels = @json($divisions->pluck('name'));
    const divisionCounts = @json($divisions->pluck('members_count'));
    const divisionData = {
        labels: divisionLabels,
        datasets: [{
            label: 'Members Count',
            data: divisionCounts,
            backgroundColor: [
                '#6610f2',
                '#7a4eec',
                '#8e6ce5',
                '#a28dde',
                '#b7add7',
                '#cabdd0',
                '#dfdec8',
                '#f3efc1',
                '#fff1ba',
                '#fff3b3',
            ],
            hoverOffset: 4
        }]
    };

    const divisionsChart = new Chart(
        document.getElementById('divisionChart'),
        {
            type: 'doughnut',
            data: divisionData,
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
    
    // Large City Chart (bottom row)
    const cityLabels = @json($cities->pluck('city'));
    const cityCounts = @json($cities->pluck('total'));
    const cityData = {
        labels: cityLabels,
        datasets: [{
            label: 'Members Count',
            data: cityCounts,
            backgroundColor: [
                '#6610f2',
                '#7a4eec',
                '#8e6ce5',
                '#a28dde',
                '#b7add7',
                '#cabdd0',
                '#dfdec8',
                '#f3efc1',
                '#fff1ba',
                '#fff3b3',
            ],
            hoverOffset: 4
        }]
    };

    const citiesChart = new Chart(
        document.getElementById('cityChart'),
        {
            type: 'doughnut',
            data: cityData,
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
        }
    );
});
</script>
@endsection