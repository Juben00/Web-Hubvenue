<?php
require_once './classes/account.class.php';

$account = new Account();


$account = new Account();
$USER_ID = isset($_SESSION['user']) ? $_SESSION['user'] : null;

$profileTemplate = $account->getProfileTemplate($USER_ID);

$userRole = $accountObj->getUserRole($USER_ID);

$HOST_ROLE = "Host";

?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<nav id="main-nav" class="bg-transparent backdrop-blur-xl z-40 fixed w-full px-2 lg:px-8">
  <div class="flex items-center justify-between md:px-4">
    <!-- Left Section - Logo -->
    <a class="flex items-center space-x-2 hover:cursor-pointer" id="HubvenueLogo">
      <img src='./images/black_ico.png' alt="HubVenue_Logo" class="h-[80px]" />
    </a>

    <!-- Center Section - Navigation Links -->
    <div class="flex items-center justify-between" id="navbar-sticky">
      <ul class="flex space-x-8 font-medium text-center">
        <li>
          <a id="rent-history" data-profileUrl="rent-history"
            class="profileNav active w-[120px] cursor-pointer block py-2 px-3">
            Rent History
          </a>
        </li>

        <?php
        if ($userRole == $HOST_ROLE) {
          echo '
            <li>
              <a id="venue-owner" data-profileUrl="venue-owner"
                class="profileNav w-[100px]  cursor-pointer block py-2 px-3">
                Today
              </a>
            </li>
            <li>';
        }
        ?>

        <a id="bookmarks" data-profileUrl="bookmarks" class="profileNav w-[100px] cursor-pointer block py-2 px-3">
          Bookmarks
        </a>
        </li>

        <?php
        if ($userRole == $HOST_ROLE) {
          echo '
        <li>
          <a id="listing" data-profileUrl="listings" class="profileNav w-[100px] cursor-pointer block py-2 px-3">
            Listings
          </a>
        </li>';
        }
        ?>
       
      </ul>
    </div>

    <!-- Right Section -->
    <div class="flex items-center space-x-4">
           <!-- Message Button -->
       <a href="./messages.php" class="flex text-sm bg-gray-900 rounded-full focus:ring-4 focus:ring-gray-300 p-2 text-white">
         <span class="sr-only">Messages</span>
         <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
           <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
             d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z">
           </path>
         </svg>
       </a>


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
              if (!isset($profileTemplate['profile_pic'])) {
                echo '<p classname="uppercase">' . $profileTemplate['initial'] . '</p>';
              } else {
                echo '<img id="profileImage" name="profile_image" src="./' . htmlspecialchars($profileTemplate['profile_pic']) . '" alt="Profile Picture" class="w-full h-full rounded-full object-cover">';
              }
              ?>
            </div>
          </div>
        </div>
      </button>
    </div>
  </div>
</nav>