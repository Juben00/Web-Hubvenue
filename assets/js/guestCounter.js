document.addEventListener('DOMContentLoaded', function() {
    const guestsInput = document.getElementById('guests');
    const guestDropdown = document.getElementById('guestDropdown');
    
    // Toggle dropdown
    guestsInput.addEventListener('click', function() {
        guestDropdown.classList.toggle('hidden');
    });

    // Close dropdown when clicking outside
    document.addEventListener('click', function(event) {
        if (!guestsInput.contains(event.target) && !guestDropdown.contains(event.target)) {
            guestDropdown.classList.add('hidden');
        }
    });

    // Handle guest counter buttons
    const minusButtons = document.querySelectorAll('.guest-minus');
    const plusButtons = document.querySelectorAll('.guest-plus');
    
    minusButtons.forEach(button => {
        button.addEventListener('click', function() {
            const countElement = this.parentElement.querySelector('.guest-count');
            let count = parseInt(countElement.textContent);
            if (count > 0) {
                countElement.textContent = count - 1;
                updateGuestCount();
            }
        });
    });

    plusButtons.forEach(button => {
        button.addEventListener('click', function() {
            const countElement = this.parentElement.querySelector('.guest-count');
            let count = parseInt(countElement.textContent);
            countElement.textContent = count + 1;
            updateGuestCount();
        });
    });

    function updateGuestCount() {
        const counts = document.querySelectorAll('.guest-count');
        let total = 0;
        let guestText = [];
        
        counts.forEach((count, index) => {
            const value = parseInt(count.textContent);
            if (value > 0) {
                total += value;
                const type = ['adult', 'child', 'infant', 'pet'][index];
                guestText.push(`${value} ${type}${value > 1 ? 's' : ''}`);
            }
        });

        guestsInput.value = total > 0 ? guestText.join(', ') : '';
    }
}); 