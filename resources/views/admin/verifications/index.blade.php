@extends('admin.layouts.app')

@section('title', 'Verifikasi Pendaftaran - Admin MMS')

@section('content')
<div class="container-fluid">
    <!-- Admin Header -->
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <div>
            <h1 class="h2">Manajemen Verifikasi</h1>
            <p class="text-muted">Kelola dan verifikasi pendaftaran anggota baru</p>
        </div>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
                <a href="{{ route('admin.verifications.index') }}" class="btn btn-sm btn-primary">Menunggu Verifikasi</a>
                <a href="{{ route('admin.verifications.verified') }}" class="btn btn-sm btn-outline-secondary">Terverifikasi</a>
                <a href="{{ route('admin.verifications.rejected') }}" class="btn btn-sm btn-outline-secondary">Ditolak</a>
            </div>
        </div>
    </div>

    <!-- Filters and Search -->
    <div class="card card-admin shadow mb-4">
        <div class="card-body">
            <form action="{{ route('admin.verifications.index') }}" method="GET">
                <div class="row g-3 align-items-end">
                    <div class="col-md">
                        <label for="search" class="form-label">Cari</label>
                        <input type="text" id="search" name="search" value="{{ request('search') }}" class="form-control" placeholder="Nama, Email, NIK atau No. Registrasi">
                    </div>
                    <div class="col-md-2">
                        <label for="date_from" class="form-label">Dari Tanggal</label>
                        <input type="date" id="date_from" name="date_from" value="{{ request('date_from') }}" class="form-control">
                    </div>
                    <div class="col-md-2">
                        <label for="date_to" class="form-label">Sampai Tanggal</label>
                        <input type="date" id="date_to" name="date_to" value="{{ request('date_to') }}" class="form-control">
                    </div>
                    <div class="col-md-auto">
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">Filter</button>
                            <a href="{{ route('admin.verifications.index') }}" class="btn btn-secondary">Reset</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Results Stats -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <p class="text-muted">Menampilkan <span class="fw-medium">{{ $registrations->firstItem() ?? 0 }}</span> - <span class="fw-medium">{{ $registrations->lastItem() ?? 0 }}</span> dari <span class="fw-medium">{{ $registrations->total() }}</span> pendaftar</p>
        <span class="badge bg-warning rounded-pill">{{ $registrations->total() }} menunggu verifikasi</span>
    </div>

    <!-- Registration Table -->
    <div class="card card-admin shadow mb-4">
        <div class="card-body p-0">
            @if($registrations->isEmpty())
                <div class="p-5 text-center">
                    <i class="bi bi-file-earmark-text fs-1 text-muted mb-3"></i>
                    <h4 class="text-primary mb-2">Tidak Ada Data</h4>
                    <p class="text-muted mb-0">Tidak ada pendaftar yang menunggu verifikasi saat ini.</p>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>No. Registrasi</th>
                                <th>Nama Lengkap</th>
                                <th>Email</th>
                                <th>NIK</th>
                                <th>Tanggal Daftar</th>
                                <th>Status</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($registrations as $registration)
                                <tr>
                                    <td class="fw-medium text-primary">{{ $registration->registration_number }}</td>
                                    <td>{{ $registration->member->full_name }}</td>
                                    <td>{{ $registration->member->user->email }}</td>
                                    <td>{{ $registration->member->nik }}</td>
                                    <td>{{ $registration->submitted_at->format('d M Y H:i') }}</td>
                                    <td>
                                        <span class="badge bg-warning">Menunggu Verifikasi</span>
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('admin.verifications.show', $registration->id) }}" class="btn btn-sm btn-primary">
                                            <i class="bi bi-eye me-1"></i> Detail
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>

    <!-- Pagination -->
    <div class="mt-4">
        {{ $registrations->links('pagination::bootstrap-5') }}
    </div>
</div>
@endsection