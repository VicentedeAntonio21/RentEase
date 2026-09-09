<form method="post" action="{{ route('password.update') }}" class="space-y-5">
    @csrf
    @method('put')

    <div>
        <label for="update_password_current_password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Current Password</label>
        <div class="relative">
            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"><i class="ri-lock-line"></i></span>
            <input type="password" id="update_password_current_password" name="current_password" autocomplete="current-password"
                   class="w-full rounded-lg border-gray-200 dark:border-white/10 dark:bg-[#1E2235] dark:text-white text-sm focus:ring-primary focus:border-primary pl-10">
        </div>
        @error('current_password', 'updatePassword') <p class="mt-1 text-xs text-danger">{{ $message }}</p> @enderror
    </div>

    <div>
        <label for="update_password_password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">New Password</label>
        <div class="relative">
            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"><i class="ri-lock-2-line"></i></span>
            <input type="password" id="update_password_password" name="password" autocomplete="new-password"
                   class="w-full rounded-lg border-gray-200 dark:border-white/10 dark:bg-[#1E2235] dark:text-white text-sm focus:ring-primary focus:border-primary pl-10">
        </div>
        @error('password', 'updatePassword') <p class="mt-1 text-xs text-danger">{{ $message }}</p> @enderror
    </div>

    <div>
        <label for="update_password_password_confirmation" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Confirm New Password</label>
        <div class="relative">
            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"><i class="ri-lock-2-line"></i></span>
            <input type="password" id="update_password_password_confirmation" name="password_confirmation" autocomplete="new-password"
                   class="w-full rounded-lg border-gray-200 dark:border-white/10 dark:bg-[#1E2235] dark:text-white text-sm focus:ring-primary focus:border-primary pl-10">
        </div>
        @error('password_confirmation', 'updatePassword') <p class="mt-1 text-xs text-danger">{{ $message }}</p> @enderror
    </div>

    <div class="flex items-center gap-4">
        <button type="submit" class="px-5 py-2 bg-primary text-white rounded-lg text-sm font-medium hover:bg-primary-dark">
            Update Password
        </button>

        @if (session('status') === 'password-updated')
            <p class="text-sm text-success flex items-center gap-1">
                <i class="ri-checkbox-circle-line"></i> Saved.
            </p>
        @endif
    </div>
</form>