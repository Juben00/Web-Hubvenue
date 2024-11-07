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

// Link listeners
let url = window.location.href;

// Define a mapping between URL endings and link IDs
const linkMappings = {
    "dashboard": "#dashboard-link",
    "venue-management": "#venue-management-link",
    "reservation-management": "#reservation-management-link",
    "financial-management": "#financial-management-link",
    "reports-analytics": "#reports-analytics-link",
    "notifications-alerts": "#notifications-alerts-link",
    "content-management": "#content-management-link",
    "promotions-marketing": "#promotions-marketing-link",
    "support-helpdesk": "#support-helpdesk-link",
    "settings": "#settings-link",
    "audit-logs": "#audit-logs-link",
    "user-management": "#user-management-link",
    // Venue management subviews
    "venue-management/add": "#add-venue-link",
    "venue-management/manage": "#manage-venues-link",
    "venue-management/pricing": "#venue-rates-link",
    "venue-management/availability": "#venue-availability-link"
};

// Loop through each mapping to find a matching URL ending
let linkFound = false;
for (const [key, linkId] of Object.entries(linkMappings)) {
    if (url.endsWith(key)) {
        $(linkId).trigger("click");
        linkFound = true;
        break;
    }
}

// Default to the dashboard link if no match was found
if (!linkFound) {
    $("#dashboard-link").trigger("click");
}



  //main views
  function viewDashboard(){
    $.ajax({
        type: "GET",
        url: "../dashboard/dashboard.php",
        dataType: "html",
        success: function (response) {
          $("#adminView").html(response);
        },
    })
  }

  function viewVenueManagement() {
      $.ajax({
          type: "GET",
          url: "../venue-management/venue-management.php",
          dataType: "html",
          success: function (response) {
              $("#adminView").html(response);

              // Set initial view to Add Venue
              viewVmAddVenue();

              // Event listeners for tabs within the loaded content
              $("#add-venue-vm").on("click", function (e) {
                  e.preventDefault();
                  viewVmAddVenue();
                  activateTab($(this));
              });

              $("#manage-venues-vm").on("click", function (e) {
                  e.preventDefault();
                  viewVmManageVenue();
                  activateTab($(this));
              });

              $("#pricing-vm").on("click", function (e) {
                  e.preventDefault();
                  viewVmPricing();
                  activateTab($(this));
              });

              $("#availability-vm").on("click", function (e) {
                  e.preventDefault();
                  viewVmAvailability();
                  activateTab($(this));
              });

              
          },
      });
  }

// Function to activate the clicked tab
  function activateTab(selectedTab) {
      $(".tab-button")
          .removeClass("bg-red-600 text-white")  // Remove active styles from all tabs
          .addClass("text-gray-800");            // Set default text color for all tabs

      selectedTab
          .addClass("bg-red-600 text-white")     // Add active styles to selected tab
          .removeClass("text-gray-800");         // Remove default text color for active tab
  }


  function viewReservationManagement(){
    $.ajax({
        type: "GET",
        url: "../reservation-management/reservation-management.php",
        dataType: "html",
        success: function (response) {
          $("#adminView").html(response);
        },
    })
  }

  function viewFinancialManagement(){
    $.ajax({
        type: "GET",
        url: "../financial-management/financial-management.php",
        dataType: "html",
        success: function (response) {
          $("#adminView").html(response);
        },
    })
  }

  function viewReportsAnalytics(){
    $.ajax({
        type: "GET",
        url: "../reports-and-analytics/reports-and-analytics.php",
        dataType: "html",
        success: function (response) {
          $("#adminView").html(response);
        },
    })
  }

  function viewNotificationAlerts(){
    $.ajax({
      type: "GET",
      url: "../notifications-alerts/notifications-alerts.php",
      dataType: "html",
      success: function (response) {
        $("#adminView").html(response);
      },
      })
  }

  function viewContentManagement(){
    $.ajax({
      type: "GET",
      url: "../content-management/content-management.php",
      dataType: "html",
      success: function (response) {
        $("#adminView").html(response);
      }, 
      })
  }

  function viewPromotionsMarketing(){
    $.ajax({
      type: "GET",
      url: "../promotion-marketing/promotion-marketing.php",
      dataType: "html",
      success: function (response) {
        $("#adminView").html(response);
      },
      })
  }

  function viewSupportHelpdesk(){
    $.ajax({
      type: "GET",
      url: "../support-helpdesk/support-helpdesk.php",
      dataType: "html",
      success: function (response) {
        $("#adminView").html(response);  
  },
  })
  }

  function viewSettings(){
    $.ajax({
      type: "GET",
      url: "../settings/settings.php",
      dataType: "html",
      success: function (response) {
        $("#adminView").html(response);
        },
      })
  }

  function viewAuditLogs(){
    $.ajax({
      type: "GET",
      url: "../audit-logs/audit-logs.php",
      dataType: "html",
      success: function (response) {
        $("#adminView").html(response);
        },
      })
  }
  

  function viewUserManagement(){
    $.ajax({
      type: "GET",
      url: "../user-management/user-management.php",
      dataType: "html",
      success: function (response) {
        $("#adminView").html(response);
        },
      })
  }


    //sub views
  function viewVmAddVenue() {
    $.ajax({
        type: "GET",
        url: "../venue-management/add-venue.html",
        dataType: "html",
        success: function (response) {
            

            $("#venue-management-view").html(response);

            $("#maps-button").on("click", function (e) {
                e.preventDefault();
                viewOpenStreetMap();  // Open the map for user interaction
            });

            $('#add-venue-form').on("submit", function (e) {
                e.preventDefault();
                addVenue();
            });

            
        },
    });
}

  function viewVmManageVenue(){
    $.ajax({
        type: "GET",
        url: "../venue-management/manage-venues.php",
        dataType: "html",
        success: function (response) {
          $("#venue-management-view").html(response);
        },
    })
  }

  function viewVmPricing(){
    $.ajax({
        type: "GET",
        url: "../venue-management/venue-rates.php",
        dataType: "html",
        success: function (response) {
          $("#venue-management-view").html(response);
        },
    })
  }

  function viewVmAvailability(){
    $.ajax({
        type: "GET",
        url: "../venue-management/venue-availability.php",
        dataType: "html",
        success: function (response) {
          $("#venue-management-view").html(response);
        },
    })
  }

  function viewOpenStreetMap(){
    $.ajax({
        type: "GET",
        url: "../venue-management/openStreetMap.html",
        dataType: "html",
        success: function (response) {
          $("#openstreetmapplaceholder").html(response);

          $('#openStreetMapSubmit').on("click", function (e) {
            
                e.preventDefault();
                console.log("hgloasd");
                
                // // Capture the value of #OpenStreetaddress
                // let openStreetAddress = $('#OpenStreetaddress').val();
                // // Set this value to #venue-location if it exists
                // $('#venue-location').val(openStreetAddress);
                $('#openStreetMapDiv').addClass("hidden"); // Hide the map modal

                
            });

        },
    })
  }


  //api calls
  function addVenue(){
    let form = new FormData($("#add-venue-form")[0]);
    $.ajax({
        type: "POST",
        url: "../api/AddVenue.api.php",
        data: form,
        dataType: "json",
        contentType: false,
        processData: false,
        success: function (response) {
            if (response.status == "success") {
                console.log("Venue added successfully");
                $("#add-venue-form")[0].reset();
            } else {
                console.log("Venue not added");
            }
        },
    });
  }

});
