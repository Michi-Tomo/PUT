<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chatify Chat</title>
    <!-- Include Chatify CSS -->
    <link href="{{ asset('css/chatify.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        <!-- Chatify Messenger -->
        @include('Chatify::layouts.messenger')
    </div>
    <!-- Include Chatify JavaScript -->
    <script src="{{ asset('js/chatify.js') }}"></script>
</body>
</html>
