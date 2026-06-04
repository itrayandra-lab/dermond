@extends('admin.layouts.app')

@section('title', isset($bundle) ? 'Edit Bundle' : 'Add Bundle')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="mb-8 flex flex-col md:flex-row justify-between items-end gap-4">
        <div>
            <h1 class="text-4xl md:text-5xl font-bold uppercase text-white mb-2">
                {{ isset($bundle) ? 'Edit Bundle' : 'New Bundle' }}
            </h1>
            <p class="text-gray-400">{{ isset($bundle) ? 'Update bundle details and images.' : 'Create a new exclusive bundle.' }}</p>
        </div>
        <a href="{{ route('admin.bundles.index') }}" class="group flex items-center gap-2 text-gray-400 hover:text-blue-400 transition-colors">
            <div class="w-8 h-8 rounded-full border border-white/10 flex items-center justify-center group-hover:border-blue-500/30 group-hover:bg-blue-500/10 transition-all">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
            </div>
            <span class="text-xs font-bold uppercase tracking-widest">Back to Bundles</span>
        </a>
    </div>

    @if($errors->any())
        <div class="bg-red-900/30 border border-red-500/30 text-red-400 px-6 py-4 rounded-2xl mb-8">
            <div class="flex items-center gap-3 mb-2">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
                <h3 class="font-bold uppercase tracking-wider text-sm">Please check the form</h3>
            </div>
            <ul class="list-disc list-inside text-sm opacity-80 pl-8">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ isset($bundle) ? route('admin.bundles.update', $bundle) : route('admin.bundles.store') }}"
          method="POST"
          enctype="multipart/form-data"
          class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
        @csrf
        @if(isset($bundle))
            @method('PUT')
        @endif

        {{-- Main Content --}}
        <div class="lg:col-span-2 space-y-6">

            {{-- General Info --}}
            <div class="bg-dermond-card border border-white/10 rounded-2xl p-6 md:p-8 space-y-6">
                <h3 class="text-lg font-bold text-white flex items-center gap-2">
                    <svg class="w-5 h-5 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    Bundle Information
                </h3>

                <div>
                    <label for="name" class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-3">Bundle Name *</label>
                    <input type="text" name="name" id="name"
                           value="{{ old('name', $bundle->name ?? '') }}"
                           class="w-full px-0 py-2 text-2xl md:text-3xl font-bold text-white bg-transparent border-0 border-b-2 border-white/10 focus:border-blue-500 focus:ring-0 placeholder-gray-600 transition-colors"
                           placeholder="e.g. Complete Care Bundle"
                           required>
                </div>

                <div>
                    <label for="subtitle" class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">Subtitle</label>
                    <input type="text" name="subtitle" id="subtitle"
                           value="{{ old('subtitle', $bundle->subtitle ?? '') }}"
                           class="w-full px-4 py-3 rounded-xl bg-dermond-dark border border-white/10 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all text-sm text-white placeholder-gray-600"
                           placeholder="e.g. 5 produk perawatan pria lengkap">
                </div>

                <div>
                    <label for="description" class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">Description</label>
                    <textarea name="description" id="description" rows="4"
                              class="w-full px-4 py-3 rounded-xl bg-dermond-dark border border-white/10 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all text-sm text-gray-300 placeholder-gray-600"
                              placeholder="Describe the bundle...">{{ old('description', $bundle->description ?? '') }}</textarea>
                </div>
            </div>

            {{-- Pricing --}}
            <div class="bg-dermond-card border border-white/10 rounded-2xl p-6 md:p-8">
                <h3 class="text-lg font-bold text-white mb-6 flex items-center gap-2">
                    <svg class="w-5 h-5 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    Pricing
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="price" class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">Bundle Price (IDR) *</label>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-500 font-medium">Rp</span>
                            <input type="number" name="price" id="price"
                                   value="{{ old('price', $bundle->price ?? '') }}"
                                   class="w-full pl-10 pr-4 py-3 rounded-xl bg-dermond-dark border border-white/10 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all font-mono font-medium text-white"
                                   required>
                        </div>
                    </div>
                    <div>
                        <label for="original_price" class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">Original Price (untuk hemat)</label>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-500 font-medium">Rp</span>
                            <input type="number" name="original_price" id="original_price"
                                   value="{{ old('original_price', $bundle->original_price ?? '') }}"
                                   class="w-full pl-10 pr-4 py-3 rounded-xl bg-dermond-dark border border-white/10 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all font-mono font-medium text-white"
                                   placeholder="0">
                        </div>
                        <p class="text-xs text-gray-500 mt-1">Isi jika ingin tampilkan "Hemat Rp..."</p>
                    </div>
                </div>
            </div>

            {{-- Included Products --}}
            <div class="bg-dermond-card border border-white/10 rounded-2xl p-6 md:p-8"
                 x-data="{
                    products: {{ json_encode(old('included_products', $bundle->included_products ?? [])) ?: '[]' }},
                    addProduct() { this.products.push(''); },
                    removeProduct(index) { this.products.splice(index, 1); }
                 }">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-bold text-white flex items-center gap-2">
                        <svg class="w-5 h-5 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                        Produk dalam Bundle
                    </h3>
                    <button type="button" @click="addProduct()"
                            class="text-xs font-bold uppercase tracking-widest text-blue-400 hover:text-blue-300 flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        Tambah Produk
                    </button>
                </div>
                <p class="text-sm text-gray-500 mb-4">Daftar nama produk yang termasuk dalam bundle ini.</p>
                <div class="space-y-3">
                    <template x-for="(product, index) in products" :key="index">
                        <div class="flex items-center gap-3">
                            <input type="text" x-model="products[index]" :name="'included_products[' + index + ']'"
                                   class="flex-1 px-3 py-2 rounded-lg bg-dermond-dark border border-white/10 text-sm text-white placeholder-gray-600 focus:border-blue-500 focus:ring-1 focus:ring-blue-500/20"
                                   placeholder="e.g. Reboot Cream">
                            <button type="button" @click="removeProduct(index)" class="text-red-400 hover:text-red-300">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                            </button>
                        </div>
                    </template>
                </div>
                <div x-show="products.length === 0" class="text-center py-6 text-gray-500 text-sm">
                    Belum ada produk ditambahkan
                </div>
            </div>

            {{-- Benefits --}}
            <div class="bg-dermond-card border border-white/10 rounded-2xl p-6 md:p-8"
                 x-data="{
                    benefits: {{ json_encode(old('benefits', $bundle->benefits ?? [])) ?: '[]' }},
                    addBenefit() { this.benefits.push({ icon: 'shield', text: '' }); },
                    removeBenefit(index) { this.benefits.splice(index, 1); }
                 }">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-bold text-white flex items-center gap-2">
                        <svg class="w-5 h-5 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                        Keunggulan Bundle
                    </h3>
                    <button type="button" @click="addBenefit()"
                            class="text-xs font-bold uppercase tracking-widest text-blue-400 hover:text-blue-300 flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        Tambah
                    </button>
                </div>
                <p class="text-sm text-gray-500 mb-4">Tampil sebagai poin-poin keunggulan di halaman bundle.</p>
                <div class="space-y-3">
                    <template x-for="(benefit, index) in benefits" :key="index">
                        <div class="flex items-center gap-3">
                            <select x-model="benefit.icon" :name="'benefits[' + index + '][icon]'"
                                    class="px-3 py-2 rounded-lg bg-dermond-dark border border-white/10 text-sm text-gray-300 focus:border-blue-500">
                                <option value="shield">🛡️ Shield</option>
                                <option value="droplet">💧 Droplet</option>
                                <option value="sparkles">✨ Sparkles</option>
                                <option value="check">✓ Check</option>
                                <option value="star">⭐ Star</option>
                            </select>
                            <input type="text" x-model="benefit.text" :name="'benefits[' + index + '][text]'"
                                   class="flex-1 px-3 py-2 rounded-lg bg-dermond-dark border border-white/10 text-sm text-white placeholder-gray-600 focus:border-blue-500 focus:ring-1 focus:ring-blue-500/20"
                                   placeholder="e.g. Jaga kebersihan sepanjang hari">
                            <button type="button" @click="removeBenefit(index)" class="text-red-400 hover:text-red-300">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                            </button>
                        </div>
                    </template>
                </div>
                <div x-show="benefits.length === 0" class="text-center py-6 text-gray-500 text-sm">
                    Belum ada keunggulan ditambahkan
                </div>
            </div>

        </div>

        {{-- Sidebar --}}
        <div class="space-y-6 lg:sticky lg:top-8">

            {{-- Publishing --}}
            <div class="bg-dermond-card border border-white/10 rounded-2xl p-6 border-t-4 border-t-blue-500">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-lg font-bold text-white">Publishing</h3>
                    @php $status = old('status', $bundle->status ?? 'published'); @endphp
                    <div class="w-2 h-2 rounded-full {{ $status === 'published' ? 'bg-emerald-400 animate-pulse' : 'bg-gray-500' }}"></div>
                </div>
                <div class="space-y-3 mb-6">
                    @foreach(['published' => 'Published', 'draft' => 'Draft', 'archived' => 'Archived'] as $val => $label)
                    <label class="flex items-center p-3 rounded-xl border border-white/10 cursor-pointer hover:bg-white/5 transition-colors {{ $status === $val ? 'bg-blue-500/10 border-blue-500/30' : '' }}">
                        <input type="radio" name="status" value="{{ $val }}" {{ $status === $val ? 'checked' : '' }} class="text-blue-500 focus:ring-blue-500 border-white/20 bg-dermond-dark">
                        <span class="ml-3 text-sm font-medium text-gray-300">{{ $label }}</span>
                    </label>
                    @endforeach
                </div>
                <button type="submit" class="w-full px-6 py-3 bg-blue-600 hover:bg-blue-500 text-white rounded-xl font-bold uppercase tracking-wider text-xs transition-all shadow-lg shadow-blue-900/30 flex items-center justify-center gap-2">
                    <span>{{ isset($bundle) ? 'Save Changes' : 'Create Bundle' }}</span>
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                </button>
            </div>

            {{-- Images --}}
            <div class="bg-dermond-card border border-white/10 rounded-2xl p-6">
                <h3 class="text-lg font-bold text-white mb-2">Bundle Images</h3>
                <p class="text-xs text-gray-500 mb-4">Upload multiple images. Shown as gallery on bundle page.</p>

                {{-- Existing images --}}
                @if(isset($bundle) && $bundle->hasImages())
                    <div class="grid grid-cols-2 gap-2 mb-4">
                        @foreach($bundle->getMedia('bundle_images') as $media)
                        <div class="relative group">
                            <img src="{{ $media->getUrl() }}" class="w-full aspect-square object-cover rounded-xl" alt="Bundle image">
                            <label class="absolute top-1 right-1 cursor-pointer">
                                <input type="checkbox" name="images_delete[]" value="{{ $media->id }}" class="sr-only peer">
                                <div class="w-6 h-6 rounded-full bg-black/60 flex items-center justify-center text-gray-400 peer-checked:bg-red-500 peer-checked:text-white transition-all">
                                    <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"/></svg>
                                </div>
                            </label>
                        </div>
                        @endforeach
                    </div>
                    <p class="text-xs text-gray-500 mb-3">Centang ✕ untuk hapus foto.</p>
                @endif

                {{-- Upload new --}}
                <div class="w-full border-2 border-dashed border-white/20 rounded-xl p-6 flex flex-col items-center justify-center text-center hover:border-blue-500/50 transition-colors cursor-pointer relative">
                    <svg class="w-8 h-8 text-gray-600 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    <p class="text-xs text-gray-500">Klik untuk upload foto</p>
                    <p class="text-xs text-gray-600 mt-1">Multiple files, max 10MB each</p>
                    <input type="file" name="images[]" accept="image/*" multiple
                           class="absolute inset-0 w-full h-full opacity-0 cursor-pointer"
                           onchange="previewNewImages(event)">
                </div>
                <div id="new-image-previews" class="grid grid-cols-2 gap-2 mt-3"></div>
            </div>

        </div>
    </form>
</div>

<script>
function previewNewImages(event) {
    const container = document.getElementById('new-image-previews');
    container.innerHTML = '';
    Array.from(event.target.files).forEach(file => {
        const reader = new FileReader();
        reader.onload = function(e) {
            const img = document.createElement('img');
            img.src = e.target.result;
            img.className = 'w-full aspect-square object-cover rounded-xl opacity-80';
            container.appendChild(img);
        };
        reader.readAsDataURL(file);
    });
}
</script>
@endsection
