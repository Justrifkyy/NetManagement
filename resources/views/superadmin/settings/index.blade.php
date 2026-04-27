<x-app-layout>
    <div class="py-10 bg-slate-950 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <h2 class="text-3xl font-extrabold text-white mb-8 px-4 sm:px-0">Pengaturan Sistem</h2>

            <div class="bg-slate-900 rounded-xl shadow-sm border border-slate-800 p-6 sm:p-8">
                <form action="{{ route('superadmin.settings.update') }}" method="POST" class="space-y-6">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-slate-300 mb-2">Nama Aplikasi</label>
                            <input type="text" name="app_name" value="{{ $settings['app_name']->value ?? 'NetManagement' }}"
                                class="w-full px-4 py-2 bg-slate-800 text-slate-100 border border-slate-700 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-300 mb-2">Nama Perusahaan</label>
                            <input type="text" name="company_name" value="{{ $settings['company_name']->value ?? '' }}"
                                class="w-full px-4 py-2 bg-slate-800 text-slate-100 border border-slate-700 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-300 mb-2">No. Telepon Perusahaan</label>
                            <input type="text" name="company_phone" value="{{ $settings['company_phone']->value ?? '' }}"
                                class="w-full px-4 py-2 bg-slate-800 text-slate-100 border border-slate-700 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-300 mb-2">Email Perusahaan</label>
                            <input type="email" name="company_email" value="{{ $settings['company_email']->value ?? '' }}"
                                class="w-full px-4 py-2 bg-slate-800 text-slate-100 border border-slate-700 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200">
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-slate-300 mb-2">Alamat Perusahaan</label>
                            <textarea name="company_address" rows="2"
                                class="w-full px-4 py-2 bg-slate-800 text-slate-100 border border-slate-700 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200">{{ $settings['company_address']->value ?? '' }}</textarea>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-300 mb-2">Timezone</label>
                            <select name="timezone"
                                class="w-full px-4 py-2 bg-slate-800 text-slate-100 border border-slate-700 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200">
                                <option value="Asia/Jakarta" @selected(($settings['timezone']->value ?? '') === 'Asia/Jakarta')>Asia/Jakarta</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-300 mb-2">Mata Uang</label>
                            <input type="text" name="currency" value="{{ $settings['currency']->value ?? 'IDR' }}"
                                class="w-full px-4 py-2 bg-slate-800 text-slate-100 border border-slate-700 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-300 mb-2">Hari Kadaluarsa Password (hari)</label>
                            <input type="number" name="password_expiry_days" value="{{ $settings['password_expiry_days']->value ?? '90' }}"
                                class="w-full px-4 py-2 bg-slate-800 text-slate-100 border border-slate-700 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-300 mb-2">Frekuensi Backup</label>
                            <select name="backup_frequency"
                                class="w-full px-4 py-2 bg-slate-800 text-slate-100 border border-slate-700 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200">
                                <option value="daily" @selected(($settings['backup_frequency']->value ?? '') === 'daily')>Harian</option>
                                <option value="weekly" @selected(($settings['backup_frequency']->value ?? '') === 'weekly')>Mingguan</option>
                            </select>
                        </div>
                    </div>

                    <div class="flex gap-4 pt-6 border-t border-slate-800">
                        <label class="flex items-center cursor-pointer group">
                            <input type="checkbox" name="enable_two_factor" value="1" @checked(($settings['enable_two_factor']->value ?? false))
                                class="w-5 h-5 rounded bg-slate-800 border-slate-600 text-blue-600 focus:ring-blue-500 focus:ring-offset-slate-900 transition-colors cursor-pointer">
                            <span class="ml-3 text-sm font-medium text-slate-300 group-hover:text-white transition-colors">Aktifkan Two-Factor Authentication</span>
                        </label>
                    </div>

                    <div class="flex gap-4 pt-4">
                        <button type="submit" class="px-6 py-2.5 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 focus:ring-offset-slate-900 transition-all duration-200 shadow-lg shadow-blue-500/30">
                            Simpan Pengaturan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>