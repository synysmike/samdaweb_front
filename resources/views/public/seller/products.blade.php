@extends('public.seller.layout')

@section('seller-content')
<!-- jQuery and Select2 for location -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<!-- Quill WYSIWYG -->
<link href="https://cdn.jsdelivr.net/npm/quill@1.3.7/dist/quill.snow.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/quill@1.3.7/dist/quill.js"></script>
<style>
    .select2-container--default .select2-selection--single { height: 42px; border: 1px solid #d1d5db; border-radius: 0.5rem; }
    .select2-container--default .select2-selection--single .select2-selection__rendered { line-height: 42px; padding-left: 16px; }
    .select2-container { width: 100% !important; }
    .product-image-slider { position: relative; width: 5rem; height: 5rem; border-radius: 0.5rem; overflow: hidden; background: #f3f4f6; }
    .product-image-slider .slides { position: relative; width: 100%; height: 100%; }
    .product-image-slider .slide { position: absolute; inset: 0; opacity: 0; transition: opacity 0.25s ease; pointer-events: none; }
    .product-image-slider .slide.active { opacity: 1; z-index: 1; pointer-events: auto; }
    .product-image-slider .slide img { width: 100%; height: 100%; object-fit: cover; display: block; }
    .product-image-slider .slider-btn { position: absolute; top: 50%; transform: translateY(-50%); z-index: 2; width: 1.5rem; height: 1.5rem; border: 0; border-radius: 9999px; background: rgba(0,0,0,0.5); color: #fff; cursor: pointer; display: flex; align-items: center; justify-content: center; opacity: 0.7; transition: opacity 0.2s; font-size: 0.75rem; }
    .product-image-slider .slider-btn:hover { opacity: 1; background: rgba(0,0,0,0.7); }
    .product-image-slider .slider-prev { left: 2px; }
    .product-image-slider .slider-next { right: 2px; }
    #productDescriptionEditor { min-height: 120px; }
    .ql-toolbar.ql-snow, .ql-container.ql-snow { border-color: #d1d5db; border-radius: 0.5rem; }
    .ql-toolbar.ql-snow { border-bottom: 0; border-radius: 0.5rem 0.5rem 0 0; }
    .ql-container.ql-snow { border-radius: 0 0 0.5rem 0.5rem; }
    .ql-emoji-btn { padding: 2px 6px; cursor: pointer; font-size: 1.1em; line-height: 1; border: none; background: transparent; }
    .ql-emoji-btn:hover { background: rgba(0,0,0,0.06); border-radius: 2px; }
    .ql-emoji-picker { position: fixed; z-index: 9999; background: #fff; border: 1px solid #d1d5db; border-radius: 0.5rem; box-shadow: 0 4px 12px rgba(0,0,0,0.15); padding: 8px; max-height: 180px; overflow-y: auto; display: grid; grid-template-columns: repeat(8, 1fr); gap: 4px; }
    .ql-emoji-picker span { cursor: pointer; padding: 4px; font-size: 1.25em; border-radius: 4px; display: flex; align-items: center; justify-content: center; }
    .ql-emoji-picker span:hover { background: #f3f4f6; }
</style>

<div class="space-y-6">
    <!-- Header -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
        <div class="bg-gradient-to-r from-blue-600 to-purple-600 px-6 py-8">
            <h1 class="text-3xl font-bold text-white">Products</h1>
            <p class="text-blue-100 mt-2">Manage your products</p>
        </div>

        <!-- Products Section -->
        <div class="p-6">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-semibold text-gray-800">Product List</h2>
                <button id="openProductModalBtn" type="button" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-medium">
                    + Add Product
                </button>
            </div>

            <!-- Products Table -->
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 border border-gray-200 rounded-lg">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Image</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Subcategory</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price Range</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="productsTableBody" class="bg-white divide-y divide-gray-200">
                        <tr>
                            <td colspan="7" class="px-6 py-8 text-center text-gray-500">
                                <div class="flex flex-col items-center">
                                    <svg class="w-12 h-12 text-gray-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                    </svg>
                                    <p>Loading products...</p>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Product Modal -->
<div id="productModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-lg shadow-xl max-w-3xl w-full max-h-[90vh] overflow-y-auto">
        <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
            <h3 id="productModalTitle" class="text-xl font-semibold text-gray-800">Add Product</h3>
            <button onclick="closeProductModal()" class="text-gray-400 hover:text-gray-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        <form id="productForm" class="p-6 space-y-4">
            <input type="hidden" id="productId" name="id" value="">
            <input type="hidden" id="productShopId" name="shop_id" value="{{ isset($shop) ? ($shop['id'] ?? '') : '' }}">
            <input type="hidden" id="productSlug" name="slug" value="">
            <input type="hidden" id="productCreatedAt" name="created_at" value="">
            <input type="hidden" id="productUpdatedAt" name="updated_at" value="">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="productTitle" class="block text-sm font-medium text-gray-700 mb-2">Title <span class="text-red-500">*</span></label>
                    <input type="text" id="productTitle" name="title" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        placeholder="Enter product title">
                </div>
                <div>
                    <label for="productSku" class="block text-sm font-medium text-gray-700 mb-2">SKU</label>
                    <input type="text" id="productSku" name="sku"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        placeholder="e.g. SKU-001">
                </div>
            </div>

            <div>
                <label for="productDescriptionEditor" class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                <input type="hidden" id="productDescription" name="description" value="">
                <div id="productDescriptionEditor" class="bg-white"></div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="productCategoryId" class="block text-sm font-medium text-gray-700 mb-2">Category <span class="text-red-500">*</span></label>
                    <select id="productCategoryId" name="category_id" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">Select a category</option>
                    </select>
                </div>
                <div>
                    <label for="productSubCategoryId" class="block text-sm font-medium text-gray-700 mb-2">Subcategory</label>
                    <select id="productSubCategoryId" name="sub_category_id"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">Select a subcategory</option>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="productMinPrice" class="block text-sm font-medium text-gray-700 mb-2">Min Price <span class="text-red-500">*</span></label>
                    <input type="number" id="productMinPrice" name="min_price" required min="0" step="1"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        placeholder="0">
                </div>
                <div>
                    <label for="productMaxPrice" class="block text-sm font-medium text-gray-700 mb-2">Max Price <span class="text-red-500">*</span></label>
                    <input type="number" id="productMaxPrice" name="max_price" required min="0" step="1"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        placeholder="0">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Is Active</label>
                    <div class="flex items-center space-x-4">
                        <label class="flex items-center">
                            <input type="radio" name="is_active" value="1" checked class="w-4 h-4 text-blue-600 focus:ring-blue-500 border-gray-300">
                            <span class="ml-2 text-sm text-gray-700">Active</span>
                        </label>
                        <label class="flex items-center">
                            <input type="radio" name="is_active" value="0" class="w-4 h-4 text-blue-600 focus:ring-blue-500 border-gray-300">
                            <span class="ml-2 text-sm text-gray-700">Inactive</span>
                        </label>
                    </div>
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Is Visible</label>
                <div class="flex items-center space-x-4">
                    <label class="flex items-center">
                        <input type="radio" name="is_visible" value="1" checked class="w-4 h-4 text-blue-600 focus:ring-blue-500 border-gray-300">
                        <span class="ml-2 text-sm text-gray-700">Visible</span>
                    </label>
                    <label class="flex items-center">
                        <input type="radio" name="is_visible" value="0" class="w-4 h-4 text-blue-600 focus:ring-blue-500 border-gray-300">
                        <span class="ml-2 text-sm text-gray-700">Hidden</span>
                    </label>
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Product Attributes</label>
                <p class="text-xs text-gray-500 mb-2">Select attributes to associate with this product (e.g. Color, Size). Attributes are saved after the product is saved.</p>
                <div id="productAttributesContainer" class="border border-gray-200 rounded-lg p-4 bg-gray-50 max-h-40 overflow-y-auto">
                    <p class="text-sm text-gray-500">Loading attributes...</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label for="productCountryId" class="block text-sm font-medium text-gray-700 mb-2">Country</label>
                    <select id="productCountryId" name="country_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">From shop profile</option>
                    </select>
                    <input type="hidden" id="productCountryName" name="country_name" value="">
                </div>
                <div>
                    <label for="productStateId" class="block text-sm font-medium text-gray-700 mb-2">State</label>
                    <select id="productStateId" name="state_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">From shop profile</option>
                    </select>
                    <input type="hidden" id="productStateName" name="state_name" value="">
                </div>
                <div>
                    <label for="productCityId" class="block text-sm font-medium text-gray-700 mb-2">City</label>
                    <select id="productCityId" name="city_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">From shop profile</option>
                    </select>
                    <input type="hidden" id="productCityName" name="city_name" value="">
                </div>
            </div>

            <div>
                <label for="productImages" class="block text-sm font-medium text-gray-700 mb-2">Product Images</label>
                <div id="existingImagesPreview" class="mb-3 hidden">
                    <p class="text-xs font-medium text-gray-600 mb-2">Current images</p>
                    <div id="existingImagesGrid" class="grid grid-cols-4 gap-4"></div>
                </div>
                <input type="file" id="productImages" name="images[]" multiple accept="image/*"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                <p class="text-xs text-gray-500 mt-1">You can select multiple images. Max file size: 1MB per image.</p>
                <div id="imagePreview" class="mt-4 grid grid-cols-4 gap-4"></div>
            </div>

            <div class="flex justify-end space-x-3 pt-4">
                <button type="button" onclick="closeProductModal()"
                    class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
                    Cancel
                </button>
                <button type="submit"
                    class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-medium">
                    Save
                </button>
            </div>
        </form>
    </div>
</div>

@push('js')
<script>
    let products = [];
    let categories = [];
    let subcategories = [];
    let allAttributes = [];
    let productAttributeSetIds = []; // Currently set attribute ids (when editing)

    const shopId = '{{ isset($shop) ? ($shop["id"] ?? "") : "" }}';
    const API_BASE_URL = ((@json(config('api.base_url'))) || '').replace(/\/$/, '');
    // Product images are served by the API. Build URL: API_BASE_URL + /storage/ + path.
    function imageUrlFromFilePath(filePath) {
        if (!filePath || typeof filePath !== 'string') return null;
        if (filePath.startsWith('http://') || filePath.startsWith('https://')) return filePath;
        let rel = String(filePath).replace(/^\/+/, '');
        for (const p of ['storage/app/public/', 'app/public/', 'storage/']) {
            if (rel.startsWith(p)) { rel = rel.slice(p.length); break; }
        }
        rel = rel.replace(/^\/+/, '');
        if (!rel) return null;
        const path = '/storage/' + rel;
        return API_BASE_URL ? (API_BASE_URL + path) : path;
    }

    @php
        $shopLocationData = isset($shop) ? [
            'country_id' => $shop['country_id'] ?? null,
            'state_id' => $shop['state_id'] ?? null,
            'city_id' => $shop['city_id'] ?? null,
            'country_name' => $shop['country_name'] ?? '',
            'state_name' => $shop['state_name'] ?? '',
            'city_name' => $shop['city_name'] ?? '',
        ] : [];
    @endphp
    const shopLocation = @json($shopLocationData);

    let productDescriptionQuill = null;

    const EMOJI_LIST = ['😀','😃','😄','😁','😅','😂','🤣','😊','😇','🙂','😉','😍','🥰','😘','😋','😜','🤔','🤨','😐','😑','😶','👍','👎','👏','🙌','👋','🤝','✌️','🤞','🤟','❤️','🧡','💛','💚','💙','💜','🖤','⭐','🌟','✨','🔥','💯','✅','❌','⚠️','📦','🛒','💰','🎉','🏷️'];

    document.addEventListener('DOMContentLoaded', async function() {
        productDescriptionQuill = new Quill('#productDescriptionEditor', {
            theme: 'snow',
            placeholder: 'Enter product description',
            modules: {
                toolbar: [
                    ['bold', 'italic', 'underline'],
                    [{ 'list': 'ordered' }, { 'list': 'bullet' }],
                    ['link'],
                    ['clean']
                ]
            }
        });
        const qlToolbar = document.querySelector('.ql-toolbar.ql-snow');
        if (qlToolbar) {
            const emojiGroup = document.createElement('span');
            emojiGroup.className = 'ql-formats';
            const emojiBtn = document.createElement('button');
            emojiBtn.type = 'button';
            emojiBtn.className = 'ql-emoji-btn';
            emojiBtn.innerHTML = '😀';
            emojiBtn.title = 'Insert emoji';
            emojiBtn.setAttribute('aria-label', 'Insert emoji');
            emojiGroup.appendChild(emojiBtn);
            qlToolbar.appendChild(emojiGroup);
            emojiBtn.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                const picker = document.getElementById('quillEmojiPicker');
                if (picker) { picker.remove(); return; }
                const p = document.createElement('div');
                p.id = 'quillEmojiPicker';
                p.className = 'ql-emoji-picker';
                const rect = emojiBtn.getBoundingClientRect();
                p.style.top = (rect.bottom + 4) + 'px';
                p.style.left = rect.left + 'px';
                EMOJI_LIST.forEach(function(emoji) {
                    const s = document.createElement('span');
                    s.textContent = emoji;
                    s.addEventListener('click', function(ev) {
                        ev.stopPropagation();
                        const q = productDescriptionQuill;
                        const range = q.getSelection(true) || { index: q.getLength() };
                        q.insertText(range.index, emoji, 'user');
                        q.setSelection(range.index + emoji.length);
                        p.remove();
                        document.removeEventListener('click', close);
                    });
                    p.appendChild(s);
                });
                document.body.appendChild(p);
                function close() {
                    const picker = document.getElementById('quillEmojiPicker');
                    if (picker) picker.remove();
                    document.removeEventListener('click', close);
                }
                setTimeout(function() { document.addEventListener('click', close); }, 10);
            });
        }
        productDescriptionQuill.on('text-change', function() {
            document.getElementById('productDescription').value = productDescriptionQuill.root.innerHTML;
        });

        await loadCategories();
        await loadAttributes();
        loadProducts();
        applyShopLocationToProductForm();

        const addProductBtn = document.getElementById('openProductModalBtn');
        if (addProductBtn) {
            addProductBtn.addEventListener('click', openProductModal);
        }

        document.getElementById('productTitle').addEventListener('blur', function() {
            const slug = (this.value || '').toLowerCase().replace(/\s+/g, '-').replace(/[^a-z0-9-]/g, '');
            document.getElementById('productSlug').value = slug;
        });
    });

    // Load categories (unified API returns all with parent_id; root = categories, children = subcategories)
    async function loadCategories() {
        try {
            const response = await fetch('{{ route("api.seller.categories") }}', {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'X-Requested-With': 'XMLHttpRequest'
                },
                credentials: 'same-origin'
            });

            const result = await response.json();
            if (result.status === 'success' || result.success) {
                let raw = result.data ?? result.categories ?? [];
                if (typeof raw === 'string') {
                    try { raw = JSON.parse(raw) || []; } catch (_) { raw = []; }
                }
                const arr = Array.isArray(raw) ? raw : [];
                // Split API response: no parent_id → category; has parent_id → subcategory
                const roots = arr.filter(c => {
                    const pid = c.parent_id ?? c.parentId ?? null;
                    return pid == null || pid === '';
                });
                const children = arr.filter(c => {
                    const pid = c.parent_id ?? c.parentId ?? null;
                    return pid != null && String(pid).trim() !== '';
                });
                categories = roots.map(c => ({ id: String(c.id ?? c.categoryId ?? ''), name: c.name ?? '' }));
                subcategories = children.map(s => ({
                    id: String(s.id ?? s.subcategoryId ?? ''),
                    name: s.name ?? '',
                    category_id: String(s.parent_id ?? s.category_id ?? s.categoryId ?? '')
                }));
            }
        } catch (error) {
            console.error('Error loading categories:', error);
        }
    }

    // Load all attributes for product form
    async function loadAttributes() {
        try {
            const response = await fetch('{{ route("api.seller.attributes") }}', {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'X-Requested-With': 'XMLHttpRequest'
                },
                credentials: 'same-origin'
            });
            const result = await response.json();
            if (result.status === 'success' || result.success) {
                let raw = result.data || result.attributes || [];
                if (typeof raw === 'string') {
                    try { raw = JSON.parse(raw) || []; } catch (_) { raw = []; }
                }
                allAttributes = Array.isArray(raw) ? raw.map(a => ({
                    id: String(a.id || a.attributeId || ''),
                    name: a.name || ''
                })) : [];
                renderProductAttributes([]);
            } else {
                document.getElementById('productAttributesContainer').innerHTML = '<p class="text-sm text-gray-500">No attributes available. Create attributes first.</p>';
            }
        } catch (error) {
            console.error('Error loading attributes:', error);
            document.getElementById('productAttributesContainer').innerHTML = '<p class="text-sm text-red-500">Failed to load attributes.</p>';
        }
    }

    function renderProductAttributes(selectedIds) {
        const container = document.getElementById('productAttributesContainer');
        if (allAttributes.length === 0) {
            container.innerHTML = '<p class="text-sm text-gray-500">No attributes available. Create attributes first.</p>';
            return;
        }
        const sel = Array.isArray(selectedIds) ? selectedIds.map(String) : [];
        container.innerHTML = allAttributes.map(a => {
            const checked = sel.indexOf(String(a.id)) >= 0 ? ' checked' : '';
            return `
                <label class="flex items-center gap-2 cursor-pointer py-1">
                    <input type="checkbox" class="product-attr-cb rounded border-gray-300 text-blue-600 focus:ring-blue-500" data-attribute-id="${escapeHtml(a.id)}"${checked}>
                    <span class="text-sm text-gray-700">${escapeHtml(a.name)}</span>
                </label>
            `;
        }).join('');
    }

    function getSelectedAttributeIds() {
        const checkboxes = document.querySelectorAll('.product-attr-cb:checked');
        return Array.from(checkboxes).map(cb => cb.getAttribute('data-attribute-id')).filter(Boolean);
    }

    async function loadProductAttributeSet(productId) {
        try {
            const response = await fetch('{{ route("api.seller.product-attribute-set") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'X-Requested-With': 'XMLHttpRequest'
                },
                credentials: 'same-origin',
                body: JSON.stringify({ product_id: productId })
            });
            const result = await response.json();
            if (result.status === 'success' || result.success) {
                let raw = result.data || result.attributes || [];
                if (typeof raw === 'string') {
                    try { raw = JSON.parse(raw) || []; } catch (_) { raw = []; }
                }
                const arr = Array.isArray(raw) ? raw : [];
                return arr.map(a => {
                    const attr = a.attribute || a;
                    return String(attr.id || attr.product_attribute_id || attr.attributeId || attr.productAttributeId || a.product_attribute_id || a.id || '');
                }).filter(Boolean);
            }
            return [];
        } catch (error) {
            console.warn('Could not load product attribute set:', error);
            return [];
        }
    }

    async function syncProductAttributeSet(productId, selectedIds) {
        const headers = {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'X-Requested-With': 'XMLHttpRequest'
        };
        const toAdd = selectedIds.filter(id => productAttributeSetIds.indexOf(id) < 0);
        const toRemove = productAttributeSetIds.filter(id => selectedIds.indexOf(id) < 0);

        for (const attrId of toAdd) {
            try {
                await fetch('{{ route("api.seller.product-attribute-set.store") }}', {
                    method: 'POST',
                    headers,
                    credentials: 'same-origin',
                    body: JSON.stringify({ product_id: productId, product_attribute_id: attrId })
                });
            } catch (e) {
                console.error('Error adding attribute to product:', e);
            }
        }
        for (const attrId of toRemove) {
            try {
                await fetch('{{ route("api.seller.product-attribute-set.delete") }}', {
                    method: 'POST',
                    headers,
                    credentials: 'same-origin',
                    body: JSON.stringify({ product_id: productId, product_attribute_id: attrId })
                });
            } catch (e) {
                console.error('Error removing attribute from product:', e);
            }
        }
    }

    // Load products
    async function loadProducts() {
        try {
            const response = await fetch('{{ route("api.seller.products") }}', {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'X-Requested-With': 'XMLHttpRequest'
                },
                credentials: 'same-origin'
            });

            const result = await response.json();

            if (response.status === 401) {
                Swal.fire({
                    icon: 'error',
                    title: 'Unauthorized',
                    text: result.message || 'Your session has expired. Please login again.',
                    confirmButtonText: 'Go to Login',
                    allowOutsideClick: false
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = '{{ route("login") }}';
                    }
                });
                return;
            }

            if (result.status === 'success' || result.success) {
                products = result.data || [];
                await loadProductImagesAndMerge();
                renderProducts();
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: result.message || 'Failed to load products'
                });
            }
        } catch (error) {
            console.error('Error loading products:', error);
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'An error occurred while loading products'
            });
        }
    }

    // Fetch product images (POST { product_id }) and merge into products. Response: { success, data: [ { file_path, ... } ] }
    async function fetchProductImages(productId) {
        const res = await fetch('{{ route("api.seller.products.images") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'X-Requested-With': 'XMLHttpRequest'
            },
            credentials: 'same-origin',
            body: JSON.stringify({ product_id: String(productId) })
        });
        const json = await res.json();
        const list = (json.success && json.data) ? json.data : [];
        return list.map(item => imageUrlFromFilePath(item.file_path)).filter(Boolean);
    }

    async function loadProductImagesAndMerge() {
        try {
            const pair = await Promise.all(products.map(async (p) => {
                const urls = await fetchProductImages(p.id);
                return [p, urls];
            }));
            pair.forEach(([p, urls]) => {
                p.images = urls;
                p.image = urls[0] || null;
            });
        } catch (e) {
            console.warn('Could not load product images:', e);
        }
    }

    // Render products table
    function renderProducts() {
        const tbody = document.getElementById('productsTableBody');
        
        if (products.length === 0) {
            tbody.innerHTML = `
                <tr>
                    <td colspan="7" class="px-6 py-8 text-center text-gray-500">
                        <div class="flex flex-col items-center">
                            <svg class="w-12 h-12 text-gray-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            <p>No products found. Click "Add Product" to create one.</p>
                        </div>
                    </td>
                </tr>
            `;
            return;
        }

        tbody.innerHTML = products.map(product => {
            const isActive = product.is_active === true || product.is_active === '1' || product.is_active === 1;
            const productCatId = String(product.category_id ?? product.categoryId ?? '');
            const sub = subcategories.find(s => String(s.id) === productCatId);
            const cat = categories.find(c => String(c.id) === productCatId);
            let categoryName = 'N/A';
            let subcategoryName = '-';
            if (sub) {
                const parentCat = categories.find(c => String(c.id) === String(sub.category_id ?? ''));
                categoryName = parentCat ? parentCat.name : 'N/A';
                subcategoryName = sub.name || '-';
            } else if (cat) {
                categoryName = cat.name || 'N/A';
                subcategoryName = '-';
            }
            const imgs = (product.images && product.images.length) ? product.images : ['/placeholder-image.svg'];
            const displayName = product.title || product.name || 'N/A';
            const slidesHtml = imgs.map((url, i) =>
                `<div class="slide ${i === 0 ? 'active' : ''}" data-index="${i}"><img src="${escapeHtml(url)}" alt="${escapeHtml(displayName)}" onerror="this.src='/placeholder-image.svg'"></div>`
            ).join('');
            const multi = imgs.length > 1;
            const navHtml = multi ? `<button type="button" class="slider-btn slider-prev" onclick="productImageSliderPrev(this)" aria-label="Previous">&lsaquo;</button><button type="button" class="slider-btn slider-next" onclick="productImageSliderNext(this)" aria-label="Next">&rsaquo;</button>` : '';
            return `
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="product-image-slider" data-current="0">
                            <div class="slides">${slidesHtml}</div>
                            ${navHtml}
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="text-sm font-medium text-gray-900">${escapeHtml(displayName)}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-500">${escapeHtml(categoryName)}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-500">${escapeHtml(subcategoryName)}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-medium text-gray-900">$${parseFloat(((product.min_price != null ? product.min_price : product.price) || 0)).toFixed(2)} - $${parseFloat(((product.max_price != null ? product.max_price : product.price) || 0)).toFixed(2)}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 py-1 text-xs font-semibold rounded-full ${isActive ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'}">
                            ${isActive ? 'Active' : 'Inactive'}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <button onclick="editProduct('${product.id}')" class="text-blue-600 hover:text-blue-900 mr-3">Edit</button>
                        <button onclick="deleteProduct('${product.id}', '${escapeHtml(displayName)}')" class="text-red-600 hover:text-red-900">Delete</button>
                    </td>
                </tr>
            `;
        }).join('');
    }

    // Open product modal for add (expose globally for onclick)
    window.openProductModal = function openProductModal() {
        document.getElementById('productModalTitle').textContent = 'Add Product';
        document.getElementById('productForm').reset();
        document.getElementById('productId').value = '';
        document.getElementById('productShopId').value = shopId;
        document.getElementById('productSlug').value = '';
        document.getElementById('productCreatedAt').value = '';
        document.getElementById('productUpdatedAt').value = '';
        if (productDescriptionQuill) { productDescriptionQuill.root.innerHTML = ''; document.getElementById('productDescription').value = ''; }
        document.getElementById('imagePreview').innerHTML = '';
        document.getElementById('existingImagesPreview').classList.add('hidden');
        document.getElementById('existingImagesGrid').innerHTML = '';
        document.getElementById('productImages').value = '';
        document.querySelector('input[name="is_active"][value="1"]').checked = true;
        document.querySelector('input[name="is_visible"][value="1"]').checked = true;
        document.getElementById('productMinPrice').value = '0';
        document.getElementById('productMaxPrice').value = '0';
        populateCategoryDropdown();
        applyShopLocationToProductForm();
        productAttributeSetIds = [];
        renderProductAttributes([]);
        document.getElementById('productModal').classList.remove('hidden');
    }

    // Close product modal (expose globally for onclick)
    window.closeProductModal = function closeProductModal() {
        document.getElementById('productModal').classList.add('hidden');
        document.getElementById('productForm').reset();
        document.getElementById('productId').value = '';
        document.getElementById('productShopId').value = shopId;
        document.getElementById('productSlug').value = '';
        document.getElementById('productCreatedAt').value = '';
        document.getElementById('productUpdatedAt').value = '';
        if (productDescriptionQuill) { productDescriptionQuill.root.innerHTML = ''; document.getElementById('productDescription').value = ''; }
        document.getElementById('imagePreview').innerHTML = '';
        document.getElementById('existingImagesPreview').classList.add('hidden');
        document.getElementById('existingImagesGrid').innerHTML = '';
        document.getElementById('productImages').value = '';
    }

    // Populate category dropdown
    function populateCategoryDropdown() {
        const categorySelect = document.getElementById('productCategoryId');
        categorySelect.innerHTML = '<option value="">Select a category</option>';
        categories.forEach(category => {
            const option = document.createElement('option');
            option.value = category.id;
            option.textContent = category.name;
            categorySelect.appendChild(option);
        });
    }

    // Populate subcategory dropdown for a given category
    function populateSubcategoryDropdown(categoryId) {
        const subCategorySelect = document.getElementById('productSubCategoryId');
        subCategorySelect.innerHTML = '<option value="">Select a subcategory</option>';
        if (!categoryId) return;
        const cid = String(categoryId);
        subcategories.filter(sub => String(sub.category_id) === cid).forEach(sub => {
            const option = document.createElement('option');
            option.value = sub.id;
            option.textContent = sub.name;
            subCategorySelect.appendChild(option);
        });
    }

    // Handle category change to load subcategories
    document.getElementById('productCategoryId').addEventListener('change', function() {
        populateSubcategoryDropdown(this.value);
    });

    function applyShopLocationToProductForm() {
        const cSel = document.getElementById('productCountryId');
        const sSel = document.getElementById('productStateId');
        const citySel = document.getElementById('productCityId');
        const cName = document.getElementById('productCountryName');
        const sName = document.getElementById('productStateName');
        const cityName = document.getElementById('productCityName');

        const cId = shopLocation.country_id != null ? String(shopLocation.country_id) : '';
        const sId = shopLocation.state_id != null ? String(shopLocation.state_id) : '';
        const cityId = shopLocation.city_id != null ? String(shopLocation.city_id) : '';
        const cLabel = shopLocation.country_name || 'Shop country';
        const sLabel = shopLocation.state_name || 'Shop state';
        const cityLabel = shopLocation.city_name || 'Shop city';

        cSel.innerHTML = cId ? `<option value="${cId}">${escapeHtml(cLabel)}</option>` : '<option value="">No country in shop profile</option>';
        sSel.innerHTML = sId ? `<option value="${sId}">${escapeHtml(sLabel)}</option>` : '<option value="">No state in shop profile</option>';
        citySel.innerHTML = cityId ? `<option value="${cityId}">${escapeHtml(cityLabel)}</option>` : '<option value="">No city in shop profile</option>';

        cSel.value = cId;
        sSel.value = sId;
        citySel.value = cityId;
        cName.value = cLabel;
        sName.value = sLabel;
        cityName.value = cityLabel;
    }

    // Handle image preview
    document.getElementById('productImages').addEventListener('change', function(e) {
        const preview = document.getElementById('imagePreview');
        preview.innerHTML = '';
        
        Array.from(e.target.files).forEach(file => {
            if (file.size > 1048576) { // 1MB
                Swal.fire({
                    icon: 'error',
                    title: 'File Too Large',
                    text: `${file.name} is larger than 1MB`
                });
                return;
            }
            
            const reader = new FileReader();
            reader.onload = function(e) {
                const div = document.createElement('div');
                div.className = 'relative';
                div.innerHTML = `
                    <img src="${e.target.result}" class="w-full h-24 object-cover rounded-lg">
                    <button type="button" onclick="this.parentElement.remove()" class="absolute top-1 right-1 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center text-xs">×</button>
                `;
                preview.appendChild(div);
            };
            reader.readAsDataURL(file);
        });
    });

    // Edit product
    window.editProduct = async function editProduct(id) {
        const product = products.find(p => p.id === id);
        if (!product) {
            Swal.fire({ icon: 'error', title: 'Error', text: 'Product not found' });
            return;
        }

        document.getElementById('productModalTitle').textContent = 'Edit Product';
        document.getElementById('productId').value = product.id || '';
        document.getElementById('productShopId').value = product.shop_id || shopId;
        document.getElementById('productTitle').value = product.title || product.name || '';
        document.getElementById('productSlug').value = product.slug || '';
        if (productDescriptionQuill) { productDescriptionQuill.root.innerHTML = product.description || ''; document.getElementById('productDescription').value = product.description || ''; }
        document.getElementById('productSku').value = product.sku || '';
        document.getElementById('productMinPrice').value = (product.min_price != null ? product.min_price : (product.price || 0));
        document.getElementById('productMaxPrice').value = (product.max_price != null ? product.max_price : (product.discount_price != null ? product.discount_price : (product.price || 0)));
        document.getElementById('productCreatedAt').value = product.created_at || '';
        document.getElementById('productUpdatedAt').value = product.updated_at || '';
        document.getElementById('productCountryName').value = product.country_name || '';
        document.getElementById('productStateName').value = product.state_name || '';
        document.getElementById('productCityName').value = product.city_name || '';

        populateCategoryDropdown();
        const productCatId = String(product.category_id ?? product.categoryId ?? '');
        const sub = subcategories.find(s => String(s.id) === productCatId);
        const cat = categories.find(c => String(c.id) === productCatId);
        let catId = '';
        let subId = '';
        if (sub) {
            catId = String(sub.category_id ?? '');
            subId = productCatId;
        } else if (cat) {
            catId = productCatId;
            subId = '';
        } else {
            catId = productCatId;
            subId = String(product.sub_category_id ?? product.subCategoryId ?? '');
        }
        document.getElementById('productCategoryId').value = catId;
        populateSubcategoryDropdown(catId);
        document.getElementById('productSubCategoryId').value = subId;

        const isActive = product.is_active === true || product.is_active === '1' || product.is_active === 1;
        document.querySelector(`input[name="is_active"][value="${isActive ? '1' : '0'}"]`).checked = true;
        const isVisible = product.is_visible !== false && product.is_visible !== '0' && product.is_visible !== 0;
        document.querySelector(`input[name="is_visible"][value="${isVisible ? '1' : '0'}"]`).checked = true;

        applyShopLocationToProductForm();

        document.getElementById('imagePreview').innerHTML = '';
        document.getElementById('productImages').value = '';
        const existingEl = document.getElementById('existingImagesPreview');
        const gridEl = document.getElementById('existingImagesGrid');
        gridEl.innerHTML = '';
        try {
            const urls = await fetchProductImages(product.id);
            if (urls.length) {
                urls.forEach(url => {
                    const div = document.createElement('div');
                    div.className = 'relative';
                    div.innerHTML = `<img src="${escapeHtml(url)}" alt="" class="w-full h-24 object-cover rounded-lg">`;
                    gridEl.appendChild(div);
                });
                existingEl.classList.remove('hidden');
            } else {
                existingEl.classList.add('hidden');
            }
        } catch (e) {
            console.warn('Could not load product images for edit:', e);
            existingEl.classList.add('hidden');
        }

        try {
            productAttributeSetIds = await loadProductAttributeSet(product.id);
            renderProductAttributes(productAttributeSetIds);
        } catch (e) {
            productAttributeSetIds = [];
            renderProductAttributes([]);
        }

        document.getElementById('productModal').classList.remove('hidden');
    }

    // Delete product
    window.deleteProduct = async function deleteProduct(id, name) {
        const result = await Swal.fire({
            title: 'Delete Product?',
            text: `Are you sure you want to delete "${name}"? This action cannot be undone.`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel'
        });

        if (result.isConfirmed) {
            try {
                const response = await fetch('{{ route("api.seller.products.delete") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    credentials: 'same-origin',
                    body: JSON.stringify({ id: id })
                });

                const data = await response.json();

                if (response.status === 401) {
                    const errorMsg = data.message || (data.data && data.data.message) || 'Your session has expired. Please login again.';
                    Swal.fire({
                        icon: 'error',
                        title: 'Unauthorized',
                        text: errorMsg,
                        confirmButtonText: 'Go to Login',
                        allowOutsideClick: false
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = '{{ route("login") }}';
                        }
                    });
                    return;
                }

                if (data.success || data.status === 'success' || response.ok) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Deleted!',
                        text: data.message || 'Product deleted successfully',
                        timer: 2000,
                        showConfirmButton: false,
                        toast: true,
                        position: 'top-end'
                    });
                    loadProducts();
                } else {
                    const errorMsg = data.message || (data.data && data.data.message) || 'Failed to delete product.';
                    Swal.fire({
                        icon: 'error',
                        title: 'Delete failed',
                        text: errorMsg,
                        confirmButtonText: 'OK'
                    });
                }
            } catch (error) {
                console.error('Error deleting product:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Could not delete product. Please try again.'
                });
            }
        }
    }

    // Handle product form submission
    document.getElementById('productForm').addEventListener('submit', async function(e) {
        e.preventDefault();

        const titleVal = document.getElementById('productTitle').value.trim();
        let slugVal = document.getElementById('productSlug').value.trim();
        if (!slugVal && titleVal) {
            slugVal = titleVal.toLowerCase().replace(/\s+/g, '-').replace(/[^a-z0-9-]/g, '');
            document.getElementById('productSlug').value = slugVal;
        }

        const countryIdRaw = document.getElementById('productCountryId').value;
        const stateIdRaw = document.getElementById('productStateId').value;
        const cityIdRaw = document.getElementById('productCityId').value;

        if (productDescriptionQuill) document.getElementById('productDescription').value = productDescriptionQuill.root.innerHTML;
        const productIdVal = document.getElementById('productId').value.trim() || null;
        const subCatId = document.getElementById('productSubCategoryId').value.trim();
        const catId = document.getElementById('productCategoryId').value.trim();
        const formData = {
            title: titleVal || '',
            description: (document.getElementById('productDescription').value || '').trim() || '',
            category_id: subCatId || catId || '',
            is_active: document.querySelector('input[name="is_active"]:checked').value === '1',
            is_visible: document.querySelector('input[name="is_visible"]:checked').value === '1',
            country_id: countryIdRaw ? parseInt(countryIdRaw, 10) : 0,
            state_id: stateIdRaw ? parseInt(stateIdRaw, 10) : 0,
            city_id: cityIdRaw ? parseInt(cityIdRaw, 10) : 0,
            min_price: parseInt(document.getElementById('productMinPrice').value.trim() || '0', 10) || 0,
            max_price: parseInt(document.getElementById('productMaxPrice').value.trim() || '0', 10) || 0
        };
        if (productIdVal) formData.id = productIdVal;

        if (!formData.title) {
            Swal.fire({ icon: 'error', title: 'Validation Error', text: 'Product title is required' });
            return;
        }
        if (!formData.category_id) {
            Swal.fire({ icon: 'error', title: 'Validation Error', text: 'Please select a category' });
            return;
        }

        try {
            // First save the product
            const response = await fetch('{{ route("api.seller.products.store") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'X-Requested-With': 'XMLHttpRequest'
                },
                credentials: 'same-origin',
                body: JSON.stringify(formData)
            });

            const data = await response.json();

            if (response.status === 401) {
                Swal.fire({
                    icon: 'error',
                    title: 'Unauthorized',
                    text: data.message || 'Your session has expired. Please login again.',
                    confirmButtonText: 'Go to Login',
                    allowOutsideClick: false
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = '{{ route("login") }}';
                    }
                });
                return;
            }

            if (data.success || data.status === 'success' || response.ok) {
                const productId = (data.data && data.data.id) || formData.id;
                
                // Handle image uploads if any
                const imageInput = document.getElementById('productImages');
                if (imageInput.files.length > 0 && productId) {
                    await uploadProductImages(productId, imageInput.files);
                }

                // Sync product attribute set (save/delete pairings)
                const selectedAttrIds = getSelectedAttributeIds();
                await syncProductAttributeSet(productId, selectedAttrIds);

                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: data.message || (formData.id ? 'Product updated successfully' : 'Product created successfully'),
                    timer: 2000,
                    showConfirmButton: false,
                    toast: true,
                    position: 'top-end'
                });
                closeProductModal();
                loadProducts();
            } else {
                let errorHtml = '';
                const msg = data.message || 'Validation failed';
                if (data.errors && typeof data.errors === 'object') {
                    const list = [];
                    Object.keys(data.errors).forEach(function(field) {
                        const messages = Array.isArray(data.errors[field]) ? data.errors[field] : [data.errors[field]];
                        messages.forEach(function(m) { list.push('<strong>' + field + ':</strong> ' + m); });
                    });
                    if (list.length) {
                        errorHtml = '<div class="text-left"><p class="mb-2">' + msg + '</p><ul class="list-unstyled mb-0">' +
                            list.map(function(l) { return '<li>' + l + '</li>'; }).join('') + '</ul></div>';
                    }
                }
                Swal.fire({
                    icon: 'error',
                    title: 'Validation failed',
                    html: errorHtml || msg,
                    confirmButtonText: 'OK'
                });
            }
        } catch (error) {
            console.error('Error saving product:', error);
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'An error occurred while saving the product'
            });
        }
    });

    // Generate UUID v4 for image id
    function uuidv4() {
        return 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function(c) {
            const r = Math.random() * 16 | 0;
            const v = c === 'x' ? r : (r & 0x3 | 0x8);
            return v.toString(16);
        });
    }

    // Upload product images via Laravel proxy to product-image/store (one POST per image)
    async function uploadProductImages(productId, files) {
        const url = '{{ route("api.seller.products.image.store") }}';
        const headers = {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'X-Requested-With': 'XMLHttpRequest'
        };
        for (let file of Array.from(files)) {
            if (file.size > 1048576) continue;
            const base64 = await new Promise((resolve, reject) => {
                const reader = new FileReader();
                reader.onload = () => {
                    const base64String = reader.result.split(',')[1];
                    resolve(base64String || reader.result);
                };
                reader.onerror = reject;
                reader.readAsDataURL(file);
            });
            const body = { id: uuidv4(), product_id: String(productId), image: base64 };
            try {
                await fetch(url, { method: 'POST', headers, credentials: 'same-origin', body: JSON.stringify(body) });
            } catch (error) {
                console.error('Error uploading image:', error);
            }
        }
    }

    // Escape HTML to prevent XSS
    function escapeHtml(text) {
        const map = {
            '&': '&amp;',
            '<': '&lt;',
            '>': '&gt;',
            '"': '&quot;',
            "'": '&#039;'
        };
        return String(text).replace(/[&<>"']/g, m => map[m]);
    }

    window.productImageSliderPrev = function productImageSliderPrev(btn) {
        const wrap = btn.closest('.product-image-slider');
        if (!wrap) return;
        const slides = wrap.querySelectorAll('.slide');
        if (slides.length < 2) return;
        let cur = parseInt(wrap.getAttribute('data-current') || '0', 10);
        cur = cur <= 0 ? slides.length - 1 : cur - 1;
        wrap.setAttribute('data-current', String(cur));
        slides.forEach((s, i) => s.classList.toggle('active', i === cur));
    }

    window.productImageSliderNext = function productImageSliderNext(btn) {
        const wrap = btn.closest('.product-image-slider');
        if (!wrap) return;
        const slides = wrap.querySelectorAll('.slide');
        if (slides.length < 2) return;
        let cur = parseInt(wrap.getAttribute('data-current') || '0', 10);
        cur = cur >= slides.length - 1 ? 0 : cur + 1;
        wrap.setAttribute('data-current', String(cur));
        slides.forEach((s, i) => s.classList.toggle('active', i === cur));
    }

    // Close modal on outside click
    document.getElementById('productModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeProductModal();
        }
    });
</script>
@endpush
@endsection
