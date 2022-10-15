<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <form action="{{ route('transaction.store', $donation->id) }}" method="post">
        @csrf
        <label for="nominal">nominal</label>
        <input type="number" name="nominal">
        <label for="nominal">nama</label>
        <input type="text" name="name">
        <label for="nominal">nomor hp</label>
        <input type="text" name="phone_number">

        <button type="submit">Kirim!</button>
    </form>
</body>
</html>
