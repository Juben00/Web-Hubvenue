<?php
require_once './classes/notification.class.php';

$notification = new Notification();
$initialLimit = 10; // Define initial limit at the top
$totalCount = $notification->getTotalNotificationCount($_SESSION['user']); // Get total count
$notifications = $notification->getUserNotifications($_SESSION['user'], $initialLimit); // Use initial limit
$unreadCount = $notification->getUnreadCount($_SESSION['user']);

// Enhanced debugging
error_log("Debug Info:");
error_log("Total notifications count: " . $totalCount);
error_log("Initial limit: " . $initialLimit);
error_log("Number of notifications fetched: " . count($notifications));
error_log("Should show load more button: " . ($totalCount > $initialLimit ? "Yes" : "No"));
error_log("Session user ID: " . $_SESSION['user']);

// Group notifications by date
$groupedNotifications = [];
foreach ($notifications as $notif) {
    $date = date('Y-m-d', strtotime($notif['created_at']));
    if (!isset($groupedNotifications[$date])) {
        $groupedNotifications[$date] = [];
    }
    $groupedNotifications[$date][] = $notif;
}
?>

<!-- Overlay -->
<div id="notificationOverlay" class="hidden fixed inset-0 bg-black/20" style="margin-top: 80px;"></div>

<div id="notificationDropdown"
    class="hidden absolute right-0 mt-2 bg-white rounded-xl shadow-sm border border-gray-100 opacity-0 transform scale-95 transition-all duration-200 ease-out"
    style="width: 400px; height: 420px;">
    <!-- Header Section -->
    <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
        <div class="flex items-center gap-2">
            <div class="relative">
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
    <div class="notifications-wrapper" style="height: calc(420px - 65px);">
        <?php if (empty($notifications)): ?>
            <div class="px-6 py-12 text-center text-gray-500">
                <div class="mb-4">
                    <i class="fas fa-bell text-gray-400 text-4xl"></i>
                </div>
                <p class="text-lg font-medium mb-1">No notifications yet</p>
                <p class="text-sm text-gray-400">We'll notify you when something arrives</p>
            </div>
        <?php else: ?>
            <!-- Scrollable Container -->
            <div class="notifications-scroll-container">
                <!-- Notifications Container -->
                <div class="notifications-container">
                    <?php foreach ($notifications as $notif): ?>
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
                                            class="flex-shrink-0 w-5 h-5 rounded-full flex items-center justify-center text-gray-300 hover:text-gray-500 hover:bg-gray-100 transition-all">
                                        <i class="fas fa-check text-xs"></i>
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
                    <?php endforeach; ?>
                </div>
            </div>
            
            <!-- Load More Button - Outside the scroll container -->
            <?php 
            // Add visual debugging in the UI (temporary)
            echo "<!-- Debug: totalCount = {$totalCount}, initialLimit = {$initialLimit} -->";
            if ($totalCount > $initialLimit): 
            ?>
                <div id="loadMoreContainer" class="sticky-footer px-6 py-3 text-center border-t border-gray-100 bg-white">
                    <button onclick="loadMoreNotifications()" class="text-sm text-blue-500 hover:text-blue-600 font-medium">
                        See previous notifications
                    </button>
                </div>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</div>

<style>
/* Notification dropdown specific styles */
#notificationDropdown {
    box-shadow: 0 1px 2px 0 rgb(0 0 0 / 0.05);
    position: absolute;
    right: 0;
    margin-top: 8px;
    z-index: 50;
    transform-origin: top right;
    height: 420px;
    width: 400px;
    display: flex;
    flex-direction: column;
}

/* Header styles */
#notificationDropdown .flex.items-center.justify-between {
    padding-top: 0.875rem;
    padding-bottom: 0.875rem;
}

.notifications-wrapper {
    display: flex;
    flex-direction: column;
    position: relative;
    overflow: hidden;
    height: calc(420px - 65px);
}

.notifications-scroll-container {
    flex: 1;
    overflow-y: auto;
    position: relative;
    height: calc(100% - 44px);
}

.notifications-container {
    display: flex;
    flex-direction: column;
}

.notification-item {
    padding-top: 0.75rem;
    padding-bottom: 0.75rem;
}

.sticky-footer {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    background: white;
    border-top: 1px solid rgb(243 244 246);
    border-bottom-left-radius: 0.75rem;
    border-bottom-right-radius: 0.75rem;
    height: 44px;
    display: flex;
    align-items: center;
    justify-content: center;
}

/* Scrollbar styling */
.notifications-scroll-container::-webkit-scrollbar {
    width: 4px;
}

.notifications-scroll-container::-webkit-scrollbar-track {
    background: transparent;
}

.notifications-scroll-container::-webkit-scrollbar-thumb {
    background-color: rgb(203 213 225);
    border-radius: 2px;
}

.notifications-scroll-container::-webkit-scrollbar-thumb:hover {
    background-color: rgb(148 163 184);
}

/* Overlay positioning */
#notificationOverlay {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    z-index: 40;
    opacity: 0;
    transition: opacity 200ms ease-out;
}
</style>

<script>
    let notificationPolling;

    function toggleOverlay(show) {
        const overlay = document.getElementById('notificationOverlay');
        const dropdown = document.querySelector('#notificationDropdown');
        
        if (show) {
            overlay.classList.remove('hidden');
            // Trigger reflow
            overlay.offsetHeight;
            overlay.style.opacity = '1';
            dropdown.classList.remove('hidden');
            // Trigger reflow
            dropdown.offsetHeight;
            dropdown.classList.remove('opacity-0', 'scale-95');
        } else {
            overlay.style.opacity = '0';
            dropdown.classList.add('opacity-0', 'scale-95');
            // Wait for animation to finish before hiding
            setTimeout(() => {
                overlay.classList.add('hidden');
                dropdown.classList.add('hidden');
            }, 200);
        }
    }

    function loadNotifications() {
        fetch('./api/get-notifications.php')
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Update notification count badge
                    const countBadge = document.querySelector('#notificationCount');
                    if (data.unreadCount > 0) {
                        if (countBadge) {
                            countBadge.textContent = data.unreadCount > 99 ? '99+' : data.unreadCount;
                        } else {
                            const newBadge = document.createElement('span');
                            newBadge.id = 'notificationCount';
                            newBadge.className = 'notification-badge';
                            newBadge.textContent = data.unreadCount > 99 ? '99+' : data.unreadCount;
                            document.querySelector('#notificationButton').appendChild(newBadge);
                        }
                    } else if (countBadge) {
                        countBadge.remove();
                    }

                    // Update notifications list if dropdown is open
                    const dropdown = document.querySelector('#notificationDropdown');
                    if (!dropdown.classList.contains('hidden')) {
                        const scrollContainer = dropdown.querySelector('.divide-y');
                        const scrollPosition = scrollContainer ? scrollContainer.scrollTop : 0;
                        
                        dropdown.querySelector('.divide-y').innerHTML = data.notificationsHtml;
                        setupDropdownEventListeners();
                        
                        if (scrollContainer) {
                            scrollContainer.scrollTop = scrollPosition;
                        }
                    }
                }
            })
            .catch(error => console.error('Error loading notifications:', error));
    }

    function startNotificationPolling() {
        loadNotifications();
        notificationPolling = setInterval(loadNotifications, 30000);
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
                user_id: <?php echo $_SESSION['user']; ?>
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.querySelectorAll('.notification-item[data-read="unread"]').forEach(el => {
                    el.setAttribute('data-read', 'read');
                    el.classList.remove('bg-blue-50/50');
                });
                const countBadge = document.querySelector('#notificationCount');
                if (countBadge) countBadge.remove();
                loadNotifications();
            }
        });
    }

    function setupDropdownEventListeners() {
        // Add click event listeners for any interactive elements in the dropdown
        const markAllReadBtn = document.querySelector('#notificationDropdown button[onclick="markAllAsRead()"]');
        if (markAllReadBtn) {
            markAllReadBtn.addEventListener('click', markAllAsRead);
        }
    }

    // Toggle notification dropdown
    document.querySelector('#notificationButton').addEventListener('click', function(e) {
        e.preventDefault();
        e.stopPropagation();
        const dropdown = document.querySelector('#notificationDropdown');
        const isHidden = dropdown.classList.contains('hidden');
        
        // Close any other open dropdowns
        document.querySelectorAll('.dropdown-content').forEach(el => {
            if (el !== dropdown) el.classList.add('hidden');
        });

        if (isHidden) {
            toggleOverlay(true);
            loadNotifications();
            startNotificationPolling();
        } else {
            toggleOverlay(false);
            stopNotificationPolling();
        }
    });

    // Close dropdown when clicking outside
    document.addEventListener('click', function(event) {
        const dropdown = document.querySelector('#notificationDropdown');
        const button = document.querySelector('#notificationButton');

        if (!dropdown.contains(event.target) && !button.contains(event.target)) {
            dropdown.classList.add('hidden');
            toggleOverlay(false);
            stopNotificationPolling();
        }
    });

    // Close dropdown when pressing escape
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            const dropdown = document.querySelector('#notificationDropdown');
            if (!dropdown.classList.contains('hidden')) {
                dropdown.classList.add('hidden');
                toggleOverlay(false);
                stopNotificationPolling();
            }
        }
    });

    // Cleanup on page unload
    window.addEventListener('unload', () => {
        stopNotificationPolling();
        toggleOverlay(false);
    });

    function markAsRead(button, notificationId) {
        fetch('./api/mark-notification-read.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                notification_id: notificationId
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Update UI
                const notificationItem = button.closest('.notification-item');
                notificationItem.setAttribute('data-read', 'read');
                notificationItem.classList.remove('bg-blue-50/50');
                button.remove();

                // Update badge count
                const countBadge = document.querySelector('#notificationCount');
                const currentCount = parseInt(countBadge.textContent);
                if (currentCount > 1) {
                    countBadge.textContent = currentCount - 1;
                } else {
                    countBadge.remove();
                }
            }
        });
    }

    let currentPage = 1;
    const itemsPerPage = 10;

    function loadMoreNotifications() {
        currentPage++;
        fetch(`./api/get-notifications.php?page=${currentPage}&limit=${itemsPerPage}`)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Insert new notifications before the load more button
                    const container = document.querySelector('.notifications-container');
                    const loadMoreContainer = document.getElementById('loadMoreContainer');
                    
                    if (container && data.notificationsHtml) {
                        container.insertAdjacentHTML('beforeend', data.notificationsHtml);
                    }

                    // Remove "load more" button if no more notifications
                    if (!data.hasMore) {
                        loadMoreContainer?.remove();
                    }
                }
            })
            .catch(error => console.error('Error loading more notifications:', error));
    }
</script>