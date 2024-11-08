<?php
require_once(__DIR__ . '/../classes/account.class.php');
$account = new Account();
$users = $account->getUser("", "");
?>
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl md:text-3xl font-semibold text-gray-800 mb-6 hidden md:block">User
        Management</h1>

    <div class="container mx-auto px-6 py-8">
        <!-- Create User Modal -->
        <div id="createUserModal" class="fixed inset-0 bg-gray-800 bg-opacity-50 items-center justify-center hidden">
            <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-md">
                <h2 class="text-xl font-semibold mb-4">Create New User</h2>
                <form id="createUserForm">
                    <div class="mb-4">
                        <label for="userName" class="block text-gray-700">Name</label>
                        <input type="text" id="userName" class="w-full p-2 border rounded" required>
                    </div>
                    <div class="mb-4">
                        <label for="userEmail" class="block text-gray-700">Email</label>
                        <input type="email" id="userEmail" class="w-full p-2 border rounded" required>
                    </div>
                    <div class="mb-4">
                        <label for="userPassword" class="block text-gray-700">Password</label>
                        <input type="password" id="userPassword" class="w-full p-2 border rounded" required>
                    </div>
                    <div class="mb-4">
                        <label for="userRole" class="block text-gray-700">Role</label>
                        <select id="userRole" class="w-full p-2 border rounded">
                            <option value="Admin">Admin</option>
                            <option value="User">Client</option>
                            <option value="User">User</option>
                        </select>
                    </div>
                    <div class="flex justify-end">
                        <button type="button" class="bg-gray-500 text-white px-4 py-2 rounded mr-2"
                            onclick="closeCreateUserModal()">Cancel</button>
                        <button type="submit" class="bg-primary text-white px-4 py-2 rounded">Create</button>
                    </div>
                </form>
            </div>
        </div>
        <!-- End of Create User Modal -->
        <section class="bg-white rounded-lg shadow-md p-6 mb-8">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-semibold text-gray-800">Manage Users</h2>
                <!-- Create User Button -->
                <button class="bg-primary text-white px-4 py-2 rounded hover:bg-red-700"
                    onclick="openCreateUserModal()">
                    Create User
                </button>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="py-2 px-4 text-left">User ID</th>
                            <th class="py-2 px-4 text-left">First Name</th>
                            <th class="py-2 px-4 text-left">M.I</th>
                            <th class="py-2 px-4 text-left">Last Name</th>
                            <th class="py-2 px-4 text-left">Sex</th>
                            <th class="py-2 px-4 text-left">Role</th>
                            <th class="py-2 px-4 text-left">Birthdate</th>
                            <th class="py-2 px-4 text-left">Contact Number</th>
                            <th class="py-2 px-4 text-left">Email</th>
                            <th class="py-2 px-4 text-left">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="userTable">
                        <?php foreach ($users as $user): ?>
                            <tr>
                                <td class="py-2 px-4 border-b"><?= $user['id'] ?></td>
                                <td class="py-2 px-4 border-b"><?= $user['firstname'] ?></td>
                                <td class="py-2 px-4 border-b"><?= $user['middlename'] ?></td>
                                <td class="py-2 px-4 border-b"><?= $user['lastname'] ?></td>
                                <td class="py-2 px-4 border-b"><?= $user['sex'] ?></td>
                                <td class="py-2 px-4 border-b"><?= $user['user_type'] ?></td>
                                <td class="py-2 px-4 border-b"><?= $user['birthdate'] ?></td>
                                <td class="py-2 px-4 border-b"><?= $user['contact_number'] ?></td>
                                <td class="py-2 px-4 border-b"><?= $user['email'] ?></td>
                                <td class="py-2 px-4 border-b">
                                    <button class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-red-700">
                                        Restrict
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </section>
    </div>
</div>