@extends('admin.layouts.app')

@section('title', 'Detail Kategori Kegiatan')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Detail Kategori: {{ $category->name }}</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('admin.activity-categories.edit', $category->id) }}" class="btn btn-sm btn-outline-primary me-2">
            <i class="bi bi-pencil"></i> Edit
        </a>
        <a href="{{ route('admin.activity-categories.index') }}" class="btn btn-sm btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-4">
        <div class="card card-admin shadow-sm mb-4">
            <div class="card-body">
                <h5 class="card-title">Informasi Kategori</h5>
                <hr>
                <div class="mb-2">
                    <strong>Nama:</strong>
                    <p>{{ $category->name }}</p>
                </div>
                <div class="mb-2">
                    <strong>Deskripsi:</strong>
                    <p>{{ $category->description ?: '-' }}</p>
                </div>                <div class="mb-2">
                    <strong>Warna:</strong>
                    <div class="d-flex align-items-center">
                        <div id="color-preview" class="me-2" style="width: 25px; height: 25px; border-radius: 6px;">
                            &nbsp;
                        </div>
                        <span>{{ $category->color }}</span>
                    </div>
                </div>

                @section('scripts')
                @parent
                <script>
                    // Apply the color using JavaScript instead - this should avoid editor validation issues
                    document.getElementById('color-preview').style.backgroundColor = '{{ $category->color }}';
                </script>
                @endsection
                <div class="mb-2">
                    <strong>Jumlah Kegiatan:</strong>
                    <p>{{ $category->activities->count() }}</p>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-8">
        <div class="card card-admin shadow-sm">
            <div class="card-body">
                <h5 class="card-title">Daftar Kegiatan dalam Kategori Ini</h5>
                <hr>
                
                @if($category->activities->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead>
                                <tr>
                                    <th scope="col">Judul</th>
                                    <th scope="col">Admin</th>
                                    <th scope="col">Tanggal</th>
                                    <th scope="col" class="text-end">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($category->activities as $activity)
                                    <tr>
                                        <td>{{ $activity->title }}</td>
                                        <td>{{ $activity->user->name }}</td>
                                        <td>{{ $activity->created_at->format('d M Y') }}</td>
                                        <td class="text-end">
                                            <a href="{{ route('activities.show', $activity->id) }}" class="btn btn-sm btn-outline-primary" target="_blank">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="bi bi-folder2-open display-4 text-muted"></i>
                        <p class="mt-3 text-muted">Belum ada kegiatan dalam kategori ini.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
