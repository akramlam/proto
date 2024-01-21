<?php
function getPredefinedRoute($city) {
    $routes = [
        "Casablanca" => ["start" => [33.608749, -7.632601], "end" => [33.587324,-7.606714 ]],
        "Rabat" => ["start" => [34.0209, -6.8416], "end" => [34.1558, -6.7677]],
        "Marrakech" => ["start" => [31.6295, -7.9811], "end" => [31.6069, -8.0367]],
        // ... other routes
    ];

    return $routes[$city] ?? null;
}

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
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
     integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
     crossorigin=""/>
     <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
     integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
     crossorigin=""></script></head>
<body>
    <div class="container">
        <!-- Navigation -->
        <div class="nav">
            <!-- ... Your navigation content ... -->
        </div>

        <!-- City Selection Form -->
        <form id="cityForm">
            <select name="city" id="city">
                <option value="Casablanca">Casablanca</option>
                <option value="Rabat">Rabat</option>
                <option value="Marrakech">Marrakech</option>
                <!-- ... other cities -->
            </select>
            <button type="submit">Get Route</button>
        </form>

        <!-- Map Container -->
        <div id="map" style="height: 400px;"></div>
        
        <!-- Footer -->
        <div class="footer">
            <!-- ... Your footer content ... -->
        </div>
    </div>

    <!-- LeafletJS Map Integration -->
    <script>
        // Function to initialize the map
        function initMap() {
            var map = L.map('map').setView([31.7917, -7.0926], 6);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '© OpenStreetMap'
            }).addTo(map);
            return map;
        }

        // Function to draw the route on the map
        function drawRoute(map, start, end) {
    // Clear any existing layers, especially previous routes
    map.eachLayer(function(layer) {
        if (!!layer.toGeoJSON) {
            map.removeLayer(layer);
        }
    });

    // Draw the route as a blue line
    var routeCoordinates = [start, end];
    L.polyline(routeCoordinates, {color: 'blue'}).addTo(map);

    // Add a marker at the start point
    var startMarker = L.marker(start).addTo(map);
    startMarker.bindPopup('Start Point').openPopup();

    // Add a marker at the end point
    var endMarker = L.marker(end).addTo(map);
    endMarker.bindPopup('End Point').openPopup();

    // Adjust the map view
    map.fitBounds(L.polyline(routeCoordinates).getBounds());

                    }

        // Wait for the DOM to be loaded before initializing the map
        document.addEventListener('DOMContentLoaded', function() {
            var map = initMap();

            // Add the form submission event listener
            document.getElementById('cityForm').addEventListener('submit', function(e) {
                e.preventDefault();
                var city = document.getElementById('city').value;

                fetch('print.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                        'X-Requested-With': 'XMLHttpRequest' // This header identifies the request as AJAX
                    },
                    body: 'city=' + encodeURIComponent(city)
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(route => {
                    if (route) {
                        drawRoute(map, route.start, route.end);
                    } else {
                        alert('No route found for the selected city.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
            });

            // Invalidate map size after it is displayed to ensure it renders correctly
            map.on('load', function() {
                map.invalidateSize();
            });
        });
    </script>
</body>
</html>
