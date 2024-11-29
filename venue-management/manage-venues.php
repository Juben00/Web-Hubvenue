<?php
require_once '../classes/venue.class.php';
$venueObj = new Venue();
$venues = $venueObj->getAllVenues($status = '1');
?>

<div id="manage-venues" class="tab-content rounded-lg border bg-white shadow-sm">
    <div class="flex flex-col space-y-1.5 p-6">
        <h3 class="text-2xl font-semibold leading-none tracking-tight">Manage Venues</h3>
    </div>
    <div class="p-6 pt-0">
        <div class="w-full overflow-auto">
            <table class="w-full caption-bottom text-sm">
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
                        echo '<tr><td colspan="12" class="p-4 align-middle text-center">No Pending Request Found!</td></tr>';
                    }
                    foreach ($venues as $venue): ?>
                        <tr class="border-b transition-colors hover:bg-muted/50 ">
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

                                <form class="approveVenueButton" method="POST">
                                    <input type="hidden" name="venue_id"
                                        value="<?php echo htmlspecialchars($venue['venue_id']) ?>">
                                    <button type="submit"
                                        class="inline-flex w-20 m-1 items-center justify-center rounded-md text-sm font-medium bg-blue-500 text-white hover:bg-blue-600 h-9 px-3 mr-2">Approve</button>
                                </form>

                                <!-- <button
                                    class="inline-flex w-20 m-1 items-center justify-center rounded-md text-sm font-medium bg-green-500 text-white hover:bg-green-600 h-9 px-3 mr-2"
                                    onclick="editVenue(<?= $venue['id'] ?>)">Edit</button> -->
                                <form class="declineVenueButton" method="POST">
                                    <input type="hidden" name="venue_id"
                                        value="<?php echo htmlspecialchars($venue['venue_id']) ?>">
                                    <button type="submit"
                                        class="inline-flex w-20 m-1 items-center justify-center rounded-md text-sm font-medium bg-red-500 text-white hover:bg-red-600 h-9 px-3">Decline</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>


<!-- <script>
    // Sample JSON data
    let venuesData = [
        { id: 1, name: "Grand Hall", location: "New York", capacity: 500 },
        { id: 2, name: "Garden Terrace", location: "Los Angeles", capacity: 200 },
        { id: 3, name: "Skyline Loft", location: "Chicago", capacity: 150 }
    ];

    // Function to populate venues table
    function populateVenuesTable() {
        const tableBody = document.getElementById('venues-table-body');
        tableBody.innerHTML = '';
        venuesData.forEach(venue => {
            const row = `
                <tr class="border-b transition-colors hover:bg-muted/50 data-[state=selected]:bg-muted">
                    <td class="p-4 align-middle [&:has([role=checkbox])]:pr-0">${venue.name}</td>
                    <td class="p-4 align-middle [&:has([role=checkbox])]:pr-0">${venue.location}</td>
                    <td class="p-4 align-middle [&:has([role=checkbox])]:pr-0">${venue.capacity}</td>
                    <td class="p-4 align-middle [&:has([role=checkbox])]:pr-0">
                        <button class="inline-flex items-center justify-center rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 border border-input bg-background hover:bg-accent hover:text-accent-foreground h-9 px-3 mr-2">Edit</button>
                        <button class="inline-flex items-center justify-center rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-red-500 text-white hover:bg-red-600 h-9 px-3">Delete</button>
                    </td>
                </tr>
            `;
            tableBody.innerHTML += row;
        });
    }

    // Function to handle tab switching
    function switchTab(tabId) {
        document.querySelectorAll('.tab-content').forEach(tab => {
            tab.classList.add('hidden');
        });
        document.getElementById(tabId).classList.remove('hidden');
        document.querySelectorAll('.tab-button').forEach(button => {
            button.dataset.state = '';
        });
        document.querySelector(`[data-tab="${tabId}"]`).dataset.state = 'active';
    }

    // Event listeners
    document.addEventListener('DOMContentLoaded', () => {
        // Populate venues table
        populateVenuesTable();

        // Tab switching
        document.querySelectorAll('.tab-button').forEach(button => {
            button.addEventListener('click', () => {
                switchTab(button.dataset.tab);
            });
        });

        // Form submissions
        document.getElementById('add-venue-form').addEventListener('submit', (e) => {
            e.preventDefault();
            alert('Venue added successfully!');
        });

        document.getElementById('pricing-form').addEventListener('submit', (e) => {
            e.preventDefault();
            alert('Pricing updated successfully!');
        });

        document.getElementById('save-availability').addEventListener('click', () => {
            alert('Availability saved successfully!');
        });
    });
</script> -->