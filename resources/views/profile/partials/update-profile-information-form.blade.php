<form method="post" action="{{ route('profile.update') }}" class="space-y-5">
    @csrf
    @method('patch')

    <x-form-input name="name" label="Name" icon="ri-user-line" :value="old('name', $user->name)" required autofocus />
    <x-form-input name="email" label="Email" type="email" icon="ri-mail-line" :value="old('email', $user->email)" required />

    @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
        <div class="flex items-start gap-2 p-3 bg-warning/10 rounded-lg text-sm text-warning">
            <i class="ri-error-warning-line mt-0.5"></i>
            <div>
                <p>Your email address is unverified.</p>
                <button form="send-verification" class="underline font-medium">
                    Click here to re-send the verification email.
                </button>

                @if (session('status') === 'verification-link-sent')
                    <p class="mt-2 font-medium text-success">
                        A new verification link has been sent to your email address.
                    </p>
                @endif
            </div>
        </div>
    @endif

    <div class="flex items-center gap-4">
        <button type="submit" class="px-5 py-2 bg-primary text-white rounded-lg text-sm font-medium hover:bg-primary-dark">
            Save Changes
        </button>

        @if (session('status') === 'profile-updated')
            <p class="text-sm text-success flex items-center gap-1">
                <i class="ri-checkbox-circle-line"></i> Saved.
            </p>
        @endif
    </div>
</form>

@if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>
@endif