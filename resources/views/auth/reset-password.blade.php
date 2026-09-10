<x-guest-layout>
    <div class="mb-6">
        <span class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-primary/10 text-primary mb-3">
            <i class="ri-lock-password-line text-xl"></i>
        </span>
        <h2 class="font-heading text-2xl font-bold">Reset your password</h2>
        <p class="text-gray-500 dark:text-gray-400 text-sm mt-1">
            Choose a new password for your account.
        </p>
    </div>

    <form method="POST" action="{{ route('password.store') }}" class="space-y-5">
        @csrf

        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <x-form-input name="email" label="Email" type="email" icon="ri-mail-line" :value="old('email', $request->email)" required autofocus />

        <div>
            <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">New Password</label>
            <div class="relative">
                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"><i class="ri-lock-line"></i></span>
                <input type="password" id="password" name="password" required autocomplete="new-password"
                       class="w-full rounded-lg border-gray-200 dark:border-white/10 dark:bg-[#1E2235] dark:text-white text-sm focus:ring-primary focus:border-primary pl-10">
            </div>
            @error('password') <p class="mt-1 text-xs text-danger">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Confirm New Password</label>
            <div class="relative">
                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"><i class="ri-lock-line"></i></span>
                <input type="password" id="password_confirmation" name="password_confirmation" required autocomplete="new-password"
                       class="w-full rounded-lg border-gray-200 dark:border-white/10 dark:bg-[#1E2235] dark:text-white text-sm focus:ring-primary focus:border-primary pl-10">
            </div>
            @error('password_confirmation') <p class="mt-1 text-xs text-danger">{{ $message }}</p> @enderror
        </div>

        <button type="submit"
                class="w-full py-2.5 bg-primary text-white rounded-lg text-sm font-medium hover:bg-primary-dark">
            Reset Password
        </button>
    </form>
</x-guest-layout>