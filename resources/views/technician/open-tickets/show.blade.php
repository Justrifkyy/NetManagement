<x-app-layout>
    <div class="min-h-screen bg-slate-950 py-10">
        <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">
            <a href="{{ route('technician.ticket.index') }}" class="text-sm font-bold text-slate-400 hover:text-white">← Kembali ke Bursa Tugas</a>
            <div class="mt-6 rounded-[2.5rem] border border-slate-800 bg-slate-900/80 p-8 shadow-2xl backdrop-blur-md">
                <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-start">
                    <div>
                        <p class="text-xs font-black uppercase tracking-[0.2em] text-sky-400">Detail Tiket #{{ $ticket->id }}</p>
                        <h1 class="mt-2 text-3xl font-black text-white">{{ $ticket->subject ?: 'Tugas Lapangan' }}</h1>
                    </div>
                    <span class="rounded-full bg-sky-500/10 px-3 py-1 text-xs font-bold uppercase text-sky-400">{{ $ticket->type }}</span>
                </div>
                <div class="mt-8 grid gap-6 sm:grid-cols-2">
                    <div><p class="text-xs font-bold uppercase tracking-wider text-slate-500">Pelanggan</p><p class="mt-2 font-bold text-white">{{ $ticket->customer?->user?->name ?? '-' }}</p></div>
                    <div><p class="text-xs font-bold uppercase tracking-wider text-slate-500">Alamat</p><p class="mt-2 text-slate-300">{{ $ticket->customer?->address_installation ?? '-' }}</p></div>
                </div>
                <div class="mt-8 border-t border-slate-800 pt-8">
                    <p class="text-xs font-bold uppercase tracking-wider text-slate-500">Deskripsi Gangguan / Kebutuhan</p>
                    <p class="mt-3 whitespace-pre-line leading-7 text-slate-300">{{ $ticket->description ?: 'Tidak ada deskripsi.' }}</p>
                </div>
                <form method="POST" action="{{ route('technician.ticket.take', $ticket) }}" class="mt-8">
                    @csrf
                    <button type="submit" class="w-full rounded-xl bg-sky-500 px-5 py-3 font-black text-white transition hover:bg-sky-400">Klaim / Ambil Tugas</button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>