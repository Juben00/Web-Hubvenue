<!-- Footer Container -->
<footer class="bg-gray-900 text-white w-full mt-24 relative bottom-0">
    <!-- Main Footer Content -->
    <div class="max-w-7xl mx-auto py-16 px-4 sm:px-6 lg:px-8">
        <!-- Grid Layout for Footer Sections -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 mb-12">
            <!-- About Section -->
            <div class="space-y-6">
                <img src="./images/white_ico.png" alt="HubVenue_Logo" class="h-12" />
                <p class="text-gray-400 text-sm leading-relaxed">
                    Discover and book unique venues for your next event. HubVenue connects you with the perfect spaces.
                </p>
                <div class="flex items-center space-x-8">
                    <a href="https://www.facebook.com/profile.php?id=61567751555773" 
                        class="text-gray-400 hover:text-white transition-colors p-2 hover:bg-gray-800 rounded-full">
                        <i class="fab fa-facebook-f text-xl"></i>
                    </a>
                    <a href="#" 
                        class="text-gray-400 hover:text-white transition-colors p-2 hover:bg-gray-800 rounded-full">
                        <i class="fab fa-twitter text-xl"></i>
                    </a>
                    <a href="https://www.instagram.com/hubvenue/" 
                        class="text-gray-400 hover:text-white transition-colors p-2 hover:bg-gray-800 rounded-full">
                        <i class="fab fa-instagram text-xl"></i>
                    </a>
                    <a href="#" 
                        class="text-gray-400 hover:text-white transition-colors p-2 hover:bg-gray-800 rounded-full">
                        <i class="fab fa-linkedin-in text-xl"></i>
                    </a>
                </div>
            </div>

            <!-- Quick Links -->
            <div class="flex flex-col">
                <h3 class="text-lg font-semibold mb-6">Quick Links</h3>
                <ul class="space-y-4">
                    <li>
                        <a href="./about.php" class="text-gray-400 hover:text-white text-sm transition-colors">About Us</a>
                    </li>
                    <li>
                        <a href="./venues.php" class="text-gray-400 hover:text-white text-sm transition-colors">Find Venues</a>
                    </li>
                    <li>
                        <a href="./list-venue.php" class="text-gray-400 hover:text-white text-sm transition-colors">List Your Venue</a>
                    </li>
                    <li>
                        <a href="./blog.php" class="text-gray-400 hover:text-white text-sm transition-colors">Blog</a>
                    </li>
                </ul>
            </div>

            <!-- Support -->
            <div class="flex flex-col">
                <h3 class="text-lg font-semibold mb-6">Support</h3>
                <ul class="space-y-4">
                    <li>
                        <a href="./help.php" class="text-gray-400 hover:text-white text-sm transition-colors">Help Center</a>
                    </li>
                    <li>
                        <a href="./contact.php" class="text-gray-400 hover:text-white text-sm transition-colors">Contact Us</a>
                    </li>
                    <li>
                        <a href="./privacy.php" class="text-gray-400 hover:text-white text-sm transition-colors">Privacy Policy</a>
                    </li>
                    <li>
                        <a href="./terms.php" class="text-gray-400 hover:text-white text-sm transition-colors">Terms of Service</a>
                    </li>
                </ul>
            </div>

            <!-- Newsletter -->
            <div class="flex flex-col">
                <h3 class="text-lg font-semibold mb-6">Newsletter</h3>
                <p class="text-gray-400 text-sm mb-6">Subscribe to our newsletter for updates and special offers.</p>
                <form class="space-y-4">
                    <div class="relative">
                        <input type="email" placeholder="Enter your email" 
                            class="w-full px-4 py-3 rounded-lg bg-gray-800 text-white border border-gray-700 focus:outline-none focus:border-blue-500 text-sm">
                    </div>
                    <button type="submit" 
                        class="w-full px-4 py-3 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors duration-200">
                        Subscribe
                    </button>
                </form>
            </div>
        </div>

        <!-- Footer Bottom -->
        <div class="border-t border-gray-800 pt-8">
            <div class="flex flex-col md:flex-row justify-between items-center space-y-4 md:space-y-0">
                <p class="text-gray-400 text-sm text-center md:text-left">© <?php echo date("Y"); ?> HubVenue. All rights reserved.</p>
               
            </div>
        </div>
    </div>
</footer> 