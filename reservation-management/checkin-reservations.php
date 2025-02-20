<?php
require_once '../classes/venue.class.php';
require_once '../classes/account.class.php';
$venueObj = new Venue();
$accountObj = new Account();

// Get check-in bookings using the new method
$Reservations = $venueObj->getAdminBookings('checkin');

// Filter for confirmed bookings that haven't checked in yet
$Reservations = array_filter($Reservations, function ($booking) {
    return isset($booking['booking_status_id']) && 
           isset($booking['booking_checkin_status']) && 
           $booking['booking_status_id'] == 2 && 
           $booking['booking_checkin_status'] == 'Pending';
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
    <h2 class="text-xl font-semibold text-gray-800 mb-4">Search and Filter Check-Ins</h2>
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
            <input type="text" id="customerFilter" class="border rounded p-2 w-full" placeholder="Filter by customer name">
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

<!-- Check-In Table -->
<section class="bg-white rounded-lg shadow-md p-4 mb-8">
    <h2 class="text-xl font-semibold text-gray-800 mb-4">Pending Check-Ins</h2>
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
                    <th class="py-2 px-4 text-left">Participants</th>
                    <th class="py-2 px-4 text-left">Check-In Status</th>
                    <th class="py-2 px-4 text-left">Payment Status</th>
                    <th class="py-2 px-4 text-left">Actions</th>
                </tr>
            </thead>
            <tbody id="reservationsTable">
                <?php
                if (!empty($Reservations)) {
                    foreach ($Reservations as $reservation) {
                        // Get payment status
                        $payment_status_id = isset($reservation['booking_payment_status_id']) ? $reservation['booking_payment_status_id'] : null;
                        ?>
                        <tr>
                            <td class="py-2 px-4"><?php echo formatDate($reservation['booking_created_at']); ?></td>
                            <td class="py-2 px-4"><?php echo formatDate($reservation['booking_start_date']); ?></td>
                            <td class="py-2 px-4"><?php echo formatDate($reservation['booking_end_date']); ?></td>
                            <td class="py-2 px-4"><?php echo $reservation['guest_name']; ?></td>
                            <td class="py-2 px-4"><?php echo $reservation['guest_contact_number']; ?></td>
                            <td class="py-2 px-4"><?php echo $reservation['venue_name']; ?></td>
                            <td class="py-2 px-4"><?php echo $reservation['booking_participants']; ?></td>
                            <td class="py-2 px-4">
                                <span class="rounded-full px-2">Pending Check-In</span>
                            </td>
                            <td class="py-2 px-4">
                                <?php
                                switch ($payment_status_id) {
                                    case 1:
                                        echo '<span class="bg-yellow-200 text-yellow-800 rounded-full px-2">Pending</span>';
                                        break;
                                    case 2:
                                        echo '<span class="bg-green-200 text-green-800 rounded-full px-2">Paid</span>';
                                        break;
                                    case 3:
                                        echo '<span class="bg-red-200 text-red-800 rounded-full px-2">Failed</span>';
                                        break;
                                    default:
                                        echo '<span class="bg-gray-200 text-gray-800 rounded-full px-2">Unknown</span>';
                                }
                                ?>
                            </td>
                            <td class="py-2 px-4">
                                <form class="checkInButton inline-block" method="POST">
                                    <input type="hidden" name="booking_id" value="<?php echo $reservation['booking_id']; ?>">
                                    <button type="submit"
                                        class=" text-green-500 font-bold py-1 px-3 rounded">
                                        Check In
                                    </button>
                                </form>
                                <form class="noShowButton inline-block" method="POST">
                                    <input type="hidden" name="booking_id" value="<?php echo $reservation['booking_id']; ?>">
                                    <button type="submit"
                                        class="  text-red-600  font-bold py-1 px-3 rounded">
                                        No Show
                                    </button>
                                </form>
                            </td>
                        </tr>
                        <?php
                    }
                } else {
                    ?>
                    <tr>
                        <td colspan="10" class="py-4 text-center">No pending check-ins found</td>
                    </tr>
                    <?php
                }
                ?>
            </tbody>
        </table>
    </div>
</section>

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

        // Handle check-in
        $('.checkInButton').on("submit", function (e) {
            e.preventDefault();
            const formData = $(this).serialize();

            confirmshowModal(
                "Are you sure you want to check in this guest?",
                function () {
                    $.ajax({
                        type: "POST",
                        url: "../api/checkInBooking.api.php",
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

        // Handle no-show
        $('.noShowButton').on("submit", function (e) {
            e.preventDefault();
            const formData = $(this).serialize();

            confirmshowModal(
                "Are you sure you want to mark this guest as no-show?",
                function () {
                    $.ajax({
                        type: "POST",
                        url: "../api/noShowBooking.api.php",
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
    });
</script> 