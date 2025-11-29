<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login Admin</title>
    @vite(['resources/css/app.css'])
</head>
<body class="min-h-screen bg-neutral-50 flex items-center justify-center">
    <div class="w-full max-w-md bg-white p-6 rounded-xl shadow">
        <h1 class="text-xl font-bold">Login Admin</h1>
        <form method="post" action="{{ url('/admin/login') }}" class="mt-6 grid gap-4">
            @csrf
            <label class="grid gap-1">
                <span>Email</span>
                <input type="email" name="email" class="border rounded px-3 py-2" value="{{ old('email') }}" required>
            </label>
            <label class="grid gap-1">
                <span>Password</span>
                <input type="password" name="password" class="border rounded px-3 py-2" required>
            </label>
            <label class="inline-flex items-center gap-2">
                <input type="checkbox" name="remember"> <span>Ingat saya</span>
            </label>
            <button class="rounded bg-neutral-900 text-white px-4 py-2">Masuk</button>
            @if($errors->any())
            <div class="bg-red-50 text-red-700 p-2 rounded">Email atau password salah.</div>
            @endif
        </form>
    </div>
</body>
</html>