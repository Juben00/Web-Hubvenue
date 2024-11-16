<?php
require_once(__DIR__ . '/../classes/account.class.php');
$account = new Account();
$users = $account->getHostApplications("", "");
?>
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl md:text-3xl font-semibold text-gray-800 mb-6 hidden md:block">Host Applications</h1>

    <div class="container mx-auto px-6 py-8">
        <!-- Create User Modal -->
        <!-- End of Create User Modal -->
        <section class="bg-white rounded-lg shadow-md p-6 mb-8">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-semibold text-gray-800">Manage Host Applications</h2>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="py-2 px-4 text-left">User ID</th>
                            <th class="py-2 px-4 text-left">FullName</th>
                            <th class="py-2 px-4 text-left">Address</th>
                            <th class="py-2 px-4 text-left">Birthdate</th>
                            <th class="py-2 px-4 text-left">Identification Cards</th>
                            <th class="py-2 px-4 text-left">Status</th>
                            <th class="py-2 px-4 text-left">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="userTable">
                        <?php foreach ($users as $user): ?>
                            <tr>
                                <td class="py-2 px-4 border-b"><?= $user['userId'] ?></td>
                                <td class="py-2 px-4 border-b"><?= $user['fullname'] ?></td>
                                <td class="py-2 px-4 border-b"><?= $user['address'] ?></td>
                                <td class="py-2 px-4 border-b"><?= $user['birthdate'] ?></td>
                                <td class="py-2 px-4 border-b">
                                    <?php if (!empty($user['idOne'])): ?>
                                        <a href="../<?= htmlspecialchars($user['idOne']) ?>" target="_blank">
                                            <img src="../<?= htmlspecialchars($user['idOne']) ?>" alt="Id card"
                                                class="w-16 h-16 object-cover mr-2 mb-2 border-2">
                                        </a>
                                    <?php endif; ?>
                                    <?php if (!empty($user['idTwo'])): ?>
                                        <a href="../<?= htmlspecialchars($user['idTwo']) ?>" target="_blank">
                                            <img src="../<?= htmlspecialchars($user['idTwo']) ?>" alt="Id card"
                                                class="w-16 h-16 object-cover mr-2 mb-2 border-2">
                                        </a>
                                    <?php endif; ?>
                                </td>
                                <td class="py-2 px-4 border-b"><?= $user['status'] ?></td>
                                <td class="py-2 px-4 border-b">
                                    <?php
                                    if ($user['status'] === 'Approved') {
                                        echo '<form class="rejectHostApplication" method="POST">
                                                <input type="hidden" name="host_id" value="' . htmlspecialchars($user['userId']) . '">
                                                <button type="submit"
                                                    class="inline-flex w-20 m-1 items-center justify-center rounded-md text-sm font-medium bg-red-500 text-white hover:bg-blue-600 h-9 px-3 mr-2">Reject</button>
                                            </form>';
                                    } else {
                                        echo '<form class="approveHostApplication" method="POST">
                                                <input type="hidden" name="host_id" value="' . htmlspecialchars($user['userId']) . '">
                                                <button type="submit"
                                                    class="inline-flex w-20 m-1 items-center justify-center rounded-md text-sm font-medium bg-blue-500 text-white hover:bg-blue-600 h-9 px-3 mr-2">Approve</button>
                                            </form>';
                                    }
                                    ?>

                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </section>
    </div>
</div>