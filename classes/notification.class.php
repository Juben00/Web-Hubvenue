<?php
require_once __DIR__ . '/../dbconnection.php';

class Notification {
    private $conn;
    
    // Notification types
    const TYPE_MESSAGE = 'message';
    const TYPE_BOOKING = 'booking';
    const TYPE_ACCOUNT = 'account';
    const TYPE_VENUE = 'venue';
    const TYPE_BOOKING_UPDATE = 'booking_update';
    const TYPE_PRICE_UPDATE = 'price_update';

    public function __construct() {
        $database = new Database();
        $this->conn = $database->connect();
    }

    public function getUserNotifications($userId, $limit = 5) {
        $query = "SELECT n.*, 
                    CASE 
                        WHEN n.type = 'message' THEN (
                            SELECT CONCAT(u.firstname, ' ', u.lastname)
                            FROM messages m
                            JOIN users u ON m.sender_id = u.id
                            WHERE m.id = n.reference_id
                        )
                        WHEN n.type IN ('booking', 'booking_update', 'price_update') THEN (
                            SELECT v.name
                            FROM bookings b
                            JOIN venues v ON b.booking_venue_id = v.id
                            WHERE b.id = n.reference_id
                        )
                        WHEN n.type = 'venue' THEN (
                            SELECT name FROM venues WHERE id = n.reference_id
                        )
                        ELSE NULL
                    END as reference_name,
                    CASE 
                        WHEN n.type = 'message' THEN (
                            SELECT m.content
                            FROM messages m
                            WHERE m.id = n.reference_id
                            LIMIT 1
                        )
                        WHEN n.type IN ('booking', 'booking_update') THEN (
                            SELECT CONCAT('₱', FORMAT(b.booking_grand_total, 2))
                            FROM bookings b
                            WHERE b.id = n.reference_id
                        )
                        ELSE NULL
                    END as additional_info,
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
                    CASE 
                        WHEN n.type IN ('booking', 'booking_update') THEN (
                            SELECT booking_status_id
                            FROM bookings
                            WHERE id = n.reference_id
                        )
                        ELSE NULL
                    END as status_id,
                    TIMESTAMPDIFF(SECOND, n.created_at, CURRENT_TIMESTAMP) as seconds_ago
                FROM notifications n
                WHERE n.user_id = :userId 
                ORDER BY n.created_at DESC 
                LIMIT :limit";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':userId', $userId, PDO::PARAM_INT);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
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

    public function createMessageNotification($userId, $messageId, $senderId, $messageContent) {
        // Check if there's a recent notification for the same sender and message
        $query = "SELECT id FROM notifications 
                 WHERE user_id = :userId 
                 AND type = :type 
                 AND reference_id = :messageId
                 AND created_at > DATE_SUB(NOW(), INTERVAL 5 MINUTE)";
        
        $stmt = $this->conn->prepare($query);
        $stmt->execute([
            'userId' => $userId,
            'type' => self::TYPE_MESSAGE,
            'messageId' => $messageId
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
                'message' => $messageContent,
                'notifId' => $notifId
            ]);
        } else {
            // Create new notification
            return $this->createNotification($userId, self::TYPE_MESSAGE, $messageId, $messageContent);
        }
    }

    public function createBookingNotification($userId, $bookingId, $message) {
        return $this->createNotification($userId, self::TYPE_BOOKING, $bookingId, $message);
    }

    public function createVenueNotification($userId, $venueId, $message) {
        return $this->createNotification($userId, self::TYPE_VENUE, $venueId, $message);
    }

    public function createBookingUpdateNotification($userId, $bookingId, $message) {
        return $this->createNotification($userId, self::TYPE_BOOKING_UPDATE, $bookingId, $message);
    }

    public function createPriceUpdateNotification($userId, $bookingId, $message) {
        return $this->createNotification($userId, self::TYPE_PRICE_UPDATE, $bookingId, $message);
    }

    public function createAccountNotification($userId, $message) {
        return $this->createNotification($userId, self::TYPE_ACCOUNT, $userId, $message);
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
            // Update existing notification instead of creating a new one
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