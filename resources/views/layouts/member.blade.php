<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Member Area | Majelis Musyawarah Sunda')</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;500;600;700;800&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Styles -->
    <style>
        :root {
            --color-primary: #29204E;
            --color-primary-light: #453976;
            --color-primary-dark: #1a1436;
            --color-secondary: #786CA1;
            --color-secondary-light: #9e95c2;
            --color-secondary-dark: #5b5280;
            --color-accent: #FFB800;
            --color-accent-light: #ffc633;
            --color-accent-dark: #cc9300;
        }
        
        html {
            scroll-behavior: smooth;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            color: #333;
            background-color: #f7f7f9;
        }
        
        h1, h2, h3, h4, h5, h6 {
            font-family: 'Nunito', sans-serif;
        }
        
        .sidebar {
            width: 250px;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            background-color: var(--color-primary);
            color: white;
            transition: all 0.3s;
            z-index: 100;
        }
        
        .sidebar-collapsed {
            width: 80px;
        }
        
        .main-content {
            margin-left: 250px;
            transition: all 0.3s;
        }
        
        .main-content-expanded {
            margin-left: 80px;
        }
        
        .nav-link {
            display: flex;
            align-items: center;
            padding: 0.75rem 1.5rem;
            color: rgba(255, 255, 255, 0.8);
            transition: all 0.2s;
        }
        
        .nav-link:hover, .nav-link.active {
            background-color: var(--color-primary-light);
            color: white;
            border-left: 4px solid var(--color-accent);
        }
        
        .nav-link-text {
            margin-left: 0.75rem;
        }
        
        .sidebar-collapsed .nav-link-text {
            display: none;
        }
        
        .card {
            background-color: white;
            border-radius: 0.5rem;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            padding: 1.5rem;
            margin-bottom: 1.5rem;
        }
        
        .btn-primary {
            display: inline-block;
            background-color: var(--color-primary);
            color: white;
            font-weight: 600;
            padding: 0.5rem 1rem;
            border-radius: 0.375rem;
            border: none;
            cursor: pointer;
            transition: background-color 0.15s ease-in-out;
            text-decoration: none;
        }
        
        .btn-primary:hover, .btn-primary:focus {
            background-color: var(--color-primary-dark);
            color: white;
        }
        
        .btn-secondary {
            display: inline-block;
            background-color: #f3f4f6;
            color: var(--color-primary);
            font-weight: 600;
            padding: 0.5rem 1rem;
            border-radius: 0.375rem;
            border: 1px solid #e5e7eb;
            cursor: pointer;
            transition: background-color 0.15s ease-in-out;
            text-decoration: none;
        }
        
        .btn-secondary:hover, .btn-secondary:focus {
            background-color: #e5e7eb;
        }
        
        .btn-accent {
            display: inline-block;
            background-color: var(--color-accent);
            color: var(--color-primary-dark);
            font-weight: 600;
            padding: 0.5rem 1rem;
            border-radius: 0.375rem;
            border: none;
            cursor: pointer;
            transition: background-color 0.15s ease-in-out;
            text-decoration: none;
        }
        
        .btn-accent:hover, .btn-accent:focus {
            background-color: var(--color-accent-dark);
        }
    </style>
    
    <!-- Include Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#29204E',
                        secondary: '#786CA1',
                        accent: '#FFB800',
                    },
                    fontFamily: {
                        heading: ['Nunito', 'sans-serif'],
                        body: ['Inter', 'sans-serif'],
                    },
                }
            }
        }
    </script>
    
    <!-- Alpine.js -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

    @yield('head')
</head>
<body>
    <div x-data="{ sidebarOpen: true }">
        <!-- Sidebar -->
        <div class="sidebar" :class="{ 'sidebar-collapsed': !sidebarOpen }">
            <!-- Logo -->
            <div class="p-4 flex items-center justify-between">
                <a href="{{ route('member.dashboard') }}" class="text-white">
                    <span class="text-2xl font-bold" x-show="sidebarOpen">MMS</span>
                    <span class="text-2xl font-bold" x-show="!sidebarOpen">M</span>
                </a>
                <button @click="sidebarOpen = !sidebarOpen" class="text-white focus:outline-none">
                    <svg x-show="sidebarOpen" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 19l-7-7 7-7m8 14l-7-7 7-7" />
                    </svg>
                    <svg x-show="!sidebarOpen" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5l7 7-7 7M5 5l7 7-7 7" />
                    </svg>
                </button>
            </div>
            
            <!-- Navigation -->
            <div class="mt-6">
                <a href="{{ route('member.dashboard') }}" class="nav-link {{ request()->routeIs('member.dashboard') ? 'active' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    <span class="nav-link-text">Dashboard</span>
                </a>
                
                <a href="{{ route('member.profile') }}" class="nav-link {{ request()->routeIs('member.profile') ? 'active' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    <span class="nav-link-text">Profil Saya</span>
                </a>
                
                <a href="{{ route('member.documents') }}" class="nav-link {{ request()->routeIs('member.documents') ? 'active' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <span class="nav-link-text">Dokumen</span>
                </a>
                
                <a href="{{ route('member.events') }}" class="nav-link {{ request()->routeIs('member.events') ? 'active' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    <span class="nav-link-text">Kegiatan</span>
                </a>
                
                <a href="{{ route('member.announcements') }}" class="nav-link {{ request()->routeIs('member.announcements') ? 'active' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z" />
                    </svg>
                    <span class="nav-link-text">Pengumuman</span>
                </a>
                
                <div class="mt-8 border-t border-gray-200 pt-4">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="nav-link w-full text-left">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                            <span class="nav-link-text">Keluar</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
        
        <!-- Main Content -->
        <div class="main-content min-h-screen" :class="{ 'main-content-expanded': !sidebarOpen }">
            <!-- Top Navigation Bar -->
            <header class="bg-white shadow">
                <div class="px-4 py-3 flex items-center justify-between">
                    <div>
                        <h1 class="text-xl font-semibold text-gray-800">@yield('page-title', 'Dashboard')</h1>
                    </div>
                    
                    <div class="flex items-center space-x-4">
                        <!-- Notifications -->
                        <div class="relative" x-data="{ isOpen: false }">
                            <button @click="isOpen = !isOpen" class="p-1 text-gray-500 rounded-full hover:bg-gray-100 focus:outline-none">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                                </svg>
                            </button>
                            
                            <div x-show="isOpen" @click.away="isOpen = false" class="absolute right-0 mt-2 w-80 bg-white rounded-md shadow-lg py-1 z-20">
                                <div class="px-4 py-2 border-b">
                                    <h3 class="text-sm font-semibold text-gray-700">Notifikasi</h3>
                                </div>
                                
                                <div class="max-h-64 overflow-y-auto">
                                    <!-- Sample Notification Items - These would come from the backend -->
                                    <a href="#" class="block px-4 py-3 hover:bg-gray-50 border-b">
                                        <p class="text-sm font-medium text-gray-900">Dokumen Anda telah diverifikasi</p>
                                        <p class="text-xs text-gray-500 mt-1">2 jam yang lalu</p>
                                    </a>
                                    <a href="#" class="block px-4 py-3 hover:bg-gray-50 border-b">
                                        <p class="text-sm font-medium text-gray-900">Kegiatan baru: Pertemuan Bulanan</p>
                                        <p class="text-xs text-gray-500 mt-1">Kemarin</p>
                                    </a>
                                    <a href="#" class="block px-4 py-3 hover:bg-gray-50">
                                        <p class="text-sm font-medium text-gray-900">Pengumuman penting dari ketua</p>
                                        <p class="text-xs text-gray-500 mt-1">3 hari yang lalu</p>
                                    </a>
                                </div>
                                
                                <div class="px-4 py-2 border-t">
                                    <a href="#" class="text-xs text-center block text-primary hover:underline">Lihat semua notifikasi</a>
                                </div>
                            </div>
                        </div>
                        
                        <!-- User Dropdown -->
                        <div class="relative" x-data="{ isOpen: false }">
                            <button @click="isOpen = !isOpen" class="flex items-center space-x-2 focus:outline-none">
                                <div class="w-8 h-8 rounded-full bg-primary flex items-center justify-center text-white">
                                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                </div>
                                <span class="text-sm font-medium text-gray-700">{{ Auth::user()->name }}</span>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </button>
                            
                            <div x-show="isOpen" @click.away="isOpen = false" class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-20">
                                <a href="{{ route('member.profile') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profil Saya</a>
                                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Pengaturan</a>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Keluar</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </header>
            
            <!-- Page Content -->
            <main class="p-6">
                @yield('content')
            </main>
            
            <!-- Footer -->
            <footer class="bg-white py-4 px-6 border-t">
                <div class="flex flex-col md:flex-row justify-between items-center">
                    <div class="text-sm text-gray-500">
                        &copy; {{ date('Y') }} Majelis Musyawarah Sunda. Hak Cipta Dilindungi.
                    </div>
                    <div class="mt-2 md:mt-0 text-sm text-gray-500">
                        Versi 1.0.0
                    </div>
                </div>
            </footer>
        </div>
    </div>
    
    @yield('scripts')
</body>
</html>