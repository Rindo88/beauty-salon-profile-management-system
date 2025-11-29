@extends('admin.layout')

@section('admin')
<div class="grid md:grid-cols-3 gap-6">
    <div class="bg-white rounded-xl p-6 border">
        <div class="text-sm">Total Services</div>
        <div class="text-2xl font-bold">{{ \App\Models\Service::count() }}</div>
    </div>
    <div class="bg-white rounded-xl p-6 border">
        <div class="text-sm">Total Products</div>
        <div class="text-2xl font-bold">{{ \App\Models\Product::count() }}</div>
    </div>
    <div class="bg-white rounded-xl p-6 border">
        <div class="text-sm">Total Reservations</div>
        <div class="text-2xl font-bold">{{ \App\Models\Reservation::count() }}</div>
    </div>
</div>
@endsection