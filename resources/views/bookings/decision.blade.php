@extends('layouts.app')
@push('css')
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
            height: 400px;
            margin-bottom: 20px;
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

@section('content')
    <h1>受け入れる？？？</h1>
    <div id="map"></div>

    <p><strong>乗車地:</strong> {{ $booking->pickup_location }}</p>
    <p><strong>目的地:</strong> {{ $booking->dropoff_location }}</p>
    <p><strong>推定時間:</strong> <span id="duration">{{ $booking->taketime }}</span></p>
    <p><strong>価格:</strong> ¥<span id="fare">{{ $booking->fare }}</span></p>

    <div class="response-buttons">
        <a href="{{ route('booking.refuse') }}" class="yes">はい</a>
        <a href="{{ route('booking.accept') }}" class="no">いいえ</a>
    </div>

    @push('js')
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script src="https://unpkg.com/leaflet-routing-machine/dist/leaflet-routing-machine.js"></script>
    <script>
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
                                var formattedFare = totalFare.toFixed(2);

                                // Update the duration and fare in the HTML
                                document.getElementById('duration').value = duration.toFixed(2) + ' minutes';
                                document.getElementById('fare').value = formattedFare;
                            });
                        });
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred while fetching the location data');
                });
        }
        plotRoute(@json($booking->pickup_location), @json($booking->dropoff_location));
    </script>
    @endpush
    
@endsection