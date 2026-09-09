<button
    x-data=""
    x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
    class="px-5 py-2 border border-danger/30 text-danger rounded-lg text-sm font-medium hover:bg-danger/10"
>
    Delete Account
</button>

<x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
    <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
        @csrf
        @method('delete')

        <div class="flex items-center gap-2 text-danger">
            <i class="ri-error-warning-line text-xl"></i>
            <h2 class="font-heading font-semibold text-lg">Delete your account?</h2>
        </div>

        <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
            This is permanent — all your properties, applications, and data will be removed. Enter your password to confirm.
        </p>

        <div class="mt-4">
            <label for="password" class="sr-only">Password</label>
            <div class="relative">
                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"><i class="ri-lock-line"></i></span>
                <input
                    type="password"
                    id="password"
                    name="password"
                    placeholder="Enter your password"
                    class="w-full rounded-lg border-gray-200 dark:border-white/10 dark:bg-[#1E2235] dark:text-white text-sm focus:ring-danger focus:border-danger pl-10"
                />
            </div>
            @error('password', 'userDeletion') <p class="mt-1 text-xs text-danger">{{ $message }}</p> @enderror
        </div>

        <div class="mt-6 flex justify-end gap-2">
            <button type="button" x-on:click="$dispatch('close')"
                    class="px-4 py-2 border border-gray-200 dark:border-white/10 rounded-lg text-sm font-medium text-gray-600 dark:text-gray-300">
                Cancel
            </button>
            <button type="submit" class="px-4 py-2 bg-danger text-white rounded-lg text-sm font-medium hover:bg-red-600">
                Delete Account
            </button>
        </div>
    </form>
</x-modal>