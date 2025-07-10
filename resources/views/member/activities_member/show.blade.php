@php
    $user = Auth::user();
    $isAdmin = $user && (bool)$user->is_admin === true;
@endphp

@if($isAdmin)
    @extends('admin.layouts.app')
@else
    @extends('member.layouts.app')
@endif

@section('title', $activity->title)

@section('styles')
<link rel="stylesheet" href="{{ asset('css/activity-instagram.css') }}">
<link rel="stylesheet" href="{{ asset('css/comment-fixes.css') }}">
<link rel="stylesheet" href="{{ asset('css/instagram-fixes.css') }}">
<link rel="stylesheet" href="{{ asset('css/final-fixes.css') }}">
<link rel="stylesheet" href="{{ asset('css/profile-image-fixes.css') }}">
<link rel="stylesheet" href="{{ asset('css/force-profile-fix.css') }}">
<link rel="stylesheet" href="{{ asset('css/image-responsive-fix.css') }}">
<link rel="stylesheet" href="{{ asset('css/dashboard-layout-fixes.css') }}">
<link rel="stylesheet" href="{{ asset('css/scroll-override.css') }}">
<style>
    @import url('{{ asset('css/inline-fix.css') }}');
    @import url('{{ asset('css/emergency-fix.css') }}');
    
    /* Direct HTML element styling */
    :root {
        --comment-avatar-size: 22px;
        --reply-avatar-size: 18px;
        --user-avatar-size: 24px;
    }
    
    /* These direct element selectors should override everything */
    .comment-avatar, .comment-placeholder-avatar,
    div.comment-avatar, div.comment-placeholder-avatar,
    img.comment-avatar, span.comment-avatar {
        width: var(--comment-avatar-size) !important;
        height: var(--comment-avatar-size) !important;
        max-width: var(--comment-avatar-size) !important;
        max-height: var(--comment-avatar-size) !important;
        min-width: var(--comment-avatar-size) !important;
        min-height: var(--comment-avatar-size) !important;
    }
    
    .reply-avatar, .reply-placeholder-avatar,
    div.reply-avatar, div.reply-placeholder-avatar,
    img.reply-avatar, span.reply-avatar {
        width: var(--reply-avatar-size) !important;
        height: var(--reply-avatar-size) !important;
        max-width: var(--reply-avatar-size) !important;
        max-height: var(--reply-avatar-size) !important;
        min-width: var(--reply-avatar-size) !important;
        min-height: var(--reply-avatar-size) !important;
    }
    
    /* EMERGENCY IMAGE FIX - Inline styles with highest priority */
    .activity-image-container {
        max-width: 100% !important;
        width: 100% !important;
        overflow: hidden !important;
        max-height: 500px !important;
        position: relative !important;
        box-sizing: border-box !important;
    }
    
    .activity-image-container img,
    .activity-image {
        max-width: 100% !important;
        width: 100% !important;
        height: auto !important;
        max-height: 500px !important;
        object-fit: contain !important;
        object-position: center !important;
        display: block !important;
        margin: 0 auto !important;
        box-sizing: border-box !important;
    }
    
    .card, .activity-detail {
        max-width: 100% !important;
        overflow: hidden !important;
        box-sizing: border-box !important;
    }
    
    /* Dashboard Layout Compatibility - Updated */
    .activity-main-content {
        height: 100%;
        overflow: visible;
    }
    
    /* Remove any padding/margin that interferes with fixed layout */
    .row {
        margin: 0;
    }
    
    @media (max-width: 768px) {
        .activity-image-container {
            max-height: 300px !important;
        }
        .activity-image-container img,
        .activity-image {
            max-height: 300px !important;
        }
    }
</style>
@endsection



@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">{{ $activity->title }}</h1>
    @if(Auth::user()->is_admin)
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
                <a href="{{ route('activities.edit', $activity) }}" class="btn btn-sm btn-outline-primary">
                    <i class="bi bi-pencil"></i> Edit
                </a>
                <button type="button" class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteModal">
                    <i class="bi bi-trash"></i> Hapus
                </button>
            </div>
        </div>
    @endif
</div>

<!-- Back to list button -->
<a href="{{ route('activities.index') }}" class="btn btn-outline-secondary btn-sm mb-3">
    <i class="bi bi-arrow-left me-2"></i> Kembali ke Daftar Kegiatan
</a>

<div class="row justify-content-center">
    <div class="col-md-8">
        <!-- Activity Details - Instagram Style -->
        <div class="card activity-detail" style="max-width: 100% !important; overflow: hidden !important; box-sizing: border-box !important;">
            <!-- Post Header -->
            <div class="card-header">                    <div class="d-flex align-items-center">
                    <div class="comment-placeholder-avatar me-3">
                        {{ substr($activity->user->name, 0, 1) }}
                    </div>
                    <div>
                        <div class="fw-bold">{{ $activity->user->name }}</div>
                        <div class="small text-muted">
                            Administrator
                            @if($activity->category)
                                <span class="mx-1">•</span>
                                <span class="badge" style="background-color: {{ $activity->category->color }}">
                                    {{ $activity->category->name }}
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
                </div>
                
                <!-- Post Image -->
                <div class="activity-image-container" style="max-width: 100% !important; overflow: hidden !important; box-sizing: border-box !important;" id="imageContainer">
                    @if($activity->image_path)
                        <img src="{{ asset('storage/' . $activity->image_path) }}" alt="{{ $activity->title }}" class="activity-image" 
                             style="max-width: 100% !important; max-height: 100% !important; width: auto !important; height: auto !important; object-fit: contain !important; object-position: center !important; display: block !important; margin: 0 auto !important; box-sizing: border-box !important;"
                             onload="setInstagramRatio(this)">
                    @else
                        <div class="file-placeholder">
                            <i class="bi bi-image"></i>
                        </div>
                    @endif
                </div>
                
                <!-- Post Actions -->
                <div class="p-3">
                    <div class="d-flex mb-2">
                        <form action="{{ route('activities.like', $activity) }}" method="POST" class="me-3">
                            @csrf
                            <button type="submit" class="btn btn-lg p-0 {{ $hasLiked ? 'text-danger' : 'text-dark' }} bg-transparent border-0">
                                <i class="bi {{ $hasLiked ? 'bi-heart-fill' : 'bi-heart' }} fs-4"></i>
                            </button>
                        </form>
                        <a href="#comments" class="btn btn-lg p-0 text-dark bg-transparent border-0">
                            <i class="bi bi-chat fs-4"></i>
                        </a>
                    </div>
                    
                    <!-- Likes count -->
                    <div class="fw-bold mb-2">{{ $activity->likes_count }} suka</div>
                    
                    <!-- Activity title and description -->
                    <h1 class="activity-title">{{ $activity->title }}</h1>
                    
                    <div class="activity-description">
                        {!! nl2br(e($activity->description)) !!}
                    </div>
                    
                    <!-- Post metadata -->
                    <div class="activity-info">
                        <div class="activity-info-item">
                            <i class="bi bi-calendar-event"></i>
                            <span>{{ $activity->created_at->format('d M Y') }}</span>
                        </div>
                        <div class="activity-info-item">
                            <i class="bi bi-clock"></i>
                            <span>{{ $activity->created_at->format('H:i') }}</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Comment Form -->
            <div id="comments"></div> <!-- Anchor for comment section navigation -->
            @if(Auth::user()->member || Auth::user()->is_admin)
                <div class="card comment-form mb-3 mt-4">
                    <div class="card-body">
                        <h5 class="mb-3 d-flex align-items-center">
                            <i class="bi bi-chat-right-text me-2"></i>Tambahkan Komentar
                        </h5>
                        <form action="{{ route('comments.store', $activity) }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <textarea class="form-control @error('content') is-invalid @enderror" name="content" rows="2" placeholder="Tulis komentar..." required>{{ old('content') }}</textarea>
                                @error('content')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary d-flex align-items-center gap-2">
                                    <i class="bi bi-send-fill"></i> Kirim
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            @else
                <div class="alert alert-info mb-3 mt-4 d-flex align-items-center" role="alert">
                    <i class="bi bi-info-circle-fill me-2"></i>
                    <div>
                        Anda harus memiliki profil member untuk dapat berkomentar. Silakan lengkapi profil Anda terlebih dahulu.
                    </div>
                </div>
            @endif
            
            <!-- Comments Section -->
            <div class="comments-container mb-5">
                <div class="comments-header">
                    <h4 class="m-0 d-flex align-items-center gap-2">
                        <i class="bi bi-chat-square-text"></i> Komentar
                        <span class="badge rounded-pill bg-light text-dark ms-2">{{ $activity->comments_count }}</span>
                    </h4>
                </div>
                
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show m-3" role="alert">
                        <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show m-3" role="alert">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                
                <div class="p-3">
                    @forelse($activity->comments as $comment)
                        <div class="comment-item" id="comment-{{ $comment->id }}">
                            <div class="d-flex">
                                <div class="flex-shrink-0">                                    @if($comment->member->getPhotoDocument())
                                        <img src="{{ asset('storage/' . $comment->member->getPhotoDocument()->file_path) }}" alt="Profile" class="comment-avatar" style="width:22px !important; height:22px !important; max-width:22px !important; max-height:22px !important; border-radius:50%; border:1px solid #dbdbdb; object-fit:cover;">
                                    @else
                                        <div class="comment-placeholder-avatar" style="width:22px !important; height:22px !important; max-width:22px !important; max-height:22px !important; border-radius:50%; border:1px solid #dbdbdb; display:flex; align-items:center; justify-content:center; font-size:10px; background-color:#6610f2; color:white;">
                                            {{ substr($comment->member->full_name, 0, 1) }}
                                        </div>
                                    @endif
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                        <div>
                                            <span class="comment-user">{{ $comment->member->full_name }}</span>
                                            <span class="comment-time ms-2">{{ $comment->created_at->diffForHumans() }}</span>
                                        </div>
                                        
                                        @if((Auth::user()->member && Auth::user()->member->id == $comment->member_id) || Auth::user()->is_admin)
                                            <div class="dropdown">
                                                <button class="btn btn-sm btn-light rounded-circle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="bi bi-three-dots"></i>
                                                </button>
                                                <ul class="dropdown-menu shadow-sm">
                                                    @if(Auth::user()->member && Auth::user()->member->id == $comment->member_id)
                                                    <li>
                                                        <a href="#" class="dropdown-item edit-comment-btn" data-comment-id="{{ $comment->id }}" data-comment-content="{{ $comment->content }}">
                                                            <i class="bi bi-pencil me-2"></i> Edit
                                                        </a>
                                                    </li>
                                                    @endif
                                                    <li>
                                                        <form action="{{ route('comments.destroy', $comment) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus komentar ini?')">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="dropdown-item text-danger">
                                                                <i class="bi bi-trash me-2"></i> Hapus
                                                            </button>
                                                        </form>
                                                    </li>
                                                </ul>
                                            </div>
                                        @endif
                                    </div>
                                    
                                    <div class="comment-content">
                                        <p class="mb-0">{{ $comment->content }}</p>
                                    </div>
                                    
                                    <div class="edit-comment-form d-none mb-3" id="edit-comment-form-{{ $comment->id }}">
                                        <form action="{{ route('comments.update', $comment) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <div class="mb-2">
                                                <textarea class="form-control" name="content" rows="2" required>{{ $comment->content }}</textarea>
                                            </div>
                                            <div>
                                                <button type="submit" class="btn btn-sm btn-primary">Simpan</button>
                                                <button type="button" class="btn btn-sm btn-outline-secondary cancel-edit-btn">Batal</button>
                                            </div>
                                        </form>
                                    </div>
                                    
                                    <div class="comment-actions">
                                        <form action="{{ route('comments.like', $comment) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm {{ $comment->likes->where('member_id', Auth::user()->member->id ?? 0)->count() ? 'text-danger' : 'text-muted' }} p-0 me-2 border-0 bg-transparent">
                                                <i class="bi {{ $comment->likes->where('member_id', Auth::user()->member->id ?? 0)->count() ? 'bi-heart-fill' : 'bi-heart' }}"></i> 
                                                <span class="small">{{ $comment->likes_count }}</span>
                                            </button>
                                        </form>
                                        
                                        <button class="btn btn-sm text-muted p-0 border-0 bg-transparent reply-btn" data-comment-id="{{ $comment->id }}">
                                            <i class="bi bi-reply"></i> Balas
                                        </button>
                                    </div>
                                    
                                    <div class="reply-form d-none mt-3" id="reply-form-{{ $comment->id }}">
                                        @if(Auth::user()->member || Auth::user()->is_admin)
                                        <form action="{{ route('replies.store', $comment) }}" method="POST">
                                            @csrf
                                            <div class="mb-2">
                                                <textarea class="form-control" name="content" rows="2" placeholder="Tulis balasan Anda..." required></textarea>
                                            </div>
                                            <div>                                                <button type="submit" class="btn btn-sm btn-primary">Kirim Balasan</button>
                                                <button type="button" class="btn btn-sm btn-outline-secondary cancel-reply-btn" onclick="document.getElementById('reply-form-{{ $comment->id }}').classList.add('d-none');">Batal</button>
                                            </div>
                                        </form>
                                        @else
                                        <div class="alert alert-info">
                                            <i class="bi bi-info-circle me-2"></i> Anda harus memiliki profil member untuk dapat membalas komentar.
                                        </div>
                                        @endif
                                    </div>
                                    
                                    <!-- Comment Replies -->
                                    @if($comment->replies->count() > 0)
                                        <div class="reply-container">
                                            @foreach($comment->replies as $reply)
                                                <div class="reply-item" id="reply-{{ $reply->id }}">
                                                    <div class="d-flex">
                                                        <div class="flex-shrink-0">                                                            @if($reply->member->getPhotoDocument())
                                                                <img src="{{ asset('storage/' . $reply->member->getPhotoDocument()->file_path) }}" alt="Profile" class="reply-avatar" style="width:18px !important; height:18px !important; max-width:18px !important; max-height:18px !important; border-radius:50%; border:1px solid #dbdbdb; object-fit:cover;">
                                                            @else
                                                                <div class="reply-placeholder-avatar" style="width:18px !important; height:18px !important; max-width:18px !important; max-height:18px !important; border-radius:50%; border:1px solid #dbdbdb; display:flex; align-items:center; justify-content:center; font-size:8px; background-color:#6610f2; color:white;">
                                                                    {{ substr($reply->member->full_name, 0, 1) }}
                                                                </div>
                                                            @endif
                                                        </div>
                                                        <div class="flex-grow-1 ms-2">
                                                            <div class="d-flex justify-content-between align-items-center mb-1">
                                                                <div>
                                                                    <span class="fw-medium">{{ $reply->member->full_name }}</span>
                                                                    <span class="comment-time ms-1">{{ $reply->created_at->diffForHumans() }}</span>
                                                                </div>
                                                                
                                                                @if((Auth::user()->member && Auth::user()->member->id == $reply->member_id) || Auth::user()->is_admin)
                                                                    <div class="dropdown">
                                                                        <button class="btn btn-sm btn-light rounded-circle p-1" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                                            <i class="bi bi-three-dots"></i>
                                                                        </button>
                                                                        <ul class="dropdown-menu shadow-sm">
                                                                            @if(Auth::user()->member && Auth::user()->member->id == $reply->member_id)
                                                                            <li>
                                                                                <a href="#" class="dropdown-item edit-reply-btn" data-reply-id="{{ $reply->id }}" data-reply-content="{{ $reply->content }}">
                                                                                    <i class="bi bi-pencil me-2"></i> Edit
                                                                                </a>
                                                                            </li>
                                                                            @endif
                                                                            <li>
                                                                                <form action="{{ route('replies.destroy', $reply) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus balasan ini?')">
                                                                                    @csrf
                                                                                    @method('DELETE')
                                                                                    <button type="submit" class="dropdown-item text-danger">
                                                                                        <i class="bi bi-trash me-2"></i> Hapus
                                                                                    </button>
                                                                                </form>
                                                                            </li>
                                                                        </ul>
                                                                    </div>
                                                                @endif
                                                            </div>
                                                            
                                                            <div class="reply-content">
                                                                <p class="mb-0">{{ $reply->content }}</p>
                                                            </div>
                                                            
                                                            <div class="edit-reply-form d-none mb-2" id="edit-reply-form-{{ $reply->id }}">
                                                                <form action="{{ route('replies.update', $reply) }}" method="POST">
                                                                    @csrf
                                                                    @method('PUT')
                                                                    <div class="mb-2">
                                                                        <textarea class="form-control" name="content" rows="2" required>{{ $reply->content }}</textarea>
                                                                    </div>
                                                                    <div>
                                                                        <button type="submit" class="btn btn-sm btn-primary">Simpan</button>
                                                                        <button type="button" class="btn btn-sm btn-outline-secondary cancel-edit-reply-btn">Batal</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                            
                                                            <div class="d-flex align-items-center mt-1">
                                                                <form action="{{ route('replies.like', $reply) }}" method="POST" class="d-inline">
                                                                    @csrf
                                                                    <button type="submit" class="btn btn-sm {{ $reply->likes->where('member_id', Auth::user()->member->id ?? 0)->count() ? 'text-danger' : 'text-muted' }} p-0 me-1 border-0 bg-transparent">
                                                                        <i class="bi {{ $reply->likes->where('member_id', Auth::user()->member->id ?? 0)->count() ? 'bi-heart-fill' : 'bi-heart' }}"></i> 
                                                                        <span class="small">{{ $reply->likes_count }}</span>
                                                                    </button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-5">
                            <i class="bi bi-chat-square text-muted mb-3" style="font-size: 3rem;"></i>
                            <h5 class="text-muted">Belum Ada Komentar</h5>
                            <p class="text-muted mb-4">Jadilah yang pertama memberikan komentar untuk kegiatan ini!</p>
                            @if(Auth::user()->member || Auth::user()->is_admin)
                                <a href="#" onclick="document.querySelector('textarea[name=content]').focus(); return false;" class="btn btn-primary">
                                    <i class="bi bi-chat-dots me-2"></i> Tulis Komentar
                                </a>
                            @endif
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Modal -->
@if(Auth::user()->is_admin)
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Konfirmasi Hapus</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Apakah Anda yakin ingin menghapus kegiatan <strong>{{ $activity->title }}</strong>? Tindakan ini tidak dapat dibatalkan.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <form action="{{ route('activities.destroy', $activity) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Hapus</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endif

@section('scripts')
<script src="{{ asset('js/fixes.js') }}"></script>
<script src="{{ asset('js/debug-helpers.js') }}"></script>
<script>
    /* Instagram Aspect Ratio Detection Script */
    function setInstagramRatio(img) {
        const container = document.getElementById('imageContainer');
        if (!container || !img) return;
        
        // Wait for image to fully load
        if (img.complete && img.naturalHeight !== 0) {
            applyInstagramRatio(img, container);
        } else {
            img.onload = function() {
                applyInstagramRatio(img, container);
            };
        }
    }
    
    function applyInstagramRatio(img, container) {
        const width = img.naturalWidth;
        const height = img.naturalHeight;
        const aspectRatio = width / height;
        
        // Remove existing ratio classes
        container.classList.remove('square', 'landscape', 'portrait');
        
        // Instagram standard ratios:
        // Square: 1:1 (ratio = 1.0)
        // Landscape: 1.91:1 (ratio = 1.91)
        // Portrait: 4:5 (ratio = 0.8)
        
        if (Math.abs(aspectRatio - 1.0) < 0.1) {
            // Square post (1:1)
            container.classList.add('square');
            console.log('Applied Instagram Square ratio (1:1)');
        } else if (aspectRatio > 1.5) {
            // Landscape post (1.91:1)
            container.classList.add('landscape');
            console.log('Applied Instagram Landscape ratio (1.91:1)');
        } else if (aspectRatio < 1.0) {
            // Portrait post (4:5)
            container.classList.add('portrait');
            console.log('Applied Instagram Portrait ratio (4:5)');
        } else {
            // Default to square if ratio doesn't match standards
            container.classList.add('square');
            console.log('Applied default Instagram Square ratio');
        }
    }
    
    // Apply ratio on page load if image is already cached
    document.addEventListener('DOMContentLoaded', function() {
        const img = document.querySelector('#imageContainer img');
        if (img) {
            setInstagramRatio(img);
        }
    });
    
    document.addEventListener('DOMContentLoaded', function() {
        // Toggle edit comment forms
        document.querySelectorAll('.edit-comment-btn').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                const commentId = this.getAttribute('data-comment-id');
                const commentContent = document.getElementById(`comment-${commentId}`).querySelector('.comment-content');
                const editForm = document.getElementById(`edit-comment-form-${commentId}`);
                
                commentContent.classList.add('d-none');
                editForm.classList.remove('d-none');
                editForm.querySelector('textarea').focus();
            });
        });
        
        // Cancel edit comment
        document.querySelectorAll('.cancel-edit-btn').forEach(button => {
            button.addEventListener('click', function() {
                const editForm = this.closest('.edit-comment-form');
                const commentContent = editForm.previousElementSibling;
                
                editForm.classList.add('d-none');
                commentContent.classList.remove('d-none');
            });
        });
        
        // Toggle edit reply forms
        document.querySelectorAll('.edit-reply-btn').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                const replyId = this.getAttribute('data-reply-id');
                const replyContent = this.closest('.reply-item').querySelector('.reply-content');
                const editForm = document.getElementById(`edit-reply-form-${replyId}`);
                
                replyContent.classList.add('d-none');
                editForm.classList.remove('d-none');
                editForm.querySelector('textarea').focus();
            });
        });
        
        // Cancel edit reply
        document.querySelectorAll('.cancel-edit-reply-btn').forEach(button => {
            button.addEventListener('click', function() {
                const editForm = this.closest('.edit-reply-form');
                const replyContent = editForm.previousElementSibling;
                
                editForm.classList.add('d-none');
                replyContent.classList.remove('d-none');
            });
        });
        
        // Smooth scroll to comment when using anchor links
        if (window.location.hash) {
            const id = window.location.hash.substring(1);
            const element = document.getElementById(id);
            if (element) {
                element.scrollIntoView({ behavior: 'smooth' });
                element.classList.add('bounce-effect');
                setTimeout(() => {
                    element.classList.remove('bounce-effect');
                }, 500);
            }
        }
    });
</script>
@endsection
@endsection