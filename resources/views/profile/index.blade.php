<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Page</title>
    <style>
        /* Add your styles here */
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
        }

        .menu-item a {
            color: white;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="profile-details">
            <h1>My Page</h1>
            <p>Welcome, {{ Auth::user()->name }}</p>
            <p>Email: {{ Auth::user()->email }}</p>
            <!-- Add more profile details as needed -->

            <!-- Logout Form -->
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit">ログアウト</button>
            </form>
        </div>
    </div>

    <div class="menu-bar">
        <div class="menu-item"><a href="/home">ホーム</a></div>
        <div class="menu-item"><a href="/history">履歴</a></div>
        <div class="menu-item"><a href="/messages">メッセージ</a></div>
        <div class="menu-item"><a href="/mypage">マイページ</a></div>
    </div>
</body>
</html>
