<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl md:text-3xl font-semibold text-gray-800 mb-6">Settings</h1>

    <!-- General Settings Section -->
    <section id="general-settings" class="bg-white rounded-lg shadow-md p-6 mb-8">
        <h2 class="text-xl font-semibold text-gray-800 mb-4">General Settings</h2>
        <form id="generalSettingsForm">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="businessName" class="block text-sm font-medium text-gray-700">Business Name</label>
                    <input type="text" id="businessName" name="businessName"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50">
                </div>
                <div>
                    <label for="businessAddress" class="block text-sm font-medium text-gray-700">Business
                        Address</label>
                    <input type="text" id="businessAddress" name="businessAddress"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50">
                </div>
                <div>
                    <label for="workingHours" class="block text-sm font-medium text-gray-700">Working Hours</label>
                    <input type="text" id="workingHours" name="workingHours"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50">
                </div>
                <div>
                    <label for="timezone" class="block text-sm font-medium text-gray-700">Timezone</label>
                    <select id="timezone" name="timezone"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50">
                        <option>EST</option>
                        <option>EST</option>
                        <option>PST</option>
                        <!-- Add more timezone options -->
                    </select>
                </div>
                <div>
                    <label for="currency" class="block text-sm font-medium text-gray-700">Currency</label>
                    <select id="currency" name="currency"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50">
                        <option>PHP</option>
                        <option>EUR</option>
                        <option>GBP</option>
                        <!-- Add more currency options -->
                    </select>
                </div>
            </div>
            <button type="submit"
                class="mt-4 px-4 py-2 bg-primary text-white rounded-md hover:bg-primary-dark focus:outline-none focus:ring focus:ring-primary focus:ring-opacity-50">Save
                General Settings</button>
        </form>
    </section>

    <!-- Booking Policies Section -->
    <section id="booking-policies" class="bg-white rounded-lg shadow-md p-6 mb-8">
        <h2 class="text-xl font-semibold text-gray-800 mb-4">Booking Policies</h2>
        <form id="bookingPoliciesForm">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="minBookingWindow" class="block text-sm font-medium text-gray-700">Minimum Booking Window
                        (hours)</label>
                    <input type="number" id="minBookingWindow" name="minBookingWindow"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50">
                </div>
                <div>
                    <label for="cancellationPolicy" class="block text-sm font-medium text-gray-700">Cancellation
                        Policy</label>
                    <textarea id="cancellationPolicy" name="cancellationPolicy" rows="3"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50"></textarea>
                </div>
                <div>
                    <label for="lateFee" class="block text-sm font-medium text-gray-700">Late Fee (%)</label>
                    <input type="number" id="lateFee" name="lateFee"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50">
                </div>
            </div>
            <button type="submit"
                class="mt-4 px-4 py-2 bg-primary text-white rounded-md hover:bg-primary-dark focus:outline-none focus:ring focus:ring-primary focus:ring-opacity-50">Save
                Booking Policies</button>
        </form>
    </section>

    <!-- Payment Settings Section -->
    <section id="payment-settings" class="bg-white rounded-lg shadow-md p-6 mb-8">
        <h2 class="text-xl font-semibold text-gray-800 mb-4">Payment Settings</h2>
        <form id="paymentSettingsForm">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="paymentGateway" class="block text-sm font-medium text-gray-700">Payment Gateway</label>
                    <select id="paymentGateway" name="paymentGateway"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50">
                        <option>G Cash</option>
                        <option>PayPal</option>
                        <!-- Add more payment gateway options -->
                    </select>
                </div>
                <div>
                    <label for="apiKey" class="block text-sm font-medium text-gray-700">API Key</label>
                    <input type="text" id="apiKey" name="apiKey"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50">
                </div>
            </div>
            <button type="submit"
                class="mt-4 px-4 py-2 bg-primary text-white rounded-md hover:bg-primary-dark focus:outline-none focus:ring focus:ring-primary focus:ring-opacity-50">Save
                Payment Settings</button>
        </form>
    </section>

    <!-- Email Templates Section -->
    <section id="email-templates" class="bg-white rounded-lg shadow-md p-6 mb-8">
        <h2 class="text-xl font-semibold text-gray-800 mb-4">Email Templates</h2>
        <form id="emailTemplatesForm">
            <div class="grid grid-cols-1 gap-4">
                <div>
                    <label for="bookingConfirmation" class="block text-sm font-medium text-gray-700">Booking
                        Confirmation Template</label>
                    <textarea id="bookingConfirmation" name="bookingConfirmation" rows="5"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50"></textarea>
                </div>
                <div>
                    <label for="reminderEmail" class="block text-sm font-medium text-gray-700">Reminder Email
                        Template</label>
                    <textarea id="reminderEmail" name="reminderEmail" rows="5"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50"></textarea>
                </div>
            </div>
            <button type="submit"
                class="mt-4 px-4 py-2 bg-primary text-white rounded-md hover:bg-primary-dark focus:outline-none focus:ring focus:ring-primary focus:ring-opacity-50">Save
                Email Templates</button>
        </form>
    </section>

    <!-- Integrations Section -->
</div>