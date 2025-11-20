@extends('admin.layout')

@section('admin')
<div>
    <h1 class="text-2xl font-bold">{{ $title }}</h1>
    <form action="{{ $action }}" method="post" class="mt-6 grid grid-cols-1 gap-4">
        @csrf
        @if($method!=='post') @method($method) @endif
        @foreach($fields as $name => $def)
            <label class="grid gap-1">
                <span>{{ $def['label'] }}</span>
                @if($def['type']==='textarea')
                    <textarea name="{{ $name }}" rows="4" class="border rounded px-3 py-2">{{ old($name, $model->$name ?? '') }}</textarea>
                @elseif($def['type']==='checkbox')
                    <input type="checkbox" name="{{ $name }}" value="1" @checked(old($name, $model->$name ?? false))>
                @else
                    <input type="{{ $def['type'] }}" name="{{ $name }}" class="border rounded px-3 py-2" value="{{ old($name, $model->$name ?? '') }}">
                @endif
            </label>
        @endforeach
        <button class="rounded bg-orange-600 text-white px-5 py-3">Simpan</button>
    </form>
</div>
@endsection