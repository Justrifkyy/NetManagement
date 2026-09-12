@props([
    'style' => session('global_error') ? 'danger' : 'warning',
    'message' => session('global_error') ?? session('global_warning'),
])

<div
    x-data="{
        show: @js((bool) $message),
        style: @js($style),
        message: @js($message)
    }"
    x-on:global-banner.window="style = $event.detail.style || 'danger'; message = $event.detail.message; show = true"
    x-show="show && message"
    x-cloak
    class="border-b border-rose-500/40 bg-rose-950/95 text-rose-100"
    :class="{ 'border-amber-500/40 bg-amber-950/95 text-amber-100': style === 'warning' }"
    role="alert"
    aria-live="assertive"
>
    <div class="mx-auto flex max-w-screen-xl items-center justify-between gap-4 px-4 py-3 sm:px-6 lg:px-8">
        <p class="text-sm font-semibold" x-text="message"></p>
        <button type="button" class="shrink-0 text-current/70 hover:text-current" aria-label="Tutup" x-on:click="show = false">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
</div>
