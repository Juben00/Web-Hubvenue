
const authModal = document.getElementById('authModal');
const closeModal = document.getElementById('closeModal');
const loginTab = document.getElementById('loginTab');
const signupTab = document.getElementById('signupTab');
const loginForm = document.getElementById('loginForm');
const signupForm = document.getElementById('signupForm');
const tabUnderline = document.getElementById('tabUnderline');

const signInButtons = document.querySelectorAll('button[onclick="openSignInUp()"]');

// Function to open modal with smooth transition
function openSignInUp() {
    authModal.style.display = 'flex';
    authModal.style.opacity = '0';
    setTimeout(() => {
        authModal.style.opacity = '1';
    }, 10);
    document.body.style.overflow = 'hidden';
}

// Function to close modal with smooth transition
function closeModalFunc() {
    authModal.style.opacity = '0';
    setTimeout(() => {
        authModal.style.display = 'none';
    }, 300);
    document.body.style.overflow = 'auto';
}

// Add click event listeners to all sign in buttons
signInButtons.forEach(button => {
    button.addEventListener('click', openSignInUp);
});

// Close modal when clicking close button
closeModal.addEventListener('click', closeModalFunc);

// Tab switching functionality
loginTab.addEventListener('click', () => {
    switchTab(loginTab, signupTab, loginForm, signupForm);
});

signupTab.addEventListener('click', () => {
    switchTab(signupTab, loginTab, signupForm, loginForm);
});

function switchTab(activeTab, inactiveTab, activeForm, inactiveForm) {
    activeTab.classList.add('text-blue-500');
    activeTab.classList.remove('text-gray-500');
    inactiveTab.classList.remove('text-blue-500');
    inactiveTab.classList.add('text-gray-500');

    // Move the tab underline
    if (activeTab === loginTab) {
        tabUnderline.style.left = '0';
    } else {
        tabUnderline.style.left = '50%';
    }

    // Fade out the current form
    activeForm.classList.add('opacity-0');
    inactiveForm.classList.add('opacity-0');

    setTimeout(() => {
        activeForm.classList.add('hidden');
        inactiveForm.classList.add('hidden');

        // Show and fade in the new form
        activeForm.classList.remove('hidden');
        setTimeout(() => {
            activeForm.classList.remove('opacity-0');
        }, 50);
    }, 300);
}

// Ensure the DOM is fully loaded before attaching event listeners

document.addEventListener('DOMContentLoaded', (event) => {
    // Reattach event listeners to make sure they work
    closeModal.addEventListener('click', closeModalFunc);
    loginTab.addEventListener('click', () => switchTab(loginTab, signupTab, loginForm, signupForm));
    signupTab.addEventListener('click', () => switchTab(signupTab, loginTab, signupForm, loginForm));

    // Get the password recovery form and back button
    const passRecoveryForm = document.getElementById('passRecoveryForm');
    const backToLogin = document.getElementById('backToLogin');
    const forgotPasswordLink = document.querySelector('a[href="#forgotPassLink"]'); // Assuming only one "Forgot password?" link

    // Show password recovery form and hide login tabs
    forgotPasswordLink.addEventListener('click', (event) => {
    event.preventDefault(); // Prevent default link behavior
    loginTabs.classList.add('hidden'); // Hide login tabs
    loginForm.classList.add('hidden'); // Hide login form
    passRecoveryForm.classList.remove('hidden'); // Show password recovery form
    });

    // Back to login functionality
    backToLogin.addEventListener('click', () => {
    passRecoveryForm.classList.add('hidden'); // Hide password recovery form
    loginTabs.classList.remove('hidden'); // Show login tabs
    loginForm.classList.remove('hidden'); // Show login form
    });
});
