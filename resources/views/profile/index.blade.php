<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>マイページ</title>
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
            font-size: 2rem;
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
</head>
<body>
    <img src="{{ asset('images/put.png') }}" alt="Header Image" class="header-image">

    <div class="container">
        <div class="profile-details">
            <h1></h1>
            <p>ようこそ、{{ Auth::user()->name }}さん</p>
            <p>メールアドレス: {{ Auth::user()->email }}</p>
            <p>電話番号: {{ Auth::user()->phone }}</p>
            
            <div class="icon-buttons">
                <a href="{{ route('profile.edit') }}" class="icon-button" title="編集">
                    <i class="bi bi-pencil-square"></i>
                </a>
                <form action="{{ route('logout') }}" method="POST" style="display: inline;" onsubmit="return confirmLogout();">
                    @csrf
                    <button type="submit" class="icon-button" title="ログアウト">
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
            <a href="/mypage">
                <i class="bi bi-person-fill"></i>
                <span>マイページ</span>
            </a>
        </div>
    </div>

    <script>
        function confirmLogout() {
            return confirm('ログアウトしますか？');
        }

        document.getElementById('logout-form').addEventListener('submit', function(event) {
            event.preventDefault(); // フォームのデフォルト送信を防ぐ
            // フォームを送信
            fetch(this.action, {
                method: this.method,
                body: new FormData(this)
            }).then(response => {
                if (response.ok) {
                    window.location.href = '/vendor/top.blade.php'; // 成功したらトップページにリダイレクト
                } else {
                    alert('ログアウトに失敗しました。再度お試しください。');
                }
            }).catch(error => {
                console.error('Error:', error);
                alert('ログアウトに失敗しました。再度お試しください。');
            });
        });
    </script>
</body>
</html>
