<div>
    <!-- Map Container -->
    <div id="map" class="h-96 w-auto z-20"></div>

    <!-- Hidden Input for OpenStreet Address (with pre-stored location) -->
    <input type="hidden" id="autoOsm" value="<?php echo htmlspecialchars($venue['location']) ?>" />
</div>

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
    // Initialize the map
    var map = L.map('map').setView([6.9214, 122.0790], 13); // Default to Zamboanga City coordinates
    // Add OpenStreetMap tiles
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '© OpenStreetMap contributors'
    }).addTo(map);

    <?php
    $location = $venue['location']; // Get the location string
    list($latitude, $longitude) = explode(',', $location); // Split into latitude and longitude
    ?>


    // Add a marker for the venue location
    var marker = L.marker([<?php echo $latitude ?? '6.918973780293266' ?>, <?php echo $longitude ?? '122.06593990292278' ?>]).addTo(map);

    // Add a popup to the marker
    marker.bindPopup("<?php echo htmlspecialchars($venue['address']) ?>").openPopup();

    // Ensure the map container fills its parent
    document.addEventListener('DOMContentLoaded', function () {
        map.invalidateSize();
    });
</script>

<style>
    #map {
        width: 100%;
        z-index: 1;
    }
</style>