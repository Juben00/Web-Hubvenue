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
    $("#maps-button").on("click", function (e) {
        e.preventDefault();
        viewOpenStreetMap();  // Open the map for user interaction
    });

    //add venue trigger button
    $('#add-venue-form').on("submit", function (e) {
        e.preventDefault();
        addVenue();
    });

    $(".venueCard").on("click", function () {
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

    $('#profileBtn').on('click', function (e) {
        const url = $(this).data("url");
        menuRedirection(url);
        openProfileNav('rent-history');
    });
    
    //add venue button
    $(document).on('click', '#addVenueButton', function (e) {
        window.location.href = './list-your-venue.php';
    });

    //host account button
    $("#hostAccountBtn").on("click", function () {
        const url = $(this).data("url");
        menuRedirection(url);
    })

    //host application button
    $('#hostApplicationForm').on("submit", function (e) {
        e.preventDefault();
        const formElement = $(this);
        hostApplication(formElement);
    });



    function viewOpenStreetMap(){
    $.ajax({
        type: "GET",
        url: "./openStreetMap/openStreetMap.html",
        dataType: "html",
        success: function (response) {
          $("#openstreetmapplaceholder").html(response);

          $('#openStreetMapSubmit').on("click", function (e) {
            
                e.preventDefault();
                
                $('#openStreetMapDiv').addClass("hidden"); // Hide the map modal
            });

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
                }
            }
        )
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
            if (response.status == "success") {
                showModal(
                    "Venue added successfully",
                    function () {
                        $("#add-venue-form")[0].reset();
                        window.location.href = "../profile.php";
                    },
                    "black_ico.png"
                );
                
                window.location.href = "./profile.php"
                
                $("#add-venue-form")[0].reset();
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

    // setting default view for profile
    openProfileNav('rent-history');

});