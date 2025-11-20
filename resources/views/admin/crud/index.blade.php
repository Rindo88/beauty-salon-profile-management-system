@extends('admin.layout')

@section('admin')
<div>
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-bold">{{ $title }}</h1>
        <div class="flex gap-2">
            @if($base==='admin.reservations')
            <a href="{{ route('admin.reservations.export') }}" class="rounded bg-neutral-900 text-white px-4 py-2">Export CSV</a>
            <a href="{{ route('admin.reservations.export.pdf') }}" class="rounded bg-neutral-900 text-white px-4 py-2">Export PDF</a>
            <a href="{{ route('admin.reservations.export.excel') }}" class="rounded bg-neutral-900 text-white px-4 py-2">Export Excel</a>
            @endif
            @if($base==='admin.products')
            <a href="{{ route('admin.products.export') }}" class="rounded bg-neutral-900 text-white px-4 py-2">Export CSV</a>
            <a href="{{ route('admin.products.export.pdf') }}" class="rounded bg-neutral-900 text-white px-4 py-2">Export PDF</a>
            <a href="{{ route('admin.products.export.excel') }}" class="rounded bg-neutral-900 text-white px-4 py-2">Export Excel</a>
            @endif
            <a href="{{ route($base.'.create') }}" class="rounded bg-orange-600 text-white px-4 py-2">Tambah</a>
        </div>
    </div>
    <div class="mt-6 overflow-x-auto">
        <table class="min-w-full text-sm">
            <thead>
                <tr>
                    @foreach($columns as $col)
                        <th class="text-left p-2 border-b">{{ $col }}</th>
                    @endforeach
                    <th class="p-2 border-b">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($items as $item)
                <tr>
                    @foreach($columns as $col)
                        <td class="p-2 border-b">{{ $item->$col }}</td>
                    @endforeach
                    <td class="p-2 border-b whitespace-nowrap">
                        <a href="{{ route($base.'.edit',$item) }}" class="underline">Edit</a>
                        <form action="{{ route($base.'.destroy',$item) }}" method="post" class="inline" onsubmit="return confirm('Hapus data?')">
                            @csrf @method('delete')
                            <button class="text-red-600 underline">Hapus</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @if(method_exists($items,'links'))
    <div class="mt-6">{{ $items->links() }}</div>
    @endif
</div>
@endsection