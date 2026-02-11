<!DOCTYPE html>
<html lang="en" data-theme="cupcake">
<head>
    <meta charset="UTF-8">
    <title>{{ $title ?? 'LMS' }} </title>

    @vite('resources/css/app.css')
    @livewireStyles
</head>

<body class="bg-base-200 min-h-screen">

{{-- Navbar --}}
<div class="navbar bg-base-100 shadow-lg">
    <div class="flex-1">
        <a href="/" class="btn btn-ghost text-xl font-bold">
            LMS
        </a>
    </div>

    <div class="flex gap-2">
        @auth
            <a href="/dashboard" class="btn btn-ghost">Dashboard</a>

            <form method="POST" action="/logout">
                @csrf
                <button class="btn btn-error btn-sm">Logout</button>
            </form>
        @else
            <a href="/login" class="btn btn-primary">Login</a>
        @endauth
    </div>
</div>

<div class="container mx-auto p-6">
    {{ $slot }}
</div>

@livewireScripts
</body>
</html>
