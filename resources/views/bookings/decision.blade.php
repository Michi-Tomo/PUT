@extends('layouts.app')
@push('css')
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine/dist/leaflet-routing-machine.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.5.0/font/bootstrap-icons.min.css">
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
        .info-container {
            margin: 20px 10px;
            text-align: center;
        }
        .info-title {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 10px;
        }
        .info-section {
            border: 2px solid #ccc;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            background-color: #f9f9f9;
            font-size: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 45px;
        }
        .info-section p {
            margin: 10px 0;
        }
        .icon-container {
            margin-right: 15px;
            display: flex;
            align-items: center;
            font-size: 36px;
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
            gap: 5px;
        }
        .button {
            display: flex;
            flex-direction: column;
            align-items: center;
            cursor: pointer;
            text-decoration: none;
            margin: 0 35px;
        }
        .button i {
            font-size: 36px;
        }
        .yes i {
            color: #2c4bff;
        }
        .no i {
            color: #ff0000;
        }
        .button span {
            font-size: 20px;
            color: #000000;
        }
    </style>
@endpush

@section('content')
    <div id="map"></div>

    <div class="info-container">
        {{-- <div class="info-title">お客様リクエスト情報</div> --}}
        <div class="info-section">
            <div class="icon-container">
                <i class="bi bi-person-check"></i>
            </div>
            <div>
                <p>{{ $booking->pickup_location }} ➡ {{ $booking->dropoff_location }}</p>
                <p><span id="duration">{{ $booking->taketime }}分</span>・<span id="fare">{{ $booking->fare }}円</span></p>
            </div>
        </div>
    </div>

    <div class="response-buttons-container">
        <h2>ピックアップしますか？</h2>
        <div class="response-buttons">
            <a href="{{ route('booking.accept') }}" class="button no">
                <i class="bi bi-x-circle-fill"></i>
                <span>いいえ</span>
            </a>
            <a href="{{ route('booking.refuse') }}" class="button yes">
                <i class="bi bi-check-circle-fill"></i>
                <span>はい</span>
            </a>
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
                                    var formattedFare = Math.ceil(totalFare);

                                    // Update the duration and fare in the HTML with rounded up values
                                    document.getElementById('duration').innerText = Math.ceil(duration) + ' 分';
                                    document.getElementById('fare').innerText = formattedFare + ' 円';
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
