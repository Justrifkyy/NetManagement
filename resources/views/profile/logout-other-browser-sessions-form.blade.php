<x-action-section>
    <x-slot name="title">
        <span class="text-white font-extrabold tracking-tight">{{ __('Sesi Perangkat & Browser') }}</span>
    </x-slot>

    <x-slot name="description">
        <span class="text-slate-400 font-medium">{{ __('Kelola dan keluarkan sesi aktif Anda di perangkat atau browser lain.') }}</span>
    </x-slot>

    <x-slot name="content">
        <div class="max-w-xl text-sm text-slate-400 leading-relaxed">
            {{ __('Jika diperlukan, Anda dapat logout (keluar) dari semua sesi browser Anda di seluruh perangkat. Beberapa sesi terakhir Anda ada di bawah ini; daftar ini mungkin tidak menyeluruh. Jika Anda merasa akun Anda telah disusupi, segera ubah password Anda.') }}
        </div>

        @if (count($this->sessions) > 0)
            <div class="mt-5 space-y-4">
                @foreach ($this->sessions as $session)
                    <div class="flex items-center bg-slate-800/30 p-4 rounded-xl border border-slate-700/30">
                        <div>
                            @if ($session->agent->isDesktop())
                                <svg class="w-8 h-8 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                            @else
                                <svg class="w-8 h-8 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                </svg>
                            @endif
                        </div>

                        <div class="ml-4">
                            <div class="text-sm text-slate-200 font-bold">
                                {{ $session->agent->platform() ? $session->agent->platform() : __('Tidak Diketahui') }} - {{ $session->agent->browser() ? $session->agent->browser() : __('Tidak Diketahui') }}
                            </div>

                            <div>
                                <div class="text-xs text-slate-500 font-medium mt-0.5">
                                    {{ $session->ip_address }},

                                    @if ($session->is_current_device)
                                        <span class="text-emerald-400 font-bold ml-1">{{ __('Perangkat Ini') }}</span>
                                    @else
                                        {{ __('Terakhir aktif') }} {{ $session->last_active }}
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

        <div class="flex items-center mt-6">
            <button wire:click="confirmLogout" wire:loading.attr="disabled" class="px-6 py-3 bg-amber-600 text-white font-bold rounded-xl hover:bg-amber-500 shadow-[0_0_15px_rgba(217,119,6,0.3)] hover:shadow-[0_0_20px_rgba(217,119,6,0.5)] transition-all duration-200 disabled:opacity-50">
                {{ __('Logout dari Perangkat Lain') }}
            </button>

            <x-action-message class="ml-4 text-emerald-400 font-bold flex items-center gap-2" on="loggedOut">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                {{ __('Berhasil Selesai.') }}
            </x-action-message>
        </div>

        <x-dialog-modal wire:model.live="confirmingLogout">
            <x-slot name="title">
                <span class="text-white font-bold">{{ __('Logout dari Perangkat Lain') }}</span>
            </x-slot>

            <x-slot name="content">
                <p class="text-slate-400 mb-4">{{ __('Silakan masukkan password Anda untuk mengonfirmasi bahwa Anda ingin mengeluarkan sesi dari seluruh perangkat Anda yang lain.') }}</p>

                <div x-data="{}" x-on:confirming-logout-other-browser-sessions.window="setTimeout(() => $refs.password.focus(), 250)">
                    <input type="password" class="mt-1 block w-full bg-slate-800/50 border-slate-700 text-slate-100 rounded-xl focus:ring-2 focus:ring-amber-500/50 focus:border-amber-500 transition-all placeholder-slate-500"
                                autocomplete="current-password"
                                placeholder="{{ __('Masukkan Password') }}"
                                x-ref="password"
                                wire:model="password"
                                wire:keydown.enter="logoutOtherBrowserSessions" />

                    <x-input-error for="password" class="mt-2 text-rose-400" />
                </div>
            </x-slot>

            <x-slot name="footer">
                <button wire:click="$toggle('confirmingLogout')" wire:loading.attr="disabled" class="px-6 py-2.5 bg-slate-800 text-slate-300 font-bold rounded-xl border border-slate-700 hover:bg-slate-700 hover:text-white transition-all disabled:opacity-50">
                    {{ __('Batal') }}
                </button>

                <button wire:click="logoutOtherBrowserSessions" wire:loading.attr="disabled" class="ml-3 px-6 py-2.5 bg-amber-600 text-white font-bold rounded-xl hover:bg-amber-500 shadow-[0_0_15px_rgba(217,119,6,0.3)] transition-all disabled:opacity-50">
                    {{ __('Lanjutkan Logout') }}
                </button>
            </x-slot>
        </x-dialog-modal>
    </x-slot>
</x-action-section>