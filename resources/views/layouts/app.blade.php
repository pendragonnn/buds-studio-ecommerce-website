<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.tailwindcss.min.css">

    <!-- DataTables JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.tailwindcss.min.js"></script>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/js/cart.js'])

    <!-- Alpine.js x-cloak styling -->
    <style>
        [x-cloak] {
            display: none !important;
        }
        /* Optional: Custom animation for smoother pulse */
        @keyframes smooth-pulse {
            0%, 100% {
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
</body>

</html>