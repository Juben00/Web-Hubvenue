<?php
require_once './classes/account.class.php';

$account = new Account();
$USER_ID = isset($_SESSION['user']) ? $_SESSION['user'] : null;

$profileTemplate = $account->getProfileTemplate($USER_ID);
?>

<nav id="main-nav" class="bg-transparent backdrop-blur-xl z-40 fixed w-full px-2 lg:px-8">
  <!-- logged in -->
  <div class="flex items-center justify-between md:px-4">
    <!-- Left Section -->
    <a href="./" class="flex items-center space-x-2 hover:cursor-pointer" id="HubvenueLogo">
      <img src="./images/black_ico.png" alt="HubVenue_Logo" class="h-[80px]" />
    </a>
    <!-- Center Section -->
    <div id="bottom-search"
      class="bg-slate-50 text-xs hidden border border-gray-300 p-1 rounded-full shadow-lg items-center max-w-2xl md:max-w-5xl mx-auto">
      <div class="flex-1 min-w-0 px-4">
        <label for="location" class="block text-sm font-medium text-gray-700">Where</label>
        <input type="text" id="location" placeholder="Search location"
          class="w-full border-0 focus:ring-0 focus:outline-none  bg-transparent">
      </div>

      <div class=" h-10 bg-gray-300 mx-2"></div>
      <div class="flex-1 min-w-0 px-4">
        <label for="minPrice" class="block text-sm font-medium text-gray-700">Price Range</label>
        <div class="flex items-center gap-2">
          <input type="number" id="minPrice" placeholder="Min"
            class="w-20 border-0 focus:ring-0 focus:outline-none  bg-transparent">
          <span class="text-gray-500">-</span>
          <input type="number" id="maxPrice" placeholder="Max"
            class="w-20 border-0 focus:ring-0 focus:outline-none  bg-transparent">
        </div>
      </div>

      <div class=" h-10 bg-gray-300 mx-2"></div>
      <div class="flex-1 min-w-0 px-4 relative">
        <label for="guests" class="block text-sm font-medium text-gray-700">Who</label>
        <button id="guestsButton" class="w-full text-left border-0 focus:ring-0 focus:outline-none  bg-transparent">
          <span id="guestCount">Add guests</span>
        </button>
      </div>

      <button class="rounded-full bg-gray-500 hover:bg-gray-600 text-black p-2">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
        </svg>
      </button>

      <!-- Guest Dropdown (moved outside the button for better positioning) -->
      <div id="guestDropdown"
        class="hidden absolute top-full left-0 mt-2 w-72 bg-slate-50 rounded-2xl shadow-lg border border-gray-200 p-4 z-50">
        <!-- Adults -->
        <div class="flex items-center justify-between py-3 border-b">
          <div>
            <h3 class="font-medium">Adults</h3>
            <p class="text-gray-500 text-sm">Ages 13 or above</p>
          </div>
          <div class="flex items-center gap-3">
            <button
              class="guest-minus rounded-full w-8 h-8 border border-gray-300 flex items-center justify-center text-gray-500 hover:border-gray-400">-</button>
            <span class="guest-count w-4 text-center">0</span>
            <button
              class="guest-plus rounded-full w-8 h-8 border border-gray-300 flex items-center justify-center text-gray-500 hover:border-gray-400">+</button>
          </div>
        </div>

        <!-- Children -->
        <div class="flex items-center justify-between py-3 border-b">
          <div>
            <h3 class="font-medium">Children</h3>
            <p class="text-gray-500 text-sm">Ages 2-12</p>
          </div>
          <div class="flex items-center gap-3">
            <button
              class="guest-minus rounded-full w-8 h-8 border border-gray-300 flex items-center justify-center text-gray-500 hover:border-gray-400">-</button>
            <span class="guest-count w-4 text-center">0</span>
            <button
              class="guest-plus rounded-full w-8 h-8 border border-gray-300 flex items-center justify-center text-gray-500 hover:border-gray-400">+</button>
          </div>
        </div>

        <!-- Infants -->
        <div class="flex items-center justify-between py-3 border-b">
          <div>
            <h3 class="font-medium">Infants</h3>
            <p class="text-gray-500 text-sm">Under 2</p>
          </div>
          <div class="flex items-center gap-3">
            <button
              class="guest-minus rounded-full w-8 h-8 border border-gray-300 flex items-center justify-center text-gray-500 hover:border-gray-400">-</button>
            <span class="guest-count w-4 text-center">0</span>
            <button
              class="guest-plus rounded-full w-8 h-8 border border-gray-300 flex items-center justify-center text-gray-500 hover:border-gray-400">+</button>
          </div>
        </div>

        <!-- Pets -->
        <div class="flex items-center justify-between py-3">
          <div>
            <h3 class="font-medium">Pets</h3>
            <p class="text-gray-500 text-sm hover:underline cursor-pointer">Bringing a service animal?</p>
          </div>
          <div class="flex items-center gap-3">
            <button
              class="guest-minus rounded-full w-8 h-8 border border-gray-300 flex items-center justify-center text-gray-500 hover:border-gray-400">-</button>
            <span class="guest-count w-4 text-center">0</span>
            <button
              class="guest-plus rounded-full w-8 h-8 border border-gray-300 flex items-center justify-center text-gray-500 hover:border-gray-400">+</button>
          </div>
        </div>
      </div>
    </div>
    <!-- Right Section -->

    
    <div class="flex items-center space-x-4">


    
       <!-- Message Button -->
       <div class="relative">
         <a href="./messages.php" class="flex text-sm bg-white rounded-full focus:ring-4 focus:ring-gray-300 p-2 text-gray-900">
           <span class="sr-only">Messages</span>
           <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
             <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
               d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z">
             </path>
           </svg>
         </a>
         <?php
         // Get initial unread message count
         $db = new Database();
         $conn = $db->connect();
         $query = "SELECT COUNT(*) as total_unread
                  FROM messages m
                  JOIN conversations c ON m.conversation_id = c.id
                  JOIN conversation_participants cp ON c.id = cp.conversation_id
                  LEFT JOIN message_status ms ON m.id = ms.message_id AND ms.user_id = :user_id
                  WHERE cp.user_id = :user_id 
                  AND m.sender_id != :user_id
                  AND (ms.is_read = 0 OR ms.is_read IS NULL)";
         $stmt = $conn->prepare($query);
         $stmt->execute(['user_id' => $USER_ID]);
         $result = $stmt->fetch(PDO::FETCH_ASSOC);
         $unreadMessages = (int) $result['total_unread'];
         
         if ($unreadMessages > 0): ?>
           <span id="messageCount" class="absolute -top-2 -right-2 flex items-center justify-center bg-red-500 text-white text-xs font-medium rounded-full h-5 w-5">
             <?php echo $unreadMessages > 99 ? '99+' : $unreadMessages; ?>
           </span>
         <?php endif; ?>
       </div>
                            
       <!-- Notification Button -->
       <div class="relative">
           <button id="notificationButton" class="relative flex text-sm bg-white rounded-full focus:ring-4 focus:ring-gray-300 p-2 text-gray-900">
               <span class="sr-only">Notifications</span>
               <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                   <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                       d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9">
                   </path>
               </svg>
           </button>
           <?php
           require_once './classes/notification.class.php';
           $notification = new Notification();
           $unreadCount = $notification->getUnreadCount($USER_ID);
           if ($unreadCount > 0): ?>
               <span id="notificationCount" class="absolute -top-2 -right-2 flex items-center justify-center bg-red-500 text-white text-xs font-medium rounded-full h-5 w-5">
                   <?php echo $unreadCount > 99 ? '99+' : $unreadCount; ?>
               </span>
           <?php endif; ?>

           <!-- Notification Dropdown -->
           <?php include './components/notifications.dropdown.php'; ?>
       </div>

    <button class="flex items-center space-x-4" id="menutabtrigger">
      <div class="relative flex items-center space-x-2 bg-slate-50 shadow-md rounded-full ps-4 p-1">
        <i class="fas fa-bars text-gray-600"> </i>
        <div class="relative">
          <div class="h-8 w-8 rounded-full bg-gray-900 text-white flex items-center justify-center">
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

<script>
  // Function to update navigation color based on scroll position
  function updateNavColor() {
    const mainNav = document.getElementById("main-nav");
    const firstSection = document.getElementById("first-section");
    const bottomSearch = document.getElementById("bottom-search");

    if (firstSection) {
      const firstSectionBottom = firstSection.offsetTop + firstSection.offsetHeight;
      const scrollPosition = window.scrollY;

      // Show/hide the search bar based on scroll position
      if (scrollPosition >= firstSectionBottom - mainNav.offsetHeight / 2) {
        bottomSearch.classList.add("flex");
        bottomSearch.classList.remove("hidden");
      } else {
        bottomSearch.classList.add("hidden");
        bottomSearch.classList.remove("flex");
      }
    }
  }

  // Add scroll event listener
  window.addEventListener("scroll", () => updateNavColor());
  // Initial call to set correct color on page load
  updateNavColor();

  document.getElementById('guestsButton').addEventListener('click', function () {
    const dropdown = document.getElementById('guestDropdown');
    dropdown.classList.toggle('hidden');
  });

  // Update guest count when + or - buttons are clicked
  document.querySelectorAll('.guest-plus, .guest-minus').forEach(button => {
    button.addEventListener('click', function () {
      const countElement = this.parentElement.querySelector('.guest-count');
      let count = parseInt(countElement.textContent);

      if (this.classList.contains('guest-plus')) {
        count++;
      } else if (count > 0) {
        count--;
      }

      countElement.textContent = count;
      updateTotalGuestCount();
    });
  });

  function updateTotalGuestCount() {
    const counts = Array.from(document.querySelectorAll('.guest-count'))
      .map(el => parseInt(el.textContent));
    const total = counts.reduce((sum, current) => sum + current, 0);

    const guestCountElement = document.getElementById('guestCount');
    if (total === 0) {
      guestCountElement.textContent = 'Add guests';
    } else {
      guestCountElement.textContent = `${total} guest${total !== 1 ? 's' : ''}`;
    }
  }

  // Close dropdown when clicking outside
  document.addEventListener('click', function (event) {
    const dropdown = document.getElementById('guestDropdown');
    const guestsButton = document.getElementById('guestsButton');

    if (!dropdown.contains(event.target) && !guestsButton.contains(event.target)) {
      dropdown.classList.add('hidden');
    }
  });

  // Add message count update function
  async function updateMessageCount() {
    try {
      const response = await fetch(`./api/getTotalUnreadMessages.api.php?user_id=<?php echo $USER_ID; ?>`);
      const data = await response.json();
      
      if (data.success) {
        const messageCountElement = document.getElementById('messageCount');
        const count = data.total_unread;
        
        if (count > 0) {
          if (!messageCountElement) {
            // Create new badge if it doesn't exist
            const badge = document.createElement('span');
            badge.id = 'messageCount';
            badge.className = 'absolute -top-2 -right-2 flex items-center justify-center bg-red-500 text-white text-xs font-medium rounded-full h-5 w-5';
            badge.textContent = count > 99 ? '99+' : count;
            document.querySelector('.relative a[href="./messages.php"]').parentElement.appendChild(badge);
          } else {
            // Update existing badge
            messageCountElement.textContent = count > 99 ? '99+' : count;
            messageCountElement.style.display = 'flex';
          }
        } else if (messageCountElement) {
          // Hide badge if count is 0
          messageCountElement.style.display = 'none';
        }
      }
    } catch (error) {
      console.error('Error updating message count:', error);
    }
  }

  // Add notification count update function
  async function updateNotificationCount() {
    try {
      const response = await fetch(`./api/getNotificationCount.api.php?user_id=<?php echo $USER_ID; ?>`);
      const data = await response.json();
      
      if (data.success) {
        const notificationCountElement = document.getElementById('notificationCount');
        const count = data.unread_count;
        
        if (count > 0) {
          if (!notificationCountElement) {
            // Create new badge if it doesn't exist
            const badge = document.createElement('span');
            badge.id = 'notificationCount';
            badge.className = 'absolute -top-2 -right-2 flex items-center justify-center bg-red-500 text-white text-xs font-medium rounded-full h-5 w-5';
            badge.textContent = count > 99 ? '99+' : count;
            document.getElementById('notificationButton').parentElement.appendChild(badge);
          } else {
            // Update existing badge
            notificationCountElement.textContent = count > 99 ? '99+' : count;
            notificationCountElement.style.display = 'flex';
          }
        } else if (notificationCountElement) {
          // Hide badge if count is 0
          notificationCountElement.style.display = 'none';
        }
      }
    } catch (error) {
      console.error('Error updating notification count:', error);
    }
  }

  // Update message count every 1 second
  setInterval(updateMessageCount, 1000);

  // Update notification count every 1 second
  setInterval(updateNotificationCount, 1000);

  // Initial updates
  updateMessageCount();
  updateNotificationCount();
</script>