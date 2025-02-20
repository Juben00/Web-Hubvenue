<?php
require_once '../classes/venue.class.php';
require_once '../classes/account.class.php';
?>

<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl md:text-3xl font-semibold text-gray-800 mb-6 hidden md:block">Venue Management</h1>

    <div class="space-y-4">
        <!-- Tabs -->
        <div class="flex space-x-1 rounded-lg bg-white p-1">
            <button
                class="tab-button flex-1 inline-flex items-center justify-center whitespace-nowrap rounded-md px-3 py-1.5 text-sm font-medium ring-offset-background transition-all focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50  bg-red-600 text-white"
                id="add-venue-vm">Add Venue</button>
            <button
                class="tab-button flex-1 inline-flex items-center justify-center whitespace-nowrap rounded-md px-3 py-1.5 text-sm font-medium ring-offset-background transition-all focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50"
                id="manage-venues-vm">Manage Venues</button>
            <button
                class="tab-button flex-1 inline-flex items-center justify-center whitespace-nowrap rounded-md px-3 py-1.5 text-sm font-medium ring-offset-background transition-all focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50"
                id="approved-vm">Approved Venues</button>
            <button
                class="tab-button flex-1 inline-flex items-center justify-center whitespace-nowrap rounded-md px-3 py-1.5 text-sm font-medium ring-offset-background transition-all focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50"
                id="rejected-vm">Rejected Venues</button>
        </div>

        <div id="venue-management-view">
            <!-- Content will be loaded here -->
        </div>
    </div>
</div>

<!-- Venue Details Modal -->
<div id="venue-details-modal" class="fixed inset-0 bg-white z-50 hidden">
    <div class="h-full w-full flex flex-col">
        <!-- Header -->
        <div class="flex justify-between items-center px-6 py-4 border-b bg-white sticky top-0 z-10">
            <h3 class="text-2xl font-semibold text-gray-800">Venue Details</h3>
            <button class="close-modal text-gray-500 hover:text-gray-700 p-2 hover:bg-gray-100 rounded-full">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        
        <!-- Content -->
        <div class="flex-1 overflow-y-auto">
            <div id="venue-details-content" class="max-w-7xl mx-auto px-4 py-6">
                <!-- Content will be loaded dynamically -->
            </div>
        </div>
    </div>
</div>

<!-- Modal Container - This will hold dynamically loaded modals -->
<div id="modal-container"></div>

<script>
// Create a window-level singleton for modal management
if (!window.ModalManager) {
    window.ModalManager = {
        initialized: false,
        venueDetailsModal: null,
        
        initialize() {
            console.log('Initializing ModalManager...');
            if (!this.initialized) {
                this.venueDetailsModal = document.getElementById('venue-details-modal');
                if (!this.venueDetailsModal) {
                    console.error('Venue details modal element not found');
                    return;
                }
                this.setupEventListeners();
                this.initialized = true;
                console.log('ModalManager initialized successfully');
            }
            return this;
        },
        
        setupEventListeners() {
            console.log('Setting up ModalManager event listeners...');
            // Close Modal Button Click Handler
            const closeButton = document.querySelector('#venue-details-modal .close-modal');
            if (closeButton) {
                closeButton.addEventListener('click', () => {
                    this.hideVenueDetailsModal();
                });
            } else {
                console.error('Close modal button not found');
            }

            // Close Modal on Outside Click
            if (this.venueDetailsModal) {
                this.venueDetailsModal.addEventListener('click', (e) => {
                    if (e.target === this.venueDetailsModal) {
                        this.hideVenueDetailsModal();
                    }
                });
            }
        },
        
        showVenueDetailsModal() {
            console.log('Showing venue details modal...');
            if (!this.initialized) {
                console.log('ModalManager not initialized, initializing now...');
                this.initialize();
            }
            if (this.venueDetailsModal) {
                this.venueDetailsModal.classList.remove('hidden');
                this.venueDetailsModal.classList.add('flex');
                console.log('Venue details modal shown');
            } else {
                console.error('Cannot show modal - venueDetailsModal element not found');
            }
        },
        
        hideVenueDetailsModal() {
            console.log('Hiding venue details modal...');
            if (!this.initialized) {
                console.log('ModalManager not initialized, initializing now...');
                this.initialize();
            }
            if (this.venueDetailsModal) {
                this.venueDetailsModal.classList.add('hidden');
                this.venueDetailsModal.classList.remove('flex');
                console.log('Venue details modal hidden');
            } else {
                console.error('Cannot hide modal - venueDetailsModal element not found');
            }
        },

        async loadVenueDetails(venueId) {
            console.log(`Loading venue details for venue ID: ${venueId}`);
            const modalContent = document.getElementById('venue-details-content');
            if (!modalContent) {
                console.error('Venue details content container not found');
                return;
            }

            // Show loading state
            modalContent.innerHTML = `
                <div class="flex items-center justify-center p-6">
                    <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-red-700"></div>
                </div>
            `;
            this.showVenueDetailsModal();
            
            try {
                console.log('Fetching venue details...');
                // Fetch venue details
                const response = await fetch(`../api/getVenueDetails.api.php?venue_id=${venueId}`);
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                
                const data = await response.json();
                console.log('Venue details response:', data);
                
                if (!data.success) {
                    throw new Error(data.message || 'Failed to load venue details');
                }

                const venue = data.venue;
                
                // Fetch venue owner details
                console.log('Fetching venue owner details...');
                const ownerResponse = await fetch(`../api/getVenueOwner.api.php?host_id=${venue.host_id}`);
                if (!ownerResponse.ok) {
                    throw new Error(`HTTP error! status: ${ownerResponse.status}`);
                }
                
                const ownerData = await ownerResponse.json();
                console.log('Venue owner response:', ownerData);
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
                console.error('Error in loadVenueDetails:', error);
                modalContent.innerHTML = `
                    <div class="p-6 text-center text-red-600">
                        <p>Error loading venue details: ${error.message}</p>
                    </div>
                `;
            }
        }
    };
}

document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM Content Loaded - Initializing venue management...');
    
    // Initialize ModalManager first
    if (!window.ModalManager.initialized) {
        window.ModalManager.initialize();
    }
    
    // Initial load of modals
    loadModals().then(() => {
        console.log('Initial modals loaded');
        
        // Initial load of add venue tab
        loadContent('add-venue.html');

        // Add click event listeners to all tab buttons
        document.querySelectorAll('.tab-button').forEach(button => {
            button.addEventListener('click', function() {
                console.log(`Tab button clicked: ${this.id}`);
                // Remove active class from all buttons
                document.querySelectorAll('.tab-button').forEach(btn => {
                    btn.classList.remove('bg-red-600', 'text-white');
                });

                // Add active class to clicked button
                this.classList.add('bg-red-600', 'text-white');

                // Load content based on button ID
                switch(this.id) {
                    case 'add-venue-vm':
                        loadContent('add-venue.html');
                        break;
                    case 'manage-venues-vm':
                        loadContent('manage-venues.php');
                        break;
                    case 'approved-vm':
                        loadContent('approved-venues.php');
                        break;
                    case 'rejected-vm':
                        loadContent('rejected-venues.php');
                        break;
                }
            });
        });
    });
});

// Function to load modals
async function loadModals() {
    try {
        console.log('Loading modals...');
        // Load confirmation modal
        const confirmResponse = await fetch('../components/confirm.feedback.modal.html');
        if (!confirmResponse.ok) {
            throw new Error(`Failed to load confirmation modal: ${confirmResponse.status} ${confirmResponse.statusText}`);
        }
        const confirmHtml = await confirmResponse.text();
        
        // Load feedback modal
        const feedbackResponse = await fetch('../components/feedback.modal.html');
        if (!feedbackResponse.ok) {
            throw new Error(`Failed to load feedback modal: ${feedbackResponse.status} ${feedbackResponse.statusText}`);
        }
        const feedbackHtml = await feedbackResponse.text();
        
        // Add modals to container only if not already added
        const modalContainer = document.getElementById('modal-container');
        if (!modalContainer) {
            console.error('Modal container element not found');
            return;
        }
        
        if (!modalContainer.hasChildNodes()) {
            modalContainer.innerHTML = confirmHtml + feedbackHtml;
            console.log('Modals loaded successfully');
        } else {
            console.log('Modals already loaded');
        }
    } catch (error) {
        console.error('Error in loadModals:', error);
        throw error; // Propagate error for handling in loadContent
    }
}

function loadContent(file) {
    console.log(`Loading content for: ${file}`);
    
    // First ensure ModalManager is initialized
    if (!window.ModalManager || !window.ModalManager.initialized) {
        console.log('ModalManager not initialized, initializing...');
        window.ModalManager.initialize();
    }
    
    // Then load the modals
    loadModals().then(() => {
        console.log('Modals loaded, proceeding to load content...');
        
        // Then load the content
        fetch(file)
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.text();
            })
            .then(html => {
                const contentContainer = document.getElementById('venue-management-view');
                if (!contentContainer) {
                    throw new Error('Content container not found');
                }
                
                contentContainer.innerHTML = html;
                console.log(`Content loaded for: ${file}`);
                
                try {
                    // Initialize event listeners for the loaded content
                    console.log('Initializing event listeners...');
                    
                    // Re-initialize specific event listeners for view details and actions
                    const viewDetailsButtons = document.querySelectorAll('.view-details-btn');
                    console.log(`Found ${viewDetailsButtons.length} view details buttons`);
                    
                    viewDetailsButtons.forEach(button => {
                        button.addEventListener('click', function() {
                            const venueId = this.dataset.venueId;
                            console.log(`View details clicked for venue ID: ${venueId}`);
                            if (!window.ModalManager) {
                                console.error('ModalManager not initialized');
                                return;
                            }
                            window.ModalManager.loadVenueDetails(venueId);
                        });
                    });

                    const approveButtons = document.querySelectorAll('.approveVenueButton');
                    console.log(`Found ${approveButtons.length} approve buttons`);
                    
                    approveButtons.forEach(form => {
                        form.addEventListener('submit', function(e) {
                            e.preventDefault();
                            const formData = new FormData(this);
                            const venueId = formData.get('venue_id');
                            console.log(`Approve venue form submitted for venue ID: ${venueId}`);
                            
                            const currentTab = document.querySelector('.tab-button.bg-red-600');
                            if (!currentTab) {
                                console.error('No active tab found');
                                return;
                            }
                            const currentTabId = currentTab.id;
                            console.log(`Current active tab: ${currentTabId}`);
                            
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
                                            console.log('Reloading content after approval...');
                                            switch(currentTabId) {
                                                case 'manage-venues-vm':
                                                    loadContent('manage-venues.php');
                                                    break;
                                                case 'approved-vm':
                                                    loadContent('approved-venues.php');
                                                    break;
                                                case 'rejected-vm':
                                                    loadContent('rejected-venues.php');
                                                    break;
                                            }
                                        }, 'success.gif');
                                    } else {
                                        console.error('Approve venue failed:', data.message);
                                        showModal('Error: ' + data.message, null, 'error.gif');
                                    }
                                })
                                .catch(error => {
                                    console.error('Error in approve venue request:', error);
                                    showModal('An error occurred while approving the venue.', null, 'error.gif');
                                });
                            }, 'confirm.gif');
                        });
                    });

                    const declineButtons = document.querySelectorAll('.declineVenueButton');
                    console.log(`Found ${declineButtons.length} decline buttons`);
                    
                    declineButtons.forEach(form => {
                        form.addEventListener('submit', function(e) {
                            e.preventDefault();
                            const formData = new FormData(this);
                            const venueId = formData.get('venue_id');
                            console.log(`Decline venue form submitted for venue ID: ${venueId}`);
                            
                            const currentTab = document.querySelector('.tab-button.bg-red-600');
                            if (!currentTab) {
                                console.error('No active tab found');
                                return;
                            }
                            const currentTabId = currentTab.id;
                            
                            confirmshowModal('Are you sure you want to decline this venue?', () => {
                                console.log('Sending decline venue request...');
                                fetch('../api/declineVenue.api.php', {
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
                                    console.log('Decline venue response:', data);
                                    if (data.success) {
                                        showModal('Venue declined successfully!', () => {
                                            console.log('Reloading content after decline...');
                                            switch(currentTabId) {
                                                case 'manage-venues-vm':
                                                    loadContent('manage-venues.php');
                                                    break;
                                                case 'approved-vm':
                                                    loadContent('approved-venues.php');
                                                    break;
                                                case 'rejected-vm':
                                                    loadContent('rejected-venues.php');
                                                    break;
                                            }
                                        }, 'success.gif');
                                    } else {
                                        console.error('Decline venue failed:', data.message);
                                        showModal('Error: ' + data.message, null, 'error.gif');
                                    }
                                })
                                .catch(error => {
                                    console.error('Error in decline venue request:', error);
                                    showModal('An error occurred while declining the venue.', null, 'error.gif');
                                });
                            }, 'confirm.gif');
                        });
                    });
                    
                    console.log('All event listeners initialized successfully');
                    
                } catch (error) {
                    console.error('Error initializing event listeners:', error);
                    showModal('An error occurred while initializing the page.', null, 'error.gif');
                }
            })
            .catch(error => {
                console.error('Error loading content:', error);
                const contentContainer = document.getElementById('venue-management-view');
                if (contentContainer) {
                    contentContainer.innerHTML = 'Error loading content. Please try again.';
                }
                showModal('Error loading content. Please try again.', null, 'error.gif');
            });
    }).catch(error => {
        console.error('Error in loadContent:', error);
        showModal('Error loading page components. Please refresh the page.', null, 'error.gif');
    });
}

function initializeAddVenueForm() {
    // Add venue form initialization and validation
    const form = document.getElementById('add-venue-form');
    if (form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            
            fetch('../api/addVenue.api.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showModal('Venue added successfully!', () => {
                        form.reset();
                    }, 'success.gif');
                } else {
                    showModal('Error: ' + data.message, null, 'error.gif');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showModal('An error occurred while adding the venue.', null, 'error.gif');
            });
        });
    }
}

function initializeDataTables() {
    // Initialize view details functionality
    document.querySelectorAll('.view-details-btn').forEach(button => {
        button.addEventListener('click', function() {
            const venueId = this.dataset.venueId;
            window.ModalManager.loadVenueDetails(venueId);
        });
    });

    // Initialize actions for venue tables
    document.querySelectorAll('.approveVenueButton').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            const currentTab = document.querySelector('.tab-button.bg-red-600').id;
            
            confirmshowModal('Are you sure you want to approve this venue?', () => {
                fetch('../api/approveVenue.api.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        showModal('Venue approved successfully!', () => {
                            // Reload the current tab content
                            switch(currentTab) {
                                case 'manage-venues-vm':
                                    loadContent('manage-venues.php');
                                    break;
                                case 'approved-vm':
                                    loadContent('approved-venues.php');
                                    break;
                                case 'rejected-vm':
                                    loadContent('rejected-venues.php');
                                    break;
                            }
                        }, 'success.gif');
                    } else {
                        showModal('Error: ' + data.message, null, 'error.gif');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showModal('An error occurred while approving the venue.', null, 'error.gif');
                });
            }, 'confirm.gif');
        });
    });

    // Initialize decline functionality
    document.querySelectorAll('.declineVenueButton').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            const currentTab = document.querySelector('.tab-button.bg-red-600').id;
            
            confirmshowModal('Are you sure you want to decline this venue?', () => {
                fetch('../api/declineVenue.api.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        showModal('Venue declined successfully!', () => {
                            // Reload the current tab content
                            switch(currentTab) {
                                case 'manage-venues-vm':
                                    loadContent('manage-venues.php');
                                    break;
                                case 'approved-vm':
                                    loadContent('approved-venues.php');
                                    break;
                                case 'rejected-vm':
                                    loadContent('rejected-venues.php');
                                    break;
                            }
                        }, 'success.gif');
                    } else {
                        showModal('Error: ' + data.message, null, 'error.gif');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showModal('An error occurred while declining the venue.', null, 'error.gif');
                });
            }, 'confirm.gif');
        });
    });
}
</script>