<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rating</title>
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
            position: relative;
            width: 100%;
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .bike-illustration {
    width: 221px;
    height: 223px;
    background: url(/images/jp.png) no-repeat center center;
    background-size: contain;
    margin: 4px auto;
}

        .road {
            width: 110%;
            height: 3px;
            background-color: black;
            box-shadow: 0 4px 2px -2px gray;
            margin-top: -36px;
            margin-bottom: 65px;
        }

        .speech-bubble {
            position: relative;
            background: #fff;
            border-radius: .4em;
            margin: 5px auto;
            padding: 20px;
            width: 80%;
            box-shadow: 0px 0px 10px rgba(0,0,0,0.1);
        }

        .speech-bubble:after {
            content: '';
            position: absolute;
            bottom: 100%;
            left: 50%;
            margin-left: -10px;
            width: 0;
            height: 0;
            border: solid transparent;
            border-color: rgba(255, 255, 255, 0);
            border-bottom-color: #fff;
            border-width: 10px;
            pointer-events: none;
        }

        .star {
            font-size: 2rem;
            color: grey;
            cursor: pointer;
        }

        .star.checked {
            color: rgb(255, 196, 0);
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
    @if(session('success'))
        <p>{{ session('success') }}</p>
    @endif
    <div class="container">
        <div class="bike-illustration"></div>
        <div class="road"></div>
        <div class="speech-bubble">
            <p>ご乗車ありがとうございました</p>
            <p>評価</p>
            <div class="stars">
                <form action="{{ route('rate.store') }}" method="POST">
                    @csrf
                    @for ($i = 1; $i <= 5; $i++)
                        <span class="star" data-value="{{ $i }}">&#9733;</span>
                    @endfor
                    <input type="hidden" name="rating" id="rating">

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
        

        document.addEventListener('DOMContentLoaded', function () {
            const stars = document.querySelectorAll('.star');
            const ratingInput = document.getElementById('rating');
            const form = document.querySelector('.stars form');

            stars.forEach(star => {
                star.addEventListener('click', function () {
                    const value = this.getAttribute('data-value');
                    ratingInput.value = value;
                    stars.forEach(s => {
                        s.classList.remove('checked');
                    });
                    this.classList.add('checked');
                    for (let i = 0; i < value; i++) {
                        stars[i].classList.add('checked');
                    }
                    form.submit(); // フォームを自動的に送信
                });
            });
        });
    </script>
    <script>
        if(@json(session('success'))) {
            // alert("test")
            setTimeout(() => {
                window.location.replace('http://127.0.0.1:8000/home');
            }, 800);
        }
    </script>
    {{-- @if(session('success'))
    <p>{{ session('success') }}</p>
    @endif --}}
    
</body>
</html>
