@extends('admin.layouts.app')

@section('title', 'User Management')
@section('page-title', 'User Management')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div>
        <h3 class="text-lg font-semibold text-gray-900">Manage Users</h3>
        <p class="text-sm text-gray-600 mt-1">Create, edit, and manage user roles and permissions</p>
    </div>

    <!-- Users Table -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
        <!-- Custom Add Button - will be positioned next to entries dropdown by JavaScript -->
        <div id="custom-add-button-container" style="display: none;">
            <button onclick="openCreateModal()" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors inline-flex items-center gap-2 text-sm font-medium">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Add New User
            </button>
        </div>
        <div class="overflow-x-auto">
            <table id="usersTable" class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Role</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Created At</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody id="usersTableBody" class="bg-white divide-y divide-gray-200">
                    <!-- Data will be populated by JavaScript -->
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Biodata Modal -->
<div id="biodataModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50" onclick="closeBiodataModalOnBackdrop(event)">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-lg shadow-xl max-w-2xl w-full max-h-[90vh] overflow-y-auto" onclick="event.stopPropagation()">
            <div class="p-6 border-b border-gray-200 sticky top-0 bg-white z-10">
                <div class="flex justify-between items-center">
                    <h3 class="text-xl font-semibold text-gray-900">User Biodata</h3>
                    <button onclick="closeBiodataModal()" class="text-gray-400 hover:text-gray-600 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>
            <div class="p-6 space-y-6">
                <!-- Profile Header -->
                <div class="flex items-center gap-4 pb-6 border-b border-gray-200">
                    <div id="biodataAvatar" class="w-20 h-20 rounded-full bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center text-white font-semibold text-2xl">
                        <!-- Avatar will be populated -->
                    </div>
                    <div>
                        <h4 id="biodataName" class="text-2xl font-bold text-gray-900"></h4>
                        <p id="biodataEmail" class="text-gray-600"></p>
                        <div class="flex items-center gap-2 mt-2">
                            <span id="biodataRole" class="px-2 py-1 text-xs font-semibold rounded-full"></span>
                            <span id="biodataStatus" class="px-2 py-1 text-xs font-semibold rounded-full"></span>
                        </div>
                    </div>
                </div>

                <!-- Personal Information -->
                <div>
                    <h5 class="text-lg font-semibold text-gray-900 mb-4">Personal Information</h5>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Full Name</label>
                            <p id="biodataFullName" class="text-gray-900"></p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Email Address</label>
                            <p id="biodataEmailAddress" class="text-gray-900"></p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Phone Number</label>
                            <p id="biodataPhone" class="text-gray-900"></p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Department</label>
                            <p id="biodataDepartment" class="text-gray-900"></p>
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-500 mb-1">Address</label>
                            <p id="biodataAddress" class="text-gray-900"></p>
                        </div>
                    </div>
                </div>

                <!-- Bio Section -->
                <div>
                    <h5 class="text-lg font-semibold text-gray-900 mb-4">Biography</h5>
                    <p id="biodataBio" class="text-gray-700 leading-relaxed"></p>
                </div>

                <!-- Account Information -->
                <div>
                    <h5 class="text-lg font-semibold text-gray-900 mb-4">Account Information</h5>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Role</label>
                            <p id="biodataRoleDetail" class="text-gray-900"></p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Status</label>
                            <p id="biodataStatusDetail" class="text-gray-900"></p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Join Date</label>
                            <p id="biodataJoinDate" class="text-gray-900"></p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Account Created</label>
                            <p id="biodataCreatedAt" class="text-gray-900"></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="p-6 border-t border-gray-200 bg-gray-50 flex justify-end">
                <button onclick="closeBiodataModal()" class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors">
                    Close
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Create/Edit User Modal -->
<div id="userModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50" onclick="closeModalOnBackdrop(event)">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-lg shadow-xl max-w-md w-full" onclick="event.stopPropagation()">
            <div class="p-6 border-b border-gray-200">
                <h3 id="modalTitle" class="text-lg font-semibold text-gray-900">Add New User</h3>
            </div>
            <form id="userForm" class="p-6 space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                    <input type="text" id="userName" name="name" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                    <input type="email" id="userEmail" name="email" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                    <input type="password" id="userPassword" name="password" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <p class="text-xs text-gray-500 mt-1">Leave blank to keep current password</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Role</label>
                    <select id="userRole" name="role" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">Select Role</option>
                        <option value="admin">Admin</option>
                        <option value="manager">Manager</option>
                        <option value="editor">Editor</option>
                        <option value="user">User</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                    <select id="userStatus" name="status" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                        <option value="suspended">Suspended</option>
                    </select>
                </div>
                <div class="flex justify-end gap-3 pt-4">
                    <button type="button" onclick="closeModal()" class="px-4 py-2 text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors">
                        Cancel
                    </button>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                        Save User
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script>
    // Mock data untuk simulasi (frontend only)
    let usersData = [
        { id: 1, name: 'John Doe', email: 'john.doe@example.com', role: 'admin', status: 'active', created_at: '2024-01-15', avatar: null, phone: '+1 (555) 123-4567', address: '123 Main Street, New York, NY 10001', bio: 'Experienced administrator with 10+ years in system management.', department: 'IT Department', join_date: '2020-01-15' },
        { id: 2, name: 'Jane Smith', email: 'jane.smith@example.com', role: 'manager', status: 'active', created_at: '2024-01-20', avatar: null, phone: '+1 (555) 234-5678', address: '456 Oak Avenue, Los Angeles, CA 90001', bio: 'Strategic manager focused on team development and process improvement.', department: 'Operations', join_date: '2019-06-20' },
        { id: 3, name: 'Bob Johnson', email: 'bob.johnson@example.com', role: 'editor', status: 'active', created_at: '2024-02-01', avatar: null, phone: '+1 (555) 345-6789', address: '789 Pine Road, Chicago, IL 60601', bio: 'Creative editor passionate about content quality and user engagement.', department: 'Content', join_date: '2021-03-01' },
        { id: 4, name: 'Alice Williams', email: 'alice.williams@example.com', role: 'user', status: 'active', created_at: '2024-02-10', avatar: null, phone: '+1 (555) 456-7890', address: '321 Elm Street, Houston, TX 77001', bio: 'Dedicated team member with strong attention to detail.', department: 'Sales', join_date: '2022-05-10' },
        { id: 5, name: 'Charlie Brown', email: 'charlie.brown@example.com', role: 'user', status: 'inactive', created_at: '2024-02-15', avatar: null, phone: '+1 (555) 567-8901', address: '654 Maple Drive, Phoenix, AZ 85001', bio: 'Customer service specialist with excellent communication skills.', department: 'Support', join_date: '2023-01-15' },
        { id: 6, name: 'Diana Prince', email: 'diana.prince@example.com', role: 'manager', status: 'active', created_at: '2024-02-20', avatar: null, phone: '+1 (555) 678-9012', address: '987 Cedar Lane, Philadelphia, PA 19101', bio: 'Results-driven manager with expertise in project management.', department: 'Marketing', join_date: '2018-09-20' },
        { id: 7, name: 'Edward Norton', email: 'edward.norton@example.com', role: 'editor', status: 'suspended', created_at: '2024-03-01', avatar: null, phone: '+1 (555) 789-0123', address: '147 Birch Court, San Antonio, TX 78201', bio: 'Content strategist with a focus on digital marketing.', department: 'Content', join_date: '2021-08-01' },
        { id: 8, name: 'Fiona Apple', email: 'fiona.apple@example.com', role: 'user', status: 'active', created_at: '2024-03-05', avatar: null, phone: '+1 (555) 890-1234', address: '258 Spruce Way, San Diego, CA 92101', bio: 'Enthusiastic team player committed to achieving goals.', department: 'HR', join_date: '2023-03-05' },
        { id: 9, name: 'George Clooney', email: 'george.clooney@example.com', role: 'admin', status: 'active', created_at: '2024-03-10', avatar: null, phone: '+1 (555) 901-2345', address: '369 Willow Street, Dallas, TX 75201', bio: 'Senior administrator overseeing system architecture and security.', department: 'IT Department', join_date: '2017-11-10' },
        { id: 10, name: 'Helen Mirren', email: 'helen.mirren@example.com', role: 'user', status: 'inactive', created_at: '2024-03-15', avatar: null, phone: '+1 (555) 012-3456', address: '741 Ash Avenue, San Jose, CA 95101', bio: 'Detail-oriented professional with strong analytical skills.', department: 'Finance', join_date: '2022-09-15' },
    ];

    let currentEditId = null;
    let dataTable;

    // Initialize DataTable
    $(document).ready(function() {
        dataTable = $('#usersTable').DataTable({
            data: usersData,
            columns: [
                {
                    data: null,
                    render: function(data, type, row) {
                        const initials = row.name.split(' ').map(n => n[0]).join('').toUpperCase().substring(0, 2);
                        return `
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center text-white font-semibold text-sm">
                                    ${initials}
                                </div>
                                <span class="font-medium text-gray-900">${row.name}</span>
                            </div>
                        `;
                    }
                },
                { data: 'email' },
                {
                    data: 'role',
                    render: function(data) {
                        const roleColors = {
                            'admin': 'bg-red-100 text-red-800',
                            'manager': 'bg-blue-100 text-blue-800',
                            'editor': 'bg-green-100 text-green-800',
                            'user': 'bg-gray-100 text-gray-800'
                        };
                        const colorClass = roleColors[data] || 'bg-gray-100 text-gray-800';
                        return `<span class="px-2 py-1 text-xs font-semibold rounded-full ${colorClass}">${data.charAt(0).toUpperCase() + data.slice(1)}</span>`;
                    }
                },
                {
                    data: 'status',
                    render: function(data) {
                        const statusColors = {
                            'active': 'bg-green-100 text-green-800',
                            'inactive': 'bg-gray-100 text-gray-800',
                            'suspended': 'bg-red-100 text-red-800'
                        };
                        const colorClass = statusColors[data] || 'bg-gray-100 text-gray-800';
                        return `<span class="px-2 py-1 text-xs font-semibold rounded-full ${colorClass}">${data.charAt(0).toUpperCase() + data.slice(1)}</span>`;
                    }
                },
                { data: 'created_at' },
                {
                    data: null,
                    orderable: false,
                    render: function(data, type, row) {
                        return `
                            <div class="flex items-center gap-2">
                                <a href="/admin/users/${row.id}" class="p-1.5 text-purple-600 hover:bg-purple-50 rounded transition-colors" title="View Details">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                    </svg>
                                </a>
                                <button onclick="viewBiodata(${row.id})" class="p-1.5 text-green-600 hover:bg-green-50 rounded transition-colors" title="View Biodata">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                </button>
                                <button onclick="editUser(${row.id})" class="p-1.5 text-blue-600 hover:bg-blue-50 rounded transition-colors" title="Edit">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                </button>
                                <button onclick="deleteUser(${row.id})" class="p-1.5 text-red-600 hover:bg-red-50 rounded transition-colors" title="Delete">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                </button>
                            </div>
                        `;
                    }
                }
            ],
            pageLength: 10,
            lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
            order: [[4, 'desc']],
            language: {
                search: "",
                searchPlaceholder: "Search users...",
                lengthMenu: "Show _MENU_ entries",
                info: "Showing _START_ to _END_ of _TOTAL_ entries",
                infoEmpty: "Showing 0 to 0 of 0 entries",
                infoFiltered: "(filtered from _TOTAL_ total entries)",
                paginate: {
                    first: "First",
                    last: "Last",
                    next: "Next",
                    previous: "Previous"
                }
            },
            dom: '<"flex justify-between items-center mb-4 px-4 pt-4"<"flex items-center gap-2"l><"flex items-center gap-2"f>>rt<"flex justify-between items-center mt-4 px-4 pb-4"<"text-sm text-gray-700"i><"flex items-center gap-2"p>>',
            initComplete: function() {
                // Move custom button below entries dropdown after DataTables initializes
                setTimeout(function() {
                    const lengthContainer = $('.dataTables_length');
                    const customButtonContainer = $('#custom-add-button-container');
                    if (lengthContainer.length && customButtonContainer.length) {
                        // Show container first
                        customButtonContainer.show();
                        // Insert button right after entries dropdown, aligned to the left
                        customButtonContainer.detach().insertAfter(lengthContainer).css({
                            'margin-left': '0',
                            'margin-top': '0',
                            'display': 'inline-flex',
                            'align-items': 'center'
                        });
                    }
                }, 100);
            }
        });
    });

    function openCreateModal() {
        currentEditId = null;
        $('#modalTitle').text('Add New User');
        $('#userForm')[0].reset();
        $('#userPassword').attr('required', true);
        $('#userModal').removeClass('hidden');
    }

    function editUser(id) {
        const user = usersData.find(u => u.id === id);
        if (!user) return;

        currentEditId = id;
        $('#modalTitle').text('Edit User');
        $('#userName').val(user.name);
        $('#userEmail').val(user.email);
        $('#userRole').val(user.role);
        $('#userStatus').val(user.status);
        $('#userPassword').removeAttr('required');
        $('#userPassword').val('');
        $('#userModal').removeClass('hidden');
    }

    function deleteUser(id) {
        Swal.fire({
            title: 'Are you sure?',
            text: 'You want to delete this user?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                usersData = usersData.filter(u => u.id !== id);
                dataTable.clear().rows.add(usersData).draw();
                Swal.fire({
                    icon: 'success',
                    title: 'Deleted!',
                    text: 'User deleted successfully!',
                    timer: 2000,
                    showConfirmButton: false
                });
            }
        });
    }

    function viewBiodata(id) {
        const user = usersData.find(u => u.id === id);
        if (!user) return;

        // Set avatar/initials
        const initials = user.name.split(' ').map(n => n[0]).join('').toUpperCase().substring(0, 2);
        $('#biodataAvatar').html(initials);

        // Set basic info
        $('#biodataName').text(user.name);
        $('#biodataEmail').text(user.email);
        
        // Set role badge
        const roleColors = {
            'admin': 'bg-red-100 text-red-800',
            'manager': 'bg-blue-100 text-blue-800',
            'editor': 'bg-green-100 text-green-800',
            'user': 'bg-gray-100 text-gray-800'
        };
        const roleColorClass = roleColors[user.role] || 'bg-gray-100 text-gray-800';
        $('#biodataRole').attr('class', `px-2 py-1 text-xs font-semibold rounded-full ${roleColorClass}`).text(user.role.charAt(0).toUpperCase() + user.role.slice(1));
        
        // Set status badge
        const statusColors = {
            'active': 'bg-green-100 text-green-800',
            'inactive': 'bg-gray-100 text-gray-800',
            'suspended': 'bg-red-100 text-red-800'
        };
        const statusColorClass = statusColors[user.status] || 'bg-gray-100 text-gray-800';
        $('#biodataStatus').attr('class', `px-2 py-1 text-xs font-semibold rounded-full ${statusColorClass}`).text(user.status.charAt(0).toUpperCase() + user.status.slice(1));

        // Set personal information
        $('#biodataFullName').text(user.name);
        $('#biodataEmailAddress').text(user.email);
        $('#biodataPhone').text(user.phone || 'N/A');
        $('#biodataDepartment').text(user.department || 'N/A');
        $('#biodataAddress').text(user.address || 'N/A');
        $('#biodataBio').text(user.bio || 'No biography available.');

        // Set account information
        $('#biodataRoleDetail').text(user.role.charAt(0).toUpperCase() + user.role.slice(1));
        $('#biodataStatusDetail').text(user.status.charAt(0).toUpperCase() + user.status.slice(1));
        $('#biodataJoinDate').text(user.join_date ? new Date(user.join_date).toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' }) : 'N/A');
        $('#biodataCreatedAt').text(new Date(user.created_at).toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' }));

        // Show modal
        $('#biodataModal').removeClass('hidden');
    }

    function closeBiodataModal() {
        $('#biodataModal').addClass('hidden');
    }

    function closeBiodataModalOnBackdrop(event) {
        if (event.target.id === 'biodataModal') {
            closeBiodataModal();
        }
    }

    function closeModal() {
        $('#userModal').addClass('hidden');
        currentEditId = null;
        $('#userForm')[0].reset();
    }

    function closeModalOnBackdrop(event) {
        if (event.target.id === 'userModal') {
            closeModal();
        }
    }

    $('#userForm').on('submit', function(e) {
        e.preventDefault();
        
        const formData = {
            name: $('#userName').val(),
            email: $('#userEmail').val(),
            password: $('#userPassword').val(),
            role: $('#userRole').val(),
            status: $('#userStatus').val()
        };

        if (currentEditId) {
            // Update existing user
            const userIndex = usersData.findIndex(u => u.id === currentEditId);
            if (userIndex !== -1) {
                usersData[userIndex] = {
                    ...usersData[userIndex],
                    name: formData.name,
                    email: formData.email,
                    role: formData.role,
                    status: formData.status
                };
                dataTable.clear().rows.add(usersData).draw();
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: 'User updated successfully!',
                    timer: 2000,
                    showConfirmButton: false,
                    toast: true,
                    position: 'top-end'
                });
            }
        } else {
            // Create new user
            const newUser = {
                id: Math.max(...usersData.map(u => u.id)) + 1,
                name: formData.name,
                email: formData.email,
                role: formData.role,
                status: formData.status,
                created_at: new Date().toISOString().split('T')[0],
                avatar: null
            };
            usersData.push(newUser);
            dataTable.clear().rows.add(usersData).draw();
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: 'User created successfully!',
                timer: 2000,
                showConfirmButton: false,
                toast: true,
                position: 'top-end'
            });
        }

        closeModal();
    });
</script>

@endpush

@push('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">
<style>
    /* Override DataTables default styles to match Tailwind */
    .dataTables_wrapper {
        font-size: 0.875rem;
    }
    
    .dataTables_wrapper .dataTables_length,
    .dataTables_wrapper .dataTables_filter {
        margin-bottom: 1rem;
    }
    
    .dataTables_wrapper .dataTables_length select,
    .dataTables_wrapper .dataTables_filter input {
        padding: 0.375rem 0.75rem;
        font-size: 0.875rem;
        border: 1px solid #d1d5db;
        border-radius: 0.5rem;
    }
    
    .dataTables_wrapper .dataTables_length select:focus,
    .dataTables_wrapper .dataTables_filter input:focus {
        outline: none;
        ring: 2px;
        ring-color: #3b82f6;
        border-color: transparent;
    }
    
    .dataTables_wrapper .dataTables_paginate .paginate_button {
        padding: 0.25rem 0.75rem;
        margin: 0 0.25rem;
        font-size: 0.875rem;
        color: #374151;
        background-color: white;
        border: 1px solid #d1d5db;
        border-radius: 0.5rem;
    }
    
    .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
        background-color: #f9fafb;
    }
    
    .dataTables_wrapper .dataTables_paginate .paginate_button.current {
        background-color: #2563eb;
        color: white;
        border-color: #2563eb;
    }
    
    .dataTables_wrapper .dataTables_paginate .paginate_button.current:hover {
        background-color: #1d4ed8;
    }
    
    .dataTables_wrapper .dataTables_paginate .paginate_button.disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }
    
    .dataTables_wrapper .dataTables_info {
        font-size: 0.875rem;
        color: #374151;
    }
    
    /* DataTables Buttons Styling */
    .dt-buttons {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .dt-button {
        padding: 0.5rem 1rem !important;
        font-size: 0.875rem !important;
        font-weight: 500 !important;
        border-radius: 0.5rem !important;
        transition: background-color 0.2s !important;
        border: none !important;
    }
    
    .dt-button:hover {
        opacity: 0.9 !important;
    }
</style>
@endpush

@endsection
