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
} else if (!isset($_GET['venueId'])) {
    header('Location: index.php');
} else {
    header('Location: index.php');
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
                <h2 class="text-sm font-medium text-gray-500 mb-2">Step <span id="currentStep">1</span> of <span id="totalSteps">3</span></h2>
                <h1 id="stepTitle" class="text-3xl font-bold mb-4">Review Details</h1>
                <p id="stepDescription" class="text-gray-600 mb-8">Review and confirm your reservation details.</p>
            </div>

            <form id="paymentForm">
                <!-- Step 1: Review Details -->
                <div id="step1" class="step">
                    <div class="space-y-6">
                        <h3 class="text-2xl font-semibold mb-4">Reservation Summary</h3>
                        <div class="bg-gray-100 p-6 rounded-lg">
                            <h4 class="font-semibold text-lg mb-4"><?php echo $venueName ?></h4>
                            <div class="space-y-2">
                                <p><strong>Check-in:</strong> <?php echo $checkIn ?></p>
                                <p><strong>Check-out:</strong> <?php echo $checkOut ?></p>
                                <p><strong>Guests:</strong> <?php echo $numberOfGuest ?></p>
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
                                </div>
                                <div class="mt-4 pt-4 border-t border-gray-300 flex justify-between font-semibold">
                                    <span>Total</span>
                                    <span>₱ <?php echo $totalPrice ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Step 2: Apply Discount -->
                <div id="step2" class="step hidden">
                    <div class="space-y-6">
                        <h3 class="text-2xl font-semibold mb-4">Apply Discount</h3>
                        <div class="bg-white p-6 rounded-lg border border-gray-200">
                            <div class="mb-4">
                                <label for="couponCode" class="block text-sm font-medium text-gray-700 mb-2">Have a coupon code?</label>
                                <div class="flex gap-2">
                                    <input type="text" id="couponCode" name="couponCode" placeholder="Enter coupon code"
                                        class="flex-1 rounded-md border-gray-300 shadow-sm focus:ring-primary focus:border-primary">
                                    <button type="button" onclick="applyCoupon()" 
                                        class="px-4 py-2 bg-black text-white rounded-md text-sm font-medium hover:opacity-90">
                                        Apply
                                    </button>
                                </div>
                                <p id="couponMessage" class="text-sm mt-2 hidden"></p>
                            </div>
                            <div class="mt-4 pt-4 border-t border-gray-200">
                                <div class="flex justify-between font-semibold">
                                    <span>Final Total</span>
                                    <span>₱ <span id="finalTotal"><?php echo $totalPrice ?></span></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Step 3: Payment Method -->
                <div id="step3" class="step hidden">
                    <div class="space-y-6">
                        <h3 class="text-2xl font-semibold mb-4">Payment Method</h3>
                        <div class="grid grid-cols-2 gap-6">
                            <div class="border rounded-lg p-6 cursor-pointer hover:border-black transition-colors"
                                onclick="selectPaymentMethod('gcash')">
                                <div class="flex items-center justify-between mb-4">
                                    <img src="./images/gcash.png" alt="GCash" class="h-8">
                                    <input type="radio" name="paymentMethod" value="gcash" class="h-4 w-4">
                                </div>
                                <p class="text-sm text-gray-600">Pay securely using your GCash account</p>
                            </div>

                            <div class="border rounded-lg p-6 cursor-pointer hover:border-black transition-colors"
                                onclick="selectPaymentMethod('paymaya')">
                                <div class="flex items-center justify-between mb-4">
                                    <img src="./images/paymaya.png" alt="PayMaya" class="h-8">
                                    <input type="radio" name="paymentMethod" value="paymaya" class="h-4 w-4">
                                </div>
                                <p class="text-sm text-gray-600">Pay securely using your PayMaya account</p>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <!-- Bottom Navigation -->
        <div class="fixed bottom-0 left-0 right-0 bg-white border-t border-gray-200 p-4">
            <div class="flex justify-between items-center max-w-3xl mx-auto">
                <button id="backBtn" class="text-gray-900 font-medium" disabled>Back</button>
                <div class="flex-1 mx-8">
                    <div class="bg-gray-200 h-1 rounded-full">
                        <div id="progressBar" class="bg-black h-1 rounded-full transition-all duration-300 ease-in-out" 
                            style="width: 33.33%"></div>
                    </div>
                </div>
                <button id="nextBtn" class="bg-black text-white px-6 py-2 rounded-md">Next</button>
            </div>
        </div>
    </main>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const steps = document.querySelectorAll('.step');
            const prevBtn = document.getElementById('backBtn');
            const nextBtn = document.getElementById('nextBtn');
            const progressBar = document.getElementById('progressBar');
            const stepTitle = document.getElementById('stepTitle');
            const stepDescription = document.getElementById('stepDescription');
            const currentStepEl = document.getElementById('currentStep');
            let currentStep = 0;

            const stepContent = [
                {
                    title: "Review Details",
                    description: "Review and confirm your reservation details."
                },
                {
                    title: "Apply Discount",
                    description: "Enter a discount code if you have one."
                },
                {
                    title: "Payment Method",
                    description: "Choose your preferred payment method."
                }
            ];

            function showStep(stepIndex) {
                steps.forEach((step, index) => {
                    step.classList.toggle('hidden', index !== stepIndex);
                });
                
                prevBtn.disabled = stepIndex === 0;
                nextBtn.textContent = stepIndex === steps.length - 1 ? 'Proceed to Payment' : 'Next';
                progressBar.style.width = `${((stepIndex + 1) / steps.length) * 100}%`;
                
                // Update step content
                stepTitle.textContent = stepContent[stepIndex].title;
                stepDescription.textContent = stepContent[stepIndex].description;
                currentStepEl.textContent = stepIndex + 1;
            }

            function validateStep() {
                // Add validation logic for each step
                switch(currentStep) {
                    case 0:
                        return true; // Review step always valid
                    case 1:
                        return true; // Discount step always valid
                    case 2:
                        return document.querySelector('input[name="paymentMethod"]:checked') !== null;
                    default:
                        return true;
                }
            }

            nextBtn.addEventListener('click', function() {
                if (validateStep()) {
                    if (currentStep < steps.length - 1) {
                        currentStep++;
                        showStep(currentStep);
                    } else {
                        // Handle final step (payment)
                        const selectedPaymentMethod = document.querySelector('input[name="paymentMethod"]:checked').value;
                        selectPaymentMethod(selectedPaymentMethod);
                    }
                } else {
                    showModal('Please complete all required fields before proceeding.', undefined, "black_ico.png");
                }
            });

            prevBtn.addEventListener('click', function() {
                if (currentStep > 0) {
                    currentStep--;
                    showStep(currentStep);
                }
            });

            // Initialize first step
            showStep(currentStep);
        });
    </script>

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
            booking_grand_total: FinalAmmount || 0,
            booking_guest_id: <?php echo htmlspecialchars($_SESSION['user']['id']) ?>,
            booking_venue_id: '<?php echo htmlspecialchars($venueId) ?>',
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
            const subtotal = parseFloat(formData.booking_grand_total) || 0;
            const discount = parseFloat(formData.couponDiscount || 0);
            // console.log("s, " + subtotal, "d", + discount);
            FinalAmmount = (subtotal - (subtotal * discount));
            return (subtotal - (subtotal * discount));
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
            }
        });

        // Initialize the form
        updateStep();

        function selectPaymentMethod(method) {
            try {
                // Update radio button
                document.querySelector(`input[value="${method}"]`).checked = true;

                const totalAmount = FinalAmmount;

                // Show loading state
                document.getElementById('nextBtn').disabled = true;

                // Set QR code based on payment method
                const qrCodeImage = method === 'gcash' ? './images/gcashqr.png' : './images/paymayaqr.png';

                // Display QR code in modal
                document.getElementById('qrCodeImage').src = qrCodeImage;
                document.getElementById('qrPaymentAmount').textContent = totalAmount.toFixed(2);
                document.getElementById('selectedPaymentMethod').textContent = method === 'gcash' ? 'GCash' : 'PayMaya';
                openQrModal();

                formData.booking_payment_method = method;

            } catch (error) {
                console.error('Payment error:', error);
                showModal('Error initiating payment: ' + error.message, undefined, "black_ico.png");
            } finally {
                document.getElementById('nextBtn').disabled = false;
            }
        }

        function closeQrModal() {
            const referenceNumber = document.getElementById('referenceNumber').value.trim();
            if (referenceNumber) {
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
            } else {
                showModal('Please complete the payment and enter the reference number before closing.', undefined, "black_ico.png");
            }
        }

        function handleModalClick(event) {
            const modalContent = document.getElementById('qrModalContent');
            const referenceNumber = document.getElementById('referenceNumber').value.trim();
            
            if (!modalContent.contains(event.target) && referenceNumber) {
                closeQrModal();
            } else if (!modalContent.contains(event.target)) {
                showModal('Please complete the payment and enter the reference number before closing.', undefined, "black_ico.png");
            }
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

        const subd = document.getElementById('submitref');
        subd.addEventListener('click', () => {
            const referenceNumber = document.getElementById('referenceNumber').value.trim();
            if (referenceNumber) {
                formData.booking_payment_reference = referenceNumber;
                closeQrModal();
                
                // Make API call to save booking
                fetch('process-payment.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify(formData)
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Show success message and redirect only after successful booking
                        showModal('Reservation confirmed! Thank you for booking with us.', () => {
                            window.location.href = 'profile/rent-history.php';
                        }, "black_ico.png");
                    } else {
                        showModal('Error processing your booking. Please try again.', undefined, "black_ico.png");
                    }
                })
                .catch(error => {
                    showModal('An error occurred. Please try again.', undefined, "black_ico.png");
                });
                
            } else {
                showModal('Please enter a reference number.', undefined, "black_ico.png");
            }
        });
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
                <!-- Reference Number Input -->
                <div class="mt-8 pt-6 border-t border-gray-200">
                    <label for="referenceNumber" class="block text-sm font-medium text-gray-700 mb-2">Already paid?
                        Enter your reference number</label>
                    <div class="flex gap-2">
                        <input type="text" id="referenceNumber" name="referenceNumber" placeholder="Reference Number"
                            class="flex-1 rounded-lg border-gray-300 shadow-sm px-1 focus:border-primary  focus:ring-primary h-11">
                        <button id="submitref"
                            class="px-4 py-2 bg-black text-white rounded-lg text-sm font-medium hover:bg-gray-800 transition-all duration-200">
                            Okay
                        </button>
                    </div>
                </div>


            </div>
        </div>
    </div>
</body>

</html>