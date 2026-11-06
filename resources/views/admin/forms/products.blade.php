@extends('admin.layout')
@section('title', ($item ? 'Edit ' : 'Add ') . $meta['singular'])
@section('heading', ($item ? 'Edit ' : 'Add ') . $meta['singular'])
@section('content')

<script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/6.8.2/tinymce.min.js"></script>

@php
    $v = fn($key, $default = '') => old($key, $item[$key] ?? $default);
    $editing = (bool)$item;
    $resolveImg = fn($path) => empty($path) ? '' : (\Illuminate\Support\Str::startsWith($path, ['storage/', 'uploads/', 'images/']) ? asset($path) : asset('storage/' . $path));
    $selectedCats = (array) old('categories', json_decode($item['categories'] ?? '[]', true) ?? []);
    $selectedRelated = (array) old('related', json_decode($item['related'] ?? '[]', true) ?? []);
    $productFaqs = $productFaqs ?? [];
    // Also check pivot table if no categories stored on product itself
@endphp

<style>
    .custom-multiselect-container { position: relative; width: 100%; z-index: 50; }
    .multiselect-trigger {
        min-height: 3rem; padding: 0.5rem 0.875rem; background: #ffffff;
        border: 0.0938rem solid #ddd8df; border-radius: 0.625rem;
        display: flex; align-items: center; justify-content: space-between;
        cursor: pointer; transition: border-color 0.2s ease, box-shadow 0.2s ease;
    }
    .multiselect-trigger:hover, .custom-multiselect-container.open .multiselect-trigger {
        border-color: var(--primary); box-shadow: 0 0 0 3px rgba(255,180,0,0.16);
    }
    .selected-tags { display: flex; flex-wrap: wrap; gap: 0.375rem; align-items: center; flex: 1; margin-right: 0.625rem; }
    .tag-chip {
        background: var(--soft); color: var(--primary); font-size: 12px;
        font-weight: 700; padding: 4px 10px; border-radius: 6px;
        display: inline-flex; align-items: center; gap: 6px; border: 1px solid #f2d78e;
    }
    .tag-chip i { cursor: pointer; font-size: 0.6875rem; }
    .tag-chip i:hover { color: var(--primary-dark); }
    .dropdown-placeholder { color: var(--muted); font-size: 0.8125rem; font-weight: 500; }
    .multiselect-dropdown {
        display: none; position: absolute; top: calc(100% + 0.375rem); left: 0; right: 0;
        background: #ffffff; border: 0.0938rem solid #ddd8df; border-radius: 0.75rem;
        box-shadow: 0 0.75rem 2.1875rem rgba(0,0,0,0.18); z-index: 9999; padding: 0.75rem;
    }
    .custom-multiselect-container.open .multiselect-dropdown { display: block; }
    .dropdown-search { position: relative; margin-bottom: 0.5rem; }
    .dropdown-search input {
        width: 100%; padding: 0.5625rem 0.75rem 0.5625rem 2.125rem; font-size: 0.8125rem;
        border-radius: 0.5rem; border: 1px solid var(--line); background: #fbfafb;
    }
    .dropdown-search i.search-icon { position: absolute; left: 0.6875rem; top: 50%; transform: translateY(-50%); color: var(--muted); font-size: 0.75rem; }
    .dropdown-actions {
        display: flex; justify-content: space-between; padding: 0.25rem 0.375rem 0.5rem;
        font-size: 0.6875rem; font-weight: 700; border-bottom: 1px solid var(--line); margin-bottom: 0.375rem;
    }
    .dropdown-actions span { color: var(--primary); cursor: pointer; }
    .dropdown-actions span:hover { text-decoration: underline; }
    .dropdown-options-list { max-height: 13.75rem; overflow-y: auto; display: flex; flex-direction: column; gap: 0.25rem; }
    .dropdown-option-item {
        display: flex; align-items: center; gap: 0.625rem; padding: 0.5rem 0.625rem;
        border-radius: 0.375rem; cursor: pointer; transition: background 0.15s ease;
        font-size: 0.8125rem; font-weight: 600; color: var(--text);
    }
    .dropdown-option-item:hover { background: var(--soft); }
    .dropdown-option-item input[type="checkbox"] { width: 1rem; height: 1rem; accent-color: var(--primary); cursor: pointer; }
</style>

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
                    <div class="single-image-wrapper" style="margin-bottom:0.5rem; position:relative; display:inline-block;">
                        <img src="{{ $resolveImg($item['image']) }}" style="height:3.75rem; border-radius:0.25rem; border:1px solid #ddd; display:block;">
                        <span onclick="removeSingleImage(this, 'image')" style="position:absolute; top:-0.375rem; right:-0.375rem; background:#e74c3c; color:white; border-radius:50%; width:1.125rem; height:1.125rem; display:flex; align-items:center; justify-content:center; font-size:0.875rem; font-weight:bold; cursor:pointer; box-shadow:0 1px 0.1875rem rgba(0,0,0,0.3); line-height:1;" title="Remove Image">&times;</span>
                    </div>
                @endif
                <input type="file" name="image" accept="image/*">
            </div>
            <div class="field">
                <label>Popular Product Icon</label>
                @if($editing && !empty($item['nav_image']))
                    <div class="single-image-wrapper" style="margin-bottom:0.5rem; position:relative; display:inline-block;">
                        <img src="{{ $resolveImg($item['nav_image']) }}" style="height:3.75rem; border-radius:0.25rem; border:1px solid #ddd; display:block;">
                        <span onclick="removeSingleImage(this, 'nav_image')" style="position:absolute; top:-0.375rem; right:-0.375rem; background:#e74c3c; color:white; border-radius:50%; width:1.125rem; height:1.125rem; display:flex; align-items:center; justify-content:center; font-size:0.875rem; font-weight:bold; cursor:pointer; box-shadow:0 1px 0.1875rem rgba(0,0,0,0.3); line-height:1;" title="Remove Image">&times;</span>
                    </div>
                @endif
                <input type="file" name="nav_image" accept="image/*">
                <small>Popular Product dropdown mein product name ke saath ye icon show hoga. Khali chhorne par Featured Image use hogi.</small>
            </div>
        </div>
    </div>

    <div class="section" style="overflow:visible; position:relative; z-index:30;">
        <h3>Product Organization</h3>
        <div class="form-grid" style="overflow:visible;">

            {{-- Categories Multiselect --}}
            <div class="field full" style="overflow:visible; position:relative; z-index:30;">
                <label>Categories (multiple allowed)</label>
                @php
                    $editingCatIds = [];
                    if ($editing && !empty($item['id'])) {
                        $editingCatIds = \Illuminate\Support\Facades\DB::table('admin_category_product')
                            ->where('product_id', $item['id'])->pluck('category_id')->toArray();
                    }
                @endphp
                <div class="custom-multiselect-container" id="categoryMultiselect">
                    <div class="multiselect-trigger" onclick="toggleDropdown('categoryMultiselect')">
                        <div class="selected-tags" id="categorySelectedTags"></div>
                        <i class="fa-solid fa-chevron-down" style="font-size:0.75rem; color:var(--muted);"></i>
                    </div>
                    <div class="multiselect-dropdown">
                        <div class="dropdown-search">
                            <i class="fa-solid fa-magnifying-glass search-icon"></i>
                            <input type="text" placeholder="Search categories..." onkeyup="filterOptions(this, 'categoryOptionsList')">
                        </div>
                        <div class="dropdown-actions">
                            <span onclick="selectAllOptions('categoryMultiselect', true)">Select All</span>
                            <span onclick="selectAllOptions('categoryMultiselect', false)">Clear All</span>
                        </div>
                        <div class="dropdown-options-list" id="categoryOptionsList">
                            @foreach($categories as $cat)
                                <label class="dropdown-option-item">
                                    <input type="checkbox" name="categories[]" value="{{ $cat['id'] }}"
                                        data-title="{{ $cat['title'] }}"
                                        {{ in_array($cat['id'], $editingCatIds) ? 'checked' : '' }}
                                        onchange="updateMultiselectDisplay('categoryMultiselect')">
                                    <span>{{ $cat['title'] }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                </div>
                <small style="margin-top:0.375rem; display:block;">First selected category becomes the primary category.</small>
            </div>

            {{-- Related Products Multiselect --}}
            <div class="field full" style="overflow:visible; position:relative; z-index:20;">
                <label>Related Products</label>
                @php
                    $editingRelatedIds = [];
                    if ($editing && !empty($item['related'])) {
                        $rel = is_string($item['related']) ? json_decode($item['related'], true) : $item['related'];
                        $editingRelatedIds = (array) ($rel ?? []);
                    }
                @endphp
                <div class="custom-multiselect-container" id="productMultiselect">
                    <div class="multiselect-trigger" onclick="toggleDropdown('productMultiselect')">
                        <div class="selected-tags" id="productSelectedTags"></div>
                        <i class="fa-solid fa-chevron-down" style="font-size:0.75rem; color:var(--muted);"></i>
                    </div>
                    <div class="multiselect-dropdown">
                        <div class="dropdown-search">
                            <i class="fa-solid fa-magnifying-glass search-icon"></i>
                            <input type="text" placeholder="Search products..." onkeyup="filterOptions(this, 'productOptionsList')">
                        </div>
                        <div class="dropdown-actions">
                            <span onclick="selectAllOptions('productMultiselect', true)">Select All</span>
                            <span onclick="selectAllOptions('productMultiselect', false)">Clear All</span>
                        </div>
                        <div class="dropdown-options-list" id="productOptionsList">
                            @foreach($products as $prod)
                                @if(!$editing || empty($item['id']) || $prod['id'] != ($item['id'] ?? null))
                                <label class="dropdown-option-item">
                                    <input type="checkbox" name="related[]" value="{{ $prod['id'] }}"
                                        data-title="{{ $prod['title'] }}"
                                        {{ in_array($prod['id'], $editingRelatedIds) ? 'checked' : '' }}
                                        onchange="updateMultiselectDisplay('productMultiselect')">
                                    <span>{{ $prod['title'] }}</span>
                                </label>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <div class="section">
        <h3>Product Content & Media</h3>
        <div class="form-grid">
            <div class="field full">
                <label>Short Description</label>
                <textarea name="description">{{ $v('description') }}</textarea>
            </div>
            <div class="field full">
                <label>Long Description</label>
                <textarea name="long_description" style="min-height:13.75rem">{{ $v('long_description') }}</textarea>
            </div>
            <div class="field">
                <label>Image Alt Text</label>
                <input name="alt_text" value="{{ $v('alt_text') }}">
            </div>
            <div class="field">
                <label>Product Gallery</label>
                @if($editing && !empty($item['images']))
                    @php $imgs = is_string($item['images']) ? json_decode($item['images'], true) : $item['images']; @endphp
                    @if(is_array($imgs))
                        <div style="display:flex; gap:0.5rem; margin-bottom:0.5rem; flex-wrap:wrap">
                            @foreach($imgs as $img)
                                <div class="gallery-image-wrapper" style="position:relative; display:inline-block;">
                                    <img src="{{ $resolveImg($img) }}" style="height:3.75rem; border-radius:0.25rem; border:1px solid #ddd; display:block;">
                                    <span onclick="removeGalleryImage(this, '{{ addslashes($img) }}')" style="position:absolute; top:-0.375rem; right:-0.375rem; background:#e74c3c; color:white; border-radius:50%; width:1.125rem; height:1.125rem; display:flex; align-items:center; justify-content:center; font-size:0.875rem; font-weight:bold; cursor:pointer; box-shadow:0 1px 0.1875rem rgba(0,0,0,0.3); line-height:1;" title="Remove Image">&times;</span>
                                </div>
                            @endforeach
                        </div>
                    @endif
                @endif
                <input type="hidden" name="existing_images" value="{{ json_encode($imgs ?? []) }}">
                <input type="file" name="images[]" accept="image/*" multiple>
            </div>
        </div>
    </div>

    <div class="section">
        <h3>Product Specifications</h3>
        <div class="form-grid">
            @foreach(['box_style' => 'Box Style', 'material' => 'Material / Stock', 'printing' => 'Printing Method', 'finishing' => 'Finishing', 'dimensions' => 'Dimensions', 'moq' => 'Minimum Order Quantity', 'turnaround' => 'Turnaround Time'] as $key => $label)
                <div class="field">
                    <label>{{ $label }}</label>
                    <input name="{{ $key }}" value="{{ $v($key) }}">
                </div>
            @endforeach
        </div>
    </div>

    <div class="section">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.9375rem; flex-wrap: wrap; gap: 0.5rem;">
            <div>
                <h3 style="margin-bottom: 0.25rem;">Product FAQs (10+ FAQs Supported)</h3>
                <small style="color: var(--muted); font-size: 0.8125rem;">Add up to 10 or more frequently asked questions for this product. All saved FAQs will be displayed on the product page. If all FAQs are removed, the FAQ section will not be shown on the product page.</small>
            </div>
            <div style="display: flex; gap: 0.5rem; flex-wrap: wrap;">
                <button type="button" onclick="addFaqRow()" class="btn light" style="padding: 0.375rem 0.75rem; font-size: 0.8125rem; white-space: nowrap;"><i class="fa-solid fa-plus"></i> Add FAQ</button>
                <button type="button" onclick="addTenFaqs()" class="btn light" style="padding: 0.375rem 0.75rem; font-size: 0.8125rem; white-space: nowrap;"><i class="fa-solid fa-layer-group"></i> Add 10 FAQ Rows</button>
            </div>
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
                } elseif (!empty($productFaqs)) {
                    $initialFaqs = $productFaqs;
                }
            @endphp

            <div id="noFaqsMessage" style="grid-column: 1 / -1; color: var(--muted); padding: 0.75rem 0; font-size: 0.875rem; {{ count($initialFaqs) > 0 ? 'display: none;' : '' }}">
                No FAQs added yet for this product. Click "<strong>+ Add FAQ</strong>" above to add one.
            </div>

            @foreach($initialFaqs as $i => $faq)
                <div class="field faq-question-field">
                    <label class="faq-q-label">Question {{ $i + 1 }}</label>
                    <input name="faq_question[]" value="{{ $faq['question'] ?? '' }}" placeholder="Enter question">
                </div>
                <div class="field faq-answer-field">
                    <label class="faq-a-label">Answer {{ $i + 1 }}</label>
                    <div style="display: flex; gap: 0.625rem; align-items: flex-start;">
                        <textarea name="faq_answer[]" style="min-height:4.375rem; flex: 1;" placeholder="Enter answer">{{ $faq['answer'] ?? '' }}</textarea>
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
                @php $productRobots = str_replace(' ', '', (string) ($v('robots', 'index,follow') ?: 'index,follow')); @endphp
                <select name="robots">
                    <option value="index,follow" @selected($productRobots === 'index,follow')>index, follow</option>
                    <option value="index,nofollow" @selected($productRobots === 'index,nofollow')>index, nofollow</option>
                    <option value="noindex,follow" @selected($productRobots === 'noindex,follow')>noindex, follow</option>
                    <option value="noindex,nofollow" @selected($productRobots === 'noindex,nofollow')>noindex, nofollow</option>
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
                            <input type="text" name="review_count" id="schema_review_count" value="{{ $v('review_count') }}" placeholder="54" autocomplete="off" style="border:none; outline:none; flex:1; padding:0.45rem 0.65rem;">
                        </div>
                    </div>
                    <div class="field" style="margin:0;">
                        <label style="font-size:0.85rem; font-weight:600; color:#475569;">Price (USD $)</label>
                        <div style="display:flex; align-items:center; background:#fff; border:1px solid #cbd5e1; border-radius:6px; overflow:hidden;">
                            <span style="padding:0.45rem 0.65rem; background:#f1f5f9; color:#64748b; font-weight:700; font-size:0.9rem; border-right:1px solid #cbd5e1;">$</span>
                            <input type="text" name="price" id="schema_price" value="{{ $v('price') }}" placeholder="0.10" autocomplete="off" style="border:none; outline:none; flex:1; padding:0.45rem 0.65rem;">
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
                <input type="checkbox" name="show_home" value="1" @checked($v('show_home'))>
                Show on home page
            </label>
            <label class="check">
                <input type="checkbox" name="show_as_custom_box" value="1" @checked($v('show_as_custom_box'))>
                Show as Popular Product
            </label>
        </div>
    </div>

    <div class="actions">
        <a class="btn light" href="{{ route('admin.module.index', $module) }}">Cancel</a>
        <button class="btn" type="submit">Save {{ $meta['singular'] }}</button>
    </div>
</form>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        if (typeof tinymce !== 'undefined') {
            tinymce.init({
                ...window.tinyMceUploadConfig,
                selector: 'textarea[name="description"], textarea[name="long_description"]',
                height: 420,
                plugins: 'code advlist autolink lists link image charmap preview anchor searchreplace visualblocks fullscreen insertdatetime media table help wordcount',
                toolbar: 'undo redo | blocks | bold italic underline strikethrough | forecolor backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media table | code fullscreen preview',
                block_formats: 'Paragraph=p; Heading 1=h1; Heading 2=h2; Heading 3=h3; Heading 4=h4; Heading 5=h5; Heading 6=h6; Preformatted=pre',
                branding: false,
                promotion: false,
                content_style: 'body { font-family:"DM Sans",sans-serif; font-size:0.875rem; line-height:1.6; }'
            });
        }
    });

    document.addEventListener('DOMContentLoaded', function () {
        updateMultiselectDisplay('categoryMultiselect');
        updateMultiselectDisplay('productMultiselect');
    });

    function toggleDropdown(containerId) {
        const container = document.getElementById(containerId);
        const isOpen = container.classList.contains('open');
        document.querySelectorAll('.custom-multiselect-container').forEach(c => c.classList.remove('open'));
        if (!isOpen) container.classList.add('open');
    }

    document.addEventListener('click', function (e) {
        if (!e.target.closest('.custom-multiselect-container')) {
            document.querySelectorAll('.custom-multiselect-container').forEach(c => c.classList.remove('open'));
        }
    });

    function updateMultiselectDisplay(containerId) {
        const container = document.getElementById(containerId);
        const tagsBox = container.querySelector('.selected-tags');
        const checkedInputs = container.querySelectorAll('.dropdown-options-list input[type="checkbox"]:checked');
        tagsBox.innerHTML = '';
        if (checkedInputs.length === 0) {
            tagsBox.innerHTML = '<span class="dropdown-placeholder">Click to select items...</span>';
        } else {
            checkedInputs.forEach(cb => {
                const title = cb.getAttribute('data-title');
                const val = cb.value;
                const chip = document.createElement('span');
                chip.className = 'tag-chip';
                chip.innerHTML = `${title} <i class="fa-solid fa-xmark" onclick="event.stopPropagation(); uncheckOption('${containerId}', '${val}')"></i>`;
                tagsBox.appendChild(chip);
            });
        }
    }

    function uncheckOption(containerId, val) {
        const container = document.getElementById(containerId);
        const cb = container.querySelector(`input[value="${val}"]`);
        if (cb) { cb.checked = false; updateMultiselectDisplay(containerId); }
    }

    function filterOptions(searchInput, listId) {
        const filter = searchInput.value.toLowerCase();
        const list = document.getElementById(listId);
        list.querySelectorAll('.dropdown-option-item').forEach(item => {
            item.style.display = item.textContent.toLowerCase().includes(filter) ? 'flex' : 'none';
        });
    }

    function selectAllOptions(containerId, selectAll) {
        const container = document.getElementById(containerId);
        container.querySelectorAll('.dropdown-options-list input[type="checkbox"]').forEach(cb => {
            if (cb.closest('.dropdown-option-item').style.display !== 'none') cb.checked = selectAll;
        });
        updateMultiselectDisplay(containerId);
    }

    function removeGalleryImage(btn, imgPath) {
        if (!confirm('Are you sure you want to remove this image?')) return;
        const wrapper = btn.closest('.gallery-image-wrapper');
        const input = document.querySelector('input[name="existing_images"]');
        if (input && wrapper) {
            let existing = [];
            try { existing = JSON.parse(input.value); } catch(e) {}
            existing = existing.filter(img => img !== imgPath);
            input.value = JSON.stringify(existing);
            wrapper.remove();
        }
    }

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

    function addTenFaqs() {
        const container = document.getElementById('faqsContainer');
        const currentCount = container.querySelectorAll('.faq-question-field').length;
        const targetCount = currentCount < 10 ? 10 : currentCount + 10;
        const toAdd = targetCount - currentCount;
        for (let i = 0; i < toAdd; i++) {
            addFaqRow();
        }
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

    // --- Schema Real-time Sync Logic ---
    (function initProductSchemaSync() {
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
                    updateFieldRecursive(parsed, 'price', cleanPrice);
                    updateFieldRecursive(parsed, 'priceRange', priceRangeVal);
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
                    if (/("price"\s*:)/i.test(updated)) {
                        updated = updated.replace(/("price"\s*:\s*)("[^"]*"|[0-9.]+)/gi, '$1' + JSON.stringify(cleanPrice));
                    }
                    if (/priceRange/i.test(updated)) {
                        updated = updated.replace(/("priceRange"\s*:\s*)("[^"]*")/gi, '$1' + JSON.stringify(priceRangeVal));
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
                    const p = findFieldRecursive(parsed, 'price') ?? findFieldRecursive(parsed, 'priceRange');
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
                    const m = raw.match(/"price"\s*:\s*("([^"]*)"|([0-9.]+))/i) || raw.match(/"priceRange"\s*:\s*"([^"]*)"/i);
                    if (m) {
                        const strP = (m[2] || m[3] || m[1] || '').trim();
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
