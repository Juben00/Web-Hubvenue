<?php

require_once './sanitize.php';
require_once './classes/venue.class.php';
require_once './classes/account.class.php';

session_start();

$accountObj = new Account();
$venueObj = new Venue();

if (isset($_SESSION['user'])) {
    if ($_SESSION['user']['user_type_id'] == 3) {
        header('Location: admin/');
        exit;
    }
} else {
    header('Location: index.php');
    exit;
}

if (!isset($_SESSION['reservationFormData'])) {
    header('Location: index.php');
    exit;
}

$discountApplied = false;

$reservationData = $_SESSION['reservationFormData'];

$venueId = $reservationData['venueId'];
$checkIn = new DateTime($reservationData['checkin']);
$checkOut = new DateTime($reservationData['checkout']);
$interval = $checkIn->diff($checkOut);
$bookingDuration = $interval->days;

$request = $reservationData['specialRequest'];
$numberOfGuest = $reservationData['numberOfGuest'];
$totalPriceForNights = $reservationData['totalPriceForNights'];
$totalEntranceFee = $reservationData['entranceFee'];
$cleaningFee = $reservationData['cleaningFee'];
$serviceFee = $reservationData['serviceFee'];
$subTotal = $reservationData['grandTotal'];

// Ensure all monetary values are strings
$totalPriceForNights = number_format((float) $totalPriceForNights, 2, '.', '');
$totalEntranceFee = number_format((float) $totalEntranceFee, 2, '.', '');
$cleaningFee = number_format((float) $cleaningFee, 2, '.', '');
$serviceFee = number_format((float) $serviceFee, 2, '.', '');
$subTotal = number_format((float) $subTotal, 2, '.', '');

// Get discount value
$discountStatus = $accountObj->getDiscountApplication($_SESSION['user']['id']);
$isSpecial = $discountStatus['discount_value'] ?? '0';

// Use BCMath for precise calculations
$computedTotal = bcmul($subTotal, bcsub('1', bcdiv($isSpecial, '100', 2), 2), 2);

$venueDetails = $venueObj->getSingleVenue($venueId);
$venueName = htmlspecialchars($venueDetails["venue_name"]);
$venueDownpayment = $venueObj->getDownpayment($venueId);

$Total = bcmul($computedTotal, (string) $venueDownpayment, 2);
$Balance = bcsub($computedTotal, $Total, 2);

// Update reservation data with exact values
$reservationData['Total'] = $Total;
$reservationData['Balance'] = $Balance;
$reservationData['RawPrice'] = $totalPriceForNights + $totalEntranceFee + $cleaningFee + $serviceFee;
$reservationData['Downpayment'] = number_format($venueDownpayment, 2, '.', '');

// Update the session
$_SESSION['reservationFormData'] = $reservationData;

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

            <form id="paymentForm" method="POST" enctype="multipart/form-data">
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
                                <button type="button" id="applyCouponBtn" onclick="applyCoupon()"
                                    class="<?php echo $discountApplied ? 'hidden' : ''; ?> px-4 py-2 bg-black text-white rounded-md text-sm font-medium hover:opacity-90">Apply</button>

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
                                <p><strong>Special Request:</strong> <?php echo $request ?></p>
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
                                    <div class="flex justify-between">
                                        <span>Coupon</span>
                                        <span id="discountValue">0%</span>
                                    </div>

                                </div>
                                <div class="mt-4 pt-4 border-t border-gray-300 flex justify-between font-semibold">
                                    <span>SubTotal</span>
                                    <span id="subTotal">₱ <?php echo number_format($computedTotal, 2) ?></span>
                                </div>
                                <div class="mt-4 pt-4 border-t border-gray-300 flex justify-between font-semibold">
                                    <span>Host's Down Payment Requirement</span>
                                    <span id="downPayment"><?php echo $venueDownpayment * 100 ?>%</span>
                                </div>
                                <div class="mt-4 pt-4 border-t border-gray-300 flex justify-between font-semibold">
                                    <span>Total</span>
                                    <span id="grandTotal">₱ <?php echo number_format($Total, 2) ?></span>
                                </div>
                                <div class="mt-4 pt-4 border-t border-gray-300 flex justify-between font-semibold">
                                    <span>Remaining balance: <span class="text-xs">(to be paid during the
                                            event)</span></span>
                                    <span id="balance">₱ <?php echo number_format($Balance, 2) ?></span>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                <!-- Step 2: Venue Details -->
                <div id="step2" class="step hidden">
                    <div class="space-y-6">
                        <h3 class="text-2xl font-semibold mb-4">Payment Method</h3>
                        <?php
                        var_dump($reservationData);
                        ?>
                        <div class="grid grid-cols-2 gap-6">
                            <div class="border rounded-lg p-6 cursor-pointer hover:border-black transition-colors"
                                onclick="selectPaymentMethod('gcash')">
                                <div class="flex items-center justify-between mb-4">
                                    <img src="./images/gcash.png" alt="GCash" class="h-8">
                                    <input type="radio" name="paymentMethod" value="gcash" class="h-4 w-4 pMethod">
                                </div>
                                <p class="text-sm text-gray-600">Pay securely using your GCash account</p>
                            </div>

                            <div class="border rounded-lg p-6 cursor-pointer hover:border-black transition-colors"
                                onclick="selectPaymentMethod('paymaya')">
                                <div class="flex items-center justify-between mb-4">
                                    <img src="./images/paymaya.png" alt="PayMaya" class="h-8">
                                    <input type="radio" name="paymentMethod" value="paymaya" class="h-4 w-4 pMethod">
                                </div>
                                <p class="text-sm text-gray-600">Pay securely using your PayMaya account</p>
                            </div>
                            <input type="hidden" id="finalRef" name="finalRef">
                            <input type="file" id="receiptUpload" name="receiptUpload" class="hidden">
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
        class="fixed inset-0 bg-black/60 hidden items-center justify-center z-50 transition-all duration-300 ease-in-out opacity-0">
        <div class="bg-slate-50 rounded-2xl p-8 max-w-lg w-full mx-4 shadow-2xl transform transition-all duration-300 ease-in-out scale-95 opacity-0 translate-y-4"
            id="qrModalContent">
            <div class="flex justify-between items-start mb-6">
                <div>
                    <h4 class="text-2xl font-bold text-gray-900">Complete Payment</h4>
                    <p class="text-sm text-gray-600 mt-2">Scan QR code to pay for your reservation</p>
                </div>
                <button onclick="closeQrModal()"
                    class="text-gray-900 hover:text-gray-600 transition-colors duration-200 p-1 hover:bg-gray-100 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- QR Code and Input Section -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 items-start">
                <!-- QR Code Section -->
                <div class="flex flex-col items-center bg-gray-50 p-4 rounded-xl border border-gray-200">
                    <img id="qrCodeImage" src="" alt="Payment QR Code" class="mb-4 rounded-lg shadow-md max-h-60">
                    <p class="text-sm text-gray-600 mb-2">Total Amount:
                        <span class="font-semibold text-black">₱<span id="qrPaymentAmount">0</span></span>
                    </p>
                    <p class="text-sm text-gray-600 text-center">Scan this QR code using your
                        <span id="selectedPaymentMethod" class="font-medium"></span> app
                    </p>
                </div>

                <!-- Reference Number Section -->
                <div>
                    <p class="block text-sm font-medium text-gray-700 mb-4">Enter your
                        reference number or upload receipt
                    </p>
                    <div class="flex flex-col gap-4">
                        <!-- Reference Number Input -->
                        <input type="text" id="referenceNumber" name="referenceNumber" placeholder="Reference Number"
                            class="rounded-lg border-gray-300 border shadow-sm px-3 py-2 focus:border-primary focus:ring-primary">
                        <!-- File Upload -->
                        <p class="block text-center text-sm font-medium text-gray-700">OR</p>
                        <div class="relative group">
                            <label for="receiptUpload" id="receiptLabel" class="flex items-center justify-between gap-2 cursor-pointer 
        border border-gray-300 rounded-lg px-4 py-3 shadow-sm bg-gray-50 
        text-sm text-gray-600 hover:bg-gray-100 hover:border-gray-400 transition">
                                <div class="flex items-center gap-2">
                                    <!-- Upload Icon -->
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        class="h-5 w-5 text-gray-500 group-hover:text-gray-700" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M3 10l7-7m0 0l7 7m-7-7v18" />
                                    </svg>
                                    <span id="fileLabelText">Choose File</span>
                                </div>
                                <!-- Clear Button (Hidden by Default) -->
                                <button id="clearButton" type="button"
                                    class="hidden text-xs text-red-600 hover:text-red-800 transition">
                                    Clear
                                </button>
                            </label>
                        </div>

                        <!-- Submit Button -->
                        <button id="submitref"
                            class="px-4 py-2 bg-black text-white rounded-lg text-sm font-medium hover:bg-gray-800 transition-all duration-200">
                            Submit
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        const fileInput = document.getElementById("receiptUpload");
        const labelText = document.getElementById("fileLabelText");
        const label = document.getElementById("receiptLabel");
        const clearButton = document.getElementById("clearButton");

        fileInput.addEventListener("change", () => {
            if (fileInput.files.length > 0) {
                labelText.textContent = fileInput.files[0].name; // Show file name
                label.classList.add("border-green-500", "bg-green-50", "text-green-600"); // Add success styling
                label.classList.remove("border-gray-300", "bg-gray-50", "text-gray-600"); // Remove default styling
                clearButton.classList.remove("hidden"); // Show clear button
            } else {
                resetInput();
            }
        });

        clearButton.addEventListener("click", () => {
            fileInput.value = "";
            resetInput();
        });

        function resetInput() {
            labelText.textContent = "Choose File";
            label.classList.remove("border-green-500", "bg-green-50", "text-green-600");
            label.classList.add("border-gray-300", "bg-gray-50", "text-gray-600");
            clearButton.classList.add("hidden");
        }
    </script>
    <script>

        let totalToPay = <?php echo $Total; ?>;
        let leftToPay = <?php echo $Balance; ?>;

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
                        // Update discount and total price dynamically
                        const couponDiscount = data.discountValue;
                        const discountValue = <?php echo isset($isSpecial) ? $discountStatus['discount_value'] / 100 : 0; ?> + data.discountValue;
                        // Assume percentage
                        console.log(discountValue);
                        <?php $discountApplied = true; ?>

                        const gt = parseFloat((1 - discountValue) * <?php echo $subTotal ?>); // New subtotal after discount
                        const downPaymentPercentage = <?php echo $venueDownpayment ?>; // Down payment (e.g., 0.5 for 50%)
                        totalToPay = gt * downPaymentPercentage; // Total amount to be paid
                        leftToPay = gt - totalToPay; // Remaining balance

                        <?php
                        $reservationData['Total'] = $Total;
                        $reservationData['Balance'] = $Balance;
                        ?>

                        document.getElementById('subTotal').textContent = `₱ ${gt.toFixed(2)}`;
                        document.getElementById('discountValue').textContent = `${couponDiscount * 100}%`;
                        document.getElementById('couponMessage').classList.remove('hidden');
                        document.getElementById('couponCode').disabled = true;
                        document.getElementById('applyCouponBtn').style.display = '';
                        document.getElementById('grandTotal').textContent = `₱ ${totalToPay.toFixed(2)}`;
                        document.getElementById('balance').textContent = `₱ ${leftToPay.toFixed(2)}`;
                    } else {
                        showModal("Invalid Coupon Code", function () {
                            document.getElementById('couponCode').value = '';
                        }, "black_ico.png");
                    }
                });
        }

        function selectPaymentMethod(method) {
            document.querySelector(`input[value="${method}"]`).checked = true;

            const totalAmount = totalToPay.toFixed(2);

            document.getElementById('nextBtn').disabled = true;

            const qrCodeImage = method === 'gcash' ? './images/gcashqr.png' : './images/paymayaqr.png';

            document.getElementById('qrCodeImage').src = qrCodeImage;
            document.getElementById('qrPaymentAmount').textContent = totalAmount;
            document.getElementById('selectedPaymentMethod').textContent = method === 'gcash' ? 'GCash' : 'PayMaya';
            openQrModal();

            document.getElementById('nextBtn').disabled = false;
        }



        function closeQrModal() {
            const modal = document.getElementById('qrModal');
            const modalContent = document.getElementById('qrModalContent');

            modal.classList.remove('opacity-100');
            modalContent.classList.remove('scale-100', 'opacity-100', 'translate-y-0');
            modalContent.classList.add('scale-95', 'opacity-0', 'translate-y-4');

            setTimeout(() => {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            }, 300);
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