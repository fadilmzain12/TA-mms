@extends('member.layouts.app')

@section('title', 'Profil Saya')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Profil Saya</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-2">
            <button type="button" class="btn btn-sm btn-outline-secondary" onclick="window.print()">
                <i class="bi bi-printer"></i> Cetak Profil
            </button>
        </div>
    </div>
</div>

<div class="row">
    <!-- Profile Photo Section -->
    <div class="col-md-4">
        <div class="card card-member shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold">Foto Profil</h6>
            </div>
            <div class="card-body text-center">
                <!-- Profile Photo -->
                <div class="mb-3">
                    @if ($photoDocument)
                        <img src="{{ asset('storage/' . $photoDocument->file_path) }}" 
                             class="img-fluid rounded-circle profile-img" 
                             alt="Foto Profil"
                             style="width: 150px; height: 150px; object-fit: cover; border: 3px solid #6610f2;">
                    @else
                        <div class="no-photo-placeholder rounded-circle mx-auto d-flex align-items-center justify-content-center" 
                             style="width: 150px; height: 150px; background-color: #e9ecef; border: 3px solid #6610f2;">
                            <i class="bi bi-person-fill fs-1 text-secondary"></i>
                        </div>
                    @endif
                </div>

                <!-- Member Status Badge -->
                <div class="mb-3">
                    <span class="badge {{ $member->status == 'active' ? 'status-active' : ($member->status == 'pending' ? 'status-pending' : ($member->status == 'rejected' ? 'status-rejected' : 'status-inactive')) }}">
                        {{ $member->status == 'active' ? 'Aktif' : ($member->status == 'pending' ? 'Menunggu' : ($member->status == 'rejected' ? 'Ditolak' : 'Tidak Aktif')) }}
                    </span>
                </div>

                <!-- Rejection Reason (if rejected) -->
                @if($member->status == 'rejected' && $registration && $registration->rejection_reason)
                    <div class="alert alert-danger mb-3" role="alert">
                        <h6 class="alert-heading mb-2">
                            <i class="bi bi-exclamation-triangle-fill me-1"></i>
                            Alasan Penolakan:
                        </h6>
                        <p class="mb-0">{{ $registration->rejection_reason }}</p>
                    </div>
                @endif

                <h5 class="card-title">{{ $member->full_name }}</h5>
                <p class="card-text text-muted">{{ $member->registration_number }}</p>

                <!-- Member Card Button -->
                @if ($member->status == 'active')
                    <a href="{{ route('member.card') }}" class="btn btn-primary">
                        <i class="bi bi-credit-card"></i> Lihat Kartu Anggota
                    </a>
                @endif
            </div>
        </div>

        <!-- Upload Photo Form -->
        <div class="card card-member shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold">Perbarui Foto Profil</h6>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('member.profile.update-photo') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="photo" class="form-label">Pilih Foto Baru</label>
                        <input type="file" class="form-control @error('photo') is-invalid @enderror" id="photo" name="photo">
                        @error('photo')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">Ukuran yang disarankan: 300x300 piksel. Ukuran maksimal: 2MB. Format: JPG, PNG.</div>
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-success">
                            <i class="bi bi-upload"></i> Perbarui Foto
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- KTP Photo Section -->
        <div class="card card-member shadow">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold">Foto KTP</h6>
            </div>
            <div class="card-body">
                <!-- Display KTP Photo -->
                <div class="mb-3 text-center">
                    @if ($ktpDocument)
                        <img src="{{ asset('storage/' . $ktpDocument->file_path) }}" 
                             class="img-fluid rounded border" 
                             alt="Foto KTP"
                             style="max-width: 100%; max-height: 200px; object-fit: contain;">
                        <div class="mt-2">
                            <small class="text-muted">
                                Diunggah: {{ $ktpDocument->created_at->format('d M Y, H:i') }}
                            </small>
                        </div>
                    @else
                        <div class="no-ktp-placeholder border rounded p-4 text-center" style="background-color: #f8f9fa;">
                            <i class="bi bi-card-text fs-1 text-secondary"></i>
                            <p class="mt-2 text-muted">Foto KTP belum diunggah</p>
                        </div>
                    @endif
                </div>

                <!-- Upload KTP Form -->
                <form method="POST" action="{{ route('member.profile.update-ktp') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="ktp" class="form-label">Pilih Foto KTP</label>
                        <input type="file" class="form-control @error('ktp') is-invalid @enderror" id="ktp" name="ktp">
                        @error('ktp')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">Foto kartu identitas yang jelas. Ukuran maksimal: 3MB. Format: JPG, PNG.</div>
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-upload"></i> {{ $ktpDocument ? 'Perbarui Foto KTP' : 'Unggah Foto KTP' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Member Information -->
    <div class="col-md-8">
        <div class="card card-member shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold">Informasi Pribadi</h6>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-4 fw-bold">Nama Lengkap</div>
                    <div class="col-md-8">{{ $member->full_name }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4 fw-bold">NIK</div>
                    <div class="col-md-8">{{ $member->nik }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4 fw-bold">Tempat/Tanggal Lahir</div>
                    <div class="col-md-8">{{ $member->birth_place }}, {{ $member->birth_date->format('d F Y') }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4 fw-bold">Jenis Kelamin</div>
                    <div class="col-md-8">{{ $member->gender == 'male' ? 'Laki-laki' : 'Perempuan' }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4 fw-bold">No. Telepon</div>
                    <div class="col-md-8">{{ $member->phone }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4 fw-bold">Alamat</div>
                    <div class="col-md-8">{{ $member->address }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4 fw-bold">Kota</div>
                    <div class="col-md-8">{{ $member->city ?? 'Tidak disebutkan' }}</div>
                </div>
            </div>
        </div>

        <div class="card card-member shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold">Informasi Keanggotaan</h6>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-4 fw-bold">Nomor Registrasi</div>
                    <div class="col-md-8">{{ $member->registration_number }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4 fw-bold">Divisi</div>
                    <div class="col-md-8">{{ $member->division->name ?? 'Belum ditentukan' }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4 fw-bold">Jabatan</div>
                    <div class="col-md-8">{{ $member->position->name ?? 'Belum ditentukan' }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4 fw-bold">Pekerjaan</div>
                    <div class="col-md-8">{{ $member->occupation }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4 fw-bold">Posisi Pekerjaan</div>
                    <div class="col-md-8">{{ $member->job_title ?? '-' }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4 fw-bold">Tanggal Daftar</div>
                    <div class="col-md-8">{{ $member->created_at->format('d F Y') }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4 fw-bold">Status</div>
                    <div class="col-md-8">
                        <span class="badge {{ $member->status == 'active' ? 'status-active' : ($member->status == 'pending' ? 'status-pending' : ($member->status == 'rejected' ? 'status-rejected' : 'status-inactive')) }}">
                            {{ $member->status == 'active' ? 'Aktif' : ($member->status == 'pending' ? 'Menunggu' : ($member->status == 'rejected' ? 'Ditolak' : 'Tidak Aktif')) }}
                        </span>
                    </div>
                </div>
                @if($member->status == 'rejected' && $registration && $registration->rejection_reason)
                <div class="row mb-3">
                    <div class="col-md-4 fw-bold text-danger">Alasan Penolakan</div>
                    <div class="col-md-8">
                        <div class="alert alert-danger py-2 px-3 mb-0">
                            <small>{{ $registration->rejection_reason }}</small>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection