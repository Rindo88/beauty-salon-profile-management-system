@extends('layouts.main')

@section('content')
<div class="mx-auto max-w-7xl px-4 py-10">
    <h1 class="text-2xl font-bold">Produk Perawatan</h1>
    <form class="mt-4 flex items-center gap-3">
        <select name="category" class="border rounded px-3 py-2" onchange="this.form.submit()">
            <option value="">Semua Kategori</option>
            @foreach($categories as $cat)
            <option value="{{ $cat }}" @selected(request('category')===$cat)>{{ $cat }}</option>
            @endforeach
        </select>
        <select name="sort" class="border rounded px-3 py-2" onchange="this.form.submit()">
            <option value="">Urutkan</option>
            <option value="harga" @selected(request('sort')==='harga')>Harga</option>
            <option value="popularitas" @selected(request('sort')==='popularitas')>Popularitas</option>
            <option value="baru" @selected(request('sort')==='baru')>Terbaru</option>
        </select>
    </form>
    <div class="mt-6 grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
        @foreach($products as $p)
        <div class="border rounded-xl overflow-hidden group">
            <img src="{{ asset($p->image_path ?? 'images/product.png') }}" alt="{{ $p->name }}" class="w-full h-48 object-cover" loading="lazy">
            <div class="p-4">
                <h3 class="font-semibold">{{ $p->name }}</h3>
                <p class="text-sm">{{ Str::limit($p->description, 100) }}</p>
                <div class="mt-3 flex items-center gap-2">
                    @if($p->discount_percent)
                        <span class="line-through text-sm">Rp {{ number_format($p->price_cents/100,0,',','.') }}</span>
                        <span class="font-semibold">Rp {{ number_format(($p->price_cents*(100-$p->discount_percent))/10000,0,',','.') }}</span>
                    @else
                        <span class="font-semibold">Rp {{ number_format($p->price_cents/100,0,',','.') }}</span>
                    @endif
                </div>
                <div class="mt-4 flex gap-2">
                    <a href="https://wa.me/6281319430521?text=Halo%20Najwa%20Salon,%20saya%20ingin%20beli%20{{ urlencode($p->name) }}" class="rounded-full bg-green-600 text-white px-4 py-2">Beli via WA</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    <div class="mt-6">
        {{ $products->withQueryString()->links() }}
    </div>
</div>
@endsection