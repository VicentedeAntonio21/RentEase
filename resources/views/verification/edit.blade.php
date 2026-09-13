<x-app-layout>
    @section('title', 'Identity Verification')

    <div class="max-w-2xl mx-auto space-y-6">

        @if (session('success'))
            <div class="flex items-center gap-2 p-4 bg-success/10 text-success rounded-lg text-sm">
                <i class="ri-checkbox-circle-line text-lg"></i> {{ session('success') }}
            </div>
        @endif

        @if (auth()->user()->verification_status === 'rejected')
            <div class="flex items-start gap-3 p-4 bg-danger/10 text-danger rounded-lg text-sm">
                <i class="ri-error-warning-line text-lg mt-0.5"></i>
                <div>
                    <p class="font-medium">Your previous submission was rejected</p>
                    <p class="mt-1">{{ auth()->user()->verification_notes }}</p>
                </div>
            </div>
        @endif

        @if (auth()->user()->verification_status === 'pending')
            <div class="flex items-center gap-3 p-4 bg-warning/10 text-warning rounded-lg text-sm">
                <i class="ri-time-line text-lg"></i>
                Your documents are under review. This usually takes up to 24 hours.
            </div>
        @else
            <div class="bg-white dark:bg-[#252B3E] rounded-xl shadow-sm border border-gray-100 dark:border-white/5 p-6">
                <h2 class="font-heading font-semibold text-lg mb-1">Identity Verification</h2>
                <p class="text-sm text-gray-500 dark:text-gray-400 mb-5">
                    @if (auth()->user()->isOwner())
                        To list properties, please upload a valid government ID and proof of property ownership (Transfer/Original Certificate of Title, or Condominium Certificate of Title).
                    @else
                        To apply for rentals, please upload a valid government ID.
                    @endif
                </p>

                <form action="{{ route('verification.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
                    @csrf

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Government ID <span class="text-danger">*</span>
                        </label>
                        <label for="id_document" class="flex flex-col items-center justify-center gap-2 border-2 border-dashed border-gray-200 dark:border-white/10 rounded-lg p-6 cursor-pointer hover:border-primary transition-colors">
                            <i class="ri-id-card-line text-3xl text-gray-400"></i>
                            <span class="text-sm text-gray-500 dark:text-gray-400">Click to upload (JPG, PNG, or PDF, max 4MB)</span>
                            <input type="file" id="id_document" name="id_document" accept=".jpg,.jpeg,.png,.pdf" class="hidden" required>
                        </label>
                        @error('id_document') <p class="mt-1 text-xs text-danger">{{ $message }}</p> @enderror
                    </div>

                    @if (auth()->user()->isOwner())
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Proof of Property Ownership <span class="text-danger">*</span>
                            </label>
                            <p class="text-xs text-gray-400 mb-2">Transfer Certificate of Title (TCT), Original Certificate of Title (OCT), or Condominium Certificate of Title (CCT)</p>
                            <label for="ownership_document" class="flex flex-col items-center justify-center gap-2 border-2 border-dashed border-gray-200 dark:border-white/10 rounded-lg p-6 cursor-pointer hover:border-primary transition-colors">
                                <i class="ri-file-shield-2-line text-3xl text-gray-400"></i>
                                <span class="text-sm text-gray-500 dark:text-gray-400">Click to upload (JPG, PNG, or PDF, max 4MB)</span>
                                <input type="file" id="ownership_document" name="ownership_document" accept=".jpg,.jpeg,.png,.pdf" class="hidden" required>
                            </label>
                            @error('ownership_document') <p class="mt-1 text-xs text-danger">{{ $message }}</p> @enderror
                        </div>
                    @endif

                    <div class="flex justify-end pt-2 border-t border-gray-100 dark:border-white/5">
                        <button type="submit" class="px-5 py-2 bg-primary text-white rounded-lg text-sm font-medium hover:bg-primary-dark flex items-center gap-2">
                            <i class="ri-upload-2-line"></i> Submit for Review
                        </button>
                    </div>
                </form>
            </div>
        @endif
    </div>
</x-app-layout>