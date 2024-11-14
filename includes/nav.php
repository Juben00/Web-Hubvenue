<?php
// Get the current page name
$current_page = basename($_SERVER['PHP_SELF']);

// Function to check if link is active
function isActive($page_name) {
    global $current_page;
    return $current_page === $page_name ? 'border-black text-gray-900' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700';
}
?>

<nav id="main-nav" class="backdrop-blur-xl z-40 fixed w-full px-8">
    <div class="mx-auto flex items-center justify-between">
        <!-- Logo -->
        <img src="./images/black_ico.png" alt="HubVenue_Logo" class="h-[80px]" />
        
        <!-- Navigation Links -->
        <div class="hidden sm:ml-6 sm:flex sm:space-x-8">

        <a href="/web-hubvenue/rent-history.php" 
                class="<?php echo isActive('rent-history.php'); ?> inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                Rent History
            </a>

            <a href="/web-hubvenue/venue-owner.php" 
                class="<?php echo isActive('venue-owner.php'); ?> inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                Today
            </a>
            <a href="/web-hubvenue/calendar.php" 
                class="<?php echo isActive('calendar.php'); ?> inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                Calendar
            </a>
            <a href="/web-hubvenue/listings.php" 
                class="<?php echo isActive('listings.php'); ?> inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                Listings
            </a>
            <a href="/web-hubvenue/messages.php" 
                class="<?php echo isActive('messages.php'); ?> inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                Messages
            </a>
        </div>

        <!-- Right side menu -->
        <div class="flex items-center">
            <button class="p-2 rounded-full hover:bg-gray-100">
                <span class="sr-only">Notifications</span>
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                </svg>
            </button>
            <button class="ml-3 p-2 rounded-full bg-gray-900 text-white">
                user icon
            </button>
        </div>
    </div>
</nav>
