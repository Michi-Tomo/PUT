
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.5.0/font/bootstrap-icons.min.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>どこ行く？</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine/dist/leaflet-routing-machine.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.5.0/font/bootstrap-icons.min.css">
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
    </form>

    <div class="response-buttons">
        <a href="{{ route('booking.accept') }}" class="icon-button cancel-icon">
            <i class="bi bi-x-circle-fill"></i>
            <span>キャンセル</span>
        </a>
        <a href="{{ route('booking.accept') }}" class="icon-button ride-icon">
            <i class="bi bi-box-arrow-right"></i> <!-- Updated icon -->
            <span>お客様降車</span>
        </a>
    </div>

    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script src="https://unpkg.com/leaflet-routing-machine/dist/leaflet-routing-machine.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var map = L.map('map').setView([35.681167, 139.767052], 13); // Set initial view to a central location

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© OpenStreetMap contributors'
            }).addTo(map);

            function plotRoute(pickup, destination) {
                // Use Nominatim API to get coordinates for the pickup location
                fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${pickup}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.length === 0) {
                            alert('Pickup location not found');
                            return;
                        }
                        var pickupLatLng = [data[0].lat, data[0].lon];

                        // Use Nominatim API to get coordinates for the destination location
                        fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${destination}`)
                            .then(response => response.json())
                            .then(data => {
                                if (data.length === 0) {
                                    alert('Destination not found');
                                    return;
                                }
                                var destinationLatLng = [data[0].lat, data[0].lon];

                                // Create routing control
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

                                    // Calculate distance in kilometers
                                    var distance = summary.totalDistance / 1000;

                                    // Calculate duration in minutes
                                    var duration = summary.totalTime / 60;

                                    // Minimum fare of 100 yen
                                    var baseFare = 100;

                                    // Additional fare beyond 500 meters (0.5 km)
                                    var additionalFarePerKm = 35;
                                    var additionalDistance = Math.max(0, distance - 0.5); // Exclude the first 500 meters

                                    // Calculate total fare
                                    var totalFare = baseFare + (additionalDistance * additionalFarePerKm);

                                    // Format the fare for display
                                    var formattedFare = Math.ceil(totalFare);
                                });
                            });
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('An error occurred while fetching the location data');
                    });
            }
            plotRoute(@json($booking->pickup_location), @json($booking->dropoff_location));
        });
    </script>
</body>
</html>
