<?php
require_once '../classes/venue.class.php';
require_once '../classes/account.class.php';
$venueObj = new Venue();
$accountObj = new Account();

// Get check-out bookings using the new method
$Reservations = $venueObj->getAdminBookings('checkout');

// Filter for checked-in bookings that haven't checked out yet
$Reservations = array_filter($Reservations, function ($booking) {
    return isset($booking['booking_status_id']) &&
        isset($booking['booking_checkin_status']) &&
        isset($booking['booking_checkout_status']) &&
        $booking['booking_status_id'] == 2 &&
        $booking['booking_checkin_status'] == 'Checked-In' &&
        $booking['booking_checkout_status'] == 'Pending';
});

function formatDate($date)
{
    return date('F d, Y', strtotime($date));
}

function formatPrice($price)
{
    return '₱' . number_format($price, 2);
}
?>

<!-- Search and Filter Section -->
<section class="bg-white rounded-lg shadow-md p-4 mb-8">
    <h2 class="text-xl font-semibold text-gray-800 mb-4">Search and Filter Check-Outs</h2>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Date Range</label>
            <div class="flex gap-2">
                <input type="date" id="startDate" class="border rounded p-2 w-full" placeholder="Start Date">
                <input type="date" id="endDate" class="border rounded p-2 w-full" placeholder="End Date">
            </div>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Venue</label>
            <input type="text" id="venueFilter" class="border rounded p-2 w-full" placeholder="Filter by venue name">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Customer</label>
            <input type="text" id="customerFilter" class="border rounded p-2 w-full"
                placeholder="Filter by customer name">
        </div>
    </div>
    <div class="flex items-center gap-2">
        <button id="applyFilters" class="bg-red-600 text-white py-2 px-4 rounded hover:bg-red-700 transition-colors">
            Apply Filters
        </button>
        <button id="clearFilters"
            class="border border-gray-300 bg-white text-gray-700 py-2 px-4 rounded hover:bg-gray-100 transition-colors">
            Clear
        </button>
    </div>
</section>

<!-- Check-Out Table -->
<section class="bg-white rounded-lg shadow-md p-4 mb-8">
    <h2 class="text-xl font-semibold text-gray-800 mb-4">Pending Check-Outs</h2>
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white">
            <thead class="bg-gray-100">
                <tr>
                    <th class="py-2 px-4 text-left">Book Date</th>
                    <th class="py-2 px-4 text-left">Start Date</th>
                    <th class="py-2 px-4 text-left">End Date</th>
                    <th class="py-2 px-4 text-left">Guest Name</th>
                    <th class="py-2 px-4 text-left">Contact</th>
                    <th class="py-2 px-4 text-left">Venue</th>
                    <th class="py-2 px-4 text-left">Check-In Date</th>
                    <th class="py-2 px-4 text-left">Check-Out Status</th>
                    <th class="py-2 px-4 text-left">Additional Charges</th>
                    <th class="py-2 px-4 text-left">Actions</th>
                </tr>
            </thead>
            <tbody id="reservationsTable">
                <?php
                if (!empty($Reservations)) {
                    foreach ($Reservations as $reservation) {
                        // Get additional charges if any
                        $additional_charges = $venueObj->getBookingCharges($reservation['booking_id']);
                        $total_charges = 0;
                        if (!empty($additional_charges)) {
                            foreach ($additional_charges as $charge) {
                                $total_charges += isset($charge['cost']) ? floatval($charge['cost']) : 0;
                            }
                        }
                        ?>
                                <tr>
                                    <td class="py-2 px-4"><?php echo formatDate($reservation['booking_created_at']); ?></td>
                                    <td class="py-2 px-4"><?php echo formatDate($reservation['booking_start_datetime']); ?></td>
                                    <td class="py-2 px-4"><?php echo formatDate($reservation['booking_end_datetime']); ?></td>
                                    <td class="py-2 px-4"><?php echo $reservation['guest_name']; ?></td>
                                    <td class="py-2 px-4"><?php echo $reservation['guest_contact_number']; ?></td>
                                    <td class="py-2 px-4"><?php echo $reservation['venue_name']; ?></td>
                                    <td class="py-2 px-4"><?php echo formatDate($reservation['booking_checkin_date']); ?></td>
                                    <td class="py-2 px-4">
                                        <span class=" rounded-full px-2">Pending Check-Out</span>
                                    </td>
                                    <td class="py-2 px-4">
                                        <?php if ($total_charges > 0): ?>
                                                <span class="text-red-600 font-semibold"><?php echo formatPrice($total_charges); ?></span>
                                                <button onclick="viewCharges(<?php echo $reservation['booking_id']; ?>)"
                                                    class="text-blue-600 hover:text-blue-800 underline ml-2">
                                                    View Details
                                                </button>
                                        <?php else: ?>
                                                None
                                        <?php endif; ?>
                                    </td>
                                    <td class="py-2 px-4">
                                        <button onclick="addCharge(<?php echo $reservation['booking_id']; ?>)"
                                            class="text-blue-500  font-bold py-1 px-3 rounded mb-1">
                                            Add Charge
                                        </button>
                                        <form class="checkOutButton inline-block" method="POST">
                                            <input type="hidden" name="booking_id" value="<?php echo $reservation['booking_id']; ?>">
                                            <button type="submit" class="text-green-500 font-bold py-1 px-3 rounded">
                                                Check Out
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                <?php
                    }
                } else {
                    ?>
                        <tr>
                            <td colspan="10" class="py-4 text-center">No pending check-outs found</td>
                        </tr>
                        <?php
                }
                ?>
            </tbody>
        </table>
    </div>
</section>

<!-- Add Charge Modal -->
<div id="addChargeModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Add Additional Charge</h3>
            <form id="addChargeForm">
                <input type="hidden" id="chargeBookingId" name="booking_id">
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Item</label>
                    <input type="text" name="item" class="border rounded p-2 w-full" required>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                    <textarea name="description" class="border rounded p-2 w-full" rows="3"></textarea>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Cost</label>
                    <input type="number" name="cost" class="border rounded p-2 w-full" step="0.01" required>
                </div>
                <div class="flex justify-end gap-2">
                    <button type="button" onclick="closeAddChargeModal()"
                        class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Cancel</button>
                    <button type="submit"
                        class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Add</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- View Charges Modal -->
<div id="viewChargesModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Additional Charges</h3>
            <div id="chargesList" class="mb-4">
                <!-- Charges will be loaded here -->
            </div>
            <div class="flex justify-end">
                <button onclick="closeViewChargesModal()"
                    class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        // Handle filter functionality
        $('#applyFilters').click(function () {
            applyFilters();
        });

        // Handle clear filters
        $('#clearFilters').click(function () {
            // Clear all inputs
            $('#startDate, #endDate, #venueFilter, #customerFilter').val('');
            // Show all rows except header
            $('#reservationsTable tr:not(:first)').show();
            $('#noResultsRow').remove();
        });

        // Handle check-out
        $('.checkOutButton').on("submit", function (e) {
            e.preventDefault();
            const formData = $(this).serialize();

            confirmshowModal(
                "Are you sure you want to check out this guest?",
                function () {
                    $.ajax({
                        type: "POST",
                        url: "../api/checkOutBooking.api.php",
                        data: formData,
                        dataType: 'json',
                        success: function (response) {
                            if (response.status === "success") {
                                showFeedbackModal("Success!", response.message, "success");
                                setTimeout(function () {
                                    location.reload();
                                }, 2000);
                            } else {
                                showFeedbackModal("Error!", response.message, "error");
                            }
                        },
                        error: function () {
                            showFeedbackModal("Error!", "Something went wrong. Please try again.", "error");
                        }
                    });
                }
            );
        });

        // Handle add charge form submission
        $('#addChargeForm').on("submit", function (e) {
            e.preventDefault();
            const formData = $(this).serialize();

            $.ajax({
                type: "POST",
                url: "../api/addBookingCharge.api.php",
                data: formData,
                dataType: 'json',
                success: function (response) {
                    if (response.status === "success") {
                        showFeedbackModal("Success!", response.message, "success");
                        closeAddChargeModal();
                        setTimeout(function () {
                            location.reload();
                        }, 2000);
                    } else {
                        showFeedbackModal("Error!", response.message, "error");
                    }
                },
                error: function () {
                    showFeedbackModal("Error!", "Something went wrong. Please try again.", "error");
                }
            });
        });
    });

    function applyFilters() {
        const startDate = $('#startDate').val();
        const endDate = $('#endDate').val();
        const venue = $('#venueFilter').val().toLowerCase();
        const customer = $('#customerFilter').val().toLowerCase();

        // Hide the "No results" row if it exists
        $('#noResultsRow').remove();

        // Get all rows except the header row
        const rows = $('#reservationsTable tr:not(:first)');

        rows.each(function () {
            const row = $(this);
            // Skip the "No results" row if it exists
            if (row.attr('id') === 'noResultsRow') return;

            const rowStartDate = new Date(row.find('td:eq(1)').text()).getTime();
            const rowEndDate = new Date(row.find('td:eq(2)').text()).getTime();
            const rowVenue = row.find('td:eq(5)').text().toLowerCase();
            const rowCustomer = row.find('td:eq(3)').text().toLowerCase();

            let showRow = true;

            // Date range filter
            if (startDate && endDate) {
                const filterStartTimestamp = new Date(startDate).getTime();
                const filterEndTimestamp = new Date(endDate).getTime();

                if (rowStartDate < filterStartTimestamp || rowEndDate > filterEndTimestamp) {
                    showRow = false;
                }
            }

            // Venue filter
            if (venue && !rowVenue.includes(venue)) {
                showRow = false;
            }

            // Customer filter
            if (customer && !rowCustomer.includes(customer)) {
                showRow = false;
            }

            row.toggle(showRow);
        });

        // Show "No results found" if all rows are hidden
        if ($('#reservationsTable tr:visible').length === 1) { // Only header row is visible
            $('#reservationsTable').append(
                '<tr id="noResultsRow"><td colspan="10" class="py-4 text-center">No results found</td></tr>'
            );
        }
    }

    function addCharge(bookingId) {
        $('#chargeBookingId').val(bookingId);
        $('#addChargeModal').removeClass('hidden');
    }

    function closeAddChargeModal() {
        $('#addChargeModal').addClass('hidden');
        $('#addChargeForm')[0].reset();
    }

    function viewCharges(bookingId) {
        $.ajax({
            type: "GET",
            url: "../api/getBookingCharges.api.php",
            data: { booking_id: bookingId },
            dataType: 'json',
            success: function (response) {
                if (response.status === "success") {
                    let chargesHtml = '<div class="space-y-4">';
                    response.charges.forEach(charge => {
                        chargesHtml += `
                            <div class="border-b pb-4">
                                <div class="font-semibold">${charge.item}</div>
                                <div class="text-sm text-gray-600">${charge.description || 'No description'}</div>
                                <div class="text-red-600 font-medium">₱${parseFloat(charge.cost).toFixed(2)}</div>
                            </div>
                        `;
                    });
                    chargesHtml += '</div>';
                    $('#chargesList').html(chargesHtml);
                    $('#viewChargesModal').removeClass('hidden');
                } else {
                    showFeedbackModal("Error!", response.message, "error");
                }
            },
            error: function () {
                showFeedbackModal("Error!", "Something went wrong. Please try again.", "error");
            }
        });
    }

    function closeViewChargesModal() {
        $('#viewChargesModal').addClass('hidden');
    }
</script>