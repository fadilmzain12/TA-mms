<!DOCTYPE html>
<html lang="en" data-bs-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'Beranda Anggota') - MMS</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <style>
        :root {
            --bs-body-bg: #fff;
            --bs-body-color: #212529;
            --sidebar-bg: #f8f9fa;
            --sidebar-color: #333;
            --sidebar-active: #6610f2;
            --navbar-bg: #6610f2;
            --navbar-color: #fff;
            --card-bg: #fff;
            --table-hover-bg: rgba(0, 0, 0, 0.03);
            --border-color: rgba(0, 0, 0, .1);
            --status-active-bg: #dcfce7;
            --status-active-color: #166534;
            --status-pending-bg: #ffedd5;
            --status-pending-color: #9a3412;
            --status-inactive-bg: #f3f4f6;
            --status-inactive-color: #4b5563;
            --status-rejected-bg: #fee2e2;
            --status-rejected-color: #b91c1c;
        }

        [data-bs-theme="dark"] {
            --bs-body-bg: #212529;
            --bs-body-color: #f8f9fa;
            --sidebar-bg: #343a40;
            --sidebar-color: #e9ecef;
            --sidebar-active: #8540f5;
            --navbar-bg: #5209c9;
            --navbar-color: #fff;
            --card-bg: #343a40;
            --table-hover-bg: rgba(255, 255, 255, 0.05);
            --border-color: rgba(255, 255, 255, .1);
            --status-active-bg: rgba(22, 101, 52, 0.3);
            --status-active-color: #4ade80;
            --status-pending-bg: rgba(154, 52, 18, 0.3);
            --status-pending-color: #fdba74;
            --status-inactive-bg: rgba(75, 85, 99, 0.3);
            --status-inactive-color: #d1d5db;
            --status-rejected-bg: rgba(185, 28, 28, 0.3);
            --status-rejected-color: #fca5a5;
        }

        body {
            font-size: .875rem;
            background-color: var(--bs-body-bg);
            color: var(--bs-body-color);
            transition: background-color 0.3s ease, color 0.3s ease;
        }
        
        /*
         * Sidebar
         */
        
        .sidebar {
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            z-index: 100; /* Behind the navbar */
            padding: 48px 0 0; /* Height of navbar */
            box-shadow: inset -1px 0 0 var(--border-color);
            background-color: var(--sidebar-bg);
            transition: background-color 0.3s ease;
        }
        
        @media (max-width: 767.98px) {
            .sidebar {
                top: 5rem;
            }
        }
        
        .sidebar-sticky {
            position: relative;
            top: 0;
            height: calc(100vh - 48px);
            padding-top: .5rem;
            overflow-x: hidden;
            overflow-y: auto; /* Scrollable contents if viewport is shorter than content. */
        }
        
        .sidebar .nav-link {
            font-weight: 500;
            color: var(--sidebar-color);
        }
        
        .sidebar .nav-link .bi {
            margin-right: 4px;
            color: var(--sidebar-color);
            opacity: 0.75;
        }
        
        .sidebar .nav-link.active {
            color: var(--sidebar-active);
        }
        
        .sidebar .nav-link:hover .bi,
        .sidebar .nav-link.active .bi {
            color: inherit;
        }
        
        .sidebar-heading {
            font-size: .75rem;
            text-transform: uppercase;
            color: var(--bs-body-color);
            opacity: 0.6;
        }
        
        /*
         * Navbar
         */
        
        .navbar-dark {
            background-color: var(--navbar-bg) !important;
        }
        
        .navbar-brand {
            padding-top: .75rem;
            padding-bottom: .75rem;
            font-size: 1rem;
            background-color: rgba(0, 0, 0, .15);
            box-shadow: inset -1px 0 0 rgba(0, 0, 0, .15);
        }
        
        .navbar .navbar-toggler {
            top: .25rem;
            right: 1rem;
        }
        
        .card-member {
            border-radius: 0.5rem;
            border: none;
            background-color: var(--card-bg);
            transition: background-color 0.3s ease;
        }
        
        .card-member .card-header {
            border-bottom: 1px solid var(--border-color);
            padding: 1rem;
            background-color: var(--card-bg);
        }
        
        .table {
            color: var(--bs-body-color);
        }
        
        .table-hover tbody tr:hover {
            background-color: var(--table-hover-bg);
        }
        
        .table-light {
            --bs-table-bg: var(--bs-light);
            --bs-table-color: var(--bs-body-color);
        }
        
        .status-badge {
            font-size: 0.75rem;
            font-weight: 600;
            padding: 0.25rem 0.5rem;
            border-radius: 0.25rem;
        }
        
        .status-pending {
            background-color: var(--status-pending-bg);
            color: var(--status-pending-color);
        }
        
        .status-active {
            background-color: var(--status-active-bg);
            color: var(--status-active-color);
        }
        
        .status-inactive {
            background-color: var(--status-inactive-bg);
            color: var(--status-inactive-color);
        }
        
        .status-rejected {
            background-color: var(--status-rejected-bg);
            color: var(--status-rejected-color);
        }
        
        .theme-icon {
            width: 20px;
            height: 20px;
        }
    </style>
    
    @yield('styles')
</head>
<body>
    <header class="navbar navbar-dark sticky-top flex-md-nowrap p-0 shadow">
        <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3" href="{{ route('member.dashboard') }}">MMS - Area Anggota</a>
        <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="w-100"></div>
        <div class="navbar-nav">
            <div class="nav-item text-nowrap d-flex align-items-center">
                <!-- Theme Toggle Button -->
                <button class="nav-link px-3 bg-transparent border-0 text-white" id="theme-toggle">
                    <span class="theme-icon-light">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-moon-fill" viewBox="0 0 16 16">
                            <path d="M6 .278a.768.768 0 0 1 .08.858 7.208 7.208 0 0 0-.878 3.46c0 4.021 3.278 7.277 7.318 7.277.527 0 1.04-.055 1.533-.16a.787.787 0 0 1 .81.316.733.733 0 0 1-.031.893A8.349 8.349 0 0 1 8.344 16C3.734 16 0 12.286 0 7.71 0 4.266 2.114 1.312 5.124.06A.752.752 0 0 1 6 .278z"/>
                        </svg>
                    </span>
                    <span class="theme-icon-dark d-none">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-sun-fill" viewBox="0 0 16 16">
                            <path d="M8 12a4 4 0 1 0 0-8 4 4 0 0 0 0 8zM8 0a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 0zm0 13a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 13zm8-5a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2a.5.5 0 0 1 .5.5zM3 8a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2A.5.5 0 0 1 3 8zm10.657-5.657a.5.5 0 0 1 0 .707l-1.414 1.415a.5.5 0 1 1-.707-.708l1.414-1.414a.5.5 0 0 1 .707 0zm-9.193 9.193a.5.5 0 0 1 0 .707L3.05 13.657a.5.5 0 0 1-.707-.707l1.414-1.414a.5.5 0 0 1 .707 0zm9.193 2.121a.5.5 0 0 1-.707 0l-1.414-1.414a.5.5 0 0 1 .707-.707l1.414 1.414a.5.5 0 0 1 0 .707zM4.464 4.465a.5.5 0 0 1-.707 0L2.343 3.05a.5.5 0 1 1 .707-.707l1.414 1.414a.5.5 0 0 1 0 .708z"/>
                        </svg>
                    </span>
                </button>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="nav-link px-3 bg-transparent border-0 text-white">
                        <i class="bi bi-box-arrow-right me-1"></i> Keluar
                    </button>
                </form>
            </div>
        </div>
    </header>

    <div class="container-fluid">
        <div class="row">
            <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block sidebar collapse">
                <div class="position-sticky pt-3">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link {{ Request::routeIs('member.dashboard') ? 'active' : '' }}" href="{{ route('member.dashboard') }}">
                                <i class="bi bi-speedometer2"></i>
                                Beranda
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ Request::routeIs('member.profile') ? 'active' : '' }}" href="{{ route('member.profile') }}">
                                <i class="bi bi-person"></i>
                                Profil Saya
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ Request::routeIs('member.card') ? 'active' : '' }}" href="{{ route('member.card') }}">
                                <i class="bi bi-credit-card"></i>
                                Kartu Anggota
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ Request::routeIs('member.activities.*') ? 'active' : '' }}" href="{{ route('member.activities.index') }}">
                                <i class="bi bi-calendar-event"></i>
                                Kegiatan
                            </a>
                        </li>
                    </ul>

                    <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                        <span>Informasi</span>
                    </h6>
                    <ul class="nav flex-column mb-2">
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <i class="bi bi-info-circle"></i>
                                Tentang MMS
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <i class="bi bi-question-circle"></i>
                                Pusat Bantuan
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>

            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if(session('info'))
                    <div class="alert alert-info alert-dismissible fade show mt-3" role="alert">
                        {{ session('info') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Dark Mode Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const themeToggle = document.getElementById('theme-toggle');
            const htmlElement = document.documentElement;
            const lightIcon = document.querySelector('.theme-icon-light');
            const darkIcon = document.querySelector('.theme-icon-dark');
            
            // Check for saved theme preference or respect OS preference
            const savedTheme = localStorage.getItem('member-theme');
            const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
            
            // Set the initial theme
            if (savedTheme === 'dark' || (!savedTheme && prefersDark)) {
                htmlElement.setAttribute('data-bs-theme', 'dark');
                lightIcon.classList.add('d-none');
                darkIcon.classList.remove('d-none');
            }
            
            // Toggle theme when the button is clicked
            themeToggle.addEventListener('click', function() {
                const currentTheme = htmlElement.getAttribute('data-bs-theme');
                const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
                
                htmlElement.setAttribute('data-bs-theme', newTheme);
                localStorage.setItem('member-theme', newTheme);
                
                if (newTheme === 'dark') {
                    lightIcon.classList.add('d-none');
                    darkIcon.classList.remove('d-none');
                } else {
                    lightIcon.classList.remove('d-none');
                    darkIcon.classList.add('d-none');
                }
            });
        });
    </script>
    
    @yield('scripts')
</body>
</html>