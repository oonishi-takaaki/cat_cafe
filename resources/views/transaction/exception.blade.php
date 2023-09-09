<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ボタンの例</title>
</head>
<body>
    ERROR
    <form method="get" action="{{ route('admin.transaction.index') }}">
        @csrf
        <button type="submit">最初に戻る</button>
    </form>
</body>
</html>