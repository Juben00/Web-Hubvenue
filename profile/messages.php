<main class="max-w-7xl mx-auto py-6 sm:px-6 pt-20 lg:px-8">
    <div class="bg-white rounded-lg shadow min-h-[calc(100vh-200px)]">
        <div class="grid grid-cols-3 h-full">
            <!-- Messages List -->
            <div class="col-span-1 border-r flex flex-col">
                <div class="p-4 border-b">
                    <div class="relative">
                        <input type="text" class="w-full pl-4 pr-10 py-3 h-12 border rounded-lg" placeholder="Search messages">
                        <svg class="w-5 h-5 absolute right-3 top-1/2 -translate-y-1/2 text-gray-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                </div>

                <!-- Empty state for messages -->
                <div class="flex-1 flex items-center justify-center p-6 text-center text-gray-500">
                    <div>
                        <svg class="w-12 h-12 mx-auto mb-4 text-gray-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z">
                            </path>
                        </svg>
                        <p>No messages yet</p>
                        <p class="text-sm">When you have messages, they'll show up here</p>
                    </div>
                </div>
            </div>

            <!-- Message Content -->
            <div class="col-span-2 flex items-center justify-center p-6 text-center text-gray-500">
                <div>
                    <svg class="w-16 h-16 mx-auto mb-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z">
                        </path>
                    </svg>
                    <h3 class="text-xl font-medium mb-2">Select a message</h3>
                    <p>Choose a conversation to view the messages</p>
                </div>
            </div>
        </div>
    </div>
</main>