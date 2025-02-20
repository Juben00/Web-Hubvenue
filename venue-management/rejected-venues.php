<?php
require_once '../classes/venue.class.php';
require_once '../classes/account.class.php';
$venueObj = new Venue();
$venues = $venueObj->getAllVenues($status = '3');
?>

<div id="manage-venues" class="tab-content rounded-lg border bg-white shadow-sm">
    <div class="flex flex-col space-y-1.5 p-6">
        <div class="flex items-center justify-between">
            <h3 class="text-2xl font-semibold leading-none tracking-tight">Rejected Venues</h3>
        </div>
    </div>
    <div class="p-6 pt-0">
        <div class="w-full overflow-x-auto">
            <table class="min-w-full caption-bottom text-sm">
                <thead class="[&_tr]:border-b">
                    <tr class="border-b transition-colors hover:bg-muted/50 data-[state=selected]:bg-muted">
                        <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">ID</th>
                        <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Name</th>
                        <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Location</th>
                        <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Price</th>
                        <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Venue Owner</th>
                        <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Status</th>
                        <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Thumbnail</th>
                        <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Actions</th>
                    </tr>
                </thead>
                <tbody id="venues-table-body" class="[&_tr:last-child]:border-0">
                    <?php
                    if (empty($venues)) {
                        echo '<tr><td colspan="8" class="p-4 align-middle text-center">No Rejected Venues Found!</td></tr>';
                    }
                    foreach ($venues as $venue): ?>
                        <tr class="border-b transition-colors hover:bg-muted/50">
                            <td class="p-4 align-middle"><?= htmlspecialchars($venue['venue_id']) ?></td>
                            <td class="p-4 align-middle max-w-[200px] truncate"
                                title="<?= htmlspecialchars($venue['name']) ?>">
                                <?= htmlspecialchars($venue['name']) ?>
                            </td>
                            <td class="p-4 align-middle max-w-[200px] truncate"
                                title="<?= htmlspecialchars($venue['address']) ?>">
                                <?= htmlspecialchars($venue['address']) ?>
                            </td>
                            <td class="p-4 align-middle">₱<?= number_format(htmlspecialchars($venue['price']), 2) ?></td>

                            <?php
                            $accountObj = new Account();
                            $venueOwner = $accountObj->getUser($venue['host_id']);
                            ?>

                            <td class="p-4 align-middle">
                                <?php if (!empty($venueOwner)): ?>
                                    <?= htmlspecialchars($venueOwner['firstname']) . ' ' . htmlspecialchars($venueOwner['lastname']) ?>
                                <?php else: ?>
                                    <span class="text-gray-500">Owner not found</span>
                                <?php endif; ?>
                            </td>

                            <td class="p-4 align-middle">
                                <span
                                    class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium bg-red-100 text-red-800">
                                    Rejected
                                </span>
                            </td>

                            <td class="p-4 align-middle">
                                <?php if (!empty($venue['image_urls'])): ?>
                                    <img src="../<?= htmlspecialchars($venue['image_urls'][0]) ?>" alt="Venue Thumbnail"
                                        class="w-16 h-16 object-cover rounded-md">
                                <?php endif; ?>
                            </td>

                            <td class="p-4 align-middle">
                                <div class="flex flex-col gap-2">
                                    <button
                                        class="view-details-btn inline-flex items-center justify-center rounded-md text-sm font-medium bg-blue-500 text-white hover:bg-blue-600 h-9 px-3"
                                        data-venue-id="<?= htmlspecialchars($venue['venue_id']) ?>">
                                        View Details
                                    </button>
                                    <form class="approveVenueButton" method="POST">
                                        <input type="hidden" name="venue_id"
                                            value="<?= htmlspecialchars($venue['venue_id']) ?>">
                                        <button type="submit"
                                            class="inline-flex w-full items-center justify-center rounded-md text-sm font-medium bg-green-500 text-white hover:bg-green-600 h-9 px-3">
                                            Approve
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    // Initialize view details functionality
    document.querySelectorAll('.view-details-btn').forEach(button => {
        button.addEventListener('click', async function () {
            const venueId = this.dataset.venueId;
            console.log('Fetching details for venue:', venueId);

            // First check if ModalManager exists and initialize if needed
            if (!window.ModalManager || !window.ModalManager.initialized) {
                console.log('Initializing ModalManager...');
                window.ModalManager.initialize();
            }

            window.ModalManager.loadVenueDetails(venueId);
        });
    });

    // Initialize approve functionality
    document.querySelectorAll('.approveVenueButton').forEach(form => {
        form.addEventListener('submit', function (e) {
            e.preventDefault();
            const formData = new FormData(this);
            const venueId = formData.get('venue_id');
            console.log(`Approve venue form submitted for venue ID: ${venueId}`);

            confirmshowModal('Are you sure you want to approve this venue?', () => {
                console.log('Sending approve venue request...');
                fetch('../api/approveVenue.api.php', {
                    method: 'POST',
                    body: formData
                })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error(`HTTP error! status: ${response.status}`);
                        }
                        return response.json();
                    })
                    .then(data => {
                        console.log('Approve venue response:', data);
                        if (data.success) {
                            showModal('Venue approved successfully!', () => {
                                // Reload the current tab content
                                loadContent('rejected-venues.php');
                            });
                        } else {
                            console.error('Approve venue failed:', data.message);
                            showModal('Error: ' + data.message);
                        }
                    })
                    .catch(error => {
                        console.error('Error in approve venue request:', error);
                        showModal('An error occurred while approving the venue.');
                    });
            }, 'black_ico.png');
        });
    });
</script>