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

    $venueObj = new Venue();

    $venueId = $_GET['venueId'];
    $checkIn = new DateTime($_GET['checkin']);
    $checkOut = new DateTime($_GET['checkout']);
    $interval = $checkIn->diff($checkOut);
    $bookingDuration = $interval->days;
    $numberOfGuest = $_GET['numberOfGuest'];
    $totalPriceForNights = $_GET['totalPriceForNights'];
    $totalEntranceFee = $_GET['totalEntranceFee'];
    $cleaningFee = $_GET['cleaningFee'];
    $serviceFee = $_GET['serviceFee'];
    $totalPrice = $_GET['totalPrice'];

    $venueDetails = $venueObj->getSingleVenue($venueId);
    $venueName = htmlspecialchars($venueDetails["venue_name"]);
    $checkIn = htmlspecialchars($checkIn->format('Y-m-d'));
    $checkOut = htmlspecialchars($checkOut->format('Y-m-d'));
    $numberOfGuest = htmlspecialchars($numberOfGuest);
    $totalPriceForNights = htmlspecialchars($totalPriceForNights);
    $totalEntranceFee = htmlspecialchars($totalEntranceFee);
    $cleaningFee = htmlspecialchars($cleaningFee);
    $serviceFee = htmlspecialchars($serviceFee);
    $totalPrice = htmlspecialchars($totalPrice);

    $discounts = $venueObj->getAllDiscounts();

    function applyDiscount($discounts, $discountCode, $totalPrice)
    {
        foreach ($discounts as $discount) {
            if ($discount['discount_code'] === $discountCode && new DateTime() <= new DateTime($discount['expiration_date'])) {
                if ($discount['discount_type'] === 'flat') {
                    return max(0, $totalPrice - $discount['discount_value']);
                } elseif ($discount['discount_type'] === 'percentage') {
                    return max(0, $totalPrice * (1 - $discount['discount_value'] / 100));
                }
            }
        }
        return $totalPrice;
    }

    if (isset($_GET['discountCode'])) {
        $discountCode = htmlspecialchars($_GET['discountCode']);
        $totalPrice = applyDiscount($discounts, $discountCode, $totalPrice);
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HubVenue - Venue Reservation</title>
    <link rel="stylesheet" href="./output.css">
    <link href="https://cdn.jsdelivr.net/npm/lucide-static@0.321.0/font/lucide.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/luxon@3.3.0/build/global/luxon.min.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
</head>


<body class="min-h-screen flex flex-col bg-white">

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

    <main class="pt-20 flex-grow flex flex-col justify-between p-6 pb-24">
        <div class="max-w-3xl mx-auto w-full">
            <div class="mb-8">
                <h2 class="text-sm font-medium text-gray-500 mb-2">Step <span id="currentStep">1</span> of <span
                        id="totalSteps">2</span></h2>
                <h1 id="stepTitle" class="text-3xl font-bold mb-4">Venue Details</h1>
                <p id="stepDescription" class="text-gray-600 mb-8">Review the details of your selected venue.</p>
            </div>

            <div id="stepContent">
                <!-- Step content will be dynamically inserted here -->
            </div>
        </div>

        <div class="fixed bottom-0 left-0 right-0 bg-white border-t border-gray-200 p-4">
            <div class="flex justify-between items-center max-w-3xl mx-auto">
                <button id="backBtn" class="flex items-center text-sm font-medium text-gray-900" disabled>
                    <i class="lucide-chevron-left h-5 w-5 mr-1"></i>
                    Back
                </button>
                <div class="flex-grow mx-8">
                    <div class="bg-gray-200 h-1 rounded-full">
                        <div id="progressBar" class="bg-black h-1 rounded-full transition-all duration-300 ease-in-out"
                            style="width: 0%"></div>
                    </div>
                </div>
                <button id="nextBtn"
                    class="flex items-center px-6 py-2 bg-black text-white rounded-md text-sm font-medium">
                    Next
                    <i class="lucide-chevron-right h-5 w-5 ml-1"></i>
                </button>
            </div>
        </div>
    </main>

    <script>

        let FinalAmmount = <?php echo $totalPrice ?>;
        const steps = [
            { title: "Review Details", description: "Review and confirm your reservation details." },
            { title: "Payment", description: "Complete your payment to secure the reservation." }
        ];

        let currentStep = 1;
        const totalSteps = steps.length;

        let formData = {
            booking_start_date: '<?php echo $checkIn ?>',
            booking_end_date: '<?php echo $checkOut ?>',
            booking_duration: '<?php echo $bookingDuration ?>',
            booking_status_id: '1',
            booking_participants: '<?php echo $numberOfGuest ?>',
            booking_grand_total: '<?php echo $totalPrice ?>',
            booking_guest_id: <?php echo htmlspecialchars($_SESSION['user']['id']) ?>,
            booking_venue_id: '<?php echo $venueId ?>',
            booking_discount_id: '',
            booking_payment_method: '',
            booking_payment_reference: '',
            booking_payment_status_id: '1',
            booking_cancellation_reason: '',
            booking_service_fee: '<?php echo $serviceFee ?>',
            discountCode: '<?php echo isset($discountCode) ? $discountCode : '' ?>',
        };

        // function calculateSubtotal() {
        //     const basePrice = 500 * parseInt(formData.booking_duration || 1);
        //     const fees = 100 + 250 + 50; // Entrance + Cleaning + Service fees
        //     return basePrice + fees;
        // }

        // function calculateDiscount() {
        //     const subtotal = calculateSubtotal();
        //     return subtotal * (formData.couponDiscount || 0);
        // }

        function calculateTotal() {
            const subtotal = parseFloat(formData.booking_grand_total);
            const discount = parseFloat(formData.couponDiscount || 0);
            console.log("s, " + subtotal, "d", + discount);
            FinalAmmount = (subtotal - (subtotal * discount));
        }

        function updateStep() {
            document.getElementById('currentStep').textContent = currentStep;
            document.getElementById('stepTitle').textContent = steps[currentStep - 1].title;
            document.getElementById('stepDescription').textContent = steps[currentStep - 1].description;
            document.getElementById('progressBar').style.width = `${((currentStep - 1) / (totalSteps - 1)) * 100}%`;

            document.getElementById('backBtn').disabled = currentStep === 1;
            document.getElementById('nextBtn').textContent = currentStep === totalSteps ? 'Confirm Reservation' : 'Next';

            if (currentStep !== totalSteps) {
                document.getElementById('nextBtn').innerHTML += '<i class="lucide-chevron-right h-5 w-5 ml-1"></i>';
            }

            renderStepContent();
        }

        function renderStepContent() {
            const stepContent = document.getElementById('stepContent');
            stepContent.innerHTML = '';

            switch (currentStep) {
                case 1:
                    stepContent.innerHTML = `
                        <div class="space-y-6">
                            <h3 class="text-2xl font-semibold mb-4">Reservation Summary</h3>
                            
                            <!-- Coupon Input Section - Removed border -->
                            <div class="bg-white p-4 rounded-lg mb-4">
                                <div class="flex gap-2">
                                    <input type="text" 
                                           id="couponCode" 
                                           name="couponCode" 
                                           placeholder="Enter coupon code"
                                           value="${formData.discountCode}"
                                           ${formData.discountCode ? 'disabled' : ''}
                                           class="flex-1 rounded-md shadow-sm focus:ring-primary focus:border-primary h-10 ${formData.discountCode ? 'bg-gray-50' : ''}">
                                    <button onclick="${formData.discountCode ? 'removeCoupon()' : 'applyCoupon()'}" 
                                            class="px-4 py-2 ${formData.discountCode ? 'bg-gray-500' : 'bg-black'} text-white rounded-md text-sm font-medium hover:opacity-90">
                                        ${formData.discountCode ? 'Remove' : 'Apply'}
                                    </button>
                                </div>
                                <p id="couponMessage" class="text-sm mt-2 ${formData.discountCode ? '' : 'hidden'} ${formData.discountCode ? 'text-green-600' : ''}">
                                    ${formData.discountCode ? `Coupon applied successfully! ${formData.couponDiscount * 100}% discount` : ''}
                                </p>
                            </div>

                            <div class="bg-gray-100 p-6 rounded-lg">
                                <h4 class="font-semibold text-lg mb-4"><?php echo $venueName ?></h4>
                                <div class="space-y-2">
                                    <p><strong>Date:</strong> ${formData.booking_start_date} to ${formData.booking_end_date}</p>
                                    <p><strong>Guests:</strong> ${formData.booking_participants}</p>
                                </div>
                                <div class="mt-6 pt-4 border-t border-gray-300">
                                    <h5 class="font-semibold mb-2">Price Breakdown</h5>
                                    <div class="space-y-1">
                                        <div class="flex justify-between">
                                            <span>Total Price for Nights</span>
                                            <span>₱ <?php echo $totalPriceForNights ?></span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span>Entrance Fee</span>
                                            <span>₱ <?php echo $totalEntranceFee ?></span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span>Cleaning Fee</span>
                                            <span>₱ <?php echo $cleaningFee ?></span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span>Service Fee</span>
                                            <span>₱ <?php echo $serviceFee ?></span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span>Discount</span>
                                            <span> ${formData.couponDiscount ? formData.couponDiscount * 100 : 0}%</span>
                                        </div>

                                    </div>
                                    <div class="mt-4 pt-4 border-t border-gray-300 flex justify-between font-semibold">
                                        <span>Total</span>
                                        <span>₱ ${FinalAmmount}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;
                    break;
                case 2:
                    stepContent.innerHTML = `
                        <div class="space-y-6">
                            <h3 class="text-2xl font-semibold mb-4">Payment Method</h3>
                            
                            <div class="grid grid-cols-2 gap-6">
                                <div class="border rounded-lg p-6 cursor-pointer hover:border-black transition-colors" onclick="selectPaymentMethod('gcash')">
                                    <div class="flex items-center justify-between mb-4">
                                        <img src="./images/gcash.png" alt="GCash" class="h-8">
                                        <input type="radio" name="paymentMethod" value="gcash" class="h-4 w-4">
                                    </div>
                                    <p class="text-sm text-gray-600">Pay securely using your GCash account</p>
                                </div>
                                
                                <div class="border rounded-lg p-6 cursor-pointer hover:border-black transition-colors" onclick="selectPaymentMethod('paymaya')">
                                    <div class="flex items-center justify-between mb-4">
                                        <img src="./images/paymaya.png" alt="PayMaya" class="h-8">
                                        <input type="radio" name="paymentMethod" value="paymaya" class="h-4 w-4">
                                    </div>
                                    <p class="text-sm text-gray-600">Pay securely using your PayMaya account</p>
                                </div>
                            </div>
                        </div>
                    `;
                    break;
            }
        }

        document.getElementById('backBtn').addEventListener('click', () => {
            if (currentStep > 1) {
                currentStep--;
                updateStep();
            }
        });

        document.getElementById('nextBtn').addEventListener('click', () => {
            if (currentStep < totalSteps) {
                currentStep++;
                updateStep();
            } else {
                // Handle form submission
                console.log('Form submitted:', formData);
                alert('Reservation confirmed!');
            }
        });

        // Initialize the form
        updateStep();

        async function selectPaymentMethod(method) {
            try {
                // Update radio button
                document.querySelector(`input[value="${method}"]`).checked = true;

                // Set default values if they're not already set
                formData.durationValue = formData.durationValue || '1';
                formData.date = formData.date || new Date().toISOString().split('T')[0];
                formData.time = formData.time || '10:00';
                formData.eventType = formData.eventType || 'Other';
                formData.guestCount = formData.guestCount || 1;

                // Calculate total amount
                const basePrice = 500 * parseInt(formData.durationValue);
                const subtotal = basePrice + 100 + 250 + 50;
                const discount = subtotal * (formData.appliedDiscount || 0);
                const totalAmount = subtotal - discount;

                // Show loading state
                document.getElementById('nextBtn').disabled = true;

                // Set QR code based on payment method
                const qrCodeImage = method === 'gcash' ? './images/gcashqr.png' : './images/paymayaqr.png';

                // Display QR code in modal
                document.getElementById('qrCodeImage').src = qrCodeImage;
                document.getElementById('qrPaymentAmount').textContent = totalAmount.toFixed(2);
                document.getElementById('selectedPaymentMethod').textContent =
                    method === 'gcash' ? 'GCash' : 'PayMaya';
                document.getElementById('appName').textContent =
                    method === 'gcash' ? 'GCash' : 'PayMaya';

                // Reset payment status
                document.getElementById('paymentStatus').textContent = 'Waiting for payment...';
                document.getElementById('paymentStatus').classList.remove('text-green-600', 'text-red-600');
                document.getElementById('paymentProgress').style.width = '0%';
                document.getElementById('loadingIndicator').classList.add('animate-pulse');

                // Show modal with animation
                openQrModal();

                // Store reference number
                formData.paymentReference = 'REF' + Date.now();

                // Start checking payment status
                checkPaymentStatus(formData.paymentReference);

            } catch (error) {
                console.error('Payment error:', error);
                alert('Error initiating payment: ' + error.message);
            } finally {
                document.getElementById('nextBtn').disabled = false;
            }
        }

        function closeQrModal() {
            const modal = document.getElementById('qrModal');
            const modalContent = document.getElementById('qrModalContent');

            // Animate out
            modal.classList.remove('opacity-100');
            modalContent.classList.remove('scale-100', 'opacity-100', 'translate-y-0');
            modalContent.classList.add('scale-95', 'opacity-0', 'translate-y-4');

            // Hide modal after animation
            setTimeout(() => {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            }, 300);
        }

        // async function checkPaymentStatus(reference) {
        //     const progressBar = document.getElementById('paymentProgress');
        //     const paymentStatus = document.getElementById('paymentStatus');
        //     const loadingIndicator = document.getElementById('loadingIndicator');
        //     const nextBtn = document.getElementById('nextBtn');

        //     // Simulate payment processing with a progress bar
        //     let progress = 0;
        //     const interval = setInterval(() => {
        //         progress += 20;
        //         progressBar.style.width = `${progress}%`;

        //         if (progress >= 100) {
        //             clearInterval(interval);
        //             // Show success message
        //             paymentStatus.textContent = 'Payment completed! Thank you for choosing HubVenue<3';
        //             paymentStatus.classList.add('text-green-600');
        //             loadingIndicator.classList.remove('animate-pulse');
        //             nextBtn.disabled = false;

        //             // Removed the automatic modal closing
        //         }
        //     }, 1000); // Update every second
        // }

        function handleModalClick(event) {
            const modalContent = document.getElementById('qrModalContent');
            if (!modalContent.contains(event.target)) {
                closeQrModal();
            }
        }

        function openPaymentApp() {
            const method = document.querySelector('input[name="paymentMethod"]:checked').value;
            const amount = document.getElementById('qrPaymentAmount').textContent;
            const reference = formData.paymentReference;

            let appUrl;
            if (method === 'gcash') {
                // Deep link for GCash
                appUrl = `gcash://app?action=pay&amount=${amount}&reference=${reference}`;
            } else if (method === 'paymaya') {
                // Deep link for PayMaya
                appUrl = `paymaya://app?action=pay&amount=${amount}&reference=${reference}`;
            }

            // Try to open the app
            window.location.href = appUrl;

            // Fallback for mobile browsers
            setTimeout(() => {
                if (method === 'gcash') {
                    window.location.href = 'https://play.google.com/store/apps/details?id=com.globe.gcash.android';
                } else if (method === 'paymaya') {
                    window.location.href = 'https://play.google.com/store/apps/details?id=com.paymaya';
                }
            }, 1000);
        }

        function copyPaymentDetails() {
            const method = document.querySelector('input[name="paymentMethod"]:checked').value;
            const amount = document.getElementById('qrPaymentAmount').textContent;
            const reference = formData.paymentReference;

            const details = `Payment Details:\nAmount: ₱${amount}\nReference: ${reference}\nMethod: ${method.toUpperCase()}`;

            navigator.clipboard.writeText(details).then(() => {
                alert('Payment details copied to clipboard!');
            }).catch(err => {
                console.error('Failed to copy details:', err);
                alert('Failed to copy payment details');
            });
        }

        function updateFileLabel(input) {
            const label = document.getElementById('fileLabel');
            if (input.files && input.files[0]) {
                label.textContent = input.files[0].name;
                validateForm();
            } else {
                label.textContent = 'Click to upload ID photo';
            }
        }

        function validateForm() {
            const name = document.getElementById('seniorPwdName').value;
            const id = document.getElementById('seniorPwdId').value;
            const photo = document.getElementById('seniorPwdIdPhoto').files[0];
            const applyBtn = document.getElementById('applyDiscountBtn');

            applyBtn.disabled = !(name && id && photo);
        }

        // Add this new function for input animations
        function addInputFocusEffects() {
            const inputs = document.querySelectorAll('input[type="text"]');
            inputs.forEach(input => {
                input.addEventListener('focus', () => {
                    input.parentElement.classList.add('ring-2', 'ring-primary', 'ring-opacity-50');
                });
                input.addEventListener('blur', () => {
                    input.parentElement.classList.remove('ring-2', 'ring-primary', 'ring-opacity-50');
                });
            });
        }

        // Add these functions for the QR modal animations

        function openQrModal() {
            const modal = document.getElementById('qrModal');
            const modalContent = document.getElementById('qrModalContent');

            // Show modal
            modal.classList.remove('hidden');
            // Force a reflow
            void modal.offsetWidth;
            // Add flex and animate in
            modal.classList.add('flex', 'opacity-100');

            // Animate content
            setTimeout(() => {
                modalContent.classList.remove('scale-95', 'opacity-0', 'translate-y-4');
                modalContent.classList.add('scale-100', 'opacity-100', 'translate-y-0');
            }, 50);
        }

        function closeQrModal() {
            const modal = document.getElementById('qrModal');
            const modalContent = document.getElementById('qrModalContent');

            // Animate out
            modal.classList.remove('opacity-100');
            modalContent.classList.remove('scale-100', 'opacity-100', 'translate-y-0');
            modalContent.classList.add('scale-95', 'opacity-0', 'translate-y-4');

            // Hide modal after animation
            setTimeout(() => {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            }, 300);
        }

        function handleModalClick(event) {
            const modalContent = document.getElementById('qrModalContent');
            if (!modalContent.contains(event.target)) {
                closeQrModal();
            }
        }

        async function applyCoupon() {
            const couponCode = document.getElementById('couponCode').value.trim().toUpperCase();
            if (!couponCode) {
                showCouponMessage('Please enter a coupon code', 'error');
                return;
            }

            const response = await fetch(`./applyDiscount.php?discountCode=${couponCode}`);
            const result = await response.json();

            if (result.valid) {
                formData.discountCode = couponCode;
                formData.couponDiscount = result.discountValue;
                formData.booking_grand_total = calculateTotal();
                renderStepContent();
            } else {
                showCouponMessage('Invalid coupon code', 'error');
            }
        }

        function removeCoupon() {
            formData.discountCode = '';
            formData.couponDiscount = 0;
            formData.booking_grand_total = calculateTotal();
            renderStepContent();
        }

        function showCouponMessage(message, type) {
            const messageEl = document.getElementById('couponMessage');
            if (messageEl) {
                messageEl.textContent = message;
                messageEl.classList.remove('hidden', 'text-green-600', 'text-red-600');
                messageEl.classList.add(type === 'success' ? 'text-green-600' : 'text-red-600');

                if (type === 'error') {
                    setTimeout(() => {
                        messageEl.classList.add('hidden');
                    }, 3000);
                }
            }
        }
    </script>

    <div id="qrModal"
        class="fixed inset-0 bg-black/60 hidden items-center justify-center z-50 transition-all duration-300 ease-in-out opacity-0"
        onclick="handleModalClick(event)">
        <div class="bg-white rounded-2xl p-8 max-w-md w-full mx-4 shadow-2xl transform transition-all duration-300 ease-in-out scale-95 opacity-0 translate-y-4"
            id="qrModalContent">
            <div class="flex justify-between items-start mb-6">
                <div>
                    <h4 class="text-2xl font-bold text-gray-900">Complete Payment</h4>
                    <p class="text-sm text-gray-600 mt-2">Scan QR code to pay for your reservation</p>
                </div>
                <button onclick="closeQrModal()"
                    class="text-gray-400 hover:text-gray-600 transition-colors duration-200 p-1 hover:bg-gray-100 rounded-full">
                    <i class="lucide-x h-5 w-5"></i>
                </button>
            </div>

            <!-- QR Code Section -->
            <div class="text-center">
                <div class="bg-gray-50 p-8 rounded-xl mb-6 border border-gray-100">
                    <img id="qrCodeImage" src="" alt="Payment QR Code" class="mx-auto mb-4 rounded-lg shadow-md">
                    <p class="text-sm text-gray-600 mb-2">Total Amount: <span class="font-semibold text-black">₱<span
                                id="qrPaymentAmount">0</span></span></p>
                    <p class="text-sm text-gray-600">Scan this QR code using your <span id="selectedPaymentMethod"
                            class="font-medium"></span> app</p>
                </div>
                <div class="flex justify-center gap-4 mb-6">
                    <button id="openAppButton" onclick="openPaymentApp()"
                        class="flex items-center px-4 py-2.5 bg-black text-white rounded-lg text-sm font-medium 
                                   hover:bg-gray-800 transform transition-all duration-200 hover:scale-[1.02] active:scale-[0.98]">
                        <i class="lucide-smartphone h-5 w-5 mr-2"></i>
                        Open <span id="appName"></span> App
                    </button>
                    <button onclick="copyPaymentDetails()"
                        class="flex items-center px-4 py-2.5 border border-gray-300 rounded-lg text-sm font-medium 
                                   hover:bg-gray-50 transform transition-all duration-200 hover:scale-[1.02] active:scale-[0.98]">
                        <i class="lucide-copy h-5 w-5 mr-2"></i>
                        Copy Details
                    </button>
                </div>

                <!-- Reference Number Input -->
                <div class="mt-8 pt-6 border-t border-gray-200">
                    <label for="referenceNumber" class="block text-sm font-medium text-gray-700 mb-2">Already paid?
                        Enter your reference number</label>
                    <div class="flex gap-2">
                        <input type="text" id="referenceNumber" name="referenceNumber"
                            placeholder="Enter your payment reference number"
                            class="flex-1 rounded-lg border-gray-300 shadow-sm focus:border-primary focus:ring-primary h-11">
                        <button onclick="checkManualReference()"
                            class="px-4 py-2 bg-black text-white rounded-lg text-sm font-medium hover:bg-gray-800 transition-all duration-200">
                            Verify
                        </button>
                    </div>
                </div>

                <div class="mt-6">
                    <p class="text-sm text-gray-600 mb-2">Payment Status:
                        <span id="paymentStatus" class="font-medium">Waiting for payment...</span>
                    </p>
                    <div class="animate-pulse" id="loadingIndicator">
                        <div class="h-2 w-full bg-gray-100 rounded-full overflow-hidden">
                            <div class="h-2 bg-blue-500 rounded-full transition-all duration-500 ease-out"
                                style="width: 0%" id="paymentProgress">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>