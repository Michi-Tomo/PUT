<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.5.0/font/bootstrap-icons.min.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>どこ行く？</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
            margin: 0;
            box-sizing: border-box;
        }
        #map {
            width: calc(100% + 40px); /* Add 20px to each side */
            height: 400px;
            margin: 0 -20px 20px -20px; /* Remove margin on left and right */
        }
        form {
            display: flex;
            flex-direction: column;
            align-items: center;
            max-width: 400px;
            margin: auto;
        }
        .input-group {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 10px;
            width: 100%;
        }
        .input-group .arrow-icon {
            font-size: 48px; /* Make the arrow longer */
            color: #000000;
        }
        .form-control {
            margin-bottom: 10px;
            padding: 10px;
            font-size: 16px;
            width: calc(100% - 20px); /* Adjust the width to fit the form */
            background-color: #e6e6fa; /* Light purple background */
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        button {
            cursor: pointer;
            padding: 10px;
            font-size: 16px;
            margin-top: 20px;
            width: calc(100% - 20px); /* Adjust the width to fit the form */
        }
    </style>
</head>
<body>
    <h1></h1>

    <div id="map"></div>

    <form action="{{ route('picks.store') }}" method="POST">
        @csrf
        <div class="mb-3" style="width: 100%;">
            <label for="pickup">
                <i class="bi bi-geo-alt-fill bi-2x"></i> <!-- Larger icon -->
            </label>
            <input type="text" id="pickup" name="pickup" class="form-control" placeholder="乗車地を入力" required>
        </div>
        
        <div class="input-group">
            <span class="arrow-icon">
                <i class="bi bi-arrow-down bi-3x"></i> <!-- Larger icon -->
            </span>
        </div>
        
        <div class="mb-3" style="width: 100%;">
            <label for="destination">
                <i class="bi bi-geo-fill bi-2x"></i> <!-- Larger icon -->
            </label>
            <input type="text" id="destination" name="destination" class="form-control" placeholder="目的地を入力" required>
        </div>
        
        <button type="submit" class="btn btn-primary">
            <i class="bi bi-check-circle-fill bi-2x"></i> <!-- Larger icon -->
            選択
        </button>
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
                        .bindPopup('現在地')
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