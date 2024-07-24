<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Top Page</title>
    {{-- <link rel="stylesheet" href="{{ asset('css/app.css') }}"> --}}
</head>

<style>
    body, html {
        margin: 0;
        padding: 0;
        height: 100%;
    }
    .container {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center; /* 上下の中央に配置 */
        height: 106vh; /* コンテナの高さを画面全体に合わせる */
    }
    .logo {
        margin-bottom: 30px; /* ロゴと以下の要素の距離を詰める */
    }
    .logo img {
        width: 420px; /* ここでロゴの幅を調整 */
        height: auto; /* 高さを自動調整 */
        margin-left: 22px;
    }
    .below2 {
        margin: 20px 0; /* ログインの位置を上に */
        width: 400px;
        text-align: center;
        font-size: 25px;
    }

    .below3 {
        margin: 10px 0; /* 新規登録の位置を詰める */
        width: 400px;
        text-align: center;
        font-size: 20px;
    }
</style>

<body>
    <div class="container">
        <div class="logo">
            <img class="loginimg" src="{{ asset('images/jp.png') }}" alt="Logo">
        </div>

        <div class="below2">
            <a href="{{ route('login') }}" class="button">ログインする</a>
        </div>
        <div class="below3">
            会員ではないですか？<a href="{{ route('register') }}" class="button">新規登録する</a>
        </div>
    </div>
</body>
</html>
