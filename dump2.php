<div id="modal-content" class="mt-4">
    <!-- Main image and details container -->
    <div class="flex flex-col items-center">
        <!-- Images Section -->
        <div class="w-full mb-6">
            <!-- Main Image -->
            <div class="relative h-80 rounded-lg overflow-hidden mb-2">
                <img id="modal-main-image" src="" alt="Venue Main Image"
                    class="w-full h-full object-cover transition-transform duration-200 hover:scale-105">
            </div>

            <!-- Horizontal Thumbnail Strip -->
            <div class="flex gap-2 overflow-x-auto" id="image-gallery">
                <!-- Thumbnail images will be inserted here -->
            </div>
        </div>

        <!-- Details Section -->
        <div class="w-full space-y-4">
            <!-- Rest of the content -->
            <div class="bg-gray-50 p-3 rounded-lg">
                <h4 class="font-semibold text-base mb-2">Price Details</h4>
                <div class="space-y-1">
                    <p id="price-per-night" class="text-xl font-bold"></p>
                    <p id="booking-duration" class="text-gray-600 text-sm"></p>
                    <p id="cleaning-fee" class="text-gray-600 text-sm"></p>
                </div>
            </div>

            <!-- Two Column Layout for Other Details -->
            <div class="grid grid-cols-2 gap-6">
                <div class="space-y-4">
                    <!-- Location Section -->
                    <div>
                        <h4 class="font-semibold text-base mb-1">Location</h4>
                        <div class="space-y-0.5 text-gray-600 text-sm" id="location-details">
                        </div>
                    </div>

                    <!-- Capacity -->
                    <div>
                        <h4 class="font-semibold text-base mb-1">Capacity</h4>
                        <p id="venue-capacity" class="text-gray-600 text-sm"></p>
                    </div>
                </div>

                <div class="space-y-4">
                    <!-- Amenities -->
                    <div>
                        <h4 class="font-semibold text-base mb-1">Amenities</h4>
                        <ul id="amenities-list" class="text-gray-600 text-sm space-y-0.5">
                        </ul>
                    </div>

                    <!-- Contact Information -->
                    <div>
                        <h4 class="font-semibold text-base mb-1">Contact Information</h4>
                        <div class="space-y-0.5 text-gray-600 text-sm" id="contact-details">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex justify-center gap-3 pt-2">
                <div id="book-again-container" class="hidden">
                    <button
                        class="px-4 py-1.5 bg-black text-white rounded-lg hover:bg-gray-800 transition-colors duration-200 text-sm">
                        Book Again
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Reviews Section -->
    <div id="reviews-section" class="mt-6 pt-4 border-t">
        <h4 class="font-semibold text-base mb-3">Reviews</h4>
        <div id="reviews-container" class="space-y-3">
            <!-- Reviews will be dynamically loaded here -->
        </div>
    </div>
</div>