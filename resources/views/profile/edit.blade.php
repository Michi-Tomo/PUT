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
        }

        .container {
            text-align: center;
            margin-right: 31px;
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 20px;
            margin-bottom: 60px; /* メニューバーに被らないように調整 */
        }

        .profile-edit {
            padding: 20px;
            width: 80%;
            max-width: 500px;
        }

        form input {
            width: 100%;
            padding: 15px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 1rem;
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
            font-size: 2.5rem; /* アイコンを大きくする */
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
            font-size: 1.2rem;
        }
    </style>
</head>
<body>
    <img src="{{ asset('images/put.png') }}" alt="Header Image" class="header-image">
    <div class="container">
        <div class="profile-edit">
            <form id="profile-form" action="{{ route('profile.update') }}" method="POST">
                @csrf
                <input type="text" name="name" value="{{ old('name', $user->name) }}" placeholder="名前" required>
                <input type="email" name="email" value="{{ old('email', $user->email) }}" placeholder="メールアドレス" required>
                <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" placeholder="電話番号">
                <input type="password" name="password" placeholder="パスワード（変更する場合のみ）">
                <input type="password" name="password_confirmation" placeholder="パスワード確認">
                
                <div class="icon-buttons">
                    <button type="submit" class="icon-button" title="更新">
                        <i class="bi bi-check-circle"></i>
                    </button>
                    <a href="/mypage" class="icon-button" title="キャンセル">
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
            <a href="/mypage">
                <i class="bi bi-person-fill"></i>
                <span>マイページ</span>
            </a>
        </div>
    </div>

    <script>
        document.getElementById('profile-form').addEventListener('submit', function(event) {
            event.preventDefault(); // フォームのデフォルト送信を防ぐ
            // フォームを送信
            fetch(this.action, {
                method: this.method,
                body: new FormData(this)
            }).then(response => {
                if (response.ok) {
                    window.location.href = '/mypage'; // 成功したらプロフィール画面にリダイレクト
                } else {
                    alert('更新に失敗しました。再度お試しください。');
                }
            }).catch(error => {
                console.error('Error:', error);
                alert('更新に失敗しました。再度お試しください。');
            });
        });
    </script>
</body>
</html>
