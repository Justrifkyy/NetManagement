<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>NetManager - ISP Management System</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
        <script src="https://cdn.tailwindcss.com"></script>
    </head>
    <body class="antialiased bg-gray-50 text-gray-800 font-sans">
        
        <nav class="flex items-center justify-between px-6 py-4 bg-white shadow-sm">
            <div class="flex items-center">
                <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                <span class="ml-2 text-xl font-bold text-gray-900">NetManager</span>
            </div>
            <div class="space-x-4">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}" class="text-sm font-semibold text-gray-600 hover:text-blue-600">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="text-sm font-semibold text-gray-600 hover:text-blue-600">Log in</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="px-4 py-2 text-sm font-semibold text-white bg-blue-600 rounded-lg hover:bg-blue-700">Register</a>
                        @endif
                    @endauth
                @endif
            </div>
        </nav>

        <header class="bg-white">
            <div class="container px-6 py-16 mx-auto text-center">
                <div class="max-w-4xl mx-auto">
                    <span class="inline-block p-2 mb-4 text-xs font-semibold tracking-wider text-blue-800 uppercase bg-blue-100 rounded-full">System v1.0</span>
                    <h1 class="text-4xl font-bold text-gray-900 md:text-5xl lg:text-6xl leading-tight">
                        Sistem Manajemen Terpadu <br>
                        <span class="text-blue-600">ISP & WiFi Rumahan</span>
                    </h1>
                    <p class="mt-6 text-lg text-gray-600">
                        Otomatisasi tagihan, manajemen pelanggan, monitoring jaringan MikroTik, dan tracking teknisi dalam satu platform yang aman dan real-time.
                    </p>
                    <div class="mt-8 flex justify-center gap-4">
                        @auth
                            <a href="{{ url('/dashboard') }}" class="px-8 py-3 text-lg font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 shadow-lg transition">
                                Masuk ke Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="px-8 py-3 text-lg font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 shadow-lg transition">
                                Login Staff / Pelanggan
                            </a>
                        @endauth
                    </div>
                </div>
            </div>
        </header>

        <section class="py-16 bg-gray-50">
            <div class="container px-6 mx-auto">
                <div class="grid grid-cols-1 gap-8 md:grid-cols-3">
                    <div class="p-6 bg-white rounded-xl shadow-md border border-gray-100">
                        <div class="w-12 h-12 bg-green-100 text-green-600 rounded-lg flex items-center justify-center mb-4">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900">Billing Otomatis</h3>
                        <p class="mt-2 text-gray-600">Invoice dikirim otomatis via WhatsApp & Email. Integrasi Payment Gateway untuk pembayaran mudah.</p>
                    </div>
                    <div class="p-6 bg-white rounded-xl shadow-md border border-gray-100">
                        <div class="w-12 h-12 bg-red-100 text-red-600 rounded-lg flex items-center justify-center mb-4">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636a9 9 0 010 12.728m0 0l-2.829-2.829m2.829 2.829L21 21M15.536 8.464a5 5 0 010 7.072m0 0l-2.829-2.829m-4.243 2.829a4.978 4.978 0 01-1.414-2.83m-1.414 5.658a9 9 0 01-2.167-9.238m7.824 2.167a1 1 0 111.414 1.414m-1.414-1.414L3 3m8.293 8.293l1.414 1.414"></path></svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900">Auto Isolir</h3>
                        <p class="mt-2 text-gray-600">Telat bayar? Sistem otomatis memutus koneksi via API MikroTik dan menyambung kembali saat lunas.</p>
                    </div>
                    <div class="p-6 bg-white rounded-xl shadow-md border border-gray-100">
                        <div class="w-12 h-12 bg-blue-100 text-blue-600 rounded-lg flex items-center justify-center mb-4">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900">Teknisi Tracking</h3>
                        <p class="mt-2 text-gray-600">Pantau lokasi teknisi saat instalasi dan perbaikan gangguan melalui peta digital.</p>
                    </div>
                </div>
            </div>
        </section>

        <footer class="bg-white border-t border-gray-200">
            <div class="container px-6 py-8 mx-auto text-center text-gray-500">
                <p>&copy; {{ date('Y') }} NetManager. All rights reserved.</p>
            </div>
        </footer>
    </body>
</html>