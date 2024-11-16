$(document).ready(function () {
  
  console.log("admin jquery loaded");
  

  //when the page is resfershed, the dashboard is loaded
  $("#dashboard-link").click();

  $(".nav-link").on("click", function (e) {
    e.preventDefault();

    // Remove active styles from all nav links and reset to original color
    $(".nav-link")
      .removeClass("bg-red-600 text-white")
      .addClass("text-gray-800");

    // Add active styles to the clicked link
    $(this).addClass("bg-red-600 text-white").removeClass("text-gray-800");

    // Update URL without reloading
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

  $("#host-application-link").on("click", function (e) {
  e.preventDefault();
  viewHostApplication();
  });

  $("#admin-logout").on("click", function (e) {
  e.preventDefault();
  confirmshowModal("Are you sure you want to logout?", adminLogout, "black_ico.png");
  });

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

              $("#approved-vm").on("click", function (e) {
                  e.preventDefault();
                   viewVmApproved();
                  activateTab($(this));
              });

              $("#rejected-vm").on("click", function (e) {
                  e.preventDefault();
                 viewVmRejected();
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

  function adminLogout(){
    $.ajax({
      type: "GET",
      url: "../logout.php",
      dataType: "html",
      success: function (response) {
        window.location.href = "../index.php";
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

  function viewHostApplication(){
    $.ajax({
      type: "GET",
      url: "../host-application/host-application.php",
      dataType: "html",
      success: function (response) {
        $("#adminView").html(response);

        $('.approveHostApplication').on("submit", function (e) {
            e.preventDefault();
            const formElement = $(this); // Capture the form element for use in confirm function

            // Show confirmation modal and only proceed if confirmed
            confirmshowModal(
                "Are you sure you want to approve this post?",
                function() {
                    approveHost(formElement); // Call approveVenue only after confirmation
                },
                "black_ico.png"
            );
        });
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

  function viewVmManageVenue() {
    $.ajax({
        type: "GET",
        url: "../venue-management/manage-venues.php",
        dataType: "html",
        success: function (response) {
            $("#venue-management-view").html(response);

            // Event listener for form submission
            $('.approveVenueButton').on("submit", function (e) {
                e.preventDefault();
                const formElement = $(this); // Capture the form element for use in confirm function

                // Show confirmation modal and only proceed if confirmed
                confirmshowModal(
                    "Are you sure you want to approve this post?",
                    function() {
                        approveVenue(formElement); // Call approveVenue only after confirmation
                    },
                    "black_ico.png"
                );
            });

            // Event listener for form submission
            $('.declineVenueButton').on("submit", function (e) {
                e.preventDefault();
                const formElement = $(this); // Capture the form element for use in confirm function

                // Show confirmation modal and only proceed if confirmed
                confirmshowModal(
                    "Are you sure you want to reject this post?",
                    function() {
                        rejectVenue(formElement); // Call rejectVenue only after confirmation
                    },
                    "black_ico.png"
                );
            });
        },
    });
}

  function viewVmRejected(){
    $.ajax({
        type: "GET",
        url: "../venue-management/rejected-venues.php",
        dataType: "html",
        success: function (response) {
          $("#venue-management-view").html(response);
        },
    })
  }

  function viewVmApproved(){
    $.ajax({
        type: "GET",
        url: "../venue-management/approved-venues.php",
        dataType: "html",
        success: function (response) {
          $("#venue-management-view").html(response);
        },
    })
  }

  function viewOpenStreetMap(){
    $.ajax({
        type: "GET",
        url: "../openStreetMap/openStreetMap.html",
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
                showModal(
                    "Venue added successfully",
                    "black_ico.png"
                );
                $("#add-venue-form")[0].reset();
            } else {
                showModal(
                    "Venue not added",
                    "black_ico.png"
                );
            }
        },
    });
  }

  function approveVenue(formElement) {
    let form = new FormData(formElement[0]);
    $.ajax({
        type: "POST",
        url: "../api/ApproveVenue.api.php",
        data: form,
        dataType: "json",
        contentType: false,
        processData: false,
        success: function (response) {
            if (response.status === "success") {
                console.log("Venue approved successfully");
                formElement[0].reset();
                //refresh the page
                viewVmManageVenue();
            } else {
                console.log("Venue not approved");
            }
        },
    });
  }

  function approveHost(formElement) {
    let form = new FormData(formElement[0]);
    $.ajax({
        type: "POST",
        url: "../api/ApproveHost.api.php",
        data: form,
        dataType: "json",
        contentType: false,
        processData: false,
        success: function (response) {
            if (response.status === "success") {
                showModal(
                    response.message,
                    "black_ico.png"
                );
                formElement[0].reset();
                //refresh the page
                viewHostApplication();
            } else {
                showModal(
                    response.message,
                    "black_ico.png"
                );
            }
        },
    });
  }

  function rejectVenue(formElement) {
    let form = new FormData(formElement[0]);
    $.ajax({
        type: "POST",
        url: "../api/RejectVenue.api.php",
        data: form,
        dataType: "json",
        contentType: false,
        processData: false,
        success: function (response) {
            if (response.status === "success") {
                console.log("Venue rejected successfully");
                formElement[0].reset();
                //refresh the page
                viewVmManageVenue();
            } else {
                console.log("Venue not rejected");
            }
        },
    });
  }

});
