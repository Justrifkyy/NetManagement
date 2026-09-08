<x-app-layout>
    <div class="min-h-screen bg-slate-950 py-10"><div class="mx-auto max-w-3xl px-4 sm:px-6 lg:px-8">
        <div class="mb-8"><p class="text-xs font-black uppercase tracking-[0.2em] text-indigo-400">Laporan Instalasi #{{ $ticket->id }}</p><h1 class="mt-2 text-3xl font-black text-white">Form Instalasi</h1></div>
        <form method="POST" action="{{ route('technician.process.update', $ticket) }}" enctype="multipart/form-data" class="space-y-6 rounded-[2.5rem] border border-slate-800 bg-slate-900/80 p-8 shadow-2xl backdrop-blur-md">
            @csrf @method('PUT')
            <div class="grid gap-6 sm:grid-cols-2">
                <div><label class="label">Panjang Kabel (meter)</label><input type="number" min="0" step="0.1" name="cable_length" required value="{{ old('cable_length', $ticket->cable_length) }}" class="field"></div>
                <div><label class="label">Merk Perangkat</label><input name="device_brand" required value="{{ old('device_brand', $ticket->device_brand) }}" class="field"></div>
                <div><label class="label">MAC Address</label><input name="device_mac" required value="{{ old('device_mac', $ticket->device_mac) }}" class="field"></div>
                <div><label class="label">Port ODP</label><input name="odp_port" required value="{{ old('odp_port', $ticket->odp_port) }}" class="field"></div>
                <div><label class="label">Sinyal Redaman (dBm)</label><input type="number" step="0.01" name="dbm_signal" required value="{{ old('dbm_signal', $ticket->dbm_signal) }}" class="field"></div>
                <div><label class="label">Status Instalasi</label><select name="installation_status" required class="field"><option value="completed">Selesai</option><option value="pending">Tertunda</option></select></div>
            </div>
            <div><label class="label">Foto Bukti Instalasi</label><input type="file" name="evidence_photo_path" accept="image/*" required class="field"></div>
            <div><label class="label">Catatan Instalasi</label><textarea name="technical_notes" rows="4" class="field">{{ old('technical_notes', $ticket->technical_notes) }}</textarea></div>
            <button class="w-full rounded-xl bg-indigo-500 px-5 py-3 font-black text-white hover:bg-indigo-400">Simpan Laporan Instalasi</button>
        </form>
    </div></div>
    <style>.label{display:block;margin-bottom:.5rem;font-size:.75rem;font-weight:700;text-transform:uppercase;letter-spacing:.05em;color:#94a3b8}.field{width:100%;border-radius:.75rem;border:1px solid #334155;background:#1e293b;color:#e2e8f0;padding:.75rem}.field:focus{outline:2px solid #6366f1}</style>
</x-app-layout>