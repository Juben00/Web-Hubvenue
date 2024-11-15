<nav id="main-nav" class="bg-transparent backdrop-blur-xl z-40 fixed w-full px-2 lg:px-8">
  <!-- logged in -->
  <div class="flex items-center justify-between md:px-4">
    <!-- Left Section -->
    <a href="./" class="flex items-center space-x-2 hover:cursor-pointer" id="HubvenueLogo">
      <img src="./images/black_ico.png" alt="HubVenue_Logo" class="h-[80px]" />
    </a>
    <!-- Center Section -->
    <div id="bottom-search"
      class="bg-slate-100 text-xs hidden border border-gray-300 p-1 rounded-full shadow-lg items-center max-w-2xl md:max-w-5xl mx-auto">
      <div class="flex-1 min-w-0 px-4">
        <button id="checkInBtn" class="w-full text-left font-normal">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block mr-2" fill="none" viewBox="0 0 24 24"
            stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
          </svg>
          <span id="checkInText">Check in</span>
        </button>
      </div>
      <div class="w-px h-10 bg-gray-300 mx-2"></div>
      <div class="flex-1 min-w-0 px-4">
        <button id="checkOutBtn" class="w-full text-left font-normal">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block mr-2" fill="none" viewBox="0 0 24 24"
            stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
          </svg>
          <span id="checkOutText">Check out</span>
        </button>
      </div>
      <div class="w-px h-10 bg-gray-300 mx-2"></div>
      <div class="flex-1 min-w-0 px-4 relative">
        <label for="guests" class="block text-sm font-medium text-gray-700">Who</label>
        <input type="text" id="guests" readonly placeholder="Add guests"
          class="w-full border-0 focus:ring-0 focus:outline-none text-lg bg-transparent cursor-pointer">

        <!-- Guest counter dropdown -->
        <div id="guestDropdown"
          class="hidden absolute top-full left-0 mt-2 w-72 bg-white rounded-2xl shadow-lg border border-gray-200 p-4 z-50">
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
      <button class="rounded-full bg-red-500 hover:bg-red-600 text-white p-2 mx-2">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
        </svg>
      </button>
    </div>
    <!-- Right Section -->
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
</nav>

<script>
  // Function to update navigation color based on scroll position
  function updateNavColor() {
    const mainNav = document.getElementById("main-nav");
    const firstSection = document.querySelector(".first-section");
    const bottomSearch = document.getElementById("bottom-search");
    const navButtons = mainNav.querySelectorAll(".nav-buttons");

    if (firstSection) {
      const firstSectionBottom = firstSection.offsetTop + firstSection.offsetHeight;
      const scrollPosition = window.scrollY;

      // Update nav buttons' color based on scroll position
      if (scrollPosition >= firstSectionBottom - mainNav.offsetHeight / 2) {
        navButtons.forEach((button) => {
          button.style.color = "#4A5568"; // Dark color
        });
      } else {
        navButtons.forEach((button) => {
          button.style.color = "white";
        });
      }

      // Show/hide the search bar based on scroll position
      if (scrollPosition >= firstSectionBottom - mainNav.offsetHeight / 2) {
        bottomSearch.classList.add("flex");
        bottomSearch.classList.remove("hidden");
      } else {
        bottomSearch.classList.add("hidden");
        bottomSearch.classList.remove("flex");
      }
    } else {
      console.warn("No element with class 'first-section' found.");
    }
  }

  // Add scroll event listener
  window.addEventListener("scroll", () => updateNavColor());
  // Initial call to set correct color on page load
  updateNavColor();
</script>