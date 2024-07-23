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
            justify-content: center;
            height: 100vh;
            background-color: #e9ecef;
        }

        .container {
            text-align: center;
            width: 100%;
            padding: 20px;
        }

        .edit-form {
            background: #ffffff;
            padding: 30px;
            margin: 20px;
            border-radius: 15px;
            box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.1);
        }

        .edit-form h1 {
            margin-bottom: 20px;
            color: #343a40;
        }

        .edit-form p {
            margin: 10px 0;
            color: #495057;
            font-size: 1rem;
        }

        .edit-button, .cancel-button {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px 25px;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            margin: 10px 5px;
            transition: background-color 0.3s;
        }

        .edit-button:hover, .cancel-button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="edit-form">
            <h1>プロフィール編集</h1>
            <form action="{{ route('driverprofile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <p>
                    <label for="driver_image">写真:</label>
                    <input type="file" name="driver_image" id="driver_image">
                </p>
                <p>
                    <label for="name">名前:</label>
                    <input type="text" name="name" id="name" value="{{ $user->name }}">
                </p>
                <p>
                    <label for="age">年齢:</label>
                    <input type="text" name="age" id="age" value="{{ $driverInfo->age }}">
                </p>
                <p>
                    <label for="email">メールアドレス:</label>
                    <input type="email" name="email" id="email" value="{{ $user->email }}">
                </p>
                <p>
                    <label for="phone">電話番号:</label>
                    <input type="text" name="phone" id="phone" value="{{ $user->phone }}">
                </p>
                <p>
                    <label for="driver_license">免許証番号:</label>
                    <input type="text" name="driver_license" id="driver_license" value="{{ $driverInfo->driver_license }}">
                </p>
                <p>
                    <label for="license_plate">車両番号:</label>
                    <input type="text" name="license_plate" id="license_plate" value="{{ $driverInfo->license_plate }}">
                </p>
                <button type="submit" class="edit-button">保存</button>
                <a href="{{ route('driverprofile.index') }}" class="cancel-button">キャンセル</a>
            </form>
        </div>
    </div>
</body>
</html>
