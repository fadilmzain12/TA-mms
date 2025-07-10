@extends('layouts.app')

@section('title', 'Pendaftaran: Konfirmasi - Majelis Musyawarah Sunda')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <!-- Progress Steps -->
                <div class="mb-5">
                    <div class="position-relative d-flex justify-content-between mb-2">
                        <div class="position-relative d-flex align-items-center w-100">
                            <div class="rounded-circle bg-success text-white d-flex align-items-center justify-content-center" style="width: 48px; height: 48px; z-index: 1;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-check-lg" viewBox="0 0 16 16">
                                    <path d="M12.736 3.97a.733.733 0 0 1 1.047 0c.286.289.29.756.01 1.05L7.88 12.01a.733.733 0 0 1-1.065.02L3.217 8.384a.757.757 0 0 1 0-1.06.733.733 0 0 1 1.047 0l3.052 3.093 5.4-6.425a.247.247 0 0 1 .02-.022Z"/>
                                </svg>
                            </div>
                            <div class="progress w-100" style="height: 2px;">
                                <div class="progress-bar bg-success" role="progressbar" style="width: 100%;" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                        <div class="position-relative d-flex align-items-center w-100">
                            <div class="rounded-circle bg-success text-white d-flex align-items-center justify-content-center" style="width: 48px; height: 48px; z-index: 1;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-check-lg" viewBox="0 0 16 16">
                                    <path d="M12.736 3.97a.733.733 0 0 1 1.047 0c.286.289.29.756.01 1.05L7.88 12.01a.733.733 0 0 1-1.065.02L3.217 8.384a.757.757 0 0 1 0-1.06.733.733 0 0 1 1.047 0l3.052 3.093 5.4-6.425a.247.247 0 0 1 .02-.022Z"/>
                                </svg>
                            </div>
                            <div class="progress w-100" style="height: 2px;">
                                <div class="progress-bar bg-success" role="progressbar" style="width: 100%;" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                        <div class="position-relative d-flex align-items-center">
                            <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center" style="width: 48px; height: 48px; z-index: 1;">
                                <span>3</span>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between">
                        <div class="text-center fw-medium text-success" style="width: 33%;">Data Pribadi</div>
                        <div class="text-center fw-medium text-success" style="width: 33%;">Unggah Dokumen</div>
                        <div class="text-center fw-medium text-primary" style="width: 33%;">Konfirmasi</div>
                    </div>
                </div>

                <!-- Title and Description -->
                <div class="text-center mb-4">
                    <h1 class="h3 fw-bold text-primary mb-2">Konfirmasi Pendaftaran</h1>
                    <p class="text-secondary">Silakan periksa data Anda dan konfirmasi pendaftaran</p>
                </div>

                <!-- Confirmation Form -->
                <div class="card shadow-sm mb-5">
                    <div class="card-body p-4">
                        <form action="{{ route('registration.step3') }}" method="POST">
                            @csrf

                            <!-- Personal Information Summary -->
                            <div class="mb-4">
                                <h2 class="h5 fw-bold text-primary mb-3 d-flex align-items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-person-fill me-2 text-primary" viewBox="0 0 16 16">
                                        <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3Zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z"/>
                                    </svg>
                                    Ringkasan Data Pribadi
                                </h2>
                                
                                <div class="bg-light rounded p-4 border">
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <div class="d-flex flex-column">
                                                <span class="small text-muted">Nama Lengkap</span>
                                                <span class="fw-medium">{{ $member->full_name }}</span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="d-flex flex-column">
                                                <span class="small text-muted">NIK</span>
                                                <span class="fw-medium">{{ $member->nik }}</span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="d-flex flex-column">
                                                <span class="small text-muted">Tempat, Tanggal Lahir</span>
                                                <span class="fw-medium">{{ $member->birth_place }}, {{ $member->birth_date->format('d F Y') }}</span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="d-flex flex-column">
                                                <span class="small text-muted">Jenis Kelamin</span>
                                                <span class="fw-medium">{{ $member->gender == 'male' ? 'Laki-laki' : 'Perempuan' }}</span>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="d-flex flex-column">
                                                <span class="small text-muted">Alamat</span>
                                                <span class="fw-medium">{{ $member->address }}</span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="d-flex flex-column">
                                                <span class="small text-muted">Telepon</span>
                                                <span class="fw-medium">{{ $member->phone }}</span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="d-flex flex-column">
                                                <span class="small text-muted">Email</span>
                                                <span class="fw-medium">{{ $member->user->email }}</span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="d-flex flex-column">
                                                <span class="small text-muted">Pekerjaan</span>
                                                <span class="fw-medium">{{ $member->occupation }}</span>
                                            </div>
                                        </div>
                                        @if($member->job_title)
                                        <div class="col-md-6">
                                            <div class="d-flex flex-column">
                                                <span class="small text-muted">Jabatan</span>
                                                <span class="fw-medium">{{ $member->job_title }}</span>
                                            </div>
                                        </div>
                                        @endif
                                        <div class="col-12">
                                            <div class="d-flex flex-column">
                                                <span class="small text-muted">Nomor Registrasi</span>
                                                <span class="fw-medium text-primary">{{ $member->registration_number }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Document Summary -->
                            <div class="mb-4">
                                <h2 class="h5 fw-bold text-primary mb-3 d-flex align-items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-file-earmark-text me-2 text-primary" viewBox="0 0 16 16">
                                        <path d="M5.5 7a.5.5 0 0 0 0 1h5a.5.5 0 0 0 0-1h-5zM5 9.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm0 2a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5z"/>
                                        <path d="M9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V4.5L9.5 0zm0 1v2A1.5 1.5 0 0 0 11 4.5h2V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h5.5z"/>
                                    </svg>
                                    Dokumen yang Diunggah
                                </h2>
                                
                                <div class="bg-light rounded p-4 border">
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <div class="d-flex align-items-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-check-circle-fill text-success me-2" viewBox="0 0 16 16">
                                                    <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
                                                </svg>
                                                <span>Kartu Tanda Penduduk (KTP)</span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="d-flex align-items-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-check-circle-fill text-success me-2" viewBox="0 0 16 16">
                                                    <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
                                                </svg>
                                                <span>Pas Foto</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Terms and Conditions -->
                            <div class="mb-4">
                                <h2 class="h5 fw-bold text-primary mb-3 d-flex align-items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-info-circle me-2 text-primary" viewBox="0 0 16 16">
                                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                        <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/>
                                    </svg>
                                    Syarat dan Ketentuan
                                </h2>
                                
                                <div class="bg-light rounded p-4 border mb-3" style="height: 250px; overflow-y: auto;">
                                    <h3 class="fw-bold text-primary mb-3">SYARAT DAN KETENTUAN KEANGGOTAAN MAJELIS MUSYAWARAH SUNDA</h3>
                                    
                                    <p class="mb-3">Dengan ini saya sebagai calon anggota Majelis Musyawarah Sunda (MMS) menyatakan:</p>
                                    
                                    <ol class="ps-3">
                                        <li class="mb-2">Bahwa semua data dan dokumen yang saya berikan adalah benar dan dapat dipertanggungjawabkan.</li>
                                        <li class="mb-2">Bersedia mematuhi semua peraturan dan tata tertib yang berlaku di Majelis Musyawarah Sunda.</li>
                                        <li class="mb-2">Bersedia berpartisipasi aktif dalam kegiatan-kegiatan yang diselenggarakan oleh Majelis Musyawarah Sunda.</li>
                                        <li class="mb-2">Bersedia menjunjung tinggi dan melestarikan nilai-nilai budaya Sunda.</li>
                                        <li class="mb-2">Bersedia membayar iuran keanggotaan sesuai dengan ketentuan yang berlaku.</li>
                                        <li class="mb-2">Bersedia untuk tidak menyalahgunakan keanggotaan Majelis Musyawarah Sunda untuk kepentingan pribadi yang dapat merugikan organisasi.</li>
                                        <li class="mb-2">Majelis Musyawarah Sunda berhak mencabut keanggotaan apabila saya melanggar peraturan dan tata tertib yang berlaku.</li>
                                        <li class="mb-2">Majelis Musyawarah Sunda berhak menggunakan data dan informasi saya untuk kepentingan organisasi sesuai dengan ketentuan yang berlaku.</li>
                                    </ol>
                                </div>
                                
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="terms_accepted" name="terms_accepted" required>
                                    <label class="form-check-label" for="terms_accepted">
                                        Saya telah membaca dan menyetujui syarat dan ketentuan keanggotaan Majelis Musyawarah Sunda
                                    </label>
                                    @error('terms_accepted')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="d-flex justify-content-between mt-4">
                                <a href="{{ route('registration.step2') }}" class="btn btn-outline-secondary">Kembali</a>
                                <button type="submit" class="btn btn-primary">Selesaikan Pendaftaran</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection