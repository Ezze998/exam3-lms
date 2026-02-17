<!DOCTYPE html>
<html lang="en" data-theme="cupcake">

<head>
    <meta charset="UTF-8">
    <title>{{ $title ?? 'LMS' }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>

<body class="bg-base-200 min-h-screen">

    <header x-data="{ scrolled: false, open: false }" x-init="window.addEventListener('scroll', () => scrolled = window.scrollY > 20)"
        :class="scrolled ? 'bg-base-100/80 backdrop-blur-lg shadow-xl' : 'bg-transparent'"
        class="fixed top-0 w-full z-50 transition-all duration-300">

        <nav class="container mx-auto px-6 h-16 flex items-center justify-between">

            {{-- LEFT --}}
            <div class="flex items-center gap-8">

                <a href="/" class="text-2xl font-extrabold text-primary">
                    LMS
                </a>

                <ul class="hidden md:flex gap-6 font-medium">

                    <li><a href="/" class="hover:text-primary">Home</a></li>
                    <li><a href="/catalog" class="hover:text-primary">Courses</a></li>

                    @auth
                        <li><a href="/dashboard" class="hover:text-primary">My Learning</a></li>
                    @endauth

                    {{-- ⭐ Teacher menu --}}
                    @auth
                        @if (auth()->user()->role === 'teacher')
                            <li>
                                <a href="/teacher/dashboard" class="text-secondary font-semibold">
                                    Manage Courses
                                </a>
                            </li>
                        @endif
                    @endauth

                </ul>
            </div>


            {{-- RIGHT --}}
            <div class="hidden md:flex items-center gap-3">

                <form action="/catalog">
                    <input name="search" placeholder="Search..." class="input input-bordered input-sm">
                </form>

                @auth
                    {{-- Avatar dropdown --}}
                    <div class="dropdown dropdown-end">
                        <div tabindex="0" class="avatar btn btn-ghost btn-circle">
                            <div class="w-10 rounded-full bg-primary text-white flex items-center justify-center">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </div>
                        </div>

                        <ul tabindex="0" class="dropdown-content menu bg-base-100 shadow-lg rounded-box w-44 p-2">

                            <li><a href="/profile">Profile</a></li>

                            @if (auth()->user()->role === 'teacher')
                                <li><a href="/teacher/dashboard">Teacher Panel</a></li>
                            @endif

                            
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="btn btn-error btn-sm">
                                        Logout
                                    </button>
                                </form>

                            
                        </ul>
                    </div>
                @else
                    <a href="/login" class="btn btn-ghost btn-sm">Login</a>
                    <a href="/register" class="btn btn-primary btn-sm">Register</a>
                @endauth
            </div>
        </nav>
    </header>

    <div class="h-16"></div>

    <div class="container mx-auto p-6">
        {{ $slot }}
    </div>

    @livewireScripts
</body>

</html>
