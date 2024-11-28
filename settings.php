<?php

require_once './sanitize.php';
require_once './classes/venue.class.php';
require_once './classes/account.class.php';

session_start();
$accountObj = new Account();

if (isset($_SESSION['user'])) {
    if ($_SESSION['user']['user_type_id'] == 3) {
        header('Location: admin/');
    }

}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HubVenue || Settings</title>
    <link rel="icon" href="./images/black_ico.png">
    <link rel="stylesheet" href="./output.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/luxon@3.3.0/build/global/luxon.min.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    <script src="//unpkg.com/alpinejs" defer></script>
</head>

<body class="bg-gray-50">
    <!-- Header -->
    <?php
    // Check if the 'user' key exists in the session
    if (isset($_SESSION['user'])) {
        include_once './components/navbar.logged.in.php';
    } else {
        include_once './components/navbar.html';
    }

    include_once './components/SignupForm.html';
    include_once './components/feedback.modal.html';
    include_once './components/confirm.feedback.modal.html';
    include_once './components/Menu.html';

    ?>

    <main class="w-full px-4 py-8 min-h-screen">
        <div class="max-w-7xl mt-16 mx-auto">
            <h1 class="text-3xl font-bold mb-8 text-gray-800">Settings</h1>

            <!-- Settings Navigation -->
            <div class="flex mb-8 border-b border-gray-200 bg-white rounded-lg p-2 gap-2 shadow-sm">
                <button
                    class="flex items-center gap-2 px-6 py-3 text-gray-600 rounded-lg transition-all duration-200 hover:bg-red-50 hover:text-red-500 data-[active=true]:bg-red-50 data-[active=true]:text-red-500 data-[active=true]:font-semibold"
                    data-tab="account" data-active="true">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    Account Settings
                </button>
                <button
                    class="flex items-center gap-2 px-6 py-3 text-gray-600 rounded-lg transition-all duration-200 hover:bg-red-50 hover:text-red-500 data-[active=true]:bg-red-50 data-[active=true]:text-red-500 data-[active=true]:font-semibold"
                    data-tab="notifications">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                    </svg>
                    Notifications
                </button>
                <button
                    class="flex items-center gap-2 px-6 py-3 text-gray-600 rounded-lg transition-all duration-200 hover:bg-red-50 hover:text-red-500 data-[active=true]:bg-red-50 data-[active=true]:text-red-500 data-[active=true]:font-semibold"
                    data-tab="privacy">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                    Privacy
                </button>
            </div>

            <!-- Settings Content -->
            <div class="bg-white rounded-xl shadow-lg p-8">
                <!-- Account Settings -->
                <div id="account-settings"
                    class="transition-all duration-200 ease-in-out transform opacity-100 translate-x-0">
                    <div class="max-w-7xl mx-auto">
                        <!-- Profile Picture Section -->
                        <div class="mb-12 flex flex-col items-center">
                            <div class="relative group">
                                <div class="w-64 h-64 rounded-full overflow-hidden border-4 border-white shadow-lg">
                                    <img id="profileImage" src="" alt="Profile Picture"
                                        class="w-full h-full object-cover">
                                </div>
                                <label for="profilePicture"
                                    class="absolute inset-0 flex items-center justify-center bg-black/50 text-white rounded-full opacity-0 group-hover:opacity-100 cursor-pointer transition-opacity duration-200">
                                    <span class="text-sm">Change Photo</span>
                                </label>
                                <input type="file" id="profilePicture" name="profilePicture" class="hidden"
                                    accept="image/*">
                            </div>
                            <p class="text-sm text-gray-500 mt-2">Click to upload new profile picture</p>
                        </div>

                        <form class="space-y-8">
                            <!-- Personal Information Section -->
                            <div class="space-y-6">
                                <h3 class="flex items-center gap-2 text-lg font-medium text-gray-800 border-b pb-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-600"
                                        viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    Personal Information
                                </h3>

                                <!-- Form inputs with Tailwind classes -->
                                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                                    <div class="space-y-2">
                                        <label class="block text-sm font-medium text-gray-700">First Name</label>
                                        <input type="text" name="firstname"
                                            class="w-full h-12 px-3 py-2 text-lg border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-colors">
                                    </div>
                                    <div class="space-y-2">
                                        <label class="block text-sm font-medium text-gray-700">Last Name</label>
                                        <input type="text" name="lastname"
                                            class="w-full h-12 px-3 py-2 text-lg border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-colors">
                                    </div>
                                    <div class="space-y-2">
                                        <label class="block text-sm font-medium text-gray-700">Middle Initial</label>
                                        <input type="text" name="middlename"
                                            class="w-full h-12 px-3 py-2 text-lg border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-colors">
                                    </div>
                                </div>

                                <!-- Sex and Birthday -->
                                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                                    <div class="space-y-2">
                                        <label class="block text-sm font-medium text-gray-700">Sex</label>
                                        <select name="sex"
                                            class="w-full h-12 px-3 py-2 text-lg border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-colors">
                                            <option value="" disabled selected>Select sex</option>
                                            <option value="Male">Male</option>
                                            <option value="Female">Female</option>
                                        </select>
                                    </div>
                                    <div class="space-y-2">
                                        <label class="block text-sm font-medium text-gray-700">Birthday</label>
                                        <input type="date" name="birthdate"
                                            class="w-full h-12 px-3 py-2 text-lg border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-colors">
                                    </div>
                                </div>
                            </div>

                            <!-- Contact Information Section -->
                            <div class="space-y-6 pt-6 border-t">
                                <h3 class="text-lg font-medium text-gray-700 border-b pb-2">Contact Information</h3>

                                <!-- Address -->
                                <div class="space-y-2">
                                    <label class="block text-sm font-medium text-gray-700">Address</label>
                                    <div class="flex gap-2">
                                        <input type="text" name="address"
                                            class="w-full h-12 px-3 py-2 text-lg border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-colors"
                                            placeholder="Enter your address">
                                        <button type="button"
                                            class="px-4 py-2 bg-red-50 rounded-lg hover:bg-red-100 transition-colors">
                                            <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>

                                <!-- Email and Contact -->
                                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                                    <div class="space-y-2">
                                        <label class="block text-sm font-medium text-gray-700">Email</label>
                                        <input type="email" name="email"
                                            class="w-full h-12 px-3 py-2 text-lg border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-colors"
                                            placeholder="your.email@example.com">
                                    </div>
                                    <div class="space-y-2">
                                        <label class="block text-sm font-medium text-gray-700">Contact Number</label>
                                        <input type="tel" name="contact"
                                            class="w-full h-12 px-3 py-2 text-lg border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-colors"
                                            placeholder="09XX XXX XXXX">
                                    </div>
                                </div>
                            </div>

                            <div class="pt-6 flex justify-end">
                                <button type="submit"
                                    class="inline-flex items-center justify-center gap-2 px-8 py-3 bg-red-600 text-white font-semibold rounded-lg transition-all duration-200 hover:-translate-y-0.5 hover:shadow-lg min-w-[200px]">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                        fill="currentColor">
                                        <path
                                            d="M7.707 10.293a1 1 0 10-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L11 11.586V6h-2v5.586l-1.293-1.293z" />
                                    </svg>
                                    Save Changes
                                </button>
                            </div>
                        </form>

                        <!-- Password Section -->
                        <div class="mt-16 pt-8 border-t border-gray-200">
                            <h3 class="text-lg font-medium mb-8 text-gray-800 border-b pb-2">Change Password</h3>
                            <form class="space-y-8">
                                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                                    <div class="space-y-2">
                                        <label class="block text-sm font-medium text-gray-700">Current Password</label>
                                        <input type="password" name="current_password"
                                            class="w-full h-12 px-3 py-2 text-lg border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-colors">
                                    </div>
                                    <div class="space-y-2">
                                        <label class="block text-sm font-medium text-gray-700">New Password</label>
                                        <input type="password" name="new_password"
                                            class="w-full h-12 px-3 py-2 text-lg border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-colors">
                                    </div>
                                    <div class="space-y-2">
                                        <label class="block text-sm font-medium text-gray-700">Confirm New
                                            Password</label>
                                        <input type="password" name="confirm_password"
                                            class="w-full h-12 px-3 py-2 text-lg border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-colors">
                                    </div>
                                </div>
                                <div class="flex justify-end">
                                    <button type="submit"
                                        class="inline-flex items-center justify-center gap-2 px-8 py-3 bg-red-600 text-white font-semibold rounded-lg transition-all duration-200 hover:-translate-y-0.5 hover:shadow-lg min-w-[200px]">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                            fill="currentColor">
                                            <path fill-rule="evenodd"
                                                d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        Update Password
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Notifications Settings -->
                <div id="notifications-settings"
                    class="transition-all duration-200 ease-in-out transform opacity-100 translate-x-0">
                    <div class="max-w-7xl mx-auto">
                        <h2 class="text-2xl font-semibold mb-6 text-gray-800">Notification Preferences</h2>
                        <form class="space-y-6">
                            <div class="space-y-6">
                                <div
                                    class="flex items-center justify-between p-4 rounded-lg bg-gray-50 hover:bg-gray-100 transition-colors duration-200">
                                    <div>
                                        <h3 class="text-lg font-medium text-gray-800">Email Notifications</h3>
                                        <p class="text-sm text-gray-600">Receive updates about your bookings via email
                                        </p>
                                    </div>
                                    <label class="relative inline-flex items-center cursor-pointer">
                                        <input type="checkbox" class="sr-only peer">
                                        <div
                                            class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-red-500">
                                        </div>
                                    </label>
                                </div>

                                <div
                                    class="flex items-center justify-between p-4 rounded-lg bg-gray-50 hover:bg-gray-100 transition-colors duration-200">
                                    <div>
                                        <h3 class="text-lg font-medium text-gray-800">SMS Notifications</h3>
                                        <p class="text-sm text-gray-600">Get text messages for important updates</p>
                                    </div>
                                    <label class="relative inline-flex items-center cursor-pointer">
                                        <input type="checkbox" class="sr-only peer">
                                        <div
                                            class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-red-500">
                                        </div>
                                    </label>
                                </div>
                            </div>
                            <div>
                                <button type="submit" class="form-button">
                                    Save Preferences
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Privacy Settings -->
                <div id="privacy-settings"
                    class="transition-all duration-200 ease-in-out transform opacity-100 translate-x-0">
                    <div class="max-w-7xl mx-auto">
                        <h2 class="text-2xl font-semibold mb-6 text-gray-800">Privacy Settings</h2>
                        <form class="space-y-6">
                            <div class="space-y-6">
                                <div
                                    class="flex items-center justify-between p-4 rounded-lg bg-gray-50 hover:bg-gray-100 transition-colors duration-200">
                                    <div>
                                        <h3 class="text-lg font-medium text-gray-800">Profile Visibility</h3>
                                        <p class="text-sm text-gray-600">Control who can see your profile information
                                        </p>
                                    </div>
                                    <select class="form-input w-auto">
                                        <option>Public</option>
                                        <option>Private</option>
                                        <option>Friends Only</option>
                                    </select>
                                </div>

                                <div
                                    class="flex items-center justify-between p-4 rounded-lg bg-gray-50 hover:bg-gray-100 transition-colors duration-200">
                                    <div>
                                        <h3 class="text-lg font-medium text-gray-800">Two-Factor Authentication</h3>
                                        <p class="text-sm text-gray-600">Add an extra layer of security to your account
                                        </p>
                                    </div>
                                    <label class="relative inline-flex items-center cursor-pointer">
                                        <input type="checkbox" class="sr-only peer">
                                        <div
                                            class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-red-500">
                                        </div>
                                    </label>
                                </div>
                            </div>
                            <div>
                                <button type="submit" class="form-button">
                                    Save Privacy Settings
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Get all tab buttons and content sections
            const tabButtons = document.querySelectorAll('[data-tab]');
            const contentSections = {
                account: document.getElementById('account-settings'),
                notifications: document.getElementById('notifications-settings'),
                privacy: document.getElementById('privacy-settings')
            };

            function switchTab(tabId) {
                // Update button states
                tabButtons.forEach(button => {
                    button.setAttribute('data-active', button.dataset.tab === tabId);
                });

                // First set all sections to start transitioning out
                Object.values(contentSections).forEach(section => {
                    if (!section.classList.contains('hidden')) {
                        section.style.opacity = '0';
                        section.style.transform = 'translateX(-20px)';
                    }
                });

                // Wait for fade out, then switch content
                setTimeout(() => {
                    // Hide all content sections
                    Object.values(contentSections).forEach(section => {
                        section.classList.add('hidden');
                        section.setAttribute('data-hidden', 'true');
                    });

                    // Show selected content
                    const selectedContent = contentSections[tabId];
                    selectedContent.classList.remove('hidden');
                    selectedContent.setAttribute('data-hidden', 'false');

                    // Trigger reflow
                    void selectedContent.offsetHeight;

                    // Start fade in
                    selectedContent.style.opacity = '1';
                    selectedContent.style.transform = 'translateX(0)';
                }, 200); // Match this with the CSS transition duration
            }

            // Add click handlers to all tab buttons
            tabButtons.forEach(button => {
                button.addEventListener('click', () => {
                    switchTab(button.dataset.tab);
                });
            });

            // Initialize with account tab active
            switchTab('account');
        });

        // Profile picture preview
        document.getElementById('profilePicture').addEventListener('change', function (e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    document.getElementById('profileImage').src = e.target.result;
                }
                reader.readAsDataURL(file);
            }
        });
    </script>
</body>

</html>