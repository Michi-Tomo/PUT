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
    </style>
@endpush
{{-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ride Request Result</title>
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
    </style>
</head>
<body> --}}
@section('content')
    <h1>予約</h1>
    <div id="map"></div>

    <form action="{{ route('bookings.store') }}" method="POST">
        @csrf
        <input type="text" id="lat" name="lat" >
        <input type="text" id="lon" name="lon" >
        <div>
            <label for="">乗車地:</label>
            <input type="text" name="pickup_location" value="{{ $pickup }}">
        </div>

        <div>
            <label for="">目的地:</label>
            <input type="text" name="dropoff_location" value="{{ $destination }}">
        </div>

        <div>
            <label for="">推定時間:</label>
            <input type="text" name="taketime" value="{{ $duration }}" id="duration">
        </div>

        <div>
            <label for="">価格:</label>
            <input type="text" name="fare" value="{{ $totalFare }}" id="fare">
        </div>
        
        {{-- <p><strong>乗車地:</strong> {{ $pickup }}</p> --}}
        {{-- <p><strong>目的地:</strong> {{ $destination }}</p> --}}
        {{-- <p><strong>推定時間:</strong> <span id="duration">{{ $duration }}</span></p>
        <p><strong>価格:</strong> ¥<span id="fare">{{ $totalFare }}</span></p> --}}

        <button type="submit">予約</button>
    </form>
    <div>
        <a href="javascript:history.back()">検索ページに戻る</a>
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

                    const lat = document.getElementById('lat').value = data[0].lat
                    const lon = document.getElementById('lon').value = data[0].lon

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

        // Call plotRoute function with PHP variables
        var pickup = "{{ $pickup }}";
        var destination = "{{ $destination }}";
        plotRoute(pickup, destination);
    </script>
    @endpush
    
@endsection
{{-- </body>
</html> --}}




