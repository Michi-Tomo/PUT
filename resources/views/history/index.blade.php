<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>履歴一覧</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.5.0/font/bootstrap-icons.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
        }
        h1 {
            font-size: 20px;
            color: #333;
            text-align: center;
        }
        ul {
            list-style-type: none;
            padding: 0;
        }
        li {
            font-size: 18px; /* 文字サイズを変更 */
            background: #f9f9f9;
            margin: 5px 0;
            padding: 10px;
            border: 1px solid #ddd;
        }
        body {
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
            margin-top: 13px; /* 画像との距離を調整 */
        }

        .profile-details {
            color: #343a40;
            width: 80%;
            margin-top: 20px; /* 追加: 画像との距離を調整 */
            font-size: 1.5rem; /* 文字を大きくする */
        }

        .profile-details h1 {
            margin-bottom: 15px;
            font-size: 2rem; /* 文字を大きくする */
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

        .icon-button {
            background: none;
            border: none;
            color: #6c757d;
            cursor: pointer;
            font-size: 2.5rem; /* 文字を大きくする */
            margin: 0 15px;
            transition: color 0.3s;
        }

        .icon-button:hover {
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
            padding-left: 0px;
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
            font-size: 1.2rem; /* 文字を大きくする */
        }

        .header-image {
            width: 100%;
            max-height: 200px;
            object-fit: cover;
            margin-top: 94px;
        }
    </style>
    </style>
</head>
<body>
    <img src="/images/letter.jpg" alt="" style="width:100%; height:auto;">
    <h1>履歴一覧</h1>
    <ul>
        @foreach ($histories as $history)
            <li>{{ $history['pickup_location'] }}</li>
            <li>{{ $history['dropoff_location'] }}</li>
            <li>{{ $history['taketime'] }}</li>
            <li>{{ $history['fare'] }}</li>
        @endforeach
    </ul>
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
            <a href="/mypage">
                <i class="bi bi-person-fill"></i>
                <span>マイページ</span>
            </a>
        </div>
    </div>
</body>
</html>


<div class="menu-item">
    <a href="/drivermyprofile">
        <i class="bi bi-person-fill"></i>
        <span>マイページ</span>
    </a>
</div>
</div>