<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>プロフィール編集</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.5.0/font/bootstrap-icons.min.css">
    <style>
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
            overflow-x: hidden; /* 横スクロールを無効にする */
        }

        .container {
            text-align: center;
            width: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 20px;
            padding-bottom: 140px;
        }

        .edit-form {
            color: #343a40;
            width: 80%;
            margin-top: 20px;
            font-size: 1.2rem;
        }

        .edit-form p {
            margin: 10px 0;
            color: #495057;
        }

        .edit-form label {
            display: block;
            margin-bottom: 5px;
            color: #495057;
            font-size: 1rem;
        }

        .edit-form input {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ced4da;
            border-radius: 5px;
            font-size: 1rem;
        }

        .icon-buttons {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }

        .edit-button, .cancel-button {
            background: none;
            border: none;
            color: #6c757d;
            cursor: pointer;
            font-size: 2.5rem;
            margin: 0 15px;
            transition: color 0.3s;
        }

        .edit-button:hover, .cancel-button:hover {
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
            margin-top: 13px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .form-group label,
        .form-group input {
            width: 100%;
        }
    </style>
</head>
<body>
    <img src="{{ asset('images/put.png') }}" alt="Header Image" class="header-image">

    <div class="container">
        <div class="edit-form">
            <form action="{{ route('driverprofile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <p>
                    <label for="driver_image">写真:</label>
                    <input type="file" name="driver_image" id="driver_image">
                </p>
                <div class="form-group">
                    <label for="name">名前:</label>
                    <input type="text" name="name" id="name" value="{{ $user->name }}">
                </div>
                <div class="form-group">
                    <label for="age">年齢:</label>
                    <input type="text" name="age" id="age" value="{{ $driverInfo->age }}">
                </div>
                <div class="form-group">
                    <label for="email">メールアドレス:</label>
                    <input type="email" name="email" id="email" value="{{ $user->email }}">
                </div>
                <div class="form-group">
                    <label for="phone">電話番号:</label>
                    <input type="text" name="phone" id="phone" value="{{ $user->phone }}">
                </div>
                <div class="form-group">
                    <label for="driver_license">免許証番号:</label>
                    <input type="text" name="driver_license" id="driver_license" value="{{ $driverInfo->driver_license }}">
                </div>
                <div class="form-group">
                    <label for="license_plate">車両番号:</label>
                    <input type="text" name="license_plate" id="license_plate" value="{{ $driverInfo->license_plate }}">
                </div>
                <div class="icon-buttons">
                    <button type="submit" class="edit-button" title="保存">
                        <i class="bi bi-check-circle"></i>
                    </button>
                    <a href="{{ route('driverprofile.index') }}" class="cancel-button" title="キャンセル">
                        <i class="bi bi-x-circle"></i>
                    </a>
                </div>
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
