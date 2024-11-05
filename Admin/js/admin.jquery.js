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
    viewReservationManagement();
  });

  $("#financial-management-link").on("click", function (e) {
  e.preventDefault();
  viewFinancialManagement();
  });

  $("#reports-analytics-link").on("click", function (e) {
  e.preventDefault();
  viewReportsAnalytics();
  });

  $("#notifications-alerts-link").on("click", function (e) {
  e.preventDefault();
  viewNotificationAlerts();
  });

  $("#content-management-link").on("click", function (e) {
      e.preventDefault();
      viewContentManagement();
  });

  $("#promotions-marketing-link").on("click", function (e) {
  e.preventDefault();
  viewPromotionsMarketing();
  });

  $("#support-helpdesk-link").on("click", function (e) {
  e.preventDefault();
  viewSupportHelpdesk();
  });

  $("#settings-link").on("click", function (e) {
  e.preventDefault();
  viewSettings();
  });

  $("#audit-logs-link").on("click", function (e) {
  e.preventDefault();
  viewAuditLogs();
  });

  $("#user-management-link").on("click", function (e) {
  e.preventDefault();
  viewUserManagement();
  });






  

  //link listeners
  let url = window.location.href;

  if (url.endsWith("dashboard")) {
    $("#dashboard-link").trigger("click");
  } else if (url.endsWith("venue-management")) {
    $("#venue-management-link").trigger("click");
  } else if (url.endsWith("accounts")) {
    $("#accounts-link").trigger("click");
  } else {
    $("#dashboard-link").trigger("click");
  }


  //main views
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

          //add event listeners
          
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

          $("#availability-vm").on("click", function (e) {
            e.preventDefault();
            viewVmAvailability();
          });
          
          viewVmAddVenue();
        },
    })
  }

  function viewReservationManagement(){
    $.ajax({
        type: "GET",
        url: "./reservation-management/reservation-management.php",
        dataType: "html",
        success: function (response) {
          $("#adminView").html(response);
        },
    })
  }

  function viewFinancialManagement(){
    $.ajax({
        type: "GET",
        url: "./financial-management/financial-management.php",
        dataType: "html",
        success: function (response) {
          $("#adminView").html(response);
        },
    })
  }

  function viewReportsAnalytics(){
    $.ajax({
        type: "GET",
        url: "./reports-and-analytics/reports-and-analytics.php",
        dataType: "html",
        success: function (response) {
          $("#adminView").html(response);
        },
    })
  }

  function viewNotificationAlerts(){
    $.ajax({
      type: "GET",
      url: "./notifications-alerts/notifications-alerts.php",
      dataType: "html",
      success: function (response) {
        $("#adminView").html(response);
      },
      })
  }

  function viewContentManagement(){
    $.ajax({
      type: "GET",
      url: "./content-management/content-management.php",
      dataType: "html",
      success: function (response) {
        $("#adminView").html(response);
      }, 
      })
  }

  function viewPromotionsMarketing(){
    $.ajax({
      type: "GET",
      url: "./promotion-marketing/promotion-marketing.php",
      dataType: "html",
      success: function (response) {
        $("#adminView").html(response);
      },
      })
  }

  function viewSupportHelpdesk(){
    $.ajax({
      type: "GET",
      url: "./support-helpdesk/support-helpdesk.php",
      dataType: "html",
      success: function (response) {
        $("#adminView").html(response);  
  },
  })
  }

  function viewSettings(){
    $.ajax({
      type: "GET",
      url: "./settings/settings.php",
      dataType: "html",
      success: function (response) {
        $("#adminView").html(response);
        },
      })
  }

  function viewAuditLogs(){
    $.ajax({
      type: "GET",
      url: "./audit-logs/audit-logs.php",
      dataType: "html",
      success: function (response) {
        $("#adminView").html(response);
        },
      })
  }

  function viewUserManagement(){
    $.ajax({
      type: "GET",
      url: "./user-management/user-management.php",
      dataType: "html",
      success: function (response) {
        $("#adminView").html(response);
        },
      })
  }
  
  
  
    //sub views
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

  function viewVmAvailability(){
    $.ajax({
        type: "GET",
        url: "./venue-management/venue-availability.php",
        dataType: "html",
        success: function (response) {
          $("#venue-management-view").html(response);
        },
    })
  }

});
