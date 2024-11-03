<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Archon HRIS Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#f41c1c',
                        secondary: '#F3F4F6',
                        'light-gray': '#F9FAFB',
                        'dark-gray': '#4B5563',
                    }
                }
            }
        };
    </script>
    <style>
        body {
            background-image: url('bg.jpg');
            background-size: cover;
            background-attachment: fixed;
        }
        
        .semi-transparent {
            background-color: rgba(255, 255, 255, 0.8);
        }

        .rounded-card {
            border-radius: 1rem;
        }

        .dark-mode {
            background: radial-gradient(circle at left, #121212 0%, #3D0000 50%, #000000 100%);
        }
        
        .dark-mode .bg-white {
            background-color: transparent;
        }

        .dark-mode .text-gray-600,
        .dark-mode .text-gray-700,
        .dark-mode .text-gray-800 {
            color: #D1D5DB;
        }

        .dark-mode table thead th,
        .dark-mode table tbody td {
            color: #FFFFFF;
        }

        .dark-mode .border-gray-800 {
            border-color: #4B5563;
        }

        .dark-mode .semi-transparent {
            background-color: rgba(31, 41, 55, 0.8);
            color: #FFFFFF;
        }

        .dark-mode .bg-light-gray {
            background-color: rgba(55, 65, 81, 0.8);
            color: #FFFFFF;
        }

        .h3 {
            color: #c10000;
        }

        .dark-mode #h1 {
            color: white;
        }
    </style>
</head>
<body class="text-gray-800 gradient-background">
    <div class="flex h-screen">
        <?php include 'sidebar.php'; ?>

        <div class="flex-1">
            <?php include 'topbar.php'; ?>

            <!-- Main Content -->
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100 main-content">
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
                        <button id="addArticleButton" class="mt-4 bg-primary text-white py-2 px-4 rounded hover:bg-blue-600 transition-colors">Add New Article</button>
                    </section>

                    <!-- Chat Support Section -->
                    <section id="chat-support" class="bg-white rounded-lg shadow-md p-6 mb-8">
                        <h2 class="text-xl font-semibold text-gray-800 mb-4">Chat Support</h2>
                        <div id="chatWindow" class="border rounded-lg p-4 h-64 overflow-y-auto mb-4">
                            <!-- Chat messages will be populated by JavaScript -->
                        </div>
                        <div class="flex">
                            <input type="text" id="chatInput" class="flex-grow border rounded-l-lg p-2" placeholder="Type your message...">
                            <button id="sendChatButton" class="bg-primary text-white py-2 px-4 rounded-r-lg hover:bg-blue-600 transition-colors">Send</button>
                        </div>
                    </section>
                </div>
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Sample JSON data
        const supportData = {
            supportTickets: [
                { id: 'T001', customer: 'John Doe', subject: 'Booking Issue', status: 'Open' },
                { id: 'T002', customer: 'Jane Smith', subject: 'Refund Request', status: 'In Progress' },
                { id: 'T003', customer: 'Bob Johnson', subject: 'Venue Inquiry', status: 'Closed' }
            ],
            knowledgeBase: [
                { id: 'KB001', title: 'How to Book a Venue', content: 'Step-by-step guide to booking a venue...' },
                { id: 'KB002', title: 'Cancellation Policy', content: 'Our cancellation policy details...' },
                { id: 'KB003', title: 'Payment Methods', content: 'We accept the following payment methods...' }
            ],
            chatMessages: [
                { sender: 'Customer', message: 'Hi, I need help with my booking.' },
                { sender: 'Support', message: 'Hello! I\'d be happy to assist you. What seems to be the issue?' }
            ]
        };

        // Function to update the support page with data
        function updateSupportPage(data) {
            // Update support tickets table
            const ticketsTable = document.getElementById('supportTicketsTable');
            ticketsTable.innerHTML = '';
            data.supportTickets.forEach(ticket => {
                const row = ticketsTable.insertRow();
                row.innerHTML = `
                    <td class="py-2 px-4">${ticket.id}</td>
                    <td class="py-2 px-4">${ticket.customer}</td>
                    <td class="py-2 px-4">${ticket.subject}</td>
                    <td class="py-2 px-4">${ticket.status}</td>
                    <td class="py-2 px-4">
                        <button class="bg-blue-500 text-white py-1 px-2 rounded hover:bg-blue-600 transition-colors">View</button>
                    </td>
                `;
            });

            // Update knowledge base articles
            const knowledgeBaseSection = document.getElementById('knowledgeBaseArticles');
            knowledgeBaseSection.innerHTML = '';
            data.knowledgeBase.forEach(article => {
                const articleDiv = document.createElement('div');
                articleDiv.className = 'bg-gray-50 p-4 rounded-lg';
                articleDiv.innerHTML = `
                    <h3 class="font-semibold mb-2">${article.title}</h3>
                    <p class="text-sm text-gray-600">${article.content.substring(0, 100)}...</p>
                    <button class="mt-2 text-primary hover:underline">Read More</button>
                `;
                knowledgeBaseSection.appendChild(articleDiv);
            });

            // Update chat messages
            const chatWindow = document.getElementById('chatWindow');
            chatWindow.innerHTML = '';
            data.chatMessages.forEach(message => {
                const messageDiv = document.createElement('div');
                messageDiv.className = `mb-2 ${message.sender === 'Customer' ? 'text-right' : 'text-left'}`;
                messageDiv.innerHTML = `
                    <span class="inline-block bg-gray-200 rounded-lg py-2 px-4 text-sm">
                        <strong>${message.sender}:</strong> ${message.message}
                    </span>
                `;
                chatWindow.appendChild(messageDiv);
            });
        }

        // Initialize the support page with sample data
        updateSupportPage(supportData);

        // Handle add new article button click
        document.getElementById('addArticleButton').addEventListener('click', function() {
            alert('Add new knowledge base article functionality would be implemented here.');
        });

        // Handle send chat message button click
        document.getElementById('sendChatButton').addEventListener('click', function() {
            const chatInput = document.getElementById('chatInput');
            const message = chatInput.value.trim();
            if (message) {
                supportData.chatMessages.push({ sender: 'Support', message: message });
                updateSupportPage(supportData);
                chatInput.value = '';
            }
        });
    </script>
</body>
</html>