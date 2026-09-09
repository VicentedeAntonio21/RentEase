<x-guest-layout>
    <div class="mb-6">
        <h2 class="font-heading text-2xl font-bold">Create your account</h2>
        <p class="text-gray-500 dark:text-gray-400 text-sm mt-1">Join RentEase as a renter or property owner</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-5">
        @csrf

        <x-form-input name="name" label="Full Name" icon="ri-user-line" required autofocus />
        <x-form-input name="email" label="Email" type="email" icon="ri-mail-line" required />

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

        <div>
            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Confirm Password</label>
            <div class="relative">
                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">
                    <i class="ri-lock-line"></i>
                </span>
                <input type="password" id="password_confirmation" name="password_confirmation" required
                       class="w-full rounded-lg border-gray-200 dark:border-white/10 dark:bg-[#1E2235] dark:text-white text-sm focus:ring-primary focus:border-primary pl-10">
            </div>
            @error('password_confirmation') <p class="mt-1 text-xs text-danger">{{ $message }}</p> @enderror
        </div>

        <!-- Role -->
        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">I am a</label>
            <div class="grid grid-cols-2 gap-3">
                <label class="relative flex items-center gap-2 border border-gray-200 dark:border-white/10 rounded-lg p-3 cursor-pointer has-[:checked]:border-primary has-[:checked]:bg-primary/5">
                    <input type="radio" name="role" value="tenant" checked class="text-primary focus:ring-primary">
                    <span class="flex items-center gap-2 text-sm">
                        <i class="ri-user-search-line text-primary"></i> Tenant
                    </span>
                </label>
                <label class="relative flex items-center gap-2 border border-gray-200 dark:border-white/10 rounded-lg p-3 cursor-pointer has-[:checked]:border-primary has-[:checked]:bg-primary/5">
                    <input type="radio" name="role" value="owner" class="text-primary focus:ring-primary">
                    <span class="flex items-center gap-2 text-sm">
                        <i class="ri-building-4-line text-primary"></i> Property Owner
                    </span>
                </label>
            </div>
            @error('role') <p class="mt-1 text-xs text-danger">{{ $message }}</p> @enderror
        </div>

        <button type="submit"
                class="w-full py-2.5 bg-primary text-white rounded-lg text-sm font-medium hover:bg-primary-dark">
            Create Account
        </button>
    </form>

    <p class="mt-6 text-center text-sm text-gray-500 dark:text-gray-400">
        Already have an account?
        <a href="{{ route('login') }}" class="text-primary font-medium hover:underline">Log in</a>
    </p>
</x-guest-layout>