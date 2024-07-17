<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Top Page</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>



<body>
    <div class="container">
        <div class="left-side">
            <img class="loginimg" src="{{ asset('images/pickup.png') }}" alt="">
        </div>
        <div class="right-side">
            {{-- <img class="logo" src="{{ asset{{ 'image/todologo.png' }} }}"> --}}
            <a href="{{ route('login') }}" class="button">ログイン</a>
            <a href="{{ route('register') }}" class="button">新規登録</a>
        </div>
    </div>
</body>
</html>