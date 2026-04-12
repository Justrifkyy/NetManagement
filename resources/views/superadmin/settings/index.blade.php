<x-app-layout>
    <div class="py-10 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <h2 class="text-3xl font-extrabold text-gray-900 mb-8 px-4 sm:px-0">Pengaturan Sistem</h2>

            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 px-4 sm:px-0">
                <form action="{{ route('superadmin.settings.update') }}" method="POST" class="space-y-6">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Nama Aplikasi</label>
                            <input type="text" name="app_name" value="{{ $settings['app_name']->value ?? 'NetManagement' }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Nama Perusahaan</label>
                            <input type="text" name="company_name" value="{{ $settings['company_name']->value ?? '' }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">No. Telepon Perusahaan</label>
                            <input type="text" name="company_phone" value="{{ $settings['company_phone']->value ?? '' }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Email Perusahaan</label>
                            <input type="email" name="company_email" value="{{ $settings['company_email']->value ?? '' }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500">
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Alamat Perusahaan</label>
                            <textarea name="company_address" rows="2"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500">{{ $settings['company_address']->value ?? '' }}</textarea>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Timezone</label>
                            <select name="timezone"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500">
                                <option value="Asia/Jakarta" @selected(($settings['timezone']->value ?? '') === 'Asia/Jakarta')>Asia/Jakarta</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Mata Uang</label>
                            <input type="text" name="currency" value="{{ $settings['currency']->value ?? 'IDR' }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Hari Kadaluarsa Password (hari)</label>
                            <input type="number" name="password_expiry_days" value="{{ $settings['password_expiry_days']->value ?? '90' }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Frekuensi Backup</label>
                            <select name="backup_frequency"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500">
                                <option value="daily" @selected(($settings['backup_frequency']->value ?? '') === 'daily')>Harian</option>
                                <option value="weekly" @selected(($settings['backup_frequency']->value ?? '') === 'weekly')>Mingguan</option>
                            </select>
                        </div>
                    </div>

                    <div class="flex gap-4 pt-6 border-t border-gray-200">
                        <label class="flex items-center">
                            <input type="checkbox" name="enable_two_factor" value="1" @checked(($settings['enable_two_factor']->value ?? false))
                                class="rounded">
                            <span class="ml-2 text-sm font-medium text-gray-700">Aktifkan Two-Factor Authentication</span>
                        </label>
                    </div>

                    <div class="flex gap-4 pt-4">
                        <button type="submit" class="px-6 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">
                            Simpan Pengaturan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
