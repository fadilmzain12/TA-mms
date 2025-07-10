@extends('layouts.app')

@section('title', 'Pendaftaran: Data Pribadi - Majelis Musyawarah Sunda')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <!-- Progress Steps -->
                <div class="mb-5">
                    <div class="position-relative d-flex justify-content-between mb-2">
                        <div class="position-relative d-flex align-items-center w-100">
                            <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center" style="width: 48px; height: 48px; z-index: 1;">
                                <span>1</span>
                            </div>
                            <div class="progress w-100" style="height: 2px;">
                                <div class="progress-bar" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                        <div class="position-relative d-flex align-items-center w-100">
                            <div class="rounded-circle bg-light text-muted d-flex align-items-center justify-content-center" style="width: 48px; height: 48px; z-index: 1;">
                                <span>2</span>
                            </div>
                            <div class="progress w-100" style="height: 2px;">
                                <div class="progress-bar" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                        <div class="position-relative d-flex align-items-center">
                            <div class="rounded-circle bg-light text-muted d-flex align-items-center justify-content-center" style="width: 48px; height: 48px; z-index: 1;">
                                <span>3</span>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between">
                        <div class="text-center fw-medium text-primary" style="width: 33%;">Data Pribadi</div>
                        <div class="text-center fw-medium text-muted" style="width: 33%;">Unggah Dokumen</div>
                        <div class="text-center fw-medium text-muted" style="width: 33%;">Konfirmasi</div>
                    </div>
                </div>

                <!-- Title and Description -->
                <div class="text-center mb-4">
                    <h1 class="h3 fw-bold text-primary mb-2">Data Pribadi</h1>
                    <p class="text-secondary">Silakan isi data pribadi Anda dengan lengkap dan benar</p>
                </div>

                <!-- Registration Form -->
                <div class="card shadow-sm mb-5">
                    <div class="card-body p-4">
                        <form action="{{ route('registration.step1') }}" method="POST">
                            @csrf

                            <div class="mb-4 border-bottom pb-4">
                                <h2 class="h5 fw-bold text-primary mb-3">Informasi Akun</h2>
                                
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label for="name" class="form-label">Nama Pengguna <span class="text-danger">*</span></label>
                                        <input type="text" id="name" name="name" value="{{ old('name') }}" class="form-control @error('name') is-invalid @enderror" required>
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                        <input type="email" id="email" name="email" value="{{ old('email') }}" class="form-control @error('email') is-invalid @enderror" required>
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label for="password" class="form-label">Kata Sandi <span class="text-danger">*</span></label>
                                        <div class="position-relative">
                                            <input type="password" id="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
                                            <button type="button" class="btn btn-link position-absolute top-50 end-0 translate-middle-y pe-3" onclick="togglePassword('password')" style="border: none; background: none; z-index: 10;">
                                                <i id="password-eye" class="fas fa-eye-slash text-muted"></i>
                                            </button>
                                        </div>
                                        @error('password')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label for="password_confirmation" class="form-label">Konfirmasi Kata Sandi <span class="text-danger">*</span></label>
                                        <div class="position-relative">
                                            <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" required>
                                            <button type="button" class="btn btn-link position-absolute top-50 end-0 translate-middle-y pe-3" onclick="togglePassword('password_confirmation')" style="border: none; background: none; z-index: 10;">
                                                <i id="password_confirmation-eye" class="fas fa-eye-slash text-muted"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-4">
                                <h2 class="h5 fw-bold text-primary mb-3">Data Pribadi</h2>
                                
                                <div class="row g-3">
                                    <div class="col-12">
                                        <label for="full_name" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                                        <input type="text" id="full_name" name="full_name" value="{{ old('full_name') }}" class="form-control @error('full_name') is-invalid @enderror" required>
                                        @error('full_name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label for="nik" class="form-label">NIK (16 Digit) <span class="text-danger">*</span></label>
                                        <input type="text" id="nik" name="nik" value="{{ old('nik') }}" class="form-control @error('nik') is-invalid @enderror" required maxlength="16" pattern="[0-9]{16}">
                                        @error('nik')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label for="phone" class="form-label">Nomor Telepon <span class="text-danger">*</span></label>
                                        <input type="tel" id="phone" name="phone" value="{{ old('phone') }}" class="form-control @error('phone') is-invalid @enderror" required>
                                        @error('phone')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label for="birth_place" class="form-label">Tempat Lahir <span class="text-danger">*</span></label>
                                        <input type="text" id="birth_place" name="birth_place" value="{{ old('birth_place') }}" class="form-control @error('birth_place') is-invalid @enderror" required>
                                        @error('birth_place')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label for="birth_date" class="form-label">Tanggal Lahir <span class="text-danger">*</span></label>
                                        <input type="date" id="birth_date" name="birth_date" value="{{ old('birth_date') }}" class="form-control @error('birth_date') is-invalid @enderror" required>
                                        @error('birth_date')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label d-block">Jenis Kelamin <span class="text-danger">*</span></label>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="gender" id="gender_male" value="male" {{ old('gender') == 'male' ? 'checked' : '' }} required>
                                            <label class="form-check-label" for="gender_male">Laki-laki</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="gender" id="gender_female" value="female" {{ old('gender') == 'female' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="gender_female">Perempuan</label>
                                        </div>
                                        @error('gender')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-12">
                                        <label for="address" class="form-label">Alamat <span class="text-danger">*</span></label>
                                        <textarea id="address" name="address" rows="3" class="form-control @error('address') is-invalid @enderror" required>{{ old('address') }}</textarea>
                                        @error('address')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label for="city" class="form-label">Kota <span class="text-danger">*</span></label>
                                        <input type="text" id="city" name="city" value="{{ old('city') }}" class="form-control @error('city') is-invalid @enderror" required>
                                        @error('city')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label for="occupation" class="form-label">Pekerjaan <span class="text-danger">*</span></label>
                                        <input type="text" id="occupation" name="occupation" value="{{ old('occupation') }}" class="form-control @error('occupation') is-invalid @enderror" required>
                                        @error('occupation')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label for="job_title" class="form-label">Jabatan</label>
                                        <input type="text" id="job_title" name="job_title" value="{{ old('job_title') }}" class="form-control @error('job_title') is-invalid @enderror">
                                        @error('job_title')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="text-center">
                                <button type="submit" class="btn btn-primary px-4 py-2">Lanjut ke Langkah Berikutnya</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function togglePassword(fieldId) {
            const passwordField = document.getElementById(fieldId);
            const eyeIcon = document.getElementById(fieldId + '-eye');
            
            if (passwordField.type === 'password') {
                // Tampilkan password (mata terbuka)
                passwordField.type = 'text';
                eyeIcon.classList.remove('fa-eye-slash');
                eyeIcon.classList.add('fa-eye');
            } else {
                // Sembunyikan password (mata tertutup/dicoret)
                passwordField.type = 'password';
                eyeIcon.classList.remove('fa-eye');
                eyeIcon.classList.add('fa-eye-slash');
            }
        }
    </script>
@endsection