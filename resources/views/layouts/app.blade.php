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

    <!-- Floating WhatsApp Button -->
    <a href="https://wa.me/6281809740724?text=Hello%20Buds%20Studio!%20I%20want%20to%20ask%20about%20your%20products%20%F0%9F%92%95" 
       target="_blank"
       class="fixed bottom-6 right-6 z-50 group">
        <!-- Button Container -->
        <div class="relative">
            <!-- Pulse Animation Ring -->
            <div class="absolute inset-0 bg-green-400 rounded-full animate-ping opacity-75"></div>
            
            <!-- Main Button -->
            <div class="relative bg-gradient-to-br from-green-400 to-green-600 text-white w-14 h-14 sm:w-16 sm:h-16 rounded-full shadow-lg flex items-center justify-center transition-all duration-300 hover:scale-110 hover:shadow-2xl hover:from-green-500 hover:to-green-700">
                <!-- WhatsApp Icon SVG -->
                <svg class="w-8 h-8 sm:w-9 sm:h-9" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
                </svg>
            </div>
        </div>
        
        <!-- Tooltip Text (appears on hover) -->
        <div class="absolute right-full mr-3 top-1/2 -translate-y-1/2 bg-gray-800 text-white text-sm px-3 py-2 rounded-lg opacity-0 group-hover:opacity-100 transition-opacity duration-300 whitespace-nowrap pointer-events-none">
            Chat with us on WhatsApp
            <!-- Arrow -->
            <div class="absolute right-0 top-1/2 -translate-y-1/2 translate-x-full">
                <div class="border-8 border-transparent border-l-gray-800"></div>
            </div>
        </div>
    </a>
</body>

</html>