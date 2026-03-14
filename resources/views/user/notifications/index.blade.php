<x-app-layout>
    <div class="py-10 bg-slate-50 min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            <div class="mb-8 px-4 sm:px-0">
                <h2 class="text-3xl font-extrabold text-slate-800 tracking-tight">Notifikasi Sistem</h2>
                <p class="text-slate-500 mt-1">Pemberitahuan terkait tagihan, status jaringan, dan info terbaru.</p>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden mx-4 sm:mx-0">
                
                <div class="p-6 border-b border-slate-100 hover:bg-slate-50 transition flex items-start">
                    <div class="w-10 h-10 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center flex-shrink-0 mt-1">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div class="ml-4">
                        <h4 class="font-bold text-slate-800">Selamat Datang di NetManagement!</h4>
                        <p class="text-sm text-slate-600 mt-1">Terima kasih telah bergabung. Layanan internet Anda telah aktif dan siap digunakan.</p>
                        <span class="text-xs text-slate-400 mt-2 block">Baru saja</span>
                    </div>
                </div>

                <div class="p-6 border-b border-slate-100 hover:bg-slate-50 transition flex items-start bg-red-50/30">
                    <div class="w-10 h-10 rounded-full bg-red-100 text-red-600 flex items-center justify-center flex-shrink-0 mt-1">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div class="ml-4">
                        <h4 class="font-bold text-red-700">Tagihan Baru Telah Terbit</h4>
                        <p class="text-sm text-slate-600 mt-1">Tagihan bulan ini telah tersedia. Silakan cek menu tagihan untuk melakukan pembayaran sebelum jatuh tempo.</p>
                        <span class="text-xs text-slate-400 mt-2 block">1 hari yang lalu</span>
                    </div>
                </div>

            </div>

        </div>
    </div>
</x-app-layout>