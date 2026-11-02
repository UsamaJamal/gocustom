@extends('admin.layout')
@section('title', ($item ? 'Edit ' : 'Add ') . $meta['singular'])
@section('heading', ($item ? 'Edit ' : 'Add ') . $meta['singular'])
@section('content')

@php
    $v = fn($key, $default = '') => old($key, $item[$key] ?? $default);
    $editing = (bool)$item;
    $pageFaqs = json_decode($item['faqs'] ?? '[]', true) ?: [];
    $resolveImg = fn($path) => empty($path) ? '' : (\Illuminate\Support\Str::startsWith($path, ['storage/', 'uploads/', 'images/']) ? asset($path) : asset('storage/' . $path));
@endphp

@if($errors->any())
    <div class="alert" style="background:#fff0f0; color:#9c2828">
        {{ $errors->first() }}
    </div>
@endif

<form class="panel" style="margin-top:0" method="post" enctype="multipart/form-data" action="{{ $editing ? route('admin.module.update', [$module, $item['id']]) : route('admin.module.store', $module) }}">
    @csrf
    @if($editing)
        @method('PUT')
    @endif

    <div class="section">
        <h3>Basic Information</h3>
        <div class="form-grid">
            <div class="field">
                <label>Title / Name *</label>
                <input name="title" required value="{{ $v('title') }}" placeholder="Enter {{ strtolower($meta['singular']) }} title">
            </div>
            
            <div class="field">
                <label>URL Slug</label>
                <input name="slug" value="{{ $v('slug') }}" placeholder="auto-generated-from-title">
            </div>
            
            <div class="field">
                <label>Status</label>
                <select name="status">
                    <option value="draft" @selected($v('status') === 'draft')>Draft</option>
                    <option value="published" @selected($v('status') === 'published')>Published</option>
                    <option value="inactive" @selected($v('status') === 'inactive')>Inactive</option>
                </select>
            </div>
            
            <div class="field">
                <label>Featured Image</label>
                @if($editing && !empty($item['image']))
                    <div style="margin-bottom:0.5rem">
                        <img src="{{ $resolveImg($item['image']) }}" style="height:3.75rem; border-radius:0.25rem; border:1px solid #ddd">
                    </div>
                @endif
                <input type="file" name="image" accept="image/*">
            </div>
        </div>
    </div>
    <div class="section">
        <h3>Page Content</h3>
        <div class="form-grid">
            <div class="field">
                <label>Page Heading</label>
                <input name="heading" value="{{ $v('heading') }}">
            </div>
            
            <div class="field">
                <label>Menu Position</label>
                <input type="number" name="position" value="{{ $v('position', 0) }}">
            </div>
            
            <div class="field">
                <label>Appearance / Template</label>
                <select name="appearance">
                    <option @selected($v('appearance') === 'Default')>Default</option>
                    <option @selected($v('appearance') === 'Policy')>Policy</option>
                    <option @selected($v('appearance') === 'Landing Page')>Landing Page</option>
                    <option @selected($v('appearance') === 'Contact')>Contact</option>
                </select>
            </div>
            
            <div class="field">
                <label>Image Alt Text</label>
                <input name="alt_text" value="{{ $v('alt_text') }}">
            </div>
            
            <div class="field full">
                <label>Page Content</label>
                <textarea name="content" style="min-height:21.25rem">{{ $v('content') }}</textarea>
        </div>
    </div>

    <div class="section">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.9375rem;">
            <h3 style="margin-bottom: 0;">Page FAQs</h3>
            <button type="button" onclick="addFaqRow()" class="btn light" style="padding: 0.375rem 0.75rem; font-size: 0.8125rem;"><i class="fa-solid fa-plus"></i> Add FAQ</button>
        </div>
        <div class="form-grid" id="faqsContainer">
            @php
                $oldQuestions = old('faq_question');
                $oldAnswers = old('faq_answer');
                $hasOld = is_array($oldQuestions);
                
                $initialFaqs = [];
                if ($hasOld) {
                    foreach ($oldQuestions as $idx => $q) {
                        $initialFaqs[] = [
                            'question' => $q,
                            'answer' => $oldAnswers[$idx] ?? '',
                        ];
                    }
                } elseif (!empty($pageFaqs)) {
                    $initialFaqs = $pageFaqs;
                }
            @endphp

            <div id="noFaqsMessage" style="grid-column: 1 / -1; color: var(--muted); padding: 0.75rem 0; font-size: 0.875rem; {{ count($initialFaqs) > 0 ? 'display: none;' : '' }}">
                No FAQs added yet for this page. Click "<strong>+ Add FAQ</strong>" above to add one.
            </div>

            @foreach($initialFaqs as $i => $faq)
                <div class="field faq-question-field">
                    <label class="faq-q-label">Question {{ $i + 1 }}</label>
                    <input name="faq_question[]" value="{{ $faq['question'] ?? ($faq['q'] ?? '') }}" placeholder="Enter question">
                </div>
                <div class="field faq-answer-field">
                    <label class="faq-a-label">Answer {{ $i + 1 }}</label>
                    <div style="display: flex; gap: 0.625rem; align-items: flex-start;">
                        <textarea name="faq_answer[]" style="min-height:4.375rem; flex: 1;" placeholder="Enter answer">{{ $faq['answer'] ?? ($faq['a'] ?? '') }}</textarea>
                        <button type="button" onclick="removeFaqRow(this)" style="background: none; border: none; color: #e74c3c; cursor: pointer; padding: 0.3125rem; margin-top: 0.3125rem; font-size: 1rem;" title="Remove FAQ"><i class="fa-solid fa-trash"></i></button>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <div class="section">
        <h3>SEO & Search Visibility</h3>
        <div class="form-grid">
            <div class="field">
                <label>Meta Title</label>
                <input name="meta_title" value="{{ $v('meta_title') }}">
            </div>
            
            <div class="field">
                <label>Robots</label>
                @php
                    $pageRobots = str_replace(' ', '', (string) ($v('robots', 'index,follow') ?: 'index,follow'));
                @endphp
                <select name="robots">
                    <option value="index,follow" @selected($pageRobots === 'index,follow')>index, follow</option>
                    <option value="index,nofollow" @selected($pageRobots === 'index,nofollow')>index, nofollow</option>
                    <option value="noindex,follow" @selected($pageRobots === 'noindex,follow')>noindex, follow</option>
                    <option value="noindex,nofollow" @selected($pageRobots === 'noindex,nofollow')>noindex, nofollow</option>
                </select>
            </div>
            
            <div class="field full">
                <label>Meta Description</label>
                <textarea name="meta_description">{{ $v('meta_description') }}</textarea>
            </div>
            
            <div class="field full">
                <label>Meta Keywords / Tags</label>
                <input name="meta_keywords" value="{{ $v('meta_keywords') }}">
            </div>
            
            <div class="field full">
                <label>Schema JSON-LD</label>
                <textarea name="schema" placeholder='{"@context":"https://schema.org"}'>{{ $v('schema') }}</textarea>
            </div>
        </div>
    </div>

    <div class="section">
        <h3>Visibility</h3>
        <div class="checks">
            <label class="check">
                <input type="checkbox" name="show_home" value="1" @checked($v('show_home'))> 
                Show on home page
            </label>
            
        </div>
    </div>

    <div class="actions">
        <a class="btn light" href="{{ route('admin.module.index', $module) }}">Cancel</a>
        <button class="btn" type="submit">Save {{ $meta['singular'] }}</button>
    </div>
</form>

<script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/6.8.2/tinymce.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        if (typeof tinymce !== 'undefined') {
            tinymce.init({
                ...window.tinyMceUploadConfig,
                selector: 'textarea[name="content"]',
                height: 400,
                plugins: 'code advlist autolink lists link image charmap preview anchor searchreplace visualblocks fullscreen insertdatetime media table help wordcount',
                toolbar: 'undo redo | blocks | bold italic underline strikethrough | forecolor backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media table | code fullscreen preview',
                block_formats: 'Paragraph=p; Heading 1=h1; Heading 2=h2; Heading 3=h3; Heading 4=h4; Heading 5=h5; Heading 6=h6; Preformatted=pre',
                branding: false,
                promotion: false,
                content_style: 'body { font-family:"DM Sans",sans-serif; font-size:0.875rem; line-height:1.6; }'
            });
        }
    });
</script>
<script>
    function updateFaqLabels() {
        const container = document.getElementById('faqsContainer');
        const qFields = container.querySelectorAll('.faq-question-field');
        const aFields = container.querySelectorAll('.faq-answer-field');
        const emptyMsg = document.getElementById('noFaqsMessage');

        qFields.forEach((field, idx) => {
            const lbl = field.querySelector('.faq-q-label');
            if (lbl) lbl.innerText = 'Question ' + (idx + 1);
        });

        aFields.forEach((field, idx) => {
            const lbl = field.querySelector('.faq-a-label');
            if (lbl) lbl.innerText = 'Answer ' + (idx + 1);
        });

        if (emptyMsg) {
            emptyMsg.style.display = qFields.length === 0 ? 'block' : 'none';
        }
    }

    function addFaqRow() {
        const container = document.getElementById('faqsContainer');
        const count = container.querySelectorAll('.faq-question-field').length;
        const newIndex = count + 1;
        
        const qField = document.createElement('div');
        qField.className = 'field faq-question-field';
        qField.innerHTML = `<label class="faq-q-label">Question ${newIndex}</label><input name="faq_question[]" value="" placeholder="Enter question">`;
        
        const aField = document.createElement('div');
        aField.className = 'field faq-answer-field';
        aField.innerHTML = `
            <label class="faq-a-label">Answer ${newIndex}</label>
            <div style="display: flex; gap: 0.625rem; align-items: flex-start;">
                <textarea name="faq_answer[]" style="min-height:4.375rem; flex: 1;" placeholder="Enter answer"></textarea>
                <button type="button" onclick="removeFaqRow(this)" style="background: none; border: none; color: #e74c3c; cursor: pointer; padding: 0.3125rem; margin-top: 0.3125rem; font-size: 1rem;" title="Remove FAQ"><i class="fa-solid fa-trash"></i></button>
            </div>
        `;
        
        container.appendChild(qField);
        container.appendChild(aField);
        updateFaqLabels();
    }

    function removeFaqRow(btn) {
        const aField = btn.closest('.faq-answer-field');
        if (!aField) return;
        const qField = aField.previousElementSibling;
        if (qField && qField.classList.contains('faq-question-field')) {
            qField.remove();
        }
        aField.remove();
        updateFaqLabels();
    }
</script>
@endsection
