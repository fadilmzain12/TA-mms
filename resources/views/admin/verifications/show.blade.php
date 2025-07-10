@extends('admin.layouts.app')

@section('title', 'Verifikasi Pendaftaran')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Detail Verifikasi Pendaftaran</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('admin.verifications.index') }}" class="btn btn-sm btn-outline-secondary">
            <i class="bi bi-arrow-left me-1"></i> Kembali ke Daftar
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card card-admin shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Informasi Anggota</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <tr>
                            <th width="30%">Nomor Registrasi</th>
                            <td>{{ $registration->registration_number }}</td>
                        </tr>
                        <tr>
                            <th>Nama Lengkap</th>
                            <td>{{ $registration->member->full_name }}</td>
                        </tr>
                        <tr>
                            <th>NIK</th>
                            <td>{{ $registration->member->nik }}</td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td>{{ $registration->member->user->email }}</td>
                        </tr>
                        <tr>
                            <th>Telepon</th>
                            <td>{{ $registration->member->phone }}</td>
                        </tr>
                        <tr>
                            <th>Alamat</th>
                            <td>{{ $registration->member->address }}</td>
                        </tr>
                        <tr>
                            <th>Kota</th>
                            <td>{{ $registration->member->city ?? 'Tidak tercantum' }}</td>
                        </tr>
                        <tr>
                            <th>Jenis Kelamin</th>
                            <td>{{ $registration->member->gender == 'male' ? 'Laki-laki' : 'Perempuan' }}</td>
                        </tr>
                        <tr>
                            <th>Tempat, Tanggal Lahir</th>
                            <td>{{ $registration->member->birth_place }}, {{ $registration->member->birth_date ? $registration->member->birth_date->format('d F Y') : 'Tanggal tidak tersedia' }}</td>
                        </tr>
                        <tr>
                            <th>Pekerjaan</th>
                            <td>{{ $registration->member->occupation }}</td>
                        </tr>
                        <tr>
                            <th>Jabatan</th>
                            <td>{{ $registration->member->job_title ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Status Pendaftaran</th>
                            <td>
                                @if($registration->status == 'submitted')
                                    <span class="badge bg-warning">Menunggu Verifikasi</span>
                                @elseif($registration->status == 'verified')
                                    <span class="badge bg-success">Terverifikasi</span>
                                @elseif($registration->status == 'rejected')
                                    <span class="badge bg-danger">Ditolak</span>
                                @else
                                    <span class="badge bg-secondary">{{ $registration->status }}</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Tanggal Pendaftaran</th>
                            <td>{{ $registration->submitted_at ? $registration->submitted_at->format('d F Y H:i') : 'Tanggal tidak tersedia' }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-6">
        <!-- KTP Document Section -->
        <div class="card card-admin shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Dokumen KTP</h6>
            </div>
            <div class="card-body">
                @php
                    $ktpDocument = $registration->member->documents->where('type', 'ktp')->first();
                @endphp
                
                @if($ktpDocument)
                    <div class="document-preview mb-3">
                        @if(in_array(pathinfo($ktpDocument->file_path, PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png', 'gif']))
                            <img src="{{ Storage::url($ktpDocument->file_path) }}" class="img-fluid img-thumbnail" alt="KTP">
                        @else
                            <div class="p-3 bg-light rounded text-center">
                                <i class="bi bi-file-earmark-text fs-1 text-primary"></i>
                                <p class="mt-2 mb-0">{{ $ktpDocument->original_name ?? $ktpDocument->file_name }}</p>
                                <a href="{{ Storage::url($ktpDocument->file_path) }}" target="_blank" class="btn btn-sm btn-primary mt-2">
                                    <i class="bi bi-eye me-1"></i> Lihat Dokumen
                                </a>
                            </div>
                        @endif
                    </div>
                @else
                    <div class="alert alert-warning">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i>
                        Anggota belum mengunggah dokumen KTP
                    </div>
                @endif
            </div>
        </div>
        
        <!-- Photo Document Section -->
        <div class="card card-admin shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Foto Anggota</h6>
            </div>
            <div class="card-body">
                @php
                    $photoDocument = $registration->member->documents->where('type', 'photo')->first();
                @endphp
                
                @if($photoDocument)
                    <div class="text-center">
                        <img src="{{ Storage::url($photoDocument->file_path) }}" class="img-fluid img-thumbnail" style="max-height: 200px;" alt="Foto Anggota">
                    </div>
                @else
                    <div class="alert alert-warning">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i>
                        Anggota belum mengunggah foto
                    </div>
                @endif
            </div>
        </div>

        <!-- Verification Actions -->
        <div class="card card-admin shadow">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Tindakan Verifikasi</h6>
            </div>
            <div class="card-body">
                @if($registration->status == 'submitted')
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <button type="button" class="btn btn-success w-100" data-bs-toggle="modal" data-bs-target="#verifyModal">
                                <i class="bi bi-check-circle me-1"></i> Verifikasi Pendaftaran
                            </button>
                        </div>
                        <div class="col-md-6 mb-3">
                            <button type="button" class="btn btn-danger w-100" data-bs-toggle="modal" data-bs-target="#rejectModal">
                                <i class="bi bi-x-circle me-1"></i> Tolak Pendaftaran
                            </button>
                        </div>
                    </div>
                @elseif($registration->status == 'verified')
                    <div class="alert alert-success mb-0">
                        <i class="bi bi-check-circle-fill me-2"></i>
                        Pendaftaran sudah diverifikasi pada {{ $registration->verified_at ? $registration->verified_at->format('d F Y H:i') : 'waktu tidak tersedia' }} oleh {{ $registration->verifier->name ?? 'Admin' }}
                        @if($registration->verification_notes)
                            <div class="mt-2 p-2 bg-light rounded">
                                <strong>Catatan:</strong> {{ $registration->verification_notes }}
                            </div>
                        @endif
                    </div>
                @elseif($registration->status == 'rejected')
                    <div class="alert alert-danger mb-0">
                        <i class="bi bi-x-circle-fill me-2"></i>
                        Pendaftaran ditolak
                        @if($registration->rejection_reason)
                            <div class="mt-2 p-2 bg-light rounded">
                                <strong>Alasan Penolakan:</strong> {{ $registration->rejection_reason }}
                            </div>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Verify Modal -->
<div class="modal fade" id="verifyModal" tabindex="-1" aria-labelledby="verifyModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('admin.verifications.verify', $registration->id) }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="verifyModalLabel">Verifikasi Pendaftaran</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Anda yakin ingin memverifikasi pendaftaran ini?</p>
                    <div class="mb-3">
                        <label for="verification_notes" class="form-label">Catatan Verifikasi (opsional)</label>
                        <textarea class="form-control" id="verification_notes" name="verification_notes" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success">Verifikasi</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Reject Modal -->
<div class="modal fade" id="rejectModal" tabindex="-1" aria-labelledby="rejectModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('admin.verifications.reject', $registration->id) }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="rejectModalLabel">Tolak Pendaftaran</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Anda yakin ingin menolak pendaftaran ini?</p>
                    <div class="mb-3">
                        <label for="rejection_reason" class="form-label">Alasan Penolakan <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="rejection_reason" name="rejection_reason" rows="3" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger">Tolak Pendaftaran</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection