<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Archon HRIS Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#f41c1c',
                        secondary: '#F3F4F6',
                        'light-gray': '#F9FAFB',
                        'dark-gray': '#4B5563',
                    }
                }
            }
        };
    </script>
    <style>
        body {
            background-image: url('bg.jpg');
            background-size: cover;
            background-attachment: fixed;
        }
        
        .semi-transparent {
            background-color: rgba(255, 255, 255, 0.8);
        }

        .rounded-card {
            border-radius: 1rem;
        }

        .dark-mode {
            background: radial-gradient(circle at left, #121212 0%, #3D0000 50%, #000000 100%);
        }
        
        .dark-mode .bg-white {
            background-color: transparent;
        }

        .dark-mode .text-gray-600,
        .dark-mode .text-gray-700,
        .dark-mode .text-gray-800 {
            color: #D1D5DB;
        }

        .dark-mode table thead th,
        .dark-mode table tbody td {
            color: #FFFFFF;
        }

        .dark-mode .border-gray-800 {
            border-color: #4B5563;
        }

        .dark-mode .hover\:text-gray-800:hover {
            color: #F3F4F6;
        }

        .dark-mode .bg-gray-100 {
            background-color: transparent;
        }

        .dark-mode .semi-transparent {
            background-color: rgba(31, 41, 55, 0.8);
            color: #FFFFFF;
        }

        .dark-mode .bg-light-gray {
            background-color: rgba(55, 65, 81, 0.8);
            color: #FFFFFF;
        }

        .h3 {
            color: #c10000;
        }

        .dark-mode #h1 {
            color: white;
        }
    </style>
</head>
<body class="text-gray-800 gradient-background">
    <div class="flex h-screen">
        <?php include 'sidebar.php'; ?>
        
        <div class="flex-1">
            <?php include 'topbar.php'; ?>
            
            <!-- Main Content -->
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100 main-content">
                <div class="container mx-auto px-4 py-8">
                    <h1 class="text-2xl md:text-3xl font-semibold text-gray-800 mb-6">Settings</h1>
                    
                    <!-- General Settings Section -->
                    <section id="general-settings" class="bg-white rounded-lg shadow-md p-6 mb-8">
                        <h2 class="text-xl font-semibold text-gray-800 mb-4">General Settings</h2>
                        <form id="generalSettingsForm">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="businessName" class="block text-sm font-medium text-gray-700">Business Name</label>
                                    <input type="text" id="businessName" name="businessName" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50">
                                </div>
                                <div>
                                    <label for="businessAddress" class="block text-sm font-medium text-gray-700">Business Address</label>
                                    <input type="text" id="businessAddress" name="businessAddress" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50">
                                </div>
                                <div>
                                    <label for="workingHours" class="block text-sm font-medium text-gray-700">Working Hours</label>
                                    <input type="text" id="workingHours" name="workingHours" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50">
                                </div>
                                <div>
                                    <label for="timezone" class="block text-sm font-medium text-gray-700">Timezone</label>
                                    <select id="timezone" name="timezone" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50">
                                        <option>EST</option>
                                        <option>EST</option>
                                        <option>PST</option>
                                        <!-- Add more timezone options -->
                                    </select>
                                </div>
                                <div>
                                    <label for="currency" class="block text-sm font-medium text-gray-700">Currency</label>
                                    <select id="currency" name="currency" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50">
                                        <option>PHP</option>
                                        <option>EUR</option>
                                        <option>GBP</option>
                                        <!-- Add more currency options -->
                                    </select>
                                </div>
                            </div>
                            <button type="submit" class="mt-4 px-4 py-2 bg-primary text-white rounded-md hover:bg-primary-dark focus:outline-none focus:ring focus:ring-primary focus:ring-opacity-50">Save General Settings</button>
                        </form>
                    </section>

                    <!-- Booking Policies Section -->
                    <section id="booking-policies" class="bg-white rounded-lg shadow-md p-6 mb-8">
                        <h2 class="text-xl font-semibold text-gray-800 mb-4">Booking Policies</h2>
                        <form id="bookingPoliciesForm">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="minBookingWindow" class="block text-sm font-medium text-gray-700">Minimum Booking Window (hours)</label>
                                    <input type="number" id="minBookingWindow" name="minBookingWindow" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50">
                                </div>
                                <div>
                                    <label for="cancellationPolicy" class="block text-sm font-medium text-gray-700">Cancellation Policy</label>
                                    <textarea id="cancellationPolicy" name="cancellationPolicy" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50"></textarea>
                                </div>
                                <div>
                                    <label for="lateFee" class="block text-sm font-medium text-gray-700">Late Fee (%)</label>
                                    <input type="number" id="lateFee" name="lateFee" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50">
                                </div>
                            </div>
                            <button type="submit" class="mt-4 px-4 py-2 bg-primary text-white rounded-md hover:bg-primary-dark focus:outline-none focus:ring focus:ring-primary focus:ring-opacity-50">Save Booking Policies</button>
                        </form>
                    </section>

                    <!-- Payment Settings Section -->
                    <section id="payment-settings" class="bg-white rounded-lg shadow-md p-6 mb-8">
                        <h2 class="text-xl font-semibold text-gray-800 mb-4">Payment Settings</h2>
                        <form id="paymentSettingsForm">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="paymentGateway" class="block text-sm font-medium text-gray-700">Payment Gateway</label>
                                    <select id="paymentGateway" name="paymentGateway" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50">
                                        <option>G Cash</option>
                                        <option>PayPal</option>
                                        <!-- Add more payment gateway options -->
                                    </select>
                                </div>
                                <div>
                                    <label for="apiKey" class="block text-sm font-medium text-gray-700">API Key</label>
                                    <input type="text" id="apiKey" name="apiKey" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50">
                                </div>
                            </div>
                            <button type="submit" class="mt-4 px-4 py-2 bg-primary text-white rounded-md hover:bg-primary-dark focus:outline-none focus:ring focus:ring-primary focus:ring-opacity-50">Save Payment Settings</button>
                        </form>
                    </section>

                    <!-- Email Templates Section -->
                    <section id="email-templates" class="bg-white rounded-lg shadow-md p-6 mb-8">
                        <h2 class="text-xl font-semibold text-gray-800 mb-4">Email Templates</h2>
                        <form id="emailTemplatesForm">
                            <div class="grid grid-cols-1 gap-4">
                                <div>
                                    <label for="bookingConfirmation" class="block text-sm font-medium text-gray-700">Booking Confirmation Template</label>
                                    <textarea id="bookingConfirmation" name="bookingConfirmation" rows="5" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50"></textarea>
                                </div>
                                <div>
                                    <label for="reminderEmail" class="block text-sm font-medium text-gray-700">Reminder Email Template</label>
                                    <textarea id="reminderEmail" name="reminderEmail" rows="5" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50"></textarea>
                                </div>
                            </div>
                            <button type="submit" class="mt-4 px-4 py-2 bg-primary text-white rounded-md hover:bg-primary-dark focus:outline-none focus:ring focus:ring-primary focus:ring-opacity-50">Save Email Templates</button>
                        </form>
                    </section>

                    <!-- Integrations Section -->
                </div>
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Sample JSON data for settings
        const settingsData = {
            generalSettings: {
                businessName: "HubVenue",
                businessAddress: "Johnston Street, Baliwasan, Zamboanga City, Philippines, 7000",
                workingHours: "9:00 AM - 5:00 PM",
                timezone: "UTC",
                currency: "PHP"
            },
            // ... rest of the settings data ...
        };

        // Function to populate form fields with data
        function populateFormFields(data) {
            // ... populate form fields function remains the same ...
        }

        // Populate form fields with sample data
        populateFormFields(settingsData);

        // Form submission handlers remain the same
        document.getElementById('generalSettingsForm').addEventListener('submit', function(e) {
            e.preventDefault();
            alert('General Settings updated successfully!');
        });

        // ... other form submission handlers remain the same ...

        // Dark mode toggle functionality
        const darkModeToggle = document.getElementById('darkModeToggle');
        const body = document.body;

        darkModeToggle.addEventListener('change', () => {
            body.classList.toggle('dark-mode');
        });
    </script>
</body>
</html>