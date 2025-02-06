<?php
require_once '../classes/venue.class.php';
require_once '../dbconnection.php';
session_start();

$venueObj = new Venue();
$userId = $_SESSION['user']['id'];
$userType = $_SESSION['user']['user_type_id']; // 1 for Host, 2 for Guest

try {
    $db = new Database();
    $conn = $db->connect();

    // Get all bookings based on user type
    if ($userType == 1) { // Host
        $query = "SELECT 
            b.*, 
            v.id as venue_id,
            v.name as venue_name,
            v.host_id,
            g.firstname as guest_firstname,
            g.lastname as guest_lastname,
            g.profile_pic as guest_profile_pic,
            (
                SELECT COUNT(*) 
                FROM messages m
                JOIN conversations c ON m.conversation_id = c.id
                LEFT JOIN message_status ms ON m.id = ms.message_id AND ms.user_id = :host_id
                WHERE c.booking_id = b.id 
                AND m.sender_id != :host_id
                AND (ms.is_read = 0 OR ms.is_read IS NULL)
            ) as unread_count
        FROM bookings b
        JOIN venues v ON b.booking_venue_id = v.id
        JOIN users g ON b.booking_guest_id = g.id
        WHERE v.host_id = :host_id
        AND b.booking_status_id IN (1, 2, 3, 4)
        ORDER BY b.booking_created_at DESC";
        
        $stmt = $conn->prepare($query);
        $stmt->execute(['host_id' => $userId]);
        $bookings = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } else { // Guest
        $query = "SELECT 
            b.*, 
            v.id as venue_id,
            v.name as venue_name,
            v.host_id,
            h.firstname as host_firstname,
            h.lastname as host_lastname,
            h.profile_pic as host_profile_pic,
            (
                SELECT COUNT(*) 
                FROM messages m
                JOIN conversations c ON m.conversation_id = c.id
                LEFT JOIN message_status ms ON m.id = ms.message_id AND ms.user_id = :guest_id
                WHERE c.booking_id = b.id 
                AND m.sender_id != :guest_id
                AND (ms.is_read = 0 OR ms.is_read IS NULL)
            ) as unread_count
        FROM bookings b
        JOIN venues v ON b.booking_venue_id = v.id
        JOIN users h ON v.host_id = h.id
        WHERE b.booking_guest_id = :guest_id
        AND b.booking_status_id IN (1, 2, 3, 4)
        ORDER BY b.booking_created_at DESC";
        
        $stmt = $conn->prepare($query);
        $stmt->execute(['guest_id' => $userId]);
        $bookings = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Debug output
    error_log("User ID: " . $userId . ", User Type: " . $userType);
    error_log("Bookings found: " . count($bookings));
    foreach ($bookings as $booking) {
        error_log("Booking ID: " . $booking['id'] . ", Unread Count: " . $booking['unread_count']);
    }

    // Group bookings by user to prevent duplicates
    $uniqueUsers = [];
    foreach ($bookings as $booking) {
        if ($userType == 1) { // Host view
            $userKey = $booking['booking_guest_id'];
            $userName = $booking['guest_firstname'] . ' ' . $booking['guest_lastname'];
            $guestId = $booking['booking_guest_id'];
            $hostId = $userId;
            $venueId = $booking['venue_id'];
            $venueName = $booking['venue_name'];
        } else { // Guest view
            $userKey = $booking['host_id'];
            $userName = $booking['host_firstname'] . ' ' . $booking['host_lastname'];
            $guestId = $userId;
            $hostId = $booking['host_id'];
            $venueId = $booking['venue_id'];
            $venueName = $booking['venue_name'];
        }
        
        // If this user isn't in our array yet, or if this booking is more recent, update it
        if (!isset($uniqueUsers[$userKey]) || 
            strtotime($booking['booking_start_date']) > strtotime($uniqueUsers[$userKey]['booking_start_date'])) {
            $uniqueUsers[$userKey] = [
                'booking_id' => $booking['id'],
                'venue_id' => $venueId,
                'venue_name' => $venueName,
                'guest_id' => $guestId,
                'host_id' => $hostId,
                'display_name' => $userName,
                'booking_start_date' => $booking['booking_start_date'],
                'booking_status_id' => $booking['booking_status_id'],
                'name' => $venueName,
                'unread_count' => (int)$booking['unread_count']
            ];
            
            // Debug output for unread counts
            error_log("User: " . $userName . ", Unread Count: " . $booking['unread_count']);
        }
    }

    // Sort by most recent booking
    usort($uniqueUsers, function($a, $b) {
        return strtotime($b['booking_start_date']) - strtotime($a['booking_start_date']);
    });

} catch (PDOException $e) {
    error_log("Database error: " . $e->getMessage());
    $uniqueUsers = [];
}
?>

<div class="fixed mt-28 inset-0 pb-4 px-4">
    <div class="bg-white rounded-lg shadow w-full h-full max-w-7xl mx-auto overflow-hidden">
        <div class="flex h-full">
            <!-- Messages List -->
            <div class="w-[350px] flex flex-col border-r flex-shrink-0 h-full">
                <div class="p-4 border-b bg-white">
                    <div class="relative">
                        <input type="text" id="searchMessages" 
                               class="w-full pl-4 pr-10 py-2 h-10 border rounded-lg text-sm bg-gray-50" 
                               placeholder="Search messages">
                        <svg class="w-4 h-4 absolute right-3 top-1/2 -translate-y-1/2 text-gray-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
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
                            <div class="conversation-item hover:bg-gray-50 cursor-pointer border-b relative <?php echo ((int)$user['unread_count'] > 0) ? 'bg-blue-50' : ''; ?>" 
                                 data-booking-id="<?php echo htmlspecialchars($user['booking_id']); ?>"
                                 data-venue-id="<?php echo htmlspecialchars($user['venue_id']); ?>"
                                 data-guest-id="<?php echo htmlspecialchars($user['guest_id']); ?>"
                                 data-host-id="<?php echo htmlspecialchars($user['host_id']); ?>"
                                 data-unread-count="<?php echo htmlspecialchars($user['unread_count']); ?>"
                                 onclick="loadConversation(this)">
                                <div class="p-4">
                                    <div class="flex justify-between items-start mb-2">
                                        <div class="flex items-center space-x-2">
                                            <div class="flex items-center">
                                                <h4 class="font-medium text-sm text-gray-900">
                                                    <?php echo htmlspecialchars($user['display_name']); ?>
                                                </h4>
                                                <?php if ((int)$user['unread_count'] > 0): ?>
                                                    <div class="ml-2 bg-blue-600 text-white text-xs font-bold rounded-full w-5 h-5 flex items-center justify-center unread-badge">
                                                        <?php echo (int)$user['unread_count']; ?>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                        <span class="text-xs text-gray-500">
                                            <?php echo date('M j, Y', strtotime($user['booking_start_date'])); ?>
                                        </span>
                                    </div>
                                    <div class="flex justify-between items-center">
                                        <p class="text-sm text-gray-600"><?php echo htmlspecialchars($user['venue_name']); ?></p>
                                        <?php echo getStatusBadge($user['booking_status_id']); ?>
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
                        <div>
                            <h3 id="chatName" class="font-medium text-gray-900"></h3>
                            <p id="chatVenue" class="text-sm text-gray-600"></p>
                        </div>
                    </div>
                    <span id="chatStatus" class="px-2 py-0.5 text-xs rounded-full"></span>
                </div>

                <!-- Messages Container -->
                <div id="messagesContainer" class="flex-1 overflow-y-auto p-4 space-y-3 custom-scrollbar">
                    <!-- Default empty state -->
                    <div id="emptyState" class="flex items-center justify-center h-full text-center text-gray-500">
                        <div>
                            <svg class="w-16 h-16 mx-auto mb-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z">
                                </path>
                            </svg>
                            <h3 class="text-xl font-medium mb-2">Select a conversation</h3>
                            <p>Choose a booking conversation to start messaging</p>
                        </div>
                    </div>
                </div>

                <!-- Message Input -->
                <div id="messageInputContainer" class="px-4 py-3 border-t bg-white hidden">
                    <form id="messageForm" class="flex items-center space-x-2">
                        <div class="flex-1 relative">
                            <input type="text" id="messageInput" 
                                   class="w-full pl-4 pr-12 py-3 border rounded-lg focus:outline-none focus:border-blue-500 bg-gray-50" 
                                   placeholder="Type your message...">
                            <button type="submit" 
                                    class="absolute right-2 top-1/2 -translate-y-1/2 p-2 text-blue-600 hover:bg-gray-100 rounded-full transition-colors duration-150">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10.894 2.553a1 1 0 00-1.788 0l-7 14a1 1 0 001.169 1.409l5-1.429A1 1 0 009 15.571V11a1 1 0 112 0v4.571a1 1 0 00.725.962l5 1.428a1 1 0 001.17-1.408l-7-14z"></path>
                                </svg>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
function getStatusBadge($statusId) {
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
?>

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
    background-color: #EF4444 !important;  /* Bright red color */
    color: white !important;
    min-width: 22px !important;
    height: 22px !important;
    padding: 0 6px !important;
    font-size: 0.85rem !important;
    font-weight: 600 !important;
    box-shadow: 0 2px 4px rgba(239, 68, 68, 0.3) !important;
    animation: pulse 2s infinite;
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
    border-radius: 9999px !important;
}

@keyframes pulse {
    0% {
        transform: scale(1);
        box-shadow: 0 2px 4px rgba(239, 68, 68, 0.3);
    }
    50% {
        transform: scale(1.05);
        box-shadow: 0 4px 8px rgba(239, 68, 68, 0.4);
    }
    100% {
        transform: scale(1);
        box-shadow: 0 2px 4px rgba(239, 68, 68, 0.3);
    }
}

/* Conversation item with unread messages */
.conversation-item.has-unread {
    background-color: #EBF5FF !important;  /* Light blue background */
    position: relative;
}

.conversation-item.has-unread::before {
    content: '';
    position: absolute;
    left: 0;
    top: 0;
    bottom: 0;
    width: 4px;
    background-color: #EF4444;  /* Red indicator line */
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
    from { opacity: 0; transform: translate(-50%, 10px); }
    to { opacity: 1; transform: translate(-50%, 0); }
}
</style>

<script>
(function() {
    const state = {
        currentConversationId: null,
        currentBookingId: null,
        messagePollingInterval: null,
        unreadCountPollingInterval: null,
        lastScrollPosition: 0,
        isInitialLoad: true,
        isLoadingConversation: false,
        lastMessageId: null,
        lastMessageStatus: {},
        activeMessageStatuses: new Map(),
        isPollingPaused: false
    };

    // Immediately start polling for unread counts
    function initializeUnreadPolling() {
        // First immediate update
        updateUnreadCounts();

        // Set up continuous polling
        state.unreadCountPollingInterval = setInterval(updateUnreadCounts, 1000);

        // Set up a periodic check to ensure polling is running
        setInterval(() => {
            if (!state.unreadCountPollingInterval) {
                state.unreadCountPollingInterval = setInterval(updateUnreadCounts, 1000);
            }
        }, 5000);
    }

    // Initialize as soon as script loads
    initializeUnreadPolling();

    // Also initialize on DOMContentLoaded for safety
    document.addEventListener('DOMContentLoaded', function() {
        if (!state.unreadCountPollingInterval) {
            initializeUnreadPolling();
        }
        
        // Load first conversation if exists (optional)
        const firstConversation = document.querySelector('.conversation-item');
        if (firstConversation) {
            firstConversation.click();
        }
    });

    // Load conversation messages
    window.loadConversation = async function(element) {
        if (state.isLoadingConversation || element.classList.contains('active')) {
            return;
        }

        try {
            state.isLoadingConversation = true;
            state.lastMessageId = null;
            state.activeMessageStatuses.clear();
            
            const bookingId = element.dataset.bookingId;
            const venueId = element.dataset.venueId;
            const guestId = element.dataset.guestId;
            const hostId = element.dataset.hostId;
            
            // Set the current booking ID
            state.currentBookingId = bookingId;
            
            if (!bookingId || !venueId || !guestId || !hostId) {
                console.error('Missing required data attributes:', { bookingId, venueId, guestId, hostId });
                return;
            }

            // Highlight selected conversation
            const conversationItems = document.querySelectorAll('.conversation-item');
            conversationItems.forEach(item => {
                item.classList.remove('bg-blue-50');
                item.classList.remove('active');
            });
            element.classList.add('bg-blue-50');
            element.classList.add('active');
            
            // First, get or create conversation
            const convResponse = await fetch('/Web-Hubvenue/api/messages.php', {
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
            
            // Show chat header and message input
            const chatHeader = document.getElementById('chatHeader');
            const messageInputContainer = document.getElementById('messageInputContainer');
            const emptyState = document.getElementById('emptyState');
            const messagesContainer = document.getElementById('messagesContainer');
            
            // Clear existing messages
            messagesContainer.innerHTML = '';
            
            if (chatHeader) chatHeader.classList.remove('hidden');
            if (messageInputContainer) messageInputContainer.classList.remove('hidden');
            if (emptyState) emptyState.classList.add('hidden');
            
            // Update chat header
            const nameElement = element.querySelector('h4');
            const venueElement = element.querySelector('p.text-sm');
            const statusElement = element.querySelector('span.rounded-full');
            
            const name = nameElement ? nameElement.textContent.trim() : '';
            const venue = venueElement ? venueElement.textContent.trim() : '';
            const status = statusElement ? statusElement.textContent.trim() : '';
            const statusClass = statusElement ? statusElement.className : '';
            
            const chatNameElement = document.getElementById('chatName');
            const chatVenueElement = document.getElementById('chatVenue');
            const chatStatusElement = document.getElementById('chatStatus');
            
            if (chatNameElement) chatNameElement.textContent = name;
            if (chatVenueElement) chatVenueElement.textContent = venue;
            if (chatStatusElement) {
                chatStatusElement.textContent = status;
                chatStatusElement.className = statusClass;
            }
            
            // Load initial messages
            await loadMessages();
            
            // Start message polling for active conversation
            if (state.currentConversationId === convData.conversation_id) {
                state.messagePollingInterval = setInterval(async () => {
                    const activeConversation = document.querySelector('.conversation-item.active');
                    if (activeConversation && activeConversation.dataset.bookingId === bookingId) {
                        await loadMessages();
                    }
                }, 1000);
            }

        } catch (error) {
            console.error('Error loading conversation:', error);
            alert('Failed to load conversation. Please try again.');
        } finally {
            state.isLoadingConversation = false;
        }
    };

    // Load messages for current conversation
    async function loadMessages() {
        if (!state.currentConversationId) return;
        
        try {
            const activeConversation = document.querySelector('.conversation-item.active');
            if (!activeConversation || activeConversation.dataset.bookingId !== state.currentBookingId) {
                return;
            }

            const response = await fetch(`/Web-Hubvenue/api/messages.php?action=get_messages&conversation_id=${state.currentConversationId}`);
            const data = await response.json();
            
            if (!response.ok) {
                throw new Error(data.error || 'Failed to load messages');
            }
            
            if (!data.success) {
                throw new Error(data.error || 'Failed to load messages');
            }
            
            const messagesContainer = document.getElementById('messagesContainer');
            const currentScrollPosition = messagesContainer.scrollTop;
            const isScrolledToBottom = Math.abs((messagesContainer.scrollHeight - messagesContainer.scrollTop) - messagesContainer.clientHeight) < 50;
            
            // Track unread messages
            const unreadMessageIds = [];
            let hasNewMessages = false;

            // Check for new messages
            data.messages.forEach(message => {
                if (message.id > (state.lastMessageId || 0)) {
                    hasNewMessages = true;
                }
                
                if (message.sender_id !== <?php echo $_SESSION['user']['id']; ?> && !message.is_read) {
                    unreadMessageIds.push(message.id);
                }
            });

            // Update last message ID
            if (data.messages.length > 0) {
                state.lastMessageId = data.messages[data.messages.length - 1].id;
            }

            // Always update DOM for active conversation
            messagesContainer.innerHTML = '';

            // Add new message indicator if needed
            if (!messagesContainer.querySelector('.new-message-indicator')) {
                const indicator = document.createElement('div');
                indicator.className = 'new-message-indicator';
                indicator.textContent = 'New messages';
                indicator.onclick = () => {
                    messagesContainer.scrollTop = messagesContainer.scrollHeight;
                    indicator.style.display = 'none';
                };
                messagesContainer.appendChild(indicator);
            }

            // Render messages
            data.messages.forEach((message, index) => {
                const isCurrentUser = message.sender_id === <?php echo $_SESSION['user']['id']; ?>;
                const messageElement = document.createElement('div');
                messageElement.className = `flex ${isCurrentUser ? 'justify-end' : 'justify-start'} mb-4`;
                messageElement.setAttribute('data-message-id', message.id);
                
                let messageStatus = '';
                // Only show status for the last message from current user
                if (isCurrentUser && index === data.messages.length - 1) {
                    let statusText = '';
                    let statusClass = 'text-gray-500';
                    
                    switch(message.status) {
                        case 'seen':
                            statusText = 'Seen';
                            statusClass = 'text-gray-600';
                            break;
                        case 'delivered':
                            statusText = 'Delivered';
                            statusClass = 'text-blue-500';
                            break;
                        default:
                            statusText = 'Sent';
                            statusClass = 'text-gray-500';
                    }
                    
                    messageStatus = `<div class="text-xs ${statusClass} text-right mt-1 message-status" data-message-id="${message.id}">
                        ${statusText}
                    </div>`;
                }
                
                messageElement.innerHTML = `
                    <div class="max-w-[70%]">
                        <div class="${isCurrentUser ? 'bg-blue-500 text-white' : 'bg-gray-100'} rounded-lg px-4 py-2">
                            <p class="text-sm">${message.content}</p>
                            <span class="text-xs ${isCurrentUser ? 'text-blue-100' : 'text-gray-500'} block mt-1">
                                ${new Date(message.created_at).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' })}
                            </span>
                        </div>
                        ${messageStatus}
                    </div>
                `;
                messagesContainer.appendChild(messageElement);
            });

            // Handle scrolling and new message indicator
            const indicator = messagesContainer.querySelector('.new-message-indicator');
            if (hasNewMessages) {
                if (isScrolledToBottom) {
                    messagesContainer.scrollTop = messagesContainer.scrollHeight;
                    if (indicator) indicator.style.display = 'none';
                } else {
                    messagesContainer.scrollTop = currentScrollPosition;
                    if (indicator) indicator.style.display = 'block';
                }
            } else {
                messagesContainer.scrollTop = currentScrollPosition;
                if (indicator) indicator.style.display = 'none';
            }

            // Mark messages as read and update UI immediately
            if (unreadMessageIds.length > 0 && activeConversation && isScrolledToBottom) {
                try {
                    const formData = new URLSearchParams();
                    formData.append('action', 'mark_as_read');
                    formData.append('message_ids', JSON.stringify(unreadMessageIds));
                    formData.append('user_id', <?php echo $_SESSION['user']['id']; ?>);

                    const markReadResponse = await fetch('/Web-Hubvenue/api/messages.php', {
                        method: 'PUT',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded',
                        },
                        body: formData.toString()
                    });

                    if (!markReadResponse.ok) {
                        const errorData = await markReadResponse.json();
                        throw new Error(errorData.error || 'Failed to mark messages as read');
                    }

                    const markReadData = await markReadResponse.json();
                    
                    if (markReadData.success) {
                        // Update UI immediately
                        const unreadBadge = activeConversation.querySelector('.unread-badge');
                        if (unreadBadge) {
                            unreadBadge.remove();
                        }
                        activeConversation.classList.remove('has-unread');
                        activeConversation.classList.remove('bg-blue-50');
                        
                        // Update conversation list immediately
                        await updateUnreadCounts();
                    } else {
                        console.error('Error marking messages as read:', markReadData.error);
                        // Optionally show a user-friendly error message
                        const errorToast = document.createElement('div');
                        errorToast.className = 'fixed bottom-4 right-4 bg-red-500 text-white px-6 py-3 rounded shadow-lg';
                        errorToast.textContent = 'Failed to mark messages as read. Please try again.';
                        document.body.appendChild(errorToast);
                        setTimeout(() => errorToast.remove(), 3000);
                    }
                } catch (error) {
                    console.error('Error marking messages as read:', error);
                    // Show error message to user
                    const errorToast = document.createElement('div');
                    errorToast.className = 'fixed bottom-4 right-4 bg-red-500 text-white px-6 py-3 rounded shadow-lg';
                    errorToast.textContent = error.message || 'Failed to mark messages as read. Please try again.';
                    document.body.appendChild(errorToast);
                    setTimeout(() => errorToast.remove(), 3000);
                }
            }
        } catch (error) {
            console.error('Error loading messages:', error);
            const messagesContainer = document.getElementById('messagesContainer');
            messagesContainer.innerHTML = `
                <div class="flex items-center justify-center h-full text-center text-red-500">
                    <div>
                        <p class="font-medium">Error loading messages</p>
                        <p class="text-sm mt-1">${error.message}</p>
                        <button onclick="loadMessages()" class="mt-4 px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                            Try Again
                        </button>
                    </div>
                </div>
            `;
        }
    }

    // Update the message form submission handler
    document.getElementById('messageForm').addEventListener('submit', async function(e) {
        e.preventDefault();
        
        const messageInput = document.getElementById('messageInput');
        const content = messageInput.value.trim();
        
        if (!content || !state.currentConversationId) {
            console.error('Missing content or conversation ID', { content, currentConversationId: state.currentConversationId });
            return;
        }
        
        const messageData = {
            action: 'send_message',
            conversation_id: state.currentConversationId,
            sender_id: <?php echo $_SESSION['user']['id']; ?>,
            content: content
        };
        
        try {
            const response = await fetch('/Web-Hubvenue/api/messages.php', {
                method: 'POST',
                headers: { 
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify(messageData)
            });
            
            const responseText = await response.text();
            
            let data;
            try {
                data = JSON.parse(responseText);
            } catch (e) {
                console.error('Failed to parse response:', e);
                throw new Error('Invalid response from server');
            }
            
            if (!response.ok) {
                throw new Error(data.error || 'Failed to send message');
            }
            
            if (!data.success) {
                throw new Error(data.error || 'Failed to send message');
            }
            
            // Clear input
            messageInput.value = '';
            
            // Set flag to scroll to bottom after this message
            const messagesContainer = document.getElementById('messagesContainer');
            messagesContainer.dataset.shouldScrollToBottom = 'true';
            
            // Load the new messages
            await loadMessages();
            
            // Scroll to bottom only for new messages
            if (messagesContainer.dataset.shouldScrollToBottom === 'true') {
                messagesContainer.scrollTop = messagesContainer.scrollHeight;
                messagesContainer.dataset.shouldScrollToBottom = 'false';
            }
            
            // Force an immediate unread count update
            await updateUnreadCounts();
            
        } catch (error) {
            console.error('Error sending message:', error);
            alert('Failed to send message. Please try again. Error: ' + error.message);
        }
    });

    // Search functionality
    document.getElementById('searchMessages').addEventListener('input', function(e) {
        const searchTerm = e.target.value.toLowerCase();
        const conversations = document.querySelectorAll('.conversation-item');
        
        conversations.forEach(conversation => {
            const text = conversation.textContent.toLowerCase();
            conversation.style.display = text.includes(searchTerm) ? 'block' : 'none';
        });
    });

    // Update cleanup
    window.addEventListener('beforeunload', function() {
        if (state.messagePollingInterval) {
            clearInterval(state.messagePollingInterval);
            state.messagePollingInterval = null;
        }
        if (state.unreadCountPollingInterval) {
            clearInterval(state.unreadCountPollingInterval);
            state.unreadCountPollingInterval = null;
        }
        state.activeMessageStatuses.clear();
    });

    // Update the updateUnreadCounts function
    async function updateUnreadCounts() {
        if (state.isPollingPaused) return;
        
        try {
            state.isPollingPaused = true;
            
            const response = await fetch(`/Web-Hubvenue/api/messages.php?action=get_booking_conversations&user_id=<?php echo $_SESSION['user']['id']; ?>`, {
                cache: 'no-store' // Prevent caching
            });
            
            if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);
            
            const data = await response.json();
            if (!data.success) throw new Error(data.error || 'Failed to fetch unread counts');
            
            if (data.conversations) {
                data.conversations.forEach(conv => {
                    const conversationItem = document.querySelector(`[data-booking-id="${conv.booking_id}"]`);
                    if (!conversationItem) return;

                    const existingBadge = conversationItem.querySelector('.unread-badge');
                    const nameElement = conversationItem.querySelector('h4');
                    
                    // Always update the unread count
                    if (conv.unread_count > 0) {
                        if (existingBadge) {
                            existingBadge.textContent = conv.unread_count;
                        } else if (nameElement) {
                            const badge = document.createElement('div');
                            badge.className = 'unread-badge';
                            badge.textContent = conv.unread_count;
                            nameElement.parentNode.appendChild(badge);
                        }
                        
                        if (!conversationItem.classList.contains('active')) {
                            conversationItem.classList.add('has-unread');
                            conversationItem.classList.add('bg-blue-50');
                        }
                    } else {
                        if (existingBadge) {
                            existingBadge.remove();
                        }
                        conversationItem.classList.remove('has-unread');
                        if (!conversationItem.classList.contains('active')) {
                            conversationItem.classList.remove('bg-blue-50');
                        }
                    }
                    
                    // Update the data attribute
                    conversationItem.setAttribute('data-unread-count', conv.unread_count);
                });
            }
        } catch (error) {
            console.error('Error updating unread counts:', error);
            // If there's an error, make sure we can try again
            state.isPollingPaused = false;
        } finally {
            state.isPollingPaused = false;
        }
    }
})();
</script>