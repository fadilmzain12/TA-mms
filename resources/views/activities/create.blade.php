@extends('admin.layouts.app')

@section('title', 'Tambah Kegiatan Baru')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/dashboard-layout-fixes.css') }}">
<link rel="stylesheet" href="{{ asset('css/scroll-override.css') }}">
@endsection

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Tambah Kegiatan Baru</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('activities.index') }}" class="btn btn-outline-secondary btn-sm">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>
</div>

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Tambah Kegiatan Baru</h5>
                </div>
                
                <div class="card-body">
                    <form action="{{ route('activities.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="mb-3">
                            <label for="title" class="form-label">Judul Kegiatan <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title') }}" required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                          <div class="mb-3">
                            <label for="category_id" class="form-label">Kategori Kegiatan</label>
                            <select class="form-select @error('category_id') is-invalid @enderror" id="category_id" name="category_id">
                                <option value="">-- Pilih Kategori --</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Opsional - Pilih kategori yang sesuai untuk kegiatan ini</div>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Deskripsi Kegiatan <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="5" required>{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-4">
                            <label for="image" class="form-label">Foto Kegiatan (Opsional)</label>
                            <input type="file" class="form-control @error('image') is-invalid @enderror" id="image" name="image" accept="image/*">
                            <div class="form-text">Format yang didukung: JPG, PNG, GIF (maks. 2MB)</div>
                            @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="{{ route('activities.index') }}" class="btn btn-outline-secondary me-md-2">Batalkan</a>
                            <button type="submit" class="btn btn-primary">Publikasikan Kegiatan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection