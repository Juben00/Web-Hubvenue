<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl md:text-3xl font-semibold text-gray-800 mb-6 hidden md:block">Support and Helpdesk</h1>

    <!-- Customer Support Tickets Section -->
    <section id="support-tickets" class="bg-white rounded-lg shadow-md p-6 mb-8">
        <h2 class="text-xl font-semibold text-gray-800 mb-4">Customer Support Tickets</h2>
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="py-2 px-4 text-left">Ticket ID</th>
                        <th class="py-2 px-4 text-left">Customer</th>
                        <th class="py-2 px-4 text-left">Subject</th>
                        <th class="py-2 px-4 text-left">Status</th>
                        <th class="py-2 px-4 text-left">Actions</th>
                    </tr>
                </thead>
                <tbody id="supportTicketsTable">
                    <!-- Table rows will be populated by JavaScript -->
                </tbody>
            </table>
        </div>
    </section>

    <!-- Knowledge Base Section -->
    <section id="knowledge-base" class="bg-white rounded-lg shadow-md p-6 mb-8">
        <h2 class="text-xl font-semibold text-gray-800 mb-4">Knowledge Base</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4" id="knowledgeBaseArticles">
            <!-- Knowledge base articles will be populated by JavaScript -->
        </div>
        <button id="addArticleButton"
            class="mt-4 bg-primary text-white py-2 px-4 rounded hover:bg-blue-600 transition-colors">Add New
            Article</button>
    </section>

    <!-- Chat Support Section -->
    <section id="chat-support" class="bg-white rounded-lg shadow-md p-6 mb-8">
        <h2 class="text-xl font-semibold text-gray-800 mb-4">Chat Support</h2>
        <div id="chatWindow" class="border rounded-lg p-4 h-64 overflow-y-auto mb-4">
            <!-- Chat messages will be populated by JavaScript -->
        </div>
        <div class="flex">
            <input type="text" id="chatInput" class="flex-grow border rounded-l-lg p-2"
                placeholder="Type your message...">
            <button id="sendChatButton"
                class="bg-primary text-white py-2 px-4 rounded-r-lg hover:bg-blue-600 transition-colors">Send</button>
        </div>
    </section>
</div>