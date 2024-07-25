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
        .driver-info1 {
            display: flex;
            margin-top: 30px;
            margin-left: 10px;
        }
        .driver-info2 {
            margin-left: 50px;
        }
        button, .response-buttons a {
            cursor: pointer;
            padding: 10px;
            font-size: 16px;
            margin-top: 20px;
            text-decoration: none;
            text-align: center;
            display: inline-block;
            width: calc(100% - 20px);
            color: white;
            border-radius: 4px;
        }
        .response-buttons {
            display: flex;
            justify-content: space-around;

        }
        .response-buttons a {
            width: 30%;
        }
        .response-buttons .yes {
            background-color: #28a745; /* Green */
        }
        .response-buttons .no {
            background-color: #dc3545; /* Red */
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
                <img src="{{ asset('storage/' . $users->driver_image) }}" alt="Driver Photo" style="width: 90px; height: 90px; border-radius: 50%; margin-top: 10px">
            </div>

        <div class="driver-info2">
            <div class="license-plate">
                <p>登録済み車両番号 <br>{{ $users->license_plate ?? 'Not available' }}</p>
            </div>

            <div class="rating">
                <p>平均評価 <br>{{ $averageRating ?? 'Not available' }}</p>
            </div>
        </div>
        </div>

        <button type="submit" class="btn btn-primary">
            <i class="bi bi-check-circle-fill bi-2x"></i> <!-- Larger icon -->
            キャンセル
        </button>
    </form>

    <div class="response-buttons">
        <a href="{{ route('booking.accept') }}" class="yes">キャンセル</a>
        <a href="{{ route('bookings.drop') }}" class="no">Pick UP</a>
    </div>
    {{-- <div class="response-buttons">
        <a href="{{ route('booking.accept') }}" class="yes">キャンセル</a>
        <a href="{{ route('bookings.drop') }}" class="no">Pick Up</a>
    </div> --}}

    {{-- <form action="{{ route('picks.store') }}" method="POST">
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
    </form> --}}
    

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

                                // document.getElementById('duration').value = Math.ceil(duration) + ' 分';
                                // document.getElementById('fare').value = formattedFare;
                                // document.getElementById('duration2').value = Math.ceil(duration) + ' 分';
                                // document.getElementById('fare2').value = formattedFare;
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
    </script>
</body>
</html>
