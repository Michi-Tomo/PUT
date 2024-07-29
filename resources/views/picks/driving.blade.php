<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.5.0/font/bootstrap-icons.min.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>どこ行く？</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine/dist/leaflet-routing-machine.css" />
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 0;
            margin: 0;
            box-sizing: border-box;
            overflow-x: hidden; /* Prevent horizontal scrolling */
        }
        #map {
            width: 100%;
            height: 400px;
            margin: 0;
        }
        .driver-info {
            display: flex;
            align-items: center;
            border: 1px solid #b8b8b8;
            padding: 10px;
            background-color: #fcfcfc;
            margin: 20px;
            height: 120px; /* Adjust height to make it slimmer */
            margin-bottom: 60px;
            margin-top: 50px; /* Remove top margin to eliminate gap */
        }
        .driver-image {
            margin-right: 20px;
        }
        .driver-image img {
            width: 70px; /* Adjusted image size */
            height: 70px; /* Adjusted image size */
            border-radius: 50%;
            margin-left: 25px;
        }
        .driver-name {
            font-size: 16px;
            font-weight: bold;
            margin-top: 5px;
            margin-left: 12px;
        }
        .driver-details {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            height: 100%;
        }
        .license-plate,
        .rating {
            margin-bottom: 5px;
        }
        .license-plate {
            font-size: 26px;
            margin-top: 35px;
            white-space: nowrap; /* Keep the text in one line */
        }
        .rating {
            display: flex;
            align-items: center;
            margin-bottom: 11px;
            margin-left: -11px;
        }
        .rating i {
            color: rgb(255, 196, 3); /* Star fill color */
            -webkit-text-stroke: 1px black; /* Star border color */
        }
        .rating span {
            font-size: 16px;
            font-weight: bold;
            margin-left: 5px;
        }
        .icon-button {
            display: flex;
            flex-direction: column;
            align-items: center;
            cursor: pointer;
            text-decoration: none;
        }
        .icon-button i {
            font-size: 48px; /* Adjust icon size */
            margin-bottom: 5px; /* Space between icon and text */
        }
        .icon-button span {
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
    </style>
</head>
<body>
    <div id="map"></div>

    <form action="">
        @csrf

        <div class="driver-info">
            <div class="driver-image">
                <img src="{{ asset('storage/' . $driver_info->driver_image) }}" alt="Driver Photo">
                <div class="driver-name">{{ $driver->name ?? 'Not available' }}</div>
            </div> 

            <div class="driver-details">
                <div class="license-plate">
                    車両番号: {{ $driver_info->license_plate ?? 'Not available' }}
                </div>
                <div class="rating">
                    <i class="bi bi-star-fill"></i><span>{{ round($driver_rating, 1) != 0 ? round($driver_rating, 1) : '評価が行われておりません' }}</span>
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
    <script src="https://unpkg.com/leaflet-routing-machine/dist/leaflet-routing-machine.js"></script>
    <script>
        var map = L.map('map').setView([35.681167, 139.767052], 13); // 初期表示の中心位置を設定

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);

        function plotRoute(pickup, destination) {
            fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${pickup}`)
                .then(response => response.json())
                .then(data => {
                    if (data.length === 0) {
                        alert('乗車地が見つかりません');
                        return;
                    }
                    var pickupLatLng = [data[0].lat, data[0].lon];

                    fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${destination}`)
                        .then(response => response.json())
                        .then(data => {
                            if (data.length === 0) {
                                alert('目的地が見つかりません');
                                return;
                            }
                            var destinationLatLng = [data[0].lat, data[0].lon];

                            var routingControl = L.Routing.control({
                                waypoints: [
                                    L.latLng(pickupLatLng[0], pickupLatLng[1]),
                                    L.latLng(destinationLatLng[0], destinationLatLng[1])
                                ],
                                routeWhileDragging: true
                            }).addTo(map);

                            routingControl.on('routesfound', function(e) {
                                var routes = e.routes;
                                var summary = routes[0].summary;

                                var distance = summary.totalDistance / 1000;
                                var duration = summary.totalTime / 60;

                                var baseFare = 100;
                                var additionalFarePerKm = 35;
                                var additionalDistance = Math.max(0, distance - 0.5);

                                var totalFare = baseFare + (additionalDistance * additionalFarePerKm);
                                var formattedFare = Math.ceil(totalFare);
                            });
                        });
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('位置情報の取得中にエラーが発生しました');
                });
        }

        var pickup = "{{ $pickup }}";
        var destination = "{{ $destination }}";
        plotRoute(pickup, destination);

        function goBack() {
            window.location.href = "{{ route('picks.search') }}";
        }

        function submitForm() {
            console.log('Form submitted');
            document.getElementById('bookingForm').submit();
        }
    </script>
    {{-- <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
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
    </script> --}}
</body>
</html>
