@extends('layouts.app')
@push('css')
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine/dist/leaflet-routing-machine.css" />
    <style>
        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }
        #map {
            width: 100%;
            height: 400px;
            margin: 0;
        }
        .info-section {
            border: 2px solid #ccc;
            padding: 20px;
            margin: 20px 10px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            background-color: #f9f9f9;
            text-align: center;
        }
        .info-section h2 {
            margin: 0 0 15px 0;
            font-size: 20px;
            font-weight: bold;
        }
        .info-section p {
            margin: 10px 0;
        }
        .response-buttons-container {
            text-align: center;
            margin-top: 20px;
        }
        .response-buttons-container h2 {
            margin-bottom: 10px;
            font-size: 18px;
        }
        .response-buttons {
            display: flex;
            justify-content: center;
            gap: 10px;
        }
        .response-buttons a {
            cursor: pointer;
            padding: 10px;
            font-size: 16px;
            text-decoration: none;
            text-align: center;
            width: 100px;
            color: white;
            border-radius: 4px;
        }
        .response-buttons .yes {
            background-color: #28a745; /* Green */
        }
        .response-buttons .no {
            background-color: #dc3545; /* Red */
        }
    </style>
@endpush

@section('content')
    <div id="map"></div>

    <div class="info-section">
        <h2>お客様リクエスト情報</h2>
        <p><strong>乗車地:</strong> {{ $booking->pickup_location }}</p>
        <p><strong>目的地:</strong> {{ $booking->dropoff_location }}</p>
        <p><strong>推定時間:</strong> <span id="duration">{{ $booking->taketime }}</span></p>
        <p><strong>料金:</strong> ¥<span id="fare">{{ $booking->fare }}</span></p>
    </div>

    <div class="response-buttons-container">
        <h2>ピックアップしますか？</h2>
        <div class="response-buttons">
            <a href="{{ route('booking.refuse') }}" class="yes">はい</a>
            <a href="{{ route('booking.accept') }}" class="no">いいえ</a>
        </div>
    </div>

    @push('js')
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
                                    var formattedFare = totalFare.toFixed(2);

                                    // Update the duration and fare in the HTML
                                    document.getElementById('duration').innerText = duration.toFixed(2) + ' 分';
                                    document.getElementById('fare').innerText = formattedFare;
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
    @endpush

@endsection
