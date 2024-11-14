<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Messages - HubVenue</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <base href="/">
</head>
<body class="bg-gray-50">
    <?php include __DIR__ . '/includes/nav.php'; ?>

    <main class="max-w-7xl mx-auto py-6 sm:px-6 pt-20 lg:px-8">
        <div class="bg-white rounded-lg shadow min-h-[600px]">
            <div class="grid grid-cols-3">
                <!-- Messages List -->
                <div class="col-span-1 border-r">
                    <div class="p-4 border-b">
                        <div class="relative">
                            <input type="text" placeholder="Search messages" class="w-full pl-10 pr-4 py-2 border rounded-lg">
                            <svg class="w-5 h-5 absolute left-3 top-2.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </div>
                    </div>
                    
                    <!-- Empty state for messages -->
                    <div class="p-6 text-center text-gray-500">
                        <svg class="w-12 h-12 mx-auto mb-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path>
                        </svg>
                        <p>No messages yet</p>
                        <p class="text-sm">When you have messages, they'll show up here</p>
                    </div>
                </div>

                <!-- Message Content -->
                <div class="col-span-2 p-6 text-center text-gray-500">
                    <svg class="w-16 h-16 mx-auto mb-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path>
                    </svg>
                    <h3 class="text-xl font-medium mb-2">Select a message</h3>
                    <p>Choose a conversation to view the messages</p>
                </div>
            </div>
        </div>
    </main>
</body>
</html> 