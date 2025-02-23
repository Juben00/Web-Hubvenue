<?php
require_once '../dbconnection.php';
header('Content-Type: application/json');

try {
    // Get POST data
    $data = json_decode(file_get_contents('php://input'), true);
    
    if (!isset($data['conversation_id']) || !isset($data['user_id']) || !isset($data['message_ids'])) {
        throw new Exception('Missing required parameters');
    }

    $conversationId = $data['conversation_id'];
    $userId = $data['user_id'];
    $messageIds = $data['message_ids'];

    $db = new Database();
    $conn = $db->connect();

    // Begin transaction
    $conn->beginTransaction();

    try {
        foreach ($messageIds as $messageId) {
            // Check if a status record exists
            $checkStmt = $conn->prepare("
                SELECT id FROM message_status 
                WHERE message_id = ? AND user_id = ?
            ");
            $checkStmt->execute([$messageId, $userId]);
            $existingStatus = $checkStmt->fetch(PDO::FETCH_ASSOC);

            if ($existingStatus) {
                // Update existing status
                $updateStmt = $conn->prepare("
                    UPDATE message_status 
                    SET is_read = 1 
                    WHERE message_id = ? AND user_id = ?
                ");
                $updateStmt->execute([$messageId, $userId]);
            } else {
                // Create new status record
                $insertStmt = $conn->prepare("
                    INSERT INTO message_status (message_id, user_id, is_read) 
                    VALUES (?, ?, 1)
                ");
                $insertStmt->execute([$messageId, $userId]);
            }
        }

        // Commit transaction
        $conn->commit();

        echo json_encode([
            'success' => true,
            'message' => 'Messages marked as read successfully'
        ]);
    } catch (Exception $e) {
        // Rollback transaction on error
        $conn->rollBack();
        throw $e;
    }
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
} 