@extends('public.seller.layout')

@section('title', 'Product Attributes')
@section('seller-page-title', 'Product Attributes')

@section('seller-content')
<div class="space-y-6">
    <!-- Header -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
        <div class="bg-gradient-to-r from-blue-600 to-purple-600 px-6 py-8">
            <h1 class="text-3xl font-bold text-white">Product Attributes</h1>
            <p class="text-blue-100 mt-2">Manage product attributes (e.g. Color, Size)</p>
        </div>

        <div class="p-6">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-semibold text-gray-800">Attribute List</h2>
                <button onclick="openAttributeModal()" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-medium">
                    + Add Attribute
                </button>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 border border-gray-200 rounded-lg">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Created At</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="attributesTableBody" class="bg-white divide-y divide-gray-200">
                        <tr>
                            <td colspan="4" class="px-6 py-8 text-center text-gray-500">
                                <div class="flex flex-col items-center">
                                    <svg class="w-12 h-12 text-gray-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                    </svg>
                                    <p>Loading attributes...</p>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Attribute Modal -->
<div id="attributeModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-lg shadow-xl max-w-md w-full max-h-[90vh] overflow-y-auto">
        <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
            <h3 id="attributeModalTitle" class="text-xl font-semibold text-gray-800">Add Attribute</h3>
            <button onclick="closeAttributeModal()" class="text-gray-400 hover:text-gray-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        <form id="attributeForm" class="p-6 space-y-4">
            <input type="hidden" id="attributeId" name="id" value="">
            
            <div>
                <label for="attributeName" class="block text-sm font-medium text-gray-700 mb-2">Attribute Name <span class="text-red-500">*</span></label>
                <input type="text" id="attributeName" name="name" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    placeholder="e.g. Color, Size">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Type <span class="text-gray-400 font-normal">(optional, defaults to select)</span></label>
                <div class="flex items-center gap-6">
                    <label class="flex items-center cursor-pointer">
                        <input type="radio" name="type" value="" checked
                            class="w-4 h-4 text-blue-600 focus:ring-blue-500 border-gray-300">
                        <span class="ml-2 text-sm text-gray-700">Skip / Empty</span>
                    </label>
                    <label class="flex items-center cursor-pointer">
                        <input type="radio" name="type" value="select"
                            class="w-4 h-4 text-blue-600 focus:ring-blue-500 border-gray-300">
                        <span class="ml-2 text-sm text-gray-700">Select</span>
                    </label>
                    <label class="flex items-center cursor-pointer">
                        <input type="radio" name="type" value="radio"
                            class="w-4 h-4 text-blue-600 focus:ring-blue-500 border-gray-300">
                        <span class="ml-2 text-sm text-gray-700">Radio</span>
                    </label>
                </div>
            </div>

            <div class="flex justify-end space-x-3 pt-4">
                <button type="button" onclick="closeAttributeModal()"
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

<!-- Attribute Values Modal -->
<div id="valuesModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-lg shadow-xl max-w-3xl w-full max-h-[90vh] overflow-hidden flex flex-col">
        <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center flex-shrink-0">
            <h3 id="valuesModalTitle" class="text-xl font-semibold text-gray-800">Set Values</h3>
            <button type="button" onclick="closeValuesModal()" class="text-gray-400 hover:text-gray-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        <input type="hidden" id="valuesAttributeId" value="">
        <div class="p-6 flex-1 overflow-y-auto">
            <div class="flex flex-wrap gap-2 mb-4 items-end">
                <input type="text" id="valueInput" placeholder="e.g. Red, Blue, Green"
                    class="flex-1 min-w-[120px] px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                <input type="number" id="valueSortOrder" placeholder="Order" min="0" value="1"
                    class="w-20 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" id="valueIsActive" checked class="w-4 h-4 text-blue-600 rounded border-gray-300">
                    <span class="text-sm text-gray-700">Active</span>
                </label>
                <button type="button" onclick="addValue()" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-medium whitespace-nowrap">
                    Add
                </button>
            </div>
            <div class="border border-gray-200 rounded-lg overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Value</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Order</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                            <th class="px-4 py-2 text-right text-xs font-medium text-gray-500 uppercase w-24">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="valuesTableBody" class="bg-white divide-y divide-gray-200">
                        <tr>
                            <td colspan="4" class="px-4 py-6 text-center text-gray-500 text-sm">Loading...</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="px-6 py-4 border-t border-gray-200 flex justify-end flex-shrink-0">
            <button type="button" onclick="closeValuesModal()"
                class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">
                Close
            </button>
        </div>
    </div>
</div>

@push('js')
<script>
    let attributes = [];

    function getAuthHeaders() {
        const meta = document.querySelector('meta[name="csrf-token"]');
        return {
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': meta ? meta.content : '',
            'X-Requested-With': 'XMLHttpRequest'
        };
    }

    function escapeHtml(text) {
        const map = { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#039;' };
        return String(text || '').replace(/[&<>"']/g, m => map[m]);
    }

    document.addEventListener('DOMContentLoaded', function() {
        loadAttributes();
    });

    async function loadAttributes() {
        try {
            const response = await fetch('{{ route("api.seller.attributes") }}', {
                method: 'GET',
                headers: getAuthHeaders(),
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
                }).then(function(r) {
                    if (r.isConfirmed) window.location.href = '{{ route("login") }}';
                });
                return;
            }

            if (result.status === 'success' || result.success) {
                let raw = result.data || result.attributes || [];
                if (typeof raw === 'string') {
                    try { raw = JSON.parse(raw) || []; } catch (_) { raw = []; }
                }
                attributes = Array.isArray(raw) ? raw.map(a => ({
                    id: String(a.id || a.attributeId || ''),
                    name: a.name || '',
                    type: a.type || '',
                    created_at: a.created_at,
                    updated_at: a.updated_at
                })) : [];
                renderAttributes();
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: result.message || 'Failed to load attributes'
                });
            }
        } catch (error) {
            console.error('Error loading attributes:', error);
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'An error occurred while loading attributes'
            });
        }
    }

    function renderAttributes() {
        const tbody = document.getElementById('attributesTableBody');
        
        if (attributes.length === 0) {
            tbody.innerHTML = `
                <tr>
                    <td colspan="4" class="px-6 py-8 text-center text-gray-500">
                        <div class="flex flex-col items-center">
                            <svg class="w-12 h-12 text-gray-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            <p>No attributes found. Click "Add Attribute" to create one.</p>
                        </div>
                    </td>
                </tr>
            `;
            return;
        }

        tbody.innerHTML = attributes.map(attr => {
            const createdDate = attr.created_at ? new Date(attr.created_at).toLocaleDateString() : 'N/A';
            const typeDisplay = attr.type || 'select';
            
            return `
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-medium text-gray-900">${escapeHtml(attr.name)}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-500">${escapeHtml(typeDisplay)}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${createdDate}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <button onclick="openValuesModal('${escapeHtml(attr.id)}', '${escapeHtml(attr.name).replace(/'/g, "\\'")}')" class="text-green-600 hover:text-green-900 mr-3">Set Values</button>
                        <button onclick="editAttribute('${escapeHtml(attr.id)}')" class="text-blue-600 hover:text-blue-900 mr-3">Edit</button>
                        <button onclick="deleteAttribute('${escapeHtml(attr.id)}', '${escapeHtml(attr.name)}')" class="text-red-600 hover:text-red-900">Delete</button>
                    </td>
                </tr>
            `;
        }).join('');
    }

    function openAttributeModal() {
        document.getElementById('attributeModalTitle').textContent = 'Add Attribute';
        document.getElementById('attributeForm').reset();
        document.getElementById('attributeId').value = '';
        document.querySelector('#attributeForm input[name="type"][value=""]').checked = true;
        document.getElementById('attributeModal').classList.remove('hidden');
    }

    function closeAttributeModal() {
        document.getElementById('attributeModal').classList.add('hidden');
        document.getElementById('attributeForm').reset();
        document.getElementById('attributeId').value = '';
    }

    function editAttribute(id) {
        const attr = attributes.find(a => String(a.id) === String(id));
        if (!attr) {
            Swal.fire({ icon: 'error', title: 'Error', text: 'Attribute not found' });
            return;
        }

        document.getElementById('attributeModalTitle').textContent = 'Edit Attribute';
        document.getElementById('attributeId').value = attr.id;
        document.getElementById('attributeName').value = attr.name || '';
        const typeVal = (attr.type && (attr.type === 'radio' || attr.type === 'select')) ? attr.type : '';
        document.querySelector(`#attributeForm input[name="type"][value="${typeVal}"]`).checked = true;
        document.getElementById('attributeModal').classList.remove('hidden');
    }

    async function deleteAttribute(id, name) {
        const result = await Swal.fire({
            title: 'Delete Attribute?',
            text: 'Are you sure you want to delete "' + name + '"? This action cannot be undone.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel'
        });

        if (result.isConfirmed) {
            try {
                const response = await fetch('{{ route("api.seller.attributes.delete") }}', {
                    method: 'POST',
                    headers: getAuthHeaders(),
                    credentials: 'same-origin',
                    body: JSON.stringify({ id: id })
                });

                const data = await response.json();

                if (response.status === 401) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Unauthorized',
                        text: data.message || 'Your session has expired. Please login again.',
                        confirmButtonText: 'Go to Login',
                        allowOutsideClick: false
                    }).then(function(r) {
                        if (r.isConfirmed) window.location.href = '{{ route("login") }}';
                    });
                    return;
                }

                if (data.status === 'success' || response.ok) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Deleted!',
                        text: data.message || 'Attribute deleted successfully',
                        timer: 2000,
                        showConfirmButton: false,
                        toast: true,
                        position: 'top-end'
                    });
                    loadAttributes();
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: data.message || data.data?.message || 'Failed to delete attribute'
                    });
                }
            } catch (error) {
                console.error('Error deleting attribute:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'An error occurred while deleting the attribute'
                });
            }
        }
    }

    document.getElementById('attributeForm').addEventListener('submit', async function(e) {
        e.preventDefault();

        const formData = {
            id: document.getElementById('attributeId').value || null,
            name: document.getElementById('attributeName').value.trim(),
            type: (document.querySelector('#attributeForm input[name="type"]:checked') || {}).value || ''
        };

        if (!formData.name) {
            Swal.fire({ icon: 'error', title: 'Validation Error', text: 'Attribute name is required' });
            return;
        }

        try {
            const response = await fetch('{{ route("api.seller.attributes.store") }}', {
                method: 'POST',
                headers: getAuthHeaders(),
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
                }).then(function(r) {
                    if (r.isConfirmed) window.location.href = '{{ route("login") }}';
                });
                return;
            }

            if (data.status === 'success' || data.success || response.ok) {
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: data.message || (formData.id ? 'Attribute updated successfully' : 'Attribute created successfully'),
                    timer: 2000,
                    showConfirmButton: false,
                    toast: true,
                    position: 'top-end'
                });
                closeAttributeModal();
                loadAttributes();
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: data.message || 'Failed to save attribute'
                });
            }
        } catch (error) {
            console.error('Error saving attribute:', error);
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'An error occurred while saving the attribute'
            });
        }
    });

    document.getElementById('attributeModal').addEventListener('click', function(e) {
        if (e.target === this) closeAttributeModal();
    });

    // === Attribute Values Modal ===
    let attributeValues = [];

    function openValuesModal(attrId, attrName) {
        document.getElementById('valuesAttributeId').value = attrId;
        document.getElementById('valuesModalTitle').textContent = 'Set Values: ' + attrName;
        document.getElementById('valueInput').value = '';
        document.getElementById('valueSortOrder').value = '1';
        document.getElementById('valueIsActive').checked = true;
        document.getElementById('valuesModal').classList.remove('hidden');
        loadAttributeValues(attrId);
    }

    function closeValuesModal() {
        document.getElementById('valuesModal').classList.add('hidden');
        document.getElementById('valuesAttributeId').value = '';
    }

    async function loadAttributeValues(attrId) {
        const tbody = document.getElementById('valuesTableBody');
        tbody.innerHTML = '<tr><td colspan="2" class="px-4 py-6 text-center text-gray-500 text-sm">Loading...</td></tr>';

        try {
            const response = await fetch('{{ route("api.seller.attribute-values") }}', {
                method: 'POST',
                headers: getAuthHeaders(),
                credentials: 'same-origin',
                body: JSON.stringify({ product_attribute_id: attrId })
            });

            const result = await response.json();

            if (response.status === 401) {
                Swal.fire({
                    icon: 'error',
                    title: 'Unauthorized',
                    text: result.message || 'Your session has expired. Please login again.',
                    confirmButtonText: 'Go to Login',
                    allowOutsideClick: false
                }).then(function(r) {
                    if (r.isConfirmed) window.location.href = '{{ route("login") }}';
                });
                return;
            }

            if (result.status === 'success' || result.success) {
                let raw = result.data || result.values || result.attribute_values || [];
                if (typeof raw === 'string') {
                    try { raw = JSON.parse(raw) || []; } catch (_) { raw = []; }
                }
                attributeValues = Array.isArray(raw) ? raw.map(v => ({
                    id: String(v.id || v.attributeValueId || ''),
                    value: v.value || '',
                    attribute_id: v.attribute_id || v.attributeId || v.product_attribute_id || attrId,
                    is_active: v.is_active !== false && v.is_active !== '0' && v.is_active !== 0,
                    sort_order: parseInt(v.sort_order ?? v.sortOrder ?? 0, 10) || 0
                })) : [];
                renderAttributeValues();
            } else {
                tbody.innerHTML = '<tr><td colspan="4" class="px-4 py-6 text-center text-red-500 text-sm">' + (result.message || 'Failed to load values') + '</td></tr>';
            }
        } catch (error) {
            console.error('Error loading attribute values:', error);
            tbody.innerHTML = '<tr><td colspan="4" class="px-4 py-6 text-center text-red-500 text-sm">An error occurred while loading values</td></tr>';
        }
    }

    function renderAttributeValues() {
        const tbody = document.getElementById('valuesTableBody');
        const attrId = document.getElementById('valuesAttributeId').value;

        if (attributeValues.length === 0) {
            tbody.innerHTML = '<tr><td colspan="4" class="px-4 py-6 text-center text-gray-500 text-sm">No values yet. Add one above.</td></tr>';
            return;
        }

        tbody.innerHTML = attributeValues.map(v => {
            const isActive = v.is_active !== false && v.is_active !== '0' && v.is_active !== 0;
            return `
            <tr class="hover:bg-gray-50">
                <td class="px-4 py-3 text-sm text-gray-900">${escapeHtml(v.value)}</td>
                <td class="px-4 py-3 text-sm text-gray-500">${v.sort_order}</td>
                <td class="px-4 py-3">
                    <span class="px-2 py-0.5 text-xs font-medium rounded ${isActive ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-600'}">${isActive ? 'Active' : 'Inactive'}</span>
                </td>
                <td class="px-4 py-3 text-right">
                    <button type="button" onclick="editAttributeValue('${escapeHtml(v.id)}')" class="text-blue-600 hover:text-blue-900 mr-2 text-sm">Edit</button>
                    <button type="button" onclick="deleteAttributeValue('${escapeHtml(v.id)}', '${escapeHtml(v.value).replace(/'/g, "\\'")}')" class="text-red-600 hover:text-red-900 text-sm">Delete</button>
                </td>
            </tr>
        `;
        }).join('');
    }

    async function addValue() {
        const attrId = document.getElementById('valuesAttributeId').value;
        const valueInput = document.getElementById('valueInput');
        const value = (valueInput.value || '').trim();
        if (!value) {
            Swal.fire({ icon: 'warning', title: 'Required', text: 'Please enter a value' });
            return;
        }
        const isActive = document.getElementById('valueIsActive').checked;
        const sortOrder = parseInt(document.getElementById('valueSortOrder').value || '0', 10) || 0;

        const body = {
            product_attribute_id: attrId,
            value: value,
            is_active: isActive,
            sort_order: sortOrder
        };

        try {
            const response = await fetch('{{ route("api.seller.attribute-values.store") }}', {
                method: 'POST',
                headers: getAuthHeaders(),
                credentials: 'same-origin',
                body: JSON.stringify(body)
            });

            const data = await response.json();

            if (response.status === 401) {
                Swal.fire({
                    icon: 'error',
                    title: 'Unauthorized',
                    text: data.message || 'Your session has expired. Please login again.',
                    confirmButtonText: 'Go to Login',
                    allowOutsideClick: false
                }).then(function(r) {
                    if (r.isConfirmed) window.location.href = '{{ route("login") }}';
                });
                return;
            }

            if (data.status === 'success' || data.success || response.ok) {
                Swal.fire({
                    icon: 'success',
                    title: 'Added!',
                    text: 'Value added successfully',
                    timer: 1500,
                    showConfirmButton: false,
                    toast: true,
                    position: 'top-end'
                });
                valueInput.value = '';
                document.getElementById('valueSortOrder').value = (attributeValues.length + 1);
                loadAttributeValues(attrId);
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: data.message || 'Failed to add value'
                });
            }
        } catch (error) {
            console.error('Error adding value:', error);
            Swal.fire({ icon: 'error', title: 'Error', text: 'An error occurred while adding the value' });
        }
    }

    function editAttributeValue(id) {
        const v = attributeValues.find(x => String(x.id) === String(id));
        if (!v) return;
        const isActive = v.is_active !== false && v.is_active !== '0' && v.is_active !== 0;
        Swal.fire({
            title: 'Edit Value',
            html: `
                <div class="text-left">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Value <span class="text-red-500">*</span></label>
                    <input id="swal-value" class="swal2-input w-full mb-4" value="${escapeHtml(v.value).replace(/"/g, '&quot;')}" placeholder="e.g. Red">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Sort Order</label>
                    <input id="swal-sort-order" type="number" class="swal2-input w-full mb-4" value="${v.sort_order}" min="0" placeholder="0">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input id="swal-is-active" type="checkbox" ${isActive ? 'checked' : ''} class="w-4 h-4 text-blue-600 rounded">
                        <span class="text-sm text-gray-700">Active</span>
                    </label>
                </div>
            `,
            showCancelButton: true,
            confirmButtonText: 'Save',
            cancelButtonText: 'Cancel',
            preConfirm: () => {
                const val = document.getElementById('swal-value').value.trim();
                if (!val) {
                    Swal.showValidationMessage('Value is required');
                    return false;
                }
                return {
                    value: val,
                    is_active: document.getElementById('swal-is-active').checked,
                    sort_order: parseInt(document.getElementById('swal-sort-order').value || '0', 10) || 0
                };
            }
        }).then(function(result) {
            if (result.isConfirmed && result.value) {
                saveAttributeValue(id, result.value.value, result.value.is_active, result.value.sort_order);
            }
        });
    }

    async function saveAttributeValue(id, value, isActive, sortOrder) {
        const attrId = document.getElementById('valuesAttributeId').value;

        const body = {
            id: id,
            product_attribute_id: attrId,
            value: value,
            is_active: isActive !== false,
            sort_order: parseInt(sortOrder || '0', 10) || 0
        };

        try {
            const response = await fetch('{{ route("api.seller.attribute-values.store") }}', {
                method: 'POST',
                headers: getAuthHeaders(),
                credentials: 'same-origin',
                body: JSON.stringify(body)
            });

            const data = await response.json();

            if (response.status === 401) {
                Swal.fire({
                    icon: 'error',
                    title: 'Unauthorized',
                    text: data.message || 'Your session has expired. Please login again.',
                    confirmButtonText: 'Go to Login',
                    allowOutsideClick: false
                }).then(function(r) {
                    if (r.isConfirmed) window.location.href = '{{ route("login") }}';
                });
                return;
            }

            if (data.status === 'success' || data.success || response.ok) {
                Swal.fire({
                    icon: 'success',
                    title: 'Updated!',
                    text: 'Value updated successfully',
                    timer: 1500,
                    showConfirmButton: false,
                    toast: true,
                    position: 'top-end'
                });
                loadAttributeValues(attrId);
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: data.message || 'Failed to update value'
                });
            }
        } catch (error) {
            console.error('Error updating value:', error);
            Swal.fire({ icon: 'error', title: 'Error', text: 'An error occurred while updating the value' });
        }
    }

    async function deleteAttributeValue(id, valueDisplay) {
        const result = await Swal.fire({
            title: 'Delete Value?',
            text: 'Are you sure you want to delete "' + valueDisplay + '"?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel'
        });

        if (!result.isConfirmed) return;

        const attrId = document.getElementById('valuesAttributeId').value;

        try {
            const response = await fetch('{{ route("api.seller.attribute-values.delete") }}', {
                method: 'POST',
                headers: getAuthHeaders(),
                credentials: 'same-origin',
                body: JSON.stringify({ id: id })
            });

            const data = await response.json();

            if (response.status === 401) {
                Swal.fire({
                    icon: 'error',
                    title: 'Unauthorized',
                    text: data.message || 'Your session has expired. Please login again.',
                    confirmButtonText: 'Go to Login',
                    allowOutsideClick: false
                }).then(function(r) {
                    if (r.isConfirmed) window.location.href = '{{ route("login") }}';
                });
                return;
            }

            if (data.status === 'success' || response.ok) {
                Swal.fire({
                    icon: 'success',
                    title: 'Deleted!',
                    text: 'Value deleted successfully',
                    timer: 1500,
                    showConfirmButton: false,
                    toast: true,
                    position: 'top-end'
                });
                loadAttributeValues(attrId);
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: data.message || data.data?.message || 'Failed to delete value'
                });
            }
        } catch (error) {
            console.error('Error deleting value:', error);
            Swal.fire({ icon: 'error', title: 'Error', text: 'An error occurred while deleting the value' });
        }
    }

    document.getElementById('valueInput').addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            addValue();
        }
    });

    document.getElementById('valuesModal').addEventListener('click', function(e) {
        if (e.target === this) closeValuesModal();
    });
</script>
@endpush
@endsection
