<?php
session_start();
require_once '../classes/notification.class.php';

header('Content-Type: application/json');

// Check if user is logged in
if (!isset($_SESSION['user'])) {
    echo json_encode(['success' => false, 'message' => 'User not authenticated']);
    exit;
}

// Get POST data
$data = json_decode(file_get_contents('php://input'), true);
$notificationId = isset($data['notification_id']) ? (int)$data['notification_id'] : null;

if (!$notificationId) {
    echo json_encode(['success' => false, 'message' => 'Notification ID is required']);
    exit;
}

$notification = new Notification();

try {
    // Mark the specific notification as read
    $success = $notification->markAsRead($notificationId);
    echo json_encode(['success' => $success]);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
} 