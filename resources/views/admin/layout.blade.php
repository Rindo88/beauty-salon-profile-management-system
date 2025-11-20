@extends('layouts.main')

@section('content')
<div class="mx-auto max-w-7xl px-4 py-10">
    <nav class="mb-6 flex gap-4">
        <a href="{{ route('admin.services.index') }}" class="underline">Services</a>
        <a href="{{ route('admin.products.index') }}" class="underline">Products</a>
        <a href="{{ route('admin.blog.index') }}" class="underline">Blog</a>
        <a href="{{ route('admin.testimonials.index') }}" class="underline">Testimonials</a>
        <a href="{{ route('admin.gallery.index') }}" class="underline">Galeri</a>
        <a href="{{ route('admin.hours.index') }}" class="underline">Jam Operasional</a>
        <a href="{{ route('admin.reservations.index') }}" class="underline">Reservasi</a>
    </nav>
    @yield('admin')
 </div>
@endsection