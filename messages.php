<?php
require_once './classes/venue.class.php';
require_once './classes/account.class.php';

require_once './dbconnection.php';
session_start();

$venueObj = new Venue();
$accountObj = new Account();
$USER_ID = isset($_SESSION['user']) ? $_SESSION['user'] : null;
$userType = $accountObj->getUserRole($USER_ID); // This returns "Host" or "Guest"
$HOST_ROLE = "Host";

// Debug output
error_log("Session user data: " . print_r($_SESSION['user'], true));
error_log("User ID: " . $USER_ID . ", User Type: " . $userType);

function getStatusBadge($statusId)
{
    $statusClasses = [
        1 => 'bg-yellow-100 text-yellow-800',
        2 => 'bg-green-100 text-green-800',
        3 => 'bg-red-100 text-red-800',
        4 => 'bg-blue-100 text-blue-800'
    ];

    $statusText = [
        1 => 'Pending',
        2 => 'Confirmed',
        3 => 'Cancelled',
        4 => 'Completed'
    ];

    $class = $statusClasses[$statusId] ?? 'bg-gray-100 text-gray-800';
    $text = $statusText[$statusId] ?? 'Unknown';

    return "<span class='inline-block px-2 py-0.5 rounded-full text-xs font-medium {$class}'>{$text}</span>";
}

try {
    $db = new Database();
    $conn = $db->connect();

    // Debug output
    error_log("User ID: " . $USER_ID . ", User Type: " . $userType);

    // Get all bookings based on user type
    if ($userType == $HOST_ROLE) { // Host
        $query = "SELECT DISTINCT
            b.*, 
            v.id as venue_id,
            v.name as venue_name,
            v.host_id,
            g.firstname as guest_firstname,
            g.lastname as guest_lastname,
            g.profile_pic as guest_profile_pic,
            g.id as guest_id,
            COALESCE((
                SELECT COUNT(*) 
                FROM messages m
                JOIN conversations c ON m.conversation_id = c.id
                LEFT JOIN message_status ms ON m.id = ms.message_id AND ms.user_id = :host_id
                WHERE c.booking_id = b.id 
                AND m.sender_id != :host_id
                AND (ms.is_read = 0 OR ms.is_read IS NULL)
            ), 0) as unread_count,
            (
                SELECT m.created_at
                FROM messages m
                JOIN conversations c ON m.conversation_id = c.id
                WHERE c.booking_id = b.id
                ORDER BY m.created_at DESC
                LIMIT 1
            ) as last_message_at
        FROM bookings b
        JOIN venues v ON b.booking_venue_id = v.id
        JOIN users g ON b.booking_guest_id = g.id
        LEFT JOIN conversations c ON c.booking_id = b.id
        LEFT JOIN conversation_participants cp1 ON c.id = cp1.conversation_id AND cp1.user_id = :host_id
        LEFT JOIN conversation_participants cp2 ON c.id = cp2.conversation_id AND cp2.user_id = g.id
        WHERE v.host_id = :host_id
        AND b.booking_status_id = 2  /* Only Confirmed status */
        AND b.booking_payment_status_id = 2  /* Only Paid status */
        GROUP BY b.id, g.id, v.id, v.name, v.host_id, g.firstname, g.lastname, g.profile_pic  /* Include all selected columns */
        ORDER BY unread_count DESC, last_message_at DESC";

        // Debug output for host query
        error_log("Executing host query with user ID: " . $USER_ID);
        error_log("Full SQL Query: " . str_replace(':host_id', $USER_ID, $query));
        
        $stmt = $conn->prepare($query);
        $stmt->execute(['host_id' => $USER_ID]);
        $bookings = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        // Debug output for results
        error_log("Host query results count: " . count($bookings));
        foreach ($bookings as $booking) {
            error_log("Found booking - ID: " . $booking['id'] . 
                     ", Guest: " . $booking['guest_firstname'] . " " . $booking['guest_lastname'] . 
                     ", Venue: " . $booking['venue_name'] . 
                     ", Status: " . $booking['booking_status_id'] . 
                     ", Payment: " . $booking['booking_payment_status_id']);
        }
    } else { // Guest
        $query = "SELECT DISTINCT
            b.*, 
            v.id as venue_id,
            v.name as venue_name,
            v.host_id,
            h.firstname as host_firstname,
            h.lastname as host_lastname,
            h.profile_pic as host_profile_pic,
            COALESCE((
                SELECT COUNT(*) 
                FROM messages m
                JOIN conversations c ON m.conversation_id = c.id
                LEFT JOIN message_status ms ON m.id = ms.message_id AND ms.user_id = :guest_id
                WHERE c.booking_id = b.id 
                AND m.sender_id != :guest_id
                AND (ms.is_read = 0 OR ms.is_read IS NULL)
            ), 0) as unread_count,
            (
                SELECT m.created_at
                FROM messages m
                JOIN conversations c ON m.conversation_id = c.id
                WHERE c.booking_id = b.id
                ORDER BY m.created_at DESC
                LIMIT 1
            ) as last_message_at
        FROM bookings b
        JOIN venues v ON b.booking_venue_id = v.id
        JOIN users h ON v.host_id = h.id
        LEFT JOIN conversations c ON c.booking_id = b.id
        LEFT JOIN conversation_participants cp1 ON c.id = cp1.conversation_id AND cp1.user_id = :guest_id
        LEFT JOIN conversation_participants cp2 ON c.id = cp2.conversation_id AND cp2.user_id = h.id
        WHERE b.booking_guest_id = :guest_id
        AND b.booking_status_id = 2  /* Only Confirmed status */
        AND b.booking_payment_status_id = 2  /* Only Paid status */
        GROUP BY b.id, h.id  /* Group by booking and host to prevent duplicates */
        ORDER BY unread_count DESC, last_message_at DESC";

        $stmt = $conn->prepare($query);
        $stmt->execute(['guest_id' => $USER_ID]);
        $bookings = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Debug output
    error_log("User ID: " . $USER_ID . ", User Type: " . $userType);
    error_log("Bookings found: " . count($bookings));
    foreach ($bookings as $booking) {
        error_log("Booking ID: " . $booking['id'] . 
                 ", Status: " . $booking['booking_status_id'] . 
                 ", Payment Status: " . $booking['booking_payment_status_id'] . 
                 ", Venue ID: " . $booking['venue_id'] .
                 ", Host ID: " . $booking['host_id']);
    }

    // Group bookings by user to prevent duplicates
    $uniqueUsers = [];
    foreach ($bookings as $booking) {
        if ($userType == $HOST_ROLE) { // Host view
            $userKey = $booking['guest_id'];
            $userName = $booking['guest_firstname'] . ' ' . $booking['guest_lastname'];
            $guestId = $booking['guest_id'];
            $hostId = $USER_ID;
            $venueId = $booking['venue_id'];
            $venueName = $booking['venue_name'];
            $profilePic = $booking['guest_profile_pic'];
        } else { // Guest view
            $userKey = $booking['host_id'];
            $userName = $booking['host_firstname'] . ' ' . $booking['host_lastname'];
            $guestId = $USER_ID;
            $hostId = $booking['host_id'];
            $venueId = $booking['venue_id'];
            $venueName = $booking['venue_name'];
            $profilePic = $booking['host_profile_pic'];
        }

        // Debug output
        error_log("Processing booking for user: " . $userName . 
                 ", Guest ID: " . $guestId . 
                 ", Host ID: " . $hostId . 
                 ", Venue ID: " . $venueId);

        // If this user isn't in our array yet, or if this booking is more recent, update it
        if (
            !isset($uniqueUsers[$userKey]) ||
            strtotime($booking['last_message_at']) > strtotime($uniqueUsers[$userKey]['last_message_at'])
        ) {
            $uniqueUsers[$userKey] = [
                'booking_id' => $booking['id'],
                'venue_id' => $venueId,
                'venue_name' => $venueName,
                'guest_id' => $guestId,
                'host_id' => $hostId,
                'display_name' => $userName,
                'profile_pic' => $profilePic,
                'last_message_at' => $booking['last_message_at'],
                'booking_status_id' => $booking['booking_status_id'],
                'name' => $venueName,
                'unread_count' => (int) $booking['unread_count']
            ];

            // Debug output for unread counts and conversation data
            error_log("Added/Updated user in uniqueUsers array: " . json_encode($uniqueUsers[$userKey]));
        }
    }

    // Sort by most recent booking
    usort($uniqueUsers, function ($a, $b) {
        return strtotime($b['last_message_at']) - strtotime($a['last_message_at']);
    });

} catch (PDOException $e) {
    error_log("Database error: " . $e->getMessage());
    $uniqueUsers = [];
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HubVenue || Messages</title>
    <link rel="icon" href="./images/black_ico.png">
    <link rel="stylesheet" href="./output.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/luxon@3.3.0/build/global/luxon.min.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    <script src="//unpkg.com/alpinejs" defer></script>
</head>

<body class="bg-gray-50">
    <!-- Header -->
    <?php
    // Check if the 'user' key exists in the session
    if (isset($_SESSION['user'])) {
        require_once './components/navbar.logged.in.php';
    } else {
        require_once './components/navbar.html';
    }

    require_once './components/SignupForm.html';
    require_once './components/feedback.modal.html';
    require_once './components/confirm.feedback.modal.html';
    require_once './components/Menu.html';
    ?>

    <div class="fixed mt-24 inset-0 pb-4 px-4">
        <div class="bg-white rounded-lg shadow w-full h-full max-w-7xl mx-auto overflow-hidden">
            <div class="flex h-full">
                <!-- Messages List -->
                <div class="w-[350px] flex flex-col border-r flex-shrink-0 h-full">
                    <div class="p-4 border-b bg-white">
                        <div class="relative">
                            <input type="text" id="searchMessages"
                                class="w-full pl-4 pr-10 py-2 h-10 border rounded-lg text-sm bg-gray-50"
                                placeholder="Search messages">
                            <svg class="w-4 h-4 absolute right-3 top-1/2 -translate-y-1/2 text-gray-400" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                    </div>

                    <!-- Conversations List -->
                    <div id="conversationsList" class="flex-1 overflow-y-auto custom-scrollbar">
                        <?php if (empty($uniqueUsers)): ?>
                            <div class="flex items-center justify-center h-full p-6 text-center text-gray-500">
                                <div>
                                    <p>No conversations yet</p>
                                    <p class="text-sm">Your booking conversations will appear here</p>
                                </div>
                            </div>
                        <?php else: ?>
                            <?php foreach ($uniqueUsers as $user): ?>
                                <?php
                                // Debug output
                                error_log("Rendering conversation for user: " . $user['display_name'] . " with unread count: " . $user['unread_count']);
                                ?>
                                <div class="conversation-item hover:bg-gray-50 cursor-pointer border-b relative <?php echo ((int) $user['unread_count'] > 0) ? 'bg-blue-50' : ''; ?>"
                                    data-booking-id="<?php echo htmlspecialchars($user['booking_id']); ?>"
                                    data-venue-id="<?php echo htmlspecialchars($user['venue_id']); ?>"
                                    data-guest-id="<?php echo htmlspecialchars($user['guest_id']); ?>"
                                    data-host-id="<?php echo htmlspecialchars($user['host_id']); ?>"
                                    data-unread-count="<?php echo htmlspecialchars($user['unread_count']); ?>"
                                    onclick="loadConversation(this)">
                                    <div class="p-4">
                                        <div class="flex justify-between items-start mb-2">
                                            <div class="flex items-center space-x-3">
                                                <!-- Profile Picture Container -->
                                                <div class="relative">
                                                    <div class="h-10 w-10 rounded-full bg-black text-white flex items-center justify-center overflow-hidden">
                                                        <?php if (!isset($user['profile_pic']) || empty($user['profile_pic'])): ?>
                                                            <span class="text-lg font-medium"><?php echo strtoupper(substr($user['display_name'], 0, 1)); ?></span>
                                                        <?php else: ?>
                                                            <img src="./<?php echo htmlspecialchars($user['profile_pic']); ?>" alt="Profile" class="w-full h-full object-cover">
                                                        <?php endif; ?>
                                                    </div>
                                                    <?php if ((int) $user['unread_count'] > 0): ?>
                                                        <div class="absolute bottom-0 right-0 bg-red-500 text-white text-xs font-bold rounded-full min-w-[16px] h-[16px] flex items-center justify-center unread-badge">
                                                            <?php echo (int) $user['unread_count']; ?>
                                                        </div>
                                                    <?php endif; ?>
                                                </div>
                                                <div>
                                                    <h4 class="font-medium text-sm text-gray-900"><?php echo htmlspecialchars($user['display_name']); ?></h4>
                                                    <p class="text-sm text-gray-600"><?php echo htmlspecialchars($user['venue_name']); ?></p>
                                                </div>
                                            </div>
                                            <div class="flex flex-col items-end">
                                                <span class="text-xs text-gray-500">
                                                    <?php echo date('M j, Y', strtotime($user['last_message_at'])); ?>
                                                </span>
                                                <?php echo getStatusBadge($user['booking_status_id']); ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>

                    <!-- Add this right after the conversation list to show debug info -->
                    <?php if (isset($_SESSION['debug']) && $_SESSION['debug']): ?>
                        <div class="p-4 bg-gray-100 border-t text-xs">
                            <p>Debug Info:</p>
                            <?php foreach ($uniqueUsers as $user): ?>
                                <div>
                                    User: <?php echo $user['display_name']; ?> -
                                    Unread: <?php echo $user['unread_count']; ?>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Message Content -->
                <div class="flex-1 flex flex-col h-full">
                    <!-- Chat Header -->
                    <div id="chatHeader" class="p-4 border-b flex items-center justify-between bg-white hidden">
                        <div class="flex items-center space-x-3">
                            <!-- Profile Picture -->
                            <div class="h-12 w-12 rounded-full bg-black text-white flex items-center justify-center overflow-hidden">
                                <span id="chatProfilePic">
                                    <?php if ($userType == $HOST_ROLE): // Host view ?>
                                        <?php if (!isset($booking['guest_profile_pic']) || empty($booking['guest_profile_pic'])): ?>
                                            <span class="text-lg font-medium"><?php echo strtoupper(substr($booking['guest_firstname'], 0, 1)); ?></span>
                                        <?php else: ?>
                                            <img src="./<?php echo htmlspecialchars($booking['guest_profile_pic']); ?>" alt="Profile" class="w-full h-full object-cover">
                                        <?php endif; ?>
                                    <?php else: // Guest view ?>
                                        <?php if (!isset($booking['host_profile_pic']) || empty($booking['host_profile_pic'])): ?>
                                            <span class="text-lg font-medium"><?php echo strtoupper(substr($booking['host_firstname'], 0, 1)); ?></span>
                                        <?php else: ?>
                                            <img src="./<?php echo htmlspecialchars($booking['host_profile_pic']); ?>" alt="Profile" class="w-full h-full object-cover">
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </span>
                            </div>
                            <div>
                                <h3 id="chatName" class="font-medium text-gray-900"></h3>
                                <p id="chatVenue" class="text-sm text-gray-600"></p>
                            </div>
                        </div>
                        <span id="chatStatus" class="px-2 py-0.5 text-xs rounded-full"></span>
                    </div>

                    <!-- Messages Container -->
                    <div id="messagesContainer" class="flex-1 overflow-y-auto overflow-x-hidden p-4 space-y-3 custom-scrollbar">
                        <!-- Messages will be inserted here -->
                        <div id="emptyState" class="flex items-center justify-center h-full text-center text-gray-500">
                            <div>
                                <svg class="w-16 h-16 mx-auto mb-4 text-gray-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z">
                                    </path>
                                </svg>
                                <h3 class="text-xl font-medium mb-2">Select a conversation</h3>
                                <p>Choose a booking conversation to start messaging</p>
                            </div>
                        </div>
                    </div>

                    <!-- Scroll to Bottom Button - Moved to a wrapper div -->
                    <div class="scroll-button-wrapper">
                        <button id="scrollToBottomBtn" class="scroll-to-bottom-btn hidden">
                            <div class="flex items-center gap-2">
                                <span id="newMessageCount" class="new-message-count hidden">0</span>
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/>
                                </svg>
                            </div>
                        </button>
                    </div>

                    <!-- Message Input -->
                    <div id="messageInputContainer" class="px-4 py-3 border-t bg-white hidden">
                        <!-- Add reply container here -->
                        <div id="replyContainer" class="reply-container hidden">
                            <div class="flex items-center justify-between p-2 bg-gray-50">
                                <div class="flex items-center space-x-2">
                                    <div class="w-1 h-full bg-blue-500 rounded"></div>
                                    <div class="flex-1 min-w-0">
                                        <div class="text-sm font-medium text-gray-900">Replying to</div>
                                        <div id="replyPreview" class="text-sm text-gray-500 truncate"></div>
                                    </div>
                                </div>
                                <button onclick="cancelReply()" class="p-1 text-gray-400 hover:text-gray-600 rounded-full hover:bg-gray-100">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                </button>
                            </div>
                        </div>
                        <form id="messageForm" class="flex items-center space-x-2">
                            <div class="flex-1 relative">
                                <input type="text" id="messageInput"
                                    class="w-full pl-4 pr-12 py-3 border rounded-lg focus:outline-none focus:border-blue-500 bg-gray-50"
                                    placeholder="Type your message...">
                                <button type="submit"
                                    class="absolute right-2 top-1/2 -translate-y-1/2 p-2 text-blue-600 hover:bg-gray-100 rounded-full transition-colors duration-150">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="M10.894 2.553a1 1 0 00-1.788 0l-7 14a1 1 0 001.169 1.409l5-1.429A1 1 0 009 15.571V11a1 1 0 112 0v4.571a1 1 0 00.725.962l5 1.428a1 1 0 001.17-1.408l-7-14z">
                                        </path>
                                    </svg>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        /* Custom Scrollbar Styling */
        .custom-scrollbar {
            scrollbar-width: thin;
            scrollbar-color: rgba(203, 213, 225, 1) transparent;
        }

        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: transparent;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background-color: rgba(203, 213, 225, 1);
            border-radius: 20px;
            border: transparent;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background-color: rgba(148, 163, 184, 1);
        }

        /* Enhanced Unread Badge Styling */
        .unread-badge {
            box-shadow: 0 0 0 1.5px white;
            padding: 0 4px;
            z-index: 10;
            transform: translate(-15%, -15%);
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% {
                transform: translate(-15%, -15%) scale(1);
                box-shadow: 0 0 0 1.5px white;
            }
            50% {
                transform: translate(-15%, -15%) scale(1.05);
                box-shadow: 0 0 0 2px white;
            }
            100% {
                transform: translate(-15%, -15%) scale(1);
                box-shadow: 0 0 0 1.5px white;
            }
        }

        /* Conversation item with unread messages */
        .conversation-item.has-unread {
            background-color: #EBF5FF !important;
            /* Light blue background */
            position: relative;
        }

        .conversation-item.has-unread::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 4px;
            background-color: #EF4444;
            /* Red indicator line */
        }

        /* New Message Indicator */
        .new-message-indicator {
            position: absolute;
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%);
            background-color: #3B82F6;
            color: white;
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 0.875rem;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            cursor: pointer;
            display: none;
            z-index: 10;
            animation: fadeIn 0.3s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translate(-50%, 10px);
            }

            to {
                opacity: 1;
                transform: translate(-50%, 0);
            }
        }

        /* Update scroll to bottom button styles */
        .scroll-button-wrapper {
            position: absolute;
            bottom: 100px; /* Position above the message input */
            right: 10px;
            z-index: 50;
            left: 450px;
            pointer-events: none; /* Allow clicks to pass through the wrapper */
        }

        .scroll-to-bottom-btn {
            background-color: white;
            color: #4B5563;
            padding: 8px 12px;
            border-radius: 20px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.2s ease;
            border: 1px solid #E5E7EB;
            pointer-events: auto; /* Re-enable clicks for the button */
        }

        .scroll-to-bottom-btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            background-color: #F9FAFB;
        }

        .scroll-to-bottom-btn.hidden {
            opacity: 0;
            pointer-events: none;
            transform: translateY(10px);
            display: none;
        }

        /* Message container parent */
        .flex-1.flex.flex-col.h-full {
            position: relative; /* This is important for absolute positioning of the button wrapper */
        }

        #messagesContainer {
            position: relative;
            height: 100%;
            overflow-y: auto;
            overflow-x: hidden;
            padding-bottom: 20px;
        }

        .message-wrapper {
            width: 100%;
            padding-right: 16px;
        }

        /* Ensure proper stacking context */
        #messageInputContainer {
            position: relative;
            z-index: 99;
            background-color: white;
        }

        #chatHeader {
            position: relative;
            z-index: 99;
            background-color: white;
        }

        /* Update animation for the button */
        @keyframes bounce {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-3px); }
        }

        .scroll-to-bottom-btn.has-new-messages {
            animation: bounce 1s infinite;
        }

        .new-message-count {
            background-color: #EF4444;
            color: white;
            padding: 2px 6px;
            border-radius: 10px;
            font-size: 12px;
            font-weight: 600;
            margin-right: 4px;
        }

        .new-message-count.hidden {
            display: none;
        }

        /* Reply Container Styles */
        .reply-container {
            border-bottom: 1px solid #E5E7EB;
            animation: slideDown 0.2s ease-out;
            background-color: #F9FAFB;
        }

        .reply-preview {
            transition: all 0.2s ease-in-out;
            position: relative;
            overflow: hidden;
            border-radius: 8px 8px 0 0;
        }

        .reply-preview::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 2px;
            background: currentColor;
            opacity: 0.5;
        }

        .reply-preview:hover {
            opacity: 0.95;
            transform: translateY(-1px);
        }

        /* Message Bubble with Reply */
        .message-bubble {
            transition: all 0.2s ease-in-out;
            position: relative;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
        }

        .message-bubble:hover {
            filter: brightness(98%);
        }

        .message-bubble .reply-preview {
            margin: -0.375rem -0.375rem 0.5rem;
            padding: 0.375rem;
            border-bottom: 1px solid rgba(0, 0, 0, 0.1);
        }

        /* Reply Button Animation */
        .reply-button {
            transform: scale(1);
            transition: all 0.2s ease-in-out;
        }

        .reply-button:hover {
            transform: scale(1.1);
            background-color: #EEF2FF;
        }

        .reply-button:active {
            transform: scale(0.95);
        }

        /* Reply Preview Animation */
        @keyframes slideDown {
            from {
                transform: translateY(-100%);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        /* Reply Icon Animation */
        .reply-icon {
            transition: transform 0.2s ease-in-out;
        }

        .reply-preview:hover .reply-icon {
            transform: translateX(-2px);
        }

        /* Enhanced Message Grouping with Replies */
        .message-wrapper + .message-wrapper {
            margin-top: 0.25rem;
        }

        .message-wrapper.has-reply {
            margin-top: 0.5rem;
        }

        /* Reply Content Truncation */
        .reply-content {
            display: -webkit-box;
            -webkit-line-clamp: 1;
            -webkit-box-orient: vertical;
            overflow: hidden;
            text-overflow: ellipsis;
        }
    </style>

    <script>
        // Get user ID from PHP session and store it safely in JavaScript
        const currentUserId = <?php echo isset($_SESSION['user']) ? $_SESSION['user'] : 'null'; ?>;

        (function () {
            const state = {
                currentConversationId: null,
                currentBookingId: null,
                messagePollingInterval: null,
                unreadCountPollingInterval: null,
                messageStatusPollingInterval: null,
                lastScrollPosition: 0,
                isInitialLoad: true,
                isLoadingConversation: false,
                lastMessageId: null,
                lastMessageStatus: {},
                activeMessageStatuses: new Map(),
                isPollingPaused: false
            };

            // Reset scroll state when changing conversations
            const originalLoadConversation = window.loadConversation;
            window.loadConversation = async function(element) {
                console.log('Loading conversation:', {
                    bookingId: element.dataset.bookingId,
                    venueId: element.dataset.venueId,
                    guestId: element.dataset.guestId,
                    hostId: element.dataset.hostId
                });

                if (state.isLoadingConversation || element.classList.contains('active')) {
                    console.log('Conversation already loading or active');
                    return;
                }

                try {
                    state.isLoadingConversation = true;
                    userHasScrolled = false;
                    newMessageCount = 0;
                    lastMessageCount = 0;
                    state.lastMessageId = null;
                    state.activeMessageStatuses.clear();

                    // Clear existing intervals
                    if (state.messageStatusPollingInterval) {
                        clearInterval(state.messageStatusPollingInterval);
                    }
                    if (state.messagePollingInterval) {
                        clearInterval(state.messagePollingInterval);
                    }
                    if (state.unreadCountPollingInterval) {
                        clearInterval(state.unreadCountPollingInterval);
                    }

                    const bookingId = element.dataset.bookingId;
                    const venueId = element.dataset.venueId;
                    const guestId = element.dataset.guestId;
                    const hostId = element.dataset.hostId;

                    if (!bookingId || !venueId || !guestId || !hostId) {
                        console.error('Missing required data attributes:', { bookingId, venueId, guestId, hostId });
                        return;
                    }

                    // Set the current booking ID
                    state.currentBookingId = bookingId;

                    // Highlight selected conversation
                    const conversationItems = document.querySelectorAll('.conversation-item');
                    conversationItems.forEach(item => {
                        item.classList.remove('bg-blue-50');
                        item.classList.remove('active');
                    });
                    element.classList.add('bg-blue-50');
                    element.classList.add('active');

                    // Show chat header and message input
                    const chatHeader = document.getElementById('chatHeader');
                    const messageInputContainer = document.getElementById('messageInputContainer');
                    const emptyState = document.getElementById('emptyState');
                    const messagesContainer = document.getElementById('messagesContainer');

                    if (chatHeader) chatHeader.classList.remove('hidden');
                    if (messageInputContainer) messageInputContainer.classList.remove('hidden');
                    if (emptyState) emptyState.classList.add('hidden');
                    if (messagesContainer) messagesContainer.innerHTML = '';

                    // Update chat header with profile information
                    const nameElement = element.querySelector('h4');
                    const venueElement = element.querySelector('p.text-sm');
                    const statusElement = element.querySelector('span.rounded-full');
                    const profilePicContainer = element.querySelector('.h-10.w-10');

                    const name = nameElement ? nameElement.textContent.trim() : '';
                    const venue = venueElement ? venueElement.textContent.trim() : '';
                    const status = statusElement ? statusElement.textContent.trim() : '';
                    const statusClass = statusElement ? statusElement.className : '';

                    const chatNameElement = document.getElementById('chatName');
                    const chatVenueElement = document.getElementById('chatVenue');
                    const chatStatusElement = document.getElementById('chatStatus');
                    const chatHeaderProfilePic = document.getElementById('chatProfilePic');

                    if (chatNameElement) chatNameElement.textContent = name;
                    if (chatVenueElement) chatVenueElement.textContent = venue;
                    if (chatStatusElement) {
                        chatStatusElement.textContent = status;
                        chatStatusElement.className = statusClass;
                    }

                    // Update profile picture
                    if (chatHeaderProfilePic && profilePicContainer) {
                        const headerPicContainer = chatHeaderProfilePic.closest('.h-12.w-12') || chatHeaderProfilePic.parentElement;
                        if (headerPicContainer) {
                            const profileContent = profilePicContainer.innerHTML;
                            headerPicContainer.innerHTML = `<div id="chatProfilePic">${profileContent}</div>`;
                            // Ensure the container maintains its size
                            headerPicContainer.className = 'h-12 w-12 rounded-full bg-black text-white flex items-center justify-center overflow-hidden';
                        }
                    }

                    // First, get or create conversation
                    const convResponse = await fetch('./api/messages.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({
                            action: 'get_or_create_conversation',
                            booking_id: bookingId,
                            venue_id: venueId,
                            guest_id: guestId,
                            host_id: hostId
                        })
                    });

                    if (!convResponse.ok) {
                        throw new Error(`HTTP error! status: ${convResponse.status}`);
                    }

                    const convData = await convResponse.json();
                    if (!convData.success) {
                        throw new Error(convData.error || 'Failed to load conversation');
                    }

                    state.currentConversationId = convData.conversation_id;

                    // Load initial messages
                    await loadMessages();

                    // Start polling intervals
                    state.messagePollingInterval = setInterval(async () => {
                        if (document.querySelector('.conversation-item.active')?.dataset.bookingId === bookingId) {
                            await loadMessages();
                        }
                    }, 1000);

                    state.unreadCountPollingInterval = setInterval(updateAllUnreadCounts, 1000);
                    state.messageStatusPollingInterval = setInterval(updateMessageStatuses, 1000);

                    // Update scroll button visibility
                    updateScrollButtonVisibility();

                } catch (error) {
                    console.error('Error loading conversation:', error);
                    alert('Failed to load conversation. Please try again.');
                } finally {
                    state.isLoadingConversation = false;
                }
            };

            // Helper function to format timestamps
            function formatMessageTimestamp(date) {
                const now = new Date();
                const messageDate = new Date(date);
                const diffDays = Math.floor((now - messageDate) / (1000 * 60 * 60 * 24));
                
                if (diffDays === 0) {
                    return messageDate.toLocaleTimeString([], { 
                        hour: '2-digit', 
                        minute: '2-digit',
                        hour12: true 
                    }).toLowerCase();
                } else if (diffDays === 1) {
                    return 'Yesterday';
                } else if (diffDays < 7) {
                    return messageDate.toLocaleDateString([], { weekday: 'long' });
                } else {
                    return messageDate.toLocaleDateString([], { 
                        month: 'short', 
                        day: 'numeric',
                        year: messageDate.getFullYear() !== now.getFullYear() ? 'numeric' : undefined
                    });
                }
            }

            // Helper function to check if messages should be grouped
            function shouldGroupMessages(prevMsg, currMsg) {
                if (!prevMsg || !currMsg) return false;
                
                const prevTime = new Date(prevMsg.created_at);
                const currTime = new Date(currMsg.created_at);
                const timeDiff = (currTime - prevTime) / 1000 / 60; // difference in minutes
                
                return timeDiff < 5 && // within 5 minutes
                       prevMsg.sender_id === currMsg.sender_id && // same sender
                       !currMsg.reply_to; // not a reply
            }

            // Helper function to create date header
            function createDateHeader(date) {
                const div = document.createElement('div');
                div.className = 'flex items-center justify-center my-4';
                div.innerHTML = `
                    <div class="bg-gray-200 rounded-full px-3 py-1 text-xs text-gray-600">
                        ${formatMessageTimestamp(date)}
                    </div>
                `;
                return div;
            }

            // Update createMessageElement function to show replies
            function createMessageElement(message, showStatus = false, prevMessage = null, nextMessage = null) {
                const isCurrentUser = message.sender_id === currentUserId;
                const div = document.createElement('div');
                div.className = `flex ${isCurrentUser ? 'justify-end' : 'justify-start'} message-wrapper`;
                div.setAttribute('data-message-id', message.id);
                div.setAttribute('data-sender-id', message.sender_id);
                div.setAttribute('data-timestamp', message.created_at);
                
                const shouldGroup = shouldGroupMessages(prevMessage, message);
                const nextShouldGroup = nextMessage && shouldGroupMessages(message, nextMessage);
                const isLastInGroup = !nextShouldGroup;
                const messageTime = new Date(message.created_at);
                
                let initialStatus = 'sent';
                if (message.status_count > 0) {
                    initialStatus = 'delivered';
                }
                if (message.read_count > 0) {
                    initialStatus = 'seen';
                }

                // Extract first names
                const senderFirstName = message.sender_name.split(' ')[0];
                const replyToFirstName = message.reply_to_sender ? message.reply_to_sender.split(' ')[0] : '';
                
                // Check if replying to own message
                const isReplyingToSelf = message.reply_to_sender_id === message.sender_id;
                
                div.innerHTML = `
                    <div class="max-w-[70%] relative group ${shouldGroup ? 'mt-1' : 'mt-3'}">
                        <div class="message-actions">
                            <button class="reply-button" onclick="handleReply('${message.id}', '${message.content.replace(/'/g, "\\'")}', '${message.sender_id}', '${message.sender_name}')">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                        d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"/>
                                </svg>
                            </button>
                        </div>
                        ${message.reply_to ? `
                            <div class="flex flex-col ${isCurrentUser ? 'items-end' : 'items-start'} mb-1">
                                <div class="bg-gray-100 text-gray-700 
                                    px-1 py-1
                                    rounded-t-2xl rounded-r-lg rounded-bl-md
                                    max-w-[75%] mb-1
                                    transform scale-95 origin-${isCurrentUser ? 'right' : 'left'}
                                    hover:bg-gray-200 transition-colors duration-200"
                                    onclick="scrollToMessage('${message.reply_to}')"
                                    style="user-select: none">
                                    <div class="text-[10px] text-gray-500">
                                        ${isReplyingToSelf ? 
                                            (isCurrentUser ? 'You replied to yourself' : `${senderFirstName} replied to themselves`) :
                                            (message.reply_to_sender_id === currentUserId ? 
                                                `${senderFirstName} replied to you` : 
                                                `You replied to ${replyToFirstName}`)}
                                    </div>
                                    <div class="text-[11px] mt-0.5 line-clamp-1">
                                        ${message.reply_to_content}
                                    </div>
                                </div>
                            </div>
                        ` : ''}
                        <div class="${isCurrentUser ? 'bg-blue-500' : 'bg-gray-100'} 
                            px-3 py-2
                            ${isCurrentUser ? 'rounded-2xl rounded-br-md' : 'rounded-2xl rounded-bl-md'}
                            message-bubble relative">
                            <p class="text-[13px] ${isCurrentUser ? 'text-white' : 'text-gray-800'} leading-relaxed">
                                ${message.content}
                            </p>
                        </div>
                        ${isLastInGroup ? `
                            <div class="message-info-wrapper">
                                <div class="message-info ${isCurrentUser ? 'right-0' : 'left-0'} 
                                    ${showStatus ? 'show' : ''}"
                                    style="--offset: ${isCurrentUser ? '7px' : '7px'}">
                                    <span class="message-time">
                                        ${messageTime.toLocaleTimeString([], { 
                                            hour: '2-digit', 
                                            minute: '2-digit',
                                            hour12: true 
                                        }).toLowerCase()}
                                    </span>
                                    ${isCurrentUser ? `
                                        <span class="message-status" 
                                            data-status-icon="${message.id}" 
                                            data-current-status="${initialStatus}">
                                            ${getStatusIcon(initialStatus, null, null, true)}
                                        </span>
                                    ` : ''}
                                </div>
                            </div>
                        ` : ''}
                    </div>
                `;

                return div;
            }

            // Update getStatusIcon function for minimalistic style
            function getStatusIcon(status, readCount, totalParticipants, isCurrentUser = false) {
                if (!isCurrentUser || !status) return '';

                const statusClasses = {
                    sent: 'text-gray-400',
                    delivered: 'text-gray-400',
                    seen: 'text-blue-400'
                };

                const statusClass = statusClasses[status] || 'text-gray-400';
                const statusText = status === 'sent' ? 'sent' : (status === 'delivered' ? 'delivered' : 'seen');
                
                return `<span class="${statusClass}">${statusText}</span>`;
            }

            // Update styles
            const styleSheet = document.createElement("style");
            styleSheet.textContent = `
                .messages-container {
                    padding: 1rem 0.5rem;
                    display: flex;
                    flex-direction: column;
                    gap: 2px;
                }
                .messages-container::-webkit-scrollbar {
                    width: 6px;
                }
                .messages-container::-webkit-scrollbar-track {
                    background: transparent;
                }
                .messages-container::-webkit-scrollbar-thumb {
                    background-color: rgba(203, 213, 225, 0.4);
                    border-radius: 20px;
                    border: transparent;
                }
                .messages-container::-webkit-scrollbar-thumb:hover {
                    background-color: rgba(203, 213, 225, 0.6);
                }
                .message-wrapper {
                    position: relative;
                    margin: 0.5px 0;
                    padding: 0 1rem;
                }
                .message-bubble {
                    transition: all 0.2s ease-in-out;
                    position: relative;
                    box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
                }
                .message-bubble:hover {
                    filter: brightness(98%);
                }
                .message-actions {
                    position: absolute;
                    top: 50%;
                    transform: translateY(-50%);
                    right: -30px;
                    opacity: 0;
                    transition: all 0.2s ease-in-out;
                    display: flex;
                    gap: 4px;
                    z-index: 10;
                }
                .message-wrapper:hover .message-actions {
                    opacity: 1;
                }
                .reply-button {
                    width: 24px;
                    height: 24px;
                    border-radius: 50%;
                    background: white;
                    color: #6B7280;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    cursor: pointer;
                    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
                    transition: all 0.2s ease-in-out;
                }
                .reply-button:hover {
                    background: #F3F4F6;
                    color: #374151;
                    transform: scale(1.05);
                }
                .line-clamp-1 {
                    display: -webkit-box;
                    -webkit-line-clamp: 1;
                    -webkit-box-orient: vertical;
                    overflow: hidden;
                }
                .message-info-wrapper {
                    position: absolute;
                    bottom: -2px;
                    left: 0;
                    right: 0;
                    height: 0;
                    overflow: visible;
                }
                .message-info {
                    position: absolute;
                    display: flex;
                    align-items: center;
                    gap: 4px;
                    padding: 1px 4px;
                    background: rgba(255, 255, 255, 0.98);
                    border-radius: 3px;
                    font-size: 11px;
                    color: #9ca3af;
                    opacity: 0;
                    transform: translateY(0);
                    transition: all 0.15s ease-in-out;
                    white-space: nowrap;
                    pointer-events: none;
                    box-shadow: 0 1px 1px rgba(0, 0, 0, 0.05);
                }
                .message-info.show {
                    opacity: 1;
                    pointer-events: auto;
                }
                .message-wrapper:hover .message-info {
                    opacity: 1;
                    transform: translateY(-2px);
                    pointer-events: auto;
                }
                .message-time, .message-status {
                    font-size: 11px;
                    line-height: 1;
                }
                .highlight-message {
                    animation: highlight-pulse 2s ease-in-out;
                }
                @keyframes highlight-pulse {
                    0% { background-color: rgba(59, 130, 246, 0.1); }
                    50% { background-color: rgba(59, 130, 246, 0.2); }
                    100% { background-color: transparent; }
                }
            `;
            document.head.appendChild(styleSheet);

            // Update the messages container styling
            const messagesContainer = document.getElementById('messagesContainer');
            if (messagesContainer) {
                messagesContainer.className = 'flex-1 overflow-y-auto messages-container';
            }

            // Add function to check if element is in viewport
            function isElementInViewport(el) {
                const rect = el.getBoundingClientRect();
                const messagesContainer = document.getElementById('messagesContainer');
                const containerRect = messagesContainer.getBoundingClientRect();
                
                return (
                    rect.top >= containerRect.top &&
                    rect.left >= containerRect.left &&
                    rect.bottom <= containerRect.bottom &&
                    rect.right <= containerRect.right
                );
            }

            // Update markMessagesAsRead function to handle message_status table
            async function markMessagesAsRead() {
                try {
                    const messagesContainer = document.getElementById('messagesContainer');
                    const messageElements = messagesContainer.querySelectorAll('[data-message-id]');
                    const visibleMessageIds = [];

                    messageElements.forEach(element => {
                        if (isElementInViewport(element)) {
                            const messageId = element.getAttribute('data-message-id');
                            const senderId = element.getAttribute('data-sender-id');
                            // Only mark messages as read if they're not from the current user
                            if (senderId != currentUserId) {
                                visibleMessageIds.push(messageId);
                            }
                        }
                    });

                    if (visibleMessageIds.length === 0) return;

                    const response = await fetch('./api/markMessagesRead.api.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify({
                            conversation_id: state.currentConversationId,
                            user_id: currentUserId,
                            message_ids: visibleMessageIds
                        })
                    });

                    if (!response.ok) {
                        throw new Error('Failed to mark messages as read');
                    }

                    const data = await response.json();
                    if (!data.success) {
                        throw new Error(data.error || 'Failed to mark messages as read');
                    }
                } catch (error) {
                    console.error('Error marking messages as read:', error);
                }
            }

            // Add scroll event listener to mark messages as read when they become visible
            function initializeMessageScrollHandler() {
                const messagesContainer = document.getElementById('messagesContainer');
                let scrollTimeout;

                messagesContainer.addEventListener('scroll', () => {
                    clearTimeout(scrollTimeout);
                    scrollTimeout = setTimeout(() => {
                        markMessagesAsRead();
                    }, 100); // Debounce scroll events
                });
            }

            // Initialize scroll handler when the page loads
            document.addEventListener('DOMContentLoaded', () => {
                initializeMessageScrollHandler();
                state.unreadCountPollingInterval = setInterval(updateAllUnreadCounts, 1000);
            });

            // Update reply handling function
            window.handleReply = function(messageId, content, senderId, senderName) {
                const messageInput = document.getElementById('messageInput');
                const replyContainer = document.getElementById('replyContainer');
                const replyPreview = document.getElementById('replyPreview');
                
                if (replyContainer && replyPreview) {
                    // Show the reply container
                    replyContainer.classList.remove('hidden');
                    
                    // Store reply data
                    messageInput.dataset.replyTo = messageId;
                    messageInput.dataset.replyContent = content;
                    messageInput.dataset.replySenderId = senderId;
                    messageInput.dataset.replySenderName = senderName;
                    
                    // Update the reply preview with a more visually appealing design
                    replyPreview.innerHTML = `
                        <div class="flex items-start space-x-2">
                            <div class="flex-shrink-0">
                                <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                        d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"/>
                                </svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-blue-600">${senderName}</p>
                                <p class="text-sm text-gray-500 truncate">${content}</p>
                            </div>
                        </div>
                    `;
                    
                    // Focus the input
                    messageInput.focus();
                }
            };

            // Add cancelReply function
            window.cancelReply = function() {
                const messageInput = document.getElementById('messageInput');
                const replyContainer = document.getElementById('replyContainer');
                
                if (replyContainer && messageInput) {
                    // Hide the reply container
                    replyContainer.classList.add('hidden');
                    
                    // Clear reply data
                    delete messageInput.dataset.replyTo;
                    delete messageInput.dataset.replyContent;
                    delete messageInput.dataset.replySenderId;
                    delete messageInput.dataset.replySenderName;
                    
                    // Focus back on the input
                    messageInput.focus();
                }
            };

            // Update message form submission to include reply data
            document.getElementById('messageForm').addEventListener('submit', async function(e) {
                e.preventDefault();
                const messageInput = document.getElementById('messageInput');
                const content = messageInput.value.trim();
                const replyTo = messageInput.dataset.replyTo;
                const replyContent = messageInput.dataset.replyContent;
                const replySenderId = messageInput.dataset.replySenderId;
                const replySenderName = messageInput.dataset.replySenderName;

                if (!content || !state.currentConversationId) return;

                try {
                    const response = await fetch('./api/messages.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({
                            action: 'send_message',
                            conversation_id: state.currentConversationId,
                            content: content,
                            sender_id: currentUserId,
                            reply_to: replyTo || null
                        })
                    });

                    if (!response.ok) {
                        throw new Error('Failed to send message');
                    }

                    messageInput.value = '';
                    cancelReply(); // Clear reply data
                    await loadMessages();
                    const messagesContainer = document.getElementById('messagesContainer');
                    messagesContainer.scrollTop = messagesContainer.scrollHeight;

                } catch (error) {
                    console.error('Error sending message:', error);
                    alert('Failed to send message. Please try again.');
                }
            });

            // Initialize search functionality
            document.getElementById('searchMessages').addEventListener('input', function(e) {
                const searchTerm = e.target.value.toLowerCase();
                const conversations = document.querySelectorAll('.conversation-item');
                
                conversations.forEach(conversation => {
                    const text = conversation.textContent.toLowerCase();
                    conversation.style.display = text.includes(searchTerm) ? 'block' : 'none';
                });
            });

            // Add these new functions after loadMessages
            async function updateUnreadCount(bookingId) {
                try {
                    const response = await fetch(`./api/getUnreadCount.api.php?booking_id=${bookingId}&user_id=${currentUserId}`);
                    if (!response.ok) {
                        throw new Error('Failed to get unread count');
                    }

                    const data = await response.json();
                    if (data.success) {
                        const conversationItem = document.querySelector(`.conversation-item[data-booking-id="${bookingId}"]`);
                        if (conversationItem) {
                            const unreadBadge = conversationItem.querySelector('.unread-badge');
                            if (data.unread_count > 0) {
                                if (!unreadBadge) {
                                    const nameElement = conversationItem.querySelector('h4');
                                    const badge = document.createElement('div');
                                    badge.className = 'ml-2 bg-blue-600 text-white text-xs font-bold rounded-full w-5 h-5 flex items-center justify-center unread-badge inline-flex';
                                    badge.textContent = data.unread_count;
                                    nameElement.appendChild(badge);
                                } else {
                                    unreadBadge.textContent = data.unread_count;
                                }
                                conversationItem.classList.add('bg-blue-50');
                            } else {
                                if (unreadBadge) {
                                    unreadBadge.remove();
                                }
                                conversationItem.classList.remove('bg-blue-50');
                            }
                        }
                    }
                } catch (error) {
                    console.error('Error updating unread count:', error);
                }
            }

            // Add this new function for updating all unread counts
            async function updateAllUnreadCounts() {
                const conversationItems = document.querySelectorAll('.conversation-item');
                for (const item of conversationItems) {
                    const bookingId = item.dataset.bookingId;
                    if (bookingId) {
                        try {
                            const response = await fetch(`./api/getUnreadCount.api.php?booking_id=${bookingId}&user_id=${currentUserId}`);
                            if (!response.ok) continue;

                            const data = await response.json();
                            if (data.success) {
                                const profilePicContainer = item.querySelector('.relative');
                                let unreadBadge = profilePicContainer.querySelector('.unread-badge');
                                
                                if (data.unread_count > 0) {
                                    if (!unreadBadge) {
                                        unreadBadge = document.createElement('div');
                                        unreadBadge.className = 'absolute bottom-0 right-0 bg-red-500 text-white text-xs font-bold rounded-full min-w-[16px] h-[16px] flex items-center justify-center unread-badge';
                                        profilePicContainer.appendChild(unreadBadge);
                                    }
                                    unreadBadge.textContent = data.unread_count;
                                    item.classList.add('bg-blue-50');
                                } else {
                                    if (unreadBadge) {
                                        unreadBadge.remove();
                                    }
                                    if (!item.classList.contains('active')) {
                                        item.classList.remove('bg-blue-50');
                                    }
                                }
                            }
                        } catch (error) {
                            console.error('Error updating unread count:', error);
                        }
                    }
                }
            }

            // Add scroll to message function
            window.scrollToMessage = function(messageId) {
                const targetMessage = document.querySelector(`[data-message-id="${messageId}"]`);
                if (targetMessage) {
                    targetMessage.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    targetMessage.classList.add('highlight-message');
                    setTimeout(() => {
                        targetMessage.classList.remove('highlight-message');
                    }, 2000);
                }
            };

            // Update loadMessages function to pass next message information
            async function loadMessages() {
                if (!state.currentConversationId) {
                    console.log('No conversation ID available');
                    return;
                }

                try {
                    const activeConversation = document.querySelector('.conversation-item.active');
                    if (!activeConversation || activeConversation.dataset.bookingId !== state.currentBookingId) {
                        console.log('No active conversation or booking ID mismatch');
                        return;
                    }

                    // First get message statuses
                    const statusResponse = await fetch(`./api/getMessageStatuses.api.php?conversation_id=${state.currentConversationId}&user_id=${currentUserId}`);
                    const statusData = await statusResponse.json();
                    const messageStatuses = statusData.success ? statusData.messages.reduce((acc, msg) => {
                        acc[msg.id] = {
                            status_count: msg.status_count,
                            read_count: msg.read_count
                        };
                        return acc;
                    }, {}) : {};

                    // Then get messages
                    const response = await fetch(`./api/messages.php?action=get_messages&conversation_id=${state.currentConversationId}`);
                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }

                    const data = await response.json();
                    if (!data.success) {
                        throw new Error(data.error || 'Failed to load messages');
                    }

                    const messagesContainer = document.getElementById('messagesContainer');
                    if (!messagesContainer) {
                        console.error('Messages container not found');
                        return;
                    }

                    const isScrolledToBottom = Math.abs((messagesContainer.scrollHeight - messagesContainer.scrollTop) - messagesContainer.clientHeight) < 50;

                    if (data.messages.length > lastMessageCount && !isScrolledToBottom && userHasScrolled) {
                        newMessageCount += data.messages.length - lastMessageCount;
                        updateScrollButtonVisibility();
                    }
                    lastMessageCount = data.messages.length;

                    messagesContainer.innerHTML = '';
                    let lastDate = null;
                    let prevMessage = null;

                    data.messages.forEach((message, index) => {
                        // Add status information to the message
                        if (messageStatuses[message.id]) {
                            message.status_count = messageStatuses[message.id].status_count;
                            message.read_count = messageStatuses[message.id].read_count;
                        }

                        const messageDate = new Date(message.created_at);
                        const currentDate = messageDate.toDateString();

                        if (currentDate !== lastDate) {
                            messagesContainer.appendChild(createDateHeader(message.created_at));
                            lastDate = currentDate;
                        }

                        const nextMessage = index < data.messages.length - 1 ? data.messages[index + 1] : null;
                        const messageElement = createMessageElement(
                            message,
                            index === data.messages.length - 1 && message.sender_id === currentUserId,
                            prevMessage,
                            nextMessage
                        );
                        messagesContainer.appendChild(messageElement);

                        prevMessage = message;
                    });

                    if (isScrolledToBottom) {
                        messagesContainer.scrollTop = messagesContainer.scrollHeight;
                        newMessageCount = 0;
                        updateScrollButtonVisibility();
                    }

                    await markMessagesAsRead();
                    updateUnreadCount(activeConversation.dataset.bookingId);

                } catch (error) {
                    console.error('Error loading messages:', error);
                }
            }

            // Update message statuses function to handle the message_status table properly
            async function updateMessageStatuses() {
                if (!state.currentConversationId) {
                    console.log('Skipping status update - no conversation ID');
                    return;
                }

                try {
                    const response = await fetch(`./api/getMessageStatuses.api.php?conversation_id=${state.currentConversationId}&user_id=${currentUserId}`);
                    if (!response.ok) {
                        console.error('Status update failed:', response.status, response.statusText);
                        return;
                    }

                    const data = await response.json();
                    if (!data.success || !data.messages) {
                        console.error('Invalid status data:', data);
                        return;
                    }

                    // Update status for all messages
                    data.messages.forEach(message => {
                        const messageElement = document.querySelector(`[data-message-id="${message.id}"]`);
                        if (messageElement) {
                            const statusSpan = messageElement.querySelector(`[data-status-icon="${message.id}"]`);
                            if (statusSpan) {
                                let status = 'sent';
                                
                                // If message has any status record, it's at least delivered
                                if (message.status_count > 0) {
                                    status = 'delivered';
                                }
                                
                                // If message is marked as read by any recipient
                                if (message.read_count > 0) {
                                    status = 'seen';
                                }
                                
                                // Only update if status has changed
                                const currentStatus = statusSpan.getAttribute('data-current-status');
                                if (currentStatus !== status) {
                                    console.log('Status changed:', {
                                        messageId: message.id,
                                        oldStatus: currentStatus,
                                        newStatus: status
                                    });
                                    
                                    statusSpan.innerHTML = getStatusIcon(status, null, null, message.sender_id === currentUserId);
                                    statusSpan.setAttribute('data-current-status', status);
                                }
                            }
                        }
                    });
                } catch (error) {
                    console.error('Error updating message statuses:', error);
                }
            }

            // Add scroll button functionality
            let newMessageCount = 0;
            let isNearBottom = true;
            let lastMessageCount = 0;
            let userHasScrolled = false;

            function updateScrollButtonVisibility() {
                const messagesContainer = document.getElementById('messagesContainer');
                const scrollButton = document.getElementById('scrollToBottomBtn');
                const newMessageCountElement = document.getElementById('newMessageCount');
                
                if (!messagesContainer || !scrollButton) return;

                const scrollPosition = messagesContainer.scrollTop + messagesContainer.clientHeight;
                const scrollThreshold = messagesContainer.scrollHeight - 100; // 100px threshold
                isNearBottom = scrollPosition >= scrollThreshold;

                if (!isNearBottom || newMessageCount > 0) {
                    scrollButton.classList.remove('hidden');
                    if (newMessageCount > 0) {
                        newMessageCountElement.textContent = newMessageCount;
                        newMessageCountElement.classList.remove('hidden');
                        scrollButton.classList.add('has-new-messages');
                    } else {
                        newMessageCountElement.classList.add('hidden');
                        scrollButton.classList.remove('has-new-messages');
                    }
                } else {
                    scrollButton.classList.add('hidden');
                    newMessageCount = 0;
                    newMessageCountElement.classList.add('hidden');
                    scrollButton.classList.remove('has-new-messages');
                }
            }

            // Add scroll event listener
            document.getElementById('messagesContainer').addEventListener('scroll', function() {
                userHasScrolled = true;
                updateScrollButtonVisibility();
            });

            // Add click handler for scroll button
            document.getElementById('scrollToBottomBtn').addEventListener('click', function() {
                const messagesContainer = document.getElementById('messagesContainer');
                messagesContainer.scrollTo({
                    top: messagesContainer.scrollHeight,
                    behavior: 'smooth'
                });
                newMessageCount = 0;
                updateScrollButtonVisibility();
            });

        })();
    </script>
    <script src="./vendor/jQuery-3.7.1/jquery-3.7.1.min.js"></script>
    <script src="./js/user.jquery.js"></script>
</body>
</html>