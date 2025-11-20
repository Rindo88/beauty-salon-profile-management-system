@extends('layouts.main')

@section('content')
<div class="mx-auto max-w-3xl px-4 py-16 text-center">
    <h1 class="text-2xl font-bold">Terima kasih</h1>
    <p class="mt-4">Reservasi Anda telah kami terima. Konfirmasi dikirim ke email.</p>
    <a href="{{ route('home') }}" class="mt-6 inline-block rounded-full bg-neutral-900 text-white px-5 py-3">Kembali ke beranda</a>
</div>
@endsection