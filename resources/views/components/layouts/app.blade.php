<!DOCTYPE html>
<html lang="en" data-theme="cupcake">

<head>
    <meta charset="UTF-8">
    <title>{{ $title ?? 'LMS' }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>

<body class="bg-[#fdebd0] min-h-screen font-sans">

    <header x-data="{ scrolled: false, open: false }" x-init="window.addEventListener('scroll', () => scrolled = window.scrollY > 20)"
        :class="scrolled ? 'bg-base-100/80 backdrop-blur-lg shadow-xl' : 'bg-transparent'"
        class="fixed top-0 w-full z-50 transition-all duration-300">

        <nav class="mx-auto px-6 h-20 flex items-center max-w-6xl">

            <div class="flex items-center">
                <a href="/" class="text-2xl font-extrabold text-[#6b2f1f] tracking-tight">
                    InnoLearn
                </a>
                <div class="ml-3 text-xs text-[#8b3f2f] opacity-80">Teach & Learn</div>
            </div>

            <div class="flex-1 flex justify-center">
                <ul class="hidden md:flex gap-8 font-medium items-center">
                    <li><a href="/" class="hover:text-[#8b3f2f] text-[#8b3f2f]">Home</a></li>

                    @guest
                        <li><a href="/catalog" class="hover:text-[#8b3f2f] text-[#8b3f2f]">Courses</a></li>
                    @endguest

                    @auth
                        @if (auth()->user()->role === 'student')
                            <li><a href="{{ route('student.my-courses') }}" class="hover:text-[#8b3f2f] text-[#8b3f2f]">My Courses</a></li>
                            <li><a href="{{ route('student.lessons') }}" class="hover:text-[#8b3f2f] text-[#8b3f2f]">Lessons</a></li>
                            <li><a href="/catalog" class="hover:text-[#8b3f2f] text-[#8b3f2f]">Browse Courses</a></li>
                        @elseif (auth()->user()->role === 'teacher')
                            <li><a href="/teacher/dashboard" class="hover:text-[#8b3f2f] text-[#8b3f2f] font-semibold">Courses</a></li>
                        @endif
                    @endauth
                </ul>
            </div>

            <div class="flex items-center gap-4">
                <form action="/catalog" class="hidden md:block">
                    <input name="search" placeholder="Search..." class="input input-bordered input-sm rounded-full px-4" style="width:260px">
                </form>

                @auth
                    <div class="dropdown dropdown-end">
                        <div tabindex="0" class="avatar btn btn-ghost btn-circle">
                            <div class="w-11 h-11 rounded-full bg-[#1f1f1f] text-white flex items-center justify-center text-sm font-semibold">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </div>
                        </div>

                        <ul tabindex="0" class="dropdown-content menu bg-white shadow-lg rounded-box w-48 p-2">
                            <li><a href="/profile">Profile</a></li>
                            @if (auth()->user()->role === 'teacher')
                                <li><a href="/teacher/dashboard">Teacher Panel</a></li>
                            @endif
                            <li>
                                <form id="logout_form" method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button id="logout_btn" type="submit" class="w-full text-left text-error">Logout</button>
                                </form>
                            </li>
                        </ul>
                    </div>
                @else
                    <a href="/login" class="btn btn-ghost btn-sm">Login</a>
                    <a href="/register" class="btn btn-primary btn-sm">Register</a>
                @endauth
            </div>

        </nav>
    </header>

    <div class="h-20"></div>

    <div class="container mx-auto p-6">
        @if(session('success'))
            <div class="alert alert-success mb-4">
                <div>
                    <span>{{ session('success') }}</span>
                </div>
            </div>
        @endif

        @if(session('info'))
            <div class="alert alert-info mb-4">
                <div>
                    <span>{{ session('info') }}</span>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-error mb-4">
                <div>
                    <span>{{ session('error') }}</span>
                </div>
            </div>
        @endif

        {{ $slot }}
    </div>

    @livewireScripts
    <script>
        // show simple toast on save-error events
        window.addEventListener('save-error', function (e) {
            try {
                const msg = e.detail?.message || 'Save error';
                const t = document.createElement('div');
                t.className = 'fixed right-6 bottom-6 bg-red-600 text-white px-4 py-2 rounded shadow-lg z-50';
                t.textContent = msg;
                document.body.appendChild(t);
                setTimeout(() => t.remove(), 5000);
            } catch (err) { console.debug('toast failed', err); }
        });

        window.addEventListener('close-course-modal', function () {
            console.debug('[debug] window event: close-course-modal');
            const d = document.getElementById('course_modal');
            if (d && d.close) { d.close(); console.debug('[debug] closed #course_modal'); }
            else { console.debug('[debug] #course_modal not found or has no close()'); }
        });

        window.addEventListener('close-lesson-modal', function () {
            console.debug('[debug] window event: close-lesson-modal');
            const d = document.getElementById('lesson_modal');
            if (d && d.close) { d.close(); console.debug('[debug] closed #lesson_modal'); }
            else { console.debug('[debug] #lesson_modal not found or has no close()'); }
        });

        // Close modals when Livewire dispatches browser event from component
        document.addEventListener('livewire:load', function () {
            Livewire.on('closeModal', () => {
                console.debug('[debug] Livewire event: closeModal');
                const cm = document.getElementById('course_modal');
                if (cm && cm.close) { cm.close(); console.debug('[debug] closed #course_modal via Livewire'); }
                else { console.debug('[debug] #course_modal not found (Livewire)'); }

                const lm = document.getElementById('lesson_modal');
                if (lm && lm.close) { lm.close(); console.debug('[debug] closed #lesson_modal via Livewire'); }
                else { console.debug('[debug] #lesson_modal not found (Livewire)'); }
            });

            // Also listen for a window-level 'closeModal' browser event (dispatched via dispatchBrowserEvent)
            window.addEventListener('closeModal', function () {
                console.debug('[debug] window event: closeModal');
                const cm = document.getElementById('course_modal');
                if (cm && cm.close) { cm.close(); console.debug('[debug] closed #course_modal via window closeModal'); }
            });
        });

        // Logout debug: ensure clicks are observed and form is submitted
        document.addEventListener('DOMContentLoaded', function () {
            const logoutBtn = document.getElementById('logout_btn');
            const logoutForm = document.getElementById('logout_form');
            if (logoutBtn && logoutForm) {
                logoutBtn.addEventListener('click', function (ev) {
                    console.debug('[debug] logout button clicked');
                    // allow normal submit to proceed, but also ensure submission via JS if prevented
                    setTimeout(function () {
                        if (!logoutForm.__submitted) {
                            try { logoutForm.__submitted = true; logoutForm.submit(); console.debug('[debug] logout form submitted via JS'); } catch (e) { console.debug('[debug] logout submit failed', e); }
                        }
                    }, 50);
                });
            } else {
                console.debug('[debug] logout button/form not found');
            }
        });
    </script>
</body>

</html>
