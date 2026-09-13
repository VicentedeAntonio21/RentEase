<x-app-layout>
    @section('title', 'Edit Property')

    <div class="max-w-2xl mx-auto space-y-6">

        <a href="{{ route('owner.properties.index') }}"
            class="inline-flex items-center gap-1 text-sm text-gray-500 dark:text-gray-400 hover:text-primary">
            <i class="ri-arrow-left-line"></i> Back to properties
        </a>

        <div class="bg-white dark:bg-[#252B3E] rounded-xl shadow-sm border border-gray-100 dark:border-white/5 p-6">
            <h2 class="font-heading font-semibold text-lg mb-5">Edit Property</h2>

            <form action="{{ route('owner.properties.update', $property) }}" method="POST" enctype="multipart/form-data"
                class="space-y-5">
                @csrf
                @method('PUT')

                <x-form-input name="title" label="Title" icon="ri-home-4-line" :value="$property->title" required />

                <div>
                    <label for="description"
                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Description</label>
                    <textarea id="description" name="description" rows="3"
                        class="w-full rounded-lg border-gray-200 dark:border-white/10 dark:bg-[#1E2235] dark:text-white text-sm focus:ring-primary focus:border-primary">{{ old('description', $property->description) }}</textarea>
                </div>

                <div x-data='{
                    provinces: [],
                    cities: [],
                    barangays: [],
                    provinceId: "",
                    cityId: "",
                    provinceName: "",
                    cityName: "",
                    barangayName: "",
                    apiBase: @json(url('/api/address')),
                    loadingCities: false,
                    loadingBarangays: false,
                    openDropdown: null,

                    async init() {
                        const res = await fetch(`${this.apiBase}/provinces`);
                        this.provinces = await res.json();

                        @if ($property->province)
                            const matchedProvince = this.provinces.find(p => p.name === @json($property->province));
                            if (matchedProvince) {
                                this.provinceId = matchedProvince.psgc_id;
                                this.provinceName = matchedProvince.name;
                                const citiesRes = await fetch(`${this.apiBase}/cities/${this.provinceId}`);
                                this.cities = await citiesRes.json();

                                const matchedCity = this.cities.find(c => c.name === @json($property->city));
                                if (matchedCity) {
                                    this.cityId = matchedCity.psgc_id;
                                    this.cityName = matchedCity.name;
                                    const brgyRes = await fetch(`${this.apiBase}/barangays/${this.cityId}`);
                                    this.barangays = await brgyRes.json();
                                    this.barangayName = @json($property->barangay ?? '');
                                }
                            }
                        @endif
                    },
                    async onProvinceChange() {
                        this.cities = [];
                        this.barangays = [];
                        this.cityId = "";
                        this.cityName = "";
                        this.barangayName = "";
                        const selected = this.provinces.find(p => p.psgc_id === this.provinceId);
                        this.provinceName = selected ? selected.name : "";
                        if (!this.provinceId) return;

                        this.loadingCities = true;
                        const res = await fetch(`${this.apiBase}/cities/${this.provinceId}`);
                        this.cities = await res.json();
                        this.loadingCities = false;
                    },
                    async onCityChange() {
                        this.barangays = [];
                        this.barangayName = "";
                        const selected = this.cities.find(c => c.psgc_id === this.cityId);
                        this.cityName = selected ? selected.name : "";
                        if (!this.cityId) return;

                        this.loadingBarangays = true;
                        const res = await fetch(`${this.apiBase}/barangays/${this.cityId}`);
                        this.barangays = await res.json();
                        this.loadingBarangays = false;
                    }
                }' class="space-y-4">
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <div>
                            <label
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Province</label>
                            <div class="relative" @click.outside="openDropdown = null">
                                <button type="button" @click.stop="openDropdown = openDropdown === 'province' ? null : 'province'"
                                    class="flex w-full items-center justify-between gap-3 rounded-lg border border-gray-200 bg-white px-3 py-2.5 text-left text-sm shadow-sm transition hover:border-primary focus:outline-none focus:ring-2 focus:ring-primary/20 dark:border-white/10 dark:bg-[#1E2235] dark:text-white">
                                    <span class="flex min-w-0 items-center gap-2">
                                        <i class="ri-map-pin-2-line text-primary"></i>
                                        <span class="truncate" x-text="provinceName || 'Select province'"></span>
                                    </span>
                                    <i class="ri-arrow-down-s-line shrink-0 text-gray-400 transition-transform" :class="openDropdown === 'province' && 'rotate-180'"></i>
                                </button>
                                <div x-show="openDropdown === 'province'" x-cloak x-transition.origin.top
                                    class="absolute left-0 top-full z-50 mt-2 max-h-60 w-full overflow-y-auto rounded-lg border border-gray-200 bg-white p-1.5 shadow-xl shadow-gray-200/60 dark:border-white/10 dark:bg-[#252B3E] dark:shadow-black/30">
                                    <button type="button" @click.stop="provinceId = ''; provinceName = ''; openDropdown = null; onProvinceChange()"
                                        class="w-full rounded-md px-3 py-2 text-left text-sm text-gray-500 hover:bg-primary/10 hover:text-primary dark:text-gray-400">Select province</button>
                                    <template x-for="p in provinces" :key="p.psgc_id">
                                        <button type="button" @click.stop="provinceId = p.psgc_id; provinceName = p.name; openDropdown = null; onProvinceChange()"
                                            class="flex w-full items-center justify-between rounded-md px-3 py-2 text-left text-sm text-gray-700 hover:bg-primary/10 hover:text-primary dark:text-gray-200"
                                            :class="provinceId === p.psgc_id && 'bg-primary/10 font-medium text-primary'">
                                            <span x-text="p.name"></span>
                                            <i x-show="provinceId === p.psgc_id" class="ri-check-line"></i>
                                        </button>
                                    </template>
                                </div>
                            </div>
                            <input type="hidden" name="province" :value="provinceName">
                            @error('province')
                            <p class="mt-1 text-xs text-danger">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">City /
                                Municipality</label>
                            <div class="relative" @click.outside="openDropdown = null">
                                <button type="button" :disabled="!provinceId || loadingCities" @click.stop="openDropdown = openDropdown === 'city' ? null : 'city'"
                                    class="flex w-full items-center justify-between gap-3 rounded-lg border border-gray-200 bg-white px-3 py-2.5 text-left text-sm shadow-sm transition hover:border-primary focus:outline-none focus:ring-2 focus:ring-primary/20 disabled:cursor-not-allowed disabled:opacity-50 dark:border-white/10 dark:bg-[#1E2235] dark:text-white">
                                    <span class="flex min-w-0 items-center gap-2">
                                        <i class="ri-building-2-line text-primary"></i>
                                        <span class="truncate" x-text="loadingCities ? 'Loading...' : (cityName || 'Select city/municipality')"></span>
                                    </span>
                                    <i class="ri-arrow-down-s-line shrink-0 text-gray-400 transition-transform" :class="openDropdown === 'city' && 'rotate-180'"></i>
                                </button>
                                <div x-show="openDropdown === 'city'" x-cloak x-transition.origin.top
                                    class="absolute left-0 top-full z-50 mt-2 max-h-60 w-full overflow-y-auto rounded-lg border border-gray-200 bg-white p-1.5 shadow-xl shadow-gray-200/60 dark:border-white/10 dark:bg-[#252B3E] dark:shadow-black/30">
                                    <button type="button" @click.stop="cityId = ''; cityName = ''; openDropdown = null; onCityChange()"
                                        class="w-full rounded-md px-3 py-2 text-left text-sm text-gray-500 hover:bg-primary/10 hover:text-primary dark:text-gray-400">Select city/municipality</button>
                                    <template x-for="c in cities" :key="c.psgc_id">
                                        <button type="button" @click.stop="cityId = c.psgc_id; cityName = c.name; openDropdown = null; onCityChange()"
                                            class="flex w-full items-center justify-between rounded-md px-3 py-2 text-left text-sm text-gray-700 hover:bg-primary/10 hover:text-primary dark:text-gray-200"
                                            :class="cityId === c.psgc_id && 'bg-primary/10 font-medium text-primary'">
                                            <span x-text="c.name"></span>
                                            <i x-show="cityId === c.psgc_id" class="ri-check-line"></i>
                                        </button>
                                    </template>
                                </div>
                            </div>
                            <input type="hidden" name="city" :value="cityName">
                            @error('city')
                            <p class="mt-1 text-xs text-danger">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Barangay</label>
                            <div class="relative" @click.outside="openDropdown = null">
                                <button type="button" :disabled="!cityId || loadingBarangays" @click.stop="openDropdown = openDropdown === 'barangay' ? null : 'barangay'"
                                    class="flex w-full items-center justify-between gap-3 rounded-lg border border-gray-200 bg-white px-3 py-2.5 text-left text-sm shadow-sm transition hover:border-primary focus:outline-none focus:ring-2 focus:ring-primary/20 disabled:cursor-not-allowed disabled:opacity-50 dark:border-white/10 dark:bg-[#1E2235] dark:text-white">
                                    <span class="flex min-w-0 items-center gap-2">
                                        <i class="ri-community-line text-primary"></i>
                                        <span class="truncate" x-text="loadingBarangays ? 'Loading...' : (barangayName || 'Select barangay')"></span>
                                    </span>
                                    <i class="ri-arrow-down-s-line shrink-0 text-gray-400 transition-transform" :class="openDropdown === 'barangay' && 'rotate-180'"></i>
                                </button>
                                <div x-show="openDropdown === 'barangay'" x-cloak x-transition.origin.top
                                    class="absolute left-0 top-full z-50 mt-2 max-h-60 w-full overflow-y-auto rounded-lg border border-gray-200 bg-white p-1.5 shadow-xl shadow-gray-200/60 dark:border-white/10 dark:bg-[#252B3E] dark:shadow-black/30">
                                    <button type="button" @click.stop="barangayName = ''; openDropdown = null"
                                        class="w-full rounded-md px-3 py-2 text-left text-sm text-gray-500 hover:bg-primary/10 hover:text-primary dark:text-gray-400">Select barangay</button>
                                    <template x-for="b in barangays" :key="b.psgc_id">
                                        <button type="button" @click.stop="barangayName = b.name; openDropdown = null"
                                            class="flex w-full items-center justify-between rounded-md px-3 py-2 text-left text-sm text-gray-700 hover:bg-primary/10 hover:text-primary dark:text-gray-200"
                                            :class="barangayName === b.name && 'bg-primary/10 font-medium text-primary'">
                                            <span x-text="b.name"></span>
                                            <i x-show="barangayName === b.name" class="ri-check-line"></i>
                                        </button>
                                    </template>
                                </div>
                            </div>
                            <input type="hidden" name="barangay" :value="barangayName">
                            @error('barangay')
                            <p class="mt-1 text-xs text-danger">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Specific Location <span class="text-gray-400 font-normal">(Lot/Block, Street,
                                Village)</span>
                        </label>
                        <input type="text" name="address" value="{{ old('address', $property->address) }}"
                            placeholder="e.g. Blk 5 Lot 12, Rose St., Sunville Village"
                            class="w-full rounded-lg border-gray-200 dark:border-white/10 dark:bg-[#1E2235] dark:text-white text-sm focus:ring-primary focus:border-primary">
                        @error('address')
                        <p class="mt-1 text-xs text-danger">{{ $message }}</p> @enderror
                    </div>

                    <x-form-input name="zip_code" label="Zip Code" :value="$property->zip_code" />
                </div>


                <div>
                    <label for="property_type"
                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Property Type</label>
                    <select id="property_type" name="property_type"
                        class="w-full rounded-lg border-gray-200 dark:border-white/10 dark:bg-[#1E2235] dark:text-white text-sm focus:ring-primary focus:border-primary">
                        @foreach (['apartment', 'house', 'condo', 'room', 'other'] as $type)
                            <option value="{{ $type }}" @selected(old('property_type', $property->property_type) === $type)>
                                {{ ucfirst($type) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                @if ($property->images->count())
                    @php
                        $imageUrls = $property->images->map(fn($img) => Storage::url($img->image_path));
                    @endphp
                    <div class="grid grid-cols-4 gap-2 px-6 pb-6">
                        @foreach ($property->images as $index => $image)
                            <div class="relative group cursor-pointer"
                                @click="$store.lightbox.show(@js($imageUrls), {{ $index }})">
                                <img src="{{ Storage::url($image->image_path) }}" class="rounded-lg h-24 w-full object-cover">
                                <div
                                    class="absolute inset-0 rounded-lg bg-black/0 group-hover:bg-black/20 transition-colors flex items-center justify-center">
                                    <i
                                        class="ri-zoom-in-line text-white opacity-0 group-hover:opacity-100 transition-opacity"></i>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif

                <div x-data="{
    files: [],
    error: '',
    maxSizeMB: 2,
    maxFiles: 6,

    addFiles(newFileList) {
        this.error = '';

        if (this.files.length >= this.maxFiles) {
            this.error = `You can only upload up to ${this.maxFiles} photos.`;
            this.syncInput();
            return;
        }

        for (const file of newFileList) {
            if (this.files.length >= this.maxFiles) {
                this.error = `Only the first ${this.maxFiles} photos were kept — max is ${this.maxFiles}.`;
                break;
            }
            if (!file.type.startsWith('image/')) {
                this.error = `${file.name} is not an image file.`;
                continue;
            }
            if (file.size > this.maxSizeMB * 1024 * 1024) {
                this.error = `${file.name} is ${(file.size / 1024 / 1024).toFixed(1)}MB — max is ${this.maxSizeMB}MB.`;
                continue;
            }
            this.files.push({ file, name: file.name, url: URL.createObjectURL(file) });
        }

        this.syncInput();
    },

    removeFile(index) {
        URL.revokeObjectURL(this.files[index].url);
        this.files.splice(index, 1);
        this.syncInput();
    },

    syncInput() {
        const dt = new DataTransfer();
        this.files.forEach(f => dt.items.add(f.file));
        this.$refs.imageInput.files = dt.files;
    }
}">
                    <label for="images"
                        class="flex flex-col items-center justify-center gap-2 border-2 border-dashed border-gray-200 dark:border-white/10 rounded-lg p-6 cursor-pointer hover:border-primary transition-colors">
                        <i class="ri-image-add-line text-3xl text-gray-400"></i>
                        <span class="text-sm text-gray-500 dark:text-gray-400">
                            Click to upload photos <span x-show="files.length > 0"
                                x-text="`(${files.length}/${maxFiles} added)`"></span>
                        </span>
                        <input type="file" id="images" name="images[]" multiple accept="image/*" class="hidden"
                            x-ref="imageInput" @change="addFiles($event.target.files)">
                    </label>

                    <p x-show="error" x-cloak x-text="error" class="mt-1 text-xs text-danger"></p>
                    @error('images.*')
                    <p class="mt-1 text-xs text-danger">{{ $message }}</p> @enderror

                    <div x-show="files.length > 0" x-cloak class="grid grid-cols-4 gap-2 mt-3">
                        <template x-for="(f, index) in files" :key="f.name + index">
                            <div class="relative group">
                                <img :src="f.url" class="h-20 w-full object-cover rounded-lg">
                                <button type="button" @click="removeFile(index)"
                                    class="absolute -top-1.5 -right-1.5 w-5 h-5 rounded-full bg-danger text-white flex items-center justify-center text-xs opacity-0 group-hover:opacity-100 transition-opacity">
                                    <i class="ri-close-line"></i>
                                </button>
                            </div>
                        </template>

                        <label x-show="files.length < maxFiles" for="images"
                            class="flex items-center justify-center h-20 border-2 border-dashed border-gray-200 dark:border-white/10 rounded-lg cursor-pointer hover:border-primary text-gray-400 hover:text-primary transition-colors">
                            <i class="ri-add-line text-xl"></i>
                        </label>
                    </div>
                </div>

                <div class="flex justify-end gap-2 pt-2 border-t border-gray-100 dark:border-white/5">
                    <a href="{{ route('owner.properties.index') }}"
                        class="px-4 py-2 border border-gray-200 dark:border-white/10 rounded-lg text-sm font-medium text-gray-600 dark:text-gray-300">
                        Cancel
                    </a>
                    <button type="submit"
                        class="px-5 py-2 bg-primary text-white rounded-lg text-sm font-medium hover:bg-primary-dark flex items-center gap-2">
                        <i class="ri-save-line"></i> Update Property
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>