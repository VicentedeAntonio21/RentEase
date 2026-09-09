<x-app-layout>
    @section('title', 'Profile Settings')

    <div class="max-w-2xl mx-auto space-y-6">

        <div class="flex items-center gap-4">
            <span class="w-16 h-16 rounded-full bg-primary/10 text-primary flex items-center justify-center font-heading font-bold text-2xl">
                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
            </span>
            <div>
                <h1 class="font-heading text-xl font-bold">{{ auth()->user()->name }}</h1>
                <p class="text-sm text-gray-500 dark:text-gray-400 capitalize">{{ auth()->user()->role }} account</p>
            </div>
        </div>

        <div class="bg-white dark:bg-[#252B3E] rounded-xl shadow-sm border border-gray-100 dark:border-white/5 p-6">
            <h2 class="font-heading font-semibold mb-1">Profile Information</h2>
            <p class="text-sm text-gray-500 dark:text-gray-400 mb-5">Update your name and email address.</p>
            @include('profile.partials.update-profile-information-form')
        </div>

        <div class="bg-white dark:bg-[#252B3E] rounded-xl shadow-sm border border-gray-100 dark:border-white/5 p-6">
            <h2 class="font-heading font-semibold mb-1">Update Password</h2>
            <p class="text-sm text-gray-500 dark:text-gray-400 mb-5">Use a long, random password to stay secure.</p>
            @include('profile.partials.update-password-form')
        </div>

        <div class="bg-white dark:bg-[#252B3E] rounded-xl shadow-sm border border-danger/20 p-6">
            <h2 class="font-heading font-semibold mb-1 text-danger">Delete Account</h2>
            <p class="text-sm text-gray-500 dark:text-gray-400 mb-5">
                Once deleted, all your data will be permanently removed. This cannot be undone.
            </p>
            @include('profile.partials.delete-user-form')
        </div>
    </div>
</x-app-layout>