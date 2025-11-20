@extends('layouts.main')

@section('content')
<div class="mx-auto max-w-3xl px-4 py-10">
    <h1 class="text-2xl font-bold">Reservasi Online</h1>
    <form action="{{ route('reservations.store') }}" method="post" class="mt-6 grid grid-cols-1 gap-4">
        @csrf
        <label class="grid gap-1">
            <span>Nama Pelanggan</span>
            <input name="customer_name" type="text" required class="border rounded px-3 py-2" value="{{ old('customer_name') }}">
        </label>
        <label class="grid gap-1">
            <span>Nomor Telepon</span>
            <input name="phone" type="text" required class="border rounded px-3 py-2" value="{{ old('phone') }}" placeholder="08xxx">
        </label>
        <label class="grid gap-1">
            <span>Email</span>
            <input name="email" type="email" required class="border rounded px-3 py-2" value="{{ old('email') }}">
        </label>
        <div class="grid md:grid-cols-2 gap-4">
            <label class="grid gap-1">
                <span>Tanggal</span>
                <input name="date" type="date" required class="border rounded px-3 py-2" value="{{ old('date') }}">
            </label>
            <label class="grid gap-1">
                <span>Waktu</span>
                <select id="timeSlot" name="time_slot" required class="border rounded px-3 py-2">
                    <option value="">Pilih waktu</option>
                </select>
            </label>
        </div>
        <label class="grid gap-1">
            <span>Jenis Layanan</span>
            <select name="service_id" required class="border rounded px-3 py-2">
                <option value="">Pilih layanan</option>
                @foreach($services->groupBy('category') as $category => $items)
                    <optgroup label="{{ $category ?: 'Umum' }}">
                        @foreach($items as $s)
                            <option value="{{ $s->id }}">{{ $s->name }}</option>
                        @endforeach
                    </optgroup>
                @endforeach
            </select>
        </label>
        <label class="grid gap-1">
            <span>Preferensi Stylist (opsional)</span>
            <select name="stylist_preference" class="border rounded px-3 py-2">
                <option value="">Tidak ada</option>
                @foreach($stylists as $sty)
                <option value="{{ $sty }}">{{ $sty }}</option>
                @endforeach
            </select>
        </label>
        <label class="grid gap-1">
            <span>Catatan Khusus (opsional)</span>
            <textarea name="notes" rows="4" class="border rounded px-3 py-2">{{ old('notes') }}</textarea>
        </label>
        <button class="mt-4 rounded-full bg-orange-600 text-white px-5 py-3 font-semibold hover:bg-orange-700">Kirim Reservasi</button>
        @if($errors->any())
        <div class="mt-4 bg-red-50 text-red-700 p-3 rounded">Terjadi kesalahan pada data. Periksa kembali.</div>
        @endif
    </form>
    <script>
    const hours = @json($hours);
    function genSlots(dateStr) {
        const d = new Date(dateStr);
        if (isNaN(d)) return [];
        const day = d.getDay();
        const cfg = hours.find(h => h.day_of_week === day);
        if (!cfg || cfg.is_closed) return [];
        const start = cfg.open_time?.substring(0,5) || '09:00';
        const end = cfg.close_time?.substring(0,5) || '18:00';
        const breakStart = cfg.break_start?.substring(0,5);
        const breakEnd = cfg.break_end?.substring(0,5);
        const slots = [];
        let cur = start;
        function addMinutes(t, m){const [H,M]=t.split(':').map(Number);const d=new Date();d.setHours(H,M+m,0,0);return `${String(d.getHours()).padStart(2,'0')}:${String(d.getMinutes()).padStart(2,'0')}`}
        while (cur <= end) {
            if (!(breakStart && breakEnd && cur >= breakStart && cur < breakEnd)) slots.push(cur);
            cur = addMinutes(cur, 60);
        }
        return slots;
    }
    function refreshSlots(){
        const select = document.getElementById('timeSlot');
        const dateInput = document.querySelector('input[name="date"]');
        const slots = genSlots(dateInput.value);
        select.innerHTML = '<option value="">Pilih waktu</option>' + slots.map(s=>`<option>${s}</option>`).join('');
    }
    document.addEventListener('DOMContentLoaded', ()=>{
        const dateInput = document.querySelector('input[name="date"]');
        dateInput.addEventListener('change', refreshSlots);
        if (dateInput.value) refreshSlots();
    });
    </script>
</div>
@endsection