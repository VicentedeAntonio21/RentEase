<x-app-layout>
    @section('title', 'Identity Verifications')

    <div class="space-y-6">

        @if (session('success'))
            <div class="flex items-center gap-2 p-4 bg-success/10 text-success rounded-lg text-sm">
                <i class="ri-checkbox-circle-line text-lg"></i> {{ session('success') }}
            </div>
        @endif

        @if ($pending->isEmpty())
            <div class="bg-white dark:bg-[#252B3E] rounded-xl shadow-sm border border-gray-100 dark:border-white/5 p-12 text-center">
                <i class="ri-shield-check-line text-5xl text-gray-300 dark:text-gray-600"></i>
                <p class="mt-3 text-gray-500 dark:text-gray-400">No pending verifications right now.</p>
            </div>
        @else
            <div class="space-y-4">
                @foreach ($pending as $user)
                    <div class="bg-white dark:bg-[#252B3E] rounded-xl shadow-sm border border-gray-100 dark:border-white/5 p-5">
                        <div class="flex items-start justify-between gap-4 mb-4">
                            <div class="flex items-center gap-3">
                                <span class="w-10 h-10 rounded-full bg-primary/10 text-primary flex items-center justify-center font-heading font-semibold">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </span>
                                <div>
                                    <p class="font-medium">{{ $user->name }}</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">
                                        {{ $user->email }} &middot; <span class="capitalize">{{ $user->role }}</span>
                                    </p>
                                </div>
                            </div>
                            <span class="px-2.5 py-1 rounded-full text-xs font-medium bg-warning/10 text-warning">Pending</span>
                        </div>

                        <div class="grid grid-cols-2 gap-3 mb-4">
                            <a href="{{ route('admin.verifications.document', [$user, 'id']) }}" target="_blank"
                               class="flex items-center gap-2 p-3 border border-gray-200 dark:border-white/10 rounded-lg hover:border-primary text-sm">
                                <i class="ri-id-card-line text-primary"></i> View Government ID
                            </a>
                            @if ($user->ownership_document_path)
                                <a href="{{ route('admin.verifications.document', [$user, 'ownership']) }}" target="_blank"
                                   class="flex items-center gap-2 p-3 border border-gray-200 dark:border-white/10 rounded-lg hover:border-primary text-sm">
                                    <i class="ri-file-shield-2-line text-primary"></i> View Ownership Document
                                </a>
                            @endif
                        </div>

                        <div class="flex items-center gap-2">
                            <form action="{{ route('admin.verifications.approve', $user) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button class="px-4 py-2 bg-success text-white rounded-lg text-sm font-medium hover:bg-green-600 flex items-center gap-1">
                                    <i class="ri-check-line"></i> Approve
                                </button>
                            </form>

                            <button type="button" x-data=""
                                    x-on:click="$dispatch('open-modal', 'reject-{{ $user->id }}')"
                                    class="px-4 py-2 border border-danger/30 text-danger rounded-lg text-sm font-medium hover:bg-danger/10">
                                Reject
                            </button>

                            <x-modal name="reject-{{ $user->id }}" focusable>
                                <form action="{{ route('admin.verifications.reject', $user) }}" method="POST" class="p-6">
                                    @csrf
                                    @method('PATCH')
                                    <h2 class="font-heading font-semibold text-lg mb-2">Reject verification</h2>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Reason (shown to the user)</label>
                                    <textarea name="notes" rows="3" required
                                              class="w-full rounded-lg border-gray-200 dark:border-white/10 dark:bg-[#1E2235] dark:text-white text-sm focus:ring-danger focus:border-danger"
                                              placeholder="e.g. ID photo is blurry, please re-upload a clearer copy."></textarea>
                                    <div class="mt-4 flex justify-end gap-2">
                                        <button type="button" x-on:click="$dispatch('close')"
                                                class="px-4 py-2 border border-gray-200 dark:border-white/10 rounded-lg text-sm font-medium text-gray-600 dark:text-gray-300">
                                            Cancel
                                        </button>
                                        <button type="submit" class="px-4 py-2 bg-danger text-white rounded-lg text-sm font-medium hover:bg-red-600">
                                            Reject
                                        </button>
                                    </div>
                                </form>
                            </x-modal>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</x-app-layout>