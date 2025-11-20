@extends('layouts.main')

@section('content')
<div class="mx-auto max-w-3xl px-4 py-10">
    <h1 class="text-2xl font-bold">Blog</h1>
    <div class="mt-6 space-y-8">
        @foreach($posts as $post)
        <article>
            <a href="{{ route('blog.show',$post->slug) }}" class="text-xl font-semibold hover:text-orange-600">{{ $post->title }}</a>
            <p class="text-sm mt-1">{{ $post->published_at?->format('d M Y') }} • {{ $post->category }}</p>
            <p class="mt-2">{{ $post->excerpt }}</p>
        </article>
        @endforeach
    </div>
    <div class="mt-8">{{ $posts->links() }}</div>
</div>
@endsection