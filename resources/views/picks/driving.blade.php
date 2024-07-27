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
        .driver-info1 {
            display: flex;
            margin-top: 30px;
            margin-left: 10px;
        }
        .driver-info2 {
            margin-left: 50px;
        }
        .icon-button {
            display: flex;
            flex-direction: column;
            align-items: center;
            cursor: pointer;
            text-decoration: none;
            padding: 10px;
            border-radius: 5px;
            transition: background-color 0.3s, color 0.3s;
        }
        .icon-button i {
            font-size: 48px; /* Adjust icon size */
            margin-bottom: 5px; /* Space between icon and text */
        }
        .icon-button span {
            margin-right: 13px;
            color: black; /* Set text color to black */
        }
        .cancel-icon {
            color: red;
        }
        .ride-icon {
            color: blue;
        }
        .response-buttons {
            display: flex;
            justify-content: space-around;
            margin-top: 20px;
        }
        .icon-button:hover {
            background-color: #f0f0f0; /* Light grey background on hover */
        }
    </style>
</head>
<body>
    <h1></h1>

    <div id="map"></div>

    <form action="">
        @csrf

        <div class="driver-info1">
            <div class="driver-image">
                <img src="{{ asset('storage/' . $driver_info->driver_image) }}" alt="Driver Photo" style="width: 90px; height: 90px; border-radius: 50%; margin-top: 10px">
            </div>

            <div class="driver-info2">
                <div class="license-plate">
                    <p>登録済み車両番号 <br>{{ $driver_info->license_plate ?? 'Not available' }}</p>
                </div>

                <div class="rating">
                    <p>平均評価 <br>{{ $driver_rating ?? 'Not available' }}</p>
                </div>
            </div>
        </div>
    </form>

    <div class="response-buttons">
        <a href="{{ route('picks.search') }}" class="icon-button cancel-icon">
            <i class="bi bi-x-circle-fill"></i>
            <span>キャンセル</span>
        </a>
        <a href="{{ route('rate.show') }}" class="icon-button ride-icon">
            <i class="bi bi-box-arrow-right"></i> <!-- Updated icon -->
            <span>降車</span>
        </a>
    </div>

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
