<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>履歴一覧</title>
</head>
<body>
    <h1>履歴一覧</h1>
    <ul>
        @foreach ($histories as $history)
            <li>{{ $history->pickup_location }}</li>
            <li>{{ $history->dropoff_location }}</li>
            <li>{{ $history->taketime }}</li>
            <li>{{ $history->fare }}</li> 
        @endforeach
    </ul>
</body>
</html>
