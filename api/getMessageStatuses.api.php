<?php
require_once '../dbconnection.php';
session_start();

header('Content-Type: application/json');

// Debug logging function
function debugLog($message, $data = null) {
    error_log(sprintf(
        "[Message Status Debug] %s %s",
        $message,
        $data ? json_encode($data) : ''
    ));
}

debugLog('Starting message status check', [
    'session_user' => $_SESSION['user'] ?? null,
    'conversation_id' => $_GET['conversation_id'] ?? null,
    'user_id' => $_GET['user_id'] ?? null
]);

// Verify user is logged in
if (!isset($_SESSION['user'])) {
    debugLog('User not authenticated');
    echo json_encode(['success' => false, 'error' => 'User not authenticated']);
    exit;
}

// Get parameters
$conversationId = isset($_GET['conversation_id']) ? intval($_GET['conversation_id']) : null;
$userId = isset($_GET['user_id']) ? intval($_GET['user_id']) : null;

debugLog('Parsed parameters', [
    'conversation_id' => $conversationId,
    'user_id' => $userId
]);

if (!$conversationId || !$userId) {
    debugLog('Missing required parameters');
    echo json_encode(['success' => false, 'error' => 'Missing required parameters']);
    exit;
}

try {
    $db = new Database();
    $conn = $db->connect();

    debugLog('Database connected successfully');

    // Get all participants in the conversation except the sender
    $participantsStmt = $conn->prepare("
        SELECT user_id 
        FROM conversation_participants 
        WHERE conversation_id = ? AND user_id != ?
    ");
    $participantsStmt->execute([$conversationId, $userId]);
    $participants = $participantsStmt->fetchAll(PDO::FETCH_COLUMN);
    $totalParticipants = count($participants);

    // Get messages with their status information
    $stmt = $conn->prepare("
        SELECT 
            m.id,
            m.sender_id,
            m.created_at,
            (
                SELECT COUNT(DISTINCT ms.user_id)
                FROM message_status ms
                WHERE ms.message_id = m.id
                AND ms.user_id IN (" . implode(',', array_fill(0, count($participants), '?')) . ")
            ) as status_count,
            (
                SELECT COUNT(DISTINCT ms.user_id)
                FROM message_status ms
                WHERE ms.message_id = m.id
                AND ms.is_read = 1
                AND ms.user_id IN (" . implode(',', array_fill(0, count($participants), '?')) . ")
            ) as read_count
        FROM messages m
        WHERE m.conversation_id = ?
        AND m.sender_id = ?
        ORDER BY m.created_at DESC
    ");

    // Prepare parameters for the query
    $params = array_merge(
        $participants, // For first IN clause
        $participants, // For second IN clause
        [$conversationId, $userId] // For WHERE clause
    );
    $stmt->execute($params);
    $messages = $stmt->fetchAll(PDO::FETCH_ASSOC);

    debugLog('Query results', [
        'message_count' => count($messages),
        'messages' => $messages,
        'total_participants' => $totalParticipants
    ]);

    echo json_encode([
        'success' => true,
        'messages' => $messages,
        'total_participants' => $totalParticipants,
        'debug' => [
            'conversation_id' => $conversationId,
            'user_id' => $userId,
            'message_count' => count($messages)
        ]
    ]);

} catch (PDOException $e) {
    debugLog('Database error', ['error' => $e->getMessage()]);
    error_log("Database error: " . $e->getMessage());
    echo json_encode([
        'success' => false,
        'error' => 'Database error occurred',
        'debug' => [
            'error_message' => $e->getMessage()
        ]
    ]);
} 