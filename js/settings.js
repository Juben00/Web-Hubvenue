$(document).ready(function() {
    // Tab switching functionality
    $('.settings-tab').click(function() {
        const tabId = $(this).data('tab');
        
        // Update active tab styling
        $('.settings-tab').removeClass('active');
        $(this).addClass('active');
        
        // Show corresponding content
        $('.settings-content').hide();
        $(`#${tabId}-settings`).show();
    });

    // Handle account form submission
    $('#account-form').submit(function(e) {
        e.preventDefault();
        
        $.ajax({
            url: '../ajax/update_account.php',
            method: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                if (response.success) {
                    alert('Account details updated successfully');
                } else {
                    alert('Error updating account details: ' + response.message);
                }
            },
            error: function() {
                alert('An error occurred while updating account details');
            }
        });
    });

    // Handle password form submission
    $('#password-form').submit(function(e) {
        e.preventDefault();
        
        $.ajax({
            url: '../ajax/update_password.php',
            method: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                if (response.success) {
                    alert('Password updated successfully');
                    $('#password-form')[0].reset();
                } else {
                    alert('Error updating password: ' + response.message);
                }
            },
            error: function() {
                alert('An error occurred while updating password');
            }
        });
    });
}); 