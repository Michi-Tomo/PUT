<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>マイページ</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.5.0/font/bootstrap-icons.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: space-between;
            height: 100vh;
            background-color: #f0f0f0;
        }

        .container {
            text-align: center;
            width: 100%;
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .profile-details {
            background: #fff;
            padding: 20px;
            margin: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }

        .edit-button {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            margin-top: 10px;
        }

        .edit-button:hover {
            background-color: #0056b3;
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
    </style>
</head>
<body>
    <div class="container">
        <div class="profile-details">
            <h1>マイページ</h1>
            <p><img src="{{ asset('storage/' . $driverInfo->driver_image ) }}" alt="Driver Photo" style="width: 90px; height: 90px; border-radius: 50%; margin-top: 10px">
            </p>
            <p>{{ Auth::user()->name }}さん</p>
            <p>年齢：{{ $driverInfo->age }}</p>
            <p>メールアドレス: {{ Auth::user()->email }}</p>
            <p>電話番号: {{ Auth::user()->phone }}</p> <!-- 追加された電話番号表示 -->
            <p>免許証番号：{{ $driverInfo->driver_license}}</p>
            <p>車両番号：{{ $driverInfo->license_plate }}</p>
            <p>平均評価：{{ $averageRating ?? 'No ratings yet' }}</p>
            
            
            <!-- 編集ボタン -->
            <a href="{{ route('profile.edit') }}" class="edit-button">編集</a>

            <!-- ログアウトフォーム -->
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit">ログアウト</button>
            </form>
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
            <a href="/messages">
                <i class="bi bi-chat-dots-fill"></i>
                <span>メッセージ</span>
            </a>
        </div>
        <div class="menu-item">
            <a href="/drivermypage">
                <i class="bi bi-person-fill"></i>
                <span>マイページ</span>
            </a>
        </div>
    </div>
</body>
</html>
