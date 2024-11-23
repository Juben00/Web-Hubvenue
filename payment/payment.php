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
    <?php include __DIR__ . '/../components/payment.nav.php'; ?>


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
        const steps = [
            { title: "Confirmation", description: "Review and confirm your reservation." },
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
                            <h3 class="text-2xl font-semibold mb-4">Reservation Summary</h3>
                            <div class="bg-gray-100 p-6 rounded-lg">
                                <h4 class="font-semibold text-lg mb-4">Santiago Resort Room 1</h4>
                                <div class="space-y-2">
                                    <p><strong>Date:</strong> ${formData.date}</p>
                                    <p><strong>Time:</strong> ${formData.time}</p>
                                    <p><strong>Duration:</strong> ${formData.durationValue} ${formData.durationType}</p>
                                    <p><strong>Event Type:</strong> ${formData.eventType}</p>
                                    <p><strong>Guests:</strong> ${formData.guestCount}</p>
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
                                    </div>
                                    <div class="mt-4 pt-4 border-t border-gray-300 flex justify-between font-semibold">
                                        <span>Total</span>
                                        <span>₱${500 * parseInt(formData.durationValue) + 100 + 250 + 50}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="flex items-center">
                                <i class="lucide-check h-5 w-5 text-green-500 mr-2"></i>
                                <p class="text-sm text-gray-600">Please review all details before proceeding to payment.</p>
                            </div>
                        </div>
                    `;
                    break;
                    stepContent.innerHTML = `
                        <div class="space-y-6">
                            <h3 class="text-2xl font-semibold mb-4">Santiago Resort Room 1</h3>
                            <div class="flex items-center text-sm text-gray-500 mb-4">
                                <i class="lucide-map-pin h-4 w-4 mr-1"></i>
                                <span>Cabatangan, Zamboanga City, Zamboanga Peninsula, 7000, Philippines</span>
                            </div>
                            <div class="grid grid-cols-3 gap-6 h-[600px]">
                                <div class="col-span-2 row-span-2">
                                    <img src="/placeholder.svg?height=600&width=800" alt="Santiago Resort Room 1 main image" class="rounded-lg object-cover w-full h-full">
                                </div>
                                <div class="h-[290px]">
                                    <img src="/placeholder.svg?height=300&width=400" alt="Santiago Resort Room 1 image 2" class="rounded-lg object-cover w-full h-full">
                                </div>
                                <div class="relative h-[290px]">
                                    <img src="/placeholder.svg?height=300&width=400" alt="Santiago Resort Room 1 image 3" class="rounded-lg object-cover w-full h-full">
                                    <button class="absolute inset-0 bg-black bg-opacity-50 text-white flex items-center justify-center rounded-lg transition-opacity hover:bg-opacity-75">
                                        Show all photos
                                    </button>
                                </div>
                            </div>
                            <div class="grid grid-cols-2 gap-8">
                                <div>
                                    <h4 class="text-lg font-semibold mb-2">Place Description</h4>
                                    <p class="text-gray-600">This Resort offers a wide range of activities suitable for all ages.</p>
                                    <h4 class="text-lg font-semibold mt-4 mb-2">What this place offers</h4>
                                    <ul class="list-disc list-inside text-gray-600">
                                        <li>Pool</li>
                                        <li>Karaoke</li>
                                        <li>Duyan Spot</li>
                                        <li>Shower</li>
                                        <li>Comfort Rooms</li>
                                        <li>Cottages</li>
                                    </ul>
                                </div>
                                <div>
                                    <div class="bg-gray-100 p-4 rounded-lg">
                                        <div class="flex justify-between items-center mb-4">
                                            <span class="text-2xl font-bold">₱500.00</span>
                                            <span class="text-gray-500">per day</span>
                                        </div>
                                        <div class="flex items-center mb-4">
                                            <i class="lucide-star h-5 w-5 text-yellow-400 mr-1"></i>
                                            <span class="text-sm text-gray-600">New listing</span>
                                        </div>
                                        <div class="space-y-2">
                                            <div class="flex justify-between">
                                                <span>Entrance fee</span>
                                                <span>₱100</span>
                                            </div>
                                            <div class="flex justify-between">
                                                <span>Cleaning fee</span>
                                                <span>₱250</span>
                                            </div>
                                            <div class="flex justify-between">
                                                <span>HubVenue service fee</span>
                                                <span>₱50</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mt-4">
                                        <h4 class="text-lg font-semibold mb-2">Venue Capacity</h4>
                                        <p class="flex items-center text-gray-600">
                                            <i class="lucide-users h-5 w-5 mr-2"></i>
                                            Up to 50 guests
                                        </p>
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
                            
                            <div class="bg-gray-50 p-6 rounded-lg mb-6">
                                <h4 class="text-lg font-semibold mb-4">Available Discounts</h4>
                                
                                <div class="mb-4">
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
                                           class="flex-1 rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary">
                                    <button onclick="applyCoupon()" 
                                            class="px-4 py-2 bg-black text-white rounded-md text-sm font-medium hover:bg-gray-800">
                                        Apply
                                    </button>
                                </div>
                                <p id="discountMessage" class="text-sm mt-2 hidden"></p>
                            </div>

                            <div class="mb-6">
                                <label for="referenceNumber" class="block text-sm font-medium text-gray-700 mb-1">Reference Number</label>
                                <div class="flex gap-2">
                                    <input type="text" 
                                           id="referenceNumber" 
                                           name="referenceNumber" 
                                           placeholder="Enter your payment reference number"
                                           class="flex-1 rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary">
                                    <button onclick="checkManualReference()" 
                                            class="px-4 py-2 bg-black text-white rounded-md text-sm font-medium hover:bg-gray-800">
                                        Verify
                                    </button>
                                </div>
                                <p class="text-sm text-gray-500 mt-1">If you already have a reference number, enter it here to verify your payment</p>
                            </div>

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
                                if (!formData.seniorPwdId || !formData.seniorPwdName || !formData.seniorPwdIdPhoto) {
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
                            const name = document.getElementById('seniorPwdName').value;
                            const id = document.getElementById('seniorPwdId').value;
                            const photo = document.getElementById('seniorPwdIdPhoto').files[0];

                            if (name && id && photo) {
                                formData.seniorPwdName = name;
                                formData.seniorPwdId = id;
                                formData.seniorPwdIdPhoto = photo;
                                formData.appliedDiscount = 0.20;
                                formData.discountType = 'senior_pwd';
                                
                                // Show success message
                                const statusEl = document.getElementById('discountStatus');
                                statusEl.textContent = 'Discount applied successfully!';
                                statusEl.classList.remove('hidden');
                                
                                // Close modal
                                closeDiscountModal();
                                
                                // Update price
                                updatePriceBreakdown();
                            } else {
                                alert('Please fill in all required fields');
                            }
                        }

                        document.getElementById('seniorPwdId').addEventListener('change', function(e) {
                            formData.seniorPwdId = e.target.value;
                        });

                        document.getElementById('seniorPwdName').addEventListener('change', function(e) {
                            formData.seniorPwdName = e.target.value;
                        });

                        document.getElementById('seniorPwdIdPhoto').addEventListener('change', function(e) {
                            const file = e.target.files[0];
                            if (file) {
                                formData.seniorPwdIdPhoto = file;
                            }
                        });

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
                    
                    // Reset payment status
                    document.getElementById('paymentStatus').textContent = 'Waiting for payment...';
                    document.getElementById('paymentStatus').classList.remove('text-green-600', 'text-red-600');
                    document.getElementById('paymentProgress').style.width = '0%';
                    document.getElementById('loadingIndicator').classList.add('animate-pulse');
                    
                    // Show modal
                    const modal = document.getElementById('qrModal');
                    modal.classList.remove('hidden');
                    modal.classList.add('flex');
                    
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
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            
            // Reset payment status
            document.getElementById('paymentStatus').textContent = 'Waiting for payment...';
            document.getElementById('paymentProgress').style.width = '0%';
            document.getElementById('loadingIndicator').classList.add('animate-pulse');
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
            const modalContent = document.querySelector('#qrModal > div');
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
    </script>

    <div id="qrModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50" onclick="handleModalClick(event)">
        <div class="bg-white rounded-lg p-8 max-w-md w-full mx-4">
            <div class="flex justify-between items-center mb-6">
                <h4 class="text-lg font-semibold">Scan QR Code to Pay</h4>
                <button onclick="closeQrModal()" class="text-gray-500 hover:text-gray-700">
                    <i class="lucide-x h-6 w-6"></i>
                </button>
            </div>
            <div class="text-center">
                <div class="bg-gray-100 p-8 rounded-lg mb-6">
                    <img id="qrCodeImage" src="" alt="Payment QR Code" class="mx-auto mb-4">
                    <p class="text-sm text-gray-600 mb-2">Total Amount: ₱<span id="qrPaymentAmount">0</span></p>
                    <p class="text-sm text-gray-600">Scan this QR code using your <span id="selectedPaymentMethod"></span> app</p>
                </div>
                <div class="flex justify-center gap-4 mb-6">
                    <button id="openAppButton" onclick="openPaymentApp()" 
                            class="flex items-center px-4 py-2 bg-black text-white rounded-md text-sm font-medium hover:bg-gray-800">
                        <i class="lucide-smartphone h-5 w-5 mr-2"></i>
                        Open <span id="appName"></span> App
                    </button>
                    <button onclick="copyPaymentDetails()" 
                            class="flex items-center px-4 py-2 border border-gray-300 rounded-md text-sm font-medium hover:bg-gray-50">
                        <i class="lucide-copy h-5 w-5 mr-2"></i>
                        Copy Details
                    </button>
                </div>
                <div class="mt-4">
                    <p class="text-sm text-gray-600 mb-2">Payment Status: <span id="paymentStatus" class="font-medium">Waiting for payment...</span></p>
                    <div class="animate-pulse" id="loadingIndicator">
                        <div class="h-1 w-full bg-gray-200 rounded">
                            <div class="h-1 bg-blue-500 rounded" style="width: 0%" id="paymentProgress"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="discountModal" 
         class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50 transition-opacity duration-300 ease-in-out" 
         onclick="handleDiscountModalClick(event)">
        <div class="bg-white rounded-lg p-8 max-w-md w-full mx-4 transform transition-all duration-300 ease-in-out scale-95 opacity-0"
             id="discountModalContent">
            <div class="flex justify-between items-center mb-8">
                <div>
                    <h4 class="text-xl font-semibold text-gray-900">Senior Citizen / PWD Details</h4>
                    <p class="text-sm text-gray-500 mt-1">Please provide the required information to apply the discount</p>
                </div>
                <button onclick="closeDiscountModal()" 
                        class="text-gray-400 hover:text-gray-600 transition-colors duration-200">
                    <i class="lucide-x h-6 w-6"></i>
                </button>
            </div>
            <div class="space-y-6">
                <div class="transition-all duration-200 ease-in-out transform hover:translate-x-1">
                    <label class="block text-sm font-medium text-gray-700 mb-2">ID Holder's Full Name</label>
                    <input type="text" 
                           id="seniorPwdName" 
                           name="seniorPwdName" 
                           placeholder="Enter the name as shown on the ID"
                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary h-10 px-4">
                </div>
                <div class="transition-all duration-200 ease-in-out transform hover:translate-x-1">
                    <label class="block text-sm font-medium text-gray-700 mb-2">ID Number</label>
                    <input type="text" 
                           id="seniorPwdId" 
                           name="seniorPwdId" 
                           placeholder="Enter Senior Citizen/PWD ID Number"
                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary h-10 px-4">
                </div>
                <div class="transition-all duration-200 ease-in-out transform hover:translate-x-1">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Upload ID Photo</label>
                    <div class="relative">
                        <input type="file" 
                               id="seniorPwdIdPhoto" 
                               name="seniorPwdIdPhoto" 
                               accept="image/*"
                               class="hidden"
                               onchange="updateFileLabel(this)">
                        <label for="seniorPwdIdPhoto" 
                               class="flex items-center justify-center w-full h-10 px-4 border border-gray-300 rounded-md cursor-pointer hover:border-primary transition-colors duration-200 group">
                            <i class="lucide-upload h-5 w-5 text-gray-400 group-hover:text-primary transition-colors duration-200 mr-2"></i>
                            <span id="fileLabel" class="text-sm text-gray-500 group-hover:text-primary transition-colors duration-200">
                                Click to upload ID photo
                            </span>
                        </label>
                    </div>
                    <p class="text-xs text-gray-500 mt-2">Please upload a clear photo of the valid ID (Max 5MB)</p>
                </div>
                <div class="mt-8">
                    <button onclick="applyDiscount()" 
                            class="w-full h-10 bg-black text-white rounded-md text-sm font-medium 
                                   hover:bg-gray-800 transform transition-all duration-200 ease-in-out 
                                   hover:scale-[1.02] active:scale-[0.98] disabled:opacity-50 disabled:cursor-not-allowed"
                            id="applyDiscountBtn">
                        Apply Discount
                    </button>
                </div>
            </div>
        </div>
    </div>
</body>

</html>