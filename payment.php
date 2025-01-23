<?php

require_once './sanitize.php';
require_once './classes/venue.class.php';
require_once './classes/account.class.php';

session_start();
$accountObj = new Account();
$reservationData = $_SESSION['reservationFormData'];

if (isset($_SESSION['user'])) {
    if ($_SESSION['user']['user_type_id'] == 3) {
        header('Location: admin/');
        exit;
    }
    if (!$reservationData) {
        header('Location: index.php');
    }
} else {
    header('Location: index.php');
    unset($_SESSION['reservationFormData']);
    exit;
}


$venueObj = new Venue();

// $venueId = $_GET['venueId'];
$venueId = $reservationData['venueId'];
$checkIn = new DateTime($reservationData['checkin']);
$checkOut = new DateTime($reservationData['checkout']);
$interval = $checkIn->diff($checkOut);
$bookingDuration = $interval->days;
$numberOfGuest = $reservationData['numberOfGuest'];
$totalPriceForNights = $reservationData['totalPriceForNights'];
$totalEntranceFee = $reservationData['entranceFee'];
$cleaningFee = $reservationData['cleaningFee'];
$serviceFee = $reservationData['serviceFee'];
$totalPrice = $reservationData['grandTotal'];


$venueDetails = $venueObj->getSingleVenue($venueId);
$venueName = htmlspecialchars($venueDetails["venue_name"]);


$discounts = $venueObj->getAllDiscounts();

$discountApplied = false;
$discountCode = isset($_GET['discountCode']) ? htmlspecialchars($_GET['discountCode']) : 'none';
if ($discountCode !== 'none') {
    $totalPrice = applyDiscount($discounts, $discountCode, $totalPrice);
    $discountApplied = true;
}
// -----------------------------
// // Calculate grand total if no discount is applied
// if (!$discountApplied) {
//     $totalPrice = $totalPriceForNights;
// }

$discountStatus = $accountObj->getDiscountApplication($_SESSION['user']['id']);
// Apply discount from discountStatus
// if ($discountStatus) {
//     $totalPrice = $totalPrice * (1 - $discountStatus['discount_value'] / 100);
// }

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

<body class="min-h-screen flex flex-col bg-slate-50">

    <!-- Header -->
    <?php
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

            <form id="paymentForm" method="POST" action="PaymentProcess.api.php">
                <!-- Step 1:  -->
                <div id="step1" class="step">
                    <div class="space-y-6">
                        <h3 class="text-2xl font-semibold mb-4">Reservation Summary</h3>
                        <!-- Coupon Input Section -->
                        <div class="bg-slate-50 p-4 rounded-lg mb-4">
                            <div class="flex gap-2">
                                <input type="text" id="couponCode" name="couponCode" placeholder="Enter coupon code"
                                    value=""
                                    class="flex-1 rounded-md shadow-sm px-1 focus:ring-primary focus:border-primary h-10"
                                    <?php echo $discountApplied ? 'disabled' : ''; ?>>
                                <?php if (!$discountApplied): ?>
                                    <button type="button" id="applyCouponBtn" onclick="applyCoupon()"
                                        class="px-4 py-2 bg-black text-white rounded-md text-sm font-medium hover:opacity-90">Apply</button>
                                <?php endif; ?>
                            </div>
                            <p id="couponMessage"
                                class="text-sm mt-2 <?php echo $discountApplied ? '' : 'hidden'; ?> text-green-600">
                                Coupon applied successfully!</p>
                        </div>

                        <div class="bg-gray-100 p-6 rounded-lg">
                            <h4 class="font-semibold text-lg mb-4"><?php echo $venueName ?></h4>
                            <div class="space-y-2">
                                <p><strong>Date:</strong>
                                    <?php
                                    $checkInFormatted = date('F j, Y', strtotime($reservationData['checkin']));
                                    $checkOutFormatted = date('F j, Y', strtotime($reservationData['checkout']));
                                    echo $checkInFormatted . ' to ' . $checkOutFormatted;
                                    ?>
                                </p>
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
                                        <span>₱ <?php echo number_format($cleaningFee, 2) ?></span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span>Service Fee</span>
                                        <span>₱ <?php echo $serviceFee ?></span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="">Discounts(PWD/Senior
                                            Citizen)</span>
                                        <span><?php
                                        if ($discountStatus) {
                                            echo htmlspecialchars(number_format($discountStatus['discount_value'], 0)) . "%";
                                        } else {
                                            echo "0%";
                                        }
                                        ?></span>
                                    </div>
                                </div>
                                <div class="mt-4 pt-4 border-t border-gray-300 ">
                                    <div class="flex justify-between">
                                        <span>Coupon</span>
                                        <span id="discountValue">0%</span>

                                    </div>
                                </div>
                                <div class="mt-4 pt-4 border-t border-gray-300 flex justify-between font-semibold">
                                    <span>Total</span>
                                    <span id="totalPrice">₱ <?php echo $totalPrice ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Step 2: Venue Details -->
                <div id="step2" class="step hidden">
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
                            <input type="hidden" id="finalRef" name="finalRef">
                        </div>
                    </div>
                </div>
                <input type="submit" id="paymentSubmit" value="" class="hidden">
            </form>
        </div>

        <div class="fixed bottom-0 left-0 right-0 bg-slate-50 border-t border-gray-200 p-4">
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

    <div id="qrModal"
        class="fixed inset-0 bg-black/60 hidden items-center justify-center z-50 transition-all duration-300 ease-in-out opacity-0"
        onclick="handleModalClick(event)">
        <div class="bg-slate-50 rounded-2xl p-8 max-w-md w-full mx-4 shadow-2xl transform transition-all duration-300 ease-in-out scale-95 opacity-0 translate-y-4"
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
                            class="flex-1 rounded-lg border-gray-300 shadow-sm px-1 focus:border-primary focus:ring-primary h-11">
                        <button id="submitref"
                            class="px-4 py-2 bg-black text-white rounded-lg text-sm font-medium hover:bg-gray-800 transition-all duration-200">Okay</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {

            document.getElementById('submitref').addEventListener('click', () => {
                const referenceNumber = document.getElementById('referenceNumber').value;
                document.getElementById('finalRef').value = referenceNumber;

                closeQrModal();
            })
            const steps = document.querySelectorAll('.step');
            const totalSteps = steps.length;
            let currentStep = 0;

            const backBtn = document.getElementById('backBtn');
            const nextBtn = document.getElementById('nextBtn');
            const progressBar = document.getElementById('progressBar');
            const currentStepSpan = document.getElementById('currentStep');
            const totalStepsSpan = document.getElementById('totalSteps');

            totalStepsSpan.textContent = totalSteps;

            function updateStep() {
                steps.forEach((step, index) => {
                    step.classList.toggle('hidden', index !== currentStep);
                });

                currentStepSpan.textContent = currentStep + 1;
                progressBar.style.width = `${(currentStep / (totalSteps - 1)) * 100}%`;

                backBtn.disabled = currentStep === 0;
                nextBtn.textContent = currentStep === totalSteps - 1 ? 'Finish' : 'Next';
            }

            backBtn.addEventListener('click', function () {
                if (currentStep > 0) {
                    currentStep--;
                    updateStep();
                }
            });

            nextBtn.addEventListener('click', function () {
                if (currentStep < totalSteps - 1) {
                    currentStep++;
                    updateStep();
                } else {
                    document.getElementById('paymentSubmit').click();
                }
            });

            updateStep();
        });

        function applyCoupon() {
            const couponCode = document.getElementById('couponCode').value;
            fetch(`applyDiscount.php?discountCode=${couponCode}`)
                .then(response => response.json())
                .then(data => {
                    if (data.valid) {
                        const discountValue = data.discountValue;

                        <?php
                        if (is_array($discountStatus) && isset($discountStatus['discount_value'])) {
                            $totalPrice = $totalPrice - $totalPrice * $discountStatus['discount_value'] / 100;
                        }
                        ?>

                        document.getElementById('totalPrice').textContent = `₱ ${<?php echo $totalPrice ?>.toFixed(2)}`;
                        document.getElementById('discountValue').textContent = `${discountValue * 100}%`;
                        document.getElementById('couponMessage').classList.remove('hidden');
                        document.getElementById('couponCode').disabled = true;
                        document.getElementById('applyCouponBtn').style.display = '';
                        document.getElementById('couponsub').value = couponCode;
                    } else {
                        showModal("Invalid Coupon Code", function () {
                            document.getElementById('couponCode').value = 'none';
                        }, "black_ico.png");
                    }
                });
        }

        function selectPaymentMethod(method) {
            document.querySelector(`input[value="${method}"]`).checked = true;

            const totalAmount = <?php echo $totalPrice ?>;

            document.getElementById('nextBtn').disabled = true;

            const qrCodeImage = method === 'gcash' ? './images/gcashqr.png' : './images/paymayaqr.png';

            document.getElementById('qrCodeImage').src = qrCodeImage;
            document.getElementById('qrPaymentAmount').textContent = totalAmount;
            document.getElementById('selectedPaymentMethod').textContent = method === 'gcash' ? 'GCash' : 'PayMaya';
            openQrModal();

            document.getElementById('nextBtn').disabled = false;
        }

        function closeQrModal() {
            const referenceNumber = document.getElementById('referenceNumber').value.trim();
            if (referenceNumber) {
                const modal = document.getElementById('qrModal');
                const modalContent = document.getElementById('qrModalContent');

                modal.classList.remove('opacity-100');
                modalContent.classList.remove('scale-100', 'opacity-100', 'translate-y-0');
                modalContent.classList.add('scale-95', 'opacity-0', 'translate-y-4');

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

        function openQrModal() {
            const modal = document.getElementById('qrModal');
            const modalContent = document.getElementById('qrModalContent');

            modal.classList.remove('hidden');
            void modal.offsetWidth;
            modal.classList.add('flex', 'opacity-100');

            setTimeout(() => {
                modalContent.classList.remove('scale-95', 'opacity-0', 'translate-y-4');
                modalContent.classList.add('scale-100', 'opacity-100', 'translate-y-0');
            }, 50);
        }
    </script>

    <script src="./vendor/jQuery-3.7.1/jquery-3.7.1.min.js"></script>
    <script src="./js/user.jquery.js"></script>

</body>

</html>