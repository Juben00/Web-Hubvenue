<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#f41c1c',
                        secondary: '#F3F4F6',
                        'light-gray': '#F9FAFB',
                        'dark-gray': '#4B5563',
                    }
                }
            }
        };
    </script>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        /* Add the dark mode and other styles from Dashboard.html */
        body {
            background-image: url('bg.jpg');
            background-size: cover;
            background-attachment: fixed;
        }
        
        .topbar, .sidebar {
            background-color: rgba(255, 255, 255, 0.1) !important;
            backdrop-filter: blur(10px);
        }
        
        .dark-mode {
            background: radial-gradient(circle at left, #121212 0%, #3D0000 50%, #000000 100%);
        }
        
        .dark-mode .bg-white {
            background-color: transparent;
        }

        .dark-mode .text-gray-600,
        .dark-mode .text-gray-700,
        .dark-mode .text-gray-800 {
            color: #D1D5DB;
        }
    </style>
</head>
<body class="text-gray-800 gradient-background">
    <div class="flex h-screen">
        <?php include 'sidebar.php'; ?>
        <div class="flex-1 flex flex-col overflow-hidden">
            <?php include 'topbar.php'; ?>
            <div class="flex-1 overflow-y-auto">
                <div class="pl-32 pr-32 pt-10 pb-10 bg-gray-100 min-h-full">
                    <h1 class="text-3xl font-bold mb-6">User Management</h1>
                    
                    <div class="mb-6">
                        <div class="flex space-x-2">
                            <button id="usersTab" class="px-4 py-2 bg-red-500 text-white rounded-t-lg">All Users</button>
                            <button id="pendingTab" class="px-4 py-2 bg-gray-200 rounded-t-lg">Pending Venue Owners</button>
                        </div>
                    </div>
                    
                    <div id="usersContent">
                        <div class="flex flex-col space-y-4 mb-4">
                            <div class="flex justify-between">
                                <input id="searchInput" type="text" placeholder="Search users..." class="px-4 py-2 border rounded-lg">
                                <select id="roleFilter" class="px-4 py-2 border rounded-lg">
                                    <option value="all">All Roles</option>
                                    <option value="User">User</option>
                                    <option value="Venue Owner">Venue Owner</option>
                                </select>
                            </div>
                            <div class="flex justify-between">
                                <select id="statusFilter" class="px-4 py-2 border rounded-lg">
                                    <option value="all">All Statuses</option>
                                    <option value="Active">Active</option>
                                    <option value="Pending">Pending</option>
                                </select>
                                <div class="flex space-x-2">
                                    <input id="startDate" type="date" class="px-4 py-2 border rounded-lg">
                                    <input id="endDate" type="date" class="px-4 py-2 border rounded-lg">
                                </div>
                            </div>
                        </div>
                        
                        <table class="min-w-full bg-white">
                            <thead>
                                <tr>
                                    <th class="px-6 py-3 border-b-2 border-gray-300 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        Name
                                    </th>
                                    <th class="px-6 py-3 border-b-2 border-gray-300 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        Email
                                    </th>
                                    <th class="px-6 py-3 border-b-2 border-gray-300 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        Registration Date
                                    </th>
                                    <th class="px-6 py-3 border-b-2 border-gray-300 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        Role
                                    </th>
                                    <th class="px-6 py-3 border-b-2 border-gray-300 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        Status
                                    </th>
                                    <th class="px-6 py-3 border-b-2 border-gray-300 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody id="userTableBody">
                                <!-- User rows will be dynamically inserted here -->
                            </tbody>
                        </table>

                        <div class="flex justify-between items-center mt-4">
                            <div id="userCount"></div>
                            <div class="flex space-x-2">
                                <button id="prevButton" class="px-4 py-2 bg-blue-500 text-white rounded-lg">Previous</button>
                                <button id="nextButton" class="px-4 py-2 bg-blue-500 text-white rounded-lg">Next</button>
                            </div>
                        </div>
                    </div>
                    
                    <div id="pendingContent" class="hidden">
                        <table class="min-w-full bg-white">
                            <thead>
                                <tr>
                                    <th class="px-6 py-3 border-b-2 border-gray-300 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        Name
                                    </th>
                                    <th class="px-6 py-3 border-b-2 border-gray-300 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        Email
                                    </th>
                                    <th class="px-6 py-3 border-b-2 border-gray-300 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        Registration Date
                                    </th>
                                    <th class="px-6 py-3 border-b-2 border-gray-300 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody id="pendingTableBody">
                                <!-- Pending venue owner rows will be dynamically inserted here -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for editing user details -->
    <div id="editModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <h3 class="text-lg font-bold mb-4">Edit User</h3>
            <form id="editForm">
                <div class="mb-4">
                    <label for="editName" class="block text-sm font-medium text-gray-700">Name</label>
                    <input type="text" id="editName" name="name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                </div>
                <div class="mb-4">
                    <label for="editEmail" class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" id="editEmail" name="email" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                </div>
                <div class="mb-4">
                    <label for="editRole" class="block text-sm font-medium text-gray-700">Role</label>
                    <select id="editRole" name="role" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        <option value="User">User</option>
                        <option value="Venue Owner">Venue Owner</option>
                    </select>
                </div>
                <div class="mb-4">
                    <label for="editStatus" class="block text-sm font-medium text-gray-700">Status</label>
                    <select id="editStatus" name="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        <option value="Active">Active</option>
                        <option value="Pending">Pending</option>
                    </select>
                </div>
                <div class="flex justify-end">
                    <button type="button" id="cancelEdit" class="mr-2 px-4 py-2 bg-gray-300 text-gray-800 rounded-lg">Cancel</button>
                    <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-lg">Save changes</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal for viewing supporting documents -->
    <div id="documentsModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden">
        <div class="relative top-20 mx-auto p-5 border w-3/4 shadow-lg rounded-md bg-white">
            <h3 class="text-lg font-bold mb-4">Supporting Documents</h3>
            <div class="flex space-x-4 mb-4">
                <button id="idTab" class="px-4 py-2 bg-blue-500 text-white rounded-t-lg">ID</button>
                <button id="utilityTab" class="px-4 py-2 bg-gray-200 rounded-t-lg">Utility Bill</button>
                <button id="photosTab" class="px-4 py-2 bg-gray-200 rounded-t-lg">Venue Photos</button>
                <button id="linksTab" class="px-4 py-2 bg-gray-200 rounded-t-lg">Social Media & Website</button>
            </div>
            <div id="idContent">
                <h4 class="text-md font-semibold mb-2">Government-Issued ID</h4>
                <img id="idImage" src="" alt="Government-Issued ID" class="max-w-full h-auto rounded-md">
            </div>
            <div id="utilityContent" class="hidden">
                <h4 class="text-md font-semibold mb-2">Utility Bill or Property Document</h4>
                <img id="utilityImage" src="" alt="Utility Bill or Property Document" class="max-w-full h-auto rounded-md">
            </div>
            <div id="photosContent" class="hidden">
                <h4 class="text-md font-semibold mb-2">Venue Photographs</h4>
                <div id="venuePhotos" class="grid grid-cols-3 gap-4">
                    <!-- Venue photos will be dynamically inserted here -->
                </div>
            </div>
            <div id="linksContent" class="hidden">
                <h4 class="text-md font-semibold mb-2">Social Media & Website Links</h4>
                <ul id="socialLinks" class="list-disc pl-5">
                    <!-- Social media and website links will be dynamically inserted here -->
                </ul>
            </div>
            <div class="flex justify-end mt-4">
                <button id="closeDocuments" class="px-4 py-2 bg-gray-300 text-gray-800 rounded-lg">Close</button>
            </div>
        </div>
    </div>
           
    <script>
        // Mock data for users
        const users = Array.from({ length: 100 }, (_, i) => ({
            id: i + 1,
            name: `User ${i + 1}`,
            email: `user${i + 1}@example.com`,
            registrationDate: new Date(2023, 0, 1 + i).toISOString().split('T')[0],
            role: i % 3 === 0 ? 'Venue Owner' : 'User',
            status: i % 5 === 0 ? 'Pending' : 'Active',
            supportingDocuments: i % 3 === 0 ? {
                governmentId: 'https://via.placeholder.com/400x300.png?text=Government+ID',
                utilityBill: 'https://via.placeholder.com/400x300.png?text=Utility+Bill',
                venuePhotos: [
                    'https://via.placeholder.com/300x200.png?text=Venue+Photo+1',
                    'https://via.placeholder.com/300x200.png?text=Venue+Photo+2',
                    'https://via.placeholder.com/300x200.png?text=Venue+Photo+3'
                ],
                socialMediaLinks: [
                    'https://facebook.com/venue' + (i + 1),
                    'https://instagram.com/venue' + (i + 1)
                ],
                website: 'https://venue' + (i + 1) + '.com'
            } : null
        }));

        let currentPage = 1;
        const itemsPerPage = 10;
        let filteredUsers = [...users];

        function renderUsers() {
            const startIndex = (currentPage - 1) * itemsPerPage;
            const endIndex = startIndex + itemsPerPage;
            const tableBody = document.getElementById('userTableBody');
            tableBody.innerHTML = '';

            filteredUsers.slice(startIndex, endIndex).forEach(user => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td class="px-6 py-4 whitespace-nowrap">${user.name}</td>
                    <td class="px-6 py-4 whitespace-nowrap">${user.email}</td>
                    <td class="px-6 py-4 whitespace-nowrap">${user.registrationDate}</td>
                    <td class="px-6 py-4 whitespace-nowrap">${user.role}</td>
                    <td class="px-6 py-4 whitespace-nowrap">${user.status}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <button class="viewBtn px-2 py-1 bg-blue-500 text-white rounded-lg mr-2" data-id="${user.id}">View</button>
                        <button class="editBtn px-2 py-1 bg-green-500 text-white rounded-lg mr-2" data-id="${user.id}">Edit</button>
                        <button class="deleteBtn px-2 py-1 bg-red-500 text-white rounded-lg" data-id="${user.id}">Delete</button>
                    </td>
                `;
                tableBody.appendChild(row);
            });

            document.getElementById('userCount').textContent = `Showing ${startIndex + 1} to ${Math.min(endIndex, filteredUsers.length)} of ${filteredUsers.length} users`;
            document.getElementById('prevButton').disabled = currentPage === 1;
            document.getElementById('nextButton').disabled = endIndex >= filteredUsers.length;
        }

        function renderPendingVenueOwners() {
            const pendingUsers = users.filter(user => user.status === 'Pending' && user.role === 'Venue Owner');
            const tableBody = document.getElementById('pendingTableBody');
            tableBody.innerHTML = '';

            pendingUsers.forEach(user => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td class="px-6 py-4 whitespace-nowrap">${user.name}</td>
                    <td class="px-6  py-4 whitespace-nowrap">${user.email}</td>
                    <td class="px-6 py-4 whitespace-nowrap">${user.registrationDate}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <button class="approveBtn px-2 py-1 bg-green-500 text-white rounded-lg mr-2" data-id="${user.id}">Approve</button>
                        <button class="rejectBtn px-2 py-1 bg-red-500 text-white rounded-lg mr-2" data-id="${user.id}">Reject</button>
                        <button class="viewDocumentsBtn px-2 py-1 bg-blue-500 text-white rounded-lg" data-id="${user.id}">View Documents</button>
                    </td>
                `;
                tableBody.appendChild(row);
            });
        }

        function filterUsers() {
            const searchTerm = document.getElementById('searchInput').value.toLowerCase();
            const roleFilter = document.getElementById('roleFilter').value;
            const statusFilter = document.getElementById('statusFilter').value;
            const startDate = document.getElementById('startDate').value;
            const endDate = document.getElementById('endDate').value;

            filteredUsers = users.filter(user => 
                (user.name.toLowerCase().includes(searchTerm) || user.email.toLowerCase().includes(searchTerm)) &&
                (roleFilter === 'all' || user.role === roleFilter) &&
                (statusFilter === 'all' || user.status === statusFilter) &&
                (!startDate || user.registrationDate >= startDate) &&
                (!endDate || user.registrationDate <= endDate)
            );

            currentPage = 1;
            renderUsers();
        }

        document.getElementById('searchInput').addEventListener('input', filterUsers);
        document.getElementById('roleFilter').addEventListener('change', filterUsers);
        document.getElementById('statusFilter').addEventListener('change', filterUsers);
        document.getElementById('startDate').addEventListener('change', filterUsers);
        document.getElementById('endDate').addEventListener('change', filterUsers);

        document.getElementById('prevButton').addEventListener('click', () => {
            if (currentPage > 1) {
                currentPage--;
                renderUsers();
            }
        });

        document.getElementById('nextButton').addEventListener('click', () => {
            if (currentPage * itemsPerPage < filteredUsers.length) {
                currentPage++;
                renderUsers();
            }
        });

        document.getElementById('usersTab').addEventListener('click', () => {
            document.getElementById('usersContent').classList.remove('hidden');
            document.getElementById('pendingContent').classList.add('hidden');
            document.getElementById('usersTab').classList.add('bg-red-500', 'text-white');
            document.getElementById('usersTab').classList.remove('bg-gray-200');
            document.getElementById('pendingTab').classList.add('bg-gray-200');
            document.getElementById('pendingTab').classList.remove('bg-red-500', 'text-white');
        });

        document.getElementById('pendingTab').addEventListener('click', () => {
            document.getElementById('usersContent').classList.add('hidden');
            document.getElementById('pendingContent').classList.remove('hidden');
            document.getElementById('pendingTab').classList.add('bg-red-500', 'text-white');
            document.getElementById('pendingTab').classList.remove('bg-gray-200');
            document.getElementById('usersTab').classList.add('bg-gray-200');
            document.getElementById('usersTab').classList.remove('bg-red-500', 'text-white');
            renderPendingVenueOwners();
        });

        document.getElementById('userTableBody').addEventListener('click', (e) => {
            if (e.target.classList.contains('viewBtn')) {
                const userId = e.target.getAttribute('data-id');
                const user = users.find(u => u.id === parseInt(userId));
                alert(`Viewing user: ${user.name}`);
            } else if (e.target.classList.contains('editBtn')) {
                const userId = e.target.getAttribute('data-id');
                const user = users.find(u => u.id === parseInt(userId));
                document.getElementById('editName').value = user.name;
                document.getElementById('editEmail').value = user.email;
                document.getElementById('editRole').value = user.role;
                document.getElementById('editStatus').value = user.status;
                document.getElementById('editModal').classList.remove('hidden');
            } else if (e.target.classList.contains('deleteBtn')) {
                const userId = e.target.getAttribute('data-id');
                if (confirm('Are you sure you want to delete this user?')) {
                    const index = users.findIndex(u => u.id === parseInt(userId));
                    if (index !== -1) {
                        users.splice(index, 1);
                        filterUsers();
                    }
                }
            }
        });

        document.getElementById('pendingTableBody').addEventListener('click', (e) => {
            if (e.target.classList.contains('approveBtn')) {
                const userId = e.target.getAttribute('data-id');
                const user = users.find(u => u.id === parseInt(userId));
                if (confirm(`Are you sure you want to approve ${user.name} as a venue owner?`)) {
                    user.status = 'Active';
                    renderPendingVenueOwners();
                }
            } else if (e.target.classList.contains('rejectBtn')) {
                const userId = e.target.getAttribute('data-id');
                const user = users.find(u => u.id === parseInt(userId));
                if (confirm(`Are you sure you want to reject ${user.name}'s application?`)) {
                    user.role = 'User';
                    user.status = 'Active';
                    renderPendingVenueOwners();
                }
            } else if (e.target.classList.contains('viewDocumentsBtn')) {
                const userId = e.target.getAttribute('data-id');
                const user = users.find(u => u.id === parseInt(userId));
                showDocumentsModal(user);
            }
        });

        document.getElementById('cancelEdit').addEventListener('click', () => {
            document.getElementById('editModal').classList.add('hidden');
        });

        document.getElementById('editForm').addEventListener('submit', (e) => {
            e.preventDefault();
            const name = document.getElementById('editName').value;
            const email = document.getElementById('editEmail').value;
            const role = document.getElementById('editRole').value;
            const status = document.getElementById('editStatus').value;
            // In a real application, you would send this data to the server
            console.log('Updated user:', { name, email, role, status });
            document.getElementById('editModal').classList.add('hidden');
            filterUsers();
        });

        function showDocumentsModal(user) {
            const modal = document.getElementById('documentsModal');
            const idImage = document.getElementById('idImage');
            const utilityImage = document.getElementById('utilityImage');
            const venuePhotos = document.getElementById('venuePhotos');
            const socialLinks = document.getElementById('socialLinks');

            idImage.src = user.supportingDocuments.governmentId;
            utilityImage.src = user.supportingDocuments.utilityBill;

            venuePhotos.innerHTML = '';
            user.supportingDocuments.venuePhotos.forEach(photo => {
                const img = document.createElement('img');
                img.src = photo;
                img.alt = 'Venue Photo';
                img.className = 'w-full h-auto rounded-md';
                venuePhotos.appendChild(img);
            });

            socialLinks.innerHTML = '';
            user.supportingDocuments.socialMediaLinks.forEach(link => {
                const li = document.createElement('li');
                const a = document.createElement('a');
                a.href = link;
                a.textContent = link;
                a.target = '_blank';
                a.rel = 'noopener noreferrer';
                a.className = 'text-blue-500 hover:underline';
                li.appendChild(a);
                socialLinks.appendChild(li);
            });

            const websiteLi = document.createElement('li');
            const websiteA = document.createElement('a');
            websiteA.href = user.supportingDocuments.website;
            websiteA.textContent = user.supportingDocuments.website;
            websiteA.target = '_blank';
            websiteA.rel = 'noopener noreferrer';
            websiteA.className = 'text-blue-500 hover:underline';
            websiteLi.appendChild(websiteA);
            socialLinks.appendChild(websiteLi);

            modal.classList.remove('hidden');
        }

        document.getElementById('closeDocuments').addEventListener('click', () => {
            document.getElementById('documentsModal').classList.add('hidden');
        });

        document.getElementById('idTab').addEventListener('click', () => {
            document.getElementById('idContent').classList.remove('hidden');
            document.getElementById('utilityContent').classList.add('hidden');
            document.getElementById('photosContent').classList.add('hidden');
            document.getElementById('linksContent').classList.add('hidden');
            document.getElementById('idTab').classList.add('bg-blue-500', 'text-white');
            document.getElementById('idTab').classList.remove('bg-gray-200');
            document.getElementById('utilityTab').classList.add('bg-gray-200');
            document.getElementById('utilityTab').classList.remove('bg-blue-500', 'text-white');
            document.getElementById('photosTab').classList.add('bg-gray-200');
            document.getElementById('photosTab').classList.remove('bg-blue-500', 'text-white');
            document.getElementById('linksTab').classList.add('bg-gray-200');
            document.getElementById('linksTab').classList.remove('bg-blue-500', 'text-white');
        });

        document.getElementById('utilityTab').addEventListener('click', () => {
            document.getElementById('idContent').classList.add('hidden');
            document.getElementById('utilityContent').classList.remove('hidden');
            document.getElementById('photosContent').classList.add('hidden');
            document.getElementById('linksContent').classList.add('hidden');
            document.getElementById('utilityTab').classList.add('bg-blue-500', 'text-white');
            document.getElementById('utilityTab').classList.remove('bg-gray-200');
            document.getElementById('idTab').classList.add('bg-gray-200');
            document.getElementById('idTab').classList.remove('bg-blue-500', 'text-white');
            document.getElementById('photosTab').classList.add('bg-gray-200');
            document.getElementById('photosTab').classList.remove('bg-blue-500', 'text-white');
            document.getElementById('linksTab').classList.add('bg-gray-200');
            document.getElementById('linksTab').classList.remove('bg-blue-500', 'text-white');
        });

        document.getElementById('photosTab').addEventListener('click', () => {
            document.getElementById('idContent').classList.add('hidden');
            document.getElementById('utilityContent').classList.add('hidden');
            document.getElementById('photosContent').classList.remove('hidden');
            document.getElementById('linksContent').classList.add('hidden');
            document.getElementById('photosTab').classList.add('bg-blue-500', 'text-white');
            document.getElementById('photosTab').classList.remove('bg-gray-200');
            document.getElementById('idTab').classList.add('bg-gray-200');
            document.getElementById('idTab').classList.remove('bg-blue-500', 'text-white');
            document.getElementById('utilityTab').classList.add('bg-gray-200');
            document.getElementById('utilityTab').classList.remove('bg-blue-500', 'text-white');
            document.getElementById('linksTab').classList.add('bg-gray-200');
            document.getElementById('linksTab').classList.remove('bg-blue-500', 'text-white');
        });

        document.getElementById('linksTab').addEventListener('click', () => {
            document.getElementById('idContent').classList.add('hidden');
            document.getElementById('utilityContent').classList.add('hidden');
            document.getElementById('photosContent').classList.add('hidden');
            document.getElementById('linksContent').classList.remove('hidden');
            document.getElementById('linksTab').classList.add('bg-blue-500', 'text-white');
            document.getElementById('linksTab').classList.remove('bg-gray-200');
            document.getElementById('idTab').classList.add('bg-gray-200');
            document.getElementById('idTab').classList.remove('bg-blue-500', 'text-white');
            document.getElementById('utilityTab').classList.add('bg-gray-200');
            document.getElementById('utilityTab').classList.remove('bg-blue-500', 'text-white');
            document.getElementById('photosTab').classList.add('bg-gray-200');
            document.getElementById('photosTab').classList.remove('bg-blue-500', 'text-white');
        });

        // Initial render
        renderUsers();
    </script>
</body>
</html>


