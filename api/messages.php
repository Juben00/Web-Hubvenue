<?php
// Prevent any output before headers
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Set headers for JSON response
header('Content-Type: application/json');
header('Cache-Control: no-cache, must-revalidate');

// Helper function to send JSON response
function sendResponse($data, $statusCode = 200) {
    http_response_code($statusCode);
    echo json_encode($data);
    exit;
}

// Get database connection
try {
    require_once '../dbconnection.php';
    $db = new Database();
    $conn = $db->connect();
    
    if (!$conn) {
        error_log("Failed to connect to database");
        sendResponse(['error' => 'Database connection failed'], 500);
    }
    
    // Set error mode to throw exceptions
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    error_log("Database connection error: " . $e->getMessage());
    sendResponse(['error' => 'Database connection failed'], 500);
}

// Debug logging
error_log("Request Method: " . $_SERVER['REQUEST_METHOD']);
error_log("Raw input: " . file_get_contents('php://input'));

// Get the request method
$method = $_SERVER['REQUEST_METHOD'];

// Handle different request methods
switch ($method) {
    case 'GET':
        if (isset($_GET['action'])) {
            switch ($_GET['action']) {
                case 'get_booking_conversations':
                    try {
                        // Get conversations based on bookings for a user
                        $userId = isset($_GET['user_id']) ? (int)$_GET['user_id'] : null;
                        
                        if (!$userId) {
                            sendResponse(['success' => false, 'error' => 'User ID is required'], 400);
                        }
                        
                        // Debug logging
                        error_log("Getting conversations for user ID: " . $userId);
                        
                        // Get user type (host or guest)
                        $userTypeQuery = "SELECT user_type_id FROM users WHERE id = ?";
                        $stmt = $conn->prepare($userTypeQuery);
                        $stmt->execute([$userId]);
                        $userTypeResult = $stmt->fetch(PDO::FETCH_ASSOC);
                        
                        if (!$userTypeResult) {
                            sendResponse(['success' => false, 'error' => 'User not found'], 404);
                        }
                        
                        $userType = $userTypeResult['user_type_id'];
                        
                        error_log("User type: " . $userType); // Debug logging
                        
                        // Different queries for hosts and guests
                        if ($userType == 1) { // Host
                            $query = "
                                SELECT DISTINCT
                                    b.id as booking_id,
                                    b.booking_guest_id as guest_id,
                                    b.booking_venue_id as venue_id,
                                    b.booking_status_id,
                                    u.firstname as guest_firstname,
                                    u.lastname as guest_lastname,
                                    u.profile_pic as guest_profile_pic,
                                    v.name as venue_name,
                                    c.id as conversation_id,
                                    COALESCE(c.name, v.name) as conversation_name,
                                    (
                                        SELECT content 
                                        FROM messages 
                                        WHERE conversation_id = c.id 
                                        ORDER BY created_at DESC 
                                        LIMIT 1
                                    ) as last_message,
                                    (
                                        SELECT COUNT(*) 
                                        FROM messages m
                                        LEFT JOIN message_status ms ON m.id = ms.message_id AND ms.user_id = :host_id
                                        WHERE m.conversation_id = c.id 
                                        AND m.sender_id != :host_id
                                        AND (ms.is_read IS NULL OR ms.is_read = 0)
                                    ) as unread_count
                                FROM bookings b
                                JOIN users u ON b.booking_guest_id = u.id
                                JOIN venues v ON b.booking_venue_id = v.id
                                LEFT JOIN conversations c ON b.id = c.booking_id
                                WHERE v.host_id = :host_id 
                                AND b.booking_status_id IN (1, 2, 3, 4)
                                ORDER BY b.booking_created_at DESC
                            ";
                            
                            $stmt = $conn->prepare($query);
                            $stmt->execute(['host_id' => $userId]);
                        } else { // Guest
                            $query = "
                                SELECT DISTINCT
                                    b.id as booking_id,
                                    v.host_id,
                                    b.booking_venue_id as venue_id,
                                    b.booking_status_id,
                                    h.firstname as host_firstname,
                                    h.lastname as host_lastname,
                                    h.profile_pic as host_profile_pic,
                                    v.name as venue_name,
                                    c.id as conversation_id,
                                    COALESCE(c.name, v.name) as conversation_name,
                                    (
                                        SELECT content 
                                        FROM messages 
                                        WHERE conversation_id = c.id 
                                        ORDER BY created_at DESC 
                                        LIMIT 1
                                    ) as last_message,
                                    (
                                        SELECT COUNT(*) 
                                        FROM messages m
                                        LEFT JOIN message_status ms ON m.id = ms.message_id AND ms.user_id = :guest_id
                                        WHERE m.conversation_id = c.id 
                                        AND m.sender_id != :guest_id
                                        AND (ms.is_read IS NULL OR ms.is_read = 0)
                                    ) as unread_count
                                FROM bookings b
                                JOIN venues v ON b.booking_venue_id = v.id
                                JOIN users h ON v.host_id = h.id
                                LEFT JOIN conversations c ON b.id = c.booking_id
                                WHERE b.booking_guest_id = :guest_id
                                AND b.booking_status_id IN (1, 2, 3, 4)
                                ORDER BY b.booking_created_at DESC
                            ";
                            
                            $stmt = $conn->prepare($query);
                            $stmt->execute(['guest_id' => $userId]);
                        }
                        
                        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                        error_log("Found " . count($result) . " conversations"); // Debug logging
                        
                        $conversations = [];
                        foreach ($result as $row) {
                            $conversations[] = [
                                'booking_id' => (int)$row['booking_id'],
                                'venue_id' => (int)$row['venue_id'],
                                'conversation_id' => (int)$row['conversation_id'],
                                'unread_count' => (int)$row['unread_count'],
                                'last_message' => $row['last_message'],
                                'venue_name' => $row['venue_name'],
                                'booking_status_id' => (int)$row['booking_status_id']
                            ];
                        }
                        
                        sendResponse(['success' => true, 'conversations' => $conversations]);
                    } catch (Exception $e) {
                        error_log("Error in get_booking_conversations: " . $e->getMessage());
                        sendResponse(['success' => false, 'error' => 'Failed to fetch conversations'], 500);
                    }
                    break;

                case 'get_messages':
                    // Get messages for a specific conversation
                    $conversationId = isset($_GET['conversation_id']) ? (int)$_GET['conversation_id'] : null;
                    
                    if (!$conversationId) {
                        sendResponse(['error' => 'Conversation ID is required'], 400);
                    }
                    
                    $query = "
                        SELECT 
                            m.*,
                            u.firstname as sender_firstname,
                            u.lastname as sender_lastname,
                            u.profile_pic,
                            u.user_type_id as sender_type,
                            b.booking_status_id,
                            b.id as booking_id,
                            v.name as venue_name,
                            v.host_id,
                            (
                                SELECT COUNT(*)
                                FROM message_status ms
                                WHERE ms.message_id = m.id
                                AND ms.is_read = 1
                            ) as read_count,
                            (
                                SELECT COUNT(*)
                                FROM conversation_participants cp
                                WHERE cp.conversation_id = m.conversation_id
                                AND cp.user_id != m.sender_id
                            ) as recipient_count
                        FROM messages m
                        JOIN users u ON m.sender_id = u.id
                        JOIN conversations c ON m.conversation_id = c.id
                        JOIN bookings b ON c.booking_id = b.id
                        JOIN venues v ON b.booking_venue_id = v.id
                        WHERE m.conversation_id = ?
                        ORDER BY m.created_at ASC
                    ";
                    
                    $stmt = $conn->prepare($query);
                    $stmt->execute([$conversationId]);
                    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    
                    $messages = [];
                    foreach ($result as $row) {
                        $messageStatus = 'sent'; // Default status
                        if ((int)$row['read_count'] === (int)$row['recipient_count']) {
                            $messageStatus = 'delivered';
                        } elseif ((int)$row['read_count'] > 0) {
                            $messageStatus = 'seen';
                        }

                        $messages[] = [
                            'id' => (int)$row['id'],
                            'conversation_id' => (int)$row['conversation_id'],
                            'sender_id' => (int)$row['sender_id'],
                            'sender_name' => $row['sender_firstname'] . ' ' . $row['sender_lastname'],
                            'sender_type' => (int)$row['sender_type'],
                            'content' => $row['content'],
                            'created_at' => $row['created_at'],
                            'profile_picture' => $row['profile_pic'],
                            'booking_status' => (int)$row['booking_status_id'],
                            'venue_name' => $row['venue_name'],
                            'is_host' => (int)$row['sender_id'] === (int)$row['host_id'],
                            'status' => $messageStatus,
                            'read_count' => (int)$row['read_count'],
                            'recipient_count' => (int)$row['recipient_count']
                        ];
                    }
                    
                    sendResponse(['success' => true, 'messages' => $messages]);
                    break;

                case 'get_conversation_details':
                    // Get details of a specific conversation
                    $conversationId = isset($_GET['conversation_id']) ? (int)$_GET['conversation_id'] : null;
                    
                    if (!$conversationId) {
                        sendResponse(['error' => 'Conversation ID is required'], 400);
                    }
                    
                    $query = "
                        SELECT 
                            c.*,
                            b.booking_venue_id,
                            b.booking_status_id,
                            b.booking_start_date,
                            b.booking_end_date,
                            b.booking_duration,
                            b.booking_participants,
                            b.booking_request,
                            b.booking_original_price,
                            b.booking_grand_total,
                            v.name as venue_name,
                            v.host_id,
                            v.address as venue_address,
                            h.firstname as host_firstname,
                            h.lastname as host_lastname,
                            h.profile_pic as host_profile_pic,
                            g.firstname as guest_firstname,
                            g.lastname as guest_lastname,
                            g.profile_pic as guest_profile_pic,
                            g.email as guest_email
                        FROM conversations c
                        JOIN bookings b ON c.booking_id = b.id
                        JOIN venues v ON b.booking_venue_id = v.id
                        JOIN users h ON v.host_id = h.id
                        JOIN users g ON b.booking_guest_id = g.id
                        WHERE c.id = ?
                    ";
                    
                    $stmt = $conn->prepare($query);
                    $stmt->execute([$conversationId]);
                    $result = $stmt->fetch(PDO::FETCH_ASSOC);
                    
                    if (!$result) {
                        sendResponse(['error' => 'Conversation not found'], 404);
                    }
                    
                    sendResponse([
                        'success' => true,
                        'conversation' => [
                            'id' => (int)$result['id'],
                            'booking_id' => (int)$result['booking_id'],
                            'venue_id' => (int)$result['booking_venue_id'],
                            'venue_name' => $result['venue_name'],
                            'venue_address' => $result['venue_address'],
                            'booking_status' => (int)$result['booking_status_id'],
                            'booking_details' => [
                                'start_date' => $result['booking_start_date'],
                                'end_date' => $result['booking_end_date'],
                                'duration' => (int)$result['booking_duration'],
                                'participants' => (int)$result['booking_participants'],
                                'request' => $result['booking_request'],
                                'original_price' => (float)$result['booking_original_price'],
                                'grand_total' => (float)$result['booking_grand_total']
                            ],
                            'host' => [
                                'id' => (int)$result['host_id'],
                                'name' => $result['host_firstname'] . ' ' . $result['host_lastname'],
                                'profile_picture' => $result['host_profile_pic']
                            ],
                            'guest' => [
                                'name' => $result['guest_firstname'] . ' ' . $result['guest_lastname'],
                                'profile_picture' => $result['guest_profile_pic'],
                                'email' => $result['guest_email']
                            ],
                            'created_at' => $result['created_at']
                        ]
                    ]);
                    break;

                case 'get_or_create_conversation':
                    $data = json_decode(file_get_contents('php://input'), true);
                    $bookingId = isset($data['booking_id']) ? (int)$data['booking_id'] : null;
                    $venueId = isset($data['venue_id']) ? (int)$data['venue_id'] : null;
                    $guestId = isset($data['guest_id']) ? (int)$data['guest_id'] : null;
                    $hostId = isset($data['host_id']) ? (int)$data['host_id'] : null;
                    
                    if (!$bookingId || !$venueId || !$guestId || !$hostId) {
                        sendResponse(['error' => 'Missing required fields'], 400);
                    }
                    
                    // Check if conversation exists
                    $stmt = $conn->prepare("SELECT id FROM conversations WHERE booking_id = ?");
                    $stmt->execute([$bookingId]);
                    $conversation = $stmt->fetch(PDO::FETCH_ASSOC);
                    
                    if ($conversation) {
                        // Return existing conversation
                        error_log("Found existing conversation: " . $conversation['id']);
                        sendResponse(['success' => true, 'conversation_id' => $conversation['id']]);
                    } else {
                        // Create new conversation
                        $stmt = $conn->prepare("INSERT INTO conversations (booking_id, type) VALUES (?, 'booking')");
                        $stmt->execute([$bookingId]);
                        $conversationId = $conn->lastInsertId();
                        error_log("Created new conversation: " . $conversationId);

                        // Add participants
                        $stmt = $conn->prepare("INSERT INTO conversation_participants (conversation_id, user_id, role) 
                                              VALUES (?, ?, 'member'), (?, ?, 'member')");
                        $stmt->execute([$conversationId, $hostId, $conversationId, $guestId]);

                        error_log("Added participants successfully");
                        sendResponse(['success' => true, 'conversation_id' => $conversationId]);
                    }
                    break;
            }
        }
        break;

    case 'POST':
        $input = file_get_contents('php://input');
        $data = json_decode($input, true);
        error_log("POST Data: " . print_r($data, true));

        if (!isset($data['action'])) {
            error_log("No action specified in POST data");
            sendResponse(['error' => 'No action specified'], 400);
        }

        switch ($data['action']) {
            case 'send_message':
                try {
                    // Validate required fields
                    $conversationId = isset($data['conversation_id']) ? (int)$data['conversation_id'] : null;
                    $senderId = isset($data['sender_id']) ? (int)$data['sender_id'] : null;
                    $content = isset($data['content']) ? trim($data['content']) : null;

                    error_log("Processing message - Conversation ID: $conversationId, Sender ID: $senderId");

                    if (!$conversationId || !$senderId || !$content) {
                        error_log("Missing required fields: " . print_r($data, true));
                        sendResponse(['error' => 'Missing required fields'], 400);
                    }

                    // Start transaction
                    $conn->beginTransaction();

                    try {
                        // Verify sender is a participant
                        $stmt = $conn->prepare("SELECT id FROM conversation_participants WHERE conversation_id = ? AND user_id = ?");
                        $stmt->execute([$conversationId, $senderId]);

                        if ($stmt->rowCount() === 0) {
                            throw new Exception('User is not a participant in this conversation');
                        }

                        // Insert message
                        $stmt = $conn->prepare("INSERT INTO messages (conversation_id, sender_id, content, type) VALUES (?, ?, ?, 'text')");
                        if (!$stmt->execute([$conversationId, $senderId, $content])) {
                            throw new Exception('Failed to insert message');
                        }

                        $messageId = $conn->lastInsertId();
                        error_log("Message inserted with ID: $messageId");

                        // Get all participants except sender
                        $stmt = $conn->prepare("
                            SELECT user_id 
                            FROM conversation_participants 
                            WHERE conversation_id = ? AND user_id != ?
                        ");
                        $stmt->execute([$conversationId, $senderId]);
                        $participants = $stmt->fetchAll(PDO::FETCH_COLUMN);

                        // Create message status records for all participants
                        foreach ($participants as $participantId) {
                            $stmt = $conn->prepare("
                                INSERT INTO message_status (message_id, user_id, is_read)
                                VALUES (?, ?, 0)
                            ");
                            $stmt->execute([$messageId, $participantId]);
                        }

                        // Create a read status for sender (marked as read)
                        $stmt = $conn->prepare("
                            INSERT INTO message_status (message_id, user_id, is_read)
                            VALUES (?, ?, 1)
                        ");
                        $stmt->execute([$messageId, $senderId]);

                        $conn->commit();
                        error_log("Message transaction committed successfully");

                        sendResponse([
                            'success' => true,
                            'message_id' => $messageId,
                            'conversation_id' => $conversationId
                        ]);

                    } catch (Exception $e) {
                        $conn->rollBack();
                        error_log("Transaction error: " . $e->getMessage());
                        sendResponse(['error' => $e->getMessage()], 500);
                    }

                } catch (Exception $e) {
                    error_log("Message sending error: " . $e->getMessage());
                    sendResponse(['error' => 'Failed to send message'], 500);
                }
                break;

            case 'get_or_create_conversation':
                try {
                    // Validate required fields
                    $booking_id = isset($data['booking_id']) ? (int)$data['booking_id'] : null;
                    $venue_id = isset($data['venue_id']) ? (int)$data['venue_id'] : null;
                    $guest_id = isset($data['guest_id']) ? (int)$data['guest_id'] : null;
                    $host_id = isset($data['host_id']) ? (int)$data['host_id'] : null;

                    error_log("Processing conversation for booking_id: $booking_id, venue_id: $venue_id, guest_id: $guest_id, host_id: $host_id");

                    if (!$booking_id || !$venue_id || !$guest_id || !$host_id) {
                        error_log("Missing required fields");
                        sendResponse(['error' => 'Missing required fields', 'received' => $data], 400);
                    }

                    // Check if conversation exists
                    $stmt = $conn->prepare("SELECT id FROM conversations WHERE booking_id = ?");
                    if (!$stmt) {
                        error_log("Failed to prepare statement: " . $conn->error);
                        sendResponse(['error' => 'Database error'], 500);
                    }
                    
                    $stmt->execute([$booking_id]);
                    $conversation = $stmt->fetch(PDO::FETCH_ASSOC);
                    
                    if ($conversation) {
                        // Return existing conversation
                        error_log("Found existing conversation: " . $conversation['id']);
                        sendResponse(['success' => true, 'conversation_id' => $conversation['id']]);
                    } else {
                        // Create new conversation
                        $stmt = $conn->prepare("INSERT INTO conversations (booking_id, type) VALUES (?, 'booking')");
                        if (!$stmt) {
                            error_log("Failed to prepare insert statement: " . $conn->error);
                            sendResponse(['error' => 'Database error'], 500);
                        }
                        
                        $stmt->execute([$booking_id]);
                        $conversation_id = $conn->lastInsertId();
                        error_log("Created new conversation: " . $conversation_id);

                        // Add participants
                        $stmt = $conn->prepare("INSERT INTO conversation_participants (conversation_id, user_id, role) 
                                              VALUES (?, ?, 'member'), (?, ?, 'member')");
                        if (!$stmt) {
                            error_log("Failed to prepare participants statement: " . $conn->error);
                            sendResponse(['error' => 'Database error'], 500);
                        }
                        
                        $stmt->execute([$conversation_id, $host_id, $conversation_id, $guest_id]);
                        error_log("Added participants - Host: $host_id, Guest: $guest_id");

                        sendResponse(['success' => true, 'conversation_id' => $conversation_id]);
                    }
                } catch (PDOException $e) {
                    error_log("Database error: " . $e->getMessage());
                    sendResponse(['error' => 'Database error occurred', 'details' => $e->getMessage()], 500);
                } catch (Exception $e) {
                    error_log("General error: " . $e->getMessage());
                    sendResponse(['error' => 'Server error occurred', 'details' => $e->getMessage()], 500);
                }
                break;
        }
        break;

    case 'PUT':
        parse_str(file_get_contents('php://input'), $_PUT);
        
        if (!isset($_PUT['action'])) {
            sendResponse(['success' => false, 'error' => 'No action specified'], 400);
        }

        switch ($_PUT['action']) {
            case 'mark_as_read':
                // Mark messages as read
                $messageIds = isset($_PUT['message_ids']) ? json_decode($_PUT['message_ids'], true) : null;
                $userId = isset($_PUT['user_id']) ? (int)$_PUT['user_id'] : null;
                
                // Debug logging
                error_log("Marking messages as read - User ID: " . $userId);
                error_log("Message IDs: " . print_r($messageIds, true));
                
                if (!$messageIds || !$userId) {
                    error_log("Missing required fields - messageIds: " . ($messageIds ? 'yes' : 'no') . ", userId: " . ($userId ? 'yes' : 'no'));
                    sendResponse(['success' => false, 'error' => 'Missing required fields'], 400);
                }

                try {
                    $conn->beginTransaction();

                    // First verify all messages exist
                    $placeholders = str_repeat('?,', count($messageIds) - 1) . '?';
                    $verifyQuery = "SELECT COUNT(*) FROM messages WHERE id IN ($placeholders)";
                    $stmt = $conn->prepare($verifyQuery);
                    $stmt->execute($messageIds);
                    $messageCount = $stmt->fetchColumn();

                    if ($messageCount !== count($messageIds)) {
                        error_log("Not all messages exist - Found: $messageCount, Expected: " . count($messageIds));
                        throw new Exception('Some messages do not exist');
                    }

                    foreach ($messageIds as $messageId) {
                        // Check if status record exists
                        $stmt = $conn->prepare("
                            SELECT id, is_read 
                            FROM message_status 
                            WHERE message_id = ? AND user_id = ?
                        ");
                        $stmt->execute([(int)$messageId, $userId]);
                        $existingStatus = $stmt->fetch(PDO::FETCH_ASSOC);
                        
                        if ($existingStatus) {
                            // Only update if not already read
                            if (!$existingStatus['is_read']) {
                                try {
                                    // Try with read_at first
                                    $stmt = $conn->prepare("
                                        UPDATE message_status 
                                        SET is_read = 1,
                                            read_at = NOW()
                                        WHERE message_id = ? AND user_id = ?
                                    ");
                                    $stmt->execute([(int)$messageId, $userId]);
                                } catch (PDOException $e) {
                                    if ($e->getCode() == '42S22') { // Column not found error
                                        // Fallback to just updating is_read
                                        $stmt = $conn->prepare("
                                            UPDATE message_status 
                                            SET is_read = 1
                                            WHERE message_id = ? AND user_id = ?
                                        ");
                                        $stmt->execute([(int)$messageId, $userId]);
                                    } else {
                                        throw $e; // Re-throw if it's a different error
                                    }
                                }
                                error_log("Updated existing message status for message ID: $messageId");
                            }
                        } else {
                            try {
                                // Try with read_at first
                                $stmt = $conn->prepare("
                                    INSERT INTO message_status (message_id, user_id, is_read, read_at)
                                    VALUES (?, ?, 1, NOW())
                                ");
                                $stmt->execute([(int)$messageId, $userId]);
                            } catch (PDOException $e) {
                                if ($e->getCode() == '42S22') { // Column not found error
                                    // Fallback to insert without read_at
                                    $stmt = $conn->prepare("
                                        INSERT INTO message_status (message_id, user_id, is_read)
                                        VALUES (?, ?, 1)
                                    ");
                                    $stmt->execute([(int)$messageId, $userId]);
                                } else {
                                    throw $e; // Re-throw if it's a different error
                                }
                            }
                            error_log("Inserted new message status for message ID: $messageId");
                        }
                    }

                    $conn->commit();
                    error_log("Successfully marked messages as read");
                    sendResponse(['success' => true, 'message' => 'Messages marked as read']);
                } catch (PDOException $e) {
                    $conn->rollBack();
                    error_log("Database error in mark_as_read: " . $e->getMessage());
                    error_log("SQL State: " . $e->getCode());
                    error_log("Stack trace: " . $e->getTraceAsString());
                    sendResponse(['success' => false, 'error' => 'Database error occurred: ' . $e->getMessage()], 500);
                } catch (Exception $e) {
                    $conn->rollBack();
                    error_log("General error in mark_as_read: " . $e->getMessage());
                    error_log("Stack trace: " . $e->getTraceAsString());
                    sendResponse(['success' => false, 'error' => 'Server error occurred: ' . $e->getMessage()], 500);
                }
                break;

            default:
                sendResponse(['success' => false, 'error' => 'Invalid action'], 400);
                break;
        }
        break;

    default:
        sendResponse(['success' => false, 'error' => 'Invalid request method'], 405);
        break;
}

// Close database connection
$conn = null; 