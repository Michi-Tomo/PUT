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
            margin: -20px -20px 0 -20px; /* Remove margin on left and right and top */
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
        .driver-info1 {
            display: flex;
            margin-top: 10px;
            align-items: center;
            justify-content: space-between;
            width: calc(100% - 20px); /* Adjust the width to fit the form */
        }
        .driver-image {
            width: 90px;
            height: 90px;
            border-radius: 50%;
            overflow: hidden;
            margin-left: 35px;
        }
        .driver-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .driver-info2 {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            justify-content: center;
            margin-left: 10px;
        }
        .license-plate {
            background-color: #fff; /* White background */
            color: #008000; /* Green text */
            border: 1px solid #000000;
            padding: 10px;
            font-size: 24px; /* Larger font size */
            font-weight: bold; /* Bold text */
            text-align: center;
            border-radius: 5px;
            width: 80%;
            margin-bottom: 5px;
        }
        .rating {
            font-size: 18px;
        }
        .menu-bar {
            width: 100%;
            background-color: #333;
            color: white;
            display: flex;
            justify-content: space-around;
            align-items: center;
            padding: 10px 0;
            position: fixed;
            bottom: 0;
            left: 0; /* 左寄せにする */
            margin: 0; /* 不要なマージンを取り除く */
        }
        .menu-item {
            text-align: center;
            flex: 1;
            margin: 0; /* 不要なマージンを取り除く */
        }
        .menu-item a {
            color: white;
            text-decoration: none;
            display: flex;
            flex-direction: column;
            align-items: center;
            margin: 0; /* 不要なマージンを取り除く */
        }
        .menu-item a i {
            font-size: 1.5rem;
            margin-bottom: 5px;
        }
        .btn-pickup {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            margin: 45px auto;
            font-size: 16px;
            color: black;
        }
        .btn-pickup i {
            font-size: 48px;
            border: 2px solid #000;
            border-radius: 50%;
            padding: 20px;
        }
    </style>
</head>
<body>
    <div id="map"></div>

    <a href="{{ route('booking.decision') }}" class="btn-pickup">
        <i class="bi bi-taxi-front-fill"></i>
        <span>スタート</span>
    </a>

    <div class="driver-info1">
        <div class="driver-image">
            <img src="{{ asset('storage/' . $users->driver_image) }}" alt="Driver Photo">
        </div>

        <div class="driver-info2">
            <div class="license-plate">
                {{ $users->license_plate ?? 'Not available' }}
            </div>

            {{-- <div class="rating">
                平均評価<br>{{ $averageRating ?? 'Not available' }}
            </div> --}}
        </div>
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

    <div class="menu-bar">
        <div class="menu-item">
            <a href="/home">
                <i class="bi bi-house-door-fill"></i>
                <span>ホーム</span>
            </a>
        </div>
        <div class="menu-item">
            <a href="/history">
                <i class="bi bi-clock-history"></i>
                <span>履歴</span>
            </a>
        </div>
        <div class="menu-item">
            <a href="/chatify">
                <i class="bi bi-chat-dots-fill"></i>
                <span>チャット</span>
            </a>
        </div>
        <div class="menu-item">
            <a href="/driverprofile">
                <i class="bi bi-person-fill"></i>
                <span>マイページ</span>
            </a>
        </div>
    </div>
</body>
</html>
