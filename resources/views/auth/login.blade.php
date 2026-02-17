<x-layouts.app>

<div class="flex justify-center items-center min-h-[80vh]">

<div class="card w-96 bg-base-100 shadow-xl p-6">

    <h2 class="text-2xl font-bold text-center mb-6">Login</h2>

    <form method="POST" action="/login" class="space-y-4">
        @csrf

        <input type="email" name="email"
            placeholder="Email"
            class="input input-bordered w-full">

        <input type="password" name="password"
            placeholder="Password"
            class="input input-bordered w-full">

        <button class="btn btn-primary w-full">
            Login
        </button>
    </form>

    <p class="text-center mt-4 text-sm">
        No account?
        <a href="/register" class="text-primary">Register</a>
    </p>

</div>
</div>

</x-layouts.app>
