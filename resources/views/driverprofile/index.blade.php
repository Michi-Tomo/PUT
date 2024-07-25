<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>マイページ</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.5.0/font/bootstrap-icons.min.css">
    <style>
        html, body {
            overflow-x: hidden; /* 横スクロールを無効にする */
            font-family: 'Helvetica Neue', Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: flex-start;
            height: 100vh;
            background-color: #ffffff;
        }

        .container {
            text-align: center;
            width: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 20px;
            margin-top: -53px; /* 画像との距離を調整 */
        }

        .profile-details {
            color: #343a40;
            width: 80%;
            margin-top: 20px; /* 追加: 画像との距離を調整 */
            font-size: 1.5rem; /* 文字を大きくする */
        }

        .profile-details img {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            margin-top: 15px;
        }

        .profile-details p {
            margin: 10px 0;
            color: #495057;
            font-size: 1.2rem; /* 文字を大きくする */
        }

        .icon-buttons {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }

        .edit-button, .logout-button {
            background: none;
            border: none;
            color: #6c757d;
            cursor: pointer;
            font-size: 2.5rem; /* 文字を大きくする */
            margin: 0 15px;
            transition: color 0.3s;
        }

        .edit-button:hover, .logout-button:hover {
            color: #343a40;
        }

        .menu-bar {
            width: 100%;
            background-color: #343a40;
            color: white;
            display: flex;
            justify-content: space-around;
            align-items: center;
            padding: 10px 0;
            position: fixed;
            bottom: 0;
        }

        .menu-item {
            text-align: center;
            flex: 1;
        }

        .menu-item a {
            color: white;
            text-decoration: none;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .menu-item a i {
            font-size: 1.5rem;
            margin-bottom: 5px;
        }

        .menu-item a span {
            font-size: 1.2rem;
        }

        .header-image {
            width: 100%;
            max-height: 200px;
            object-fit: cover;
            margin-top: 31px;
        }
    </style>
</head>
<body>
    <img src="{{ asset('images/put.png') }}" alt="Header Image" class="header-image">

    <div class="container">
        <div class="profile-details">
            <p><img src="{{ asset('storage/' . $driverInfo->driver_image ) }}" alt="Driver Photo"></p>
            <p>{{ Auth::user()->name }}さん</p>
            <p>年齢：{{ $driverInfo->age }}</p>
            <p>メールアドレス: {{ Auth::user()->email }}</p>
            <p>電話番号: {{ Auth::user()->phone }}</p>
            <p>免許証番号：{{ $driverInfo->driver_license }}</p>
            <p>車両番号：{{ $driverInfo->license_plate }}</p>
            <p>平均評価：{{ $averageRating ?? '評価が行われていません' }}</p>
            
            <div class="icon-buttons">
                <a href="{{ route('driverprofile.edit') }}" class="edit-button" title="編集">
                    <i class="bi bi-pencil-square"></i>
                </a>
                <form action="{{ route('logout') }}" method="POST" style="display: inline;" onsubmit="return confirmLogout();">
                    @csrf
                    <button type="submit" class="logout-button" title="ログアウト">
                        <i class="bi bi-box-arrow-right"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>

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
            <a href="/chatify">
                <i class="bi bi-chat-dots-fill"></i>
                <span>チャット</span>
            </a>
        </div>
        <div class="menu-item">
            <a href="/drivermyprofile">
                <i class="bi bi-person-fill"></i>
                <span>マイページ</span>
            </a>
        </div>
    </div>

    <script>
        function confirmLogout() {
            return confirm('ログアウトしますか？');
        }
    </script>
</body>
</html>
