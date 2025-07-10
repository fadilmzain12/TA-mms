@extends('layouts.app')

@section('title', 'Majelis Musyawarah Sunda - Beranda')

@section('content')
<div class="container">
    <!-- Hero Section -->
    <div class="row align-items-center py-5 mb-5">
        <div class="col-lg-6 mb-4 mb-lg-0">
            <h1 class="display-4 fw-bold text-primary mb-3">
                Selamat Datang di<br>
                <span class="text-primary">Majelis Musyawarah Sunda</span>
            </h1>
            <p class="lead mb-4 text-secondary">
                Bergabunglah dengan komunitas kami untuk menjaga dan melestarikan nilai-nilai budaya Sunda 
                serta membangun jaringan masyarakat berbasis kearifan lokal.
            </p>
            <div class="d-flex flex-column flex-sm-row gap-3">
                <a href="{{ route('registration.step1') }}" class="btn btn-primary btn-lg">
                    Daftar Sekarang
                </a>
                <a href="#tentang" class="btn btn-outline-secondary btn-lg">
                    Pelajari Lebih Lanjut
                </a>
            </div>
        </div>
        <div class="col-lg-6 text-center">
            <img src="https://via.placeholder.com/700x500/6c757d/FFFFFF?text=Majelis+Musyawarah+Sunda" alt="Majelis Musyawarah Sunda" class="img-fluid rounded shadow-lg">
        </div>
    </div>

    <!-- Features Section -->
    <div id="tentang" class="py-5 mb-5">
        <div class="text-center mb-5">
            <h2 class="display-5 fw-bold text-primary mb-3">Tentang MMS</h2>
            <p class="text-secondary mx-auto" style="max-width: 700px;">
                Majelis Musyawarah Sunda (MMS) adalah organisasi yang bertujuan untuk melestarikan 
                dan mengembangkan nilai-nilai budaya Sunda sebagai bagian dari kekayaan budaya Indonesia.
            </p>
        </div>
        
        <div class="row g-4 mb-5">
            <!-- Feature 1 -->
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm hover-shadow-lg">
                    <div class="card-body p-4">
                        <div class="text-center mb-3">
                            <div class="bg-primary d-inline-flex p-3 rounded-circle mb-3">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="white" class="bi bi-people-fill" viewBox="0 0 16 16">
                                    <path d="M7 14s-1 0-1-1 1-4 5-4 5 3 5 4-1 1-1 1H7Zm4-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6Zm-5.784 6A2.238 2.238 0 0 1 5 13c0-1.355.68-2.75 1.936-3.72A6.325 6.325 0 0 0 5 9c-4 0-5 3-5 4s1 1 1 1h4.216ZM4.5 8a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5Z"/>
                                </svg>
                            </div>
                            <h3 class="h4 fw-bold text-primary mb-2">Komunitas</h3>
                        </div>
                        <p class="text-secondary text-center">
                            Menjadi bagian dari jaringan masyarakat yang peduli terhadap pelestarian budaya Sunda
                            dan mendapat kesempatan berinteraksi dengan tokoh-tokoh Sunda.
                        </p>
                    </div>
                </div>
            </div>
            
            <!-- Feature 2 -->
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm hover-shadow-lg">
                    <div class="card-body p-4">
                        <div class="text-center mb-3">
                            <div class="bg-primary d-inline-flex p-3 rounded-circle mb-3">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="white" class="bi bi-calendar2-event" viewBox="0 0 16 16">
                                    <path d="M11 7.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1z"/>
                                    <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM2 2a1 1 0 0 0-1 1v11a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V3a1 1 0 0 0-1-1H2z"/>
                                    <path d="M2.5 4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5H3a.5.5 0 0 1-.5-.5V4z"/>
                                </svg>
                            </div>
                            <h3 class="h4 fw-bold text-primary mb-2">Program</h3>
                        </div>
                        <p class="text-secondary text-center">
                            Akses ke berbagai program pemberdayaan, pelatihan, dan pengembangan diri yang 
                            berbasis pada nilai-nilai kearifan lokal budaya Sunda.
                        </p>
                    </div>
                </div>
            </div>
            
            <!-- Feature 3 -->
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm hover-shadow-lg">
                    <div class="card-body p-4">
                        <div class="text-center mb-3">
                            <div class="bg-primary d-inline-flex p-3 rounded-circle mb-3">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="white" class="bi bi-shield-check" viewBox="0 0 16 16">
                                    <path d="M5.338 1.59a61.44 61.44 0 0 0-2.837.856.481.481 0 0 0-.328.39c-.554 4.157.726 7.19 2.253 9.188a10.725 10.725 0 0 0 2.287 2.233c.346.244.652.42.893.533.12.057.218.095.293.118a.55.55 0 0 0 .101.025.615.615 0 0 0 .1-.025c.076-.023.174-.061.294-.118.24-.113.547-.29.893-.533a10.726 10.726 0 0 0 2.287-2.233c1.527-1.997 2.807-5.031 2.253-9.188a.48.48 0 0 0-.328-.39c-.651-.213-1.75-.56-2.837-.855C9.552 1.29 8.531 1.067 8 1.067c-.53 0-1.552.223-2.662.524zM5.072.56C6.157.265 7.31 0 8 0s1.843.265 2.928.56c1.11.3 2.229.655 2.887.87a1.54 1.54 0 0 1 1.044 1.262c.596 4.477-.787 7.795-2.465 9.99a11.775 11.775 0 0 1-2.517 2.453 7.159 7.159 0 0 1-1.048.625c-.28.132-.581.24-.829.24s-.548-.108-.829-.24a7.158 7.158 0 0 1-1.048-.625 11.777 11.777 0 0 1-2.517-2.453C1.928 10.487.545 7.169 1.141 2.692A1.54 1.54 0 0 1 2.185 1.43 62.456 62.456 0 0 1 5.072.56z"/>
                                    <path d="M10.854 5.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7.5 7.793l2.646-2.647a.5.5 0 0 1 .708 0z"/>
                                </svg>
                            </div>
                            <h3 class="h4 fw-bold text-primary mb-2">Identitas</h3>
                        </div>
                        <p class="text-secondary text-center">
                            Memiliki kartu identitas anggota resmi MMS yang dapat digunakan untuk mengakses
                            berbagai fasilitas dan kegiatan yang diselenggarakan oleh MMS.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Call to Action -->
    <div class="bg-primary rounded-3 shadow-lg p-5 mb-5">
        <div class="row justify-content-center">
            <div class="col-lg-8 text-center">
                <h2 class="h2 fw-bold text-white mb-3">Siap untuk bergabung dengan kami?</h2>
                <p class="text-white-50 mb-4">
                    Proses pendaftaran mudah dan cepat. Anda hanya perlu mengisi formulir dan mengunggah dokumen identitas.
                </p>
                <a href="{{ route('registration.step1') }}" class="btn btn-light btn-lg px-4 fw-bold text-primary">
                    Daftar Sekarang
                </a>
            </div>
        </div>
    </div>

    <!-- Testimonials -->
    <div class="py-5 mb-5">
        <div class="text-center mb-5">
            <h2 class="display-5 fw-bold text-primary mb-3">Apa Kata Mereka</h2>
            <p class="text-secondary mx-auto" style="max-width: 700px;">
                Dengarkan pengalaman dari anggota Majelis Musyawarah Sunda yang telah bergabung dengan kami.
            </p>
        </div>
        
        <div class="row g-4">
            <!-- Testimonial 1 -->
            <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body p-4">
                        <div class="text-primary mb-3">
                            <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="currentColor" class="bi bi-quote" viewBox="0 0 16 16">
                                <path d="M12 12a1 1 0 0 0 1-1V8.558a1 1 0 0 0-1-1h-1.388c0-.351.021-.703.062-1.054.062-.372.166-.703.31-.992.145-.29.331-.517.559-.683.227-.186.516-.279.868-.279V3c-.579 0-1.085.124-1.52.372a3.322 3.322 0 0 0-1.085.992 4.92 4.92 0 0 0-.62 1.458A7.712 7.712 0 0 0 9 7.558V11a1 1 0 0 0 1 1h2Zm-6 0a1 1 0 0 0 1-1V8.558a1 1 0 0 0-1-1H4.612c0-.351.021-.703.062-1.054.062-.372.166-.703.31-.992.145-.29.331-.517.559-.683.227-.186.516-.279.868-.279V3c-.579 0-1.085.124-1.52.372a3.322 3.322 0 0 0-1.085.992 4.92 4.92 0 0 0-.62 1.458A7.712 7.712 0 0 0 3 7.558V11a1 1 0 0 0 1 1h2Z"/>
                            </svg>
                        </div>
                        <p class="text-secondary mb-4 fst-italic">
                            "Bergabung dengan MMS membuat saya lebih mengenal nilai-nilai budaya Sunda. 
                            Program-programnya sangat bermanfaat untuk pengembangan diri dan masyarakat."
                        </p>
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <img src="https://via.placeholder.com/60/6610f2/FFFFFF?text=AS" alt="Ahmad Sutisna" class="rounded-circle" width="50">
                            </div>
                            <div class="ms-3">
                                <h5 class="fw-bold text-primary mb-0">Ahmad Sutisna</h5>
                                <p class="small text-muted mb-0">Anggota sejak 2023</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Testimonial 2 -->
            <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body p-4">
                        <div class="text-primary mb-3">
                            <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="currentColor" class="bi bi-quote" viewBox="0 0 16 16">
                                <path d="M12 12a1 1 0 0 0 1-1V8.558a1 1 0 0 0-1-1h-1.388c0-.351.021-.703.062-1.054.062-.372.166-.703.31-.992.145-.29.331-.517.559-.683.227-.186.516-.279.868-.279V3c-.579 0-1.085.124-1.52.372a3.322 3.322 0 0 0-1.085.992 4.92 4.92 0 0 0-.62 1.458A7.712 7.712 0 0 0 9 7.558V11a1 1 0 0 0 1 1h2Zm-6 0a1 1 0 0 0 1-1V8.558a1 1 0 0 0-1-1H4.612c0-.351.021-.703.062-1.054.062-.372.166-.703.31-.992.145-.29.331-.517.559-.683.227-.186.516-.279.868-.279V3c-.579 0-1.085.124-1.52.372a3.322 3.322 0 0 0-1.085.992 4.92 4.92 0 0 0-.62 1.458A7.712 7.712 0 0 0 3 7.558V11a1 1 0 0 0 1 1h2Z"/>
                            </svg>
                        </div>
                        <p class="text-secondary mb-4 fst-italic">
                            "MMS bukan hanya sekadar organisasi, tapi juga keluarga besar yang selalu 
                            menjunjung tinggi nilai-nilai kebersamaan dan gotong royong."
                        </p>
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <img src="https://via.placeholder.com/60/6610f2/FFFFFF?text=NA" alt="Nenden Aisyah" class="rounded-circle" width="50">
                            </div>
                            <div class="ms-3">
                                <h5 class="fw-bold text-primary mb-0">Nenden Aisyah</h5>
                                <p class="small text-muted mb-0">Anggota sejak 2022</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Testimonial 3 -->
            <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body p-4">
                        <div class="text-primary mb-3">
                            <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="currentColor" class="bi bi-quote" viewBox="0 0 16 16">
                                <path d="M12 12a1 1 0 0 0 1-1V8.558a1 1 0 0 0-1-1h-1.388c0-.351.021-.703.062-1.054.062-.372.166-.703.31-.992.145-.29.331-.517.559-.683.227-.186.516-.279.868-.279V3c-.579 0-1.085.124-1.52.372a3.322 3.322 0 0 0-1.085.992 4.92 4.92 0 0 0-.62 1.458A7.712 7.712 0 0 0 9 7.558V11a1 1 0 0 0 1 1h2Zm-6 0a1 1 0 0 0 1-1V8.558a1 1 0 0 0-1-1H4.612c0-.351.021-.703.062-1.054.062-.372.166-.703.31-.992.145-.29.331-.517.559-.683.227-.186.516-.279.868-.279V3c-.579 0-1.085.124-1.52.372a3.322 3.322 0 0 0-1.085.992 4.92 4.92 0 0 0-.62 1.458A7.712 7.712 0 0 0 3 7.558V11a1 1 0 0 0 1 1h2Z"/>
                            </svg>
                        </div>
                        <p class="text-secondary mb-4 fst-italic">
                            "Jaringan dan komunitas MMS sangat luas. Banyak peluang kerjasama dan kolaborasi 
                            yang bisa dimanfaatkan untuk kemajuan bersama."
                        </p>
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <img src="https://via.placeholder.com/60/6610f2/FFFFFF?text=DS" alt="Dedi Supriatna" class="rounded-circle" width="50">
                            </div>
                            <div class="ms-3">
                                <h5 class="fw-bold text-primary mb-0">Dedi Supriatna</h5>
                                <p class="small text-muted mb-0">Anggota sejak 2024</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Smooth scroll for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            
            document.querySelector(this.getAttribute('href')).scrollIntoView({
                behavior: 'smooth'
            });
        });
    });

    // Add hover effect to cards
    document.querySelectorAll('.hover-shadow-lg').forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.classList.add('shadow-lg');
            this.classList.add('transition');
        });
        
        card.addEventListener('mouseleave', function() {
            this.classList.remove('shadow-lg');
        });
    });
</script>
@endsection
