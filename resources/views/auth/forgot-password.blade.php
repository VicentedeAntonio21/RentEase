<x-guest-layout>
    <div class="mb-6">
        <span class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-primary/10 text-primary mb-3">
            <i class="ri-key-2-line text-xl"></i>
        </span>
        <h2 class="font-heading text-2xl font-bold">Forgot your password?</h2>
        <p class="text-gray-500 dark:text-gray-400 text-sm mt-1">
            No problem. Enter your email and we'll send you a password reset link.
        </p>
    </div>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}" class="space-y-5">
        @csrf

        <x-form-input name="email" label="Email" type="email" icon="ri-mail-line" required autofocus />

        <button type="submit"
                class="w-full py-2.5 bg-primary text-white rounded-lg text-sm font-medium hover:bg-primary-dark flex items-center justify-center gap-2">
            <i class="ri-send-plane-line"></i> Email Password Reset Link
        </button>
    </form>

    <p class="mt-6 text-center text-sm text-gray-500 dark:text-gray-400">
        Remembered your password?
        <a href="{{ route('login') }}" class="text-primary font-medium hover:underline">Back to log in</a>
    </p>
</x-guest-layout>