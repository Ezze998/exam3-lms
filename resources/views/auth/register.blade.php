<x-layouts.app>

<div class="flex justify-center items-center min-h-[80vh]">

<div class="card w-96 bg-base-100 shadow-xl p-6">

    <h2 class="text-2xl font-bold text-center mb-6">Create Account</h2>

    <form method="POST" action="/register" class="space-y-4">
        @csrf

        <input name="name"
            placeholder="Full Name"
            class="input input-bordered w-full">

        <input type="email" name="email"
            placeholder="Email"
            class="input input-bordered w-full">

        <input type="password" name="password"
            placeholder="Password"
            class="input input-bordered w-full">

        <input type="password" name="password_confirmation"
            placeholder="Confirm Password"
            class="input input-bordered w-full">


        {{-- ROLE --}}
        <div>
            <p class="mb-2 font-semibold">Register as:</p>

            <label class="label cursor-pointer justify-start gap-3">
                <input type="radio" name="role" value="student" checked class="radio radio-primary">
                <span>Student</span>
            </label>

            <label class="label cursor-pointer justify-start gap-3">
                <input type="radio" name="role" value="teacher" class="radio radio-primary">
                <span>Teacher</span>
            </label>
        </div>


        <button class="btn btn-primary w-full">
            Register
        </button>
    </form>

    <p class="text-center mt-4 text-sm">
        Already have account?
        <a href="/login" class="text-primary">Login</a>
    </p>

</div>
</div>

</x-layouts.app>
