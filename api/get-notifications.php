<?php
session_start();
require_once '../classes/notification.class.php';

header('Content-Type: application/json');

// Check if user is logged in
if (!isset($_SESSION['user'])) {
    echo json_encode(['success' => false, 'message' => 'User not authenticated']);
    exit;
}

$notification = new Notification();
$userId = $_SESSION['user'];

// Get pagination parameters
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 10;
$offset = ($page - 1) * $limit;

try {
    // Get notifications for current page
    $notifications = $notification->getUserNotifications($userId, $limit, $offset);
    $unreadCount = $notification->getUnreadCount($userId);
    $totalCount = $notification->getTotalNotificationCount($userId);
    
    // Start output buffering to capture HTML
    ob_start();

    if (empty($notifications)): ?>
        <div class="px-6 py-12 text-center text-gray-500">
            <div class="mb-4">
                <i class="fas fa-bell text-gray-400 text-4xl"></i>
            </div>
            <p class="text-lg font-medium mb-1">No notifications yet</p>
            <p class="text-sm text-gray-400">We'll notify you when something arrives</p>
        </div>
    <?php else:
        foreach ($notifications as $notif): ?>
            <div class="notification-item px-6 py-4 hover:bg-gray-50/50 transition-colors <?php echo !$notif['is_read'] ? 'bg-blue-50/50' : ''; ?>"
                 data-type="<?php echo htmlspecialchars($notif['type']); ?>"
                 data-id="<?php echo htmlspecialchars($notif['id']); ?>"
                 data-read="<?php echo $notif['is_read'] ? 'read' : 'unread'; ?>">
                <div class="flex items-start gap-4">
                    <!-- Profile Picture/Icon -->
                    <div class="flex-shrink-0">
                        <?php if (!empty($notif['profile_pic'])): ?>
                            <div class="h-10 w-10 rounded-full bg-gray-200 overflow-hidden">
                                <img src="./<?php echo htmlspecialchars($notif['profile_pic']); ?>" 
                                     alt="Profile" 
                                     class="w-full h-full object-cover">
                            </div>
                        <?php else: ?>
                            <div class="h-10 w-10 rounded-full bg-gray-100 flex items-center justify-center">
                                <span class="text-lg font-medium text-gray-600">
                                    <?php 
                                    $name = explode(' ', $notif['reference_name'] ?? 'U')[0];
                                    echo strtoupper(substr($name, 0, 1)); 
                                    ?>
                                </span>
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- Content -->
                    <div class="flex-grow min-w-0">
                        <p class="text-[13px] text-gray-900 leading-5">
                            <?php echo htmlspecialchars($notif['message']); ?>
                        </p>
                        <p class="text-xs text-gray-500 mt-1">
                            <?php
                            $secondsAgo = (int) $notif['seconds_ago'];
                            if ($secondsAgo < 60) {
                                echo "Just now";
                            } elseif ($secondsAgo < 3600) {
                                $minutes = floor($secondsAgo / 60);
                                echo $minutes . " minute" . ($minutes > 1 ? "s" : "") . " ago";
                            } elseif ($secondsAgo < 86400) {
                                $hours = floor($secondsAgo / 3600);
                                echo $hours . " hour" . ($hours > 1 ? "s" : "") . " ago";
                            } elseif ($secondsAgo < 604800) {
                                $days = floor($secondsAgo / 86400);
                                echo $days . " day" . ($days > 1 ? "s" : "") . " ago";
                            } else {
                                echo date('M j, Y', strtotime($notif['created_at']));
                            }
                            ?>
                        </p>
                    </div>

                    <!-- Mark as Read Button (for unread notifications) -->
                    <?php if (!$notif['is_read']): ?>
                        <button onclick="markAsRead(this, <?php echo $notif['id']; ?>)" 
                                class="flex-shrink-0 text-gray-400 hover:text-gray-600 transition-colors">
                            <i class="fas fa-check"></i>
                        </button>
                    <?php endif; ?>

                    <!-- Status Icon (if needed) -->
                    <?php if ($notif['type'] === 'booking_update' || $notif['type'] === 'payment'): ?>
                        <div class="flex-shrink-0">
                            <i class="fas fa-check text-blue-500"></i>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach;
    endif;

    // Get the buffered content
    $notificationsHtml = ob_get_clean();

    // Calculate if there are more notifications
    $hasMore = ($page * $limit) < $totalCount;

    // Return JSON response
    echo json_encode([
        'success' => true,
        'unreadCount' => $unreadCount,
        'notificationsHtml' => $notificationsHtml,
        'hasMore' => $hasMore,
        'totalCount' => $totalCount
    ]);

} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
}