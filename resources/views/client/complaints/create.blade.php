<x-app-layout>
    <div class="py-10 bg-gradient-to-b from-slate-900 to-slate-950 min-h-screen">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">

            <!-- Header -->
            <div class="mb-8 px-4 sm:px-0">
                <a href="{{ route('client.complaints.index') }}" class="text-amber-400 hover:text-amber-300 font-semibold mb-4 inline-flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                    Kembali
                </a>
                <h1 class="text-4xl font-black text-white mt-4">Buat Pengajuan Baru</h1>
                <p class="text-slate-400 mt-2">Laporkan masalah yang Anda alami dengan jelas dan detail</p>
            </div>

            <!-- Form Card -->
            <div class="bg-slate-800 border border-slate-700 rounded-lg p-8 shadow-lg">
                <form action="{{ route('client.complaints.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <!-- Kategori Pengajuan -->
                    <div class="mb-6">
                        <label class="block text-slate-300 font-bold mb-3">Kategori Masalah</label>
                        <div class="space-y-3">
                            <label class="flex items-center p-4 bg-slate-700/50 border border-slate-600 rounded-lg hover:border-amber-500 cursor-pointer transition">
                                <input type="radio" name="category" value="network_slow" class="w-4 h-4" checked>
                                <span class="ml-3 text-slate-300">🐢 Jaringan Lambat / Putus</span>
                            </label>
                            <label class="flex items-center p-4 bg-slate-700/50 border border-slate-600 rounded-lg hover:border-amber-500 cursor-pointer transition">
                                <input type="radio" name="category" value="installation_issue" class="w-4 h-4">
                                <span class="ml-3 text-slate-300">🔧 Masalah Instalasi</span>
                            </label>
                            <label class="flex items-center p-4 bg-slate-700/50 border border-slate-600 rounded-lg hover:border-amber-500 cursor-pointer transition">
                                <input type="radio" name="category" value="billing_issue" class="w-4 h-4">
                                <span class="ml-3 text-slate-300">Pertanyaan Tagihan</span>
                            </label>
                            <label class="flex items-center p-4 bg-slate-700/50 border border-slate-600 rounded-lg hover:border-amber-500 cursor-pointer transition">
                                <input type="radio" name="category" value="other" class="w-4 h-4">
                                <span class="ml-3 text-slate-300">❓ Lainnya</span>
                            </label>
                        </div>
                    </div>

                    <!-- Judul -->
                    <div class="mb-6">
                        <label for="title" class="block text-slate-300 font-bold mb-2">Judul Singkat</label>
                        <input type="text" id="title" name="title" placeholder="Contoh: Internet Putus Sejak Pagi" 
                            class="w-full px-4 py-3 bg-slate-700 border border-slate-600 rounded-lg text-white placeholder-slate-500 focus:border-amber-500 focus:ring-1 focus:ring-amber-500 transition"
                            required>
                    </div>

                    <!-- Deskripsi -->
                    <div class="mb-6">
                        <label for="description" class="block text-slate-300 font-bold mb-2">Deskripsi Detail</label>
                        <textarea id="description" name="description" rows="6" 
                            placeholder="Jelaskan masalah secara detail:&#10;- Kapan masalah terjadi&#10;- Apa gejala yang Anda rasakan&#10;- Apa yang sudah Anda coba lakukan"
                            class="w-full px-4 py-3 bg-slate-700 border border-slate-600 rounded-lg text-white placeholder-slate-500 focus:border-amber-500 focus:ring-1 focus:ring-amber-500 transition"
                            required></textarea>
                    </div>

                    <!-- Prioritas -->
                    <div class="mb-6">
                        <label for="priority" class="block text-slate-300 font-bold mb-2">Tingkat Urgensi</label>
                        <select id="priority" name="priority" 
                            class="w-full px-4 py-3 bg-slate-700 border border-slate-600 rounded-lg text-white focus:border-amber-500 focus:ring-1 focus:ring-amber-500 transition">
                            <option value="low">Rendah - Dapat ditangani kapan saja</option>
                            <option value="medium" selected>Sedang - Dalam beberapa hari</option>
                            <option value="high">Tinggi - Perlu segera ditangani</option>
                            <option value="urgent">Urgen - Internet sama sekali tidak bisa digunakan</option>
                        </select>
                    </div>

                    <!-- Foto/Bukti (Optional) -->
                    <div class="mb-8">
                        <label for="photo" class="block text-slate-300 font-bold mb-2">Foto/Bukti (Opsional)</label>
                        <div class="border-2 border-dashed border-slate-600 rounded-lg p-8 text-center hover:border-amber-500 transition cursor-pointer" onclick="document.getElementById('photo').click()">
                            <svg class="w-12 h-12 text-slate-500 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            <p class="text-slate-400 text-sm">Klik atau seret foto ke sini</p>
                            <p class="text-slate-500 text-xs mt-1">Max 5 MB (PNG, JPG, JPEG)</p>
                        </div>
                        <input type="file" id="photo" name="photo" accept="image/*" class="hidden">
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex gap-4">
                        <a href="{{ route('client.complaints.index') }}" 
                            class="flex-1 px-6 py-3 bg-slate-700 hover:bg-slate-600 text-slate-300 font-bold rounded-lg transition text-center">
                            Batal
                        </a>
                        <button type="submit" 
                            class="flex-1 px-6 py-3 bg-gradient-to-r from-amber-500 to-amber-600 hover:from-amber-400 hover:to-amber-500 text-slate-900 font-bold rounded-lg shadow-lg transform hover:-translate-y-0.5 transition inline-flex items-center justify-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                            Kirim Pengajuan
                        </button>
                    </div>

                    <!-- Info Box -->
                    <div class="mt-8 bg-blue-900/30 border border-blue-500/50 rounded-lg p-4 text-center">
                        <p class="text-blue-300 text-sm">
                            💡 <strong>Tips:</strong> Semakin detail penjelasan Anda, semakin cepat kami bisa membantu
                        </p>
                    </div>
                </form>
            </div>

            <!-- Support Info -->
            <div class="mt-8 px-4 sm:px-0">
                <div class="bg-slate-800/50 border border-slate-700 rounded-lg p-6">
                    <h3 class="font-bold text-white mb-4">Butuh Bantuan Cepat?</h3>
                    <p class="text-slate-400 text-sm mb-4">Hubungi customer support kami melalui:</p>
                    <div class="space-y-2 text-sm">
                        <p class="text-slate-300"><strong>Email:</strong> support@netmanager.com</p>
                        <p class="text-slate-300"><strong>WhatsApp:</strong> +62 821-XXXX-XXXX</p>
                        <p class="text-slate-300"><strong>Jam Kerja:</strong> Senin - Jumat, 08:00 - 17:00</p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
