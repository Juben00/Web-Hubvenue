<?php
require_once '../classes/venue.class.php';
require_once '../api/coorAddressVerify.api.php';

session_start();

$venueObj = new Venue();
$venuePost = $venueObj->getAllVenues('', $_SESSION['user']['id']);

?>
<main class="max-w-7xl mx-auto py-6 pt-20 sm:px-6 lg:px-8">
    <div class="px-4 sm:px-0" id="mainContent">
        <!-- Main Listings View -->
        <div id="listingsView">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold">Your listings</h1>
                <?php if ($_SESSION['user']['user_type_id'] == 1) { ?>
                    <div class="flex items-center space-x-4">
                        <button class="p-2 rounded-lg hover:bg-gray-100">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </button>
                        <button class="p-2 rounded-lg hover:bg-gray-100">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 6h16M4 12h16M4 18h16"></path>
                            </svg>
                        </button>
                        <button class="px-4 py-2 bg-black text-white rounded-lg hover:bg-gray-800"
                            id="addVenueButton">+</button>
                    </div>
                <?php } ?>
            </div>

            <?php
            if ($_SESSION['user']['user_type_id'] == 2) {
                echo '<p class="text-gray-500 text-left">You need to apply for Host Account before you can list your venue.</p>';
            }

            if (empty($venuePost)) {
                echo '<p class="text-gray-500 text-left">No listings found.</p>';
            }
            ?>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <?php foreach ($venuePost as $venue):
                    // $address = getAddressByCoordinates($venue['location']);
                    ?>
                    <div class="venue-card relative group" data-id="<?php echo htmlspecialchars($venue['venue_id']); ?>">
                        <div class="bg-white rounded-xl shadow overflow-hidden hover:shadow-lg transition duration-300">
                            <div class="relative">
                                <?php
                                switch ($venue['status']) {
                                    case 'Approved':
                                        echo '<div class="absolute top-2 text-white px-2 py-1 rounded-full text-xs p-1" style="right: 0.5rem; background-color: #3f3f46;">Approved</div>';
                                        break;
                                    case 'Pending':
                                        echo '<div class="absolute top-2 text-white px-2 py-1 rounded-full text-xs p-1" style="right: 0.5rem; background-color: #3f3f46;">Pending</div>';
                                        break;
                                    case 'Declined':
                                        echo '<div class="absolute top-2 text-white px-2 py-1 rounded-full text-xs p-1" style="right: 0.5rem; background-color: #3f3f46;">Declined</div>';
                                        break;
                                }
                                ?>
                                <img src="./<?php echo !empty($venue['image_urls'][0]) ? $venue['image_urls'][$venue['thumbnail']] : '../images/black_ico.png'; ?>"
                                    alt="<?php echo htmlspecialchars($venue['name'] ?? 'Venue'); ?>"
                                    class="w-full h-48 object-cover">
                            </div>
                            <div class="p-4">
                                <div class="flex justify-between items-center">
                                    <h3 class="font-medium text-lg"><?php echo htmlspecialchars($venue['name']); ?></h3>
                                    <button class="p-2 hover:bg-red-50 rounded-full transition-all duration-200 delete-venue-btn" 
                                            data-venue-id="<?php echo htmlspecialchars($venue['venue_id']); ?>"
                                            data-venue-name="<?php echo htmlspecialchars($venue['name']); ?>">
                                        <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                    </button>
                                </div>
                                <p class="text-gray-500 text-sm mt-1">
                                    <?php echo htmlspecialchars($venue['venue_tag_name'] ?? 'No tag specified'); ?>
                                </p>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</main>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize delete buttons
    document.querySelectorAll('.delete-venue-btn').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            const venueId = this.dataset.venueId;
            const venueName = this.dataset.venueName;
            
            // Create and show a custom confirmation dialog
            const confirmDialog = `
                <div class="fixed inset-0 bg-black/60 backdrop-blur-sm flex items-center justify-center z-50">
                    <div class="bg-white rounded-xl shadow-2xl p-8 w-[28rem] mx-4">
                        <div class="flex justify-center mb-6">
                            <img src="../images/black_ico.png" alt="Logo" class="w-auto h-28 object-contain drop-shadow-md">
                        </div>
                        <div class="text-center mb-8">
                            <h2 class="text-2xl font-bold mb-3 text-gray-800">Delete Venue</h2>
                            <p class="text-gray-600 leading-relaxed">
                                Are you sure you want to delete "${venueName}"?<br><br>
                                This action cannot be undone.
                            </p>
                        </div>
                        <div class="flex justify-center space-x-4">
                            <button class="cancel-delete px-6 py-2.5 rounded-lg border border-gray-300 text-gray-700 font-medium transition-all hover:bg-gray-100">
                                Cancel
                            </button>
                            <button class="confirm-delete px-6 py-2.5 rounded-lg bg-red-500 text-white font-medium transition-all hover:bg-red-600">
                                Delete
                            </button>
                        </div>
                    </div>
                </div>
            `;

            // Add the dialog to the page
            const dialogContainer = document.createElement('div');
            dialogContainer.innerHTML = confirmDialog;
            document.body.appendChild(dialogContainer);

            // Add event listeners
            const dialog = dialogContainer.firstElementChild;
            dialog.querySelector('.cancel-delete').addEventListener('click', () => {
                document.body.removeChild(dialogContainer);
            });

            dialog.querySelector('.confirm-delete').addEventListener('click', () => {
                document.body.removeChild(dialogContainer);
                deleteVenue(venueId);
            });

            // Close on backdrop click
            dialog.addEventListener('click', (e) => {
                if (e.target === dialog) {
                    document.body.removeChild(dialogContainer);
                }
            });
        });
    });
    
    // Initialize calendar if needed
    if (document.querySelector('.calendar-days')) {
        initializeCalendar();
    }
});

function showFeedbackMessage(message) {
    const feedbackDialog = `
        <div class="fixed inset-0 bg-black/60 backdrop-blur-sm flex items-center justify-center z-50">
            <div class="bg-white rounded-xl shadow-2xl p-8 w-[28rem] mx-4">
                <div class="flex justify-center mb-6">
                    <img src="../images/black_ico.png" alt="Logo" class="w-auto h-28 object-contain drop-shadow-md">
                </div>
                <div class="text-center mb-8">
                    <p class="text-gray-600 leading-relaxed">${message}</p>
                </div>
                <div class="flex justify-center">
                    <button class="close-feedback px-6 py-2.5 rounded-lg bg-gray-800 text-white font-medium transition-all hover:bg-gray-700">
                        OK
                    </button>
                </div>
            </div>
        </div>
    `;

    const dialogContainer = document.createElement('div');
    dialogContainer.innerHTML = feedbackDialog;
    document.body.appendChild(dialogContainer);

    const dialog = dialogContainer.firstElementChild;
    const closeBtn = dialog.querySelector('.close-feedback');
    
    closeBtn.addEventListener('click', () => {
        document.body.removeChild(dialogContainer);
    });

    dialog.addEventListener('click', (e) => {
        if (e.target === dialog) {
            document.body.removeChild(dialogContainer);
        }
    });
}

function deleteVenue(venueId) {
    // Show loading state
    const venueCard = document.querySelector(`[data-id="${venueId}"]`);
    if (venueCard) {
        venueCard.style.opacity = '0.5';
        venueCard.style.pointerEvents = 'none';
    }

    // Send delete request to server
    fetch('../api/deleteVenue.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ venue_id: venueId })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Animate removal of the venue card
            if (venueCard) {
                venueCard.style.transition = 'all 0.3s ease';
                venueCard.style.transform = 'scale(0.9)';
                venueCard.style.opacity = '0';
                
                setTimeout(() => {
                    venueCard.remove();
                    
                    // Check if there are any venues left
                    const remainingVenues = document.querySelectorAll('.venue-card');
                    if (remainingVenues.length === 0) {
                        const noListingsMessage = document.createElement('p');
                        noListingsMessage.className = 'text-gray-500 text-left mt-4';
                        noListingsMessage.textContent = 'No listings found.';
                        document.querySelector('.grid').insertAdjacentElement('beforebegin', noListingsMessage);
                    }
                }, 300);
            }

            // Show success message using the modal
            showFeedbackMessage('Venue has been successfully deleted.');
        } else {
            // Restore venue card state if deletion failed
            if (venueCard) {
                venueCard.style.opacity = '1';
                venueCard.style.pointerEvents = 'auto';
            }
            showFeedbackMessage('Failed to delete venue: ' + (data.message || 'Unknown error'));
        }
    })
    .catch(error => {
        console.error('Error:', error);
        // Restore venue card state on error
        if (venueCard) {
            venueCard.style.opacity = '1';
            venueCard.style.pointerEvents = 'auto';
        }
        showFeedbackMessage('An error occurred while deleting the venue. Please try again.');
    });
}

function showVenueDetails(venue) {
    // Hide listings view and show details view
    document.getElementById('listingsView').classList.add('hidden');
    document.getElementById('venueDetailsView').classList.remove('hidden');

    // Populate venue details
    document.getElementById('detailVenueName').textContent = venue.name;
    document.getElementById('detailVenueLocation').textContent = venue.location;
    document.getElementById('detailVenueDescription').textContent = venue.description || 'No description provided yet';
    document.getElementById('detailVenueCapacity').textContent = venue.capacity ? `${venue.capacity} guests` : 'Capacity not specified';
    document.getElementById('detailVenuePrice').textContent = venue.price;

    // Populate amenities with descriptions
    const amenitiesList = document.getElementById('detailVenueAmenities');
    amenitiesList.innerHTML = '';
    if (Array.isArray(venue.amenities) && venue.amenities.length === 0) {
        amenitiesList.innerHTML = '<p class="text-gray-500 italic">No amenities listed yet</p>';
    } else if (typeof venue.amenities === 'object') {
        Object.entries(venue.amenities).forEach(([amenity, details]) => {
            const li = document.createElement('li');
            li.className = 'flex items-center gap-2 mb-3';
            if (details && details.description) {
                // Detailed amenity format
                li.innerHTML = `
                <div class="flex-shrink-0">
                    <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                <div>
                    <span class="font-medium">${amenity}</span>
                    <p class="text-sm text-gray-500">${details.description}</p>
                </div>
            `;
            } else {
                // Simple amenity format
                li.innerHTML = `
                <div class="flex-shrink-0">
                    <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                <div>
                    <span class="font-medium">${amenity}</span>
                </div>
            `;
            }
            amenitiesList.appendChild(li);
        });
    }

    // Populate rules with sections
    const rulesList = document.getElementById('detailVenueRules');
    rulesList.innerHTML = '';
    if (Array.isArray(venue.rules) && venue.rules.length === 0) {
        rulesList.innerHTML = `
        <div class="bg-yellow-50 border border-yellow-200 rounded-md p-4">
            <div class="flex items-center">
                <svg class="w-5 h-5 text-yellow-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
                <p class="text-yellow-700 font-medium">Required: Please add venue rules</p>
            </div>
            <p class="text-yellow-600 text-sm mt-2">Specify guidelines and restrictions for venue use</p>
        </div>
    `;
    } else {
        // Existing rules display code...
    }

    // Populate cancellation policy with detailed breakdown
    const policyDiv = document.getElementById('detailCancellationPolicy');
    if (!venue.cancellation_policy) {
        policyDiv.innerHTML = `
        <div class="bg-yellow-50 border border-yellow-200 rounded-md p-4">
            <div class="flex items-center">
                <svg class="w-5 h-5 text-yellow-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
                <p class="text-yellow-700 font-medium">Required: Please add cancellation policy</p>
        </div>
            <p class="text-yellow-600 text-sm mt-2">Define your booking cancellation terms and conditions</p>
        </div>
    `;
    } else {
        // Existing cancellation policy display code...
    }

    // Populate owner information
    const ownerDiv = document.getElementById('detailVenueOwner');
    ownerDiv.innerHTML = `
    <p><strong>Name:</strong> ${venue.owner.first_name} ${venue.owner.last_name}</p>
    <p><strong>Contact:</strong> ${venue.owner.contact}</p>
    <p><strong>Email:</strong> ${venue.owner.email}</p>
`;

    // Show status badge
    const statusDiv = document.getElementById('detailVenueStatus');
    let statusColor = '';
    switch (venue.status) {
        case 'Approved':
            statusColor = 'bg-green-500 border-green-600';
            break;
        case 'Pending':
            statusColor = 'bg-yellow-500 border-yellow-600';
            break;
        case 'Declined':
            statusColor = 'bg-red-500 border-red-600';
            break;
    }
    statusDiv.innerHTML = `
    <div class="inline-block border ${statusColor} text-white px-3 py-1 rounded-full">
        ${venue.status}
    </div>
`;

    // Set edit mode fields initial values
    document.getElementById('editVenueLocation').value = venue.location;
    document.getElementById('editVenueDescription').value = venue.description;
    document.getElementById('editVenueCapacity').value = venue.capacity;

    // Reset to view mode when showing details
    const viewElements = document.querySelectorAll('.view-mode');
    const editElements = document.querySelectorAll('.edit-mode');
    viewElements.forEach(el => el.classList.remove('hidden'));
    editElements.forEach(el => el.classList.add('hidden'));

    // Handle missing images
    const mainImage = document.getElementById('mainImage');
    mainImage.src = venue.image_urls && venue.image_urls.length > 0
        ? venue.image_urls[0]
        : '../images/black_ico.png';
    mainImage.alt = venue.name || 'Venue image';
}

function showListings() {
    // Hide details view and show listings view
    document.getElementById('venueDetailsView').classList.add('hidden');
    document.getElementById('listingsView').classList.remove('hidden');
}

function toggleEditMode() {
    const viewElements = document.querySelectorAll('.view-mode');
    const editElements = document.querySelectorAll('.edit-mode');

    viewElements.forEach(el => el.classList.toggle('hidden'));
    editElements.forEach(el => el.classList.toggle('hidden'));

    // Populate edit fields with current values
    if (!editElements[0].classList.contains('hidden')) {
        document.getElementById('editVenueLocation').value = document.getElementById('detailVenueLocation').textContent;
        document.getElementById('editVenueDescription').value = document.getElementById('detailVenueDescription').textContent;
        document.getElementById('editVenueCapacity').value = document.getElementById('detailVenueCapacity').textContent.split(' ')[0];
        populateAmenitiesEdit();

        // Populate rules edit fields
        const currentRules = Array.from(document.getElementById('detailVenueRules').children)
            .map(li => li.textContent);
        const rulesList = document.getElementById('rulesList');
        rulesList.innerHTML = '';
        currentRules.forEach(rule => {
            addRuleField(rule);
        });

        // Handle cancellation policy edit mode
        document.getElementById('editCancellationPolicy').addEventListener('change', function () {
            const customPolicyField = document.getElementById('editCustomPolicy');
            if (this.value === 'custom') {
                customPolicyField.classList.remove('hidden');
            } else {
                customPolicyField.classList.add('hidden');
            }
        });
    }
}

function populateAmenitiesEdit() {
    const amenitiesList = document.getElementById('amenitiesList');
    amenitiesList.innerHTML = '';

    const currentAmenities = Array.from(document.getElementById('detailVenueAmenities').children)
        .map(li => li.textContent);

    currentAmenities.forEach(amenity => {
        addAmenityField(amenity);
    });
}

function addAmenityField(value = '') {
    const amenitiesList = document.getElementById('amenitiesList');
    const div = document.createElement('div');
    div.className = 'flex items-center gap-2';
    div.innerHTML = `
    <input type="text" class="form-input rounded-md flex-grow" value="${value}">
    <button onclick="this.parentElement.remove()" class="p-2 text-red-500 hover:bg-red-50 rounded-md">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
        </svg>
    </button>
`;
    amenitiesList.appendChild(div);
}

function addRuleField(value = '') {
    const rulesList = document.getElementById('rulesList');
    const div = document.createElement('div');
    div.className = 'flex items-center gap-2';
    div.innerHTML = `
    <input type="text" class="form-input rounded-md flex-grow" value="${value}" placeholder="Enter venue rule">
    <button onclick="this.parentElement.remove()" class="p-2 text-red-500 hover:bg-red-50 rounded-md">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
        </svg>
    </button>
`;
    rulesList.appendChild(div);
}

// Add this to your existing script section
function initializeCalendar() {
    // Get current date
    const date = new Date();
    const currentMonth = date.getMonth();
    const currentYear = date.getFullYear();

    // Update calendar header
    updateCalendarHeader(currentMonth, currentYear);

    // Generate calendar days
    generateCalendarDays(currentMonth, currentYear);
}

function updateCalendarHeader(month, year) {
    const monthNames = ["January", "February", "March", "April", "May", "June",
        "July", "August", "September", "October", "November", "December"
    ];
    document.querySelector('.calendar-header h4').textContent = `${monthNames[month]} ${year}`;
}

function generateCalendarDays(month, year) {
    const firstDay = new Date(year, month, 1).getDay();
    const daysInMonth = new Date(year, month + 1, 0).getDate();

    let calendarHTML = '';

    // Previous month days
    for (let i = 0; i < firstDay; i++) {
        calendarHTML += `<div class="p-2 border-b border-r text-gray-400"></div>`;
    }

    // Current month days
    for (let day = 1; day <= daysInMonth; day++) {
        const isToday = day === new Date().getDate() &&
            month === new Date().getMonth() &&
            year === new Date().getFullYear();

        calendarHTML += `
        <div class="relative p-2 border-b border-r hover:bg-gray-50 cursor-pointer" 
             onclick="editDayPrice(${year}, ${month}, ${day})">
            <div class="text-sm ${isToday ? 'font-bold' : ''}">${day}</div>
            <div class="text-xs text-gray-600">₱2,341</div>
        </div>
    `;
    }

    document.querySelector('.calendar-days').innerHTML = calendarHTML;
}

function editDayPrice(year, month, day) {
    // Show a modal or form to edit the price for this specific day
    const date = new Date(year, month, day);
    const formattedDate = date.toLocaleDateString();

    // You can implement your own modal here
    const newPrice = prompt(`Enter new price for ${formattedDate}:`);
    if (newPrice && !isNaN(newPrice)) {
        // Update the price in your database
        // Then refresh the calendar display
        console.log(`Updated price for ${formattedDate} to ₱${newPrice}`);
    }
}

// Initialize calendar when page loads
document.addEventListener('DOMContentLoaded', initializeCalendar);
</script>

<!-- Update the styles -->
<style>
.venue-card {
    transition: all 0.3s ease;
}

.delete-venue-btn {
    transition: all 0.2s ease;
}

.delete-venue-btn:hover {
    transform: scale(1.1);
}

/* Remove the old hover styles since we don't need them anymore */
.venue-card:hover .delete-venue-btn {
    opacity: 1;
}
</style>