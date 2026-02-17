<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
    <meta charset="UTF-8">
    <title>{{ config('app.name') }}</title>

    @vite(['resources/css/app.css','resources/js/app.js'])
    @livewireStyles
</head>

<body class="bg-base-200 min-h-screen">


{{-- ===================================================== --}}
{{-- NAVBAR AUTH VERSION --}}
{{-- ===================================================== --}}
<header
    x-data="{ scrolled:false }"
    x-init="window.addEventListener('scroll', () => scrolled = window.scrollY > 10)"
    :class="scrolled
        ? 'bg-base-100/80 backdrop-blur-md shadow-lg'
        : 'bg-base-100'"
    class="fixed w-full top-0 z-50 transition-all duration-300">

    <div class="container mx-auto h-16 px-6 flex items-center justify-between">


        {{-- LEFT --}}
        <div class="flex items-center gap-8">

            <a href="/" class="text-xl font-bold text-primary">
                LMS
            </a>

            <nav class="hidden md:flex gap-6 font-medium">

                <a href="/"
                   class="{{ request()->is('/') ? 'text-primary font-semibold' : 'hover:text-primary' }}">
                    Home
                </a>

                <a href="/catalog"
                   class="{{ request()->is('catalog*') ? 'text-primary font-semibold' : 'hover:text-primary' }}">
                    Courses
                </a>

                <a href="/dashboard"
                   class="{{ request()->is('dashboard*') ? 'text-primary font-semibold' : 'hover:text-primary' }}">
                    Dashboard
                </a>

            </nav>
        </div>



        {{-- RIGHT --}}
        <div class="flex items-center gap-4">


            {{-- SEARCH --}}
            <form action="/catalog" method="GET" class="hidden md:block">
                <input
                    name="search"
                    placeholder="Search courses..."
                    class="input input-bordered input-sm w-64">
            </form>


            {{-- PROFILE DROPDOWN --}}
            <div class="dropdown dropdown-end">

                <label tabindex="0" class="btn btn-ghost btn-circle avatar">
                    <div class="w-10 rounded-full bg-primary text-white flex items-center justify-center font-bold">
                        {{ strtoupper(substr(auth()->user()->name,0,1)) }}
                    </div>
                </label>

                <ul tabindex="0"
                    class="menu menu-sm dropdown-content mt-3 z-[1] p-2 shadow bg-base-100 rounded-box w-48">

                    <li class="menu-title text-xs opacity-70">
                        {{ auth()->user()->name }}
                    </li>

                    <li>
                        <a href="/profile">
                            ✏️ Edit Profile
                        </a>
                    </li>

                    <li>
                        <form method="POST" action="/logout">
                            @csrf
                            <button class="text-error w-full text-left">
                                🚪 Logout
                            </button>
                        </form>
                    </li>

                </ul>
            </div>

        </div>
    </div>
</header>


{{-- spacer biar ga ketutup navbar --}}
<div class="h-16"></div>



{{-- ===================================================== --}}
{{-- CONTENT --}}
{{-- ===================================================== --}}
<main class="container mx-auto px-6 py-8">
    {{ $slot }}
</main>



@livewireScripts
</body>
</html>
