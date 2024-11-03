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
            /* Uncomment this line */
            background-size: cover;
            /* Add this line to ensure the image covers the entire body */
            background-attachment: fixed;
            /* Add this to keep the background fixed while scrolling */
        }

        .topbar,
        .sidebar {
            background-color: rgba(255, 255, 255, 0.1) !important;
            backdrop-filter: blur(10px);
        }

        .sidebar-brand,
        .sidebar-heading,
        .nav-item {
            background-color: transparent;
        }

        .gradient-background {
            background: radial-gradient(circle at left, #F3F4F6 0%, #E5E7EB 50%, #D1D5DB 100%);
        }

        #sidebar nav a:hover,
        #sidebar nav button:hover {
            background-color: #f41c1c;
            color: white;
            border-radius: 0.5rem;
        }

        #sidebar nav a,
        #sidebar nav button {
            color: #1F2937;
        }

        #sidebar.w-16 nav a,
        #sidebar.w-16 nav button {
            justify-content: center;
        }

        #sidebar.w-16 nav a svg,
        #sidebar.w-16 nav button svg {
            margin-left: 0;
            margin-right: 0;
        }

        #sidebar nav a,
        #sidebar nav button {
            margin: 0.25rem 0.5rem;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            padding: 0.5rem 0.75rem;
            border-radius: 0.5rem 0 0 0.5rem;
            justify-content: flex-start;
            width: calc(100% - 1rem);
            overflow: hidden;
        }

        #sidebar nav a svg,
        #sidebar nav button svg {
            min-width: 1.25rem;
            width: 1.25rem;
            height: 1.25rem;
            margin-right: 0.75rem;
        }

        #sidebar nav a span,
        #sidebar nav button span {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        #sidebar nav a:hover,
        #sidebar nav button:hover {
            background-color: #e60e0e;
            color: white;
            border-radius: 0.5rem 0 0 0.5rem;
            margin-right: 0;
            width: calc(100% - 0.5rem);
        }

        #sidebar.w-16 nav a,
        #sidebar.w-16 nav button {
            justify-content: center;
            padding: 0.5rem;
            margin: 0.25rem;
            width: calc(100% - 0.5rem);
            border-radius: 0.5rem;
        }

        #sidebar.w-16 nav a:hover,
        #sidebar.w-16 nav button:hover {
            border-radius: 0.5rem;
            width: calc(100% - 0.5rem);
        }

        #sidebar {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        #sidebar nav {
            width: 100%;
        }

        #sidebar nav a,
        #sidebar nav button {
            margin: 0.50rem 0.5rem;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            padding: 0.5rem 0.75rem;
            border-radius: 0.5rem 0 0 0.5rem;
        }

        #sidebar.w-16 {
            border-right: none;
        }

        #darkModeToggle:checked+label div {
            transform: translateX(100%);
            background-color: #1F2937;
        }

        #darkModeToggle:checked+label .sun {
            display: none;
        }

        #darkModeToggle:checked+label .moon {
            display: block;
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
            /* Set text color to white in dark mode */
        }


        .dark-mode .border-gray-800 {
            border-color: #4B5563;
        }

        .dark-mode .hover\:text-gray-800:hover {
            color: #F3F4F6;
        }

        .dark-mode .bg-gray-100 {
            background-color: transparent;
        }


        * New dark mode styles for sidebar and card components */ .dark-mode #sidebar {
            background-color: rgba(0, 0, 0, 0.5);
        }

        .dark-mode #sidebar nav a,
        .dark-mode #sidebar nav button,
        .dark-mode #sidebar .sidebar-full {
            color: #FFFFFF;
        }

        .dark-mode #sidebar nav a:hover,
        .dark-mode #sidebar nav button:hover {
            background-color: #f41c1c;
            color: #FFFFFF;
        }

        .dark-mode .semi-transparent {
            background-color: rgba(31, 41, 55, 0.8);
            color: #FFFFFF;
        }

        .dark-mode .bg-light-gray {
            background-color: rgba(55, 65, 81, 0.8);
            color: #FFFFFF;
        }

        .dark-mode .text-gray-800 .h1 {
            color: #FFFFFF;
        }

        .dark-mode .border-gray-300 {
            border-color: #4B5563;
        }

        /* Dark mode styles */

        .dark-mode .hover:text-gray-800:hover {
            color: #F3F4F6;
        }

        .dark-mode .bg-gray-100 {
            background-color: transparent;
        }

        .dark-mode .text-gray-600,
        .dark-mode .text-gray-700,
        .dark-mode .text-gray-800 {
            color: #E5E7EB;
            /* Lighter gray for better contrast */
        }

        .dark-mode table thead th,
        .dark-mode table tbody td {
            color: #E5E7EB;
            /* Lighter text color for tables */
        }

        .dark-mode .text-muted-foreground {
            color: #9CA3AF;
            /* Adjust muted text color */
        }

        .dark-mode .bg-background {
            background-color: #ffffff;
            /* Darker background for better contrast */
        }

        .dark-mode .border-input {
            border-color: #374151;
            /* Adjust border color for inputs */
        }

        .dark-mode .placeholder\:text-muted-foreground::placeholder {
            color: #000000;
            /* Adjust placeholder text color */
        }


        /* New dark mode styles for sidebar and card components */
        .dark-mode #sidebar {
            background-color: transparent;
        }

        .dark-mode #sidebar nav a,
        .dark-mode #sidebar nav button,
        .dark-mode #sidebar .sidebar-full {
            color: #FFFFFF;
        }

        .dark-mode #sidebar nav a:hover,
        .dark-mode #sidebar nav button:hover {
            background-color: #f41c1c;
            color: #FFFFFF;
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
        <!-- Sidebar -->
        <div id="sidebar" class="w-64 bg-white  transition-all duration-300 ease-in-out flex flex-col h-screen">
            <div class="p-4 w-full flex justify-center ">
                <img src="logo only.png" alt="Archon Logo" class="w-16 h-16 mb-20 transition-all duration-300">
            </div>
            <div class="px-4 w-full mb-4 sidebar-full">
                <div class="flex">
                    <input type="text" placeholder="Search..."
                        class="w-full p-2 border rounded bg-white text-gray-800 search-input">
                    <button class="bg-red-500 text-white p-2 rounded ml-2 search-button">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </button>
                </div>
            </div>
            <!-- Updated search icon for collapsed state -->
            <div class="hidden px-4 w-full mb-4 sidebar-collapsed-search">
                <button class="flex items-center text-white bg-primary hover:bg-red-900 w-full px-4 py-2 rounded-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                        class="w-5 h-5 mx-auto">
                        <path d="M8.25 10.875a2.625 2.625 0 1 1 5.25 0 2.625 2.625 0 0 1-5.25 0Z" />
                        <path fill-rule="evenodd"
                            d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25Zm-1.125 4.5a4.125 4.125 0 1 0 2.338 7.524l2.007 2.006a.75.75 0 1 0 1.06-1.06l-2.006-2.007a4.125 4.125 0 0 0-3.399-6.463Z"
                            clip-rule="evenodd" />
                    </svg>
                </button>
            </div>
            <nav class="flex-grow w-full overflow-y-auto">
                <a href="dashboard.html"
                    class="flex items-center text-gray-800 hover:bg-red-900 hover:text-white w-full px-4 py-2">
                    <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                        <path
                            d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z" />
                    </svg>
                    <span class="sidebar-full">Dashboard</span>
                </a>

                <a href="venue.html"
                    class="flex items-center text-gray-800 hover:bg-red-900 hover:text-white w-full px-4 py-2">
                    <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M3 12v3c0 1.657 3.134 3 7 3s7-1.343 7-3v-3c0 1.657-3.134 3-7 3s-7-1.343-7-3z" />
                        <path d="M3 7v3c0 1.657 3.134 3 7 3s7-1.343 7-3V7c0 1.657-3.134 3-7 3S3 8.657 3 7z" />
                        <path d="M17 5c0 1.657-3.134 3-7 3s-7-1.343-7-3v-3c0 1.657 3.134 3 7 3s7-1.343 7-3z" />
                    </svg>
                    <span class="sidebar-full">Venue Management</span>
                </a>

                <a href="reservation.html"
                    class="flex items-center text-gray-800 hover:bg-red-900 hover:text-white w-full px-4 py-2">
                    <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                        <path
                            d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z" />
                    </svg>
                    <span class="sidebar-full">Reservation Management</span>
                </a>

                <a href="financials.html"
                    class="flex items-center text-gray-800 hover:bg-red-900 hover:text-white w-full px-4 py-2">
                    <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                        <path
                            d="M5.5 2A1.5 1.5 0 004 3.5V4h12v-.5A1.5 1.5 0 0014.5 2h-9zM2 7.5A1.5 1.5 0 013.5 6h13A1.5 1.5 0 0118 7.5V8H2v-.5zM0 4.5A1.5 1.5 0 011.5 3h13A1.5 1.5 0 0116 4.5V5H0v-.5zM2 12.5A1.5 1.5 0 013.5 11h13A1.5 1.5 0 0118 12.5V13H2v-.5zM0 10.5A1.5 1.5 0 011.5 9h13A1.5 1.5 0 0116 10.5V11H0v-.5zM3.5 14A1.5 1.5 0 002 15.5V16h16v-.5a1.5 1.5 0 00-1.5-1.5h-13zM0 13.5A1.5 1.5 0 011.5 12h13A1.5 1.5 0 0116 13.5V14H0v-.5z" />
                    </svg>
                    <span class="sidebar-full">Financial Management</span>
                </a>

                <a href="reports-analytics.html"
                    class="flex items-center text-gray-800 hover:bg-red-900 hover:text-white w-full px-4 py-2">
                    <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M4 4a2 2 0 00-2 2v1h16V6a2 2 0 00-2-2H4z" />
                        <path fill-rule="evenodd"
                            d="M18 9H2v5a2 2 0 002 2h12a2 2 0 002-2V9zM4 13a1 1 0 011-1h1a1 1 0 110 2H5a1 1 0 01-1-1zm5-1a1 1 0 100 2h1a1 1 0 100-2H9z"
                            clip-rule="evenodd" />
                    </svg>
                    <span class="sidebar-full">Reports and Analytics</span>
                </a>

                <a href="notifications.html"
                    class="flex items-center text-gray-800 hover:bg-red-900 hover:text-white w-full px-4 py-2">
                    <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 2a8 8 0 100 16 8 8 0 000-16zM5 8h10v2H5V8zm0 4h10v2H5v-2z" />
                    </svg>
                    <span class="sidebar-full">Notifications and Alerts</span>
                </a>

                <a href="content-management.html"
                    class="flex items-center text-gray-800 hover:bg-red-900 hover:text-white w-full px-4 py-2">
                    <svg class="w-5 h-5 min-w-[1.25rem] mr-3" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z"
                            clip-rule="evenodd" />
                    </svg>
                    <span class="sidebar-full whitespace-nowrap overflow-hidden text-ellipsis">Content Management</span>
                </a>

                <a href="promotions.html"
                    class="flex items-center text-gray-800 hover:bg-red-900 hover:text-white w-full px-4 py-2">
                    <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z"
                            clip-rule="evenodd" />
                    </svg>
                    <span class="sidebar-full">Promotions and Marketing</span>
                </a>

                <a href="support.html"
                    class="flex items-center text-gray-800 hover:bg-red-900 hover:text-white w-full px-4 py-2">
                    <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                        <path
                            d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z" />
                    </svg>
                    <span class="sidebar-full">Support and Helpdesk</span>
                </a>

                <a href="settings.html"
                    class="flex items-center text-gray-800 hover:bg-red-900 hover:text-white w-full px-4 py-2">
                    <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z"
                            clip-rule="evenodd" />
                    </svg>
                    <span class="sidebar-full">Settings</span>
                </a>

                <a href="audit.html"
                    class="flex items-center text-gray-800 hover:bg-red-900 hover:text-white w-full px-4 py-2">
                    <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z"
                            clip-rule="evenodd" />
                    </svg>
                    <span class="sidebar-full">Audit Logs</span>
                </a>
            </nav>
            <!-- Logout button -->
            <div class="w-full mt-auto mb-4">
                <!-- Added mt-auto to push it to the bottom, and mb-4 for some bottom margin -->
                <button class="flex items-center text-gray-800 hover:bg-red-900 hover:text-white w-full px-4 py-2">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                        </path>
                    </svg>
                    <span class="sidebar-full">Logout</span>
                </button>
            </div>
        </div>

        <!-- Dashboard Content -->



        <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100">

            <!-- Top Navigation -->
            <header class="bg-white  flex justify-between items-center p-4">
                <div class="flex items-center">
                    <!-- Sidebar Toggle Button -->
                    <button onclick="toggleSidebar()" class="text-gray-500 hover:text-gray-700" title="Toggle Sidebar">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M0 0h24v24H0z" fill="none" />
                            <path d="M3 18h18v-2H3v2zm0-5h18v-2H3v2zm0-7v2h18V6H3z" />
                        </svg>
                    </button>
                    <h1 class=" text-2xl font-bold ml-4" id="h1" for="darkModeToggle">HubVenue Admin</h1>
                </div>
                <!-- Dark Mode Toggle (Centered) -->
                <div class="flex items-center">
                    <input type="checkbox" id="darkModeToggle" class="hidden">
                    <label for="darkModeToggle"
                        class="w-12 h-6 rounded-full bg-white-300 flex items-center cursor-pointer relative mx-2">
                        <div
                            class="w-5 h-5 rounded-full bg-white absolute left-0.5 transition-transform duration-300 ease-in-out flex items-center justify-center">
                            <svg class="w-4 h-4 text-yellow-500 sun" xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 24 24" fill="currentColor">
                                <path
                                    d="M12 2.25a.75.75 0 0 1 .75.75v2.25a.75.75 0 0 1-1.5 0V3a.75.75 0 0 1 .75-.75ZM7.5 12a4.5 4.5 0 1 1 9 0 4.5 4.5 0 0 1-9 0ZM18.894 6.166a.75.75 0 0 0-1.06-1.06l-1.591 1.59a.75.75 0 1 0 1.06 1.061l1.591-1.591ZM21.75 12a.75.75 0 0 1-.75.75h-2.25a.75.75 0 0 1 0-1.5H21a.75.75 0 0 1 .75.75ZM17.834 18.894a.75.75 0 0 0 1.06-1.06l-1.59-1.591a.75.75 0 1 0-1.061 1.06l1.59 1.591ZM12 18a.75.75 0 0 1 .75.75V21a.75.75 0 0 1-1.5 0v-2.25A.75.75 0 0 1 12 18ZM7.758 17.303a.75.75 0 0 0-1.061-1.06l-1.59-1.591a.75.75 0 0 0-1.061 1.06l1.59 1.591ZM6 12a.75.75 0 0 1-.75.75H3a.75.75 0 0 1 0-1.5h2.25A.75.75 0 0 1 6 12ZM6.697 7.757a.75.75 0 0 0 1.06-1.06l-1.59-1.591a.75.75 0 0 0-1.061 1.06l1.59 1.591Z" />
                            </svg>
                            <svg class="w-4 h-4 text-gray-600 moon hidden" xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 24 24" fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M9.528 1.718a.75.75 0 0 1 .162.819A8.97 8.97 0 0 0 9 6a9 9 0 0 0 9 9 8.97 8.97 0 0 0 3.463-.69.75.75 0 0 1 .981.98 10.503 10.503 0 0 1-9.694 6.46c-5.799 0-10.5-4.7-10.5-10.5 0-4.368 2.667-8.112 6.46-9.694a.75.75 0 0 1 .818.162Z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                    </label>
                </div>



                <div class="flex items-center space-x-4">
                    <button onclick="toggleFullscreen()" class="text-gray-600 hover:text-gray-800" title="Fullscreen">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 9V5a2 2 0 012-2h6a2 2 0 012 2v4m-6 10v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4m8-10h4a2 2 0 012 2v4m-6 10h4a2 2 0 002-2v-4" />
                        </svg>
                    </button>
                    <button class="text-gray-600 hover:text-gray-800">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9">
                            </path>
                        </svg>
                    </button>
                    <button class="text-gray-600 hover:text-gray-800">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z">
                            </path>
                        </svg>
                    </button>
                    <button class="text-gray-600 hover:text-gray-800">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.724 1.724 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.724 1.724 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.723 1.723 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.724 1.724 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.724 1.724 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.724 1.724 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z"
                                clip-rule="evenodd" />
                        </svg>
                    </button>
                    <button class="bg-gray-800 rounded-full w-8 h-8"></button>
                </div>
            </header>


            <div class="container mx-auto px-6 py-8">
                <!-- Main Content -->
                <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100 main-content">
                    <div class="container mx-auto px-4 py-8">
                        <h1 class="text-2xl md:text-3xl font-semibold text-gray-800 mb-6 hidden md:block">User
                            Management</h1>

                        <div class="container mx-auto px-6 py-8">
                            <!-- Create User Modal -->
                            <div id="createUserModal"
                                class="fixed inset-0 bg-gray-800 bg-opacity-50 items-center justify-center hidden">
                                <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-md">
                                    <h2 class="text-xl font-semibold mb-4">Create New User</h2>
                                    <form id="createUserForm">
                                        <div class="mb-4">
                                            <label for="userName" class="block text-gray-700">Name</label>
                                            <input type="text" id="userName" class="w-full p-2 border rounded" required>
                                        </div>
                                        <div class="mb-4">
                                            <label for="userEmail" class="block text-gray-700">Email</label>
                                            <input type="email" id="userEmail" class="w-full p-2 border rounded"
                                                required>
                                        </div>
                                        <div class="mb-4">
                                            <label for="userPassword" class="block text-gray-700">Password</label>
                                            <input type="password" id="userPassword" class="w-full p-2 border rounded"
                                                required>
                                        </div>
                                        <div class="mb-4">
                                            <label for="userRole" class="block text-gray-700">Role</label>
                                            <select id="userRole" class="w-full p-2 border rounded">
                                                <option value="Admin">Admin</option>
                                                <option value="User">Client</option>
                                                <option value="User">User</option>
                                            </select>
                                        </div>
                                        <div class="flex justify-end">
                                            <button type="button" class="bg-gray-500 text-white px-4 py-2 rounded mr-2"
                                                onclick="closeCreateUserModal()">Cancel</button>
                                            <button type="submit"
                                                class="bg-primary text-white px-4 py-2 rounded">Create</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <!-- End of Create User Modal -->
                            <section class="bg-white rounded-lg shadow-md p-6 mb-8">
                                <div class="flex justify-between items-center mb-4">
                                    <h2 class="text-xl font-semibold text-gray-800">Manage Users</h2>
                                    <!-- Create User Button -->
                                    <button class="bg-primary text-white px-4 py-2 rounded hover:bg-red-700"
                                        onclick="openCreateUserModal()">
                                        Create User
                                    </button>
                                </div>
                                <div class="overflow-x-auto">
                                    <table class="min-w-full bg-white">
                                        <thead class="bg-gray-100">
                                            <tr>
                                                <th class="py-2 px-4 text-left">User ID</th>
                                                <th class="py-2 px-4 text-left">Name</th>
                                                <th class="py-2 px-4 text-left">Email</th>
                                                <th class="py-2 px-4 text-left">Role</th>
                                                <th class="py-2 px-4 text-left">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody id="userTable">
                                            <!-- Table rows will be populated by JavaScript -->
                                        </tbody>
                                    </table>
                                </div>
                            </section>
                        </div>
                    </div>
                </main>
            </div>
            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>



            <script>




                const usersData = [
                    { id: 1, name: 'Joevin Ansoc', email: 'joevin@example.com', role: 'Admin' },
                    { id: 2, name: 'Randolf Marba', email: 'randolf@example.com', role: 'User' },
                    { id: 3, name: 'Hui Fon', email: 'huifon@example.com', role: 'User' }
                ];


                // Function to populate the user table
                function populateUserTable(data) {
                    const userTable = document.getElementById('userTable');
                    userTable.innerHTML = '';
                    data.forEach(user => {
                        const row = userTable.insertRow();
                        row.insertCell(0).textContent = user.id;
                        row.insertCell(1).textContent = user.name;
                        row.insertCell(2).textContent = user.email;
                        row.insertCell(3).textContent = user.role;
                        const actionsCell = row.insertCell(4);
                        actionsCell.innerHTML = '<button class="text-blue-500 hover:underline">Edit</button> <button class="text-red-500 hover:underline">Delete</button>';
                    });
                }

                // Initialize the user table with sample data
                populateUserTable(usersData);

                function openCreateUserModal() {
                    document.getElementById('createUserModal').classList.remove('hidden');
                }

                function closeCreateUserModal() {
                    document.getElementById('createUserModal').classList.add('hidden');
                }

                document.getElementById('createUserForm').addEventListener('submit', function (event) {
                    event.preventDefault();
                    const name = document.getElementById('userName').value;
                    const email = document.getElementById('userEmail').value;
                    const role = document.getElementById('userRole').value;

                    // Add the new user to the usersData array
                    const newUser = {
                        id: usersData.length + 1,
                        name: name,
                        email: email,
                        role: role
                    };
                    usersData.push(newUser);

                    // Update the user table
                    populateUserTable(usersData);

                    // Close the modal
                    closeCreateUserModal();
                });

















                // Ensure the dark mode toggle is working
                const darkModeToggle = document.getElementById('darkModeToggle');
                const body = document.body;

                darkModeToggle.addEventListener('change', () => {
                    body.classList.toggle('dark-mode');
                });

                // Sample JSON data (in a real application, this would come from an API)
                const dashboardData = {
                    totalReservations: 1234,
                    completedReservations: 980,
                    upcomingReservations: 234,
                    canceledReservations: 20,
                    totalEarnings: 50000,
                    monthlyEarnings: 15000,
                    venueOccupancy: 75,
                    newBookings: 15,
                    upcomingReservationsList: [
                        { date: '2023-09-30', venue: 'Grand Hall', customer: 'John Doe', status: 'Confirmed' },
                        { date: '2023-10-01', venue: 'Garden Terrace', customer: 'Jane Smith', status: 'Pending' },
                        { date: '2023-10-02', venue: 'Conference Room A', customer: 'Bob Johnson', status: 'Confirmed' }
                    ],
                    financialData: {
                        income: [10000, 15000, 20000, 18000, 25000, 30000],
                        expenses: [8000, 10000, 12000, 15000, 18000, 20000]
                    },
                    paymentBreakdown: {
                        completed: 45000,
                        pending: 5000,
                        refunded: 500
                    },
                    popularVenues: [
                        { name: 'Grand Hall', bookings: 50 },
                        { name: 'Garden Terrace', bookings: 45 },
                        { name: 'Conference Room A', bookings: 30 }
                    ],
                    venueAvailability: [
                        { name: 'Grand Hall', available: true },
                        { name: 'Garden Terrace', available: false },
                        { name: 'Conference Room A', available: true },
                        { name: 'Conference Room B', available: true }
                    ]
                };

                // Function to update the dashboard with data
                function updateDashboard(data) {
                    // Update overview section
                    document.getElementById('totalReservations').textContent = data.totalReservations;
                    document.getElementById('completedReservations').textContent = data.completedReservations;
                    document.getElementById('upcomingReservations').textContent = data.upcomingReservations;
                    document.getElementById('canceledReservations').textContent = data.canceledReservations;
                    document.getElementById('totalEarnings').textContent = `$${data.totalEarnings.toLocaleString()}`;
                    document.getElementById('monthlyEarnings').textContent = `$${data.monthlyEarnings.toLocaleString()}`;
                    document.getElementById('venueOccupancy').textContent = `${data.venueOccupancy}%`;
                    document.getElementById('newBookings').textContent = data.newBookings;

                    // Update upcoming reservations table
                    const tableBody = document.getElementById('upcomingReservationsTable');
                    tableBody.innerHTML = '';
                    data.upcomingReservationsList.forEach(reservation => {
                        const row = tableBody.insertRow();
                        row.insertCell(0).textContent = reservation.date;
                        row.insertCell(1).textContent = reservation.venue;
                        row.insertCell(2).textContent = reservation.customer;
                        row.insertCell(3).textContent = reservation.status;
                    });

                    // Update financial dashboard
                    document.getElementById('completedPayments').textContent = `$${data.paymentBreakdown.completed.toLocaleString()}`;
                    document.getElementById('pendingPayments').textContent = `$${data.paymentBreakdown.pending.toLocaleString()}`;
                    document.getElementById('refundedPayments').textContent = `$${data.paymentBreakdown.refunded.toLocaleString()}`;

                    // Update income vs expenses chart
                    const ctx = document.getElementById('incomeExpensesChart').getContext('2d');
                    new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                            datasets: [{
                                label: 'Income',
                                data: data.financialData.income,
                                borderColor: 'rgb(75, 192, 192)',
                                tension: 0.1
                            }, {
                                label: 'Expenses',
                                data: data.financialData.expenses,
                                borderColor: 'rgb(255, 99, 132)',
                                tension: 0.1
                            }]
                        },
                        options: {
                            responsive: true,
                            scales: {
                                y: {
                                    beginAtZero: true
                                }
                            }
                        }
                    });

                    // Update popular venues
                    const popularVenuesList = document.getElementById('popularVenues');
                    popularVenuesList.innerHTML = '';
                    data.popularVenues.forEach(venue => {
                        const li = document.createElement('li');
                        li.textContent = `${venue.name} - ${venue.bookings} bookings`;
                        popularVenuesList.appendChild(li);
                    });

                    // Update venue availability
                    const venueAvailabilityDiv = document.getElementById('venueAvailability');
                    venueAvailabilityDiv.innerHTML = '';
                    data.venueAvailability.forEach(venue => {
                        const p = document.createElement('p');
                        p.textContent = `${venue.name}: ${venue.available ? 'Available' : 'Booked'}`;
                        p.className = venue.available ? 'text-green-600' : 'text-red-600';
                        venueAvailabilityDiv.appendChild(p);
                    });
                }

                // Initialize the dashboard with sample data
                updateDashboard(dashboardData);

                // Handle logout button click
                document.getElementById('logoutButton').addEventListener('click', function () {
                    alert('Logout functionality would be implemented here.');
                });

                // Handle account settings form submission
                document.getElementById('accountSettingsForm').addEventListener('submit', function (e) {
                    e.preventDefault();
                    alert('Account settings update functionality would be implemented here.');
                });

                // Modified mobile menu toggle functionality
                document.querySelector('.mobile-menu').addEventListener('click', function (event) {
                    event.stopPropagation();
                    const sidebar = document.querySelector('.desktop-sidebar');
                    sidebar.classList.toggle('show');
                });

                // Close sidebar when clicking outside of it
                document.addEventListener('click', function (event) {
                    const sidebar = document.querySelector('.desktop-sidebar');
                    const mobileMenu = document.querySelector('.mobile-menu');
                    if (!sidebar.contains(event.target) && !mobileMenu.contains(event.target) && sidebar.classList.contains('show')) {
                        sidebar.classList.remove('show');
                    }
                });

                // Prevent clicks inside the sidebar from closing it
                document.querySelector('.desktop-sidebar').addEventListener('click', function (event) {
                    event.stopPropagation();
                });





                function toggleSidebar() {
                    const sidebar = document.getElementById('sidebar');
                    const logo = document.querySelector('#sidebar img');
                    const sidebarFullElements = document.querySelectorAll('.sidebar-full');
                    const icons = document.querySelectorAll('#sidebar nav a svg, #sidebar nav button svg, #sidebar > div:last-child button svg');
                    const navItems = document.querySelectorAll('#sidebar nav a, #sidebar nav button, #sidebar > div:last-child button');
                    const searchInput = document.querySelector('.search-input');
                    const searchButton = document.querySelector('.search-button');
                    const collapsedSearch = document.querySelector('.sidebar-collapsed-search');
                    const logoutButton = document.querySelector('#sidebar > div:last-child button');
                    const logoutIcon = logoutButton.querySelector('svg');
                    const logoutText = logoutButton.querySelector('span');

                    sidebar.classList.toggle('w-64');
                    sidebar.classList.toggle('w-16');

                    // Toggle logo size
                    logo.classList.toggle('w-12');
                    logo.classList.toggle('h-12');
                    logo.classList.toggle('w-8');
                    logo.classList.toggle('h-8');

                    sidebarFullElements.forEach(element => {
                        element.classList.toggle('hidden');
                    });

                    navItems.forEach(item => {
                        item.classList.toggle('justify-center');
                        item.classList.toggle('px-4');
                        item.classList.toggle('px-2');
                    });

                    icons.forEach(icon => {
                        icon.classList.toggle('mr-3');
                        icon.classList.toggle('mr-0');
                    });

                    sidebar.classList.toggle('border-r-0');

                    // Toggle search input and button
                    searchInput.parentElement.classList.toggle('hidden');
                    collapsedSearch.classList.toggle('hidden');

                    // Align collapsed search with other icons
                    collapsedSearch.querySelector('button').classList.toggle('justify-center');
                    collapsedSearch.querySelector('button').classList.toggle('px-4');
                    collapsedSearch.querySelector('button').classList.toggle('px-2');

                    // Adjust logout button
                    logoutButton.classList.toggle('justify-center');
                    logoutButton.classList.toggle('px-4');
                    logoutButton.classList.toggle('px-2');
                    logoutIcon.classList.toggle('mr-3');
                    logoutIcon.classList.toggle('mr-0');

                    // Toggle visibility of logout text and adjust icon
                    if (sidebar.classList.contains('w-16')) {
                        logoutText.classList.add('hidden');
                        logoutIcon.classList.remove('mr-3');
                        logoutIcon.classList.add('mx-auto');
                    } else {
                        logoutText.classList.remove('hidden');
                        logoutIcon.classList.add('mr-3');
                        logoutIcon.classList.remove('mx-auto');
                    }
                }

                function toggleFullscreen() {
                    if (!document.fullscreenElement) {
                        document.documentElement.requestFullscreen();
                    } else {
                        if (document.exitFullscreen) {
                            document.exitFullscreen();
                        }
                    }
                }

            </script>

</body>

</html>