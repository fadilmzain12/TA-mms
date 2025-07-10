@extends('layouts.app')

@section('title', 'Pendaftaran: Unggah Dokumen - Majelis Musyawarah Sunda')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <!-- Progress Steps -->
                <div class="mb-5">
                    <div class="position-relative d-flex justify-content-between mb-2">
                        <div class="position-relative d-flex align-items-center w-100">
                            <div class="rounded-circle bg-success text-white d-flex align-items-center justify-content-center" style="width: 48px; height: 48px; z-index: 1;">
                                <i class="bi bi-check-lg"></i>
                            </div>
                            <div class="progress w-100" style="height: 2px;">
                                <div class="progress-bar bg-success" role="progressbar" style="width: 100%;" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                        <div class="position-relative d-flex align-items-center w-100">
                            <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center" style="width: 48px; height: 48px; z-index: 1;">
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
                        <div class="text-center fw-medium text-success" style="width: 33%;">Data Pribadi</div>
                        <div class="text-center fw-medium text-primary" style="width: 33%;">Unggah Dokumen</div>
                        <div class="text-center fw-medium text-muted" style="width: 33%;">Konfirmasi</div>
                    </div>
                </div>

                <!-- Title and Description -->
                <div class="text-center mb-4">
                    <h1 class="h3 fw-bold text-primary mb-2">Unggah Dokumen</h1>
                    <p class="text-secondary">Silakan unggah dokumen yang diperlukan untuk verifikasi keanggotaan</p>
                </div>

                <!-- Document Upload Form -->
                <div class="card shadow-sm mb-5">
                    <div class="card-body p-4">
                        <form action="{{ route('registration.step2') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="mb-4">
                                <!-- KTP Document Upload -->
                                <div class="border rounded-3 bg-light p-4 mb-4">
                                    <h2 class="h5 fw-bold text-primary mb-3 d-flex align-items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-person-vcard me-2 text-primary" viewBox="0 0 16 16">
                                            <path d="M5 8a2 2 0 1 0 0-4 2 2 0 0 0 0 4m4-2.5a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 0 1h-4a.5.5 0 0 1-.5-.5M9 8a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 0 1h-4A.5.5 0 0 1 9 8m1 2.5a.5.5 0 0 1 .5-.5h3a.5.5 0 0 1 0 1h-3a.5.5 0 0 1-.5-.5"/>
                                            <path d="M2 2a2 2 0 0 0-2 2v8a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2zm13 2v8a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1"/>
                                        </svg>
                                        Kartu Tanda Penduduk (KTP)
                                    </h2>
                                    
                                    <div class="mb-3">
                                        <p class="text-secondary mb-3">Unggah scan atau foto KTP. Format yang diterima: JPG, JPEG, PNG, atau PDF. Ukuran maksimum: 2MB.</p>
                                        
                                        <div class="border border-2 border-dashed rounded-3 p-4 text-center bg-white">
                                            <div class="mb-3">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="currentColor" class="bi bi-cloud-arrow-up text-secondary opacity-50 mx-auto" viewBox="0 0 16 16">
                                                    <path fill-rule="evenodd" d="M7.646 5.146a.5.5 0 0 1 .708 0l2 2a.5.5 0 0 1-.708.708L8.5 6.707V10.5a.5.5 0 0 1-1 0V6.707L6.354 7.854a.5.5 0 1 1-.708-.708l2-2z"/>
                                                    <path d="M4.406 3.342A5.53 5.53 0 0 1 8 2c2.69 0 4.923 2 5.166 4.579C14.758 6.804 16 8.137 16 9.773 16 11.569 14.502 13 12.687 13H3.781C1.708 13 0 11.366 0 9.318c0-1.763 1.266-3.223 2.942-3.593.143-.863.698-1.723 1.464-2.383zm.653.757c-.757.653-1.153 1.44-1.153 2.056v.448l-.445.049C2.064 6.805 1 7.952 1 9.318 1 10.785 2.23 12 3.781 12h8.906C13.98 12 15 10.988 15 9.773c0-1.216-1.02-2.228-2.313-2.228h-.5v-.5C12.188 4.825 10.328 3 8 3a4.53 4.53 0 0 0-2.941 1.1z"/>
                                                </svg>
                                            </div>
                                            <label for="ktp_document" class="form-label cursor-pointer">
                                                <span class="text-muted">Klik untuk memilih file atau tarik dan lepaskan file di sini</span>
                                                <input id="ktp_document" name="ktp_document" type="file" class="d-none" accept=".jpg,.jpeg,.png,.pdf" required>
                                            </label>
                                            <p id="ktp_file_name" class="mt-2 small fw-medium text-primary d-none"></p>
                                        </div>
                                        
                                        @error('ktp_document')
                                            <div class="text-danger small mt-2">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Photo Upload -->
                                <div class="border rounded-3 bg-light p-4">
                                    <h2 class="h5 fw-bold text-primary mb-3 d-flex align-items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-camera me-2 text-primary" viewBox="0 0 16 16">
                                            <path d="M15 12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V6a1 1 0 0 1 1-1h1.172a3 3 0 0 0 2.12-.879l.83-.828A1 1 0 0 1 6.827 3h2.344a1 1 0 0 1 .707.293l.828.828A3 3 0 0 0 12.828 5H14a1 1 0 0 1 1 1v6zM2 4a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2h-1.172a2 2 0 0 1-1.414-.586l-.828-.828A2 2 0 0 0 9.172 2H6.828a2 2 0 0 0-1.414.586l-.828.828A2 2 0 0 1 3.172 4H2z"/>
                                            <path d="M8 11a2.5 2.5 0 1 1 0-5 2.5 2.5 0 0 1 0 5zm0 1a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7zM3 6.5a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0z"/>
                                        </svg>
                                        Pas Foto
                                    </h2>
                                    
                                    <div class="mb-3">
                                        <p class="text-secondary mb-3">Unggah pas foto berwarna terbaru dengan latar belakang polos. Format yang diterima: JPG, JPEG, atau PNG. Ukuran maksimum: 2MB.</p>
                                        
                                        <div class="border border-2 border-dashed rounded-3 p-4 text-center bg-white">
                                            <div class="mb-3">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="currentColor" class="bi bi-cloud-arrow-up text-secondary opacity-50 mx-auto" viewBox="0 0 16 16">
                                                    <path fill-rule="evenodd" d="M7.646 5.146a.5.5 0 0 1 .708 0l2 2a.5.5 0 0 1-.708.708L8.5 6.707V10.5a.5.5 0 0 1-1 0V6.707L6.354 7.854a.5.5 0 1 1-.708-.708l2-2z"/>
                                                    <path d="M4.406 3.342A5.53 5.53 0 0 1 8 2c2.69 0 4.923 2 5.166 4.579C14.758 6.804 16 8.137 16 9.773 16 11.569 14.502 13 12.687 13H3.781C1.708 13 0 11.366 0 9.318c0-1.763 1.266-3.223 2.942-3.593.143-.863.698-1.723 1.464-2.383zm.653.757c-.757.653-1.153 1.44-1.153 2.056v.448l-.445.049C2.064 6.805 1 7.952 1 9.318 1 10.785 2.23 12 3.781 12h8.906C13.98 12 15 10.988 15 9.773c0-1.216-1.02-2.228-2.313-2.228h-.5v-.5C12.188 4.825 10.328 3 8 3a4.53 4.53 0 0 0-2.941 1.1z"/>
                                                </svg>
                                            </div>
                                            <label for="photo" class="form-label cursor-pointer">
                                                <span class="text-muted">Klik untuk memilih file atau tarik dan lepaskan file di sini</span>
                                                <input id="photo" name="photo" type="file" class="d-none" accept=".jpg,.jpeg,.png" required>
                                            </label>
                                            <p id="photo_file_name" class="mt-2 small fw-medium text-primary d-none"></p>
                                        </div>
                                        
                                        @error('photo')
                                            <div class="text-danger small mt-2">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-between mt-4">
                                <a href="{{ route('registration.step1') }}" class="btn btn-outline-secondary">Kembali</a>
                                <button type="submit" class="btn btn-primary">Lanjut ke Langkah Berikutnya</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @section('scripts')
    <script>
        // Display file name when selected
        document.getElementById('ktp_document').addEventListener('change', function() {
            const fileName = this.files[0]?.name;
            const fileNameElement = document.getElementById('ktp_file_name');
            if (fileName) {
                fileNameElement.textContent = 'File terpilih: ' + fileName;
                fileNameElement.classList.remove('d-none');
                fileNameElement.classList.add('d-block');
            } else {
                fileNameElement.classList.remove('d-block');
                fileNameElement.classList.add('d-none');
            }
        });

        document.getElementById('photo').addEventListener('change', function() {
            const fileName = this.files[0]?.name;
            const fileNameElement = document.getElementById('photo_file_name');
            if (fileName) {
                fileNameElement.textContent = 'File terpilih: ' + fileName;
                fileNameElement.classList.remove('d-none');
                fileNameElement.classList.add('d-block');
            } else {
                fileNameElement.classList.remove('d-block');
                fileNameElement.classList.add('d-none');
            }
        });
    </script>
    @endsection
@endsection