<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rating</title>
    <style>
        .star {
            font-size: 2rem;
            color: grey;
            cursor: pointer;
        }
        .star.checked {
            color: yellow;
        }
    </style>
</head>
<body>
    <form action="{{ route('rate.store') }}" method="POST">
        @csrf
        <div class="stars">
            @for ($i = 1; $i <= 5; $i++)
                <span class="star" data-value="{{ $i }}">&#9733;</span>
            @endfor
        </div>
        <input type="hidden" name="rating" id="rating" value="">
        <button type="submit">Submit</button>
    </form>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const stars = document.querySelectorAll('.star');
            const ratingInput = document.getElementById('rating');

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
                });
            });
        });
    </script>

    @if(session('success'))
        <p>{{ session('success') }}</p>
    @endif
</body>
</html>
