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

try {
    // Get notifications
    $notifications = $notification->getUserNotifications($userId);
    $unreadCount = $notification->getUnreadCount($userId);

    // Start output buffering to capture HTML
    ob_start();

    if (empty($notifications)): ?>
        <div class="p-4 text-center text-gray-500">
            <p>No notifications yet</p>
        </div>
    <?php else:
        foreach ($notifications as $notif): ?>
            <div class="p-4 hover:bg-gray-50 <?php echo !$notif['is_read'] ? 'bg-blue-50' : ''; ?>">
                <div class="flex items-start gap-4">
                    <?php
                    // Icon based on notification type
                    switch ($notif['type']) {
                        case 'message':
                            echo '<div class="flex-shrink-0 w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center">';
                            if (!empty($notif['profile_pic'])) {
                                echo '<img src="' . htmlspecialchars($notif['profile_pic']) . '" class="w-10 h-10 rounded-full object-cover" alt="Profile">';
                            } else {
                                echo '<svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path>
                                    </svg>';
                            }
                            echo '</div>';
                            break;

                        case 'booking':
                        case 'booking_update':
                            $statusColors = [
                                1 => 'yellow', // Pending
                                2 => 'green',  // Confirmed
                                3 => 'red',    // Cancelled
                                4 => 'blue'    // Completed
                            ];
                            $color = $statusColors[$notif['status_id']] ?? 'gray';
                            echo "<div class='flex-shrink-0 w-10 h-10 rounded-full bg-{$color}-100 flex items-center justify-center'>";
                            if (!empty($notif['profile_pic'])) {
                                echo '<img src="' . htmlspecialchars($notif['profile_pic']) . '" class="w-10 h-10 rounded-full object-cover" alt="Profile">';
                            } else {
                                echo "<svg class='w-6 h-6 text-{$color}-500' fill='none' stroke='currentColor' viewBox='0 0 24 24'>
                                        <path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2'></path>
                                    </svg>";
                            }
                            echo '</div>';
                            break;

                        case 'venue':
                            echo '<div class="flex-shrink-0 w-10 h-10 rounded-full bg-purple-100 flex items-center justify-center">
                                    <svg class="w-6 h-6 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                    </svg>
                                </div>';
                            break;

                        case 'price_update':
                            echo '<div class="flex-shrink-0 w-10 h-10 rounded-full bg-green-100 flex items-center justify-center">
                                    <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>';
                            break;

                        case 'account':
                            echo '<div class="flex-shrink-0 w-10 h-10 rounded-full bg-indigo-100 flex items-center justify-center">
                                    <svg class="w-6 h-6 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                </div>';
                            break;

                        default:
                            echo '<div class="flex-shrink-0 w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center">
                                    <svg class="w-6 h-6 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>';
                    }
                    ?>
                    <div class="flex-1 min-w-0">
                        <div class="flex items-start justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-900">
                                    <?php
                                    switch ($notif['type']) {
                                        case 'message':
                                            echo htmlspecialchars($notif['reference_name']) . ' sent you a message';
                                            break;
                                        case 'booking':
                                            echo 'New booking for ' . htmlspecialchars($notif['reference_name']);
                                            break;
                                        case 'booking_update':
                                            echo 'Booking update for ' . htmlspecialchars($notif['reference_name']);
                                            break;
                                        case 'venue':
                                            echo 'Venue listing update: ' . htmlspecialchars($notif['reference_name']);
                                            break;
                                        case 'price_update':
                                            echo 'Price update for ' . htmlspecialchars($notif['reference_name']);
                                            break;
                                        case 'account':
                                            echo 'Account update';
                                            break;
                                        default:
                                            echo htmlspecialchars($notif['message']);
                                    }
                                    ?>
                                </p>
                                <?php if (!empty($notif['additional_info'])): ?>
                                    <p class="text-sm text-gray-600 mt-1">
                                        <?php
                                        switch ($notif['type']) {
                                            case 'message':
                                                echo htmlspecialchars($notif['additional_info']);
                                                break;
                                            case 'booking':
                                            case 'booking_update':
                                                echo 'Total Amount: ' . htmlspecialchars($notif['additional_info']);
                                                break;
                                            default:
                                                echo htmlspecialchars($notif['additional_info']);
                                        }
                                        ?>
                                    </p>
                                <?php endif; ?>
                            </div>
                            <?php if (!$notif['is_read']): ?>
                                <span class="flex-shrink-0 w-2 h-2 bg-blue-600 rounded-full mt-2"></span>
                            <?php endif; ?>
                        </div>
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
                            } elseif ($secondsAgo < 604800) { // Less than a week
                                $days = floor($secondsAgo / 86400);
                                echo $days . " day" . ($days > 1 ? "s" : "") . " ago";
                            } else {
                                echo date('M j, Y g:i A', strtotime($notif['created_at']));
                            }
                            ?>
                        </p>
                    </div>
                </div>
            </div>
        <?php endforeach;
    endif;

    // Get the buffered content
    $notificationsHtml = ob_get_clean();

    // Return JSON response
    echo json_encode([
        'success' => true,
        'unreadCount' => $unreadCount,
        'notificationsHtml' => $notificationsHtml
    ]);

} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
}