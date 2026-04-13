<x-app-layout>
    <div class="py-10 bg-slate-50 min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            <div class="mb-8 px-4 sm:px-0">
                <h2 class="text-3xl font-extrabold text-slate-800 tracking-tight">Akun & Profil Saya</h2>
                <p class="text-slate-500 mt-1">Kelola informasi pribadi dan data kontak Anda.</p>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden mx-4 sm:px-0">
                <div class="bg-slate-800 px-8 py-10 text-white flex flex-col md:flex-row items-center gap-6">
                    <div class="w-24 h-24 rounded-full bg-blue-500 flex items-center justify-center text-4xl font-black border-4 border-slate-700">
                        {{ substr(Auth::user()->name, 0, 1) }}
                    </div>
                    <div class="text-center md:text-left">
                        <h3 class="text-2xl font-bold">{{ Auth::user()->name }}</h3>
                        <p class="text-slate-400">{{ Auth::user()->email }}</p>
                        <span class="inline-block mt-2 px-3 py-1 bg-green-500/20 text-green-400 text-xs font-bold rounded-full border border-green-500/30">Pelanggan Aktif</span>
                    </div>
                </div>

                <div class="p-8">
                    <div class="flex justify-between items-center border-b border-slate-200 pb-4 mb-6">
                        <h4 class="text-lg font-bold text-slate-800">Informasi Kontak & Pemasangan</h4>
                        <button class="text-sm font-bold text-amber-400 hover:text-blue-800">Edit Data</button>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Nama Lengkap</label>
                            <p class="text-slate-800 font-medium">{{ Auth::user()->name }}</p>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Email (Login)</label>
                            <p class="text-slate-800 font-medium">{{ Auth::user()->email }}</p>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Nomor WhatsApp / HP</label>
                            <p class="text-slate-800 font-medium">{{ Auth::user()->customer->phone_number ?? '-' }}</p>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">ID Pelanggan</label>
                            <p class="text-slate-800 font-mono font-bold">{{ Auth::user()->customer->customer_code ?? '-' }}</p>
                        </div>
                        <div class="md:col-span-2 mt-4">
                            <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Alamat Pemasangan Internet</label>
                            <div class="p-4 bg-slate-50 rounded-lg border border-slate-100 mt-1">
                                <p class="text-slate-700">{{ Auth::user()->customer->address_installation ?? '-' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
