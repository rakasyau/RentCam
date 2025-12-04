<!DOCTYPE html>
<html lang="id" data-bs-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RentCam - Sewa Kamera Profesional</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        /* --- 1. SETUP VARIABEL WARNA (Light vs Dark) --- */
        :root {
            /* Light Mode Variables */
            --bg-gradient: radial-gradient(at 0% 0%, hsla(253,16%,7%,1) 0, transparent 50%), radial-gradient(at 50% 0%, hsla(225,39%,30%,1) 0, transparent 50%), radial-gradient(at 100% 0%, hsla(339,49%,30%,1) 0, transparent 50%);
            --body-bg: #f0f4f8;
            --glass-bg: rgba(255, 255, 255, 0.65); /* Transparan Putih */
            --glass-border: rgba(255, 255, 255, 0.4);
            --text-color: #1e293b;
            --card-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.15);
            --glow-color: rgba(37, 99, 235, 0.5);
            --navbar-bg: rgba(255, 255, 255, 0.7);
        }

        [data-bs-theme="dark"] {
            /* Dark Mode Variables */
            --body-bg: #0f172a;
            --glass-bg: rgba(15, 23, 42, 0.65); /* Transparan Hitam/Biru Gelap */
            --glass-border: rgba(255, 255, 255, 0.1);
            --text-color: #e2e8f0;
            --card-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.3);
            --glow-color: rgba(56, 189, 248, 0.5); /* Cyan Glow */
            --navbar-bg: rgba(15, 23, 42, 0.7);
        }

        /* --- 2. GLOBAL STYLES & BACKGROUND --- */
        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--body-bg);
            color: var(--text-color);
            transition: background-color 0.5s ease, color 0.3s ease;
            min-height: 100vh;
            position: relative;
            overflow-x: hidden;
        }

        /* Background Blobs (Supaya efek kaca terlihat jelas) */
        body::before {
            content: '';
            position: fixed;
            top: -10%;
            left: -10%;
            right: -10%;
            bottom: -10%;
            background: var(--bg-gradient);
            background-size: 200% 200%;
            z-index: -1;
            opacity: 0.15; /* Samar-samar */
            animation: gradientBG 15s ease infinite;
        }

        @keyframes gradientBG {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        /* --- 3. GLASSMORPHISM UTILITIES (IOS Style) --- */
        .glass {
            background: var(--glass-bg);
            backdrop-filter: blur(16px); /* Efek Blur Kaca */
            -webkit-backdrop-filter: blur(16px); /* Safari support */
            border: 1px solid var(--glass-border);
            border-radius: 20px;
            box-shadow: var(--card-shadow);
        }

        /* --- 4. COMPONENT STYLES --- */
        
        /* Navbar */
        .navbar {
            background: var(--navbar-bg) !important;
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-bottom: 1px solid var(--glass-border);
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }
        

        /* Cards */
        .card {
            background: var(--glass-bg); /* Pakai variabel glass */
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid var(--glass-border);
            border-radius: 20px;
            box-shadow: var(--card-shadow);
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275); /* Bouncy effect */
            color: var(--text-color);
        }

        .card:hover {
            transform: translateY(-10px) scale(1.02);
            /* GLOW EFFECT */
            box-shadow: 0 0 20px var(--glow-color), 0 0 40px var(--glow-color); 
            border-color: rgba(255,255,255, 0.6);
        }

        .card-header {
            background: transparent;
            border-bottom: 1px solid var(--glass-border);
            font-weight: 700;
        }


        /* Buttons with Glow */
        .btn {
            border-radius: 12px;
            padding: 10px 24px;
            font-weight: 600;
            transition: all 0.3s;
            position: relative;
            overflow: hidden;
            border: none;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #3b82f6, #2563eb);
            box-shadow: 0 4px 15px rgba(37, 99, 235, 0.4);
        }
        
        .btn-primary:hover {
            background: linear-gradient(135deg, #2563eb, #1d4ed8);
            box-shadow: 0 0 20px rgba(37, 99, 235, 0.8); /* Strong Glow */
            transform: translateY(-2px);
        }

        /* Form Inputs */
        .form-control {
            background: rgba(255, 255, 255, 0.1); /* Semi transparan */
            border: 1px solid var(--glass-border);
            color: var(--text-color);
            border-radius: 12px;
            backdrop-filter: blur(5px);
        }
        .form-control:focus {
            background: rgba(255, 255, 255, 0.2);
            box-shadow: 0 0 15px var(--glow-color);
            border-color: var(--glass-border);
            color: var(--text-color);
        }

        /* Alerts */
        .alert {
            backdrop-filter: blur(10px);
            border-radius: 16px;
            border: 1px solid rgba(255,255,255,0.2);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        /* Theme Switcher Button */
        .theme-icon-active {
            display: none;
        }
        [data-bs-theme="light"] .fa-sun { display: inline-block; }
        [data-bs-theme="dark"] .fa-moon { display: inline-block; }
        [data-bs-theme="auto"] .fa-circle-half-stroke { display: inline-block; }
        
        /* --- 5. MOBILE RESPONSIVE FIXES (UPDATED) --- */
        @media (max-width: 991.98px) {
            
            /* FIX NAVBAR MOBILE: Floating Menu */
            .navbar-collapse {
                position: absolute; /* Membuatnya mengambang, tidak mendorong konten ke bawah */
                top: 100%; /* Muncul tepat di bawah navbar */
                left: 10px;
                right: 10px;
                background: var(--glass-bg); /* Pakai variabel tema */
                backdrop-filter: blur(25px);
                -webkit-backdrop-filter: blur(25px);
                padding: 20px;
                border-radius: 16px;
                border: 1px solid var(--glass-border);
                box-shadow: 0 10px 40px rgba(0,0,0,0.4);
                z-index: 9999;
                margin-top: 10px;
            }

            /* FIX TOMBOL DI MOBILE */
            .navbar-nav .btn {
                width: 100%;
                margin-bottom: 10px;
                text-align: center;
            }

            /* Karena navbar sticky, konten butuh padding atas ekstra di mobile */
            body {
                padding-top: 20px; 
            }
        }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark sticky-top">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ route('home') }}" style="color: var(--text-color) !important;">
                <i class="fas fa-camera-retro me-2 text-primary"></i>RentCam
            </a>
            
            <button class="navbar-toggler text-primary border-primary" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon" style="filter: invert(1);"></span> </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item">
                        <a class="nav-link" style="color: var(--text-color) !important;" href="{{ route('home') }}">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link position-relative" style="color: var(--text-color) !important;" href="{{ route('cart.view') }}">
                            Keranjang
                            @if(session('cart'))
                                <span class="position-absolute top-3 start-100 translate-middle badge rounded-pill bg-danger shadow-sm">
                                    {{ count(session('cart')) }}
                                </span>
                            @endif
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('help') ? 'active' : '' }}" style="color: var(--text-color) !important;" href="{{ route('help') }}">
                            Bantuan
                        </a>
                    </li>

                    <li class="nav-item dropdown ms-3">
                        <button class="btn btn-link nav-link dropdown-toggle d-flex align-items-center" id="bd-theme" type="button" aria-expanded="false" data-bs-toggle="dropdown" data-bs-display="static" style="color: var(--text-color) !important;">
                            <i class="fas fa-sun theme-icon-active" id="theme-icon-display"></i>
                            <span class="d-lg-none ms-2">Ganti Tema</span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end glass border-0" aria-labelledby="bd-theme" style="--bs-dropdown-bg: var(--glass-bg);">
                            <li>
                                <button type="button" class="dropdown-item d-flex align-items-center" data-bs-theme-value="light" style="color: var(--text-color);">
                                    <i class="fas fa-sun me-2 opacity-50"></i> Terang
                                </button>
                            </li>
                            <li>
                                <button type="button" class="dropdown-item d-flex align-items-center" data-bs-theme-value="dark" style="color: var(--text-color);">
                                    <i class="fas fa-moon me-2 opacity-50"></i> Gelap
                                </button>
                            </li>
                            <li>
                                <button type="button" class="dropdown-item d-flex align-items-center" data-bs-theme-value="auto" style="color: var(--text-color);">
                                    <i class="fas fa-circle-half-stroke me-2 opacity-50"></i> Sistem
                                </button>
                            </li>
                        </ul>
                    </li>

                    @auth
                        <li class="nav-item dropdown ms-3">
                            <a class="nav-link dropdown-toggle btn btn-primary text-white px-4 border-0" href="#" data-bs-toggle="dropdown">
                                {{ Auth::user()->name }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end glass border-0 mt-2" style="--bs-dropdown-bg: var(--glass-bg);">
                                <li><a class="dropdown-item" href="{{ route('admin.dashboard') }}" style="color: var(--text-color);">Dashboard</a></li>
                                <li><a class="dropdown-item" href="{{ route('cameras.index') }}" style="color: var(--text-color);">Kelola Kamera</a></li>
                                <li><hr class="dropdown-divider border-secondary"></li>
                                <li>
                                    <form action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="dropdown-item text-danger">Logout</button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @else
                        <li class="nav-item ms-3">
                            <a class="btn btn-primary btn-sm px-4 shadow-lg" href="{{ route('login') }}">Login Admin</a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <div class="container py-5 py-lg-5" style="min-height: 85vh;">
        @if(session('success'))
            <div class="alert alert-success d-flex flex-column align-items-center glass text-success border-0 text-center py-4" role="alert">
                <i class="fas fa-check-circle mb-3" style="font-size: 3rem;"></i>
                <h4 class="fw-bold">Berhasil!</h4>
                <p class="mb-3">{{ session('success') }}</p>

                @if(session('booking_id'))
                    <a href="{{ route('booking.invoice', session('booking_id')) }}" class="btn btn-primary shadow-lg px-4 py-2">
                        <i class="fas fa-file-pdf me-2"></i> Download Bukti Booking (PDF)
                    </a>
                    <small class="mt-2 text-muted">*Simpan file ini untuk pengambilan barang</small>
                @endif

                <button type="button" class="btn-close position-absolute top-0 end-0 m-3" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger d-flex align-items-center glass text-danger border-0" role="alert">
                <i class="fas fa-exclamation-triangle me-2 fs-4"></i>
                <div>{{ session('error') }}</div>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @yield('content')
    </div>

    <footer class="text-center py-4 mt-auto glass border-0 rounded-0">
        <div class="container">
            <p class="mb-0 fw-medium" style="color: var(--text-color);">&copy; {{ date('Y') }} <span class="text-primary fw-bold">RentCam</span>. All rights reserved.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        (() => {
            'use strict'

            const getStoredTheme = () => localStorage.getItem('theme')
            const setStoredTheme = theme => localStorage.setItem('theme', theme)

            // Cek preferensi user (auto detect system)
            const getPreferredTheme = () => {
                const storedTheme = getStoredTheme()
                if (storedTheme) {
                    return storedTheme
                }
                return window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light'
            }

            // Fungsi ganti atribut HTML
            const setTheme = theme => {
                if (theme === 'auto' && window.matchMedia('(prefers-color-scheme: dark)').matches) {
                    document.documentElement.setAttribute('data-bs-theme', 'dark')
                } else {
                    document.documentElement.setAttribute('data-bs-theme', theme === 'auto' ? 'light' : theme)
                }
            }

            setTheme(getPreferredTheme())

            // Update icon di navbar
            const showActiveTheme = (theme, focus = false) => {
                const themeSwitcher = document.querySelector('#bd-theme')
                const themeSwitcherIcon = document.querySelector('#theme-icon-display')
                const btnToActive = document.querySelector(`[data-bs-theme-value="${theme}"]`)

                // Reset icon display
                themeSwitcherIcon.className = 'theme-icon-active fas me-2'

                if (theme === 'light') {
                    themeSwitcherIcon.classList.add('fa-sun')
                } else if (theme === 'dark') {
                    themeSwitcherIcon.classList.add('fa-moon')
                } else {
                    themeSwitcherIcon.classList.add('fa-circle-half-stroke')
                }

                // Reset active state di dropdown
                document.querySelectorAll('[data-bs-theme-value]').forEach(element => {
                    element.classList.remove('active', 'bg-primary', 'text-white')
                })
                
                // Set active state
                btnToActive.classList.add('active', 'bg-primary', 'text-white')
            }

            window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', () => {
                const storedTheme = getStoredTheme()
                if (storedTheme !== 'light' && storedTheme !== 'dark') {
                    setTheme('auto')
                }
            })

            window.addEventListener('DOMContentLoaded', () => {
                showActiveTheme(getPreferredTheme())

                document.querySelectorAll('[data-bs-theme-value]')
                    .forEach(toggle => {
                        toggle.addEventListener('click', () => {
                            const theme = toggle.getAttribute('data-bs-theme-value')
                            setStoredTheme(theme)
                            setTheme(theme)
                            showActiveTheme(theme, true)
                        })
                    })
            })
        })()
    </script>
</body>
</html>