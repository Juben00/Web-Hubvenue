<div>
    <!-- Map Container -->
    <div id="map" class="h-48 w-auto z-20"></div>

    <!-- Hidden Input for OpenStreet Address (with pre-stored location) -->
    <input type="hidden" id="autoOsm" value="<?php echo htmlspecialchars($venue['location']) ?>" />
</div>

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
    // Initialize the map to a default position (world view)
    const autoMap = L.map('map').setView([0, 0], 2);

    // Add OpenStreetMap tiles
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(autoMap);

    // Retrieve the saved location from the hidden input
    const autoOsmValue = document.getElementById('autoOsm').value;

    // Function to set a specific location on the map
    function setLocationOnMap(lat, lng, address = null) {
        autoMap.setView([lat, lng], 13);
        const marker = L.marker([lat, lng]).addTo(autoMap);
        if (address) {
            marker.bindPopup(address).openPopup();
        }
    }

    // Check if autoOsmValue contains an address
    if (autoOsmValue) {
        // Use OpenStreetMap's Nominatim API to geocode the address
        fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(autoOsmValue)}`)
            .then(response => response.json())
            .then(data => {
                if (data && data.length > 0) {
                    const { lat, lon } = data[0];
                    setLocationOnMap(parseFloat(lat), parseFloat(lon), autoOsmValue);
                } else {
                    alert("Address not found. Showing default location.");
                }
            })
            .catch(error => {
                console.error("Error fetching geocode data:", error);
                alert("Error retrieving location.");
            });
    } else if (navigator.geolocation) {
        // Fallback to user's current location if autoOsm doesn't have coordinates or an address
        navigator.geolocation.getCurrentPosition(
            position => {
                const { latitude, longitude } = position.coords;
                setLocationOnMap(latitude, longitude, "Current Location");
            },
            error => {
                console.error("Geolocation error:", error);
                alert("Unable to retrieve your location.");
            }
        );
    } else {
        alert("Geolocation is not supported by your browser.");
    }
</script>