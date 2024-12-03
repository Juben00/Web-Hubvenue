<?php
require_once '../classes/venue.class.php';
$venueObj = new Venue();
$venues = $venueObj->getAllVenues($status = '2');
?>

<div id="manage-venues" class="tab-content rounded-lg border bg-white shadow-sm">
    <div class="flex flex-col space-y-1.5 p-6">
        <h3 class="text-2xl font-semibold leading-none tracking-tight">Approved Venues</h3>
    </div>
    <div class="p-6 pt-0">
        <div class="w-full overflow-x-auto">
            <table class="min-w-full caption-bottom text-sm">
                <thead class="[&_tr]:border-b">
                    <tr class="border-b transition-colors hover:bg-muted/50 data-[state=selected]:bg-muted">
                        <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Venue ID</th>
                        <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Name</th>
                        <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Description</th>
                        <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Location</th>
                        <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Price</th>
                        <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Amenities</th>
                        <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Entrance Fee</th>
                        <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Cleaning Fee</th>
                        <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Venue Owner</th>
                        <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Status</th>
                        <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Availability</th>
                        <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Images</th>
                        <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Created At</th>
                        <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Actions</th>
                    </tr>
                </thead>
                <tbody id="venues-table-body" class="[&_tr:last-child]:border-0">
                    <?php
                    if (empty($venues)) {
                        echo '<tr><td colspan="12" class="p-4 align-middle text-center">No venues found</td></tr>';
                    }
                    foreach ($venues as $venue): ?>
                        <tr class="border-b transition-colors hover:bg-muted/50">
                            <td class="p-4 align-middle"><?= htmlspecialchars($venue['venue_id']) ?></td>
                            <td class="p-4 align-middle"><?= htmlspecialchars($venue['name']) ?></td>
                            <td class="p-4 align-middle"><?= htmlspecialchars($venue['description']) ?></td>
                            <td class="p-4 align-middle"><?= htmlspecialchars($venue['location']) ?></td>
                            <td class="p-4 align-middle"><?= htmlspecialchars($venue['price']) ?></td>
                            <td class="p-4 align-middle">
                                <?php
                                // Check if amenities exist and decode JSON if present
                                if (!empty($venue['amenities'])) {
                                    $amenities = json_decode($venue['amenities'], true); // Decode the JSON into an associative array
                                    if ($amenities) {
                                        // Display the amenities
                                        echo '<ul>';
                                        foreach ($amenities as $amenity) {
                                            echo '<li>' . htmlspecialchars($amenity) . '</li>';
                                        }
                                        echo '</ul>';
                                    } else {
                                        echo 'No amenities available';
                                    }
                                } else {
                                    echo 'No amenities available';
                                }
                                ?>
                            </td>
                            <td class="p-4 align-middle"><?= htmlspecialchars($venue['entrance']) ?></td>
                            <td class="p-4 align-middle"><?= htmlspecialchars($venue['cleaning']) ?></td>

                            <?php
                            // Fetch the venue owner details
                            require_once '../classes/account.class.php';
                            $accountObj = new Account();
                            $venueOwner = $accountObj->getUser($venue['host_id']);
                            ?>

                            <td class="p-4 align-middle">
                                <?= htmlspecialchars($venueOwner[0]['firstname']) . ' ' . htmlspecialchars($venueOwner[0]['lastname']) ?>
                            </td>
                            <td class="p-4 align-middle"><?= htmlspecialchars($venue['status']) ?></td>
                            <td class="p-4 align-middle"><?= htmlspecialchars($venue['availability']) ?></td>
                            <td class="p-4 align-middle">
                                <?php if (!empty($venue['image_urls'])): ?>
                                    <?php foreach ($venue['image_urls'] as $image_url): ?>
                                        <img src="../<?= htmlspecialchars($image_url) ?>" alt="Venue Image"
                                            class="w-16 h-16 object-cover mr-2 mb-2">
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </td>
                            <td class="p-4 align-middle"><?= date('Y-m-d', strtotime($venue['created_at'])) ?></td>
                            <td class="p-4 align-middle ">

                                <button
                                    class="inline-flex w-20 m-1 items-center justify-center rounded-md text-sm font-medium bg-blue-500 text-white hover:bg-blue-600 h-9 px-3 mr-2"
                                    onclick="editVenue(<?= $venue['id'] ?>)">Approve</button>
                                <button
                                    class="inline-flex w-20 m-1 items-center justify-center rounded-md text-sm font-medium bg-green-500 text-white hover:bg-green-600 h-9 px-3 mr-2"
                                    onclick="editVenue(<?= $venue['id'] ?>)">Edit</button>
                                <button
                                    class="inline-flex w-20 m-1 items-center justify-center rounded-md text-sm font-medium bg-red-500 text-white hover:bg-red-600 h-9 px-3"
                                    onclick="deleteVenue(<?= $venue['id'] ?>)">Reject</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>