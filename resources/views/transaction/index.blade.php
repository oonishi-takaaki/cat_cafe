<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ボタンの例</title>
</head>
<body>
    <form method="post" action="{{ route('admin.transaction.success') }}">
        @csrf
        <button type="submit">成功</button>
    </form>

    <form method="post" action="{{ route('admin.transaction.exception') }}">
        @csrf
        <button type="submit">失敗</button>

    {{-- </form>
        <form method="post" action="{{ route('admin.transaction.exception2') }}">
        @csrf
        <button type="submit">失敗2</button>
    </form> --}}
</body>
</html>