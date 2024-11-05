<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl md:text-3xl font-semibold text-gray-800 mb-6 hidden md:block">Promotions and Marketing</h1>

    <!-- Promo Codes Section -->
    <section id="promo-codes" class="bg-white rounded-lg shadow-md p-6 mb-8">
        <h2 class="text-xl font-semibold text-gray-800 mb-4">Promo Codes</h2>
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="py-2 px-4 text-left">Code</th>
                        <th class="py-2 px-4 text-left">Discount</th>
                        <th class="py-2 px-4 text-left">Valid Until</th>
                        <th class="py-2 px-4 text-left">Status</th>
                        <th class="py-2 px-4 text-left">Actions</th>
                    </tr>
                </thead>
                <tbody id="promoCodesTable">
                    <!-- Table rows will be populated by JavaScript -->
                </tbody>
            </table>
        </div>
        <button id="addPromoCodeBtn"
            class="mt-4 bg-red-500 text-white py-2 px-4 rounded hover:bg-red-600 transition-colors">Add New Promo
            Code</button>
    </section>

    <!-- Special Offers Section -->
    <section id="special-offers" class="bg-white rounded-lg shadow-md p-6 mb-8">
        <h2 class="text-xl font-semibold text-gray-800 mb-4">Special Offers</h2>
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="py-2 px-4 text-left">Offer Name</th>
                        <th class="py-2 px-4 text-left">Venue</th>
                        <th class="py-2 px-4 text-left">Discount</th>
                        <th class="py-2 px-4 text-left">Valid Until</th>
                        <th class="py-2 px-4 text-left">Status</th>
                        <th class="py-2 px-4 text-left">Actions</th>
                    </tr>
                </thead>
                <tbody id="specialOffersTable">
                    <!-- Table rows will be populated by JavaScript -->
                </tbody>
            </table>
        </div>
        <button id="addSpecialOfferBtn"
            class="mt-4 bg-red-500 text-white py-2 px-4 rounded hover:bg-blue-600 transition-colors">Add New Special
            Offer</button>
    </section>
</div>