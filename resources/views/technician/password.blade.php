<x-app-layout>
    <div class="py-10 bg-slate-900 min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            <!-- Header -->
            <div class="mb-8 px-4 sm:px-0">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-4xl font-bold text-yellow-400">🔐 Ganti Password</h1>
                        <p class="text-slate-400 mt-1">Ubah password akun Anda</p>
                    </div>
                    <a href="{{ route('technician.profile') }}" class="text-yellow-400 hover:text-yellow-300 font-semibold">← Kembali</a>
                </div>
            </div>

            <div class="bg-slate-800 rounded-xl shadow-lg border border-slate-700 overflow-hidden p-6 mx-4 sm:mx-0">
                <form method="POST" action="#" class="space-y-6">
                    @csrf

                    <!-- Current Password -->
                    <div>
                        <label class="block text-sm font-bold text-yellow-400 mb-2">Password Saat Ini</label>
                        <input type="password" name="current_password" required
                            class="w-full px-4 py-2 bg-slate-700 border border-slate-600 text-slate-100 rounded-lg focus:ring-2 focus:ring-yellow-400 focus:border-transparent">
                    </div>

                    <!-- New Password -->
                    <div>
                        <label class="block text-sm font-bold text-yellow-400 mb-2">Password Baru</label>
                        <input type="password" name="password" required
                            class="w-full px-4 py-2 bg-slate-700 border border-slate-600 text-slate-100 rounded-lg focus:ring-2 focus:ring-yellow-400 focus:border-transparent">
                    </div>

                    <!-- Confirm Password -->
                    <div>
                        <label class="block text-sm font-bold text-yellow-400 mb-2">Konfirmasi Password Baru</label>
                        <input type="password" name="password_confirmation" required
                            class="w-full px-4 py-2 bg-slate-700 border border-slate-600 text-slate-100 rounded-lg focus:ring-2 focus:ring-yellow-400 focus:border-transparent">
                    </div>

                    <div class="flex gap-4">
                        <button type="submit" class="bg-yellow-500 hover:bg-yellow-600 text-slate-900 font-bold py-2 px-6 rounded-lg">
                            Simpan Password Baru
                        </button>
                        <a href="{{ route('technician.profile') }}" class="bg-slate-700 hover:bg-slate-600 text-yellow-300 font-bold py-2 px-6 rounded-lg">
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
