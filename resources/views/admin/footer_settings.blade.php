@extends('admin.layout')

@section('title', 'Footer & Company Settings - Admin')
@section('heading', 'Footer & Company Settings')

@section('content')

<style>
    .custom-multiselect-container {
        position: relative;
        width: 100%;
        z-index: 50;
    }
    .multiselect-trigger {
        min-height: 3rem;
        padding: 0.5rem 0.875rem;
        background: #ffffff;
        border: 1px solid #ddd8df;
        border-radius: 0.5rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
        cursor: pointer;
        transition: border-color 0.2s ease, box-shadow 0.2s ease;
    }
    .multiselect-trigger:hover, .custom-multiselect-container.open .multiselect-trigger {
        border-color: #FFB400;
        box-shadow: 0 0 0 3px rgba(255,180,0,0.16);
    }
    .selected-tags {
        display: flex;
        flex-wrap: wrap;
        gap: 0.375rem;
        align-items: center;
        flex: 1;
        margin-right: 0.625rem;
    }
    .tag-chip {
        background: #fbfafb;
        color: #0B2240;
        font-size: 12px;
        font-weight: 700;
        padding: 0.25rem 0.625rem;
        border-radius: 0.375rem;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        border: 1px solid #f2d78e;
    }
    .tag-chip i {
        cursor: pointer;
        font-size: 0.6875rem;
    }
    .dropdown-placeholder {
        color: #888;
        font-size: 0.8125rem;
        font-weight: 500;
    }
    .multiselect-dropdown {
        display: none;
        position: absolute;
        top: calc(100% + 0.375rem);
        left: 0;
        right: 0;
        background: #ffffff;
        border: 1px solid #ddd8df;
        border-radius: 0.5rem;
        box-shadow: 0 0.75rem 2.1875rem rgba(0,0,0,0.18);
        z-index: 9999;
        padding: 0.75rem;
    }
    .custom-multiselect-container.open .multiselect-dropdown {
        display: block;
    }
    .dropdown-search {
        position: relative;
        margin-bottom: 0.5rem;
    }
    .dropdown-search input {
        width: 100%;
        padding: 0.5625rem 0.75rem 0.5625rem 2.125rem;
        font-size: 0.8125rem;
        border-radius: 0.375rem;
        border: 1px solid #ddd8df;
        background: #fbfafb;
    }
    .dropdown-search i.search-icon {
        position: absolute;
        left: 0.6875rem;
        top: 50%;
        transform: translateY(-50%);
        color: #888;
        font-size: 0.75rem;
    }
    .dropdown-actions {
        display: flex;
        justify-content: space-between;
        padding: 0.25rem 0.375rem 0.5rem;
        font-size: 0.6875rem;
        font-weight: 700;
        border-bottom: 1px solid #ddd8df;
        margin-bottom: 0.375rem;
    }
    .dropdown-actions span {
        color: #0B2240;
        cursor: pointer;
    }
    .dropdown-actions span:hover {
        text-decoration: underline;
    }
    .dropdown-options-list {
        max-height: 13.75rem;
        overflow-y: auto;
        display: flex;
        flex-direction: column;
        gap: 0.25rem;
    }
    .dropdown-option-item {
        display: flex;
        align-items: center;
        gap: 0.625rem;
        padding: 0.5rem 0.625rem;
        border-radius: 0.375rem;
        cursor: pointer;
        transition: background 0.15s ease;
        font-size: 0.8125rem;
        font-weight: 600;
        color: #333;
    }
    .dropdown-option-item:hover {
        background: #fbfafb;
    }
    .dropdown-option-item input[type="checkbox"] {
        width: 16px;
        height: 16px;
        accent-color: #FFB400;
        cursor: pointer;
    }
</style>

<div class="card" style="max-width: 56.25rem;">
    <div class="card-header">
        <h2 class="card-title">Manage Global Settings</h2>
    </div>
    
    @if(session('success'))
        <div style="padding:0.9375rem; background:#d4edda; color:#155724; border-radius:0.375rem; margin-bottom:1.25rem;">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('admin.footer.update') }}" method="POST">
        @csrf
        
        <div style="margin-bottom:1.875rem;">
            <h3 style="font-size:1.125rem; margin-bottom:0.9375rem; padding-bottom:0.5rem; border-bottom:1px solid #eaeaea;">Company Information</h3>
            <p style="font-size:0.8125rem; color:#666; margin-bottom:0.9375rem;">These details will automatically update across the Header, Footer, and Contact pages.</p>
            
            <div class="form-group">
                <label class="form-label">Company Email</label>
                <input type="email" name="company_email" class="form-input" value="{{ old('company_email', $settings['company_email'] ?? '') }}">
            </div>
            
            <div class="form-group">
                <label class="form-label">Company Phone Number</label>
                <input type="text" name="company_phone" class="form-input" value="{{ old('company_phone', $settings['company_phone'] ?? '') }}">
            </div>
            
            <div class="form-group">
                <label class="form-label">Company Address</label>
                <textarea name="company_address" class="form-input" rows="3">{{ old('company_address', $settings['company_address'] ?? '') }}</textarea>
                <small style="color:#666; font-size:0.75rem;">You can use &lt;br&gt; to add line breaks.</small>
            </div>
        </div>

        <div style="margin-bottom:1.875rem;">
            <h3 style="font-size:1.125rem; margin-bottom:0.9375rem; padding-bottom:0.5rem; border-bottom:1px solid #eaeaea;">1. Social Media Links</h3>
            
            <div class="form-group">
                <label class="form-label">Facebook URL</label>
                <input type="url" name="social_facebook" class="form-input" value="{{ old('social_facebook', $settings['social_facebook'] ?? '') }}">
            </div>
            
            <div class="form-group">
                <label class="form-label">Twitter URL</label>
                <input type="url" name="social_twitter" class="form-input" value="{{ old('social_twitter', $settings['social_twitter'] ?? '') }}">
            </div>
            
            <div class="form-group">
                <label class="form-label">Instagram URL</label>
                <input type="url" name="social_instagram" class="form-input" value="{{ old('social_instagram', $settings['social_instagram'] ?? '') }}">
            </div>
            
            <div class="form-group">
                <label class="form-label">Pinterest URL</label>
                <input type="url" name="social_pinterest" class="form-input" value="{{ old('social_pinterest', $settings['social_pinterest'] ?? '') }}">
            </div>
            
            <div class="form-group">
                <label class="form-label">LinkedIn URL</label>
                <input type="url" name="social_linkedin" class="form-input" value="{{ old('social_linkedin', $settings['social_linkedin'] ?? '') }}">
            </div>
            
            <div class="form-group">
                <label class="form-label">YouTube URL</label>
                <input type="url" name="social_youtube" class="form-input" value="{{ old('social_youtube', $settings['social_youtube'] ?? '') }}">
            </div>
        </div>

        <div style="margin-bottom:1.875rem;">
            <h3 style="font-size:1.125rem; margin-bottom:0.9375rem; padding-bottom:0.5rem; border-bottom:1px solid #eaeaea;">Footer Settings</h3>

            <div class="form-group">
                <label class="form-label">Footer Description</label>
                <textarea name="footer_description" class="form-input" rows="5" maxlength="2000">{{ old('footer_description', $settings['footer_description'] ?? '') }}</textarea>
                <small style="color:#666; font-size:0.75rem;">This text appears below the footer logo.</small>
            </div>

            <div class="form-group" style="position:relative; z-index:100;">
                <label class="form-label">Footer Products</label>
                @php $selectedProducts = array_map('intval', (array) ($settings['footer_products'] ?? [])); @endphp
                <div class="custom-multiselect-container" id="productMultiselect">
                    <div class="multiselect-trigger" onclick="toggleDropdown('productMultiselect')">
                        <div class="selected-tags" id="productSelectedTags" data-placeholder="Click to select products..."></div>
                        <i class="fa-solid fa-chevron-down" style="font-size:0.75rem; color:#888;"></i>
                    </div>
                    <div class="multiselect-dropdown">
                        <div class="dropdown-search">
                            <i class="fa-solid fa-magnifying-glass search-icon"></i>
                            <input type="text" placeholder="Search products..." onkeyup="filterOptions(this, 'productOptionsList')">
                        </div>
                        <div class="dropdown-actions">
                            <span style="color:#666; font-size:0.75rem;">Select products</span>
                            <span onclick="clearAllOptions('productMultiselect')" style="cursor:pointer; color:#d9534f; font-size:0.75rem;">Clear All</span>
                        </div>
                        <div class="dropdown-options-list" id="productOptionsList">
                            @forelse($products as $product)
                                <label class="dropdown-option-item">
                                    <input type="checkbox" name="footer_products[]" value="{{ $product['id'] }}" data-title="{{ $product['title'] }}" {{ in_array((int) $product['id'], $selectedProducts) ? 'checked' : '' }} onchange="updateMultiselectDisplay('productMultiselect')">
                                    <span>{{ $product['title'] }}</span>
                                </label>
                            @empty
                                <p style="color:#888; padding:0.5rem; font-size:0.75rem;">No products available. Add and publish products first.</p>
                            @endforelse
                        </div>
                    </div>
                </div>
                <small style="margin-top:0.375rem; display:block; color:#777;">Selected products will appear in the footer Products column.</small>
            </div>
            
            <div class="form-group">
                <label class="form-label">Footer Categories</label>
                @php $selectedCats = (array) ($settings['footer_categories'] ?? []); @endphp
                <div class="custom-multiselect-container" id="categoryMultiselect">
                    <div class="multiselect-trigger" onclick="toggleDropdown('categoryMultiselect')">
                        <div class="selected-tags" id="categorySelectedTags" data-placeholder="Click to select categories..."></div>
                        <i class="fa-solid fa-chevron-down" style="font-size: 0.75rem; color: #888;"></i>
                    </div>

                    <div class="multiselect-dropdown">
                        <div class="dropdown-search">
                            <i class="fa-solid fa-magnifying-glass search-icon"></i>
                            <input type="text" placeholder="Search categories..." onkeyup="filterOptions(this, 'categoryOptionsList')">
                        </div>
                        <div class="dropdown-actions">
                            <span style="color:#666; font-size:0.75rem;">Select categories</span>
                            <span onclick="clearAllOptions('categoryMultiselect')" style="cursor:pointer; color:#d9534f; font-size:0.75rem;">Clear All</span>
                        </div>
                        <div class="dropdown-options-list" id="categoryOptionsList">
                            @forelse($categories as $category)
                                <label class="dropdown-option-item">
                                    <input type="checkbox" name="footer_categories[]" value="{{ $category['id'] }}" data-title="{{ $category['title'] ?? $category['name'] ?? '' }}" {{ in_array($category['id'], $selectedCats) ? 'checked' : '' }} onchange="updateMultiselectDisplay('categoryMultiselect')">
                                    <span>{{ $category['title'] ?? $category['name'] ?? '' }}</span>
                                </label>
                            @empty
                                <p style="color: #888; padding: 0.5rem; font-size: 0.75rem;">No categories available.</p>
                            @endforelse
                        </div>
                    </div>
                </div>
                <small style="margin-top:0.375rem; display:block; color:#777;">Selected categories will appear in the footer Categories column.</small>
            </div>
            
            <div class="form-group">
                <label class="form-label">Footer Quick Links</label>
                <div id="quick-links-container">
                    @php $quickLinks = (array) ($settings['footer_quick_links'] ?? []); @endphp
                    
                    @if(empty($quickLinks))
                        <div class="quick-link-row" style="display:flex; gap:0.625rem; margin-bottom:0.625rem;">
                            <input type="text" name="footer_quick_links_names[]" class="form-input" placeholder="Link Name (e.g. About Us)">
                            <input type="text" name="footer_quick_links_urls[]" class="form-input" placeholder="URL (e.g. /about-us)">
                            <button type="button" class="btn btn-danger remove-link-btn" style="padding:0 0.9375rem;">&times;</button>
                        </div>
                    @else
                        @foreach($quickLinks as $link)
                        <div class="quick-link-row" style="display:flex; gap:0.625rem; margin-bottom:0.625rem;">
                            <input type="text" name="footer_quick_links_names[]" class="form-input" value="{{ $link['name'] ?? '' }}" placeholder="Link Name (e.g. About Us)">
                            <input type="text" name="footer_quick_links_urls[]" class="form-input" value="{{ $link['url'] ?? '' }}" placeholder="URL (e.g. /about-us)">
                            <button type="button" class="btn btn-danger remove-link-btn" style="padding:0 0.9375rem;">&times;</button>
                        </div>
                        @endforeach
                    @endif
                </div>
                
                <button type="button" id="add-quick-link-btn" class="btn" style="background:#f0f0f0; color:#333; margin-top:0.625rem;">
                    + Add Quick Link
                </button>
            </div>
        </div>

        <div style="margin-top: 1.875rem;">
            <button type="submit" class="btn btn-primary" style="padding: 0.625rem 1.5rem; font-size: 1rem;">Save Settings</button>
        </div>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const container = document.getElementById('quick-links-container');
        const addBtn = document.getElementById('add-quick-link-btn');

        if(addBtn) {
            addBtn.addEventListener('click', function() {
                const row = document.createElement('div');
                row.className = 'quick-link-row';
                row.style = 'display:flex; gap:0.625rem; margin-bottom:0.625rem;';
                row.innerHTML = `
                    <input type="text" name="footer_quick_links_names[]" class="form-input" placeholder="Link Name (e.g. About Us)">
                    <input type="text" name="footer_quick_links_urls[]" class="form-input" placeholder="URL (e.g. /about-us)">
                    <button type="button" class="btn btn-danger remove-link-btn" style="padding:0 0.9375rem;">&times;</button>
                `;
                container.appendChild(row);
            });
            
            container.addEventListener('click', function(e) {
                if (e.target.classList.contains('remove-link-btn')) {
                    const row = e.target.closest('.quick-link-row');
                    if (container.querySelectorAll('.quick-link-row').length > 1) {
                        row.remove();
                    } else {
                        // Just clear the inputs if it's the last row
                        row.querySelectorAll('input').forEach(input => input.value = '');
                    }
                }
            });
        }

        // Initialize multiselect
        updateMultiselectDisplay('categoryMultiselect');
        updateMultiselectDisplay('productMultiselect');
    });

    function toggleDropdown(containerId) {
        const container = document.getElementById(containerId);
        container.classList.toggle('open');
    }

    document.addEventListener('click', function(e) {
        if (!e.target.closest('.custom-multiselect-container')) {
            document.querySelectorAll('.custom-multiselect-container').forEach(c => c.classList.remove('open'));
        }
    });

    function updateMultiselectDisplay(containerId) {
        const container = document.getElementById(containerId);
        const tagsBox = container.querySelector('.selected-tags');
        const activeInputs = container.querySelectorAll('.dropdown-options-list input[type="checkbox"]:checked');
        tagsBox.innerHTML = '';
        if (activeInputs.length === 0) {
            tagsBox.innerHTML = '<span class="dropdown-placeholder">' + (tagsBox.dataset.placeholder || 'Click to select...') + '</span>';
        } else {
            activeInputs.forEach(cb => {
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
        if (cb) {
            cb.checked = false;
            updateMultiselectDisplay(containerId);
        }
    }

    function filterOptions(searchInput, listId) {
        const filter = searchInput.value.toLowerCase();
        const list = document.getElementById(listId);
        const items = list.querySelectorAll('.dropdown-option-item');
        items.forEach(item => {
            const text = item.textContent.toLowerCase();
            item.style.display = text.includes(filter) ? 'flex' : 'none';
        });
    }

    function clearAllOptions(containerId) {
        const container = document.getElementById(containerId);
        const cbs = container.querySelectorAll('.dropdown-options-list input[type="checkbox"]');
        cbs.forEach(cb => {
            cb.checked = false;
        });
        updateMultiselectDisplay(containerId);
    }
</script>
@endsection
