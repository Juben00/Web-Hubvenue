$(document).ready(function() {
    // Initially load the all reservations view
    loadView('all-reservations');

    // Handle tab clicks
    $('.tab-button').click(function() {
        // Remove active class from all tabs
        $('.tab-button').removeClass('bg-red-600 text-white');
        // Add active class to clicked tab
        $(this).addClass('bg-red-600 text-white');
        
        // Load the corresponding view
        loadView($(this).attr('id'));
    });

    function loadView(viewId) {
        let viewUrl;
        switch(viewId) {
            case 'all-reservations':
                viewUrl = '../reservation-management/all-reservations.php';
                break;
            case 'approved-reservations':
                viewUrl = '../reservation-management/approved-reservations.php';
                break;
            case 'cancelled-reservations':
                viewUrl = '../reservation-management/cancelled-reservations.php';
                break;
            case 'rejected-reservations':
                viewUrl = '../reservation-management/rejected-reservations.php';
                break;
        }
        
        if (viewUrl) {
            $('#reservation-management-view').load(viewUrl, function(response, status, xhr) {
                if (status == "error") {
                    console.log("Error loading content:", xhr.status, xhr.statusText);
                }
            });
        }
    }
});