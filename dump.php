<div id="modal-content" class="mt-4">

    <p id="properties"></p>

    <!-- Main Image and Details Container -->
    <div class="flex flex-col items-center">

        <!-- Images Section -->
        <div class="w-full mb-6">
            <div class="relative h-80 rounded-lg overflow-hidden mb-4">
                <img id="modal-main-image" src="/venue_image_uploads/679277047a91f.jpeg" alt="Marcian Convention Center"
                    class="w-full h-full object-cover transition-transform duration-200 hover:scale-105">
            </div>

            <div class="flex gap-2 overflow-x-auto" id="image-gallery">
                <!-- Example Thumbnails -->
                <img src="/venue_image_uploads/679277047ae19.jpeg"
                    class="w-20 h-20 object-cover rounded-md cursor-pointer hover:opacity-75" alt="Thumbnail">
                <img src="/venue_image_uploads/679277047b18e.jpeg"
                    class="w-20 h-20 object-cover rounded-md cursor-pointer hover:opacity-75" alt="Thumbnail">
                <!-- Add more dynamically if needed -->
            </div>
        </div>

        <!-- Details Section -->
        <div class="w-full space-y-6">
            <div class="flex items-center gap-2">
                <span id="booking-status"
                    class="px-2.5 py-0.5 bg-green-200 rounded-full text-sm font-medium">Confirmed</span>
                <span id="booking-type" class="px-2.5 py-0.5 bg-blue-200 rounded-full text-sm font-medium">Event
                    Booking</span>
            </div>

            <div class="bg-gray-50 p-4 rounded-lg">
                <h4 class="font-semibold text-base mb-2">Price Details</h4>
                <div class="space-y-1">
                    <p id="price-per-night" class="text-xl font-bold">PHP 3,800.00</p>
                    <p id="booking-duration" class="text-gray-600 text-sm">Booking Duration: 1 Day</p>
                    <p id="cleaning-fee" class="text-gray-600 text-sm">Cleaning Fee: PHP 0.00</p>
                </div>
            </div>

            <!-- Two Column Layout for Other Details -->
            <div class="grid grid-cols-2 gap-6">
                <div class="space-y-4">
                    <div>
                        <h4 class="font-semibold text-base mb-1">Location</h4>
                        <p class="text-gray-600 text-sm">Marcian Convention Center, Governor Camins Avenue, Baliwasan,
                            Zamboanga City, 7000, Philippines</p>
                    </div>
                    <div>
                        <h4 class="font-semibold text-base mb-1">Capacity</h4>
                        <p id="venue-capacity" class="text-gray-600 text-sm">200 Participants</p>
                    </div>
                </div>
                <div class="space-y-4">
                    <div>
                        <h4 class="font-semibold text-base mb-1">Amenities</h4>
                        <ul id="amenities-list" class="text-gray-600 text-sm space-y-0.5">
                            <li>Wifi</li>
                            <li>TV</li>
                            <li>Kitchen</li>
                            <li>Pool</li>
                        </ul>
                    </div>
                    <div>
                        <h4 class="font-semibold text-base mb-1">Contact Information</h4>
                        <p id="contact-details" class="text-gray-600 text-sm">Phone: (example) +63 917 123 4567</p>
                    </div>
                </div>
            </div>

            <div class="flex justify-center gap-3 pt-2">
                <button
                    class="px-4 py-1.5 bg-black text-white rounded-lg hover:bg-gray-800 transition-colors duration-200 text-sm">
                    Book Again
                </button>
            </div>
        </div>
    </div>

    <!-- Reviews Section -->
    <div id="reviews-section" class="mt-6 pt-4 border-t">
        <h4 class="font-semibold text-base mb-3">Reviews</h4>
        <div id="reviews-container" class="space-y-3">
            <p>No reviews available at the moment.</p>
        </div>
    </div>
</div>