<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Venue Owner Application</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_GOOGLE_MAPS_API_KEY&libraries=places"></script>
    <!-- Add custom styles -->
    <style>
        /* Input field transitions and styles */
        input[type="text"],
        input[type="email"],
        input[type="tel"],
        input[type="url"],
        textarea {
            transition: all 0.3s ease;
            border: 2px solid transparent;
            background-color: #f3f4f6;
            padding: 1rem 1.2rem;
            font-size: 1.1rem;
            border-radius: 8px;
        }

        input[type="text"]:focus,
        input[type="email"]:focus,
        input[type="tel"]:focus,
        input[type="url"]:focus,
        textarea:focus {
            outline: none;
            border-color: transparent;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.2);
            transform: translateY(-2px);
            background-color: white;
        }

        /* Label styles */
        .form-label {
            font-size: 1.1rem;
            font-weight: 500;
            margin-bottom: 0.5rem;
            display: block;
            transition: all 0.3s ease;
        }

        /* Description text styles */
        .step p {
            font-size: 1.1rem;
            line-height: 1.6;
        }

        /* Heading styles */
        .step h1 {
            font-size: 2.5rem !important;
            margin-bottom: 1rem;
        }

        /* File input styling */
        input[type="file"] {
            padding: 1rem;
            font-size: 1.1rem;
        }

        /* Input container spacing */
        .space-y-4 > div {
            margin-bottom: 2rem;
        }

        /* Optional: Add hover effect */
        input:hover,
        textarea:hover {
            background-color: #e5e7eb;
        }

        /* Map container styles */
        .map-container {
            height: 300px;
            width: 100%;
            margin-bottom: 1.5rem;
            border-radius: 8px;
            overflow: hidden;
        }

        /* Address confirmation modal styles */
        .address-confirm-modal {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 1000;
        }

        .address-confirm-content {
            background: white;
            padding: 2rem;
            border-radius: 12px;
            width: 90%;
            max-width: 600px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .address-fields {
            background: #f8f9fa;
            padding: 1.5rem;
            border-radius: 8px;
            margin: 1rem 0;
        }

        .address-field {
            margin-bottom: 1rem;
        }
    </style>
</head>
<body class="min-h-screen flex flex-col bg-gray-50">
    <!-- Top Navigation -->
    <header class="bg-white border-b">
        <div class="container mx-auto px-4 h-16 flex items-center justify-between">
            <button class="p-2">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
            </button>
            <div class="flex items-center gap-4">
                <button class="text-gray-600">Questions?</button>
                <button class="bg-black text-white px-4 py-2 rounded-md">Save & exit</button>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="flex-1 mt-40 container mx-auto px-4 py-8">
        <form id="venueOwnerForm" class="max-w-2xl mx-auto">
            <!-- Step 1: Personal Information -->
            <div id="step1" class="step">
                <h1 class="text-2xl font-bold mb-2">Personal Information</h1>
                <p class="text-gray-600 mb-6">Let's start with your personal details.</p>
                <div class="space-y-4">
                    <div>
                        <label for="fullName" class="block text-sm font-medium text-gray-700">Full Name</label>
                        <input type="text" id="fullName" name="fullName" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                    </div>
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                        <input type="email" id="email" name="email" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                    </div>
                    <div>
                        <label for="phoneNumber" class="block text-sm font-medium text-gray-700">Phone Number</label>
                        <input type="tel" id="phoneNumber" name="phoneNumber" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                    </div>
                </div>
            </div>

            <!-- Step 2: Venue Details -->
            <div id="step2" class="step hidden">
                <h1 class="text-2xl font-bold mb-2">Venue Details</h1>
                <p class="text-gray-600 mb-6">Tell us about your venue.</p>
                <div class="space-y-4">
                    <div>
                        <label for="venueName" class="block text-sm font-medium text-gray-700">Venue Name</label>
                        <input type="text" id="venueName" name="venueName" class="mt-1 block w-full">
                    </div>
                    
                    <!-- Map Placeholder and Address Section -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Venue Location</label>
                        <input type="text" id="searchAddress" 
                               placeholder="Search for your venue's address" 
                               class="mt-1 block w-full mb-4">
                        
                        <!-- Map Placeholder -->
                        <div class="map-placeholder bg-gray-100 rounded-lg mb-4 flex items-center justify-center" 
                             style="height: 300px;">
                            <div class="text-center">
                                <svg class="w-12 h-12 mx-auto mb-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                          d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                          d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                <p class="text-gray-500">Map placeholder - Click to set location</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Step 3: Online Presence -->
            <div id="step3" class="step hidden">
                <h1 class="text-2xl font-bold mb-2">Online Presence</h1>
                <p class="text-gray-600 mb-6">Share your venue's online information.</p>
                <div class="space-y-4">
                    <div>
                        <label for="websiteUrl" class="block text-sm font-medium text-gray-700">Website URL (Optional)</label>
                        <input type="url" id="websiteUrl" name="websiteUrl" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                    </div>
                    <div>
                        <label for="socialMediaLinks" class="block text-sm font-medium text-gray-700">Social Media Links (Optional)</label>
                        <input type="text" id="socialMediaLinks" name="socialMediaLinks" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                        <p class="mt-2 text-sm text-gray-500">Separate multiple links with commas</p>
                    </div>
                </div>
            </div>

            <!-- Step 4: Supporting Documents -->
            <div id="step4" class="step hidden">
                <h1 class="text-2xl font-bold mb-2">Supporting Documents</h1>
                <p class="text-gray-600 mb-6">Please upload the required documents.</p>
                <div class="space-y-4">
                    <div>
                        <label for="governmentId" class="block text-sm font-medium text-gray-700">Government-Issued ID</label>
                        <input type="file" id="governmentId" name="governmentId" accept="image/*,.pdf" class="mt-1 block w-full">
                    </div>
                    <div>
                        <label for="utilityBill" class="block text-sm font-medium text-gray-700">Utility Bill or Property Document</label>
                        <input type="file" id="utilityBill" name="utilityBill" accept="image/*,.pdf" class="mt-1 block w-full">
                    </div>
                    <div>
                        <label for="venuePhotos" class="block text-sm font-medium text-gray-700">Venue Photos (Up to 5)</label>
                        <input type="file" id="venuePhotos" name="venuePhotos" accept="image/*" multiple class="mt-1 block w-full">
                    </div>
                </div>
            </div>

            <!-- Step 5: Review and Submit -->
            <div id="step5" class="step hidden">
                <h1 class="text-2xl font-bold mb-2">Review and Submit</h1>
                <p class="text-gray-600 mb-6">Please review your information before submitting.</p>
                <div id="reviewContent" class="space-y-2"></div>
            </div>
        </form>
    </main>

    <!-- Bottom Navigation -->
    <footer class="bg-white border-t">
        <div class="container mx-auto px-4 h-20 flex items-center justify-between">
            <button id="prevBtn" class="text-gray-900 font-medium">Back</button>
            <div class="flex-1 flex justify-center">
                <div class="w-1/2 relative">
                    <div class="h-1 bg-gray-200 rounded-full">
                        <div id="progressBarFill" class="h-1 bg-gray-900 rounded-full transition-all duration-300" style="width: 20%"></div>
                    </div>
                </div>
            </div>
            <button id="nextBtn" class="bg-black text-white px-6 py-2 rounded-md">Next</button>
        </div>
    </footer>

    <!-- Success Message Modal (hidden by default) -->
    <div id="successMessage" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3 text-center">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Application Submitted Successfully</h3>
                <div class="mt-2 px-7 py-3">
                    <p class="text-sm text-gray-500">
                        Thank you for applying to become a venue owner. Your application has been received and is being reviewed. We will contact you shortly with further information.
                    </p>
                </div>
                <div class="items-center px-4 py-3">
                    <button id="closeSuccessMessage" class="px-4 py-2 bg-black text-white text-base font-medium rounded-md w-full shadow-sm hover:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-500">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Address Confirmation Modal -->
    <div id="addressConfirmModal" class="address-confirm-modal">
        <div class="address-confirm-content">
            <h2 class="text-xl font-bold mb-4">Confirm your address</h2>
            <p class="text-gray-600 mb-4">Your address is only shared with guests after they've made a reservation.</p>
            
            <div class="address-fields">
                <div class="address-field">
                    <label class="block text-sm font-medium text-gray-700">Country/Region</label>
                    <input type="text" id="country" class="mt-1 block w-full">
                </div>
                <div class="address-field">
                    <label class="block text-sm font-medium text-gray-700">Street address</label>
                    <input type="text" id="street" class="mt-1 block w-full">
                </div>
                <div class="address-field">
                    <label class="block text-sm font-medium text-gray-700">Unit/Apartment (if applicable)</label>
                    <input type="text" id="unit" class="mt-1 block w-full">
                </div>
                <div class="address-field">
                    <label class="block text-sm font-medium text-gray-700">City</label>
                    <input type="text" id="city" class="mt-1 block w-full">
                </div>
                <div class="address-field">
                    <label class="block text-sm font-medium text-gray-700">State/Province</label>
                    <input type="text" id="state" class="mt-1 block w-full">
                </div>
                <div class="address-field">
                    <label class="block text-sm font-medium text-gray-700">ZIP/Postal code</label>
                    <input type="text" id="zipCode" class="mt-1 block w-full">
                </div>
            </div>

            <div class="flex justify-end gap-4 mt-6">
                <button type="button" id="editAddress" 
                        class="px-4 py-2 text-gray-700 border border-gray-300 rounded-md hover:bg-gray-50">
                    Edit
                </button>
                <button type="button" id="confirmAddress" 
                        class="px-4 py-2 bg-black text-white rounded-md hover:bg-gray-800">
                    Confirm
                </button>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('venueOwnerForm');
            const steps = document.querySelectorAll('.step');
            const prevBtn = document.getElementById('prevBtn');
            const nextBtn = document.getElementById('nextBtn');
            const progressBarFill = document.getElementById('progressBarFill');
            const successMessage = document.getElementById('successMessage');
            const closeSuccessMessage = document.getElementById('closeSuccessMessage');
            let currentStep = 0;

            function showStep(stepIndex) {
                steps.forEach((step, index) => {
                    step.classList.toggle('hidden', index !== stepIndex);
                });
                prevBtn.style.display = stepIndex === 0 ? 'none' : 'block';
                nextBtn.textContent = stepIndex === steps.length - 1 ? 'Submit' : 'Next';
                progressBarFill.style.width = `${((stepIndex + 1) / steps.length) * 100}%`;
            }

            function updateReviewStep() {
                const reviewContent = document.getElementById('reviewContent');
                reviewContent.innerHTML = '';
                const formData = new FormData(form);
                for (let [key, value] of formData.entries()) {
                    if (key !== 'governmentId' && key !== 'utilityBill' && key !== 'venuePhotos') {
                        const p = document.createElement('p');
                        p.innerHTML = `<strong>${key}:</strong> ${value || 'Not provided'}`;
                        reviewContent.appendChild(p);
                    }
                }
                // Add file information
                ['governmentId', 'utilityBill'].forEach(fileId => {
                    const file = document.getElementById(fileId).files[0];
                    const p = document.createElement('p');
                    p.innerHTML = `<strong>${fileId}:</strong> ${file ? file.name : 'Not uploaded'}`;
                    reviewContent.appendChild(p);
                });
                const venuePhotos = document.getElementById('venuePhotos').files;
                const p = document.createElement('p');
                p.innerHTML = `<strong>Venue Photos:</strong> ${venuePhotos.length} photo(s) uploaded`;
                reviewContent.appendChild(p);
            }

            nextBtn.addEventListener('click', function() {
                if (currentStep < steps.length - 1) {
                    currentStep++;
                    showStep(currentStep);
                    if (currentStep === steps.length - 1) {
                        updateReviewStep();
                    }
                } else {
                    successMessage.classList.remove('hidden');
                }
            });

            prevBtn.addEventListener('click', function() {
                if (currentStep > 0) {
                    currentStep--;
                    showStep(currentStep);
                }
            });

            closeSuccessMessage.addEventListener('click', function() {
                successMessage.classList.add('hidden');
            });

            showStep(currentStep);

            const mapPlaceholder = document.querySelector('.map-placeholder');
            const addressConfirmModal = document.getElementById('addressConfirmModal');
            const searchInput = document.getElementById('searchAddress');
            const confirmAddressBtn = document.getElementById('confirmAddress');
            const editAddressBtn = document.getElementById('editAddress');

            // Show modal when clicking on map placeholder
            mapPlaceholder.addEventListener('click', function() {
                addressConfirmModal.style.display = 'flex';
            });

            // Show modal when pressing enter in search input
            searchInput.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    addressConfirmModal.style.display = 'flex';
                }
            });

            // Handle confirm button
            confirmAddressBtn.addEventListener('click', function() {
                addressConfirmModal.style.display = 'none';
            });

            // Handle edit button
            editAddressBtn.addEventListener('click', function() {
                addressConfirmModal.style.display = 'none';
            });

            // Close modal when clicking outside
            addressConfirmModal.addEventListener('click', function(e) {
                if (e.target === addressConfirmModal) {
                    addressConfirmModal.style.display = 'none';
                }
            });
        });
    </script>
</body>
</html>