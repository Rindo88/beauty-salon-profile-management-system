@extends('layouts.main')

@section('content')
<article class="mx-auto max-w-3xl px-4 py-10">
    <h1 class="text-3xl font-bold">{{ $post->title }}</h1>
    <p class="mt-2 text-sm">{{ $post->published_at?->format('d M Y') }} • {{ $post->author_name }} • {{ $post->category }}</p>
    <img src="{{ asset($post->cover_image_path ?? 'images/blog.jpg') }}" alt="{{ $post->title }}" class="mt-6 w-full h-72 object-cover rounded" loading="lazy">
    <div class="prose mt-6">{!! nl2br(e($post->content)) !!}</div>
    <hr class="my-8">
    <h3 class="text-xl font-semibold">Related posts</h3>
    <ul class="mt-3 list-disc list-inside">
        @foreach($related as $rel)
        <li><a href="{{ route('blog.show',$rel->slug) }}" class="hover:text-orange-600">{{ $rel->title }}</a></li>
        @endforeach
    </ul>

    <hr class="my-8">
    <h3 class="text-xl font-semibold">Komentar</h3>
    <div class="mt-4 space-y-4">
        @foreach($comments as $c)
        <div class="border rounded p-3">
            <p class="font-semibold">{{ $c->author_name }}</p>
            <p class="text-sm">{{ $c->created_at->diffForHumans() }}</p>
            <p class="mt-2">{{ $c->content }}</p>
        </div>
        @endforeach
    </div>
    <form action="{{ route('blog.comment.store',$post->slug) }}" method="post" class="mt-6 grid gap-3">
        @csrf
        <label class="grid gap-1"><span>Nama</span><input name="author_name" class="border rounded px-3 py-2"></label>
        <label class="grid gap-1"><span>Komentar</span><textarea name="content" rows="4" class="border rounded px-3 py-2"></textarea></label>
        <button class="rounded bg-orange-600 text-white px-4 py-2">Kirim Komentar</button>
    </form>
</article>
@endsection