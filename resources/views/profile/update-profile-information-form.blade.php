<x-form-section submit="updateProfileInformation">
    <x-slot name="title">
        <span class="text-white font-extrabold tracking-tight">{{ __('Informasi Profil') }}</span>
    </x-slot>

    <x-slot name="description">
        <span class="text-slate-400 font-medium">{{ __('Perbarui informasi profil dan alamat email akun Anda.') }}</span>
    </x-slot>

    <x-slot name="form">
        @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
            <div x-data="{photoName: null, photoPreview: null}" class="col-span-6 sm:col-span-4">
                <input type="file" id="photo" class="hidden"
                            wire:model.live="photo"
                            x-ref="photo"
                            x-on:change="
                                    photoName = $refs.photo.files[0].name;
                                    const reader = new FileReader();
                                    reader.onload = (e) => {
                                        photoPreview = e.target.result;
                                    };
                                    reader.readAsDataURL($refs.photo.files[0]);
                            " />

                <label for="photo" class="block text-slate-300 font-bold mb-3">{{ __('Foto Profil') }}</label>

                <div class="mt-2" x-show="! photoPreview">
                    <img src="{{ $this->user->profile_photo_url }}" alt="{{ $this->user->name }}" class="rounded-full size-24 object-cover border-4 border-slate-800 shadow-[0_0_15px_rgba(0,0,0,0.5)]">
                </div>

                <div class="mt-2" x-show="photoPreview" style="display: none;">
                    <span class="block rounded-full size-24 bg-cover bg-no-repeat bg-center border-4 border-indigo-500 shadow-[0_0_20px_rgba(99,102,241,0.4)]"
                          x-bind:style="'background-image: url(\'' + photoPreview + '\');'">
                    </span>
                </div>

                <div class="flex items-center gap-3 mt-5">
                    <button type="button" class="px-5 py-2.5 bg-slate-800 border border-slate-700 rounded-xl text-xs font-bold text-slate-300 uppercase tracking-widest hover:bg-slate-700 hover:text-white transition-all shadow-sm" x-on:click.prevent="$refs.photo.click()">
                        {{ __('Pilih Foto Baru') }}
                    </button>

                    @if ($this->user->profile_photo_path)
                        <button type="button" class="px-5 py-2.5 bg-rose-500/10 border border-rose-500/20 rounded-xl text-xs font-bold text-rose-400 uppercase tracking-widest hover:bg-rose-500/20 hover:text-rose-300 transition-all shadow-sm" wire:click="deleteProfilePhoto">
                            {{ __('Hapus Foto') }}
                        </button>
                    @endif
                </div>

                <x-input-error for="photo" class="mt-2 text-rose-400" />
            </div>
        @endif

        <div class="col-span-6 sm:col-span-4">
            <label for="name" class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">{{ __('Nama Lengkap') }}</label>
            <input id="name" type="text" class="mt-1 block w-full bg-slate-800/50 border-slate-700 text-slate-100 rounded-xl focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500 transition-all placeholder-slate-500" wire:model="state.name" required autocomplete="name" />
            <x-input-error for="name" class="mt-2 text-rose-400" />
        </div>

        <div class="col-span-6 sm:col-span-4">
            <label for="email" class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">{{ __('Alamat Email') }}</label>
            <input id="email" type="email" class="mt-1 block w-full bg-slate-800/50 border-slate-700 text-slate-100 rounded-xl focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500 transition-all placeholder-slate-500" wire:model="state.email" required autocomplete="username" />
            <x-input-error for="email" class="mt-2 text-rose-400" />

            @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::emailVerification()) && ! $this->user->hasVerifiedEmail())
                <div class="mt-3 bg-amber-500/10 border border-amber-500/20 rounded-xl p-4">
                    <p class="text-sm font-medium text-amber-400">
                        {{ __('Alamat email Anda belum terverifikasi.') }}

                        <button type="button" class="underline text-sm text-amber-300 hover:text-white rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500 focus:ring-offset-slate-900 transition-colors mt-1" wire:click.prevent="sendEmailVerification">
                            {{ __('Klik di sini untuk mengirim ulang email verifikasi.') }}
                        </button>
                    </p>

                    @if ($this->verificationLinkSent)
                        <p class="mt-3 font-medium text-sm text-emerald-400 flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            {{ __('Tautan verifikasi baru telah dikirim ke alamat email Anda.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>
    </x-slot>

    <x-slot name="actions">
        <x-action-message class="me-4 text-emerald-400 font-bold flex items-center gap-2" on="saved">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
            {{ __('Berhasil Disimpan.') }}
        </x-action-message>

        <button type="submit" wire:loading.attr="disabled" wire:target="photo" class="inline-flex items-center px-8 py-3 bg-indigo-600 border border-transparent rounded-xl font-bold text-xs text-white uppercase tracking-widest hover:bg-indigo-500 focus:bg-indigo-500 active:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 focus:ring-offset-slate-900 shadow-[0_0_15px_rgba(79,70,229,0.3)] hover:shadow-[0_0_20px_rgba(79,70,229,0.5)] transition-all duration-200 disabled:opacity-50 disabled:cursor-not-allowed">
            {{ __('Simpan Perubahan') }}
        </button>
    </x-slot>
</x-form-section>