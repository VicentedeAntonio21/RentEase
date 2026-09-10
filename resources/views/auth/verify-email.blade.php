<x-guest-layout>
    <div class="text-center mb-6">
        <span class="inline-flex items-center justify-center w-14 h-14 rounded-full bg-primary/10 text-primary mb-4">
            <i class="ri-mail-check-line text-2xl"></i>
        </span>
        <h2 class="font-heading text-xl font-bold">Verify your email</h2>
        <p class="text-gray-500 dark:text-gray-400 text-sm mt-2">
            Thanks for signing up! Before getting started, please verify your email address by clicking the link we just emailed you. If you didn't receive it, we can send another.
        </p>
    </div>

    @if (session('status') === 'verification-link-sent')
        <div class="mb-4 p-3 bg-success/10 text-success rounded-lg text-sm text-center">
            A new verification link has been sent to the email address you provided during registration.
        </div>
    @endif

    <div class="flex flex-col gap-3">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <button type="submit" class="w-full py-2.5 bg-primary text-white rounded-lg text-sm font-medium hover:bg-primary-dark">
                Resend Verification Email
            </button>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="w-full py-2.5 border border-gray-200 dark:border-white/10 rounded-lg text-sm font-medium text-gray-600 dark:text-gray-300">
                Log Out
            </button>
        </form>
    </div>
</x-guest-layout>