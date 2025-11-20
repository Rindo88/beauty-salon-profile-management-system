<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Najwa Salon</title>
    <meta name="description" content="Salon kecantikan dengan layanan profesional dan produk perawatan terbaik.">
    <meta name="theme-color" content="#ff7a00">
    @verbatim
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "BeautySalon",
      "name": "Najwa Salon",
      "telephone": "081319430521",
      "address": {"@type":"PostalAddress","streetAddress":"Jl. Contoh No.123","addressLocality":"Jakarta","addressCountry":"ID"}
    }
    </script>
    @endverbatim
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    @vite(['resources/css/app.css','resources/js/app.js'])
    @if(env('GOOGLE_MAPS_API_KEY'))
    <script src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}" defer></script>
    <script defer>
        const logoUrl = @json(asset('images/logo.svg'));
        function initSalonMap(el, lat, lng) {
            const map = new google.maps.Map(el, { center: {lat, lng}, zoom: 16 });
            const svg = {
                path: 'M20 40c20-20 20-30 0-30',
                strokeColor: '#ff7a00',
                strokeWeight: 4,
                fillOpacity: 0
            };
            const marker = new google.maps.marker.AdvancedMarkerElement({
                map,
                position: {lat, lng},
                content: Object.assign(document.createElement('div'), { innerHTML: "<img src='"+logoUrl+"' width='40' />" })
            });
            const infowindow = new google.maps.InfoWindow({ content: '<strong>Najwa Salon</strong><br>Jl. Contoh No.123, Jakarta' });
            marker.addListener('click', () => infowindow.open({anchor: marker, map}));
        }
    </script>
    @endif
</head>
<body class="min-h-screen bg-neutral-50 text-neutral-900">
    <header class="sticky top-0 z-50 bg-white/90 backdrop-blur border-b">
        <div class="mx-auto max-w-7xl px-4 py-3 flex items-center justify-between">
            <a href="{{ route('home') }}" class="flex items-center gap-2">
                <img src="{{ asset('images/logo.svg') }}" alt="Logo Najwa Salon" class="h-10 w-auto" loading="eager">
                <span class="text-xl font-bold">Najwa Salon</span>
            </a>
            <nav aria-label="Navigasi utama" class="hidden md:flex items-center gap-6">
                <a href="{{ route('home') }}" class="hover:text-orange-600">Home</a>
                <a href="#tentang" class="hover:text-orange-600">Tentang Kami</a>
                <a href="#layanan" class="hover:text-orange-600">Layanan</a>
                <a href="#galeri" class="hover:text-orange-600">Galeri</a>
                <a href="#lokasi" class="hover:text-orange-600">Lokasi</a>
                <a href="#kontak" class="hover:text-orange-600">Kontak</a>
            </nav>
            <div class="flex items-center gap-2">
                <a href="{{ route('reservations.create') }}" class="inline-flex items-center rounded-full bg-orange-600 text-white px-4 py-2 text-sm font-semibold hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-600">Reservasi Online</a>
            </div>
        </div>
    </header>

    <main>
        {{ $slot ?? '' }}
        @yield('content')
    </main>

    <footer id="kontak" class="mt-16 bg-neutral-900 text-neutral-100">
        <div class="mx-auto max-w-7xl px-4 py-10 grid md:grid-cols-4 gap-8">
            <div>
                <h3 class="text-lg font-semibold">Kontak</h3>
                <p class="mt-2">Telepon: <a href="tel:081319430521" class="underline">081319430521</a></p>
                <p>Email: <a href="mailto:hello@najwasalon.id" class="underline">hello@najwasalon.id</a></p>
                <p>Alamat: Jl. Contoh No. 123, Jakarta</p>
            </div>
            <div>
                <h3 class="text-lg font-semibold">Social Media</h3>
                <div class="mt-2 flex gap-3">
                    <a href="#" aria-label="Instagram" class="hover:text-orange-400">Instagram</a>
                    <a href="#" aria-label="Facebook" class="hover:text-orange-400">Facebook</a>
                    <a href="#" aria-label="TikTok" class="hover:text-orange-400">TikTok</a>
                </div>
            </div>
            <div>
                <h3 class="text-lg font-semibold">Quick Links</h3>
                <ul class="mt-2 space-y-2">
                    <li><a href="#layanan" class="hover:text-orange-400">Layanan</a></li>
                    <li><a href="{{ route('products.index') }}" class="hover:text-orange-400">Produk</a></li>
                    <li><a href="{{ route('blog.index') }}" class="hover:text-orange-400">Blog</a></li>
                    <li><a href="{{ route('reservations.create') }}" class="hover:text-orange-400">Reservasi</a></li>
                </ul>
            </div>
            <div class="md:text-right">
                <p class="text-sm">© {{ date('Y') }} Najwa Salon. All rights reserved.</p>
            </div>
        </div>
        <a href="https://wa.me/6281319430521?text=Halo%20Najwa%20Salon,%20saya%20ingin%20reservasi" class="fixed bottom-6 right-6 inline-flex items-center gap-2 bg-green-600 text-white px-4 py-2 rounded-full shadow-lg hover:bg-green-700" aria-label="Hubungi via WhatsApp">WhatsApp</a>
    </footer>
</body>
</html>