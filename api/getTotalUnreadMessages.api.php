<?php
require_once '../dbconnection.php';
session_start();

header('Content-Type: application/json');

try {
    $user_id = isset($_GET['user_id']) ? $_GET['user_id'] : null;

    if (!$user_id) {
        throw new Exception('User ID is required');
    }

    $db = new Database();
    $conn = $db->connect();

    // Get total unread messages across all conversations
    $query = "SELECT COUNT(*) as total_unread
              FROM messages m
              JOIN conversations c ON m.conversation_id = c.id
              JOIN conversation_participants cp ON c.id = cp.conversation_id
              LEFT JOIN message_status ms ON m.id = ms.message_id AND ms.user_id = :user_id
              WHERE cp.user_id = :user_id 
              AND m.sender_id != :user_id
              AND (ms.is_read = 0 OR ms.is_read IS NULL)";

    $stmt = $conn->prepare($query);
    $stmt->execute(['user_id' => $user_id]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    echo json_encode([
        'success' => true,
        'total_unread' => (int) $result['total_unread']
    ]);

} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
} 