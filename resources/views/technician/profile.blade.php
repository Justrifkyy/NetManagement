<x-app-layout>
    <div class="py-10 bg-slate-900 min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            <!-- Header -->
            <div class="mb-8 px-4 sm:px-0">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-4xl font-bold text-yellow-400">👤 Profil Teknisi</h1>
                        <p class="text-slate-400 mt-1">Kelola informasi profil Anda</p>
                    </div>
                    <a href="{{ route('technician.dashboard') }}" class="text-yellow-400 hover:text-yellow-300 font-semibold">← Kembali</a>
                </div>
            </div>

            <div class="bg-slate-800 rounded-xl shadow-lg border border-slate-700 overflow-hidden p-6 mx-4 sm:mx-0">
                <h3 class="text-xl font-bold text-yellow-400 mb-6">Informasi Teknisi</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <p class="text-slate-400 text-sm">Nama</p>
                        <p class="text-yellow-300 font-bold text-lg">{{ auth()->user()->name }}</p>
                    </div>
                    <div>
                        <p class="text-slate-400 text-sm">Email</p>
                        <p class="text-yellow-300 font-bold text-lg">{{ auth()->user()->email }}</p>
                    </div>
                    <div>
                        <p class="text-slate-400 text-sm">Role</p>
                        <p class="text-yellow-300 font-bold text-lg">{{ ucfirst(auth()->user()->role) }}</p>
                    </div>
                    <div>
                        <p class="text-slate-400 text-sm">Kode Teknisi</p>
                        <p class="text-yellow-300 font-bold text-lg">{{ auth()->user()->technician_code ?? 'N/A' }}</p>
                    </div>
                </div>

                <div class="mt-8 pt-8 border-t border-slate-700">
                    <a href="{{ route('technician.password') }}" class="bg-yellow-500 hover:bg-yellow-600 text-slate-900 font-bold py-2 px-4 rounded-lg inline-block">
                        🔐 Ganti Password
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
