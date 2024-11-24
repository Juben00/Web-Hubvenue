<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HubVenue - Venue Reservation</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/lucide-static@0.321.0/font/lucide.min.css" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#FF0000',
                    }
                }
            }
        }
    </script>
</head>

<body class="min-h-screen flex flex-col bg-white">
    <?php
    session_start();

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
                        id="totalSteps">3</span></h2>
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
        // Discount Modal Functions
        function openDiscountModal() {
            const modal = document.getElementById('discountModal');
            const modalContent = document.getElementById('discountModalContent');

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

        function closeDiscountModal() {
            const modal = document.getElementById('discountModal');
            const modalContent = document.getElementById('discountModalContent');

            // Animate out
            modal.classList.remove('opacity-100');
            modalContent.classList.remove('scale-100', 'opacity-100', 'translate-y-0');
            modalContent.classList.add('scale-95', 'opacity-0', 'translate-y-4');

            // Hide modal after animation
            setTimeout(() => {
                modal.classList.add('hidden');
                modal.classList.remove('flex');

                // Uncheck the discount checkbox if no data was entered
                if (!formData.seniorPwdId) {
                    document.getElementById('seniorPwdDiscount').checked = false;
                }
            }, 300);
        }

        function handleDiscountModalClick(event) {
            const modalContent = document.querySelector('#discountModal > div');
            if (!modalContent.contains(event.target)) {
                closeDiscountModal();
            }
        }

        const steps = [
            { title: "Discounts", description: "Apply any available discounts to your reservation." },
            { title: "Review Details", description: "Review and confirm your reservation details." },
            { title: "Payment", description: "Complete your payment to secure the reservation." }
        ];

        let currentStep = 1;
        const totalSteps = steps.length;
        let formData = {
            date: '',
            time: '',
            durationValue: '',
            durationType: 'days',
            eventType: '',
            guestCount: 1,
            specialRequests: '',
            cardName: '',
            cardNumber: '',
            expirationDate: '',
            cvv: '',
            seniorPwdId: '',
            couponCode: '',
            appliedDiscount: 0,
            discountType: ''
        };

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
                            <h3 class="text-2xl font-semibold mb-4">Available Discounts</h3>
                            
                            <div class="bg-gray-50 p-6 rounded-lg mb-6">
                                <div class="mb-6">
                                    <label class="flex items-center space-x-2">
                                        <input type="checkbox" id="seniorPwdDiscount" class="rounded text-primary focus:ring-primary">
                                        <span>Senior Citizen / PWD Discount (20% off)</span>
                                    </label>
                                    <p id="discountStatus" class="text-sm text-green-600 mt-1 hidden"></p>
                                </div>

                                <div class="flex gap-2">
                                    <input type="text" 
                                           id="couponCode" 
                                           name="couponCode" 
                                           placeholder="Enter coupon code"
                                           class="flex-1 rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary h-10">
                                    <button onclick="applyCoupon()" 
                                            class="px-4 py-2 bg-black text-white rounded-md text-sm font-medium hover:bg-gray-800">
                                        Apply
                                    </button>
                                </div>
                                <p id="discountMessage" class="text-sm mt-2 hidden"></p>
                            </div>

                        </div>
                    `;

                    // Add event listener for senior/PWD discount checkbox
                    const seniorPwdCheckbox = document.getElementById('seniorPwdDiscount');
                    if (seniorPwdCheckbox) {
                        seniorPwdCheckbox.addEventListener('change', function (e) {
                            if (e.target.checked) {
                                openDiscountModal();
                            } else {
                                clearDiscountData();
                            }
                        });
                    }
                    break;
                case 2:
                    stepContent.innerHTML = `
                        <div class="space-y-6">
                            <h3 class="text-2xl font-semibold mb-4">Reservation Summary</h3>
                            <div class="bg-gray-100 p-6 rounded-lg">
                                <h4 class="font-semibold text-lg mb-4">Santiago Resort Room 1</h4>
                                <div class="space-y-2">
                                    <p><strong>Date:</strong> ${formData.date}</p>
                                    <p><strong>Time:</strong> ${formData.time}</p>
                                    <p><strong>Duration:</strong> ${formData.durationValue} ${formData.durationType}</p>
                                    <p><strong>Event Type:</strong> ${formData.eventType}</p>
                                    <p><strong>Guests:</strong> ${formData.guestCount}</p>
                                    ${formData.appliedDiscount ? `<p><strong>Discount Applied:</strong> ${formData.discountType === 'senior_pwd' ? 'Senior/PWD (20%)' : 'Coupon (10%)'}</p>` : ''}
                                </div>
                                <div class="mt-6 pt-4 border-t border-gray-300">
                                    <h5 class="font-semibold mb-2">Price Breakdown</h5>
                                    <div class="space-y-1">
                                        <div class="flex justify-between">
                                            <span>Base Price (₱500 x ${formData.durationValue} ${formData.durationType})</span>
                                            <span>₱${500 * parseInt(formData.durationValue)}</span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span>Entrance Fee</span>
                                            <span>₱100</span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span>Cleaning Fee</span>
                                            <span>₱250</span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span>HubVenue Service Fee</span>
                                            <span>₱50</span>
                                        </div>
                                        ${formData.appliedDiscount ? `
                                        <div class="flex justify-between text-green-600">
                                            <span>Discount Applied</span>
                                            <span>-₱${(500 * parseInt(formData.durationValue) + 100 + 250 + 50) * formData.appliedDiscount}</span>
                                        </div>
                                        ` : ''}
                                    </div>
                                    <div class="mt-4 pt-4 border-t border-gray-300 flex justify-between font-semibold">
                                        <span>Total</span>
                                        <span>₱${(500 * parseInt(formData.durationValue) + 100 + 250 + 50) * (1 - (formData.appliedDiscount || 0))}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;
                    break;
                case 3:
                    stepContent.innerHTML = `
                        <div class="space-y-6">
                            <h3 class="text-2xl font-semibold mb-4">Payment Method</h3>
                            
                            <div class="grid grid-cols-2 gap-6">
                                <div class="border rounded-lg p-6 cursor-pointer hover:border-black transition-colors" onclick="selectPaymentMethod('gcash')">
                                    <div class="flex items-center justify-between mb-4">
                                        <img src="gcash.png" alt="GCash" class="h-8">
                                        <input type="radio" name="paymentMethod" value="gcash" class="h-4 w-4">
                                    </div>
                                    <p class="text-sm text-gray-600">Pay securely using your GCash account</p>
                                </div>
                                
                                <div class="border rounded-lg p-6 cursor-pointer hover:border-black transition-colors" onclick="selectPaymentMethod('paymaya')">
                                    <div class="flex items-center justify-between mb-4">
                                        <img src="paymaya.png" alt="PayMaya" class="h-8">
                                        <input type="radio" name="paymentMethod" value="paymaya" class="h-4 w-4">
                                    </div>
                                    <p class="text-sm text-gray-600">Pay using your PayMaya account</p>
                                </div>
                            </div>
                        </div>
                    `;

                    const discountScript = document.createElement('script');
                    discountScript.textContent = `
                        document.getElementById('seniorPwdDiscount').addEventListener('change', function(e) {
                            if (e.target.checked) {
                                openDiscountModal();
                            } else {
                                clearDiscountData();
                            }
                        });

                        function openDiscountModal() {
                            const modal = document.getElementById('discountModal');
                            const modalContent = document.getElementById('discountModalContent');
                            
                            // Show modal with fade in
                            modal.classList.remove('hidden');
                            modal.classList.add('flex');
                            
                            // Trigger reflow
                            void modal.offsetWidth;
                            
                            // Animate content
                            modalContent.classList.remove('scale-95', 'opacity-0');
                            modalContent.classList.add('scale-100', 'opacity-100');
                        }

                        function closeDiscountModal() {
                            const modal = document.getElementById('discountModal');
                            const modalContent = document.getElementById('discountModalContent');
                            
                            // Animate out
                            modalContent.classList.remove('scale-100', 'opacity-100');
                            modalContent.classList.add('scale-95', 'opacity-0');
                            
                            // Hide modal after animation
                            setTimeout(() => {
                                modal.classList.add('hidden');
                                modal.classList.remove('flex');
                                
                                // Uncheck the discount checkbox if no data was entered
                                if (!formData.seniorPwdId) {
                                    document.getElementById('seniorPwdDiscount').checked = false;
                                }
                            }, 200);
                        }

                        function handleDiscountModalClick(event) {
                            const modalContent = document.querySelector('#discountModal > div');
                            if (!modalContent.contains(event.target)) {
                                closeDiscountModal();
                            }
                        }

                        function clearDiscountData() {
                            document.getElementById('seniorPwdId').value = '';
                            document.getElementById('seniorPwdName').value = '';
                            document.getElementById('seniorPwdIdPhoto').value = '';
                            document.getElementById('discountStatus').classList.add('hidden');
                            formData.seniorPwdId = '';
                            formData.seniorPwdName = '';
                            formData.seniorPwdIdPhoto = null;
                            formData.appliedDiscount = 0;
                            formData.discountType = '';
                            updatePriceBreakdown();
                        }

                        function applyDiscount() {
                            if (!validateForm()) {
                                return;
                            }
                            
                            const name = document.getElementById('seniorPwdName').value.trim();
                            const id = document.getElementById('seniorPwdId').value.trim();
                            const photo = document.getElementById('seniorPwdIdPhoto').files[0];

                                formData.seniorPwdName = name;
                                formData.seniorPwdId = id;
                                formData.seniorPwdIdPhoto = photo;
                                formData.appliedDiscount = 0.20;
                                formData.discountType = 'senior_pwd';
                                
                                // Show success message
                                const statusEl = document.getElementById('discountStatus');
                            statusEl.textContent = 'Senior Citizen/PWD discount (20%) applied successfully!';
                            statusEl.classList.remove('hidden', 'text-red-600');
                            statusEl.classList.add('text-green-600');
                                
                                // Close modal
                                closeDiscountModal();
                                
                                // Update price
                                updatePriceBreakdown();
                        }

                        function validateForm() {
                            const name = document.getElementById('seniorPwdName').value.trim();
                            const id = document.getElementById('seniorPwdId').value.trim();
                            const photo = document.getElementById('seniorPwdIdPhoto').files[0];
                            const applyBtn = document.getElementById('applyDiscountBtn');
                            
                            // Show/hide error messages with animation
                            ['nameError', 'idError', 'photoError'].forEach(errorId => {
                                const errorElement = document.getElementById(errorId);
                                if (errorElement) {
                                    if (errorElement.classList.contains('hidden')) {
                                        errorElement.style.maxHeight = '0';
                                        errorElement.classList.remove('hidden');
                                        void errorElement.offsetWidth;
                                        errorElement.style.maxHeight = errorElement.scrollHeight + 'px';
                                    } else {
                                        errorElement.style.maxHeight = '0';
                                        setTimeout(() => {
                                            errorElement.classList.add('hidden');
                                        }, 200);
                                    }
                                }
                            });
                            
                            applyBtn.disabled = !(name && id && photo);
                            
                            // Add pulse animation when button becomes enabled
                            if (!applyBtn.disabled) {
                                applyBtn.classList.add('animate-pulse');
                                setTimeout(() => {
                                    applyBtn.classList.remove('animate-pulse');
                                }, 1000);
                            }
                        }

                        function updateFileLabel(input) {
                            const label = document.getElementById('fileLabel');
                            const photoError = document.getElementById('photoError');
                            
                            if (input.files && input.files[0]) {
                                const file = input.files[0];
                                
                                // Check file size (5MB limit)
                                if (file.size > 5 * 1024 * 1024) {
                                    photoError.textContent = 'File size must be less than 5MB';
                                    photoError.classList.remove('hidden');
                                    input.value = '';
                                    label.textContent = 'Click to upload ID photo';
                                    return;
                                }
                                
                                // Check file type
                                if (!file.type.startsWith('image/')) {
                                    photoError.textContent = 'Please upload an image file';
                                    photoError.classList.remove('hidden');
                                    input.value = '';
                                    label.textContent = 'Click to upload ID photo';
                                    return;
                                }
                                
                                label.textContent = file.name;
                                photoError.classList.add('hidden');
                            } else {
                                label.textContent = 'Click to upload ID photo';
                            }
                            validateForm();
                        }

                        async function applyCoupon() {
                            const couponCode = document.getElementById('couponCode').value;
                            const messageEl = document.getElementById('discountMessage');
                            
                            // Simulate coupon validation
                            // In real implementation, this would be an API call
                            if (couponCode === 'SAVE10') {
                                formData.couponCode = couponCode;
                                formData.appliedDiscount = 0.10; // 10% discount
                                formData.discountType = 'coupon';
                                messageEl.textContent = 'Coupon applied successfully!';
                                messageEl.classList.remove('hidden', 'text-red-600');
                                messageEl.classList.add('text-green-600');
                                updatePriceBreakdown();
                            } else {
                                messageEl.textContent = 'Invalid coupon code';
                                messageEl.classList.remove('hidden', 'text-green-600');
                                messageEl.classList.add('text-red-600');
                                formData.couponCode = '';
                                formData.appliedDiscount = 0;
                                formData.discountType = '';
                                updatePriceBreakdown();
                            }
                        }

                        function updatePriceBreakdown() {
                            const basePrice = 500 * parseInt(formData.durationValue);
                            const subtotal = basePrice + 100 + 250 + 50;
                            const discount = subtotal * formData.appliedDiscount;
                            const total = subtotal - discount;

                            document.getElementById('subtotal').textContent = subtotal;
                            document.getElementById('discountAmount').textContent = discount.toFixed(2);
                            document.getElementById('finalTotal').textContent = total.toFixed(2);
                            
                            const discountRow = document.getElementById('discountRow');
                            if (discount > 0) {
                                discountRow.classList.remove('hidden');
                            } else {
                                discountRow.classList.add('hidden');
                            }
                        }
                    `;
                    document.body.appendChild(discountScript);
                    break;
            }

            // Add event listeners to form inputs
            const inputs = stepContent.querySelectorAll('input, select, textarea');
            inputs.forEach(input => {
                input.addEventListener('change', (e) => {
                    formData[e.target.name] = e.target.value;
                });
            });
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
            // Update radio button
            document.querySelector(`input[value="${method}"]`).checked = true;

            // Calculate total amount
            const basePrice = 500 * parseInt(formData.durationValue);
            const subtotal = basePrice + 100 + 250 + 50;
            const discount = subtotal * (formData.appliedDiscount || 0);
            const totalAmount = subtotal - discount;

            try {
                // Initiate payment
                const response = await fetch('../payment/process-payment.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        paymentMethod: method,
                        amount: totalAmount,
                        reservationDetails: formData
                    })
                });

                const data = await response.json();

                if (data.success) {
                    // Display QR code in modal
                    document.getElementById('qrCodeImage').src = data.qrCode;
                    document.getElementById('qrPaymentAmount').textContent = totalAmount;
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
                    formData.paymentReference = data.reference;

                    // Start checking payment status
                    checkPaymentStatus(data.reference);
                } else {
                    throw new Error(data.message);
                }
            } catch (error) {
                alert('Error initiating payment: ' + error.message);
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

        async function checkPaymentStatus(reference) {
            const progressBar = document.getElementById('paymentProgress');
            const paymentStatus = document.getElementById('paymentStatus');
            const loadingIndicator = document.getElementById('loadingIndicator');
            const nextBtn = document.getElementById('nextBtn');

            let retryCount = 0;
            const maxRetries = 20;

            async function checkStatus() {
                try {
                    const response = await fetch(`../payment/process-payment.php?reference=${reference}`);
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }

                    const data = await response.json();

                    if (data.status === 'completed') {
                        progressBar.style.width = '100%';
                        paymentStatus.textContent = 'Payment completed! Thank you for choosing HubVenue<3';
                        paymentStatus.classList.add('text-green-600');
                        loadingIndicator.classList.remove('animate-pulse');
                        nextBtn.disabled = false;
                        // Modal will stay open until user manually closes it
                        return;
                    }

                    progressBar.style.width = `${(retryCount / maxRetries) * 100}%`;

                    retryCount++;
                    if (retryCount < maxRetries) {
                        setTimeout(checkStatus, 3000);
                    } else {
                        paymentStatus.textContent = 'Payment verification timed out. Please contact support.';
                        paymentStatus.classList.add('text-red-600');
                        loadingIndicator.classList.remove('animate-pulse');
                    }

                } catch (error) {
                    console.error('Payment status check error:', error);
                    paymentStatus.textContent = 'Unable to verify payment. Please refresh or contact support.';
                    paymentStatus.classList.add('text-red-600');
                    loadingIndicator.classList.remove('animate-pulse');
                }
            }

            checkStatus();
        }

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

        // Add input event listeners for real-time validation
        document.getElementById('seniorPwdName').addEventListener('input', validateForm);
        document.getElementById('seniorPwdId').addEventListener('input', validateForm);

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
<<<<<<< HEAD:payment.php
                <div class="mt-4">
                    <p class="text-sm text-gray-600 mb-2">Payment Status:
=======

                <!-- Reference Number Input -->
                <div class="mt-8 pt-6 border-t border-gray-200">
                    <label for="referenceNumber" class="block text-sm font-medium text-gray-700 mb-2">Already paid? Enter your reference number</label>
                    <div class="flex gap-2">
                        <input type="text" 
                               id="referenceNumber" 
                               name="referenceNumber" 
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
>>>>>>> fed2a35afc5e9c2cc48a0d870b52847123b6621e:payment/payment.php
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

    <div id="discountModal"
        class="fixed inset-0 bg-black/60 hidden items-center justify-center z-50 transition-all duration-300 ease-in-out opacity-0"
        onclick="handleDiscountModalClick(event)">
        <div class="bg-white rounded-2xl p-8 max-w-md w-full mx-4 shadow-2xl transform transition-all duration-300 ease-in-out scale-95 opacity-0 translate-y-4"
            id="discountModalContent">
            <!-- Header -->
            <div class="flex justify-between items-start mb-6">
                <div>
                    <h4 class="text-2xl font-bold text-gray-900">Senior Citizen / PWD Details</h4>
                    <p class="text-sm text-gray-600 mt-2">Please provide the required information to apply the discount
                    </p>
                </div>
                <button onclick="closeDiscountModal()"
                    class="text-gray-400 hover:text-gray-600 transition-colors duration-200 p-1 hover:bg-gray-100 rounded-full">
                    <i class="lucide-x h-5 w-5"></i>
                </button>
            </div>

            <!-- Form Content -->
            <div class="space-y-6">
                <div class="space-y-2">
                    <label class="block text-sm font-medium text-gray-700">ID Holder's Full Name</label>
                    <input type="text" id="seniorPwdName" name="seniorPwdName"
                        placeholder="Enter the name as shown on the ID"
                        class="w-full rounded-lg border-gray-300 shadow-sm focus:border-primary focus:ring-primary h-11 transition-colors duration-200">
                    <p id="nameError" class="text-red-500 text-xs mt-1 hidden">Please enter the ID holder's name</p>
                </div>

                <div class="space-y-2">
                    <label class="block text-sm font-medium text-gray-700">ID Number</label>
                    <input type="text" id="seniorPwdId" name="seniorPwdId"
                        placeholder="Enter Senior Citizen/PWD ID Number"
                        class="w-full rounded-lg border-gray-300 shadow-sm focus:border-primary focus:ring-primary h-11 transition-colors duration-200">
                    <p id="idError" class="text-red-500 text-xs mt-1 hidden">Please enter a valid ID number</p>
                </div>

                <div class="space-y-2">
                    <label class="block text-sm font-medium text-gray-700">Upload ID Photo</label>
                    <div class="relative">
                        <input type="file" id="seniorPwdIdPhoto" name="seniorPwdIdPhoto" accept="image/*" class="hidden"
                            onchange="updateFileLabel(this)">
                        <label for="seniorPwdIdPhoto"
                            class="flex items-center justify-center w-full h-11 px-4 border-2 border-dashed border-gray-300 rounded-lg cursor-pointer hover:border-primary transition-colors duration-200 group">
                            <i
                                class="lucide-upload h-5 w-5 text-gray-400 group-hover:text-primary transition-colors duration-200 mr-2"></i>
                            <span id="fileLabel"
                                class="text-sm text-gray-500 group-hover:text-gray-700 transition-colors duration-200">Click
                                to upload ID photo</span>
                        </label>
                    </div>
                    <p id="photoError" class="text-red-500 text-xs mt-1 hidden">Please upload a photo of the ID</p>
                    <p class="text-xs text-gray-500 mt-1">Please upload a clear photo of the valid ID (Max 5MB)</p>
                </div>

                <button onclick="applyDiscount()" id="applyDiscountBtn" disabled class="w-full h-11 bg-black text-white rounded-lg text-sm font-medium 
                               hover:bg-gray-800 disabled:opacity-50 disabled:cursor-not-allowed
                               transform transition-all duration-200 hover:scale-[1.02] active:scale-[0.98]
                               disabled:hover:scale-100">
                    Apply Discount
                </button>
            </div>
        </div>
    </div>
</body>

</html>