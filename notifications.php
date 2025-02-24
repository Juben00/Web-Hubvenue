<?php
session_start();
require_once './classes/account.class.php';
require_once './classes/notification.class.php';

// Check if user is logged in
if (!isset($_SESSION['user'])) {
    header("Location: ./login.php");
    exit();
}

$account = new Account();
$notification = new Notification();
$USER_ID = $_SESSION['user'];
$profileTemplate = $account->getProfileTemplate($USER_ID);

// Get notifications
$notifications = $notification->getUserNotifications($USER_ID, 50); // Get last 50 notifications
$unreadCount = $notification->getUnreadCount($USER_ID);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notifications - HubVenue</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
</head>

<body class="bg-gray-50 min-h-screen flex flex-col">
    <?php include './components/navbar.logged.in.php'; ?>

    <main class="flex-grow container mx-auto px-4 pt-24 pb-12">
        <div class="max-w-2xl mx-auto bg-white rounded-xl shadow-sm border border-gray-100">
            <!-- Header Section -->
            <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
                <div class="flex items-center gap-2">
                    <div class="relative">
                        <i class="fas fa-bell text-gray-900"></i>
                        <?php if ($unreadCount > 0): ?>
                            <span
                                class="absolute -top-1 -right-1 bg-red-500 text-[10px] text-white font-medium h-4 min-w-[16px] flex items-center justify-center rounded-full">
                                <?php echo $unreadCount > 99 ? '99+' : $unreadCount; ?>
                            </span>
                        <?php endif; ?>
                    </div>
                    <h1 class="text-xl font-semibold text-gray-900">Notifications</h1>
                </div>
                <?php if ($unreadCount > 0): ?>
                    <button onclick="markAllAsRead()" class="text-sm text-red-500 hover:text-red-600 font-medium">
                        Mark all as read
                    </button>
                <?php endif; ?>
            </div>

            <!-- Notifications List -->
            <div class="divide-y divide-gray-100">
                <?php if (empty($notifications)): ?>
                    <div class="px-6 py-12 text-center text-gray-500">
                        <div class="mb-4">
                            <i class="fas fa-bell text-gray-400 text-4xl"></i>
                        </div>
                        <p class="text-lg font-medium mb-1">No notifications yet</p>
                        <p class="text-sm text-gray-400">We'll notify you when something arrives</p>
                    </div>
                <?php else: ?>
                    <?php foreach ($notifications as $notif): ?>
                        <div class="notification-item px-6 py-4 hover:bg-gray-50/50 transition-colors"
                            data-type="<?php echo htmlspecialchars($notif['type']); ?>"
                            data-read="<?php echo $notif['is_read'] ? 'read' : 'unread'; ?>">
                            <div class="flex items-start gap-4">
                                <!-- Profile Picture/Icon -->
                                <div class="flex-shrink-0">
                                    <?php if (!empty($notif['profile_pic'])): ?>
                                        <div class="h-10 w-10 rounded-full bg-gray-200 overflow-hidden">
                                            <img src="./<?php echo htmlspecialchars($notif['profile_pic']); ?>" alt="Profile"
                                                class="w-full h-full object-cover">
                                        </div>
                                    <?php else: ?>
                                        <div class="h-10 w-10 rounded-full bg-gray-100 flex items-center justify-center">
                                            <span class="text-lg font-medium text-gray-600">
                                                <?php
                                                $name = explode(' ', $notif['sender_name'] ?? 'U')[0];
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

                                <!-- Status Icon (if needed) -->
                                <?php if ($notif['type'] === 'booking_update' || $notif['type'] === 'payment'): ?>
                                    <div class="flex-shrink-0">
                                        <i class="fas fa-check text-blue-500"></i>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </main>

    <?php include './components/footer.php'; ?>

    <script>
        function markAllAsRead() {
            fetch('./api/mark-notifications-read.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    user_id: <?php echo $USER_ID; ?>
                })
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Remove the mark all as read button
                        const markAllReadBtn = document.querySelector('button[onclick="markAllAsRead()"]');
                        if (markAllReadBtn) {
                            markAllReadBtn.remove();
                        }

                        // Update notification badge in navbar if it exists
                        const navBadge = document.querySelector('#notificationCount');
                        if (navBadge) {
                            navBadge.remove();
                        }

                        // Reload the page to show updated state
                        window.location.reload();
                    }
                });
        }
    </script>
</body>

</html>