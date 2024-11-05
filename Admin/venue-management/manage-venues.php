<div id="manage-venues" class="tab-content rounded-lg border bg-white shadow-sm">
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

<script>
    // Sample JSON data
    let venuesData = [
        { id: 1, name: "Grand Hall", location: "New York", capacity: 500 },
        { id: 2, name: "Garden Terrace", location: "Los Angeles", capacity: 200 },
        { id: 3, name: "Skyline Loft", location: "Chicago", capacity: 150 }
    ];

    // Function to populate venues table
    function populateVenuesTable() {
        const tableBody = document.getElementById('venues-table-body');
        tableBody.innerHTML = '';
        venuesData.forEach(venue => {
            const row = `
                <tr class="border-b transition-colors hover:bg-muted/50 data-[state=selected]:bg-muted">
                    <td class="p-4 align-middle [&:has([role=checkbox])]:pr-0">${venue.name}</td>
                    <td class="p-4 align-middle [&:has([role=checkbox])]:pr-0">${venue.location}</td>
                    <td class="p-4 align-middle [&:has([role=checkbox])]:pr-0">${venue.capacity}</td>
                    <td class="p-4 align-middle [&:has([role=checkbox])]:pr-0">
                        <button class="inline-flex items-center justify-center rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 border border-input bg-background hover:bg-accent hover:text-accent-foreground h-9 px-3 mr-2">Edit</button>
                        <button class="inline-flex items-center justify-center rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-red-500 text-white hover:bg-red-600 h-9 px-3">Delete</button>
                    </td>
                </tr>
            `;
            tableBody.innerHTML += row;
        });
    }

    // Function to handle tab switching
    function switchTab(tabId) {
        document.querySelectorAll('.tab-content').forEach(tab => {
            tab.classList.add('hidden');
        });
        document.getElementById(tabId).classList.remove('hidden');
        document.querySelectorAll('.tab-button').forEach(button => {
            button.dataset.state = '';
        });
        document.querySelector(`[data-tab="${tabId}"]`).dataset.state = 'active';
    }

    // Event listeners
    document.addEventListener('DOMContentLoaded', () => {
        // Populate venues table
        populateVenuesTable();

        // Tab switching
        document.querySelectorAll('.tab-button').forEach(button => {
            button.addEventListener('click', () => {
                switchTab(button.dataset.tab);
            });
        });

        // Form submissions
        document.getElementById('add-venue-form').addEventListener('submit', (e) => {
            e.preventDefault();
            alert('Venue added successfully!');
        });

        document.getElementById('pricing-form').addEventListener('submit', (e) => {
            e.preventDefault();
            alert('Pricing updated successfully!');
        });

        document.getElementById('save-availability').addEventListener('click', () => {
            alert('Availability saved successfully!');
        });
    });
</script>