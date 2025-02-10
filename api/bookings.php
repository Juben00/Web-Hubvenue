<?php

// After successful booking creation
if ($stmt->execute()) {
    $bookingId = $conn->lastInsertId();
    
    try {
        // Create notification for the host
        require_once '../classes/notification.class.php';
        $notification = new Notification();

        // Get host ID and venue details
        $stmt = $conn->prepare("SELECT v.host_id, v.name FROM venues v WHERE v.id = ?");
        $stmt->execute([$venueId]);
        $venue = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($venue) {
            // Create booking notification for host
            $notification->createBookingNotification(
                $venue['host_id'],
                $bookingId,
                "New booking request for " . $venue['name']
            );
        }

        // Send success response
        echo json_encode([
            'success' => true, 
            'booking_id' => $bookingId,
            'message' => 'Booking created successfully'
        ]);
    } catch (Exception $e) {
        error_log("Error creating notification: " . $e->getMessage());
        // Still return success since booking was created
        echo json_encode([
            'success' => true,
            'booking_id' => $bookingId,
            'message' => 'Booking created but notification failed'
        ]);
    }
} else {
    // Error handling
    echo json_encode([
        'success' => false, 
        'error' => 'Failed to create booking'
    ]);
} 