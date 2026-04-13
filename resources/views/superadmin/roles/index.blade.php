<x-app-layout>
    <div class="py-10 bg-slate-950 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <h2 class="text-3xl font-extrabold text-white mb-8 px-4 sm:px-0">Pengaturan Role & Akses</h2>

            <div class="bg-slate-900 rounded-xl shadow-sm border border-slate-800 p-6 px-4 sm:px-0">
                <p class="text-slate-300 mb-6">Atur hak akses dan permission untuk setiap role dalam sistem</p>

                <div class="space-y-6">
                    @foreach ($roles as $role)
                        <div class="border-t border-slate-800 pt-6 first:border-t-0 first:pt-0">
                            <h3 class="font-bold text-lg text-white mb-4 capitalize">{{ str_replace('_', ' ', $role) }}</h3>
                            
                            <form action="{{ route('superadmin.roles.updatePermissions') }}" method="POST">
                                @csrf

                                <input type="hidden" name="role" value="{{ $role }}">

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                    @foreach ($permissions[$role] ?? [] as $permKey => $permName)
                                        <label class="flex items-center">
                                            <input type="checkbox" name="permissions[]" value="{{ $permKey }}"
                                                @checked(in_array($permKey, $rolePermissions[$role]->pluck('permission')->toArray() ?? []))
                                                class="rounded">
                                            <span class="ml-2 text-sm text-slate-300">{{ $permName }}</span>
                                        </label>
                                    @endforeach
                                </div>

                                <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 text-sm">
                                    Simpan Permission
                                </button>
                            </form>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
