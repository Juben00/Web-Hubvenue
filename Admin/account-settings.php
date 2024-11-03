<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Settings - Venue Reservation</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#3b82f6',
                        secondary: '#10b981',
                    }
                }
            }
        }
    </script>
    <style>
        @media (max-width: 768px) {
            .mobile-menu {
                display: block;
            }
            .main-content {
                padding-top: 60px;
            }
        }
    </style>
</head>
<body class="bg-gray-100">
    <div class="flex h-screen overflow-hidden">
        <!-- Mobile Header -->
        <header class="fixed top-0 left-0 right-0 bg-white shadow-md z-50 md:hidden">
            <div class="flex items-center justify-between p-4">
                <button class="mobile-menu p-2 rounded-md focus:outline-none focus:ring">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
                <h1 class="text-xl font-semibold text-gray-800">Account Settings</h1>
            </div>
        </header>

        <!-- Sidebar -->
        <?php include 'sidebar.php'; ?>
        <div class="flex-1 flex flex-col overflow-hidden">
            <?php include 'topbar.php'; ?>
        <!-- Main Content -->
        <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100 main-content">
            <div class="container mx-auto px-4 py-8">
                <h1 class="text-2xl md:text-3xl font-semibold text-gray-800 mb-6 hidden md:block">Account Settings</h1>

                <!-- Personal Information -->
                <section id="personal-information" class="bg-white rounded-lg shadow-md p-6 mb-6">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4">Personal Information</h2>
                    <form id="personal-info-form">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                                <input type="text" id="name" name="name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50">
                            </div>
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                                <input type="email" id="email" name="email" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50">
                            </div>
                            <div>
                                <label for="phone" class="block text-sm font-medium text-gray-700">Phone</label>
                                <input type="tel" id="phone" name="phone" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50">
                            </div>
                            <div>
                                <label for="address" class="block text-sm font-medium text-gray-700">Address</label>
                                <input type="text" id="address" name="address" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50">
                            </div>
                            <div>
                                <label for="city" class="block text-sm font-medium text-gray-700">City</label>
                                <input type="text" id="city" name="city" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50">
                            </div>
                            <div>
                                <label for="country" class="block text-sm font-medium text-gray-700">Country</label>
                                <input type="text" id="country" name="country" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50">
                            </div>
                            <div>
                                <label for="timezone" class="block text-sm font-medium text-gray-700">Timezone</label>
                                <select id="timezone" name="timezone" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50">
                                    <option>UTC-8:00 Pacific Time (US & Canada)</option>
                                    <option>UTC-5:00 Eastern Time (US & Canada)</option>
                                    <option>UTC+0:00 London</option>
                                    <option>UTC+1:00 Paris</option>
                                </select>
                            </div>
                            <div>
                                <label for="role" class="block text-sm font-medium text-gray-700">Role</label>
                                <input type="text" id="role" name="role" value="Venue Manager" disabled class="mt-1 block w-full rounded-md border-gray-300 bg-gray-100 shadow-sm">
                            </div>
                        </div>
                        <div class="mt-4">
                            <button type="submit" class="px-4 py-2 bg-primary text-white rounded-md hover:bg-primary-dark focus:outline-none focus:ring-2 focus:ring-primary focus:ring-opacity-50">
                                Save Changes
                            </button>
                        </div>
                    </form>
                </section>

                <!-- Security Settings -->
                <section id="security-settings" class="bg-white rounded-lg shadow-md p-6 mb-6">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4">Security Settings</h2>
                    <form id="security-form">
                        <div class="space-y-4">
                            <div>
                                <label for="current-password" class="block text-sm font-medium text-gray-700">Current Password</label>
                                <input type="password" id="current-password" name="current-password" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50">
                            </div>
                            <div>
                                <label for="new-password" class="block text-sm font-medium text-gray-700">New Password</label>
                                <input type="password" id="new-password" name="new-password" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50">
                            </div>
                            <div>
                                <label for="confirm-password" class="block text-sm font-medium text-gray-700">Confirm New Password</label>
                                <input type="password" id="confirm-password" name="confirm-password" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50">
                            </div>
                            <div>
                                <label class="flex items-center">
                                    <input type="checkbox" id="enable-2fa" name="enable-2fa" class="rounded border-gray-300 text-primary focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50">
                                    <span class="ml-2 text-sm text-gray-700">Enable Two-Factor Authentication</span>
                                </label>
                            </div>
                        </div>
                        <div class="mt-4">
                            <button type="submit" class="px-4 py-2 bg-primary text-white rounded-md hover:bg-primary-dark focus:outline-none focus:ring-2 focus:ring-primary focus:ring-opacity-50">
                                Update Security Settings
                            </button>
                        </div>
                    </form>
                </section>

                <!-- Notification Preferences -->
                <section id="notification-preferences" class="bg-white rounded-lg shadow-md p-6 mb-6">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4">Notification Preferences</h2>
                    <form id="notification-form">
                        <div class="space-y-4">
                            <div>
                                <label class="flex items-center">
                                    <input type="checkbox" name="email-notifications" class="rounded border-gray-300 text-primary focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50">
                                    <span class="ml-2 text-sm text-gray-700">Email Notifications</span>
                                </label>
                            </div>
                            <div>
                                <label class="flex items-center">
                                    <input type="checkbox" name="sms-notifications" class="rounded border-gray-300 text-primary focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50">
                                    <span class="ml-2 text-sm text-gray-700">SMS Notifications</span>
                                </label>
                            </div>
                            <div>
                                <label class="flex items-center">
                                    <input type="checkbox" name="push-notifications" class="rounded border-gray-300 text-primary focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50">
                                    <span class="ml-2 text-sm text-gray-700">Push Notifications</span>
                                </label>
                            </div>
                            <div>
                                <label class="flex items-center">
                                    <input type="checkbox" name="in-app-notifications" class="rounded border-gray-300 text-primary focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50">
                                    <span class="ml-2 text-sm text-gray-700">In-App Notifications</span>
                                </label>
                            </div>
                        </div>
                        <div class="mt-4">
                            <button type="submit" class="px-4 py-2 bg-primary text-white rounded-md hover:bg-primary-dark focus:outline-none focus:ring-2 focus:ring-primary focus:ring-opacity-50">
                                Save Notification Preferences
                            </button>
                        </div>
                    </form>
                </section>

                <!-- Billing and Payment Settings -->
                <section id="billing-payment" class="bg-white rounded-lg shadow-md p-6 mb-6">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4">Billing and Payment Settings</h2>
                    <div class="space-y-4">
                        <div>
                            <h3 class="text-lg font-medium text-gray-700">Saved Payment Methods</h3>
                            <ul id="payment-methods" class="mt-2 space-y-2">
                                <!-- Payment methods will be populated by JavaScript -->
                            </ul>
                        </div>
                        <div>
                            <button id="add-payment-method" class="px-4 py-2 bg-secondary text-white rounded-md hover:bg-secondary-dark focus:outline-none focus:ring-2 focus:ring-secondary focus:ring-opacity-50">
                                Add Payment Method
                            </button>
                        </div>
                        <div>
                            <h3 class="text-lg font-medium text-gray-700">Billing History</h3>
                            <table class="mt-2 w-full text-sm text-left text-gray-500">
                                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3">Date</th>
                                        <th scope="col" class="px-6 py-3">Description</th>
                                        <th scope="col" class="px-6 py-3">Amount</th>
                                    </tr>
                                </thead>
                                <tbody id="billing-history">
                                    <!-- Billing history will be populated by JavaScript -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </section>

                <!-- Privacy Settings -->
                <section id="privacy-settings" class="bg-white rounded-lg shadow-md p-6 mb-6">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4">Privacy Settings</h2>
                    <form id="privacy-form">
                        <div class="space-y-4">
                            <div>
                                <label class="flex items-center">
                                    <input type="checkbox" name="profile-visibility" class="rounded border-gray-300 text-primary focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50">
                                    <span class="ml-2 text-sm text-gray-700">Make profile visible to other users</span>
                                </label>
                            </div>
                            <div>
                                <label class="flex items-center">
                                    <input type="checkbox" name="data-sharing" class="rounded border-gray-300 text-primary focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50">
                                    <span class="ml-2 text-sm text-gray-700">Allow data sharing with third-party services</span>
                                </label>
                            </div>
                        </div>
                        <div class="mt-4">
                            <button type="submit" class="px-4 py-2 bg-primary text-white rounded-md hover:bg-primary-dark focus:outline-none focus:ring-2 focus:ring-primary focus:ring-opacity-50">
                                Update Privacy Settings
                            </button>
                        </div>
                    </form>
                    <div class="mt-6 space-y-4">
                        <button id="export-data" class="px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-opacity-50">
                            Export Personal Data
                        </button>
                        <button id="delete-account" class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-opacity-50">
                            Delete Account
                        </button>
                    </div>
                </section>

                <!-- Subscription and Plan Management -->
                <section id="subscription-plan" class="bg-white rounded-lg shadow-md p-6 mb-6">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4">Subscription and Plan Management</h2>
                    <div class="space-y-4">
                        <div>
                            <h3 class="text-lg font-medium text-gray-700">Current Plan: <span id="current-plan">Premium</span></h3>
                            <p class="text-sm text-gray-600">Renewal Date: <span id="renewal-date">July 1, 2023</span></p>
                        </div>
                        <div>
                            <button id="upgrade-plan" class="px-4 py-2 bg-secondary text-white rounded-md hover:bg-secondary-dark focus:outline-none focus:ring-2 focus:ring-secondary focus:ring-opacity-50">
                                Upgrade Plan
                            </button>
                        </div>
                        <div>
                            <button id="cancel-subscription" class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-opacity-50">
                                Cancel Subscription
                            </button>
                        </div>
                    </div>
                </section>

                <!-- API and Integrations -->
                <section id="api-integrations" class="bg-white rounded-lg shadow-md p-6 mb-6">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4">API and Integrations</h2>
                    <div class="space-y-4">
                        <div>
                            <h3 class="text-lg font-medium text-gray-700">API Key</h3>
                            <div class="flex items-center mt-2">
                                <input type="text" id="api-key" value="xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx" disabled class="flex-grow mr-2 p-2 bg-gray-100 rounded border border-gray-300">
                                <button id="regenerate-api-key" class="px-4 py-2 bg-primary text-white rounded-md hover:bg-primary-dark focus:outline-none focus:ring-2 focus:ring-primary focus:ring-opacity-50">
                                    Regenerate
                                </button>
                            </div>
                        </div>
                        <div>
                            <h3 class="text-lg font-medium text-gray-700">Connected Apps</h3>
                            <ul id="connected-apps" class="mt-2 space-y-2">
                                <!-- Connected apps will be populated by JavaScript -->
                            </ul>
                        </div>
                    </div>
                </section>

                <!-- Support and Help -->
                <section id="support-help" class="bg-white rounded-lg shadow-md p-6 mb-6">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4">Support and Help</h2>
                    <div class="space-y-4">
                        <a href="#" class="block text-primary hover:underline">FAQs</a>
                        <a href="#" class="block text-primary hover:underline">Contact Support</a>
                        <a href="#" class="block text-primary hover:underline">User Guide</a>
                        <button id="request-data" class="px-4 py-2 bg-primary text-white rounded-md hover:bg-primary-dark focus:outline-none focus:ring-2 focus:ring-primary focus:ring-opacity-50">
                            Request Personal Data
                        </button>
                    </div>
                </section>
            </div>
        </main>
    </div>

    <script>
        // Sample data (in a real application, this would come from an API)
        const userData = {
            name: 'John Doe',
            email: 'john@example.com',
            phone: '+1 (555) 123-4567',
            address: '123 Main St',
            city: 'Anytown',
            country: 'USA',
            timezone: 'UTC-5:00 Eastern Time (US & Canada)',
            role: 'Venue Manager',
            paymentMethods: [
                { id: 1, type: 'Credit Card', last4: '1234', expiry: '12/2024' },
                { id: 2, type: 'PayPal', email: 'john@example.com' }
            ],
            billingHistory: [
                { date: '2023-05-01', description: 'Monthly Subscription', amount: '$99.99' },
                { date: '2023-04-01', description: 'Monthly Subscription', amount: '$99.99' },
                { date: '2023-03-01', description: 'Monthly Subscription', amount: '$99.99' }
            ],
            connectedApps: [
                { id: 1, name: 'Google Calendar', status: 'Connected' },
                { id: 2, name: 'Zapier', status: 'Connected' }
            ]
        };

        // Function to populate form fields
        function populateFormFields() {
            document.getElementById('name').value = userData.name;
            document.getElementById('email').value = userData.email;
            document.getElementById('phone').value = userData.phone;
            document.getElementById('address').value = userData.address;
            document.getElementById('city').value = userData.city;
            document.getElementById('country').value = userData.country;
            document.getElementById('timezone').value = userData.timezone;
            document.getElementById('role').value = userData.role;
        }

        // Function to populate payment methods
        function populatePaymentMethods() {
            const paymentMethodsList = document.getElementById('payment-methods');
            paymentMethodsList.innerHTML = '';
            userData.paymentMethods.forEach(method => {
                const li = document.createElement('li');
                li.className = 'flex items-center justify-between p-2 bg-gray-100 rounded';
                li.innerHTML = `
                    <span>${method.type} ${method.last4 ? `ending in ${method.last4}` : method.email}</span>
                    <button class="text-red-600 hover:text-red-800" onclick="removePaymentMethod(${method.id})">Remove</button>
                `;
                paymentMethodsList.appendChild(li);
            });
        }

        // Function to populate billing history
        function populateBillingHistory() {
            const billingHistoryTable = document.getElementById('billing-history');
            billingHistoryTable.innerHTML = '';
            userData.billingHistory.forEach(item => {
                const tr = document.createElement('tr');
                tr.className = 'bg-white border-b';
                tr.innerHTML = `
                    <td class="px-6 py-4">${item.date}</td>
                    <td class="px-6 py-4">${item.description}</td>
                    <td class="px-6 py-4">${item.amount}</td>
                `;
                billingHistoryTable.appendChild(tr);
            });
        }

        // Function to populate connected apps
        function populateConnectedApps() {
            const connectedAppsList = document.getElementById('connected-apps');
            connectedAppsList.innerHTML = '';
            userData.connectedApps.forEach(app => {
                const li = document.createElement('li');
                li.className = 'flex items-center justify-between p-2 bg-gray-100 rounded';
                li.innerHTML = `
                    <span>${app.name}</span>
                    <button class="text-red-600 hover:text-red-800" onclick="disconnectApp(${app.id})">Disconnect</button>
                `;
                connectedAppsList.appendChild(li);
            });
        }

        // Function to handle form submissions
        function handleFormSubmit(event) {
            event.preventDefault();
            const formId = event.target.id;
            console.log(`Form submitted: ${formId}`);
            // In a real application, you would send the form data to the server here
            alert('Changes saved successfully!');
        }

        // Event listeners for form submissions
        document.getElementById('personal-info-form').addEventListener('submit', handleFormSubmit);
        document.getElementById('security-form').addEventListener('submit', handleFormSubmit);
        document.getElementById('notification-form').addEventListener('submit', handleFormSubmit);
        document.getElementById('privacy-form').addEventListener('submit', handleFormSubmit);

        // Event listeners for buttons
        document.getElementById('add-payment-method').addEventListener('click', () => {
            console.log('Add payment method clicked');
            // In a real application, you would open a modal or navigate to a payment method addition page
            alert('Add payment method functionality would be implemented here.');
        });

        document.getElementById('export-data').addEventListener('click', () => {
            console.log('Export data clicked');
            // In a real application, you would initiate the data export process
            alert('Your data export has been initiated. You will receive an email with the download link shortly.');
        });

        document.getElementById('delete-account').addEventListener('click', () => {
            if (confirm('Are you sure you want to delete your account? This action cannot be undone.')) {
                console.log('Delete account confirmed');
                // In a real application, you would initiate the account deletion process
                alert('Account deletion process has been initiated. You will receive a confirmation email shortly.');
            }
        });

        document.getElementById('upgrade-plan').addEventListener('click', () => {
            console.log('Upgrade plan clicked');
            // In a real application, you would navigate to the plan upgrade page
            alert('Redirecting to plan upgrade page...');
        });

        document.getElementById('cancel-subscription').addEventListener('click', () => {
            if (confirm('Are you sure you want to cancel your subscription?')) {
                console.log('Cancel subscription confirmed');
                // In a real application, you would initiate the subscription cancellation process
                alert('Your subscription cancellation has been processed. You will receive a confirmation email shortly.');
            }
        });

        document.getElementById('regenerate-api-key').addEventListener('click', () => {
            if (confirm('Are you sure you want to regenerate your API key? This will invalidate your current key.')) {
                console.log('Regenerate API key confirmed');
                // In a real application, you would regenerate the API key
                document.getElementById('api-key').value = 'yyyyyyyy-yyyy-yyyy-yyyy-yyyyyyyyyyyy';
                alert('Your API key has been regenerated. Make sure to update it in all your applications.');
            }
        });

        document.getElementById('request-data').addEventListener('click', () => {
            console.log('Request personal data clicked');
            // In a real application, you would initiate the personal data request process
            alert('Your personal data request has been submitted. You will receive an email with further instructions shortly.');
        });

        // Function to remove a payment method
        function removePaymentMethod(id) {
            console.log(`Remove payment method clicked for id: ${id}`);
            // In a real application, you would send a request to the server to remove the payment method
            userData.paymentMethods = userData.paymentMethods.filter(method => method.id !== id);
            populatePaymentMethods();
            alert('Payment method removed successfully.');
        }

        // Function to disconnect an app
        function disconnectApp(id) {
            console.log(`Disconnect app clicked for id: ${id}`);
            // In a real application, you would send a request to the server to disconnect the app
            userData.connectedApps = userData.connectedApps.filter(app => app.id !== id);
            populateConnectedApps();
            alert('App disconnected successfully.');
        }

        // Initialize the page
        document.addEventListener('DOMContentLoaded', () => {
            populateFormFields();
            populatePaymentMethods();
            populateBillingHistory();
            populateConnectedApps();
        });

        // Mobile menu toggle
        document.querySelector('.mobile-menu').addEventListener('click', function(event) {
            event.stopPropagation();
            const sidebar = document.querySelector('.desktop-sidebar');
            sidebar.classList.toggle('show');
        });

        // Close sidebar when clicking outside of it
        document.addEventListener('click', function(event) {
            const sidebar = document.querySelector('.desktop-sidebar');
            const mobileMenu = document.querySelector('.mobile-menu');
            if (!sidebar.contains(event.target) && !mobileMenu.contains(event.target) && sidebar.classList.contains('show')) {
                sidebar.classList.remove('show');
            }
        });

        // Prevent clicks inside the sidebar from closing it
        document.querySelector('.desktop-sidebar').addEventListener('click', function(event) {
            event.stopPropagation();
        });
    </script>
</body>
</html>