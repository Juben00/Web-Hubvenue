document.addEventListener('DOMContentLoaded', function() {
    const stickySearch = document.getElementById('stickySearch');
    const firstSection = document.getElementById('first-section');
    
    window.addEventListener('scroll', function() {
        // Get the bottom position of the first section
        const firstSectionBottom = firstSection.offsetTop + firstSection.offsetHeight;
        
        // Check if we've scrolled past the first section
        if (window.scrollY > firstSectionBottom) {
            stickySearch.classList.remove('hidden', '-translate-y-full');
            stickySearch.classList.add('translate-y-0');
        } else {
            stickySearch.classList.add('-translate-y-full');
            stickySearch.classList.remove('translate-y-0');
            
            // Add hidden class after transition
            setTimeout(() => {
                if (window.scrollY <= firstSectionBottom) {
                    stickySearch.classList.add('hidden');
                }
            }, 300);
        }
    });
    
    // Sync the sticky search with the main search
    const mainGuestsInput = document.getElementById('guests');
    const stickyGuestsInput = document.getElementById('stickyGuests');
    const mainCheckInText = document.getElementById('checkInText');
    const stickyCheckInText = document.getElementById('stickyCheckInText');
    const mainCheckOutText = document.getElementById('checkOutText');
    const stickyCheckOutText = document.getElementById('stickyCheckOutText');
    
    // Function to sync inputs
    function syncInputs(source, target) {
        target.value = source.value;
    }
    
    // Sync guests
    mainGuestsInput.addEventListener('input', () => syncInputs(mainGuestsInput, stickyGuestsInput));
    stickyGuestsInput.addEventListener('input', () => syncInputs(stickyGuestsInput, mainGuestsInput));
    
    // Sync dates
    function syncDates() {
        stickyCheckInText.textContent = mainCheckInText.textContent;
        stickyCheckOutText.textContent = mainCheckOutText.textContent;
    }
    
    // Add observers for date changes
    new MutationObserver(syncDates).observe(mainCheckInText, { childList: true });
    new MutationObserver(syncDates).observe(mainCheckOutText, { childList: true });
}); 