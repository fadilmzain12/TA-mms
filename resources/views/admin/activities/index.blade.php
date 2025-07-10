@extends('admin.layouts.app')

@section('title', 'Kelola Kegiatan')

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
        border-radius: 4px 0 0 4px;
    }
    
    .page-item:last-child .page-link {
        border-radius: 0 4px 4px 0;
    }
    
    .page-link {
        color: #6610f2;
        border: none;
        border-right: 1px solid #dbdbdb;
        padding: 0.5rem 0.75rem;
    }
    
    .page-link:hover {
        background-color: #6610f2;
        color: white;
    }
    
    .page-item.active .page-link {
        background-color: #6610f2;
        border-color: #6610f2;
    }
</style>
@endsection

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Kelola Kegiatan</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-2">
            <a href="{{ route('activities.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Tambah Kegiatan
            </a>
        </div>
    </div>
</div>

<!-- Search and Filter Section -->
<div class="row mb-4">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <form method="GET" action="{{ route('activities.index') }}" class="row g-3">
                    <div class="col-md-6">
                        <label for="search" class="form-label">Cari Kegiatan</label>
                        <input type="text" class="form-control" id="search" name="search" value="{{ $search }}" placeholder="Masukkan judul kegiatan...">
                    </div>
                    <div class="col-md-4">
                        <label for="category" class="form-label">Kategori</label>
                        <select class="form-select" id="category" name="category">
                            <option value="">Semua Kategori</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ $categoryId == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label d-block">&nbsp;</label>
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="bi bi-search"></i> Cari
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Activities List -->
<div class="row">
    @forelse($activities as $activity)
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card activity-card h-100">
                <div class="card-header activity-header">
                    <div class="d-flex align-items-center">
                        <div class="activity-author-avatar me-3">
                            {{ substr($activity->user->name, 0, 1) }}
                        </div>
                        <div class="flex-grow-1">
                            <div class="fw-bold">{{ $activity->user->name }}</div>
                            <div class="small text-muted d-flex align-items-center">
                                <span>Administrator</span>
                                @if($activity->category)
                                    <span class="mx-2">•</span>
                                    <span class="badge" style="background-color: {{ $activity->category->color }}">
                                        {{ $activity->category->name }}
                                    </span>
                                @endif
                            </div>
                        </div>
                        <!-- Admin Actions -->
                        <div class="dropdown">
                            <button class="btn btn-sm btn-outline-secondary" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-three-dots-vertical"></i>
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="{{ route('activities.show', $activity) }}"><i class="bi bi-eye me-2"></i>Lihat</a></li>
                                <li><a class="dropdown-item" href="{{ route('activities.edit', $activity) }}"><i class="bi bi-pencil me-2"></i>Edit</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form action="{{ route('activities.destroy', $activity) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kegiatan ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="dropdown-item text-danger">
                                            <i class="bi bi-trash me-2"></i>Hapus
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                
                @if($activity->image_path)
                    <div class="activity-image-container">
                        <img src="{{ asset('storage/' . $activity->image_path) }}" alt="{{ $activity->title }}" class="activity-image">
                    </div>
                @else
                    <div class="activity-placeholder">
                        <i class="bi bi-image"></i>
                    </div>
                @endif
                
                <div class="card-body">
                    <div class="activity-actions mb-2">
                        <div class="d-flex">
                            <form action="{{ route('activities.like', $activity) }}" method="POST" class="me-3">
                                @csrf
                                <button type="submit" class="btn p-0 {{ $activity->likes->where('member_id', Auth::user()->member->id ?? 0)->count() ? 'text-danger' : 'text-dark' }} bg-transparent border-0">
                                    <i class="bi {{ $activity->likes->where('member_id', Auth::user()->member->id ?? 0)->count() ? 'bi-heart-fill' : 'bi-heart' }} fs-5"></i>
                                </button>
                            </form>
                            <a href="{{ route('activities.show', $activity) }}#comments" class="btn p-0 text-dark bg-transparent border-0">
                                <i class="bi bi-chat fs-5"></i>
                            </a>
                        </div>
                    </div>
                    
                    <div class="fw-bold mb-2">{{ $activity->likes_count }} suka</div>
                    
                    <h5 class="activity-title">{{ $activity->title }}</h5>
                    
                    <p class="activity-description">
                        {{ Str::limit(strip_tags($activity->description), 100) }}
                    </p>
                    
                    <div class="activity-meta">
                        <small class="text-muted">
                            <i class="bi bi-calendar-event me-1"></i> {{ $activity->created_at->format('d M Y') }}
                            <span class="mx-2">•</span>
                            <i class="bi bi-clock me-1"></i> {{ $activity->created_at->format('H:i') }}
                        </small>
                    </div>
                    
                    @if($activity->comments_count > 0)
                        <div class="mt-3">
                            <a href="{{ route('activities.show', $activity) }}#comments" class="text-muted small">
                                Lihat semua {{ $activity->comments_count }} komentar
                            </a>
                        </div>
                    @endif
                </div>
                
                <div class="card-footer">
                    <div class="row">
                        <div class="col-6">
                            <a href="{{ route('activities.show', $activity) }}" class="btn btn-outline-primary btn-sm w-100">
                                <i class="bi bi-eye me-2"></i> Detail
                            </a>
                        </div>
                        <div class="col-6">
                            <a href="{{ route('activities.edit', $activity) }}" class="btn btn-outline-warning btn-sm w-100">
                                <i class="bi bi-pencil me-2"></i> Edit
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12">
            <div class="text-center py-5">
                <i class="bi bi-calendar-x text-muted mb-3" style="font-size: 4rem;"></i>
                <h4 class="text-muted">Tidak Ada Kegiatan</h4>
                <p class="text-muted">
                    @if($search || $categoryId)
                        Tidak ada kegiatan yang sesuai dengan kriteria pencarian Anda.
                        <br>
                        <a href="{{ route('activities.index') }}" class="btn btn-outline-primary mt-2">
                            <i class="bi bi-arrow-clockwise me-2"></i> Reset Filter
                        </a>
                    @else
                        Belum ada kegiatan yang dipublikasikan.
                        <br>
                        <a href="{{ route('activities.create') }}" class="btn btn-primary mt-2">
                            <i class="bi bi-plus-circle me-2"></i> Tambah Kegiatan Pertama
                        </a>
                    @endif
                </p>
            </div>
        </div>
    @endforelse
</div>

<!-- Pagination -->
@if($activities->hasPages())
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-center">
                {{ $activities->appends(request()->query())->links() }}
            </div>
        </div>
    </div>
@endif
@endsection

@section('scripts')
<script src="{{ asset('js/fixes.js') }}"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Auto-submit form when category changes
        document.getElementById('category').addEventListener('change', function() {
            this.form.submit();
        });
        
        // Reset search when clicking reset
        const resetBtn = document.querySelector('.btn-outline-primary[href*="reset"]');
        if (resetBtn) {
            resetBtn.addEventListener('click', function(e) {
                e.preventDefault();
                document.getElementById('search').value = '';
                document.getElementById('category').value = '';
                document.querySelector('form').submit();
            });
        }
    });
</script>
@endsection
