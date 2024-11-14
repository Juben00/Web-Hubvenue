<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rent History - HubVenue</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <base href="/">
</head>

<body class="bg-gray-50">
    <?php include __DIR__ . '/../components/profile.nav.php'; ?>

    <main class="max-w-7xl mx-auto py-6 sm:px-6 pt-20 lg:px-8">
        <div class="px-4 sm:px-0">
            <h1 class="text-2xl font-bold text-gray-900 mb-6">Your Rent History</h1>

            <!-- Tabs -->
            <div class="border-b border-gray-200 mb-6">
                <nav class="-mb-px flex space-x-8">
                    <button onclick="showTab('current')"
                        class="tab-btn border-black text-gray-900 whitespace-nowrap pb-4 px-1 border-b-2 font-medium text-sm">
                        Current Rental
                    </button>
                    <button onclick="showTab('previous')"
                        class="tab-btn border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap pb-4 px-1 border-b-2 font-medium text-sm">
                        Previous Rentals
                    </button>
                </nav>
            </div>

            <!-- Current Rental Tab -->
            <div id="current-tab" class="tab-content">
                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h2 class="text-xl font-semibold">Garden Orchid Room 301</h2>
                            <span
                                class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-sm font-medium">Active</span>
                        </div>
                        <div class="flex flex-col md:flex-row gap-6">
                            <img src="/placeholder.svg?height=150&width=150" alt="Garden Orchid Room"
                                class="w-full md:w-40 h-40 object-cover rounded-lg">
                            <div>
                                <p class="text-lg font-medium">Garden Orchid Hotel and Resort Corporation</p>
                                <p class="text-gray-600 mt-2">Governor Camins Avenue, Zone II, Baliwasan</p>
                                <p class="text-gray-600">Zamboanga City, Zamboanga Peninsula, 7000</p>
                                <p class="text-gray-600 mt-2">₱4,800/night</p>
                                <button onclick="showDetails('current')"
                                    class="mt-4 px-4 py-2 bg-black text-white rounded-lg hover:bg-gray-800">View
                                    Details</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Previous Rentals Tab -->
            <div id="previous-tab" class="tab-content hidden">
                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <div class="p-6">
                        <div class="space-y-6">
                            <div class="flex flex-col md:flex-row gap-6 border-b pb-6">
                                <img src="/placeholder.svg?height=150&width=150" alt="Previous Property"
                                    class="w-full md:w-40 h-40 object-cover rounded-lg">
                                <div>
                                    <p class="text-lg font-medium">Garden View Suite 205</p>
                                    <p class="text-gray-600 mt-2">Jan 2023 - Dec 2023</p>
                                    <p class="text-gray-600">₱4,500/night</p>
                                    <div class="mt-4 space-x-4">
                                        <button onclick="showDetails('prev1')"
                                            class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50">View
                                            Details</button>
                                        <button onclick="bookAgain('prev1')"
                                            class="px-4 py-2 bg-black text-white rounded-lg hover:bg-gray-800">Book
                                            Again</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Details Modal -->
            <div id="details-modal"
                class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
                <div class="relative top-20 mx-auto p-5 border w-full max-w-4xl shadow-lg rounded-md bg-white">
                    <div class="flex justify-between items-center pb-3">
                        <h3 class="text-2xl font-bold" id="modal-title">Venue Details</h3>
                        <button onclick="closeModal()" class="text-black close-modal">&times;</button>
                    </div>
                    <div id="modal-content" class="mt-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <div class="mb-4">
                                    <img id="modal-main-image" src="/placeholder.svg?height=300&width=400"
                                        alt="Venue Main Image" class="w-full h-64 object-cover rounded-lg">
                                </div>
                                <div class="grid grid-cols-3 gap-2">
                                    <img src="/placeholder.svg?height=100&width=100" alt="Venue Image 1"
                                        class="w-full h-20 object-cover rounded-lg cursor-pointer"
                                        onclick="changeMainImage(this.src)">
                                    <img src="/placeholder.svg?height=100&width=100" alt="Venue Image 2"
                                        class="w-full h-20 object-cover rounded-lg cursor-pointer"
                                        onclick="changeMainImage(this.src)">
                                    <img src="/placeholder.svg?height=100&width=100" alt="Venue Image 3"
                                        class="w-full h-20 object-cover rounded-lg cursor-pointer"
                                        onclick="changeMainImage(this.src)">
                                </div>
                                <h4 class="font-semibold mt-4 mb-2">Venue Capacity</h4>
                                <p>3 guests</p>

                                <h4 class="font-semibold mt-4 mb-2">What this place offers</h4>
                                <ul class="space-y-2">
                                    <li>Pool</li>
                                    <li>WiFi</li>
                                    <li>Air-conditioned Room</li>
                                    <li>Smart TV</li>
                                </ul>
                            </div>
                            <div>
                                <h4 class="font-semibold mb-2">Location</h4>
                                <p>Garden Orchid Hotel and Resort Corporation</p>
                                <p>Governor Camins Avenue, Zone II</p>
                                <p>Baliwasan, Zamboanga City</p>
                                <p>Zamboanga Peninsula, 7000</p>

                                <h4 class="font-semibold mt-4 mb-2">Price Details</h4>
                                <p>₱4,800.00 per night</p>
                                <p>Cleaning fee: ₱500</p>
                                <p>Service fee applies</p>

                                <h4 class="font-semibold mt-4 mb-2">Contact Information</h4>
                                <p>Email: joevinansoc870@gmail.com</p>
                                <p>Phone: 09053258512</p>

                                <div id="book-again-container" class="mt-6 hidden">
                                    <button onclick="bookAgain('modal')"
                                        class="w-full px-4 py-2 bg-black text-white rounded-lg hover:bg-gray-800">Book
                                        Again</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script>
        function showTab(tabName) {
            document.querySelectorAll('.tab-content').forEach(tab => {
                tab.classList.add('hidden');
            });
            document.getElementById(tabName + '-tab').classList.remove('hidden');

            document.querySelectorAll('.tab-btn').forEach(btn => {
                btn.classList.remove('border-black', 'text-gray-900');
                btn.classList.add('border-transparent', 'text-gray-500');
            });

            event.currentTarget.classList.remove('border-transparent', 'text-gray-500');
            event.currentTarget.classList.add('border-black', 'text-gray-900');
        }

        function showDetails(type) {
            const modal = document.getElementById('details-modal');
            const bookAgainContainer = document.getElementById('book-again-container');
            modal.classList.remove('hidden');

            if (type === 'current') {
                document.getElementById('modal-title').textContent = 'Garden Orchid Room 301';
                bookAgainContainer.classList.add('hidden');
            } else {
                document.getElementById('modal-title').textContent = 'Garden View Suite 205';
                bookAgainContainer.classList.remove('hidden');
            }
        }

        function closeModal() {
            document.getElementById('details-modal').classList.add('hidden');
        }

        function changeMainImage(src) {
            document.getElementById('modal-main-image').src = src;
        }

        function bookAgain(type) {
            alert('Booking process initiated for ' + (type === 'modal' ? document.getElementById('modal-title').textContent : 'Garden View Suite 205'));
            // Implement actual booking logic here
        }

        window.onclick = function (event) {
            const modal = document.getElementById('details-modal');
            if (event.target === modal) {
                closeModal();
            }
        }
    </script>
</body>

</html>