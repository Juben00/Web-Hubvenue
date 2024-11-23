<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Venue Owner Profile - HubVenue</title>
    <link rel="stylesheet" href="./output.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    <link rel="icon" href="./images/black_ico.png">
</head>

<body class="bg-white">
    <?php
    session_start();
    // Include navbar based on login status
    if (isset($_SESSION['user'])) {
        include_once './components/navbar.logged.in.php';
    } else {
        include_once './components/navbar.html';
    }
    ?>

    <div class="container mx-auto px-4 py-8 pt-24">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            <!-- Venue Owner Profile Card -->
            <div class="bg-white rounded-xl shadow-xl p-6 md:col-span-1">
                <div class="flex flex-col items-center mt-16 space-y-4 mb-4">
                    <img src="/placeholder.svg?height=80&width=80" alt="John Doe"
                        class="w-20 h-20 rounded-full object-cover border-2 border-gray-200">
                    <div class="text-center">
                        <h2 class="text-xl font-bold">John Doe</h2>
                        <p class="text-gray-500">Venue Owner since 2020</p>
                    </div>
                </div>
                <p class="text-sm text-gray-600 mb-4">
                    Passionate about creating unforgettable experiences through unique venues. I specialize in urban and
                    rustic spaces perfect for any occasion.
                </p>
                <div class="flex items-center space-x-2 mb-2">
                    <i class="fas fa-star text-yellow-400"></i>
                    <span class="font-semibold">4.9</span>
                    <span class="text-sm text-gray-500">(120 reviews)</span>
                </div>
                <div class="flex items-center space-x-2 mb-2">
                    <i class="fas fa-map-marker-alt text-gray-400"></i>
                    <span class="text-sm text-gray-500">San Francisco, CA</span>
                </div>
                <div class="flex items-center space-x-2 mb-4">
                    <i class="fas fa-clock text-gray-400"></i>
                    <span class="text-sm text-gray-500">Usually responds within 1 hour</span>
                </div>
                <button
                    class="w-full mt-12 bg-black text-white py-2 px-4 rounded-lg hover:bg-gray-800 transition duration-300 flex items-center justify-center">
                    <i class="fas fa-comment-alt mr-2"></i>
                    Contact John
                </button>
            </div>

            <!-- Venue Listings -->
            <div class="md:col-span-3 ml-12 ">
                <h2 class="text-2xl mt-12 font-bold mb-6">John's Venues</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <!-- Venue Cards -->
                    <div class="bg-transparent rounded-xl overflow-hidden transition duration-300">
                        <img src="/placeholder.svg?height=400&width=600" alt="Urban Loft Space"
                            class="w-full h-48 object-cover">
                        <div class="p-6">
                            <h3 class="text-xl font-semibold mb-2">Urban Loft Space</h3>
                            <p class="text-gray-600 mb-4">Perfect for photoshoots and small gatherings</p>
                            <div class="flex justify-between items-center mb-2">
                                <div class="flex items-center space-x-2">
                                    <i class="fas fa-map-marker-alt text-gray-400"></i>
                                    <span class="text-sm text-gray-500">Downtown SF</span>
                                </div>
                                <span
                                    class="bg-blue-50 text-blue-800 text-xs font-semibold px-2.5 py-0.5 rounded-full">₱200/hour</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <div class="flex items-center space-x-2">
                                    <i class="fas fa-users text-gray-400"></i>
                                    <span class="text-sm text-gray-500">Up to 50 guests</span>
                                </div>
                                <div class="flex items-center space-x-1">
                                    <i class="fas fa-star text-yellow-400"></i>
                                    <span class="font-semibold">4.8</span>
                                    <span class="text-sm text-gray-500">(45)</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Additional venue cards follow the same pattern... -->
                </div>
            </div>
        </div>

        <!-- Reviews Section -->
        <div class="mt-12">
            <h2 class="text-2xl font-bold mb-6">Reviews</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Review Cards -->
                <div class="bg-transparent rounded-xl shadow-sm p-6">
                    <div class="flex items-center space-x-4 mb-4">
                        <img src="/placeholder.svg?height=40&width=40" alt="Sarah Johnson"
                            class="w-10 h-10 rounded-full object-cover">
                        <div>
                            <h3 class="text-lg font-semibold">Sarah Johnson</h3>
                            <p class="text-gray-500">Reviewed Urban Loft Space</p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-1 mb-2">
                        <i class="fas fa-star text-yellow-400"></i>
                        <i class="fas fa-star text-yellow-400"></i>
                        <i class="fas fa-star text-yellow-400"></i>
                        <i class="fas fa-star text-yellow-400"></i>
                        <i class="fas fa-star text-yellow-400"></i>
                        <span class="ml-2 text-sm text-gray-500">1 month ago</span>
                    </div>
                    <p class="text-gray-700">
                        The Urban Loft Space was perfect for our company photoshoot. John was incredibly helpful and
                        accommodating. The natural light in the space is amazing!
                    </p>
                </div>

                <!-- Additional review cards... -->
            </div>
            <div class="mt-6 text-center">
                <button
                    class="bg-white text-black border border-black py-2 px-6 rounded-lg hover:bg-gray-50 transition duration-300">
                    View All Reviews
                </button>
            </div>
        </div>
    </div>
    <script src="./vendor/jQuery-3.7.1/jquery-3.7.1.min.js"></script>
    <script>
        // Your existing JavaScript with improved event handling...
    </script>
</body>

</html>