@extends('admin.layouts.app')

@section('title', 'Pengaturan Sistem')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Pengaturan Sistem</h1>
    </div>

    <!-- Alert Messages -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row">
        <div class="col-md-6">
            <!-- General Settings -->
            <div class="card card-admin shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Pengaturan Umum</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.settings.update') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="site_name" class="form-label">Nama Sistem</label>
                            <input type="text" class="form-control" id="site_name" name="site_name" value="{{ $settings['site_name'] ?? 'Member Management System' }}">
                        </div>
                        <div class="mb-3">
                            <label for="organization_name" class="form-label">Nama Organisasi</label>
                            <input type="text" class="form-control" id="organization_name" name="organization_name" value="{{ $settings['organization_name'] ?? 'MMS Organization' }}">
                        </div>
                        <div class="mb-3">
                            <label for="contact_email" class="form-label">Email Kontak</label>
                            <input type="email" class="form-control" id="contact_email" name="contact_email" value="{{ $settings['contact_email'] ?? 'admin@mms.org' }}">
                        </div>
                        <div class="mb-3">
                            <label for="contact_phone" class="form-label">Telepon Kontak</label>
                            <input type="text" class="form-control" id="contact_phone" name="contact_phone" value="{{ $settings['contact_phone'] ?? '+62 000 0000 0000' }}">
                        </div>
                        
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="col-md-6">
            <!-- Email Settings -->
            <div class="card card-admin shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Pengaturan Email</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.settings.update') }}" method="POST">
                        @csrf
                        <input type="hidden" name="section" value="email">
                        
                        <div class="mb-3">
                            <label for="mail_from_address" class="form-label">Alamat Email Pengirim</label>
                            <input type="email" class="form-control" id="mail_from_address" name="mail_from_address" value="{{ $settings['mail_from_address'] ?? 'noreply@mms.org' }}">
                        </div>
                        <div class="mb-3">
                            <label for="mail_from_name" class="form-label">Nama Pengirim</label>
                            <input type="text" class="form-control" id="mail_from_name" name="mail_from_name" value="{{ $settings['mail_from_name'] ?? 'MMS System' }}">
                        </div>
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" id="send_welcome_email" name="send_welcome_email" value="1" {{ isset($settings['send_welcome_email']) && $settings['send_welcome_email'] ? 'checked' : '' }}>
                            <label class="form-check-label" for="send_welcome_email">
                                Kirim email selamat datang setelah registrasi
                            </label>
                        </div>
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" id="send_verification_email" name="send_verification_email" value="1" {{ isset($settings['send_verification_email']) && $settings['send_verification_email'] ? 'checked' : '' }}>
                            <label class="form-check-label" for="send_verification_email">
                                Kirim email setelah verifikasi pendaftaran
                            </label>
                        </div>
                        
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </form>
                </div>
            </div>
            
            <!-- Membership Card Settings -->
            <div class="card card-admin shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Pengaturan Kartu Anggota</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.settings.update') }}" method="POST">
                        @csrf
                        <input type="hidden" name="section" value="card">
                        
                        <div class="mb-3">
                            <label for="card_validity_years" class="form-label">Masa Berlaku Kartu (tahun)</label>
                            <input type="number" class="form-control" id="card_validity_years" name="card_validity_years" value="{{ $settings['card_validity_years'] ?? '2' }}" min="1" max="10">
                        </div>
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" id="show_qr_on_card" name="show_qr_on_card" value="1" {{ isset($settings['show_qr_on_card']) && $settings['show_qr_on_card'] ? 'checked' : '' }}>
                            <label class="form-check-label" for="show_qr_on_card">
                                Tampilkan QR Code pada kartu anggota
                            </label>
                        </div>
                        
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection