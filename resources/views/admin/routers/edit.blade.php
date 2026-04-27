<x-app-layout>
    <div class="py-10 bg-slate-950 min-h-screen selection:bg-indigo-500/30">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="mb-8">
                <a href="{{ route('admin.routers.index') }}" class="inline-flex items-center text-sm font-semibold text-slate-400 hover:text-white transition-colors mb-4 group">
                    <svg class="w-4 h-4 mr-1.5 transform group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Batal Edit
                </a>
                <h2 class="text-3xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-white to-slate-400 tracking-tight">Edit Perangkat Jaringan</h2>
            </div>

            <div class="bg-slate-900/80 backdrop-blur-md rounded-2xl shadow-xl border border-slate-800 p-6 sm:p-8">
                <form action="{{ route('admin.routers.update', $router) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-bold text-slate-300 mb-2">Nama Perangkat <span class="text-rose-500">*</span></label>
                            <input type="text" name="name" value="{{ $router->name }}" required placeholder="Contoh: Router Pusat BTP"
                                class="w-full px-4 py-3 bg-slate-800/50 text-slate-100 border border-slate-700 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500 transition-all placeholder-slate-500">
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-slate-300 mb-2">Lokasi / POP <span class="text-rose-500">*</span></label>
                            <input type="text" name="location" value="{{ $router->location }}" required placeholder="Contoh: POP Antang"
                                class="w-full px-4 py-3 bg-slate-800/50 text-slate-100 border border-slate-700 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500 transition-all placeholder-slate-500">
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-slate-300 mb-2">IP Address <span class="text-rose-500">*</span></label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path></svg>
                                </div>
                                <input type="text" name="ip_address" value="{{ $router->ip_address }}" required placeholder="192.168.x.x"
                                    class="w-full pl-11 pr-4 py-3 bg-slate-800/50 text-sky-400 font-mono font-bold border border-slate-700 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500 transition-all placeholder-slate-500">
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-slate-300 mb-2">Brand / Merek <span class="text-rose-500">*</span></label>
                            <input type="text" name="brand" value="{{ $router->brand }}" required placeholder="Mikrotik, ZTE, Huawei..."
                                class="w-full px-4 py-3 bg-slate-800/50 text-slate-100 border border-slate-700 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500 transition-all placeholder-slate-500">
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-slate-300 mb-2">Tipe Perangkat <span class="text-rose-500">*</span></label>
                            <select name="type" required class="w-full px-4 py-3 bg-slate-800/50 text-slate-100 border border-slate-700 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500 transition-all appearance-none cursor-pointer">
                                <option value="OLT" @selected($router->type === 'OLT') class="bg-slate-800">OLT (Optical Line Terminal)</option>
                                <option value="Router" @selected($router->type === 'Router') class="bg-slate-800">Router / Mikrotik</option>
                                <option value="AP" @selected($router->type === 'AP') class="bg-slate-800">AP (Access Point)</option>
                                <option value="ODP" @selected($router->type === 'ODP') class="bg-slate-800">ODP (Optical Distribution Point)</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-slate-300 mb-2">Status Koneksi</label>
                            <select name="is_active" required class="w-full px-4 py-3 bg-slate-800/50 text-slate-100 border border-slate-700 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500 transition-all appearance-none cursor-pointer">
                                <option value="1" @selected($router->is_active) class="bg-slate-800">Aktif (Online)</option>
                                <option value="0" @selected(!$router->is_active) class="bg-slate-800">Nonaktif (Offline / Down)</option>
                            </select>
                        </div>
                    </div>

                    <div class="flex flex-col sm:flex-row gap-4 pt-6 mt-8 border-t border-slate-800/60">
                        <button type="submit" class="px-8 py-3 bg-indigo-600 text-white font-bold rounded-xl hover:bg-indigo-500 shadow-[0_0_15px_rgba(79,70,229,0.3)] hover:shadow-[0_0_20px_rgba(79,70,229,0.5)] transition-all duration-200 text-center">
                            Simpan Perubahan
                        </button>
                        <a href="{{ route('admin.routers.index') }}" class="px-8 py-3 bg-slate-800 text-slate-300 font-bold rounded-xl border border-slate-700 hover:bg-slate-700 hover:text-white transition-all text-center">
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>