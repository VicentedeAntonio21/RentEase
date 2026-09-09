<x-guest-layout>
    <div class="mb-6">
        <h2 class="font-heading text-2xl font-bold">Welcome back</h2>
        <p class="text-gray-500 dark:text-gray-400 text-sm mt-1">Log in to continue to RentEase</p>
    </div>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        <x-form-input name="email" label="Email" type="email" icon="ri-mail-line" required autofocus />

        <div>
            <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Password</label>
            <div class="relative">
                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">
                    <i class="ri-lock-line"></i>
                </span>
                <input type="password" id="password" name="password" required
                       class="w-full rounded-lg border-gray-200 dark:border-white/10 dark:bg-[#1E2235] dark:text-white text-sm focus:ring-primary focus:border-primary pl-10">
            </div>
            @error('password') <p class="mt-1 text-xs text-danger">{{ $message }}</p> @enderror
        </div>

        <div class="flex items-center justify-between">
            <label class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-300">
                <input type="checkbox" name="remember" class="rounded border-gray-300 text-primary focus:ring-primary">
                Remember me
            </label>

            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="text-sm text-primary hover:underline">Forgot password?</a>
            @endif
        </div>

        <button type="submit"
                class="w-full py-2.5 bg-primary text-white rounded-lg text-sm font-medium hover:bg-primary-dark">
            Log In
        </button>
    </form>

    <p class="mt-6 text-center text-sm text-gray-500 dark:text-gray-400">
        Don't have an account?
        <a href="{{ route('register') }}" class="text-primary font-medium hover:underline">Sign up</a>
    </p>
</x-guest-layout>