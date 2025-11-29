<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Dashboard</title>
    @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body class="min-h-screen bg-neutral-100">
    <div class="flex min-h-screen">
        <aside class="w-64 bg-neutral-900 text-neutral-100 p-4 space-y-2">
            <div class="text-xl font-bold">Najwa Admin</div>
            <nav class="mt-4 grid gap-2">
                <a href="{{ route('admin.dashboard') }}" class="px-2 py-1 rounded hover:bg-neutral-800">Dashboard</a>
                <a href="{{ route('admin.services.index') }}" class="px-2 py-1 rounded hover:bg-neutral-800">Services</a>
                <a href="{{ route('admin.products.index') }}" class="px-2 py-1 rounded hover:bg-neutral-800">Products</a>
                <a href="{{ route('admin.blog.index') }}" class="px-2 py-1 rounded hover:bg-neutral-800">Blog</a>
                <a href="{{ route('admin.testimonials.index') }}" class="px-2 py-1 rounded hover:bg-neutral-800">Testimonials</a>
                <a href="{{ route('admin.gallery.index') }}" class="px-2 py-1 rounded hover:bg-neutral-800">Galeri</a>
                <a href="{{ route('admin.hours.index') }}" class="px-2 py-1 rounded hover:bg-neutral-800">Jam Operasional</a>
                <a href="{{ route('admin.reservations.index') }}" class="px-2 py-1 rounded hover:bg-neutral-800">Reservasi</a>
            </nav>
            <form action="{{ route('admin.logout') }}" method="post" class="mt-6">
                @csrf
                <button class="w-full bg-red-600 text-white px-3 py-2 rounded">Logout</button>
            </form>
        </aside>
        <main class="flex-1">
            <header class="bg-white border-b px-6 py-4">Admin Dashboard</header>
            <section class="p-6">
                @yield('admin')
            </section>
        </main>
    </div>
</body>
</html>