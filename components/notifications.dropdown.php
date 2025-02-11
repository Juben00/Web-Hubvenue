<?php
require_once '../classes/notification.class.php';

session_start();

$notification = new Notification();
$notifications = $notification->getUserNotifications($_SESSION['user']);
$unreadCount = $notification->getUnreadCount($_SESSION['user']);
?>

<div id="notificationDropdown"
    class="hidden absolute right-0 mt-2 w-96 bg-white rounded-lg shadow-xl border border-gray-200 max-h-[32rem] overflow-y-auto">
    <div class="p-4 border-b border-gray-200">
        <div class="flex items-center justify-between">
            <h3 class="text-lg font-semibold">Notifications</h3>
            <?php if ($unreadCount > 0): ?>
                <button onclick="markAllAsRead()" class="text-sm text-blue-600 hover:text-blue-800">Mark all as
                    read</button>
            <?php endif; ?>
        </div>
    </div>

    <div class="divide-y divide-gray-200">
        <?php if (empty($notifications)): ?>
            <div class="p-4 text-center text-gray-500">
                <p>No notifications yet</p>
            </div>
        <?php else: ?>
            <?php foreach ($notifications as $notif): ?>
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
                                $timestamp = strtotime($notif['created_at']);
                                $timeAgo = time() - $timestamp;

                                if ($timeAgo < 60) {
                                    echo "Just now";
                                } elseif ($timeAgo < 3600) {
                                    echo floor($timeAgo / 60) . " minutes ago";
                                } elseif ($timeAgo < 86400) {
                                    echo floor($timeAgo / 3600) . " hours ago";
                                } else {
                                    echo floor($timeAgo / 86400) . " days ago";
                                }
                                ?>
                            </p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <div class="p-4 text-center border-t border-gray-200">
        <a href="./notifications.php" class="text-sm text-gray-600 hover:text-gray-900">See Previous Notifications</a>
    </div>
</div>

<script>
    let notificationPolling;

    function loadNotifications() {
        fetch('./api/get-notifications.php')
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Update notification count badge
                    const countBadge = document.querySelector('#notificationCount');
                    if (data.unreadCount > 0) {
                        if (countBadge) {
                            countBadge.textContent = data.unreadCount;
                        } else {
                            const newBadge = document.createElement('span');
                            newBadge.id = 'notificationCount';
                            newBadge.className = 'absolute -top-2 -right-2 bg-red-500 text-white text-xs font-bold rounded-full h-5 w-5 flex items-center justify-center';
                            newBadge.textContent = data.unreadCount;
                            document.querySelector('#notificationButton').appendChild(newBadge);
                        }
                    } else if (countBadge) {
                        countBadge.remove();
                    }

                    // Update notifications list if dropdown is open
                    const dropdown = document.querySelector('#notificationDropdown');
                    if (!dropdown.classList.contains('hidden')) {
                        const notificationsList = dropdown.querySelector('.divide-y');
                        if (notificationsList) {
                            notificationsList.innerHTML = data.notificationsHtml;
                        }
                    }
                }
            })
            .catch(error => console.error('Error loading notifications:', error));
    }

    function startNotificationPolling() {
        // Load immediately
        loadNotifications();
        // Then start polling every second
        notificationPolling = setInterval(loadNotifications, 1000);
    }

    function stopNotificationPolling() {
        if (notificationPolling) {
            clearInterval(notificationPolling);
            notificationPolling = null;
        }
    }

    function markAllAsRead() {
        fetch('./api/mark-notifications-read.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                user_id: <?php echo $_SESSION['user']['id']; ?>
            })
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Remove all unread indicators
                    document.querySelectorAll('.bg-blue-50').forEach(el => el.classList.remove('bg-blue-50'));
                    document.querySelectorAll('.bg-blue-600').forEach(el => el.remove());
                    // Update notification count
                    const countBadge = document.querySelector('#notificationCount');
                    if (countBadge) countBadge.remove();
                    // Force reload notifications
                    loadNotifications();
                }
            });
    }

    // Toggle notification dropdown
    document.querySelector('#notificationButton').addEventListener('click', function () {
        const dropdown = document.querySelector('#notificationDropdown');
        const isHidden = dropdown.classList.contains('hidden');

        dropdown.classList.toggle('hidden');

        if (isHidden) {
            // When opening dropdown
            loadNotifications(); // Load immediately
            startNotificationPolling(); // Start polling
        } else {
            // When closing dropdown
            stopNotificationPolling(); // Stop polling
        }
    });

    // Close dropdown when clicking outside
    document.addEventListener('click', function (event) {
        const dropdown = document.querySelector('#notificationDropdown');
        const button = document.querySelector('#notificationButton');

        if (!dropdown.contains(event.target) && !button.contains(event.target)) {
            dropdown.classList.add('hidden');
            stopNotificationPolling(); // Stop polling when closing
        }
    });

    // Start polling for notification count even when dropdown is closed
    startNotificationPolling();

    // Cleanup on page unload
    window.addEventListener('unload', stopNotificationPolling);
</script>