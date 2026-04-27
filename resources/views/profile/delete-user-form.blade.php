<x-action-section>
    <x-slot name="title">
        <span class="text-rose-400 font-extrabold tracking-tight">{{ __('Hapus Akun Permanen') }}</span>
    </x-slot>

    <x-slot name="description">
        <span class="text-slate-400 font-medium">{{ __('Hapus akun Anda secara permanen dari sistem.') }}</span>
    </x-slot>

    <x-slot name="content">
        <div class="max-w-xl text-sm text-slate-400 leading-relaxed">
            {{ __('Peringatan: Setelah akun Anda dihapus, semua sumber daya dan data akan dihapus secara permanen tanpa dapat dikembalikan. Sebelum menghapus, harap unduh atau selamatkan data yang ingin Anda simpan.') }}
        </div>

        <div class="mt-6">
            <button wire:click="confirmUserDeletion" wire:loading.attr="disabled" class="px-6 py-3 bg-rose-600 text-white font-bold rounded-xl hover:bg-rose-500 shadow-[0_0_15px_rgba(225,29,72,0.3)] hover:shadow-[0_0_20px_rgba(225,29,72,0.5)] transition-all duration-200 disabled:opacity-50">
                {{ __('Hapus Akun Saya') }}
            </button>
        </div>

        <x-dialog-modal wire:model.live="confirmingUserDeletion">
            <x-slot name="title">
                <span class="text-rose-400 font-bold">{{ __('Konfirmasi Hapus Akun') }}</span>
            </x-slot>

            <x-slot name="content">
                <p class="text-slate-400 mb-4">{{ __('Apakah Anda yakin ingin menghapus akun Anda secara permanen? Setelah dihapus, semua data akan hilang. Masukkan password Anda untuk mengonfirmasi penghapusan akun.') }}</p>

                <div x-data="{}" x-on:confirming-delete-user.window="setTimeout(() => $refs.password.focus(), 250)">
                    <input type="password" class="mt-1 block w-full bg-slate-800/50 border-slate-700 text-slate-100 rounded-xl focus:ring-2 focus:ring-rose-500/50 focus:border-rose-500 transition-all placeholder-slate-500"
                                autocomplete="current-password"
                                placeholder="{{ __('Masukkan Password') }}"
                                x-ref="password"
                                wire:model="password"
                                wire:keydown.enter="deleteUser" />

                    <x-input-error for="password" class="mt-2 text-rose-400" />
                </div>
            </x-slot>

            <x-slot name="footer">
                <button wire:click="$toggle('confirmingUserDeletion')" wire:loading.attr="disabled" class="px-6 py-2.5 bg-slate-800 text-slate-300 font-bold rounded-xl border border-slate-700 hover:bg-slate-700 hover:text-white transition-all disabled:opacity-50">
                    {{ __('Batal') }}
                </button>

                <button wire:click="deleteUser" wire:loading.attr="disabled" class="ml-3 px-6 py-2.5 bg-rose-600 text-white font-bold rounded-xl hover:bg-rose-500 shadow-[0_0_15px_rgba(225,29,72,0.3)] transition-all disabled:opacity-50">
                    {{ __('Ya, Hapus Permanen') }}
                </button>
            </x-slot>
        </x-dialog-modal>
    </x-slot>
</x-action-section>