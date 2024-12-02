<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cancel Your Booking</title>
    <link rel="icon" href="./images/black_ico.png">
    <link rel="stylesheet" href="./output.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/luxon@3.3.0/build/global/luxon.min.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        .top-bar {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
            background-color: white;
            border-bottom: none;
        }

        .progress-bar {
            height: 4px;
            background-color: #dddddd;
        }

        .progress {
            height: 100%;
            background-color: #000000;
            transition: width 0.3s ease;
        }

        /* Add padding to account for fixed topbar */
        .container {
            padding-top: 80px;
        }
    </style>
</head>

<body class="bg-gray-50">
    <?php
    session_start();

    if (isset($_SESSION['user'])) {
        if ($_SESSION['user']['user_type_id'] == 3) {
            header('Location: admin/');
        }
    }
    ?>

    <div class="top-bar">
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
    </div>

    <div class="container mx-auto px-4 py-8 pt-32 max-w-4xl">
        <h1 class="text-3xl font-bold mb-8">Cancel Your Booking</h1>

        <div class="bg-slate-50 rounded-lg shadow-md p-6 mb-8">
            <div class="flex justify-between mb-4">
                <h2 class="text-xl font-semibold">Booking Summary</h2>
                <span class="text-sm text-gray-500">Step <span id="current-step">1</span> of 4</span>
            </div>
            <div class="flex flex-col md:flex-row">
                <img src="/placeholder.svg?height=200&width=300" alt="Property Image"
                    class="w-full md:w-1/3 rounded-lg mb-4 md:mb-0 md:mr-6">
                <div>
                    <h3 class="text-lg font-semibold mb-2">Cozy Mountain Retreat</h3>
                    <p class="text-gray-600 mb-2">Santa Cruz, California, United States</p>
                    <p class="mb-2"><span class="font-semibold">Check-in:</span> June 15, 2023</p>
                    <p class="mb-2"><span class="font-semibold">Check-out:</span> June 20, 2023</p>
                    <p><span class="font-semibold">Guests:</span> 2 adults</p>
                </div>
            </div>
        </div>

        <form id="cancellation-form" class="space-y-8">
            <div id="step-1" class="bg-slate-50 rounded-lg shadow-md p-6">
                <h2 class="text-xl font-semibold mb-4">Step 1: Select Cancellation Option</h2>
                <div class="space-y-4">
                    <div class="flex items-center">
                        <input type="radio" id="cancel-full-refund" name="cancellation-option" value="full-refund"
                            class="mr-3" required>
                        <label for="cancel-full-refund">
                            <span class="font-semibold">Cancel now for a full refund</span>
                            <p class="text-sm text-gray-600">Cancel before June 8, 2023 for a full refund of $750</p>
                        </label>
                    </div>
                    <div class="flex items-center">
                        <input type="radio" id="cancel-partial-refund" name="cancellation-option" value="partial-refund"
                            class="mr-3">
                        <label for="cancel-partial-refund">
                            <span class="font-semibold">Cancel with a partial refund</span>
                            <p class="text-sm text-gray-600">Cancel between June 8 and June 14, 2023 for a 50% refund of
                                $375</p>
                        </label>
                    </div>
                    <div class="flex items-center">
                        <input type="radio" id="cancel-no-refund" name="cancellation-option" value="no-refund"
                            class="mr-3">
                        <label for="cancel-no-refund">
                            <span class="font-semibold">Cancel with no refund</span>
                            <p class="text-sm text-gray-600">Cancel on or after June 15, 2023 for no refund</p>
                        </label>
                    </div>
                </div>
            </div>

            <div id="step-2" class="bg-slate-50 rounded-lg shadow-md p-6 hidden">
                <h2 class="text-xl font-semibold mb-4">Step 2: Reason for Cancellation</h2>
                <select id="cancellation-reason" name="cancellation-reason"
                    class="w-full p-2 border border-gray-300 rounded-md mb-4" required>
                    <option value="">Select a reason</option>
                    <option value="change-of-plans">Change of plans</option>
                    <option value="found-better-option">Found a better option</option>
                    <option value="emergency">Emergency</option>
                    <option value="other">Other</option>
                </select>
                <textarea id="cancellation-details" name="cancellation-details"
                    class="w-full p-2 border border-gray-300 rounded-md" rows="4"
                    placeholder="Please provide more details about your cancellation (optional)"></textarea>
            </div>

            <div id="step-3" class="bg-slate-50 rounded-lg shadow-md p-6 hidden">
                <h2 class="text-xl font-semibold mb-4">Step 3: Review Cancellation</h2>
                <div id="review-content" class="space-y-4">
                    <!-- Content will be dynamically populated -->
                </div>
            </div>

            <div id="step-4" class="bg-slate-50 rounded-lg shadow-md p-6 hidden">
                <h2 class="text-xl font-semibold mb-4">Step 4: Confirm Cancellation</h2>
                <p class="mb-4">By clicking the button below, you agree to cancel your booking according to the selected
                    option.</p>
                <div class="flex items-center mb-4">
                    <input type="checkbox" id="confirm-checkbox" name="confirm-checkbox" class="mr-2" required>
                    <label for="confirm-checkbox">I understand that this action cannot be undone</label>
                </div>
            </div>

            <div class="fixed bottom-0 left-0 right-0 bg-slate-50 border-t">
                <div class="container mx-auto px-4 py-4 flex justify-between items-center">
                    <button onclick="prevStep()" class="text-black font-semibold hover:underline">Back</button>
                    <div class="progress-bar w-1/3">
                        <div id="progress" class="progress" style="width: 25%;"></div>
                    </div>
                    <button onclick="nextStep()"
                        class="bg-black text-white px-6 py-3 rounded-lg hover:bg-gray-800">Next</button>
                </div>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const form = document.getElementById('cancellation-form');
            const steps = ['step-1', 'step-2', 'step-3', 'step-4'];
            let currentStep = 0;

            const currentStepIndicator = document.getElementById('current-step');

            function updateStep() {
                steps.forEach((step, index) => {
                    const stepElement = document.getElementById(step);
                    if (index === currentStep) {
                        stepElement.classList.remove('hidden');
                    } else {
                        stepElement.classList.add('hidden');
                    }
                });

                currentStepIndicator.textContent = currentStep + 1;

                const progressBar = document.getElementById('progress');
                const progressPercentage = ((currentStep + 1) / steps.length) * 100;
                progressBar.style.width = `${progressPercentage}%`;

                const backButton = document.querySelector('.bottom-0 button:first-child');
                const nextButton = document.querySelector('.bottom-0 button:last-child');

                backButton.style.visibility = currentStep === 0 ? 'hidden' : 'visible';

                if (currentStep === steps.length - 1) {
                    nextButton.textContent = 'Confirm Cancellation';
                    nextButton.classList.add('bg-red-600', 'hover:bg-red-700');
                } else {
                    nextButton.textContent = 'Next';
                    nextButton.classList.remove('bg-red-600', 'hover:bg-red-700');
                }
            }

            function validateStep() {
                switch (currentStep) {
                    case 0:
                        return document.querySelector('input[name="cancellation-option"]:checked') !== null;
                    case 1:
                        return document.getElementById('cancellation-reason').value !== '';
                    case 2:
                        return true; // Review step is always valid
                    case 3:
                        return document.getElementById('confirm-checkbox').checked;
                    default:
                        return true;
                }
            }

            function updateReviewStep() {
                const reviewContent = document.getElementById('review-content');
                const selectedOption = document.querySelector('input[name="cancellation-option"]:checked');
                const optionLabel = selectedOption.nextElementSibling.querySelector('span').textContent;
                const reason = document.getElementById('cancellation-reason');
                const details = document.getElementById('cancellation-details').value;

                reviewContent.innerHTML = `
                    <div class="space-y-2">
                        <p><strong>Cancellation Option:</strong> ${optionLabel}</p>
                        <p><strong>Reason:</strong> ${reason.options[reason.selectedIndex].text}</p>
                        <p><strong>Additional Details:</strong> ${details || 'None provided'}</p>
                    </div>
                `;
            }

            document.querySelector('.bottom-0 button:last-child').addEventListener('click', function (e) {
                e.preventDefault();
                if (validateStep()) {
                    if (currentStep < steps.length - 1) {
                        currentStep++;
                        if (currentStep === 2) {
                            updateReviewStep();
                        }
                        updateStep();
                    }
                } else {
                    alert('Please fill in all required fields before proceeding.');
                }
            });

            document.querySelector('.bottom-0 button:first-child').addEventListener('click', function (e) {
                e.preventDefault();
                if (currentStep > 0) {
                    currentStep--;
                    updateStep();
                }
            });

            form.addEventListener('submit', async function (e) {
                e.preventDefault();
                if (validateStep()) {
                    try {
                        const formData = new FormData(form);
                        alert('Booking cancelled successfully!');
                        window.location.href = '/profile/rent-history.php';
                    } catch (error) {
                        alert('An error occurred while cancelling your booking. Please try again.');
                        console.error('Error:', error);
                    }
                } else {
                    alert('Please confirm that you understand the cancellation terms.');
                }
            });

            updateStep();

            document.querySelectorAll('input[name="cancellation-option"]').forEach(radio => {
                radio.addEventListener('change', () => {
                    if (currentStep === 0) {
                        document.querySelector('.bottom-0 button:last-child').disabled = !validateStep();
                    }
                });
            });

            document.getElementById('cancellation-reason').addEventListener('change', () => {
                if (currentStep === 1) {
                    document.querySelector('.bottom-0 button:last-child').disabled = !validateStep();
                }
            });
        });
    </script>
</body>

</html>