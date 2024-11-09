$(document).ready(function () {

    // signup terms and conditions checker
    const $signupAgreeTerms = $("#agreeTerms");
    const $signupButton = $("#signupSubmit");

    if ($signupAgreeTerms.length) {
        // Initial check on page load
        $signupButton.prop("disabled", !$signupAgreeTerms.is(":checked"));

        // Add a click event listener
        $signupAgreeTerms.on("click", function () {
            $signupButton.prop("disabled", !$(this).is(":checked"));
        });
    }

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

    // maps
    $("#maps-button").on("click", function (e) {
        e.preventDefault();
        viewOpenStreetMap(); 
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
                    showModal(response.message, "./images/black_ico.png");
                    formElement[0].reset();
                    $('#authModal').addClass("hidden");
                } else {
                    showModal(response.message, "./images/black_ico.png");
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
                    showModal(response.message, "./images/black_ico.png");
                    formElement[0].reset();
                    $('#authModal').addClass("hidden");
                    $('#loginTab').click();
                } else {
                    showModal(response.message, "./images/black_ico.png");
                }
            },
            });
    }


});