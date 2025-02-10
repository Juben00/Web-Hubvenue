<?php

// After successful venue update
if ($stmt->execute()) {
    try {
        require_once '../classes/notification.class.php';
        $notification = new Notification();

        // Check if price was updated
        if (isset($data['price']) && $data['price'] !== $originalPrice) {
            // Get all guests who have booked this venue
            $stmt = $conn->prepare("
                SELECT DISTINCT b.booking_guest_id 
                FROM bookings b 
                WHERE b.booking_venue_id = ? 
                AND b.booking_status_id IN (1, 2, 4)  -- Pending, Confirmed, or Completed
                AND b.booking_created_at >= DATE_SUB(NOW(), INTERVAL 6 MONTH)  -- Within last 6 months
            ");
            $stmt->execute([$venueId]);
            $guests = $stmt->fetchAll(PDO::FETCH_COLUMN);

            // Notify each guest about the price change
            foreach ($guests as $guestId) {
                $notification->createPriceUpdateNotification(
                    $guestId,
                    $venueId,
                    "Price updated for venue " . $venueName . ". New price: ₱" . number_format($data['price'], 2)
                );
            }
        }

        // If venue status changed (e.g., approved, rejected)
        if (isset($data['venue_status_id']) && $data['venue_status_id'] !== $originalStatus) {
            // Notify the host about venue status change
            $notification->createVenueNotification(
                $hostId,
                $venueId,
                "Your venue " . $venueName . " status has been updated to " . getVenueStatusName($data['venue_status_id'])
            );
        }

        // Send success response
        echo json_encode([
            'success' => true,
            'message' => 'Venue updated successfully'
        ]);
    } catch (Exception $e) {
        error_log("Error creating notifications: " . $e->getMessage());
        // Still return success since venue was updated
        echo json_encode([
            'success' => true,
            'message' => 'Venue updated but notifications failed'
        ]);
    }
} else {
    echo json_encode([
        'success' => false,
        'error' => 'Failed to update venue'
    ]);
}

// Helper function to get venue status name
function getVenueStatusName($statusId) {
    switch ($statusId) {
        case 1:
            return "Pending";
        case 2:
            return "Approved";
        case 3:
            return "Rejected";
        default:
            return "Unknown";
    }
} 