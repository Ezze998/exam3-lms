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
    <header x-data="{ scrolled: false, open: false }" x-init="window.addEventListener('scroll', () => scrolled = window.scrollY > 20)"
        :class="scrolled
            ?
            'bg-base-100/80 backdrop-blur-md shadow-lg' :
            'bg-transparent'"
        class="fixed top-0 w-full z-50 transition-all duration-300">

        <nav class="container mx-auto px-6 h-16 flex items-center justify-between">

            {{-- ================= LEFT ================= --}}
            <div class="flex items-center gap-8">

                {{-- Logo --}}
                <a href="/" class="text-2xl font-extrabold text-primary">
                    LMS
                </a>

                {{-- Desktop Menu --}}
                <ul class="hidden md:flex gap-6 font-medium">

                    <li>
                        <a href="/"
                            class="{{ request()->is('/') ? 'text-primary font-semibold' : 'hover:text-primary' }}">
                            Home
                        </a>
                    </li>

                    <li>
                        <a href="/catalog"
                            class="{{ request()->is('catalog*') ? 'text-primary font-semibold' : 'hover:text-primary' }}">
                            Courses
                        </a>
                    </li>

                    <li>
                        <a href="/dashboard"
                            class="{{ request()->is('dashboard*') ? 'text-primary font-semibold' : 'hover:text-primary' }}">
                            Dashboard
                        </a>
                    </li>

                </ul>
            </div>


            {{-- ================= RIGHT ================= --}}
            <div class="hidden md:flex items-center gap-3">

                {{-- SEARCH BAR --}}
                <form action="/catalog" method="GET" class="relative">
                    <input name="search" type="text" placeholder="Search courses..."
                        class="input input-bordered input-sm w-56 pr-10">

                    <button class="absolute right-2 top-1/2 -translate-y-1/2 opacity-60">
                        🔍
                    </button>
                </form>


                @auth

                    <a href="/dashboard" class="btn btn-sm btn-outline">
                        My Learning
                    </a>

                    <form method="POST" action="/logout">
                        @csrf
                        <button class="btn btn-sm btn-error">
                            Logout
                        </button>
                    </form>
                @else
                    <a href="/login" class="btn btn-sm btn-ghost">
                        Sign In
                    </a>

                    <a href="/register" class="btn btn-sm btn-primary">
                        Sign Up
                    </a>

                @endauth
            </div>


            {{-- ================= MOBILE BTN ================= --}}
            <button class="md:hidden btn btn-ghost" @click="open = !open">
                ☰
            </button>
        </nav>


        {{-- ================= MOBILE MENU ================= --}}
        <div x-show="open" x-transition class="md:hidden bg-base-100 border-t shadow-lg">

            <div class="p-4 space-y-3">

                <a href="/" class="block">Home</a>
                <a href="/catalog" class="block">Courses</a>
                <a href="/dashboard" class="block">Dashboard</a>

                <form action="/catalog" method="GET">
                    <input name="search" placeholder="Search..." class="input input-bordered w-full">
                </form>

                @auth
                    <form method="POST" action="/logout">
                        @csrf
                        <button class="btn btn-error w-full">
                            Logout
                        </button>
                    </form>
                @else
                    <a href="/login" class="btn btn-primary w-full">
                        Sign In
                    </a>
                @endauth

            </div>
        </div>

    </header>


    {{-- Spacer biar konten ga ketutup navbar --}}
    <div class="h-16"></div>




    <div class="container mx-auto p-6">
        {{ $slot }}
    </div>

    @livewireScripts
</body>

</html>
