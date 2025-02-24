<?php
require_once '../dbconnection.php';
header('Content-Type: application/json');

try {
    $db = new Database();
    $conn = $db->connect();

    $bookingId = $_GET['booking_id'] ?? null;
    $userId = $_GET['user_id'] ?? null;

    if (!$bookingId || !$userId) {
        throw new Exception('Missing required parameters');
    }

    // Get unread count for the conversation
    $query = "SELECT COUNT(*) as unread_count
              FROM messages m
              JOIN conversations c ON m.conversation_id = c.id
              LEFT JOIN message_status ms ON m.id = ms.message_id AND ms.user_id = :user_id
              WHERE c.booking_id = :booking_id
              AND m.sender_id != :user_id
              AND (ms.is_read = 0 OR ms.is_read IS NULL)";

    $stmt = $conn->prepare($query);
    $stmt->execute([
        'booking_id' => $bookingId,
        'user_id' => $userId
    ]);

    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
    echo json_encode([
        'success' => true,
        'unread_count' => (int)$result['unread_count']
    ]);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
} 