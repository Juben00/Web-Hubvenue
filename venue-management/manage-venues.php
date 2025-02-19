<?php
require_once '../classes/venue.class.php';
require_once '../classes/account.class.php';
$venueObj = new Venue();
$venues = $venueObj->getAllVenues($status = '1');
?>

<div id="manage-venues" class="tab-content rounded-lg border bg-white shadow-sm">
    <div class="flex flex-col space-y-1.5 p-6">
        <h3 class="text-2xl font-semibold leading-none tracking-tight">Manage Venues</h3>
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
                        echo '<tr><td colspan="8" class="p-4 align-middle text-center">No Pending Request Found!</td></tr>';
                    }
                    foreach ($venues as $venue): ?>
                        <tr class="border-b transition-colors hover:bg-muted/50">
                            <td class="p-4 align-middle"><?= htmlspecialchars($venue['venue_id']) ?></td>
                            <td class="p-4 align-middle max-w-[200px] truncate" title="<?= htmlspecialchars($venue['name']) ?>">
                                <?= htmlspecialchars($venue['name']) ?>
                            </td>
                            <td class="p-4 align-middle max-w-[200px] truncate" title="<?= htmlspecialchars($venue['location']) ?>">
                                <?= htmlspecialchars($venue['location']) ?>
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
                                <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium bg-yellow-100 text-yellow-800">
                                    Pending
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
                                        <input type="hidden" name="venue_id" value="<?= htmlspecialchars($venue['venue_id']) ?>">
                                        <button type="submit"
                                            class="inline-flex w-full items-center justify-center rounded-md text-sm font-medium bg-green-500 text-white hover:bg-green-600 h-9 px-3">
                                            Approve
                                        </button>
                                    </form>
                                    <form class="declineVenueButton" method="POST">
                                        <input type="hidden" name="venue_id" value="<?= htmlspecialchars($venue['venue_id']) ?>">
                                        <button type="submit"
                                            class="inline-flex w-full items-center justify-center rounded-md text-sm font-medium bg-red-500 text-white hover:bg-red-600 h-9 px-3">
                                            Decline
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
    button.addEventListener('click', async function() {
        const venueId = this.dataset.venueId;
        console.log('Fetching details for venue:', venueId);
        
        // First check if ModalManager exists and initialize if needed
        if (!window.ModalManager || !window.ModalManager.initialized) {
            console.log('Initializing ModalManager...');
            window.ModalManager.initialize();
        }

        // Show loading state
        const loadingHtml = `
            <div class="flex items-center justify-center p-6">
                <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-red-700"></div>
            </div>
        `;
        const modalContent = document.getElementById('venue-details-content');
        if (modalContent) {
            modalContent.innerHTML = loadingHtml;
            window.ModalManager.showVenueDetailsModal();
        }
        
        try {
            // Fetch venue details
            const response = await fetch(`../api/getVenueDetails.api.php?venue_id=${venueId}`);
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            
            const data = await response.json();
            console.log('Venue data:', data);
            
            if (!data.success) {
                throw new Error(data.message || 'Failed to load venue details');
            }

            const venue = data.venue;
            
            // Fetch venue owner details
            const ownerResponse = await fetch(`../api/getVenueOwner.api.php?host_id=${venue.host_id}`);
            if (!ownerResponse.ok) {
                throw new Error(`HTTP error! status: ${ownerResponse.status}`);
            }
            
            const ownerData = await ownerResponse.json();
            console.log('Owner data:', ownerData);
            const owner = ownerData.success ? ownerData.owner : null;

            // Safely parse JSON strings or use arrays directly
            const amenities = typeof venue.amenities === 'string' ? 
                JSON.parse(venue.amenities) : (venue.amenities || []);
            const rules = typeof venue.rules === 'string' ? 
                JSON.parse(venue.rules) : (venue.rules || []);

            modalContent.innerHTML = `
                <div class="space-y-8">
                    <!-- Images Section -->
                    ${venue.image_urls && venue.image_urls.length > 0 ? `
                        <div>
                            <h4 class="text-lg font-semibold text-gray-700 mb-4">Venue Images</h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                                ${venue.image_urls.map(url => `
                                    <div class="aspect-w-16 aspect-h-9 rounded-lg overflow-hidden shadow-lg">
                                        <img src="../${url}" alt="Venue Image" class="w-full h-full object-cover">
                                    </div>
                                `).join('')}
                            </div>
                        </div>
                    ` : ''}

                    <!-- Main Information Grid -->
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                        <!-- Basic Information -->
                        <div class="space-y-6">
                            <div>
                                <h4 class="text-lg font-semibold text-gray-700 mb-4">Basic Information</h4>
                                <div class="bg-gray-50 p-6 rounded-lg space-y-4">
                                    <div>
                                        <span class="text-sm text-gray-500">Venue Name</span>
                                        <p class="text-gray-800 font-medium text-lg">${venue.name || venue.venue_name || 'N/A'}</p>
                                    </div>
                                    <div>
                                        <span class="text-sm text-gray-500">Price</span>
                                        <p class="text-gray-800 font-medium text-lg">₱${parseFloat(venue.price || 0).toLocaleString('en-US', {minimumFractionDigits: 2})}</p>
                                    </div>
                                    <div>
                                        <span class="text-sm text-gray-500">Capacity</span>
                                        <p class="text-gray-800 font-medium text-lg">${venue.capacity || 0} people</p>
                                    </div>
                                    <div>
                                        <span class="text-sm text-gray-500">Status</span>
                                        <p class="text-gray-800 font-medium text-lg">${venue.status || 'N/A'}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Location and Description -->
                        <div class="space-y-6">
                            <div>
                                <h4 class="text-lg font-semibold text-gray-700 mb-4">Location Details</h4>
                                <div class="bg-gray-50 p-6 rounded-lg">
                                    <p class="text-gray-800">${venue.address || venue.venue_location || venue.location || 'N/A'}</p>
                                </div>
                            </div>
                            <div>
                                <h4 class="text-lg font-semibold text-gray-700 mb-4">Description</h4>
                                <div class="bg-gray-50 p-6 rounded-lg">
                                    <p class="text-gray-800">${venue.description || venue.venue_description || 'No description available'}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Owner Information -->
                        <div class="space-y-6">
                            <div>
                                <h4 class="text-lg font-semibold text-gray-700 mb-4">Owner Information</h4>
                                <div class="bg-gray-50 p-6 rounded-lg space-y-4">
                                    <div>
                                        <span class="text-sm text-gray-500">Name</span>
                                        <p class="text-gray-800 font-medium text-lg">${owner ? `${owner.firstname} ${owner.lastname}` : 'Owner not found'}</p>
                                    </div>
                                    <div>
                                        <span class="text-sm text-gray-500">Contact</span>
                                        <p class="text-gray-800 font-medium text-lg">${owner ? owner.contact_number : 'N/A'}</p>
                                    </div>
                                    <div>
                                        <span class="text-sm text-gray-500">Email</span>
                                        <p class="text-gray-800 font-medium text-lg">${owner ? owner.email : 'N/A'}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Amenities and Rules Grid -->
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                        <!-- Amenities -->
                        ${amenities.length > 0 ? `
                            <div>
                                <h4 class="text-lg font-semibold text-gray-700 mb-4">Amenities</h4>
                                <div class="bg-gray-50 p-6 rounded-lg">
                                    <ul class="list-disc list-inside grid grid-cols-2 gap-2">
                                        ${amenities.map(amenity => `<li class="text-gray-800">${amenity}</li>`).join('')}
                                    </ul>
                                </div>
                            </div>
                        ` : ''}

                        <!-- Rules -->
                        ${rules.length > 0 ? `
                            <div>
                                <h4 class="text-lg font-semibold text-gray-700 mb-4">Rules</h4>
                                <div class="bg-gray-50 p-6 rounded-lg">
                                    <ul class="list-disc list-inside">
                                        ${rules.map(rule => `<li class="text-gray-800">${rule}</li>`).join('')}
                                    </ul>
                                </div>
                            </div>
                        ` : ''}
                    </div>
                </div>
            `;
        } catch (error) {
            console.error('Error:', error);
            if (modalContent) {
                modalContent.innerHTML = `
                    <div class="p-6 text-center text-red-600">
                        <p>Error loading venue details: ${error.message}</p>
                    </div>
                `;
            }
        }
    });
});

// Add close modal functionality
document.querySelector('#venue-details-modal-manage .close-modal').addEventListener('click', function() {
    const modal = document.getElementById('venue-details-modal-manage');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
});

// Close modal when clicking outside
document.getElementById('venue-details-modal-manage').addEventListener('click', function(e) {
    if (e.target === this) {
        this.classList.add('hidden');
        this.classList.remove('flex');
    }
});
</script>