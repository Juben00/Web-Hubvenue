<?php
require_once(__DIR__ . '/../classes/account.class.php');
$account = new Account();
$users = $account->getAllUsers();
?>
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl md:text-3xl font-semibold text-gray-800 mb-6 hidden md:block">User Management</h1>

    <div class="container mx-auto px-6 py-8">
        <section class="bg-white rounded-lg shadow-md p-6 mb-8">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-semibold text-gray-800">Manage Users</h2>
                <div class="flex gap-2">
                    <select id="filterUserType" class="border rounded px-3 py-2">
                        <option value="">All Users</option>
                        <option value="1">Host</option>
                        <option value="2">Guest</option>
                        <option value="3">Admin</option>
                    </select>
                    <button class="bg-primary text-white px-4 py-2 rounded hover:bg-red-700" id="createUserBtn">
                        Create User
                    </button>
                </div>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="py-2 px-4 text-left">User ID</th>
                            <th class="py-2 px-4 text-left">Name</th>
                            <th class="py-2 px-4 text-left">Sex</th>
                            <th class="py-2 px-4 text-left">Role</th>
                            <th class="py-2 px-4 text-left">Birthdate</th>
                            <th class="py-2 px-4 text-left">Contact</th>
                            <th class="py-2 px-4 text-left">Email</th>
                            <th class="py-2 px-4 text-left">Status</th>
                            <th class="py-2 px-4 text-left">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="userTable">
                        <?php if (!empty($users) && is_array($users)): ?>
                            <?php foreach ($users as $user): ?>
                                <tr class="hover:bg-gray-50">
                                    <td class="py-2 px-4 border-b"><?= htmlspecialchars($user['id']) ?></td>
                                    <td class="py-2 px-4 border-b">
                                        <div class="flex items-center gap-3">
                                            <?php if (!empty($user['profile_pic'])): ?>
                                                <img src="../<?= htmlspecialchars($user['profile_pic']) ?>" alt="Profile" class="w-8 h-8 rounded-full object-cover">
                                            <?php else: ?>
                                                <div class="w-8 h-8 rounded-full bg-gray-200 flex items-center justify-center">
                                                    <span class="text-gray-500 text-sm font-semibold"><?= htmlspecialchars(strtoupper(substr($user['firstname'], 0, 1))) ?></span>
                                                </div>
                                            <?php endif; ?>
                                            <div>
                                                <div class="font-medium">
                                                    <?= htmlspecialchars($user['firstname'] . ' ' . $user['lastname']) ?>
                                                </div>
                                                <?php if (!empty($user['middlename'])): ?>
                                                    <div class="text-sm text-gray-500">
                                                        <?= htmlspecialchars($user['middlename']) . '.' ?>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-2 px-4 border-b"><?= htmlspecialchars($user['sex_name']) ?></td>
                                    <td class="py-2 px-4 border-b">
                                        <span class="px-2 py-1 text-sm rounded-full <?= 
                                            $user['user_type_id'] == 1 ? 'bg-blue-100 text-blue-800' : 
                                            ($user['user_type_id'] == 2 ? 'bg-green-100 text-green-800' : 
                                            'bg-purple-100 text-purple-800') ?>">
                                            <?= htmlspecialchars($user['user_type_name']) ?>
                                        </span>
                                    </td>
                                    <td class="py-2 px-4 border-b">
                                        <?= !empty($user['birthdate']) ? date('M d, Y', strtotime($user['birthdate'])) : '-' ?>
                                    </td>
                                    <td class="py-2 px-4 border-b"><?= htmlspecialchars($user['contact_number']) ?></td>
                                    <td class="py-2 px-4 border-b">
                                        <div class="flex flex-col">
                                            <span><?= htmlspecialchars($user['email']) ?></span>
                                            <span class="text-sm <?= $user['is_Verified'] == 'Verified' ? 'text-green-600' : 'text-red-600' ?>">
                                                <?= htmlspecialchars($user['is_Verified']) ?>
                                            </span>
                                        </div>
                                    </td>
                                    <td class="py-2 px-4 border-b">
                                        <span class="px-2 py-1 text-sm rounded-full <?= $user['is_Verified'] == 'Verified' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' ?>">
                                            <?= htmlspecialchars($user['is_Verified']) ?>
                                        </span>
                                    </td>
                                    <td class="py-2 px-4 border-b">
                                        <div class="flex gap-2">
                                            <button class="view-user bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600" 
                                                    data-id="<?= htmlspecialchars($user['id']) ?>">
                                                View
                                            </button>
                                            <?php if ($user['is_Verified'] == 'Verified'): ?>
                                                <button class="restrict-user bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600" 
                                                        data-id="<?= htmlspecialchars($user['id']) ?>">
                                                    Restrict
                                                </button>
                                            <?php else: ?>
                                                <button class="verify-user bg-green-500 text-white px-3 py-1 rounded hover:bg-green-600" 
                                                        data-id="<?= htmlspecialchars($user['id']) ?>">
                                                    Verify
                                                </button>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="9" class="py-4 px-4 text-center text-gray-500">No users found</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </section>

        <!-- Create User Modal -->
        <?php require_once './add-user.html'; ?>

        <!-- View User Modal -->
        <div id="viewUserModal" class="fixed inset-0 bg-gray-800 bg-opacity-50 items-center justify-center hidden">
            <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-2xl">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-xl font-semibold">User Details</h2>
                    <button class="close-modal text-gray-500 hover:text-gray-700">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                <div id="userDetails" class="space-y-4">
                    <!-- User details will be populated here -->
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const filterUserType = document.getElementById('filterUserType');
    const createUserBtn = document.getElementById('createUserBtn');
    const createUserModal = document.getElementById('createUserModal');
    const viewUserModal = document.getElementById('viewUserModal');
    const userTable = document.getElementById('userTable');
    const createUserForm = document.getElementById('createUserForm');

    // Filter functionality
    filterUserType.addEventListener('change', function() {
        const rows = userTable.querySelectorAll('tr:not(:first-child)');
        const filterValue = this.value.toLowerCase();
        
        rows.forEach(row => {
            const roleCell = row.querySelector('td:nth-child(4)');
            if (!roleCell) return;
            
            const roleText = roleCell.textContent.trim().toLowerCase();
            const shouldShow = !filterValue || 
                (filterValue === '1' && roleText.includes('host')) ||
                (filterValue === '2' && roleText.includes('guest')) ||
                (filterValue === '3' && roleText.includes('admin'));
            
            row.style.display = shouldShow ? '' : 'none';
        });
    });

    // Create user form submission
    if (createUserForm) {
        createUserForm.addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const data = {};
            formData.forEach((value, key) => data[key] = value);

            try {
                const response = await fetch('../api/createUser.api.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify(data)
                });

                if (!response.ok) throw new Error('Network response was not ok');
                
                const result = await response.json();
                if (result.success) {
                    alert('User created successfully!');
                    window.location.reload();
                } else {
                    alert(result.message || 'Failed to create user');
                }
            } catch (error) {
                console.error('Error:', error);
                alert('Error creating user. Please try again.');
            }
        });
    }

    // View user functionality
    document.querySelectorAll('.view-user').forEach(button => {
        button.addEventListener('click', async function() {
            const userId = this.dataset.id;
            if (!userId) return;

            try {
                const response = await fetch(`../api/getUserDetails.api.php?id=${userId}`);
                if (!response.ok) throw new Error('Network response was not ok');
                
                const userData = await response.json();
                if (!userData.success) throw new Error(userData.message || 'Failed to fetch user details');

                const userDetails = document.getElementById('userDetails');
                userDetails.innerHTML = `
                    <div class="grid grid-cols-2 gap-4">
                        <div class="col-span-2 flex items-center justify-center mb-4">
                            ${userData.user.profile_pic ? 
                                `<img src="../${userData.user.profile_pic}" alt="Profile" class="w-24 h-24 rounded-full object-cover shadow-lg">` :
                                `<div class="w-24 h-24 rounded-full bg-gray-200 flex items-center justify-center shadow-lg">
                                    <span class="text-gray-500 text-3xl font-semibold">${userData.user.firstname.charAt(0).toUpperCase()}</span>
                                </div>`
                            }
                        </div>
                        <div>
                            <label class="text-sm font-medium text-gray-700">Name</label>
                            <p class="mt-1 text-lg">${userData.user.firstname} ${userData.user.middlename ? userData.user.middlename + ' ' : ''}${userData.user.lastname}</p>
                        </div>
                        <div>
                            <label class="text-sm font-medium text-gray-700">Email</label>
                            <p class="mt-1 text-lg">${userData.user.email}</p>
                        </div>
                        <div>
                            <label class="text-sm font-medium text-gray-700">Contact Number</label>
                            <p class="mt-1 text-lg">${userData.user.contact_number || 'Not specified'}</p>
                        </div>
                        <div>
                            <label class="text-sm font-medium text-gray-700">Role</label>
                            <p class="mt-1">
                                <span class="px-3 py-1 text-sm rounded-full ${
                                    userData.user.user_type_name === 'Host' ? 'bg-blue-100 text-blue-800' :
                                    userData.user.user_type_name === 'Guest' ? 'bg-green-100 text-green-800' :
                                    'bg-purple-100 text-purple-800'
                                }">
                                    ${userData.user.user_type_name}
                                </span>
                            </p>
                        </div>
                        <div>
                            <label class="text-sm font-medium text-gray-700">Address</label>
                            <p class="mt-1 text-lg">${userData.user.address || 'Not specified'}</p>
                        </div>
                        <div>
                            <label class="text-sm font-medium text-gray-700">Status</label>
                            <p class="mt-1">
                                <span class="px-3 py-1 text-sm rounded-full ${
                                    userData.user.is_Verified === 'Verified' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'
                                }">
                                    ${userData.user.is_Verified}
                                </span>
                            </p>
                        </div>
                    </div>
                `;
                
                viewUserModal.classList.remove('hidden');
                viewUserModal.classList.add('flex');
            } catch (error) {
                console.error('Error:', error);
                alert('Error fetching user details. Please try again.');
            }
        });
    });

    // Action buttons (Restrict/Verify)
    document.querySelectorAll('.restrict-user, .verify-user').forEach(button => {
        button.addEventListener('click', async function() {
            const userId = this.dataset.id;
            if (!userId) return;

            const action = this.classList.contains('restrict-user') ? 'restrict' : 'verify';
            
            if (!confirm(`Are you sure you want to ${action} this user?`)) return;

            try {
                const response = await fetch(`../api/${action}User.api.php`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({ userId })
                });

                if (!response.ok) throw new Error('Network response was not ok');
                
                const result = await response.json();
                if (!result.success) throw new Error(result.message || `Failed to ${action} user`);

                alert(`User has been ${action}ed successfully!`);
                window.location.reload();
            } catch (error) {
                console.error('Error:', error);
                alert(`Error ${action}ing user. Please try again.`);
            }
        });
    });

    // Modal handling
    function closeModal(modal) {
        if (modal) {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            if (modal === createUserModal && createUserForm) {
                createUserForm.reset();
            }
        }
    }

    // Create user button
    if (createUserBtn && createUserModal) {
        createUserBtn.addEventListener('click', function() {
            createUserModal.classList.remove('hidden');
            createUserModal.classList.add('flex');
        });
    }

    // Close modal handlers
    document.querySelectorAll('.close-modal').forEach(button => {
        button.addEventListener('click', function() {
            const modal = this.closest('.fixed');
            closeModal(modal);
        });
    });

    // Close modal when clicking outside
    [createUserModal, viewUserModal].forEach(modal => {
        if (modal) {
            modal.addEventListener('click', function(e) {
                if (e.target === this) {
                    closeModal(this);
                }
            });
        }
    });

    // Close modal with Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            [createUserModal, viewUserModal].forEach(modal => {
                closeModal(modal);
            });
        }
    });
});
</script>