$(document).ready(function () {

    console.log("User jQuery loaded");
    
    // signup terms and conditions checker
    const signupAgreeTerms = $("#agreeTerms");
    const signupButton = $("#signupSubmit");

    if (signupAgreeTerms.length) {
        // Initial check on page load
        signupButton.prop("disabled", !signupAgreeTerms.is(":checked"));

        // Add a click event listener
        signupAgreeTerms.on("click", function () {
            signupButton.prop("disabled", !$(this).is(":checked"));
        });
    }

    //bookmark btn
    $(document).on('click', '#bookmarkBtn', function (e) {
        e.preventDefault();
        const btn = $(this);
        const venueId = btn.data('venueid');
        const userId = btn.data('userid');

        // Add animation class
        btn.addClass('animate');
        
        // Toggle bookmarked class immediately for instant feedback
        btn.toggleClass('bookmarked');
        
        // Remove animation class after animation completes
        setTimeout(() => {
            btn.removeClass('animate');
        }, 800);
        
        // Call the bookmarkVenue function
        bookmarkVenue(venueId, userId);
    });


    $('#HubvenueLogo').on('click', function (e) {
        e.preventDefault();
        window.location.href = "index.php";
    })

    // login form
    $('#loginForm').on("submit", function (e) {
        e.preventDefault();
        const formElement = $(this);
        login(formElement);
    });

    // signup form
    $('#signupForm').on("submit", function (e) {
        e.preventDefault();
        const formElement = $(this);
        signup(formElement);
    });

    // payment form
    $('#paymentForm').on("submit", function (e) {
        e.preventDefault();
        const formElement = $(this);
        book(formElement);
    });

    //logout button
    $('#logoutBtn').on('click', function (e) {
        e.preventDefault();
        logout();
    });

    //menu trigger buttons open
    $("#menutabtrigger").on("click", function (e) {
        e.preventDefault();
        $("#menutab").toggleClass("hidden");
    });

    //menu trigger buttons close
    $('#menutab').on("dblclick", function (e) {
        e.preventDefault();
        $("#menutab").toggleClass("hidden");
    });

    //map trigger buttons open
    // $("#maps-button").on("click", function (e) {
    //     e.preventDefault();
    //     viewOpenStreetMap();  // Open the map for user interaction
    // });

    $(document).on('click', '#maps-button', function (e) {
        e.preventDefault();
        viewOpenStreetMap();  // Open the map for user interaction
    });
    //add venue trigger button
    $('#add-venue-form').on("submit", function (e) {
        e.preventDefault();
        addVenue();
    });

    $('.venueCard').on("click", function () {
        let isLogged = $(this).data("isloggedin"); 
        let venueUrl = $(this).data("id");
        
        if (isLogged === true) {  
            viewVenue(venueUrl);
        } else {
            showModal("Please login to view the venue", undefined, "black_ico.png");
        }
    });

    //profile navigation
    $('.profileNav').on('click', function (e) {
        e.preventDefault();
        let url = $(this).attr("data-profileUrl");
        
        $('.profileNav').removeClass('active');
        $(this).addClass('active');
    
        openProfileNav(url);
        
        
    })

    //profile button
    $(document).on('click', '#profileBtn', function (e) {
        e.preventDefault();
        const url = $(this).data("url");
        menuRedirection(url);
        openProfileNav('rent-history');
    });

    //host account button
    $(document).on('click', '#hostAccountBtn', function (e) {
        e.preventDefault();
        const url = $(this).data("url");
        menuRedirection(url);
    });

    //settings button
    $(document).on('click', '#settingsBtn', function (e) {
        e.preventDefault();
        const url = $(this).data("url");
        menuRedirection(url);
    });

    //help-center
    $(document).on('click', "#helpCenterBtn", function (e) {
        e.preventDefault();
        const url = $(this).data("url");
        menuRedirection(url);
    })
    
    //notifications
    $(document).on('click', "#notificationsBtn", function (e) {
        e.preventDefault();
        const url = $(this).data("url");
        menuRedirection(url);
    })

    //host application button
    $('#hostApplicationForm').on("submit", function (e) {
        e.preventDefault();
        const formElement = $(this);
        hostApplication(formElement);
    });  

    //reservation form
  $('#reservationForm').on('submit', function (e) {
    const numberOfGuests = $('#numberOFGuest').val(); // Get the value of the input
    const checkInDate = $('#checkin').val(); // Get the value of the input
    const checkOutDate = $('#checkout').val(); // Get the value of the input
    if (numberOfGuests < 1) { // Check if the value is less than 1
        e.preventDefault(); // Prevent form submission
        showModal('Please enter a valid number of guests', undefined, "black_ico.png");
    }
    if (!checkInDate || !checkOutDate) { // Check if either date is empty
        e.preventDefault(); // Prevent form submission        
        showModal('Please select both check-in and check-out dates.', undefined, "black_ico.png");
        return;
    }

    // Convert to Date objects for comparison
    const checkIn = new Date(checkInDate);
    const checkOut = new Date(checkOutDate);

    if (checkIn >= checkOut) { // Check if the check-in date is not before the check-out date
        e.preventDefault(); // Prevent form submission
        showModal('Check-in date must be before the check-out date.', undefined, "black_ico.png");
        return;
    }
    // Populate a hidden form with the calculated data
                   
});

    // Update user info form submission
    $('#updateUserInfoForm').on('submit', function (e) {
        e.preventDefault();
        const formElement = $(this);
        updateUserInfo(formElement);
    });

    // Change password form submission
    $('#updatePasswordForm').on('submit', function (e) {
        e.preventDefault();
        const formElement = $(this);
        updatePassword(formElement);
    }); 

    //mandatory discount form submission
    $('#discountApplicationForm').on('submit', function (e) {
        e.preventDefault();
        const formElement = $(this);
        mandatoryDiscount(formElement);
    });

    function viewOpenStreetMap(){
    $.ajax({
        type: "GET",
        url: "./openStreetMap/userOpenStreetMap.html",
        dataType: "html",
        success: function (response) {
          $("#openstreetmapplaceholder").html(response);

          $('#openStreetMapDiv').addClass('fixed');
        },
    })
    }

    function login(formElement) {
        let form = new FormData(formElement[0]);
        $.ajax({
            type: "POST",
            url: "./api/Login.api.php",
            data: form,
            processData: false,  // prevent jQuery from processing the FormData
            contentType: false,  // prevent jQuery from setting the content type
            success: function (response) {
                response = JSON.parse(response);
                if (response.status === "success") {
                    showModal(response.message, function () {
                        formElement[0].reset();
                        $('#authModal').addClass("hidden");
                        window.location.reload();
                    }, "black_ico.png");
                } else {
                    showModal(response.message, undefined, "black_ico.png");
                }
            },
        });
    }

    function signup(formElement) {
        let form = new FormData(formElement[0]);
        $.ajax({
            type: "POST",
            url: "./api/Signup.api.php",
            data: form,
            processData: false,  
            contentType: false, 
            success: function (response) {
                response = JSON.parse(response);
                console.log(response);
                
                if (response.status === "success") {
                    showModal(response.message, function () {
                        formElement[0].reset();
                        $('#authModal').addClass("hidden");
                        $('#loginTab').click();
                    }, "black_ico.png");
                } else {
                    showModal(response.message, undefined, "black_ico.png");
                }
            },
            });
    }

    

    function viewVenue(url) {
        window.location.href = url;
    }

    function menuRedirection(url){
        window.location.href = url;
    }

    function hostApplication(formElement) {
        let form = new FormData(formElement[0]);
        $.ajax({
            type: "POST",
            url: "./api/HostApplication.api.php",
            data: form,
            processData: false,
            contentType: false,
            success: function (response) {
                response = JSON.parse(response);
                if (response.status === "success") {
                    formElement[0].reset();
                    showModal(response.message, function () {
                        $("#hostAccountBtn").click();
                    }, "black_ico.png");
                } else {
                    showModal(response.message, undefined, "black_ico.png");
                }
            }
            });
    }

    function logout(){
        confirmshowModal('Are you sure you want to log out?', function () {
            window.location.href = "./logout.php";
        }, 'black_ico.png');
    }

    function openProfileNav(url) {
        $.ajax(
            {
                type: "GET",
                url: './profile/' + url + '.php',
                success: function (response) {
                    $('#profileDisplay').html(response);

                    //view listing
                    $('.venue-card').on('click', function (e) {
                        e.preventDefault();
                        const url = $(this).data("id");

                        //set the url to the id of the venue
                        $.ajax({
                            type: "GET",
                            url: "./profile/view-listing.php?id=" + url,
                            data: {
                                id: url
                            },
                            success: function (response) {
                                $('#profileDisplay').html(response);
                            }
                        });

                        // viewListing(url);
                    });

                    //view bookmarks
                    $('.venueCard').on("click", function () {
                        let isLogged = $(this).data("isloggedin"); 
                        let venueUrl = $(this).data("id");
                        
                        if (isLogged === true) {  
                            viewVenue(venueUrl);
                        } else {
                            showModal("Please login to view the venue", undefined, "black_ico.png");
                        }
                    });

                    //add venue button
                    $('#addVenueButton').on('click',  function (e) {
                        e.preventDefault();
                        window.location.href = './list-your-venue.php';
                    });

                   $('#bookAgainBtn').on('click', function (e) {
                        e.preventDefault();
                        const venueId = $(this).data("bvid");
                        window.location.href = './venues.php?id=' + venueId; // Uncomment if you want to navigate
                    });

                    $('#reviewForm').on('submit', function (e) {
                        e.preventDefault();
                        const formElement = $(this);
                        addReview(formElement);
                    });

                    $('#cancellation-form').on('submit', function (e) {
                        e.preventDefault();
                        const formElement = $(this);
                        cancelBooking(formElement);
                    });
                    
                }
            }
        )
    }
    
    // function viewListing(url) {
    //     $.ajax({
    //         type: "GET",
    //         url: "./profile/view-listing.php?id=" + url,
    //         data: {
    //             id: url
    //         },
    //         success: function (response) {
    //             $('#profileDisplay').html(response);
    //         }
    //     });
    // }

    function addReview(formElement) {
        let form = new FormData(formElement[0]);
        $.ajax({
            type: "POST",
            url: "./api/AddReview.api.php",
            data: form,
            processData: false,
            contentType: false,
            success: function (response) {
                response = JSON.parse(response);
                if (response.status === "success") {
                    showModal(response.message, undefined, "black_ico.png");
                    openProfileNav('rent-history');
                } else {
                    showModal(response.message, undefined, "black_ico.png");
                }
                },
            });
    }


    function addVenue(){
    let form = new FormData($("#add-venue-form")[0]);
    $.ajax({
        type: "POST",
        url: "./api/hostAddVenue.api.php",
        data: form,
        dataType: "json",
        contentType: false,
        processData: false,
        success: function (response) {
            if (response.status === "success") {
                showModal(
                    "Venue added successfully",
                    function () {
                        $("#add-venue-form")[0].reset();
                        window.location.href = "./profile.php";
                    },
                    "black_ico.png"
                );
            } else {
                showModal(
                    "Venue not added",
                    undefined,
                    "black_ico.png"
                );
            }
        },
    });
    }

    function bookmarkVenue(venueId, userId, buttonElement) {
        console.log(`Venue ID: ${venueId}, User ID: ${userId}`); // Debugging
        $.ajax({
            type: "POST",
            url: "./api/Bookmark.api.php",
            data: {
                userId: userId,
                venueId: venueId,
            },
            success: function (response) {
                console.log(response); // Log response for debugging
                response = JSON.parse(response);

                if (response.status === "success") {
                    if (response.action === "bookmarked") {
                        $(buttonElement).removeClass("text-white").addClass("text-red-500");
                    } else if (response.action === "unbookmarked") {
                        $(buttonElement).removeClass("text-red-500").addClass("text-white");
                    }
                    // showModal(response.message, undefined, "black_ico.png");
                } else {
                    showModal(response.message, undefined, "black_ico.png");
                }
            },
            error: function (xhr, status, error) {
                console.error(`Error: ${error}`); // Log AJAX error
            },
        });
    }

    function book(formElement){
        let form = new FormData(formElement[0]);
        $.ajax({
            type: "POST",
            url: "./api/AddBooking.api.php",
            data: form,
            processData: false,  
            contentType: false, 
            success: function (response) {
                response = JSON.parse(response);
                if (response.status === "success") {
                    showModal(response.message, function () {
                        formElement[0].reset();
                        window.location.href = "./index.php";
                    }, "black_ico.png");
                } else {
                    showModal(response.message, undefined, "black_ico.png");
                }
            },
        });
    } 

    function updateUserInfo(formElement) {
        let form = new FormData(formElement[0]);
        $.ajax({
            type: "POST",
            url: "./api/UpdateUserInfo.api.php",
            data: form,
            processData: false,
            contentType: false,
            success: function (response) {
                response = JSON.parse(response);
                if (response.status === "success") {
                    showModal(response.message, undefined, "black_ico.png");
                } else {
                    showModal(response.message, undefined, "black_ico.png");
                }
            },
        });
    }

   function updatePassword(formElement) {
    let form = new FormData(formElement[0]);
    $.ajax({
        type: "POST",
        url: "./api/UserChangePass.api.php",
        data: form,
        processData: false,
        contentType: false,
        success: function (response) {
            let res = JSON.parse(response); // Parse the response if it's not automatically parsed
            if (res.status === "success") {
                showModal(res.message, function(){
                    formElement[0].reset();
                }, "black_ico.png");
            } else {
                showModal(res.message, undefined, "black_ico.png");
            }
        }
    });
}

    function mandatoryDiscount(formElement) {
        let form = new FormData(formElement[0]);
        $.ajax({
            type: "POST",
            url: "./api/DiscountApplication.api.php",
            data: form,
            processData: false,
            contentType: false,
            success: function (response) {
                let res = JSON.parse(response); // Parse the response if it's not automatically parsed
                if (res.status === "success") {
                    showModal(res.message, function(){
                        formElement[0].reset();
                        menuRedirection("./settings.php");
                    }, "black_ico.png");
                } else {
                    showModal(res.message, undefined, "black_ico.png");
                }
            },


     
            
    });

    
}

    function cancelBooking(formElement){
        let form = new FormData(formElement[0]);
        $.ajax({
            type: "POST",
            url: "./api/CancelBooking.api.php",
            data: form,
            processData: false,
            contentType: false,
            success: function (response) {
                let res = JSON.parse(response); // Parse the response if it's not automatically parsed
                if (res.status === "success") {
                    showModal(res.message, function(){
                        formElement[0].reset();
                        window.location.reload();
                    }, "black_ico.png");
                } else {
                    showModal(res.message, undefined, "black_ico.png");
                }
            }
        });

    }
    // setting default view for profile
    openProfileNav('rent-history');

});