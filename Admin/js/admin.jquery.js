$(document).ready(function () {
  $(".nav-link").on("click", function (e) {
    e.preventDefault();

    // Remove active styles from all nav links and reset to original color
    $(".nav-link")
      .removeClass("bg-red-600 text-white")
      .addClass("text-gray-800");

    // Add active styles to the clicked link
    $(this).addClass("bg-red-600 text-white").removeClass("text-gray-800");

    // Update URL without reloading
    let url = $(this).attr("href");
    window.history.pushState({ path: url }, "", url);
  });


  $("#dashboard-link").on("click", function (e) {
    e.preventDefault();
    viewDashboard();
  });

  $("#venue-management-link").on("click", function (e) {
    e.preventDefault();
    viewVenueManagement();
  });

  $("#reservation-management-link").on("click", function (e) {
    e.preventDefault();
    viewVenueManagement();
  });

  function viewDashboard(){
    $.ajax({
        type: "GET",
        url: "./dashboard/dashboard.php",
        dataType: "html",
        success: function (response) {
          $("#adminView").html(response);
        },
    })
  }

  function viewVenueManagement(){
    $.ajax({
        type: "GET",
        url: "./venue-management/venue-management.php",
        dataType: "html",
        success: function (response) {
          $("#adminView").html(response);

          $("#add-venue-vm").on("click", function (e) {
          e.preventDefault();
          viewVmAddVenue();
          });

          $("#manage-venues-vm").on("click", function (e) {
          e.preventDefault();
          viewVmManageVenue();
          });

          $("#pricing-vm").on("click", function (e) {
            e.preventDefault();
            viewVmPricing();
            });
          
        },
    })
  }

  // function viewReservationManagement(){
  //   $.ajax({
  //       type: "GET",
  //       url: "./reservation-management/reservation-management.php",
  //       dataType: "html",
  //       success: function (response) {
  //         $("#adminView").html(response);
  //       },
  //   })
  // }

  function viewVmAddVenue(){
    $.ajax({
        type: "GET",
        url: "./venue-management/add-venue.html",
        dataType: "html",
        success: function (response) {
          $("#venue-management-view").html(response);
        },
    })
  }

  function viewVmManageVenue(){
    $.ajax({
        type: "GET",
        url: "./venue-management/manage-venues.php",
        dataType: "html",
        success: function (response) {
          $("#venue-management-view").html(response);
        },
    })
  }

  function viewVmPricing(){
    $.ajax({
        type: "GET",
        url: "./venue-management/venue-rates.php",
        dataType: "html",
        success: function (response) {
          $("#venue-management-view").html(response);
        },
    })
  }


});
