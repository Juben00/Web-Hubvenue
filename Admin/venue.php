<!-- <!DOCTYPE html>
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

        .dark-mode .border-gray-300 {
            border-color: #4B5563;
        }

        .dark-mode .text-muted-foreground {
            color: #9CA3AF;
        }

        .dark-mode .bg-background {
            background-color: #ffffff;
        }

        .dark-mode .border-input {
            border-color: #374151;
        }

        .dark-mode .placeholder\:text-muted-foreground::placeholder {
            color: #000000;
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
        <?php
        // include 'sidebar.php'; 
        ?>

        <div class="flex-1 flex flex-col overflow-hidden">
            <?php
            //  include 'topbar.php'; 
            ?>

            <!-- Main Content -->
<!-- <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100 main-content"> --> -->
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl md:text-3xl font-semibold text-gray-800 mb-6 hidden md:block">Venue Management
    </h1>

    <div class="space-y-4">
        <!-- Tabs -->
        <div class="flex space-x-1 rounded-lg bg-white p-1">
            <button
                class="tab-button flex-1 inline-flex items-center justify-center whitespace-nowrap rounded-md px-3 py-1.5 text-sm font-medium ring-offset-background transition-all focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 data-[state=active]:bg-red-500 data-[state=active]:text-white"
                data-tab="add-venue">Add Venue</button>
            <button class=" tab-button flex-1 inline-flex items-center justify-center whitespace-nowrap
                                rounded-md px-3 py-1.5 text-sm font-medium ring-offset-background transition-all
                                focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring
                                focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50
                                data-[state=active]:bg-red-500 data-[state=active]:text-white"
                data-tab="manage-venues">Manage Venues</button>
            <button
                class="tab-button flex-1 inline-flex items-center justify-center whitespace-nowrap rounded-md px-3 py-1.5 text-sm font-medium ring-offset-background transition-all focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 data-[state=active]:bg-red-500 data-[state=active]:text-white"
                data-tab="pricing">Pricing</button>
            <button
                class="tab-button flex-1 inline-flex items-center justify-center whitespace-nowrap rounded-md px-3 py-1.5 text-sm font-medium ring-offset-background transition-all focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 data-[state=active]:bg-red-500 data-[state=active]:text-white"
                data-tab="availability">Availability</button>
        </div>

        <!-- Add Venue Form -->
        <div id="add-venue" class="tab-content rounded-lg border bg-white shadow-sm">
            <div class="flex flex-col space-y-1.5 p-6">
                <h3 class="text-2xl font-semibold leading-none tracking-tight">Add New Venue</h3>
            </div>
            <div class="p-6 pt-0">
                <form id="add-venue-form" class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="space-y-2">
                            <label for="venue-name"
                                class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Venue
                                Name</label>
                            <input id="venue-name" name="name" placeholder="Enter venue name"
                                class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50" />
                        </div>
                        <div class="space-y-2">
                            <label for="venue-location"
                                class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Location</label>
                            <input id="venue-location" name="location" placeholder="Enter venue location"
                                class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50" />
                        </div>
                        <div class="space-y-2">
                            <label for="venue-capacity"
                                class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Capacity</label>
                            <input id="venue-capacity" name="capacity" type="number" placeholder="Enter venue capacity"
                                class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50" />
                        </div>
                        <div class="space-y-2">
                            <label for="venue-amenities"
                                class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Amenities</label>
                            <input id="venue-amenities" name="amenities" placeholder="Enter amenities (comma-separated)"
                                class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50" />
                        </div>
                    </div>
                    <div class="space-y-2">
                        <label for="venue-description"
                            class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Description</label>
                        <textarea id="venue-description" name="description" placeholder="Enter venue description"
                            class="flex min-h-[80px] w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50"></textarea>
                    </div>
                    <div class="space-y-2">
                        <label
                            class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Upload
                            Images</label>
                        <input type="file" name="images" multiple accept="image/*"
                            class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50" />
                    </div>
                    <button type="submit"
                        class="inline-flex items-center justify-center rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-red-500 text-white hover:bg-red-900 h-10 px-4 py-2">Add
                        Venue</button>
                </form>
            </div>
        </div>

        <!-- Manage Venues Table -->
        <div id="manage-venues" class="tab-content rounded-lg border bg-white shadow-sm hidden">
            <div class="flex flex-col space-y-1.5 p-6">
                <h3 class="text-2xl font-semibold leading-none tracking-tight">Manage Venues</h3>
            </div>
            <div class="p-6 pt-0">
                <div class="w-full overflow-auto">
                    <table class="w-full caption-bottom text-sm">
                        <thead class="[&_tr]:border-b">
                            <tr class="border-b transition-colors hover:bg-muted/50 data-[state=selected]:bg-muted">
                                <th
                                    class="h-12 px-4 text-left align-middle font-medium text-muted-foreground [&:has([role=checkbox])]:pr-0">
                                    Name</th>
                                <th
                                    class="h-12 px-4 text-left align-middle font-medium text-muted-foreground [&:has([role=checkbox])]:pr-0">
                                    Location</th>
                                <th
                                    class="h-12 px-4 text-left align-middle font-medium text-muted-foreground [&:has([role=checkbox])]:pr-0">
                                    Capacity</th>
                                <th
                                    class="h-12 px-4 text-left align-middle font-medium text-muted-foreground [&:has([role=checkbox])]:pr-0">
                                    Actions</th>
                            </tr>
                        </thead>
                        <tbody id="venues-table-body" class="[&_tr:last-child]:border-0">
                            <!-- Venue rows will be dynamically added here -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Pricing Form -->
        <div id="pricing" class="tab-content rounded-lg border bg-white shadow-sm hidden">
            <div class="flex flex-col space-y-1.5 p-6">
                <h3 class="text-2xl font-semibold leading-none tracking-tight">Pricing Tiers</h3>
            </div>
            <div class="p-6 pt-0">
                <form id="pricing-form" class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="space-y-2">
                            <label for="hourly-rate"
                                class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Hourly
                                Rate</label>
                            <input id="hourly-rate" name="hourlyRate" type="number" placeholder="Enter hourly rate"
                                class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50" />
                        </div>
                        <div class="space-y-2">
                            <label for="daily-rate"
                                class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Daily
                                Rate</label>
                            <input id="daily-rate" name="dailyRate" type="number" placeholder="Enter daily rate"
                                class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50" />
                        </div>
                    </div>
                    <button type="submit"
                        class="inline-flex items-center justify-center rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-blue-500 text-white hover:bg-blue-600 h-10 px-4 py-2">Update
                        Pricing</button>
                </form>
            </div>
        </div>

        <!-- Availability Calendar -->
        <div id="availability" class="tab-content rounded-lg border bg-white shadow-sm hidden">
            <div class="flex flex-col space-y-1.5 p-6">
                <h3 class="text-2xl font-semibold leading-none tracking-tight">Venue Availability</h3>
            </div>
            <div class="p-6 pt-0">
                <div class="space-y-4">
                    <label
                        class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Select
                        Block-out Dates</label>
                    <div id="availability-calendar" class="rounded-md border p-4">
                        <!-- Calendar will be dynamically added here -->
                    </div>
                    <button id="save-availability"
                        class="inline-flex items-center justify-center rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-blue-500 text-white hover:bg-blue-600 h-10 px-4 py-2">Save
                        Block-out Dates</button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- </main>
        </div>
    </div> -->

<!-- <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> -->

<!-- </body>

</html> -->