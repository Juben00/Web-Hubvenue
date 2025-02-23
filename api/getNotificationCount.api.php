<?php
require_once '../dbconnection.php';
require_once '../classes/notification.class.php';
session_start();

header('Content-Type: application/json');

try {
    $user_id = isset($_GET['user_id']) ? $_GET['user_id'] : null;

    if (!$user_id) {
        throw new Exception('User ID is required');
    }

    $notification = new Notification();
    $unreadCount = $notification->getUnreadCount($user_id);

    echo json_encode([
        'success' => true,
        'unread_count' => (int) $unreadCount
    ]);

} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
} 