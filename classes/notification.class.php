<?php
require_once __DIR__ . '/../dbconnection.php';

class Notification {
    private $conn;
    
    // Notification types
    const TYPE_MESSAGE = 'message';
    const TYPE_BOOKING = 'booking';
    const TYPE_BOOKING_UPDATE = 'booking_update';
    const TYPE_PRICE_UPDATE = 'price_update';
    const TYPE_ACCOUNT = 'account';
    const TYPE_VENUE = 'venue';

    // Default number of notifications to fetch
    const DEFAULT_LIMIT = 50;

    // Notification templates
    const TEMPLATES = [
        'booking_request' => 'You have a new booking request from {user} for {venue}',
        'booking_accepted' => 'Your booking request for {venue} has been accepted!',
        'booking_declined' => 'Unfortunately, your request to stay at {venue} was declined',
        'payment_confirmed' => 'Your payment of ₱{amount} for {venue} has been processed successfully',
        'booking_canceled' => 'The booking for {venue} has been canceled',
        'new_message' => '{user} sent you a message: {message}',
        'payment_sent' => 'A payout of ₱{amount} has been sent for your booking',
        'booking_reminder' => 'Your stay at {venue} is coming up soon!'
    ];

    public function __construct() {
        $database = new Database();
        $this->conn = $database->connect();
    }

    public function getUserNotifications($userId, $limit = self::DEFAULT_LIMIT, $offset = 0) {
        $query = "SELECT n.id, n.type, n.message, n.created_at, n.is_read,
                    CASE 
                        WHEN n.type = 'message' THEN (
                            SELECT CONCAT(u.firstname, ' ', u.lastname)
                            FROM messages m
                            JOIN users u ON m.sender_id = u.id
                            WHERE m.id = n.reference_id
                        )
                        WHEN n.type IN ('booking', 'booking_update', 'price_update') THEN (
                            SELECT CONCAT(u.firstname, ' ', u.lastname)
                            FROM bookings b
                            JOIN users u ON b.booking_guest_id = u.id
                            WHERE b.id = n.reference_id
                        )
                        WHEN n.type = 'venue' THEN (
                            SELECT name FROM venues WHERE id = n.reference_id
                        )
                        ELSE NULL
                    END as reference_name,
                    CASE 
                        WHEN n.type = 'message' THEN (
                            SELECT u.profile_pic
                            FROM messages m
                            JOIN users u ON m.sender_id = u.id
                            WHERE m.id = n.reference_id
                        )
                        WHEN n.type IN ('booking', 'booking_update') THEN (
                            SELECT u.profile_pic
                            FROM bookings b
                            JOIN users u ON b.booking_guest_id = u.id
                            WHERE b.id = n.reference_id
                        )
                        ELSE NULL
                    END as profile_pic,
                    TIMESTAMPDIFF(SECOND, n.created_at, CURRENT_TIMESTAMP) as seconds_ago
                FROM notifications n
                WHERE n.user_id = :userId 
                ORDER BY n.created_at DESC 
                LIMIT :limit
                OFFSET :offset";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':userId', $userId, PDO::PARAM_INT);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTotalNotificationCount($userId) {
        $query = "SELECT COUNT(*) as count FROM notifications WHERE user_id = :userId";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':userId', $userId, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $count = (int)$result['count'];
        
        // Enhanced debugging
        error_log("=== Notification Count Debug ===");
        error_log("User ID: " . $userId);
        error_log("SQL Query: " . $query);
        error_log("Count Result: " . $count);
        error_log("Raw result: " . print_r($result, true));
        error_log("=============================");
        
        return $count;
    }

    public function getUnreadCount($userId) {
        $query = "SELECT COUNT(*) as count 
                 FROM notifications n
                 WHERE n.user_id = :userId 
                 AND n.is_read = 0";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':userId', $userId, PDO::PARAM_INT);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['count'];
    }

    public function createBookingRequestNotification($userId, $bookingId, $guestName, $venueName) {
        $message = str_replace(
            ['{user}', '{venue}'],
            [$guestName, $venueName],
            self::TEMPLATES['booking_request']
        );
        return $this->createNotification($userId, self::TYPE_BOOKING, $bookingId, $message);
    }

    public function createBookingAcceptedNotification($userId, $bookingId, $venueName) {
        $message = str_replace(
            '{venue}',
            $venueName,
            self::TEMPLATES['booking_accepted']
        );
        return $this->createNotification($userId, self::TYPE_BOOKING_UPDATE, $bookingId, $message);
    }

    public function createBookingDeclinedNotification($userId, $bookingId, $venueName) {
        $message = str_replace(
            '{venue}',
            $venueName,
            self::TEMPLATES['booking_declined']
        );
        return $this->createNotification($userId, self::TYPE_BOOKING_UPDATE, $bookingId, $message);
    }

    public function createPaymentConfirmationNotification($userId, $bookingId, $amount, $venueName) {
        $message = str_replace(
            ['{amount}', '{venue}'],
            [$amount, $venueName],
            self::TEMPLATES['payment_confirmed']
        );
        return $this->createNotification($userId, self::TYPE_PRICE_UPDATE, $bookingId, $message);
    }

    public function createBookingCanceledNotification($userId, $bookingId, $venueName) {
        $message = str_replace(
            '{venue}',
            $venueName,
            self::TEMPLATES['booking_canceled']
        );
        return $this->createNotification($userId, self::TYPE_BOOKING_UPDATE, $bookingId, $message);
    }

    public function createMessageNotification($userId, $messageId, $senderName, $messageContent) {
        $message = str_replace(
            ['{user}', '{message}'],
            [$senderName, $messageContent],
            self::TEMPLATES['new_message']
        );
        return $this->createNotification($userId, self::TYPE_MESSAGE, $messageId, $message);
    }

    public function createPaymentSentNotification($userId, $bookingId, $amount) {
        $message = str_replace(
            '{amount}',
            $amount,
            self::TEMPLATES['payment_sent']
        );
        return $this->createNotification($userId, self::TYPE_PRICE_UPDATE, $bookingId, $message);
    }

    public function createAccountNotification($userId, $message) {
        return $this->createNotification($userId, self::TYPE_ACCOUNT, $userId, $message);
    }

    public function createVenueNotification($userId, $venueId, $message) {
        return $this->createNotification($userId, self::TYPE_VENUE, $venueId, $message);
    }

    private function createNotification($userId, $type, $referenceId, $message) {
        // Check for duplicate notifications within the last minute
        $query = "SELECT id FROM notifications 
                 WHERE user_id = :userId 
                 AND type = :type 
                 AND reference_id = :referenceId
                 AND created_at > DATE_SUB(NOW(), INTERVAL 1 MINUTE)";
        
        $stmt = $this->conn->prepare($query);
        $stmt->execute([
            'userId' => $userId,
            'type' => $type,
            'referenceId' => $referenceId
        ]);
        
        if ($stmt->rowCount() > 0) {
            // Update existing notification
            $notifId = $stmt->fetchColumn();
            $query = "UPDATE notifications 
                     SET message = :message,
                         is_read = 0,
                         updated_at = NOW() 
                     WHERE id = :notifId";
            
            $stmt = $this->conn->prepare($query);
            return $stmt->execute([
                'message' => $message,
                'notifId' => $notifId
            ]);
        }

        // Create new notification
        $query = "INSERT INTO notifications (user_id, type, reference_id, message, created_at, updated_at) 
                 VALUES (:userId, :type, :referenceId, :message, NOW(), NOW())";
        
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([
            'userId' => $userId,
            'type' => $type,
            'referenceId' => $referenceId,
            'message' => $message
        ]);
    }

    public function markAsRead($notificationId) {
        $query = "UPDATE notifications 
                 SET is_read = 1,
                     read_at = NOW(),
                     updated_at = NOW()
                 WHERE id = :notificationId 
                 AND user_id = :userId 
                 AND is_read = 0";
        
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([
            'notificationId' => $notificationId,
            'userId' => $_SESSION['user']
        ]);
    }

    public function markAllAsRead($userId) {
        $query = "UPDATE notifications 
                 SET is_read = 1,
                     read_at = NOW(),
                     updated_at = NOW()
                 WHERE user_id = :userId AND is_read = 0";
        
        $stmt = $this->conn->prepare($query);
        return $stmt->execute(['userId' => $userId]);
    }
} 