@extends('admin.layout')
@section('title', ($item ? 'Edit ' : 'Add ') . $meta['singular'])
@section('heading', ($item ? 'Edit ' : 'Add ') . $meta['singular'])
@section('content')

<script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/6.8.2/tinymce.min.js"></script>

@php
    $v = fn($key, $default = '') => old($key, $item[$key] ?? $default);
    $editing = (bool)$item;
    $selectedParentId = old('parent_id', $item['parent_id'] ?? '');
    $categoryFaqs = $categoryFaqs ?? [];
    $categoryFeatureSections = json_decode($item['feature_sections'] ?? '[]', true) ?: [];
    if (is_array(old('feature_section_title'))) {
        $categoryFeatureSections = [];
        foreach (old('feature_section_title') as $index => $title) {
            $categoryFeatureSections[] = [
                'title' => $title,
                'description' => old('feature_section_description.' . $index, ''),
                'image' => old('feature_section_existing_image.' . $index, ''),
            ];
        }
    }
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
                <label>Category / Card Title *</label>
                <input name="title" required value="{{ $v('title') }}" placeholder="Enter {{ strtolower($meta['singular']) }} title">
            </div>
            
            <div class="field">
                <label>URL Slug</label>
                <input name="slug" value="{{ $v('slug') }}" placeholder="auto-generated-from-title">
            </div>
            
            <div class="field">
                <label>Status</label>
                <select name="status">
                    <option value="draft" @if($v('status') === 'draft') selected @endif>Draft</option>
                    <option value="published" @if($v('status') === 'published') selected @endif>Published</option>
                    <option value="inactive" @if($v('status') === 'inactive') selected @endif>Inactive</option>
                </select>
            </div>
            
            <div class="field page-only-section">
                <label>Featured Image</label>
                @if($editing && !empty($item['image']))
                    <div class="single-image-wrapper" style="margin-bottom:0.5rem; position:relative; display:inline-block;">
                        <img src="{{ $resolveImg($item['image']) }}" style="height:3.75rem; border-radius:0.25rem; border:1px solid #ddd; display:block;">
                        <span onclick="removeSingleImage(this, 'image')" style="position:absolute; top:-0.375rem; right:-0.375rem; background:#e74c3c; color:white; border-radius:50%; width:1.125rem; height:1.125rem; display:flex; align-items:center; justify-content:center; font-size:0.875rem; font-weight:bold; cursor:pointer; box-shadow:0 1px 0.1875rem rgba(0,0,0,0.3); line-height:1;" title="Remove Image">&times;</span>
                    </div>
                @endif
                <input type="file" name="image" accept="image/*">
            </div>
        </div>
    </div>
    <div class="section">
        <h3>Category Hierarchy</h3>
        <div class="field full" style="margin-bottom:1rem; background:#fff8e6; border:1px solid #ffe0a3; border-radius:0.5rem; padding:0.875rem 1rem;">
            <label class="check" style="display:flex; align-items:flex-start; gap:0.625rem; margin:0; cursor:pointer;">
                <input type="checkbox" id="isNavGroupToggle" name="is_nav_group" value="1" @if((bool) $v('is_nav_group')) checked @endif style="margin-top:0.2rem;">
                <span>
                    <strong>Navigation group only — no public page</strong>
                    <small style="display:block; margin-top:0.25rem; color:#6b7280;">Use this for menu parents like <em>Box by Industry</em>, <em>Box by Material</em> or <em>Box by Style</em>. It just groups other categories in the navbar; it will not open its own page (the slug returns 404). Assign child categories to it using their own <strong>Parent Category</strong> field. When checked, the page-content fields below are hidden.</small>
                </span>
            </label>
        </div>
        <div class="form-grid">
            <div class="field">
                <label>Parent Category</label>
                <select name="parent_id">
                    <option value="" @if($selectedParentId === '' || $selectedParentId === null) selected @endif>— Top Level —</option>
                    @foreach($categories as $cat)
                        @if(!$item || (string) $cat['id'] !== (string) $item['id'])
                            <option value="{{ $cat['id'] }}" @if((string) $selectedParentId === (string) $cat['id']) selected @endif>
                                {{ $cat['title'] }}
                            </option>
                        @endif
                    @endforeach
                </select>
            </div>
            
            <div class="field">
                <label>Category Card & Navigation Icon</label>
                @if($editing && !empty($item['icon']))
                    <div class="single-image-wrapper" style="margin-bottom:0.5rem; position:relative; display:inline-block;">
                        <img src="{{ $resolveImg($item['icon']) }}" style="height:3.75rem; border-radius:0.25rem; border:1px solid #ddd; display:block;">
                        <span onclick="removeSingleImage(this, 'icon')" style="position:absolute; top:-0.375rem; right:-0.375rem; background:#e74c3c; color:white; border-radius:50%; width:1.125rem; height:1.125rem; display:flex; align-items:center; justify-content:center; font-size:0.875rem; font-weight:bold; cursor:pointer; box-shadow:0 1px 0.1875rem rgba(0,0,0,0.3); line-height:1;" title="Remove Image">&times;</span>
                    </div>
                @endif
                <input type="file" name="icon" accept="image/*">
            </div>
        </div>
    </div>

    <div class="section page-only-section">
        <h3>Hero & Banner</h3>
        <div class="form-grid">
            <div class="field">
                <label>Hero Title</label>
                <input name="hero_title" value="{{ $v('hero_title') }}">
            </div>
            
            <div class="field">
                <label>Hero Badge</label>
                <input name="hero_badge" value="{{ $v('hero_badge') }}">
            </div>
            
            <div class="field full">
                <label>Hero Description</label>
                <textarea name="hero_description" id="hero_description_input" placeholder="Enter hero description...">{{ $v('hero_description') }}</textarea>
            </div>
            
            <div class="field">
                <label>Hero Image</label>
                @if($editing && !empty($item['hero_image']))
                    <div class="single-image-wrapper" style="margin-bottom:0.5rem; position:relative; display:inline-block;">
                        <img src="{{ $resolveImg($item['hero_image']) }}" style="height:3.75rem; border-radius:0.25rem; border:1px solid #ddd; display:block;">
                        <span onclick="removeSingleImage(this, 'hero_image')" style="position:absolute; top:-0.375rem; right:-0.375rem; background:#e74c3c; color:white; border-radius:50%; width:1.125rem; height:1.125rem; display:flex; align-items:center; justify-content:center; font-size:0.875rem; font-weight:bold; cursor:pointer; box-shadow:0 1px 0.1875rem rgba(0,0,0,0.3); line-height:1;" title="Remove Image">&times;</span>
                    </div>
                @endif
                <input type="file" name="hero_image" accept="image/*">
            </div>
            
            <div class="field">
                <label>Card Hover Banner Image</label>
                @if($editing && !empty($item['banner_image']))
                    <div class="single-image-wrapper" style="margin-bottom:0.5rem; position:relative; display:inline-block;">
                        <img src="{{ $resolveImg($item['banner_image']) }}" style="height:3.75rem; border-radius:0.25rem; border:1px solid #ddd; display:block;">
                        <span onclick="removeSingleImage(this, 'banner_image')" style="position:absolute; top:-0.375rem; right:-0.375rem; background:#e74c3c; color:white; border-radius:50%; width:1.125rem; height:1.125rem; display:flex; align-items:center; justify-content:center; font-size:0.875rem; font-weight:bold; cursor:pointer; box-shadow:0 1px 0.1875rem rgba(0,0,0,0.3); line-height:1;" title="Remove Image">&times;</span>
                    </div>
                @endif
                <input type="file" name="banner_image" accept="image/*">
            </div>
        </div>
    </div>

    <div class="section page-only-section">
        <h3>Category Sections</h3>
        <div class="form-grid">
            <div class="field full">
                <label>Key Features Section Heading</label>
                <input name="feature_title" value="{{ $v('feature_title') }}" placeholder="e.g. Key Packaging Features">
                <small style="display:block; margin-top:0.375rem; color:#6b7280;">This heading appears above the image and text feature section on the category page.</small>
            </div>
        </div>
    </div>

    <div class="section page-only-section">
        <div style="display:flex; justify-content:space-between; align-items:center; gap:1rem; margin-bottom:0.9375rem;">
            <div>
                <h3 style="margin:0;">Image & Text Feature Sections</h3>
                <p style="margin:0.3125rem 0 0; color:#6b7280; font-size:0.8125rem;">Add as many image, title, and description rows as needed. They will alternate left and right on this category page.</p>
            </div>
            <button type="button" onclick="addFeatureSection()" class="btn light" style="padding:0.375rem 0.75rem; font-size:0.8125rem;"><i class="fa-solid fa-plus"></i> Add Section</button>
        </div>
        <div id="featureSectionsContainer" style="display:grid; gap:1rem;">
            @foreach($categoryFeatureSections as $index => $feature)
                @php $editorId = 'feature_desc_' . $index . '_' . \Illuminate\Support\Str::random(5); @endphp
                <div class="feature-section-row" style="border:1px solid #e5e7eb; border-radius:0.5rem; padding:1rem; background:#fafafa;">
                    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:0.75rem;">
                        <strong>Feature Section <span class="feature-section-number">{{ $loop->iteration }}</span></strong>
                        <button type="button" onclick="removeFeatureSection(this)" style="background:none; border:0; color:#e74c3c; cursor:pointer;" title="Remove section"><i class="fa-solid fa-trash"></i> Remove</button>
                    </div>
                    <input type="hidden" name="feature_section_existing_image[]" value="{{ $feature['image'] ?? '' }}">
                    <div class="form-grid">
                        <div class="field">
                            <label>Heading</label>
                            <input name="feature_section_title[]" value="{{ $feature['title'] ?? '' }}" placeholder="Feature heading">
                        </div>
                        <div class="field">
                            <label>Image</label>
                            @if(!empty($feature['image']))
                                <img src="{{ $resolveImg($feature['image']) }}" alt="" style="display:block; width:5rem; height:3.75rem; object-fit:cover; border-radius:0.25rem; margin-bottom:0.5rem;">
                            @endif
                            <input type="file" name="feature_section_image[]" accept="image/*">
                        </div>
                        <div class="field full">
                            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:0.25rem;">
                                <label style="margin:0;">Description <small style="font-weight:normal; color:#6b7280;">(Select word & click 🔗 Link to insert anchor tag)</small></label>
                                <button type="button" onclick="insertAnchorLink('{{ $editorId }}')" class="btn light" style="padding:0.15rem 0.5rem; font-size:0.75rem; line-height:1.2;" title="Insert Anchor Link"><i class="fa-solid fa-link"></i> Add Link</button>
                            </div>
                            <textarea id="{{ $editorId }}" name="feature_section_description[]" class="feature-desc-editor" style="min-height:5.625rem;">{{ $feature['description'] ?? '' }}</textarea>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <div class="section page-only-section">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.9375rem;">
            <h3 style="margin-bottom: 0;">Category FAQs</h3>
            <button type="button" onclick="addFaqRow()" class="btn light" style="padding: 0.375rem 0.75rem; font-size: 0.8125rem;"><i class="fa-solid fa-plus"></i> Add FAQ</button>
        </div>
        <div class="form-grid" id="faqsContainer">
            @php
                $faqsCount = max(1, count($categoryFaqs ?? []), count(old('faq_question', [])));
            @endphp
            @for($i = 0; $i < $faqsCount; $i++)
                <div class="field faq-question-field">
                    <label class="faq-q-label">Question {{ $i + 1 }}</label>
                    <input name="faq_question[]" value="{{ old('faq_question.' . $i, $categoryFaqs[$i]['question'] ?? '') }}">
                </div>
                <div class="field faq-answer-field">
                    <label class="faq-a-label">Answer {{ $i + 1 }}</label>
                    <div style="display: flex; gap: 0.625rem; align-items: flex-start;">
                        <textarea name="faq_answer[]" style="min-height:4.375rem; flex: 1;">{{ old('faq_answer.' . $i, $categoryFaqs[$i]['answer'] ?? '') }}</textarea>
                        <button type="button" onclick="removeFaqRow(this)" style="background: none; border: none; color: #e74c3c; cursor: pointer; padding: 0.3125rem; margin-top: 0.3125rem;" title="Remove FAQ"><i class="fa-solid fa-trash"></i></button>
                    </div>
                </div>
            @endfor
        </div>
    </div>
    <div class="section page-only-section">
        <h3>SEO & Search Visibility</h3>
        <div class="form-grid">
            <div class="field">
                <label>Meta Title</label>
                <input name="meta_title" value="{{ $v('meta_title') }}">
            </div>
            
            <div class="field">
                <label>Robots</label>
                @php $catRobots = str_replace(' ', '', (string) ($v('robots', 'index,follow') ?: 'index,follow')); @endphp
                <select name="robots">
                    <option value="index,follow" @selected($catRobots === 'index,follow')>index, follow</option>
                    <option value="index,nofollow" @selected($catRobots === 'index,nofollow')>index, nofollow</option>
                    <option value="noindex,follow" @selected($catRobots === 'noindex,follow')>noindex, follow</option>
                    <option value="noindex,nofollow" @selected($catRobots === 'noindex,nofollow')>noindex, nofollow</option>
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
            
            <div class="field full" style="background:#f8fafc; border:1px solid #e2e8f0; border-radius:8px; padding:1.25rem; margin-top:0.5rem; margin-bottom:0.5rem;">
                <div style="font-weight:700; color:#1e293b; margin-bottom:0.75rem; font-size:0.95rem; display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:0.5rem;">
                    <div style="display:flex; align-items:center; gap:0.5rem;">
                        <span>⭐ Schema Rating, Reviews & Price</span>
                        <span style="font-size:0.75rem; font-weight:400; color:#64748b;">(Signs like $ are added automatically into schema below)</span>
                    </div>
                </div>
                <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(180px, 1fr)); gap:1rem;">
                    <div class="field" style="margin:0;">
                        <label style="font-size:0.85rem; font-weight:600; color:#475569;">Rating Value (★)</label>
                        <div style="display:flex; align-items:center; background:#fff; border:1px solid #cbd5e1; border-radius:6px; overflow:hidden;">
                            <span style="padding:0.45rem 0.65rem; background:#f1f5f9; color:#eab308; font-size:0.95rem; border-right:1px solid #cbd5e1;">★</span>
                            <input type="text" name="rating_value" id="schema_rating_value" value="{{ $v('rating_value') }}" placeholder="4.9" autocomplete="off" style="border:none; outline:none; flex:1; padding:0.45rem 0.65rem;">
                        </div>
                    </div>
                    <div class="field" style="margin:0;">
                        <label style="font-size:0.85rem; font-weight:600; color:#475569;">Review Count (💬)</label>
                        <div style="display:flex; align-items:center; background:#fff; border:1px solid #cbd5e1; border-radius:6px; overflow:hidden;">
                            <span style="padding:0.45rem 0.65rem; background:#f1f5f9; color:#64748b; font-size:0.85rem; border-right:1px solid #cbd5e1;"><i class="fa-solid fa-comment-dots"></i></span>
                            <input type="text" name="review_count" id="schema_review_count" value="{{ $v('review_count') }}" placeholder="1540" autocomplete="off" style="border:none; outline:none; flex:1; padding:0.45rem 0.65rem;">
                        </div>
                    </div>
                    <div class="field" style="margin:0;">
                        <label style="font-size:0.85rem; font-weight:600; color:#475569;">Price / Price Range ($)</label>
                        <div style="display:flex; align-items:center; background:#fff; border:1px solid #cbd5e1; border-radius:6px; overflow:hidden;">
                            <span style="padding:0.45rem 0.65rem; background:#f1f5f9; color:#64748b; font-weight:700; font-size:0.9rem; border-right:1px solid #cbd5e1;">$</span>
                            <input type="text" name="price" id="schema_price" value="{{ $v('price') }}" placeholder="$$ or 0.10" autocomplete="off" style="border:none; outline:none; flex:1; padding:0.45rem 0.65rem;">
                        </div>
                    </div>
                </div>
            </div>

            <div class="field full">
                <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:0.35rem;">
                    <label style="margin:0;">Schema JSON-LD</label>
                    <span id="schema_sync_indicator" style="font-size:0.75rem; color:#16a34a; font-weight:500; display:none;"><i class="fa-solid fa-check"></i> Real-time synced</span>
                </div>
                <textarea name="schema" id="schema_json_ld" rows="12" style="font-family:monospace; font-size:13px; line-height:1.4;" placeholder='{"@context":"https://schema.org"}'>{{ $v('schema') }}</textarea>
            </div>
        </div>
    </div>

    <div class="section">
        <h3>Visibility</h3>
        <div class="checks">
            <label class="check">
                <input type="checkbox" name="show_home" value="1" @if((bool) $v('show_home')) checked @endif> 
                Show on home page
            </label>
            <label class="check"><input type="checkbox" name="show_in_nav" value="1" @if((bool) $v('show_in_nav')) checked @endif> Show in navigation</label>
        </div>
    </div>

    <div class="actions">
        <a class="btn light" href="{{ route('admin.module.index', $module) }}">Cancel</a>
        <button class="btn" type="submit">Save {{ $meta['singular'] }}</button>
    </div>
</form>

<script>
    function initFeatureEditor(id) {
        if (typeof tinymce === 'undefined') return;
        if (tinymce.get(id)) {
            tinymce.get(id).remove();
        }
        tinymce.init({
            selector: '#' + id,
            height: 180,
            menubar: false,
            plugins: 'code autolink link lists',
            toolbar: 'undo redo | bold italic underline | link unlink | bullist numlist | code',
            branding: false,
            promotion: false,
            content_style: 'body { font-family: sans-serif; font-size: 14px; line-height: 1.5; }',
            setup: function (editor) {
                editor.on('change keyup blur', function () {
                    editor.save();
                });
            }
        });
    }

    function insertAnchorLink(editorId) {
        if (typeof tinymce !== 'undefined' && tinymce.get(editorId)) {
            tinymce.get(editorId).execCommand('mceLink');
            return;
        }
        var textarea = document.getElementById(editorId);
        if (!textarea) return;
        var url = prompt('Enter URL for link:', 'https://');
        if (!url) return;
        var start = textarea.selectionStart;
        var end = textarea.selectionEnd;
        var selected = textarea.value.substring(start, end) || 'Link Text';
        var linkTag = '<a href="' + url + '">' + selected + '</a>';
        textarea.value = textarea.value.substring(0, start) + linkTag + textarea.value.substring(end);
    }

    document.addEventListener('DOMContentLoaded', function () {
        if (typeof tinymce !== 'undefined') {
            tinymce.init({
                ...window.tinyMceUploadConfig,
                selector: 'textarea[name="description"]',
                height: 420,
                plugins: 'code advlist autolink lists link image charmap preview anchor searchreplace visualblocks fullscreen insertdatetime media table help wordcount',
                toolbar: 'undo redo | blocks | bold italic underline strikethrough | forecolor backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media table | code fullscreen preview',
                block_formats: 'Paragraph=p; Heading 1=h1; Heading 2=h2; Heading 3=h3; Heading 4=h4; Heading 5=h5; Heading 6=h6; Preformatted=pre',
                branding: false,
                promotion: false,
                content_style: 'body { font-family:"DM Sans",sans-serif; font-size:0.875rem; line-height:1.6; }'
            });

            document.querySelectorAll('.feature-desc-editor').forEach(function(el) {
                if (el.id) {
                    initFeatureEditor(el.id);
                }
            });
        }

        const form = document.querySelector('form.panel');
        if (form) {
            form.addEventListener('submit', function() {
                if (typeof tinymce !== 'undefined') {
                    tinymce.triggerSave();
                }
            });
        }

        // Navigation group toggle: hide all page-content fields when this category
        // is only a navbar group (no public page of its own).
        const navGroupToggle = document.getElementById('isNavGroupToggle');
        if (navGroupToggle) {
            const applyNavGroupState = function () {
                const hide = navGroupToggle.checked;
                document.querySelectorAll('.page-only-section').forEach(function (el) {
                    el.style.display = hide ? 'none' : '';
                });
            };
            navGroupToggle.addEventListener('change', applyNavGroupState);
            applyNavGroupState();
        }
    });

    function removeSingleImage(btn, fieldName) {
        if (!confirm('Are you sure you want to remove this image?')) return;
        const wrapper = btn.closest('.single-image-wrapper');
        const form = wrapper.closest('form');
        let hidden = form.querySelector('input[name="remove_' + fieldName + '"]');
        if (!hidden) {
            hidden = document.createElement('input');
            hidden.type = 'hidden';
            hidden.name = 'remove_' + fieldName;
            form.appendChild(hidden);
        }
        hidden.value = '1';
        wrapper.style.display = 'none';
    }

    function addFaqRow() {
        const container = document.getElementById('faqsContainer');
        const count = container.querySelectorAll('.faq-question-field').length;
        const newIndex = count + 1;
        
        const qField = document.createElement('div');
        qField.className = 'field faq-question-field';
        qField.innerHTML = `<label class="faq-q-label">Question ${newIndex}</label><input name="faq_question[]" value="">`;
        
        const aField = document.createElement('div');
        aField.className = 'field faq-answer-field';
        aField.innerHTML = `
            <label class="faq-a-label">Answer ${newIndex}</label>
            <div style="display: flex; gap: 0.625rem; align-items: flex-start;">
                <textarea name="faq_answer[]" style="min-height:4.375rem; flex: 1;"></textarea>
                <button type="button" onclick="removeFaqRow(this)" style="background: none; border: none; color: #e74c3c; cursor: pointer; padding: 0.3125rem; margin-top: 0.3125rem;" title="Remove FAQ"><i class="fa-solid fa-trash"></i></button>
            </div>
        `;
        
        container.appendChild(qField);
        container.appendChild(aField);
    }

    function removeFaqRow(btn) {
        const aField = btn.closest('.faq-answer-field');
        const qField = aField.previousElementSibling;
        aField.remove();
        qField.remove();
        
        const qLabels = document.querySelectorAll('#faqsContainer .faq-q-label');
        const aLabels = document.querySelectorAll('#faqsContainer .faq-a-label');
        qLabels.forEach((lbl, idx) => lbl.innerText = 'Question ' + (idx + 1));
        aLabels.forEach((lbl, idx) => lbl.innerText = 'Answer ' + (idx + 1));
    }

    function addFeatureSection() {
        const container = document.getElementById('featureSectionsContainer');
        const section = document.createElement('div');
        const uniqueId = 'feature_desc_' + Date.now() + '_' + Math.random().toString(36).substr(2, 5);
        section.className = 'feature-section-row';
        section.style.cssText = 'border:1px solid #e5e7eb; border-radius:0.5rem; padding:1rem; background:#fafafa;';
        section.innerHTML = `
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:0.75rem;">
                <strong>Feature Section <span class="feature-section-number"></span></strong>
                <button type="button" onclick="removeFeatureSection(this)" style="background:none; border:0; color:#e74c3c; cursor:pointer;" title="Remove section"><i class="fa-solid fa-trash"></i> Remove</button>
            </div>
            <input type="hidden" name="feature_section_existing_image[]" value="">
            <div class="form-grid">
                <div class="field"><label>Heading</label><input name="feature_section_title[]" placeholder="Feature heading"></div>
                <div class="field"><label>Image</label><input type="file" name="feature_section_image[]" accept="image/*"></div>
                <div class="field full">
                    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:0.25rem;">
                        <label style="margin:0;">Description <small style="font-weight:normal; color:#6b7280;">(Select word & click 🔗 Link to insert anchor tag)</small></label>
                        <button type="button" onclick="insertAnchorLink('${uniqueId}')" class="btn light" style="padding:0.15rem 0.5rem; font-size:0.75rem; line-height:1.2;" title="Insert Anchor Link"><i class="fa-solid fa-link"></i> Add Link</button>
                    </div>
                    <textarea id="${uniqueId}" name="feature_section_description[]" class="feature-desc-editor" style="min-height:5.625rem;"></textarea>
                </div>
            </div>`;
        container.appendChild(section);
        renumberFeatureSections();
        setTimeout(function() {
            initFeatureEditor(uniqueId);
        }, 50);
    }

    function removeFeatureSection(btn) {
        const row = btn.closest('.feature-section-row');
        const textarea = row.querySelector('.feature-desc-editor');
        if (textarea && textarea.id && typeof tinymce !== 'undefined' && tinymce.get(textarea.id)) {
            tinymce.get(textarea.id).remove();
        }
        row.remove();
        renumberFeatureSections();
    }

    function renumberFeatureSections() {
        document.querySelectorAll('.feature-section-number').forEach((number, index) => number.textContent = index + 1);
    }

    // --- Schema Real-time Sync Logic ---
    (function initCategorySchemaSync() {
        const ratingInput = document.getElementById('schema_rating_value');
        const reviewInput = document.getElementById('schema_review_count');
        const priceInput = document.getElementById('schema_price');
        const schemaTextarea = document.getElementById('schema_json_ld');
        const syncIndicator = document.getElementById('schema_sync_indicator');

        if (!schemaTextarea) return;

        function showSyncIndicator() {
            if (!syncIndicator) return;
            syncIndicator.style.display = 'inline-block';
            clearTimeout(syncIndicator._timer);
            syncIndicator._timer = setTimeout(() => {
                syncIndicator.style.display = 'none';
            }, 1800);
        }

        function updateFieldRecursive(obj, targetKey, newVal) {
            if (!obj || typeof obj !== 'object') return false;
            let updated = false;
            if (Array.isArray(obj)) {
                obj.forEach(item => {
                    if (updateFieldRecursive(item, targetKey, newVal)) updated = true;
                });
                return updated;
            }
            for (let k in obj) {
                if (!obj.hasOwnProperty(k)) continue;
                if (k.toLowerCase() === targetKey.toLowerCase()) {
                    if (typeof obj[k] === 'number' && !isNaN(Number(newVal)) && String(newVal).trim() !== '') {
                        obj[k] = Number(newVal);
                    } else {
                        obj[k] = String(newVal);
                    }
                    updated = true;
                } else if (typeof obj[k] === 'object' && obj[k] !== null) {
                    if (updateFieldRecursive(obj[k], targetKey, newVal)) updated = true;
                }
            }
            return updated;
        }

        function findFieldRecursive(obj, targetKey) {
            if (!obj || typeof obj !== 'object') return null;
            if (Array.isArray(obj)) {
                for (let item of obj) {
                    let found = findFieldRecursive(item, targetKey);
                    if (found !== null) return found;
                }
                return null;
            }
            for (let k in obj) {
                if (!obj.hasOwnProperty(k)) continue;
                if (k.toLowerCase() === targetKey.toLowerCase()) {
                    return obj[k];
                }
                if (typeof obj[k] === 'object' && obj[k] !== null) {
                    let found = findFieldRecursive(obj[k], targetKey);
                    if (found !== null) return found;
                }
            }
            return null;
        }

        function syncInputsToSchema() {
            const raw = schemaTextarea.value.trim();
            if (!raw) return;

            const ratingVal = ratingInput ? ratingInput.value.trim() : '';
            const reviewVal = reviewInput ? reviewInput.value.trim() : '';
            const priceVal = priceInput ? priceInput.value.trim() : '';

            let hasScriptTag = false;
            let jsonText = raw;
            const scriptMatch = raw.match(/^<script\b[^>]*>([\s\S]*?)<\/script>$/i);
            if (scriptMatch) {
                hasScriptTag = true;
                jsonText = scriptMatch[1].trim();
            }

            let parsed = null;
            try {
                parsed = JSON.parse(jsonText);
            } catch (err) {
                parsed = null;
            }

            let priceRangeVal = priceVal;
            if (priceRangeVal !== '' && !priceRangeVal.startsWith('$')) {
                priceRangeVal = '$' + priceRangeVal;
            }
            let cleanPrice = priceVal.replace(/^\$+/, '').trim();
            if (cleanPrice === '') cleanPrice = priceVal;

            if (parsed) {
                if (ratingVal !== '') updateFieldRecursive(parsed, 'ratingValue', ratingVal);
                if (reviewVal !== '') updateFieldRecursive(parsed, 'reviewCount', reviewVal);
                if (priceVal !== '') {
                    updateFieldRecursive(parsed, 'priceRange', priceRangeVal);
                    updateFieldRecursive(parsed, 'price', cleanPrice);
                }
                const formatted = JSON.stringify(parsed, null, 2);
                schemaTextarea.value = hasScriptTag
                    ? '<script type="application/ld+json">\n' + formatted + '\n<\/script>'
                    : formatted;
                showSyncIndicator();
            } else {
                let updated = raw;
                if (ratingVal !== '') {
                    updated = updated.replace(/("ratingValue"\s*:\s*)("[^"]*"|[0-9.]+)/gi, '$1' + JSON.stringify(ratingVal));
                }
                if (reviewVal !== '') {
                    updated = updated.replace(/("reviewCount"\s*:\s*)("[^"]*"|[0-9]+)/gi, '$1' + JSON.stringify(reviewVal));
                }
                if (priceVal !== '') {
                    if (/priceRange/i.test(updated)) {
                        updated = updated.replace(/("priceRange"\s*:\s*)("[^"]*")/gi, '$1' + JSON.stringify(priceRangeVal));
                    }
                    if (/("price"\s*:)/i.test(updated)) {
                        updated = updated.replace(/("price"\s*:\s*)("[^"]*"|[0-9.]+)/gi, '$1' + JSON.stringify(cleanPrice));
                    }
                }
                schemaTextarea.value = updated;
                showSyncIndicator();
            }
        }

        function syncSchemaToInputs() {
            const raw = schemaTextarea.value.trim();
            if (!raw) return;

            let jsonText = raw;
            const scriptMatch = raw.match(/^<script\b[^>]*>([\s\S]*?)<\/script>$/i);
            if (scriptMatch) {
                jsonText = scriptMatch[1].trim();
            }

            try {
                const parsed = JSON.parse(jsonText);
                if (ratingInput && !ratingInput.value) {
                    const r = findFieldRecursive(parsed, 'ratingValue');
                    if (r !== null) ratingInput.value = r;
                }
                if (reviewInput && !reviewInput.value) {
                    const rc = findFieldRecursive(parsed, 'reviewCount');
                    if (rc !== null) reviewInput.value = rc;
                }
                if (priceInput && !priceInput.value) {
                    const p = findFieldRecursive(parsed, 'priceRange') ?? findFieldRecursive(parsed, 'price');
                    if (p !== null) {
                        const strP = String(p).trim();
                        priceInput.value = (/^\$[0-9]/.test(strP)) ? strP.substring(1) : strP;
                    }
                }
            } catch (err) {
                if (ratingInput && !ratingInput.value) {
                    const m = raw.match(/"ratingValue"\s*:\s*("([^"]*)"|([0-9.]+))/i);
                    if (m) ratingInput.value = m[2] || m[3];
                }
                if (reviewInput && !reviewInput.value) {
                    const m = raw.match(/"reviewCount"\s*:\s*("([^"]*)"|([0-9]+))/i);
                    if (m) reviewInput.value = m[2] || m[3];
                }
                if (priceInput && !priceInput.value) {
                    const m = raw.match(/"priceRange"\s*:\s*"([^"]*)"/i) || raw.match(/"price"\s*:\s*("([^"]*)"|([0-9.]+))/i);
                    if (m) {
                        const strP = (m[1] || m[2] || m[3] || '').trim();
                        priceInput.value = (/^\$[0-9]/.test(strP)) ? strP.substring(1) : strP;
                    }
                }
            }
        }

        [ratingInput, reviewInput, priceInput].forEach(inp => {
            if (inp) {
                inp.addEventListener('input', syncInputsToSchema);
                inp.addEventListener('change', syncInputsToSchema);
            }
        });

        schemaTextarea.addEventListener('input', syncSchemaToInputs);
        schemaTextarea.addEventListener('paste', () => setTimeout(syncSchemaToInputs, 100));

        syncSchemaToInputs();
    })();

</script>

@endsection
