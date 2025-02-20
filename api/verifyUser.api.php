<?php
require_once(__DIR__ . '/../classes/account.class.php');
require_once(__DIR__ . '/../config/database.php');

header('Content-Type: application/json');

// Get the raw POST data
$data = json_decode(file_get_contents('php://input'), true);

if (!isset($data['userId']) || empty($data['userId'])) {
    echo json_encode([
        'success' => false,
        'message' => 'User ID is required'
    ]);
    exit;
}

try {
    $db = new Database();
    $conn = $db->connect();
    
    $sql = "UPDATE users SET is_Verified = 'Verified' WHERE id = :userId";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':userId', $data['userId']);
    
    if ($stmt->execute()) {
        echo json_encode([
            'success' => true,
            'message' => 'User verified successfully'
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Failed to verify user'
        ]);
    }
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}
?> 