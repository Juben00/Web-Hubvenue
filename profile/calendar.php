<div class="flex pt-20">
    <!-- Main Calendar Section -->
    <div class="flex-1">
        <!-- Header Section -->
        <div class="flex justify-between items-center p-4">
            <div>
                <h1 class="text-2xl font-semibold">October 2024</h1>
                <a href="#" class="text-sm underline">2 discounts</a>
            </div>
            <div class="flex items-center gap-4">
                <!-- User Selector -->
                <div class="flex items-center gap-2">
                    <img src="/SEUser/assets/images/profile.jpg" alt="Profile" class="w-8 h-8 rounded-full">
                    <span>asdas</span>
                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none">
                        <path d="M6 9l6 6 6-6" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                    </svg>
                </div>

                <!-- View Button -->
                <button class="flex items-center gap-2">
                    <span>View</span>
                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none">
                        <path d="M6 9l6 6 6-6" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                    </svg>
                </button>

                <!-- Camera Icon -->
                <button>
                    <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <circle cx="12" cy="12" r="3"></circle>
                        <path d="M19 4H5a2 2 0 00-2 2v12a2 2 0 002 2h14a2 2 0 002-2V6a2 2 0 00-2-2z"></path>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Calendar Grid -->
        <div class="px-4">
            <!-- Days Header -->
            <div class="grid grid-cols-7 text-sm">
                <div class="py-2">Su</div>
                <div class="py-2">Mo</div>
                <div class="py-2">Tu</div>
                <div class="py-2">We</div>
                <div class="py-2">Th</div>
                <div class="py-2">Fr</div>
                <div class="py-2">Sa</div>
            </div>

            <!-- Calendar Days -->
            <div class="grid grid-cols-7 bg-gray-100 gap-[1px]">
                <?php
                // Empty cells for days before October 1st
                for ($i = 0; $i < 2; $i++) {
                    echo '<div class="bg-gray-100 h-24"></div>';
                }

                // October days
                for ($day = 1; $day <= 31; $day++) {
                    echo '<div class="bg-white p-3 hover:bg-gray-50">
                            <div class="text-sm mb-2">' . $day . '</div>
                            <div class="text-sm">₱2,341</div>
                        </div>';
                }
                ?>
            </div>
        </div>
    </div>

    <!-- Settings Panel -->
    <div class="w-[400px] border-l min-h-screen">
        <div class="p-6">
            <h2 class="text-xl font-semibold mb-2">Settings</h2>
            <p class="text-gray-600 text-sm mb-6">These apply to all nights, unless you customize them by date.</p>

            <!-- Tabs -->
            <div class="border-b mb-6">
                <div class="flex gap-6">
                    <button class="border-b-2 border-black pb-2 text-sm font-medium">Pricing</button>
                    <button class="text-sm text-gray-600 pb-2">Availability</button>
                </div>
            </div>

            <!-- Base Price Section -->
            <div class="mb-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-medium">Base price</h3>
                    <span class="text-sm">PHP</span>
                </div>
                <div class="bg-white rounded-lg border p-4 mb-4">
                    <div class="text-sm text-gray-600">Per night</div>
                    <div class="text-2xl font-semibold">₱2,341</div>
                </div>
            </div>

            <!-- Custom Weekend Price -->
            <div class="flex justify-between items-center p-4 border rounded-lg mb-4">
                <span class="text-sm">Custom weekend price</span>
                <button class="text-sm font-semibold">Add</button>
            </div>

            <!-- Smart Pricing -->
            <div class="flex justify-between items-center p-4 border rounded-lg mb-6">
                <span class="text-sm">Smart Pricing</span>
                <button class="w-10 h-6 bg-gray-200 rounded-full relative">
                    <span class="absolute left-1 top-1 w-4 h-4 bg-white rounded-full"></span>
                </button>
            </div>

            <!-- Discounts Section -->
            <div>
                <div class="mb-2">
                    <h3 class="text-lg font-medium">Discounts</h3>
                    <p class="text-sm text-gray-600">Adjust your pricing to attract more guests.</p>
                </div>

                <!-- Weekly Discount -->
                <div class="bg-white rounded-lg border p-4 mb-4">
                    <div class="flex justify-between items-center">
                        <div>
                            <div class="font-medium">Weekly</div>
                            <div class="text-sm text-gray-600">For 7 nights or more</div>
                        </div>
                        <div class="text-2xl font-semibold">10%</div>
                    </div>
                    <div class="text-sm text-gray-600 mt-2">Weekly average is ₱14,748</div>
                </div>

                <!-- Monthly Discount -->
                <div class="bg-white rounded-lg border p-4">
                    <div class="flex justify-between items-center">
                        <div>
                            <div class="font-medium">Monthly</div>
                            <div class="text-sm text-gray-600">For 28 nights or more</div>
                        </div>
                        <div class="text-2xl font-semibold">20%</div>
                    </div>
                    <div class="text-sm text-gray-600 mt-2">Monthly average is ₱56,184</div>
                </div>
            </div>
        </div>
    </div>
</div>