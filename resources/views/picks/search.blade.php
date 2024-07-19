<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ride Request</title>
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
            width: 100%;
            height: 300px;
        }
        form {
            margin-top: 20px;
        }
        input[type="text"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            box-sizing: border-box;
        }
        button {
            width: 100%;
            padding: 10px;
            background-color: #007BFF;
            color: white;
            border: none;
            cursor: pointer;
        }
        button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <h1>Request a Ride</h1>
    <div id="map"></div>

<!-- resources/views/picks/search.blade.php -->

<!-- resources/views/picks/search.blade.php -->

<form id="rideForm" action="{{ route('picks.search.submit') }}" method="POST">
    @csrf
    <label for="pickup">Pickup Location:</label>
    <input type="text" id="pickup" name="pickup" required>
    <br>
    <label for="destination">Destination:</label>
    <input type="text" id="destination" name="destination" required>
    <br>
    <button type="submit">Submit</button>
</form>




    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script src="https://unpkg.com/leaflet-routing-machine/dist/leaflet-routing-machine.js"></script>
    <script>
        // Initialize the map
        var map = L.map('map').setView([51.505, -0.09], 13);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);

        // Function to geocode and plot route
        function plotRoute(pickup, destination) {
            // Geocode pickup location
            fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${pickup}`)
                .then(response => response.json())
                .then(data => {
                    if (data.length === 0) {
                        alert('Pickup location not found');
                        return;
                    }
                    var pickupLatLng = [data[0].lat, data[0].lon];
                    console.log('Pickup LatLng:', pickupLatLng);

                    // Geocode destination location
                    fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${destination}`)
                        .then(response => response.json())
                        .then(data => {
                            if (data.length === 0) {
                                alert('Destination not found');
                                return;
                            }
                            var destinationLatLng = [data[0].lat, data[0].lon];
                            console.log('Destination LatLng:', destinationLatLng);

                            // Clear existing layers
                            map.eachLayer(function (layer) {
                                if (!!layer.toGeoJSON) {
                                    map.removeLayer(layer);
                                }
                            });

                            // Add new layers for the pickup and destination
                            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                                attribution: '© OpenStreetMap contributors'
                            }).addTo(map);

                            var pickupMarker = L.marker(pickupLatLng).addTo(map)
                                .bindPopup('Pickup Location').openPopup();
                            var destinationMarker = L.marker(destinationLatLng).addTo(map)
                                .bindPopup('Destination').openPopup();

                            // Draw route
                            L.Routing.control({
                                waypoints: [
                                    L.latLng(pickupLatLng[0], pickupLatLng[1]),
                                    L.latLng(destinationLatLng[0], destinationLatLng[1])
                                ],
                                routeWhileDragging: true
                            }).addTo(map);

                            // Center map on the route
                            map.fitBounds(L.latLngBounds([pickupLatLng, destinationLatLng]));
                        });
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred while fetching the location data');
                });
        }

        // Handle form submission
    document.getElementById('rideForm').addEventListener('submit', function(event) {
        // event.preventDefault(); // Prevent form submission is commented out to allow form submission to the server

        var pickup = document.getElementById('pickup').value;
        var destination = document.getElementById('destination').value;

        plotRoute(pickup, destination);
    });
    </script>
</body>
</html>
