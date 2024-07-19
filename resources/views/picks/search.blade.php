<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pickup and Destination</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
            margin: 0;
            box-sizing: border-box;
        }
        #map {
            width: 100%;
            height: 400px;
            margin-bottom: 20px;
        }
        form {
            display: flex;
            flex-direction: column;
            max-width: 400px;
        }
        input, button {
            margin-bottom: 10px;
            padding: 10px;
            font-size: 16px;
        }
        button {
            cursor: pointer;
        }
    </style>
</head>
<body>
    <h1>Pickup and Destination</h1>

    <div id="map"></div>

    <form action="{{ route('picks.store') }}" method="POST">
        @csrf
        <label for="pickup">Pickup Location:</label>
        <input type="text" id="pickup" name="pickup" required>
        
        <label for="destination">Destination:</label>
        <input type="text" id="destination" name="destination" required>
        
        <button type="submit">Submit</button>
    </form>

    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script>
        var map = L.map('map');

        // Default center to Tokyo
        map.setView([35.681167, 139.767052], 13);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);

        function updateMapWithCurrentLocation() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    var lat = position.coords.latitude;
                    var lon = position.coords.longitude;

                    // Center map on current location
                    map.setView([lat, lon], 13);

                    // Add marker for current location
                    L.marker([lat, lon]).addTo(map)
                        .bindPopup('You are here')
                        .openPopup();
                }, function(error) {
                    console.error('Error getting location:', error);
                    alert('Unable to retrieve your location. Error code: ' + error.code);
                }, {
                    enableHighAccuracy: true, // Request high accuracy
                    timeout: 5000, // Set timeout to 5 seconds
                    maximumAge: 0 // Do not use cached location
                });
            } else {
                alert('Geolocation is not supported by this browser.');
            }
        }

        updateMapWithCurrentLocation();
    </script>
</body>
</html>
