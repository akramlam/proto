<?php
// Function to get predefined route coordinates
function getPredefinedRoute($city) {
    $routes = [
        "Casablanca" => [
            "start" => [33.5731, -7.5898],
            "end" => [33.9716, -6.8498]
        ],
        "Rabat" => [
            "start" => [34.0209, -6.8416],
            "end" => [34.1558, -6.7677]
        ],
        "Marrakech" => [
            "start" => [31.6295, -7.9811],
            "end" => [31.6069, -8.0367]
        ],
        // ... other routes
    ];

    return $routes[$city] ?? null;
}

// Handle AJAX request
if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    $city = $_POST["city"];
    $route = getPredefinedRoute($city);

    header('Content-Type: application/json');
    echo json_encode($route);
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>YALLAH</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <!-- Navigation -->
        <div class="nav">
            <!-- ... Your navigation content ... -->
        </div>

        <!-- Map Container -->
        <div id="map" style="height: 400px;"></div>
        
        <!-- Footer -->
        <div class="footer">
            <!-- ... Your footer content ... -->
        </div>
    </div>

    <!-- LeafletJS Map Integration -->
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    <script>
        // Initialize the map
        var map = L.map('map').setView([31.7917, -7.0926], 6);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '© OpenStreetMap'
        }).addTo(map);

        document.getElementById('cityForm').addEventListener('submit', function(e) {
            e.preventDefault();
            var city = document.getElementById('city').value;

            fetch('yourscript.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                    'X-Requested-With': 'XMLHttpRequest' // This header identifies the request as AJAX
                },
                body: 'city=' + encodeURIComponent(city)
            })
            .then(response => response.json())
            .then(route => {
                if (route) {
                    // Draw the route on the map
                    drawRoute(route.start, route.end);
                } else {
                    alert('No route found for the selected city.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        });

        function drawRoute(start, end) {
            // Clear any existing layers
            map.eachLayer(function(layer) {
                if (!!layer.toGeoJSON) {
                    map.removeLayer(layer);
                }
            });

            // Draw the route
            var routeCoordinates = [start, end];
            L.polyline(routeCoordinates, {color: 'blue'}).addTo(map);

            // Add markers for the start and end points
            L.marker(start).addTo(map).bindPopup('Start');
            L.marker(end).addTo(map).bindPopup('End');

            // Adjust the map view
            map.fitBounds(L.polyline(routeCoordinates).getBounds());
            map.invalidateSize();

        }
    </script>
</body>
</html>
