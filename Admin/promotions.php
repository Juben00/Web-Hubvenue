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
        /* Keep only content-specific styles */
        .semi-transparent {
            background-color: rgba(255, 255, 255, 0.8);
        }

        .rounded-card {
            border-radius: 1rem;
        }

        .dark-mode table thead th,
        .dark-mode table tbody td {
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
        
        <div class="flex-1 flex flex-col overflow-hidden">
            <?php include 'topbar.php'; ?>

            <!-- Main Content -->
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100 main-content">
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
                        <button id="addPromoCodeBtn" class="mt-4 bg-red-500 text-white py-2 px-4 rounded hover:bg-red-600 transition-colors">Add New Promo Code</button>
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
                        <button id="addSpecialOfferBtn" class="mt-4 bg-red-500 text-white py-2 px-4 rounded hover:bg-blue-600 transition-colors">Add New Special Offer</button>
                    </section>
                </div>
            </main>
        </div>
    </div>

    <!-- Modals -->
    <!-- (Keep all the modal HTML code here - unchanged) -->

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Keep only the promotion-specific JavaScript
        // Sample data
        let promoCodes = [
            { id: 1, code: 'SUMMER2024', discount: 20, validUntil: '2024-08-31', status: 'Active' },
            { id: 2, code: 'CHRISTMAS2024', discount: 15, validUntil: '2024-11-30', status: 'Inactive' }
        ];

        let specialOffers = [
            { id: 1, name: 'Weekend Special', venue: 'Grand Hall', discount: 25, validUntil: '2023-12-31', status: 'Active' },
            { id: 2, name: 'Last Minute Booking', venue: 'Garden Terrace', discount: 30, validUntil: '2023-09-30', status: 'Active' }
        ];

        // Keep all the functions related to promo codes and special offers
        // (updatePromoCodesTable, updateSpecialOffersTable, modal functions, etc.)
        
        // Initialize tables
        updatePromoCodesTable();
        updateSpecialOffersTable();

        // Event listeners for "Add New" buttons
        document.getElementById('addPromoCodeBtn').addEventListener('click', () => openPromoCodeModal());
        document.getElementById('addSpecialOfferBtn').addEventListener('click', () => openSpecialOfferModal());
    </script>
</body>
</html>