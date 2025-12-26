@extends('admin.layouts.app')

@section('title', isset($slider) ? 'Edit Slider' : 'Add New Slider')

@section('content')
<div class="section-container section-padding max-w-3xl mx-auto">

    <div class="mb-8 flex flex-col md:flex-row justify-between items-end gap-4">
        <div>
            <h1 class="text-4xl md:text-5xl font-display font-medium uppercase text-white mb-2">
                {{ isset($slider) ? 'Edit Slider' : 'New Slider' }}
            </h1>
            <p class="text-gray-400 font-light">
                {{ isset($slider) ? 'Update hero slide.' : 'Add a new hero slide for your homepage.' }}
            </p>
        </div>

        <a href="{{ route('admin.slider.index') }}" class="group flex items-center gap-2 text-gray-400 hover:text-blue-400 transition-colors">
            <div class="w-8 h-8 rounded-full border border-white/10 flex items-center justify-center group-hover:border-blue-500/30 group-hover:bg-blue-500/10 transition-all">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
            </div>
            <span class="text-xs font-bold uppercase tracking-widest">Back</span>
        </a>
    </div>

    @if ($errors->any())
        <div class="bg-red-900/30 border border-red-500/30 text-red-400 px-6 py-4 rounded-2xl mb-8">
            <ul class="list-disc list-inside text-sm">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ isset($slider) ? route('admin.slider.update', $slider->id) : route('admin.slider.store') }}"
          method="POST"
          enctype="multipart/form-data"
          class="space-y-6">
        @csrf
        @if (isset($slider))
            @method('PUT')
        @endif

        {{-- Step 1: Image --}}
        <div class="bg-dermond-card border border-white/10 rounded-2xl p-6 md:p-8">
            <div class="flex justify-between items-center mb-4">
                <div>
                    <label class="text-xs font-bold text-gray-500 uppercase tracking-widest">Slide Image *</label>
                    <p class="text-[10px] text-gray-500 mt-1">Upload full-width hero banner image (recommended: 1920x1080)</p>
                </div>
            </div>

            <div class="relative group">
                <input id="image" name="image" type="file" class="hidden" accept="image/*" onchange="previewImage(event)">

                <div class="w-full aspect-video rounded-xl bg-dermond-dark border-2 border-dashed border-white/10 hover:border-blue-500/30 hover:bg-blue-500/5 transition-all cursor-pointer overflow-hidden relative flex items-center justify-center" onclick="document.getElementById('image').click()">

                    <img id="image-preview"
                         src="{{ isset($slider) && $slider->hasImage() ? $slider->getImageUrl() : '#' }}"
                         alt="Preview"
                         class="absolute inset-0 w-full h-full object-cover {{ isset($slider) && $slider->hasImage() ? '' : 'hidden' }}">

                    <button type="button"
                            id="remove-image-btn"
                            onclick="removeImage(event)"
                            class="absolute top-4 right-4 bg-dermond-card/90 backdrop-blur text-red-400 p-2 rounded-xl shadow-lg hover:bg-red-500 hover:text-white transition-all z-20 border border-white/10 {{ isset($slider) && $slider->hasImage() ? '' : 'hidden' }}"
                            title="Remove Image">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>

                    <div id="upload-placeholder" class="text-center p-6 {{ isset($slider) && $slider->hasImage() ? 'hidden' : '' }}">
                        <div class="mx-auto w-12 h-12 bg-white/5 rounded-full flex items-center justify-center mb-3 text-blue-400 border border-white/10">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <p class="text-sm font-medium text-white">Click to upload</p>
                        <p class="text-xs text-gray-500 mt-1">PNG, JPG, WebP (Max 2MB)</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Step 2: Settings --}}
        <div class="bg-dermond-card border border-white/10 rounded-2xl p-6 md:p-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label for="position" class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">Order *</label>
                    <input type="number" 
                           name="position" 
                           id="position"
                           value="{{ old('position', $slider->position ?? '') }}"
                           class="w-full px-4 py-3 rounded-xl bg-dermond-dark border border-white/10 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all text-sm font-mono text-white"
                           placeholder="1"
                           min="1"
                           required>
                </div>

                <div>
                    <label for="status" class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">Status *</label>
                    <div class="relative">
                        <select name="status" id="status" class="w-full px-4 py-3 rounded-xl bg-dermond-dark border border-white/10 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all text-sm text-gray-300 appearance-none cursor-pointer" required>
                            @php $currentStatus = old('status', $slider->status ?? 'active'); @endphp
                            <option value="draft" {{ $currentStatus === 'draft' ? 'selected' : '' }}>Draft</option>
                            <option value="active" {{ $currentStatus === 'active' ? 'selected' : '' }}>Active</option>
                            <option value="archived" {{ $currentStatus === 'archived' ? 'selected' : '' }}>Archived</option>
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-gray-500">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                        </div>
                    </div>
                </div>

                <div>
                    <label for="label" class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">Label</label>
                    <input type="text" 
                           name="label" 
                           id="label"
                           value="{{ old('label', $slider->label ?? '') }}"
                           class="w-full px-4 py-3 rounded-xl bg-dermond-dark border border-white/10 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all text-sm text-white placeholder-gray-600"
                           placeholder="Internal note">
                </div>
            </div>
        </div>

        {{-- Actions --}}
        <div class="flex items-center justify-end gap-4">
            <a href="{{ route('admin.slider.index') }}" class="text-xs font-bold uppercase tracking-widest text-gray-400 hover:text-white transition-colors">Cancel</a>
            <button type="submit" class="bg-blue-600 hover:bg-blue-500 text-white px-8 py-3 rounded-xl font-bold uppercase tracking-wider text-xs shadow-lg shadow-blue-900/30 transition-all flex items-center gap-2">
                <span>{{ isset($slider) ? 'Save' : 'Create' }}</span>
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
            </button>
        </div>
    </form>
</div>

<script>
function previewImage(event) {
    const input = event.target;
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('image-preview').src = e.target.result;
            document.getElementById('image-preview').classList.remove('hidden');
            document.getElementById('upload-placeholder').classList.add('hidden');
            document.getElementById('remove-image-btn').classList.remove('hidden');
        }
        reader.readAsDataURL(input.files[0]);
    }
}

function removeImage(event) {
    event.stopPropagation();
    document.getElementById('image').value = '';
    document.getElementById('image-preview').src = '#';
    document.getElementById('image-preview').classList.add('hidden');
    document.getElementById('upload-placeholder').classList.remove('hidden');
    document.getElementById('remove-image-btn').classList.add('hidden');
}
</script>
@endsection
