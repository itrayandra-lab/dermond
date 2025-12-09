@props(['id', 'name', 'value' => '', 'placeholder' => 'Start writing...'])

@once
@push('styles')
<style>
    /* Dermond Dark Trix Theme */
    trix-toolbar .trix-button-group {
        border-color: rgba(255, 255, 255, 0.1) !important;
    }
    
    trix-toolbar .trix-button {
        border-bottom-color: rgba(255, 255, 255, 0.1) !important;
    }
    
    trix-toolbar .trix-button--icon {
        filter: invert(1) brightness(0.85);
    }
    
    trix-toolbar .trix-button--icon:hover {
        background-color: rgba(59, 130, 246, 0.2) !important;
        filter: invert(48%) sepia(79%) saturate(2476%) hue-rotate(210deg) brightness(100%) contrast(95%);
    }
    
    trix-toolbar .trix-button.trix-active {
        background-color: rgba(59, 130, 246, 0.25) !important;
        filter: invert(48%) sepia(79%) saturate(2476%) hue-rotate(210deg) brightness(100%) contrast(95%);
    }
    
    trix-editor {
        border: none !important;
        padding: 1.5rem !important;
        font-family: 'Inter', sans-serif;
        color: #e2e8f0;
        min-height: 400px;
    }

    trix-editor::placeholder {
        color: #475569;
    }

    trix-editor ol,
    .trix-content ol {
        list-style: decimal outside;
        padding-left: 1.5rem;
    }

    trix-editor ol li,
    .trix-content ol li {
        list-style-type: decimal;
    }

    trix-editor:focus {
        outline: none !important;
    }

    trix-toolbar {
        border-bottom: 1px solid rgba(255, 255, 255, 0.1) !important;
        background-color: #0a1226 !important;
        border-radius: 1rem 1rem 0 0;
        padding: 0.75rem !important;
    }

    trix-toolbar .trix-dialogs {
        background-color: #0f172a !important;
        border: 1px solid rgba(255, 255, 255, 0.1) !important;
    }

    trix-toolbar .trix-dialog {
        background-color: #0f172a !important;
    }

    trix-toolbar .trix-dialog__link-fields input {
        background-color: #050a14 !important;
        border: 1px solid rgba(255, 255, 255, 0.1) !important;
        color: #e2e8f0 !important;
    }

    trix-toolbar .trix-input {
        background-color: #050a14 !important;
        border: 1px solid rgba(255, 255, 255, 0.1) !important;
        color: #e2e8f0 !important;
    }

    trix-editor a {
        color: #60a5fa;
    }

    trix-editor a:hover {
        color: #3b82f6;
    }
</style>
@endpush
@endonce

<div class="bg-dermond-card border border-white/10 rounded-2xl overflow-hidden min-h-[500px] flex flex-col">
    <input
        type="hidden"
        name="{{ $name }}"
        id="{{ $id }}"
        value="{{ $value }}"
    />

    <trix-editor
        input="{{ $id }}"
        class="trix-content flex-1 bg-dermond-dark"
        placeholder="{{ $placeholder }}"
        {{ $attributes }}
    ></trix-editor>
</div>
