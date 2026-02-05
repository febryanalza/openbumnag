@props([
    'name' => 'content',
    'id' => 'content',
    'value' => '',
    'placeholder' => 'Tulis konten di sini...',
    'height' => '400px',
    'required' => false,
    'error' => false
])

{{-- Hidden textarea to store the content for form submission --}}
<input type="hidden" name="{{ $name }}" id="{{ $id }}">

{{-- Quill Editor Container --}}
<div id="{{ $id }}-editor" 
     class="quill-editor-container bg-white border @if($error) border-red-500 @else border-gray-300 @endif rounded-lg overflow-hidden"
     style="min-height: {{ $height }};">
</div>

@once
@push('styles')
{{-- Quill Editor CSS --}}
<link href="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.snow.css" rel="stylesheet">
<style>
    .quill-editor-container {
        display: flex;
        flex-direction: column;
    }
    .quill-editor-container .ql-toolbar {
        border: none;
        border-bottom: 1px solid #e5e7eb;
        background: #f9fafb;
        flex-shrink: 0;
    }
    .quill-editor-container .ql-container {
        border: none;
        flex: 1;
        overflow-y: auto;
        font-size: 16px;
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
    }
    .quill-editor-container .ql-editor {
        min-height: 300px;
        line-height: 1.6;
        color: #374151;
    }
    .quill-editor-container .ql-editor.ql-blank::before {
        color: #9ca3af;
        font-style: normal;
    }
    .quill-editor-container .ql-editor h1 { font-size: 2rem; font-weight: 600; margin: 1.5rem 0 0.75rem 0; }
    .quill-editor-container .ql-editor h2 { font-size: 1.5rem; font-weight: 600; margin: 1.25rem 0 0.5rem 0; }
    .quill-editor-container .ql-editor h3 { font-size: 1.25rem; font-weight: 600; margin: 1rem 0 0.5rem 0; }
    .quill-editor-container .ql-editor p { margin: 0 0 1rem 0; }
    .quill-editor-container .ql-editor blockquote {
        border-left: 4px solid #f59e0b;
        margin: 1rem 0;
        padding: 0.5rem 1rem;
        background: #fef3c7;
        border-radius: 0 8px 8px 0;
    }
    .quill-editor-container .ql-editor img {
        max-width: 100%;
        height: auto;
        border-radius: 8px;
        margin: 1rem 0;
    }
    .quill-editor-container .ql-editor a {
        color: #f59e0b;
        text-decoration: underline;
    }
    .quill-editor-container .ql-editor ul, 
    .quill-editor-container .ql-editor ol {
        padding-left: 1.5rem;
        margin: 0.5rem 0;
    }
    .quill-editor-container .ql-editor code {
        background: #f3f4f6;
        padding: 0.125rem 0.375rem;
        border-radius: 0.25rem;
        font-family: monospace;
        font-size: 0.875rem;
    }
    .quill-editor-container .ql-editor pre {
        background: #1f2937;
        color: #f9fafb;
        padding: 1rem;
        border-radius: 0.5rem;
        overflow-x: auto;
        margin: 1rem 0;
    }
    .quill-editor-container .ql-editor pre code {
        background: transparent;
        color: inherit;
        padding: 0;
    }
    /* Toolbar button styling */
    .quill-editor-container .ql-toolbar button:hover,
    .quill-editor-container .ql-toolbar button:focus,
    .quill-editor-container .ql-toolbar button.ql-active {
        color: #f59e0b;
    }
    .quill-editor-container .ql-toolbar .ql-stroke {
        stroke: #374151;
    }
    .quill-editor-container .ql-toolbar button:hover .ql-stroke,
    .quill-editor-container .ql-toolbar button.ql-active .ql-stroke {
        stroke: #f59e0b;
    }
    .quill-editor-container .ql-toolbar .ql-fill {
        fill: #374151;
    }
    .quill-editor-container .ql-toolbar button:hover .ql-fill,
    .quill-editor-container .ql-toolbar button.ql-active .ql-fill {
        fill: #f59e0b;
    }
</style>
@endpush

@push('scripts')
{{-- Quill Editor JS --}}
<script src="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.js"></script>
@endpush
@endonce

@push('scripts')
<script>
(function() {
    // Wait for DOM and Quill to be ready
    function initQuillEditor() {
        if (typeof Quill === 'undefined') {
            console.warn('Quill not loaded yet, retrying...');
            setTimeout(initQuillEditor, 100);
            return;
        }

        const editorId = '{{ $id }}-editor';
        const inputId = '{{ $id }}';
        const editorElement = document.getElementById(editorId);
        const inputElement = document.getElementById(inputId);

        if (!editorElement) {
            console.error('Editor element not found:', editorId);
            return;
        }

        // Quill toolbar configuration
        const toolbarOptions = [
            [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
            [{ 'font': [] }],
            [{ 'size': ['small', false, 'large', 'huge'] }],
            ['bold', 'italic', 'underline', 'strike'],
            [{ 'color': [] }, { 'background': [] }],
            [{ 'script': 'sub' }, { 'script': 'super' }],
            [{ 'list': 'ordered' }, { 'list': 'bullet' }],
            [{ 'indent': '-1' }, { 'indent': '+1' }],
            [{ 'direction': 'rtl' }],
            [{ 'align': [] }],
            ['blockquote', 'code-block'],
            ['link', 'image', 'video'],
            ['clean']
        ];

        // Initialize Quill
        const quill = new Quill('#' + editorId, {
            theme: 'snow',
            placeholder: '{{ $placeholder }}',
            modules: {
                toolbar: toolbarOptions
            }
        });

        // Set initial content if provided
        const initialContent = {!! json_encode($value) !!};
        if (initialContent && initialContent.trim() !== '') {
            quill.clipboard.dangerouslyPasteHTML(initialContent);
        }

        // Sync content to hidden input on text change
        quill.on('text-change', function() {
            const html = quill.root.innerHTML;
            // Don't save if empty (just the default empty paragraph)
            if (html === '<p><br></p>' || html === '<p></p>') {
                inputElement.value = '';
            } else {
                inputElement.value = html;
            }
        });

        // Initial sync
        const initialHtml = quill.root.innerHTML;
        if (initialHtml !== '<p><br></p>' && initialHtml !== '<p></p>') {
            inputElement.value = initialHtml;
        }

        // Store quill instance globally for access in form handlers
        window.quillEditors = window.quillEditors || {};
        window.quillEditors['{{ $id }}'] = quill;

        console.log('Quill editor initialized for:', '{{ $id }}');
    }

    // Initialize when DOM is ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initQuillEditor);
    } else {
        // Small delay to ensure Quill script is loaded
        setTimeout(initQuillEditor, 50);
    }
})();
</script>
@endpush
