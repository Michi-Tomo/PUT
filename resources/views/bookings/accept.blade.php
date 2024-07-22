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
            margin: 0 -20px 20px -20px; /* Remove margin on left and right */
        }
        /* form {
            display: flex;
            flex-direction: column;
            align-items: center;
            max-width: 400px;
            margin: auto;
        } */
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

    </style>
</head>
<body>
    <h1></h1>

    <div id="map"></div>
   
   
        <form action="">
            @csrf
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-check-circle-fill bi-2x"></i> <!-- Larger icon -->
                Pick Up
            </button>

            <div class="driver-info1">
                <div class="driver-image">
                    <img src="{{ asset('storage/' . $users->driver_image) }}" alt="Driver Photo" style="width: 90px; height: 90px; border-radius: 50%; margin-top: 10px">
                </div>

            <div class="driver-info2">
                <div class="license-plate">
                    <p>登録済み車両番号 <br>{{ $users->license_plate ?? 'Not available' }}</p>
                </div>

                <div class="rating">
                    <p>あなたの平均評価 <br>{{ $averageRating ?? 'No ratings yet' }}</p>
                </div>
            </div>
            </div>
        </form>
  

    {{-- @foreach ($users as  $user)
    
   


    <form action="">
            @csrf
        <button type="submit" class="btn btn-primary">
            <i class="bi bi-check-circle-fill bi-2x"></i> <!-- Larger icon -->
            Pick Up
        </button>
            <!-- ドライバーの顔写真を表示 -->
            <img src="{{ asset('storage/' .  $user->driver_image )}}" alt="Driver Photo" style="width: 100px; height: 100px;">

            <!-- 他のドライバー情報も表示する -->
            Driver Plate: <p> {{  $user->license_plate ?? null }}</p>
    </form>
    @endforeach --}}


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
            <a href="/messages">
                <i class="bi bi-chat-dots-fill"></i>
                <span>メッセージ</span>
            </a>
        </div>
        <div class="menu-item">
            <a href="/mypage">
                <i class="bi bi-person-fill"></i>
                <span>マイページ</span>
            </a>
        </div>
    </div>
</body>
</html>

<!-- resources/views/layouts/app.blade.php (or wherever you include your layout) -->
@if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif
