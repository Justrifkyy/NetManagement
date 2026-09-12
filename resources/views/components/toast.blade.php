@props([
    'style' => session('error') ? 'danger' : (session('warning') ? 'warning' : 'success'),
    'message' => session('error') ?? session('warning') ?? session('success') ?? session('status'),
])

<div
    x-data="{
        show: @js((bool) $message),
        style: @js($style),
        message: @js($message),
        timeout: null,
        display(detail) {
            this.style = detail.style || 'info';
            this.message = detail.message;
            this.show = true;
            clearTimeout(this.timeout);
            this.timeout = setTimeout(() => this.show = false, 5000);
        }
    }"
    x-init="if (show) timeout = setTimeout(() => show = false, 5000)"
    x-on:toast-message.window="display($event.detail)"
    x-show="show && message"
    x-cloak
    x-transition:enter="transform ease-out duration-300 transition"
    x-transition:enter-start="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2"
    x-transition:enter-end="translate-y-0 opacity-100 sm:translate-x-0"
    x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
    class="fixed top-5 right-5 z-[100] w-[min(24rem,calc(100vw-2rem))] rounded-xl border px-4 py-3 shadow-2xl"
    :class="{
        'border-emerald-500/40 bg-emerald-950/95 text-emerald-100': style === 'success',
        'border-rose-500/40 bg-rose-950/95 text-rose-100': style === 'danger',
        'border-amber-500/40 bg-amber-950/95 text-amber-100': style === 'warning',
        'border-sky-500/40 bg-sky-950/95 text-sky-100': style === 'info'
    }"
    :role="style === 'danger' ? 'alert' : 'status'"
    aria-live="polite"
>
    <div class="flex items-start gap-3">
        <p class="flex-1 text-sm font-semibold" x-text="message"></p>
        <button type="button" class="shrink-0 text-current/70 hover:text-current" aria-label="Tutup" x-on:click="show = false">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
</div>
