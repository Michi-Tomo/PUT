<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.5.0/font/bootstrap-icons.min.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>どこ行く？</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <style>
        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            box-sizing: border-box;
        }
        #map {
            width: 100%;
            height: 400px;
            margin: 0;
            margin-bottom: 20px; /* Add margin bottom to create space */
        }
        form {
            display: flex;
            flex-direction: column;
            align-items: center;
            max-width: 400px;
            margin: auto;
            padding: 0 20px; /* Add padding to prevent overflow */
            box-sizing: border-box;
        }
        .input-group {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 10px;
            width: 100%;
        }
        .input-group .arrow-icon {
            font-size: 24px; /* Make the arrow match input height */
            color: #000000;
        }
        .form-control {
            margin-bottom: 10px;
            padding: 10px;
            font-size: 16px;
            width: 100%; /* Adjust the width to fit the form */
            background-color: #e6e6fa; /* Light purple background */
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
        .form-group {
            display: flex;
            align-items: center;
            width: 100%;
            margin-bottom: 10px;
        }
        .form-group svg, .form-group i {
            font-size: 24px; /* Adjust the size of icons to match input height */
            margin-right: 10px; /* Space between icon and input */
        }
        .icon-wrapper {
            display: flex;
            align-items: center;
            justify-content: center;
            align-self: flex-start; /* Align icon to the start to match input height */
            padding-top: 4px; /* Adjust this value to fine-tune the vertical alignment */
        }
        button {
            cursor: pointer;
            padding: 10px;
            font-size: 16px;
            margin-top: 20px;
            width: 100%; /* Adjust the width to fit the form */
            box-sizing: border-box;
        }
    </style>
</head>
<body>
    <div id="map"></div>

    <form action="{{ route('picks.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <div class="icon-wrapper">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-person-raised-hand" viewBox="0 0 16 16">
                    <path d="M6 6.207v9.043a.75.75 0 0 0 1.5 0V10.5a.5.5 0 0 1 1 0v4.75a.75.75 0 0 0 1.5 0v-8.5a.25.25 0 1 1 .5 0v2.5a.75.75 0 0 0 1.5 0V6.5a3 3 0 0 0-3-3H6.236a1 1 0 0 1-.447-.106l-.33-.165A.83.83 0 0 1 5 2.488V.75a.75.75 0 0 0-1.5 0v2.083c0 .715.404 1.37 1.044 1.689L5.5 5c.32.32.5.754.5 1.207"/>
                    <path d="M8 3a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3"/>
                </svg>
            </div>
            <input type="text" id="pickup" name="pickup" class="form-control" placeholder="乗車地を入力" required>
        </div>
        
        <div class="input-group">
            <span class="arrow-icon">
                <i class="bi bi-arrow-down bi-3x"></i>
            </span>
        </div>
        
        <div class="form-group">
            <div class="icon-wrapper">
                <i class="bi bi-geo-fill"></i>
            </div>
            <input type="text" id="destination" name="destination" class="form-control" placeholder="目的地を入力" required>
        </div>
        
        <button type="submit" class="btn btn-primary">
            <i class="bi bi-check-circle-fill"></i>
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
