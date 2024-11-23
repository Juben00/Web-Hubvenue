<?php
session_start();
// Get the current page name
$current_page = basename($_SERVER['PHP_SELF']);

// Function to check if link is active
function isActive($page_name)
{
  global $current_page;
  return $current_page === $page_name ? 'border-black text-gray-900' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700';
}
?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<nav id="main-nav" class="bg-transparent backdrop-blur-xl z-40 fixed w-full px-2 lg:px-8">
  <div class="flex items-center justify-between md:px-4">
    <!-- Left Section - Logo -->
    <a href="/web-hubvenue/" class="flex items-center space-x-2 hover:cursor-pointer" id="HubvenueLogo">
      <img src="../images/black_ico.png" alt="HubVenue_Logo" class="h-[80px]" />
    </a>


    <!-- Right Section -->
    <div class="flex items-center space-x-4">
      <!-- Notification Button -->
      <button type="button" class="flex text-sm bg-gray-800 rounded-full focus:ring-4 focus:ring-gray-300 p-2">
        <span class="sr-only">Notifications</span>
        <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9">
          </path>
        </svg>
      </button>

      <!-- User Menu Button -->
      <button class="flex items-center space-x-4" id="menutabtrigger">
        <div class="relative flex items-center space-x-2 bg-slate-50 shadow-md rounded-full ps-4 p-1">
          <i class="fas fa-bars text-gray-600"> </i>
          <div class="relative">
            <div class="h-8 w-8 rounded-full bg-black text-white flex items-center justify-center">
              <?php
              if (isset($_SESSION['user'])) {
                echo $_SESSION['user']['firstname'][0];
              } else {
                echo "U";
              }
              ?>
            </div>
          </div>
        </div>
      </button>
    </div>
  </div>
</nav>
<div class="fixed inset-0 bg-black bg-opacity-30 z-40 hidden" id="menutab">
  <div class="z-50 w-64 bg-white rounded-lg shadow-lg absolute right-8 md:right-12 top-20 overflow-hidden">
    <ul class="divide-y divide-gray-200 hover:cursor-pointer">
      <li class="px-4 py-3 flex justify-between items-center hover:bg-slate-100 hover:font-semibold duration-150"
        data-url="/web-hubvenue/profile/profile.php" id="profileBtn">
        <span>Profile</span>
      </li>
      <li class="px-4 py-3 flex justify-between items-center hover:bg-slate-100 hover:font-semibold duration-150"
        data-url="/web-hubvenue/profile/notifications.php" id="notificationsBtn">
        <span>Notifications</span>
        <span class="bg-red-500 text-white text-xs px-2 py-1 rounded-full">2</span>
      </li>
      <li class="px-4 py-3 flex justify-between items-center hover:bg-slate-100 hover:font-semibold duration-150"
        data-url="/web-hubvenue/host-account-application.php" id="hostAccountBtn">
        <span>Host Account</span>
      </li>
      <li class="px-4 py-3 flex justify-between items-center hover:bg-slate-100 hover:font-semibold duration-150"
        data-url="/web-hubvenue/help-center.php" id="helpCenterBtn">
        <span>Help Center</span>
      </li>
      <li class="px-4 py-3 flex justify-between items-center hover:bg-slate-100 hover:font-semibold duration-150"
        data-url="/web-hubvenue/profile/settings.php" id="settingsBtn">
        <span>Settings</span>
      </li>
      <li
        class="px-4 py-3 flex justify-between items-center hover:bg-slate-100 hover:font-semibold duration-150 text-red-500"
        id="logoutBtn">
        <span>Log out</span>
      </li>
    </ul>
  </div>
</div>