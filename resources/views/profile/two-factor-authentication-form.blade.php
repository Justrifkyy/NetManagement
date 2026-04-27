<x-action-section>
    <x-slot name="title">
        <span class="text-white font-extrabold tracking-tight">{{ __('Otentikasi Dua Langkah (2FA)') }}</span>
    </x-slot>

    <x-slot name="description">
        <span class="text-slate-400 font-medium">{{ __('Tambahkan lapisan keamanan ekstra ke akun Anda menggunakan otentikasi dua langkah.') }}</span>
    </x-slot>

    <x-slot name="content">
        <h3 class="text-lg font-bold text-slate-200 mb-2">
            @if ($this->enabled)
                @if ($showingConfirmation)
                    {{ __('Selesaikan pengaktifan otentikasi dua langkah.') }}
                @else
                    {{ __('Anda telah mengaktifkan otentikasi dua langkah.') }}
                @endif
            @else
                {{ __('Anda belum mengaktifkan otentikasi dua langkah.') }}
            @endif
        </h3>

        <div class="mt-3 max-w-xl text-sm text-slate-400 leading-relaxed">
            <p>
                {{ __('Ketika otentikasi dua langkah aktif, Anda akan diminta memasukkan token acak yang aman selama proses login. Token ini bisa Anda dapatkan dari aplikasi Google Authenticator di HP Anda.') }}
            </p>
        </div>

        @if ($this->enabled)
            @if ($showingQrCode)
                <div class="mt-4 max-w-xl text-sm text-slate-400">
                    <p class="font-semibold">
                        @if ($showingConfirmation)
                            {{ __('Untuk menyelesaikan pengaktifan, scan kode QR di bawah menggunakan aplikasi otentikator HP Anda atau masukkan kode setup, lalu berikan kode OTP yang muncul.') }}
                        @else
                            {{ __('Otentikasi dua langkah sekarang telah aktif. Scan kode QR ini dengan aplikasi otentikator Anda atau masukkan kode setup.') }}
                        @endif
                    </p>
                </div>

                <div class="mt-4 p-2 inline-block bg-white rounded-lg">
                    {!! $this->user->twoFactorQrCodeSvg() !!}
                </div>

                <div class="mt-4 max-w-xl text-sm text-slate-400">
                    <p class="font-semibold">
                        {{ __('Kode Setup:') }} <span class="font-mono text-indigo-400">{{ decrypt($this->user->two_factor_secret) }}</span>
                    </p>
                </div>

                @if ($showingConfirmation)
                    <div class="mt-4">
                        <label for="code" class="block text-slate-300 font-bold mb-2">{{ __('Kode OTP') }}</label>
                        <input id="code" type="text" name="code" class="block w-1/2 bg-slate-800/50 border-slate-700 text-slate-100 rounded-xl focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500 transition-all" inputmode="numeric" autofocus autocomplete="one-time-code"
                            wire:model="code"
                            wire:keydown.enter="confirmTwoFactorAuthentication" />
                        <x-input-error for="code" class="mt-2 text-rose-400" />
                    </div>
                @endif
            @endif

            @if ($showingRecoveryCodes)
                <div class="mt-4 max-w-xl text-sm text-slate-400">
                    <p class="font-semibold text-rose-400 bg-rose-500/10 p-3 rounded-lg border border-rose-500/20">
                        {{ __('Simpan kode pemulihan ini di tempat yang aman (password manager). Kode ini bisa digunakan untuk mengembalikan akses akun Anda jika Anda kehilangan akses ke perangkat HP Anda.') }}
                    </p>
                </div>

                <div class="grid gap-1 max-w-xl mt-4 px-4 py-4 font-mono text-sm bg-slate-950 border border-slate-800 rounded-xl text-emerald-400">
                    @foreach (json_decode(decrypt($this->user->two_factor_recovery_codes), true) as $code)
                        <div>{{ $code }}</div>
                    @endforeach
                </div>
            @endif
        @endif

        <div class="mt-6 flex flex-wrap gap-3">
            @if (! $this->enabled)
                <x-confirms-password wire:then="enableTwoFactorAuthentication">
                    <button type="button" wire:loading.attr="disabled" class="px-6 py-2.5 bg-indigo-600 text-white font-bold rounded-xl hover:bg-indigo-500 shadow-[0_0_15px_rgba(79,70,229,0.3)] hover:shadow-[0_0_20px_rgba(79,70,229,0.5)] transition-all duration-200 disabled:opacity-50">
                        {{ __('Aktifkan 2FA') }}
                    </button>
                </x-confirms-password>
            @else
                @if ($showingRecoveryCodes)
                    <x-confirms-password wire:then="regenerateRecoveryCodes">
                        <button type="button" class="px-6 py-2.5 bg-slate-800 text-slate-300 font-bold rounded-xl border border-slate-700 hover:bg-slate-700 hover:text-white transition-all">
                            {{ __('Buat Ulang Kode') }}
                        </button>
                    </x-confirms-password>
                @elseif ($showingConfirmation)
                    <x-confirms-password wire:then="confirmTwoFactorAuthentication">
                        <button type="button" wire:loading.attr="disabled" class="px-6 py-2.5 bg-indigo-600 text-white font-bold rounded-xl hover:bg-indigo-500 shadow-[0_0_15px_rgba(79,70,229,0.3)] transition-all disabled:opacity-50">
                            {{ __('Konfirmasi') }}
                        </button>
                    </x-confirms-password>
                @else
                    <x-confirms-password wire:then="showRecoveryCodes">
                        <button type="button" class="px-6 py-2.5 bg-slate-800 text-slate-300 font-bold rounded-xl border border-slate-700 hover:bg-slate-700 hover:text-white transition-all">
                            {{ __('Tampilkan Kode Pemulihan') }}
                        </button>
                    </x-confirms-password>
                @endif

                @if ($showingConfirmation)
                    <x-confirms-password wire:then="disableTwoFactorAuthentication">
                        <button type="button" wire:loading.attr="disabled" class="px-6 py-2.5 bg-slate-800 text-slate-300 font-bold rounded-xl border border-slate-700 hover:bg-slate-700 hover:text-white transition-all disabled:opacity-50">
                            {{ __('Batal') }}
                        </button>
                    </x-confirms-password>
                @else
                    <x-confirms-password wire:then="disableTwoFactorAuthentication">
                        <button type="button" wire:loading.attr="disabled" class="px-6 py-2.5 bg-rose-500/10 text-rose-400 font-bold rounded-xl border border-rose-500/20 hover:bg-rose-500/20 hover:text-rose-300 transition-all disabled:opacity-50">
                            {{ __('Matikan 2FA') }}
                        </button>
                    </x-confirms-password>
                @endif
            @endif
        </div>
    </x-slot>
</x-action-section>