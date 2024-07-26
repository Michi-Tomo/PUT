<!DOCTYPE html>
<html lang="ja">
<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.5.0/font/bootstrap-icons.min.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>結果</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine/dist/leaflet-routing-machine.css" />
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
            height: 50vh; /* Adjust the height as needed */
            margin: 0;
        }
        .container {
            padding: 20px;
            box-sizing: border-box;
            text-align: left; /* Align text to the left */
        }
        .result-info {
            font-size: 20px; /* Make the text larger */
            margin: 20px 0;
        }
        .result-info p {
            margin: 15px 0;
            display: flex;
            align-items: center;
        }
        .result-info svg, .result-info i {
            font-size: 28px; /* Adjust icon size */
            margin-right: 15px; /* Space between icon and text */
        }
        .result-info .pickup-icon {
            font-size: 36px; /* Larger size for pickup icon */
        }
        .result-info input[type="text"] {
            font-size: 16px; /* Adjust input text size */
        }
        .reservation-button {
            display: flex;
            flex-direction: column;
            align-items: center;
            cursor: pointer;
            margin-top: 20px;
        }
        .reservation-button i {
            font-size: 36px;
            color: #ff0000; /* Red color for the icon */
        }
        .reservation-button span {
            font-size: 20px; /* Increase text size */
            color: #000000; /* Red color for the text */
        }
        .back-button {
            position: fixed;
            bottom: 30px; /* Adjusted for higher position */
            left: 30px; /* Adjusted for more right position */
            font-size: 30px;
            color: #000;
            cursor: pointer;
            font-weight: bold; /* To ensure the < mark is bold */
        }
    </style>
</head>
<body>
    <div id="map"></div>
    <form action="{{ route('bookings.store') }}" method="POST" class="container" id="bookingForm">
        @csrf
        <input type="hidden" id="lat" name="lat">
        <input type="hidden" id="lon" name="lon">
        <div class="result-info">
            <p><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-person-raised-hand" viewBox="0 0 16 16">
                <path d="M6 6.207v9.043a.75.75 0 0 0 1.5 0V10.5a.5.5 0 0 1 1 0v4.75a.75.75 0 0 0 1.5 0v-8.5a.25.25 0 1 1 .5 0v2.5a.75.75 0 0 0 1.5 0V6.5a3 3 0 0 0-3-3H6.236a1 1 0 0 1-.447-.106l-.33-.165A.83.83 0 0 1 5 2.488V.75a.75.75 0 0 0-1.5 0v2.083c0 .715.404 1.37 1.044 1.689L5.5 5c.32.32.5.754.5 1.207"/>
                <path d="M8 3a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3"/>
            </svg>乗車地 :  <input type="text" name="pickup_location" value="{{ $pickup }}" hidden><input type="text" value="{{ $pickup }}" disabled></p>
        </div>

        <div class="result-info">
            <p><i class="bi bi-geo-alt"></i>目的地 : <input type="text" name="dropoff_location" value="{{ $destination }}" hidden><input type="text" value="{{ $destination }}" disabled></p>
        </div>

        <div class="result-info">
            <p><i class="bi bi-clock"></i>所要時間 : <input type="text" name="taketime" value="{{ $duration }}" id="duration2" hidden><input type="text" value="{{ $duration }}" id="duration" disabled></p>
        </div>

        <div class="result-info">
            <p><i class="bi bi-currency-yen"></i>料金 : <input type="text" name="fare" value="{{ $totalFare }}" id="fare2" hidden><input type="text" value="{{ $totalFare }}" id="fare" disabled></p>
        </div>

        <div class="reservation-button" onclick="submitForm()">
            <i class="bi bi-check-circle-fill"></i>
            <span>予約</span>
        </div>
    </form>

    <div class="back-button" onclick="goBack()">
        &lt;
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

                            const lat = document.getElementById('lat').value = data[0].lat;
                            const lon = document.getElementById('lon').value = data[0].lon;

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

                                document.getElementById('duration').value = Math.ceil(duration) + ' 分';
                                document.getElementById('fare').value = formattedFare;
                                document.getElementById('duration2').value = Math.ceil(duration) + ' 分';
                                document.getElementById('fare2').value = formattedFare;
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
</body>
</html>
