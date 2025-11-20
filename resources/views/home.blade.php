@extends('layouts.main')

@section('content')
<section class="relative">
    <div class="mx-auto max-w-7xl px-4 py-10 grid md:grid-cols-2 gap-8 items-center">
        <div>
            <h1 class="text-3xl md:text-5xl font-bold">Rasakan Perawatan Premium di Najwa Salon</h1>
            <p class="mt-4 text-lg">Layanan profesional, produk berkualitas, dan pengalaman yang memanjakan. Reservasi mudah, hasil maksimal.</p>
            <div class="mt-6 flex gap-3">
                <a href="{{ route('reservations.create') }}" class="rounded-full bg-orange-600 text-white px-5 py-3 font-semibold hover:bg-orange-700">Reservasi Sekarang</a>
                <a href="#layanan" class="rounded-full border border-orange-600 text-orange-600 px-5 py-3 font-semibold hover:bg-orange-50">Layanan Populer</a>
            </div>
        </div>
        <div class="aspect-video rounded-xl bg-gradient-to-br from-orange-100 to-purple-100 overflow-hidden">
            <img src="{{ asset('images/hero.webp') }}" alt="Interior Najwa Salon" class="w-full h-full object-cover" loading="eager" onerror="this.style.display='none'">
        </div>
    </div>
</section>

<section id="tentang" class="mx-auto max-w-7xl px-4 py-12">
    <div class="grid md:grid-cols-2 gap-8 items-center">
        <div>
            <img src="{{ asset('images/owner.jpg') }}" alt="Pemilik Najwa Salon" class="w-full h-72 object-cover rounded-lg" loading="lazy">
        </div>
        <div>
            <h2 class="text-2xl font-bold">Tentang Kami</h2>
            <p class="mt-4">Najwa Salon menghadirkan perawatan rambut dan kecantikan dengan tim profesional berpengalaman. Kami fokus pada kenyamanan, kebersihan, dan hasil terbaik untuk setiap pelanggan.</p>
            <ul class="mt-4 grid sm:grid-cols-2 gap-3">
                <li class="p-4 border rounded-lg">Stylists berpengalaman</li>
                <li class="p-4 border rounded-lg">Produk premium</li>
                <li class="p-4 border rounded-lg">Reservasi fleksibel</li>
                <li class="p-4 border rounded-lg">Garansi kepuasan</li>
            </ul>
        </div>
    </div>
</section>

<section id="layanan" class="bg-white">
    <div class="mx-auto max-w-7xl px-4 py-12">
        <h2 class="text-2xl font-bold">Layanan</h2>
        <div class="mt-6 grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($services as $service)
            <div class="group border rounded-xl overflow-hidden">
                <div class="p-4">
                    <div class="flex items-center gap-3">
                        <img src="{{ asset($service->icon_path ?? 'images/service.svg') }}" alt="{{ $service->name }}" class="h-8 w-8" loading="lazy">
                        <h3 class="font-semibold">{{ $service->name }}</h3>
                    </div>
                    <p class="mt-2 text-sm">{{ Str::limit($service->description, 120) }}</p>
                    <div class="mt-4 flex items-center justify-between">
                        <span class="text-sm">{{ $service->duration_minutes }} menit</span>
                        <span class="font-semibold">Rp {{ number_format($service->price_cents/100,0,',','.') }}</span>
                    </div>
                    <a href="{{ route('reservations.create') }}" class="mt-4 inline-block rounded-full bg-neutral-900 text-white px-4 py-2 text-sm hover:bg-neutral-800">Detail</a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<section id="galeri" class="bg-neutral-50">
    <div class="mx-auto max-w-7xl px-4 py-12">
        <h2 class="text-2xl font-bold">Galeri</h2>
        <div class="mt-6 grid sm:grid-cols-2 md:grid-cols-3 gap-4">
            @foreach($gallery as $photo)
            <a href="{{ asset($photo->image_path) }}" class="block" data-lightbox>
                <img src="{{ asset($photo->image_path) }}" alt="{{ $photo->alt_text }}" class="w-full h-48 object-cover rounded-lg" loading="lazy">
            </a>
            @endforeach
        </div>
    </div>
</section>

<section id="lokasi" class="mx-auto max-w-7xl px-4 py-12">
    <h2 class="text-2xl font-bold">Lokasi</h2>
    <div class="mt-6 grid md:grid-cols-2 gap-6 items-start">
        @if(env('GOOGLE_MAPS_API_KEY'))
            <div id="map" class="w-full h-[400px] rounded" aria-label="Peta Najwa Salon"></div>
            <script defer>document.addEventListener('DOMContentLoaded',()=>{ if (typeof initSalonMap==='function') initSalonMap(document.getElementById('map'), -6.2, 106.816666); });</script>
        @else
            <iframe title="Peta Najwa Salon" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d991.0000000001!2d106.816666!3d-6.200000" width="600" height="400" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        @endif
        <div>
            <p>Jl. Contoh No. 123, Menteng, Jakarta Pusat</p>
            <div class="mt-4">
                <h3 class="font-semibold">Jam Operasional</h3>
                <ul class="mt-2 space-y-1">
                    @foreach($hours as $h)
                    <li>{{ ['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'][$h->day_of_week] }}: {{ $h->is_closed ? 'Tutup' : $h->open_time.' - '.$h->close_time }}</li>
                    @endforeach
                </ul>
                <div class="mt-4 flex gap-3">
                    <a class="rounded-full bg-blue-600 text-white px-4 py-2" href="https://www.google.com/maps?q=Najwa+Salon" target="_blank" rel="noopener">Google Maps</a>
                    <a class="rounded-full bg-blue-600 text-white px-4 py-2" href="https://waze.com/ul?q=Najwa+Salon" target="_blank" rel="noopener">Waze</a>
                </div>
                <div class="mt-4 inline-flex items-center gap-2">
                    <span class="inline-block h-2 w-2 rounded-full {{ $isOpenNow ? 'bg-green-600' : 'bg-red-600' }}"></span>
                    <span>{{ $isOpenNow ? 'Buka Sekarang' : 'Tutup Saat Ini' }}</span>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="mx-auto max-w-7xl px-4 py-12">
    <h2 class="text-2xl font-bold">Testimoni</h2>
    <div class="mt-6 grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($testimonials as $t)
        <div class="border rounded-xl p-4">
            <div class="flex items-center gap-3">
                <img src="{{ asset($t->photo_path ?? 'images/avatar.png') }}" alt="{{ $t->customer_name }}" class="h-12 w-12 rounded-full object-cover" loading="lazy">
                <div>
                    <p class="font-semibold">{{ $t->customer_name }}</p>
                    <p class="text-sm">{{ str_repeat('★', $t->rating) }}</p>
                </div>
            </div>
            <p class="mt-3 text-sm">{{ $t->content }}</p>
        </div>
        @endforeach
    </div>
</section>
@endsection