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

    // Add a marker for the venue location
    var marker = L.marker([<?php echo $venue['latitude'] ?? '6.9214' ?>, <?php echo $venue['longitude'] ?? '122.0790' ?>]).addTo(map);
    
    // Add a popup to the marker
    marker.bindPopup("<?php echo htmlspecialchars($venue['location']) ?>").openPopup();

    // Ensure the map container fills its parent
    document.addEventListener('DOMContentLoaded', function() {
        map.invalidateSize();
    });
</script>

<style>
    #map {
        width: 100%;
        z-index: 1;
    }
</style>