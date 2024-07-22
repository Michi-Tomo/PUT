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
    .container {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        height: 140vh;
    }
    .logo {
        margin-bottom: 50px;
    }
    .logo img {
        width: 300px; /* ロゴの幅を300pxに設定 */
        height: auto; /* 高さを自動調整 */
    }
    /* .auth-buttons {
            display: flex;
            flex-direction: column;
            align-items: center;
        } */

        /* .below {
            margin: 40px 0; /* ボタン間の余白を設定 */
            /* width: 400px;
            text-align: center;
            font-size: 25px;
        } */ 

        .below2 {
            margin: 100px 0;
            width: 400px;
            text-align: center;
            font-size: 25px;
        }

        .below3 {
            margin: 60px 0;
            width: 400px;
            text-align: center;
            font-size: 20px;
        }
</style>

<body>
    <div class="container">
        <div class="above">
            <img class="loginimg" src="{{ asset('images/pickup2.png') }}" alt="">
        </div>
        {{-- <div class="below">
            <a href="{{ route('login') }}" class="button">乗客</a>
        </div> --}}
        <div class="below2">
            <a href="{{ route('login') }}" class="button">ログイン</a>
        <div class="below3">
            会員ではないですか？<a href="{{ route('register') }}" class="button">新規登録する</a>
        </div>
    </div>
</body>
</html>