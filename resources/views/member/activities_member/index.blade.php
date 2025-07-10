@php
    $user = Auth::user();
    $isAdmin = $user && (bool)$user->is_admin === true;
@endphp

@if($isAdmin)
    @extends('admin.layouts.app')
@else
    @extends('member.layouts.app')
@endif

@section('title', 'Kegiatan')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/activities-instagram.css') }}">
<link rel="stylesheet" href="{{ asset('css/activities-final-fixes.css') }}">
<link rel="stylesheet" href="{{ asset('css/profile-image-fixes.css') }}">
<link rel="stylesheet" href="{{ asset('css/force-profile-fix.css') }}">
<link rel="stylesheet" href="{{ asset('css/image-responsive-fix.css') }}">
<link rel="stylesheet" href="{{ asset('css/dashboard-layout-fixes.css') }}">
<link rel="stylesheet" href="{{ asset('css/scroll-override.css') }}">
<style>
    @import url('{{ asset('css/inline-fix.css') }}');
    @import url('{{ asset('css/emergency-fix.css') }}');
      /* Custom styles can be added here if needed */
  
    
    .section-title {
        position: relative;
        margin-bottom: 1.5rem;
        padding-bottom: 0.75rem;
    }
    
    .section-title::after {
        content: '';
        position: absolute;
        left: 0;
        bottom: 0;
        height: 3px;
        width: 60px;
        background-color: #6610f2;
    }
      .pagination {
        border-radius: 0;
        padding: 0.25rem;
        background-color: #fff;
        border: 1px solid #dbdbdb;
    }
    
    .page-item:first-child .page-link {
        border-top-left-radius: 3px;
        border-bottom-left-radius: 3px;
    }
    
    .page-item:last-child .page-link {
        border-top-right-radius: 3px;
        border-bottom-right-radius: 3px;
    }
    
    .page-link {
        color: #262626;
    }
      .page-item.active .page-link {
        background-color: #0095f6;
        border-color: #0095f6;
    }
    
    /* Search form styling */
    .search-form .form-control {
        border-top-right-radius: 0;
        border-bottom-right-radius: 0;
        border-right: none;
    }
    
    .search-form .btn-outline-secondary {
        border-top-left-radius: 0;
        border-bottom-left-radius: 0;
        border-left: none;
    }
    
    .search-form .btn-outline-danger {
        border-top-left-radius: 0;
        border-bottom-left-radius: 0;
    }
    
    .search-form .form-control:focus {
        box-shadow: none;
        border-color: #ced4da;
        border-right: none;
    }
    
    .search-form .btn:focus {
        box-shadow: none;
    }
    
    /* Search results highlight */
    .activity-title-highlight {
        background-color: rgba(102, 16, 242, 0.1);
        padding: 1px 2px;
        border-radius: 3px;
    }
    
    /* Modern Activity Title Styling */
    .activity-title-modern {
        font-family: 'Nunito', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif !important;
        font-weight: 700 !important;
        font-size: 1.1rem !important;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
        -webkit-background-clip: text !important;
        -webkit-text-fill-color: transparent !important;
        background-clip: text !important;
        color: transparent !important;
        line-height: 1.3 !important;
        margin: 0 !important;
        padding: 0.2rem 0 !important;
        text-shadow: none !important;
        letter-spacing: -0.02em !important;
    }
    
    /* Fallback for browsers that don't support background-clip */
    @supports not (-webkit-background-clip: text) {
        .activity-title-modern {
            color: #667eea !important;
            background: none !important;
        }
    }
    
    /* Dark mode support */
    [data-bs-theme="dark"] .activity-title-modern {
        background: linear-gradient(135deg, #74b9ff 0%, #a29bfe 100%) !important;
        -webkit-background-clip: text !important;
        -webkit-text-fill-color: transparent !important;
        background-clip: text !important;
    }
    
    @supports not (-webkit-background-clip: text) {
        [data-bs-theme="dark"] .activity-title-modern {
            color: #74b9ff !important;
            background: none !important;
        }
    }
    
    /* Hover effect for modern title */
    .activity-card:hover .activity-title-modern {
        background: linear-gradient(135deg, #5a67d8 0%, #553c9a 100%) !important;
        -webkit-background-clip: text !important;
        -webkit-text-fill-color: transparent !important;
        background-clip: text !important;
        transform: translateY(-1px) !important;
        transition: all 0.3s ease !important;
    }
    
    /* Clean card layout without actions */
    .activity-card {
        border-radius: 12px !important;
        overflow: hidden !important;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1) !important;
        transition: all 0.3s ease !important;
        background: white !important;
    }
    
    .activity-card:hover {
        transform: translateY(-2px) !important;
        box-shadow: 0 4px 16px rgba(0,0,0,0.15) !important;
    }
    
    .activity-card .card-body {
        padding: 1rem !important;
        border-top: none !important;
    }
    
    /* Remove any leftover styling from action buttons */
    .activity-actions,
    .activity-stats,
    .btn-like {
        display: none !important;
    }
    
    /* Date styling improvement */
    .activity-date {
        font-size: 0.8rem !important;
        color: #888 !important;
        font-weight: 500 !important;
    }
    
    /* Sidebar Styling - Right Side - Fixed for dashboard layout */
    .sidebar-activities {
        /* Remove sticky behavior - let it be part of main content scroll */
    }
    
    .sidebar-activities .card {
        border: none !important;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1) !important;
        border-radius: 12px !important;
        overflow: hidden !important;
    }
    
    .sidebar-activities .card-header {
        border-bottom: none !important;
        font-weight: 600 !important;
        padding: 0.75rem 1rem !important;
    }
    
    .sidebar-activities .list-group-item {
        font-size: 0.9rem !important;
        transition: all 0.2s ease !important;
    }
    
    .sidebar-activities .list-group-item:hover {
        background-color: #f8f9fa !important;
        transform: translateX(-3px) !important; /* Slide to left for right sidebar */
    }
    
    .sidebar-activities .list-group-item.active {
        background-color: #6610f2 !important;
        border-color: #6610f2 !important;
        color: white !important;
    }
    
    .sidebar-activities .list-group-item.active .badge {
        background-color: rgba(255,255,255,0.2) !important;
        color: white !important;
    }
    
    /* Quick stats styling */
    .sidebar-activities .card-body h4 {
        font-weight: 700 !important;
        font-size: 1.5rem !important;
    }
    
    /* Recent activity styling */
    .sidebar-activities .border-bottom:last-child {
        border-bottom: none !important;
    }
    
    /* Main content spacing for right sidebar */
    .col-lg-9.col-md-8.pe-md-4 {
        padding-right: 1.5rem !important;
    }
    
    /* Responsive sidebar */
    @media (max-width: 768px) {
        .sidebar-activities {
            position: static;
            margin-top: 2rem;
        }
        
        .sidebar-activities .card {
            margin-bottom: 1rem !important;
        }
        
        .col-lg-9.col-md-8.pe-md-4 {
            padding-right: 15px !important;
        }
    }
    
    /* Compact Activity Cards - Smaller Size */
    .activity-card {
        border-radius: 8px !important; /* Smaller radius */
        overflow: hidden !important;
        box-shadow: 0 1px 4px rgba(0,0,0,0.08) !important; /* Lighter shadow */
        transition: all 0.2s ease !important;
        background: white !important;
        margin-bottom: 0.5rem !important; /* Reduced margin */
        max-width: 100% !important;
        height: fit-content !important;
    }
    
    .activity-card:hover {
        transform: translateY(-1px) !important; /* Smaller lift */
        box-shadow: 0 2px 8px rgba(0,0,0,0.12) !important; /* Smaller shadow */
    }
    
    /* Smaller image container */
    .activity-image-container {
        height: 180px !important; /* Further reduced */
        max-height: 180px !important;
        overflow: hidden !important;
    }
    
    .activity-image-container img,
    .card-img-top {
        height: 180px !important;
        max-height: 180px !important;
        object-fit: cover !important;
        width: 100% !important;
    }
    
    /* Compact card body */
    .activity-card .card-body {
        padding: 0.5rem !important; /* Further reduced padding */
        border-top: none !important;
    }
    
    /* Smaller title */
    .activity-title-modern {
        font-size: 0.85rem !important; /* Smaller font */
        line-height: 1.2 !important;
        margin: 0 !important;
        padding: 0.1rem 0 0.3rem 0 !important;
    }
    
    /* Compact date styling */
    .activity-date {
        font-size: 0.7rem !important; /* Smaller date */
        color: #999 !important;
        font-weight: 400 !important;
    }
    
    /* Compact user header */
    .activity-user-header {
        padding: 0.5rem !important;
        font-size: 0.8rem !important;
    }
    
    .activity-username {
        font-size: 0.8rem !important;
        font-weight: 600 !important;
    }
    
    /* Grid layout adjustments for smaller cards */
    .activities-grid {
        margin-bottom: 2rem !important;
    }
    
    .activities-grid .col {
        padding: 0.25rem !important; /* Smaller grid spacing */
    }
    
    /* Mobile responsive for compact cards */
    @media (max-width: 576px) {
        .activity-image-container {
            height: 150px !important;
        }
        
        .activity-image-container img,
        .card-img-top {
            height: 150px !important;
        }
        
        .activity-title-modern {
            font-size: 0.8rem !important;
        }
    }
    
    /* Dashboard Layout Compatibility - Updated */
    .activities-main-content {
        height: 100%;
        overflow: visible;
    }
    
    /* Remove any padding/margin that interferes with fixed layout */
    .row {
        margin: 0;
    }
    
    .col-lg-9, .col-md-8, .col-lg-3, .col-md-4 {
        padding-left: 15px;
        padding-right: 15px;
    }
</style>
@endsection

@section('scripts')
<script src="{{ asset('js/fixes.js') }}"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Highlight search terms in titles if search parameter exists
        const urlParams = new URLSearchParams(window.location.search);
        const searchQuery = urlParams.get('search');
        
        if (searchQuery && searchQuery.length > 0) {
            const activityTitles = document.querySelectorAll('.comment-username');
            
            activityTitles.forEach(function(title) {
                const originalText = title.textContent;
                const regex = new RegExp('(' + searchQuery.replace(/[.*+?^${}()|[\]\\]/g, '\\$&') + ')', 'gi');
                
                if (regex.test(originalText)) {
                    title.innerHTML = originalText.replace(regex, '<span class="activity-title-highlight">$1</span>');
                }
            });
        }
        
        // Focus search input when page loads if there's a search query
        const searchInput = document.querySelector('input[name="search"]');
        if (searchQuery && searchInput) {
            searchInput.focus();
            // Position cursor at the end of the text
            const inputLength = searchInput.value.length;
            searchInput.setSelectionRange(inputLength, inputLength);
        }
        
        // Auto-submit form on clear button click
        const clearSearchBtn = document.querySelector('.search-form .btn-outline-danger');
        if (clearSearchBtn) {
            clearSearchBtn.addEventListener('click', function(e) {
                e.preventDefault();
                window.location.href = this.getAttribute('href');
            });
        }
    });
</script>
@endsection

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Kegiatan</h1>
    @if(Auth::user()->is_admin)
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
                <a href="{{ route('activities.create') }}" class="btn btn-sm btn-outline-primary">
                    <i class="bi bi-plus"></i> Tambah Kegiatan
                </a>
            </div>
        </div>
    @endif
</div>

<!-- Search and Category Filter Form -->
<div class="mb-4">
    <form action="{{ route('activities.index') }}" method="GET" class="search-form">
        <div class="row g-2">
            <div class="col-md-6">
                <div class="input-group">
                    <input 
                        type="text" 
                        class="form-control form-control-sm" 
                        placeholder="Cari judul kegiatan..."
                        name="search"
                        value="{{ $search ?? '' }}"
                        aria-label="Search"
                    >
                    <button class="btn btn-sm btn-outline-secondary" type="submit">
                        <i class="bi bi-search"></i>
                    </button>
                    @if((isset($search) && $search) || (isset($categoryId) && $categoryId))
                        <a href="{{ route('activities.index') }}" class="btn btn-sm btn-outline-danger">
                            <i class="bi bi-x"></i>
                        </a>
                    @endif
                </div>
            </div>
            <div class="col-md-6">
                <select name="category" class="form-select form-select-sm" onchange="this.form.submit()">
                    <option value="">-- Semua Kategori --</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ isset($categoryId) && $categoryId == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
    </form>
</div>

<div class="row">
    <!-- Main Content -->
    <div class="col-lg-9 col-md-8 pe-md-4">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        
        <!-- Search notification -->
        @if(isset($search) && $search)
            <div class="alert alert-info alert-dismissible fade show shadow-sm mb-3" role="alert">
                <i class="bi bi-search me-2"></i> Hasil pencarian untuk: <strong>{{ $search }}</strong>
                <a href="{{ route('activities.index') }}" class="btn-close" aria-label="Clear search"></a>
            </div>
        @endif

            <!-- Instagram doesn't typically have section titles, so removing this -->
            <!-- <h3 class="section-title">Daftar Kegiatan</h3> -->

            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-2 row-cols-lg-3 g-2 mb-5 activities-grid">
            @forelse($activities as $activity)                <div class="col">
                    <div class="card activity-card" data-id="{{ $activity->id }}"><!-- Instagram-like user header -->
                        <div class="activity-user-header">
                            <div class="activity-user-placeholder" style="width:24px !important; height:24px !important; border-radius:50%; border:1px solid #dbdbdb; display:flex; align-items:center; justify-content:center; font-size:12px; background-color:#6610f2; color:white; flex-shrink:0;">
                                A
                            </div>                            <div>
                                <div class="activity-username d-flex align-items-center">
                                    Administrator
                                    @if($activity->category)
                                        <span class="ms-2 badge" style="background-color: {{ $activity->category->color }}; font-size: 0.7rem;">
                                            {{ $activity->category->name }}
                                        </span>
                                    @endif
                                </div>
                                @if($activity->category)
                                    <small>
                                        <span class="badge" style="background-color: {{ $activity->category->color }}">
                                            {{ $activity->category->name }}
                                        </span>
                                    </small>
                                @endif
                            </div>
                        </div>

                        <!-- Activity image -->
                        <div class="activity-image-container">
                            @if($activity->image_path)
                                <img src="{{ asset('storage/' . $activity->image_path) }}" alt="{{ $activity->title }}" class="card-img-top">
                            @else
                                <div class="d-flex align-items-center justify-content-center h-100 bg-light">
                                    <i class="bi bi-image text-secondary" style="font-size: 2rem;"></i>
                                </div>
                            @endif
                        </div>
                        
                        <!-- Activity content -->
                        <div class="card-body">
                            <div class="d-flex align-items-start mb-2">
                                <h3 class="activity-title-modern">{{ $activity->title }}</h3>
                                <span class="activity-date ms-auto">{{ $activity->created_at->format('d M') }}</span>
                            </div>
                            <p class="card-text">{{ Str::limit($activity->description, 100) }}</p>
                            <a href="{{ route('activities.show', $activity) }}" class="btn-read-more">
                                Lihat Detail
                            </a>
                        </div>
                        
                        @if(count($activity->comments) > 0)
                            <!-- Instagram-style comment section -->
                                <!-- View all comments link -->
                                @if($activity->comments_count > 0)
                                    <a href="{{ route('activities.show', $activity) }}" class="view-all-comments">
                                        Lihat semua {{ $activity->comments_count }} komentar
                                    </a>
                                @endif
                                
                                <!-- Latest comment -->                                @foreach($activity->comments->take(1) as $comment)
                                    <div class="latest-comment">                                        @if($comment->member->getPhotoDocument())
                                            <img src="{{ asset('storage/' . $comment->member->getPhotoDocument()->file_path) }}" alt="Profile" class="comment-avatar" style="width:22px !important; height:22px !important; max-width:22px !important; max-height:22px !important; border-radius:50%; border:1px solid #dbdbdb; object-fit:cover; flex-shrink:0;">
                                        @else
                                            <div class="comment-placeholder-avatar" style="width:22px !important; height:22px !important; max-width:22px !important; max-height:22px !important; border-radius:50%; border:1px solid #dbdbdb; display:flex; align-items:center; justify-content:center; font-size:10px; background-color:#6610f2; color:white; flex-shrink:0;">
                                                {{ substr($comment->member->full_name, 0, 1) }}
                                            </div>
                                        @endif
                                        <div class="comment-content">
                                            <span class="comment-username">{{ Str::limit($comment->member->full_name, 15) }}</span>
                                            {{ Str::limit($comment->content, 50) }}</div>
                                    </div>
                                @endforeach
                        @endif
                    </div>
                </div>            @empty
                <div class="col-12">
                    <div class="empty-activities">
                        @if(isset($search) && $search)
                            <i class="bi bi-search"></i>
                            <h4 class="mt-3">Tidak Ada Hasil</h4>
                            <p class="text-muted mb-4">Tidak ditemukan kegiatan dengan judul yang mengandung "{{ $search }}".</p>
                            <a href="{{ route('activities.index') }}" class="btn btn-sm btn-outline-secondary">
                                <i class="bi bi-arrow-left"></i> Kembali ke Semua Kegiatan
                            </a>
                        @else
                            <i class="bi bi-camera"></i>
                            <h4 class="mt-3">Belum Ada Kegiatan</h4>
                            <p class="text-muted mb-4">Belum ada kegiatan yang dipublikasikan saat ini.</p>
                            @if(Auth::user()->is_admin)
                                <a href="{{ route('activities.create') }}" class="btn btn-sm btn-outline-secondary">
                                    <i class="bi bi-plus"></i> Tambah Kegiatan Baru
                                </a>
                            @endif
                        @endif
                    </div>
                </div>
            @endforelse
            </div>
            
            <div class="d-flex justify-content-center">
                {{ $activities->links() }}
            </div>
        </div>
        <!-- End Main Content -->
        
        <!-- Sidebar - Right Side -->
        <div class="col-lg-3 col-md-4 mb-4">
            <div class="sidebar-activities">
                <!-- Quick Stats -->
                <div class="card mb-3">
                    <div class="card-header bg-primary text-white">
                        <h6 class="mb-0"><i class="bi bi-bar-chart me-2"></i>Statistik Cepat</h6>
                    </div>
                    <div class="card-body">
                        <div class="row text-center">
                            <div class="col-6">
                                <h4 class="text-primary mb-0">{{ $activities->total() ?? 0 }}</h4>
                                <small class="text-muted">Total Kegiatan</small>
                            </div>
                            <div class="col-6">
                                <h4 class="text-success mb-0">{{ $categories->count() ?? 0 }}</h4>
                                <small class="text-muted">Kategori</small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Categories Quick Filter -->
                <div class="card mb-3">
                    <div class="card-header bg-info text-white">
                        <h6 class="mb-0"><i class="bi bi-tags me-2"></i>Kategori</h6>
                    </div>
                    <div class="card-body p-2">
                        <div class="list-group list-group-flush">
                            <a href="{{ route('activities.index') }}" 
                               class="list-group-item list-group-item-action border-0 py-2 {{ !isset($categoryId) || !$categoryId ? 'active' : '' }}">
                                <i class="bi bi-grid me-2"></i>Semua Kategori
                                <span class="badge bg-secondary float-end">{{ $activities->total() ?? 0 }}</span>
                            </a>
                            @foreach($categories as $category)
                                <a href="{{ route('activities.index', ['category' => $category->id]) }}" 
                                   class="list-group-item list-group-item-action border-0 py-2 {{ isset($categoryId) && $categoryId == $category->id ? 'active' : '' }}">
                                    <span class="badge me-2" style="background-color: {{ $category->color }}; width: 12px; height: 12px; border-radius: 50%;"></span>
                                    {{ $category->name }}
                                    <span class="badge bg-light text-dark float-end">{{ $category->activities_count ?? 0 }}</span>
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Recent Activity -->
                <div class="card mb-3">
                    <div class="card-header bg-warning text-dark">
                        <h6 class="mb-0"><i class="bi bi-clock me-2"></i>Aktivitas Terbaru</h6>
                    </div>
                    <div class="card-body p-2">
                        <div class="small">
                            @if($activities->count() > 0)
                                @foreach($activities->take(3) as $recentActivity)
                                    <div class="d-flex align-items-center py-2 border-bottom">
                                        <div class="bg-primary rounded-circle me-2 d-flex align-items-center justify-content-center" style="width: 24px; height: 24px; min-width: 24px;">
                                            <i class="bi bi-calendar-event text-white" style="font-size: 10px;"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <div class="text-truncate" style="max-width: 150px;">{{ $recentActivity->title }}</div>
                                            <div class="text-muted" style="font-size: 10px;">{{ $recentActivity->created_at->diffForHumans() }}</div>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="text-muted text-center py-3">
                                    <i class="bi bi-inbox"></i><br>
                                    Belum ada kegiatan
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Admin Quick Actions -->
                @if(Auth::user()->is_admin)
                <div class="card">
                    <div class="card-header bg-success text-white">
                        <h6 class="mb-0"><i class="bi bi-gear me-2"></i>Admin</h6>
                    </div>
                    <div class="card-body p-2">
                        <div class="d-grid gap-2">
                            <a href="{{ route('activities.create') }}" class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-plus me-1"></i>Tambah Kegiatan
                            </a>
                            @if(Route::has('admin.activity-categories.index'))
                                <a href="{{ route('admin.activity-categories.index') }}" class="btn btn-sm btn-outline-info">
                                    <i class="bi bi-tags me-1"></i>Kelola Kategori
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
                @endif
        </div>
    </div>
    <!-- End Row -->
</div>

@endsection