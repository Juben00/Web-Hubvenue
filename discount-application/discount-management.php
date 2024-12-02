<?php
require_once(__DIR__ . '/../classes/account.class.php');
$account = new Account();
$discountApplications = $account->getDiscountApplications("", ""); // You'll need to add this method to your account class
?>
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl md:text-3xl font-semibold text-gray-800 mb-6 hidden md:block">Discount Applications</h1>

    <div class="container mx-auto px-6 py-8">
        <section class="bg-white rounded-lg shadow-md p-6 mb-8">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-semibold text-gray-800">Manage Discount Applications</h2>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="py-2 px-4 text-left">User ID</th>
                            <th class="py-2 px-4 text-left">Discount Type</th>
                            <th class="py-2 px-4 text-left">ID Holder's Name</th>
                            <th class="py-2 px-4 text-left">ID Number</th>
                            <th class="py-2 px-4 text-left">ID Photo</th>
                            <th class="py-2 px-4 text-left">Status</th>
                            <th class="py-2 px-4 text-left">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="discountApplicationTable">
                        <?php foreach ($discountApplications as $application): ?>
                            <tr>
                                <td class="py-2 px-4 border-b"><?= $application['userId'] ?></td>
                                <td class="py-2 px-4 border-b"><?= $application['discount_type'] ?></td>
                                <td class="py-2 px-4 border-b"><?= $application['id_holder_name'] ?></td>
                                <td class="py-2 px-4 border-b"><?= $application['id_number'] ?></td>
                                <td class="py-2 px-4 border-b">
                                    <?php if (!empty($application['id_photo'])): ?>
                                        <a href="../<?= htmlspecialchars($application['id_photo']) ?>" target="_blank">
                                            <img src="../<?= htmlspecialchars($application['id_photo']) ?>" 
                                                alt="ID Photo"
                                                class="w-16 h-16 object-cover mr-2 mb-2 border-2">
                                        </a>
                                    <?php endif; ?>
                                </td>
                                <td class="py-2 px-4 border-b"><?= $application['status'] ?></td>
                                <td class="py-2 px-4 border-b">
                                    <?php
                                    if ($application['status'] === 'Active') {
                                        echo '<form class="rejectDiscountApplication" method="POST">
                                                <input type="hidden" name="application_id" value="' . htmlspecialchars($application['id']) . '">
                                                <button type="submit"
                                                    class="inline-flex w-20 m-1 items-center justify-center rounded-md text-sm font-medium bg-red-500 text-white hover:bg-red-600 h-9 px-3 mr-2">Reject</button>
                                            </form>';
                                    } else {
                                        echo '<form class="approveDiscountApplication" method="POST">
                                                <input type="hidden" name="application_id" value="' . htmlspecialchars($application['id']) . '">
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

<script src="../vendor/jQuery-3.7.1/jquery-3.7.1.min.js"></script>
<script>
$(document).ready(function() {
    // Handle approve discount application
    $('.approveDiscountApplication').on('submit', function(e) {
        e.preventDefault();
        const applicationId = $(this).find('input[name="application_id"]').val();
        
        $.ajax({
            url: '../api/ApproveDiscount.api.php',
            type: 'POST',
            data: { application_id: applicationId },
            success: function(response) {
                if(response.success) {
                    location.reload();
                } else {
                    alert('Failed to approve discount application');
                }
            },
            error: function() {
                alert('Error processing request');
            }
        });
    });

    // Handle reject discount application
    $('.rejectDiscountApplication').on('submit', function(e) {
        e.preventDefault();
        const applicationId = $(this).find('input[name="application_id"]').val();
        
        $.ajax({
            url: '../api/RejectDiscount.api.php',
            type: 'POST',
            data: { application_id: applicationId },
            success: function(response) {
                if(response.success) {
                    location.reload();
                } else {
                    alert('Failed to reject discount application');
                }
            },
            error: function() {
                alert('Error processing request');
            }
        });
    });
});
</script>
