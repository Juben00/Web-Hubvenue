<?php
require_once(__DIR__ . '/../classes/account.class.php');
$account = new Account();
$users = $account->getUser("", "");
?>
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl md:text-3xl font-semibold text-gray-800 mb-6 hidden md:block">User
        Management</h1>

    <div class="container mx-auto px-6 py-8">
        <!-- End of Create User Modal -->
        <section class="bg-white rounded-lg shadow-md p-6 mb-8">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-semibold text-gray-800">Manage Users</h2>
                <!-- Create User Button -->
                <button class="bg-primary text-white px-4 py-2 rounded hover:bg-red-700" id="createUserBtn">
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
                            <th class="py-2 px-4 text-left">Address</th>
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
                                <td class="py-2 px-4 border-b"><?= $user['address'] ?></td>
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

        <!-- Create User Modal -->
        <?php
        require_once './add-user.html';
        ?>
    </div>
</div>