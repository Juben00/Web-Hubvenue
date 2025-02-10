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
$userId = $data['user_id'] ?? null;

// Validate user ID matches session user
if ($userId != $_SESSION['user']['id']) {
    echo json_encode(['success' => false, 'message' => 'Invalid user']);
    exit;
}

$notification = new Notification();
$success = $notification->markAllAsRead($userId);

echo json_encode(['success' => $success]); 