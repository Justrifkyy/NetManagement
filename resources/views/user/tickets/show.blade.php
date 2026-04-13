<x-app-layout>
    <div class="py-10 bg-slate-50 min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 text-center pt-20">
            <h2 class="text-2xl font-bold text-slate-800">Detail Laporan Keluhan</h2>
            <p class="text-slate-500 mt-2">Halaman ini akan terisi otomatis saat Anda sudah mengklik salah satu tiket dari daftar keluhan.</p>
            <a href="{{ route('client.tickets.index') }}" class="inline-block mt-6 px-6 py-2 bg-slate-200 font-bold rounded-lg text-slate-700">Kembali</a>
        </div>
    </div>
</x-app-layout>
