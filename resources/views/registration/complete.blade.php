@extends('layouts.app')

@section('title', 'Pendaftaran Berhasil - Majelis Musyawarah Sunda')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card text-center">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-center mb-4">
                            <div class="rounded-circle bg-success bg-opacity-25 p-3">
                                <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" fill="currentColor" class="bi bi-check2 text-success" viewBox="0 0 16 16">
                                    <path d="M13.854 3.646a.5.5 0 0 1 0 .708l-7 7a.5.5 0 0 1-.708 0l-3.5-3.5a.5.5 0 1 1 .708-.708L6.5 10.293l6.646-6.647a.5.5 0 0 1 .708 0z"/>
                                </svg>
                            </div>
                        </div>
                        
                        <h1 class="h3 fw-bold text-primary mb-3">Pendaftaran Berhasil!</h1>
                        <p class="text-secondary fs-5 mb-4">Terima kasih telah mendaftar sebagai anggota Majelis Musyawarah Sunda.</p>
                        
                        <div class="bg-light rounded p-4 border mb-4">
                            <div class="d-flex flex-column align-items-center">
                                <p class="text-secondary">Nomor Registrasi Anda:</p>
                                <p class="fs-3 fw-bold text-primary">{{ $registration_number }}</p>
                                <p class="small text-muted">Harap simpan nomor registrasi ini untuk keperluan selanjutnya</p>
                            </div>
                        </div>
                        
                        <div class="bg-primary bg-opacity-10 rounded p-4 border border-primary border-opacity-25 mb-4">
                            <h2 class="h5 fw-bold text-primary mb-3">Langkah Selanjutnya</h2>
                            <div class="mb-3">
                                <div class="d-flex mb-3">
                                    <div class="flex-shrink-0">
                                        <div class="d-flex align-items-center justify-content-center rounded-circle bg-primary text-white fw-bold" style="width: 32px; height: 32px;">
                                            1
                                        </div>
                                    </div>
                                    <div class="ms-3">
                                        <h3 class="h6 fw-bold text-primary">Verifikasi Administrasi</h3>
                                        <p class="text-secondary">Tim kami akan melakukan verifikasi data dan dokumen yang Anda unggah. Proses ini biasanya membutuhkan waktu 3-5 hari kerja.</p>
                                    </div>
                                </div>
                                <div class="d-flex mb-3">
                                    <div class="flex-shrink-0">
                                        <div class="d-flex align-items-center justify-content-center rounded-circle bg-primary text-white fw-bold" style="width: 32px; height: 32px;">
                                            2
                                        </div>
                                    </div>
                                    <div class="ms-3">
                                        <h3 class="h6 fw-bold text-primary">Konfirmasi Email</h3>
                                        <p class="text-secondary">Anda akan menerima email konfirmasi setelah verifikasi berhasil. Harap periksa email Anda secara berkala, termasuk folder spam.</p>
                                    </div>
                                </div>
                                <div class="d-flex">
                                    <div class="flex-shrink-0">
                                        <div class="d-flex align-items-center justify-content-center rounded-circle bg-primary text-white fw-bold" style="width: 32px; height: 32px;">
                                            3
                                        </div>
                                    </div>
                                    <div class="ms-3">
                                        <h3 class="h6 fw-bold text-primary">Aktivasi Keanggotaan</h3>
                                        <p class="text-secondary">Setelah diverifikasi, keanggotaan Anda akan diaktifkan dan Anda akan diberikan akses penuh ke platform anggota kami.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="d-flex justify-content-center gap-2">
                            <a href="{{ route('login') }}" class="btn btn-primary">Masuk ke Akun</a>
                            <a href="{{ url('/') }}" class="btn btn-outline-secondary">Kembali ke Beranda</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection