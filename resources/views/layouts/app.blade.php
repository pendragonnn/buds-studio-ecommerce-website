<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Buds Studio')</title>

    @php
        $svg = view('components.application-logo')->render();
        $favicon = 'data:image/svg+xml;base64,' . base64_encode($svg);
    @endphp

    <link rel="icon" type="image/svg+xml" href="{{ $favicon }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.tailwindcss.min.css">

    <!-- DataTables JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.css.min.js"></script>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/js/cart.js'])

    <!-- Alpine.js x-cloak styling -->
    <style>
        [x-cloak] {
            display: none !important;
        }

        /* Optional: Custom animation for smoother pulse */
        @keyframes smooth-pulse {

            0%,
            100% {
                opacity: 0.75;
                transform: scale(1);
            }

            50% {
                opacity: 0;
                transform: scale(1.5);
            }
        }

        .animate-ping {
            animation: smooth-pulse 2s cubic-bezier(0, 0, 0.2, 1) infinite;
        }
    </style>
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.store('authModal', {
                open: false,
                tab: 'login'
            });
            Alpine.store('cart', {
                open: false,
                items: JSON.parse(localStorage.getItem('buds_cart') || '[]'),
                syncWithStorage() {
                    this.items = JSON.parse(localStorage.getItem('buds_cart') || '[]');
                }
            });

            Alpine.store('checkout', {
                open: false,
                step: 1,
                data: {
                    name: @json(auth()->user()->name ?? ''),
                    phone: @json(auth()->user()->phone ?? ''), address: '',
                    province: '', province_name: '',
                    city: '', city_name: '',
                    district: '', district_name: '',
                    subdistrict: '', subdistrict_name: '',
                    postal_code: ''
                },
                provinces: [],
                cities: [],
                districts: [],
                subdistricts: [],
                async init() {
                    // Load provinsi saat pertama
                    let res = await fetch("https://www.emsifa.com/api-wilayah-indonesia/api/provinces.json");
                    this.provinces = await res.json();
                },
                async fetchCities(province_id) {
                    let res = await fetch(`https://www.emsifa.com/api-wilayah-indonesia/api/regencies/${province_id}.json`);
                    this.cities = await res.json();
                    this.districts = [];
                    this.subdistricts = [];
                },
                async fetchDistricts(city_id) {
                    let res = await fetch(`https://www.emsifa.com/api-wilayah-indonesia/api/districts/${city_id}.json`);
                    this.districts = await res.json();
                    this.subdistricts = [];
                },
                async fetchSubdistricts(district_id) {
                    let res = await fetch(`https://www.emsifa.com/api-wilayah-indonesia/api/villages/${district_id}.json`);
                    this.subdistricts = await res.json();
                },
                paymentMethod: null,
                get paymentMethodLabel() {
                    switch (this.paymentMethod) {
                        case 'bank_transfer': return 'Bank Transfer (BCA, Mandiri, BNI)';
                        case 'e_wallet': return 'E-Wallet (GoPay, OVO, DANA)';
                        default: return '-';
                    }
                },
                validateAddress() {
                    const d = this.data;
                    if (!d.address || !d.province || !d.city || !d.district || !d.subdistrict) {
                        return false;
                    }
                    return true;
                },
                validatePaylentMethod() {
                    if (!this.paymentMethod) {
                        return false;
                    }
                    return true;
                }
            })
        })
    </script>
</head>

<body data-user-id="{{ auth()->id() ?? 'guest' }}" class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100">

        @include('layouts.navigation')

        <!-- Page Heading -->
        @isset($header)
            <header class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endisset

        <!-- Page Content -->
        <main>
            {{ $slot }}
        </main>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const messages = {
                register: @json(session('register_success')),
                admin: @json(session('login_success_admin')),
                customer: @json(session('login_success_customer')),
                logout: @json(session('logout_success'))
            };

            let message = '';
            let type = '';

            if (messages.register) {
                message = messages.register;
                type = 'register';
            } else if (messages.admin) {
                message = messages.admin;
                type = 'admin';
            } else if (messages.customer) {
                message = messages.customer;
                type = 'customer';
            } else if (messages.logout) {
                message = messages.logout;
                type = 'logout';
            }

            if (!message) return; // Tidak ada notifikasi

            // --- Warna berdasarkan type (menggunakan class lengkap untuk Tailwind) ---
            const colorClasses = {
                register: {
                    border: 'border-green-400',
                    bgGradient: 'from-green-400 to-green-500',
                    bgAnimate: 'bg-green-400',
                    progress: 'from-green-400 to-green-500'
                },
                admin: {
                    border: 'border-indigo-400',
                    bgGradient: 'from-indigo-400 to-indigo-500',
                    bgAnimate: 'bg-indigo-400',
                    progress: 'from-indigo-400 to-indigo-500'
                },
                customer: {
                    border: 'border-blue-400',
                    bgGradient: 'from-blue-400 to-blue-500',
                    bgAnimate: 'bg-blue-400',
                    progress: 'from-blue-400 to-blue-500'
                },
                logout: {
                    border: 'border-pink-400',
                    bgGradient: 'from-pink-400 to-pink-500',
                    bgAnimate: 'bg-pink-400',
                    progress: 'from-pink-400 to-pink-500'
                }
            };
            const colors = colorClasses[type] || colorClasses.register;

            // --- Ikon berdasarkan type ---
            const iconMap = {
                register: `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>`,
                admin: `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>`,
                customer: `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>`,
                logout: `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a2 2 0 11-4 0V7a2 2 0 114 0v1" />`
            };
            const icon = iconMap[type] || iconMap.register;

            // --- Judul berdasarkan type ---
            const titleMap = {
                register: 'Registration Successful!',
                admin: 'Admin Login Successful!',
                customer: 'Login Successful!',
                logout: 'Logged Out!'
            };
            const title = titleMap[type] || 'Success!';

            // --- Template Toast ---
            const toast = document.createElement('div');
            toast.id = 'auth-toast';
            toast.className = 'fixed top-20 right-6 z-[60] transform transition-all duration-500 ease-out';
            toast.style.opacity = '0';
            toast.style.transform = 'translateX(400px)';

            toast.innerHTML = `
        <div class="bg-white rounded-xl shadow-2xl border-2 ${colors.border} p-4 flex items-center gap-3 min-w-[320px] max-w-[400px]">
          <div class="relative">
            <div class="absolute inset-0 ${colors.bgAnimate} rounded-full animate-ping opacity-75"></div>
            <div class="relative bg-gradient-to-br ${colors.bgGradient} rounded-full p-2">
              <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                ${icon}
              </svg>
            </div>
          </div>

          <div class="flex-1">
            <p class="font-bold text-gray-800 text-sm mb-1">${title}</p>
            <p class="text-xs text-gray-600">${message}</p>
          </div>

          <button onclick="document.getElementById('auth-toast').remove()" 
                  class="text-gray-400 hover:text-gray-600 transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
          </button>
        </div>

        <div class="h-1 bg-gray-200 rounded-b-xl overflow-hidden mt-1">
          <div class="h-full bg-gradient-to-r ${colors.progress} toast-progress"></div>
        </div>
      `;

            document.body.appendChild(toast);

            // --- Animasi muncul ---
            setTimeout(() => {
                toast.style.opacity = '1';
                toast.style.transform = 'translateX(0)';
            }, 10);

            // --- Auto remove setelah 3 detik ---
            setTimeout(() => {
                toast.style.opacity = '0';
                toast.style.transform = 'translateX(400px)';
                setTimeout(() => toast.remove(), 500);
            }, 3000);
        });

        // --- Animasi progress bar (hanya perlu sekali) ---
        if (!document.getElementById('toast-progress-style')) {
            const style = document.createElement('style');
            style.id = 'toast-progress-style';
            style.textContent = `
      @keyframes progress {
        from { width: 100%; }
        to { width: 0%; }
      }
      .toast-progress {
        animation: progress 3s linear forwards;
      }
    `;
            document.head.appendChild(style);
        }
    </script>
</body>

</html>