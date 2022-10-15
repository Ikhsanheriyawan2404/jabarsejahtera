<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>dfsafdsa</title>
</head>
<body>
    @foreach ($transactions as $transaction)
    <li>{{ $loop->iteration }} :<a href="{{ route('transaction.process', $transaction->id) }}">{{ $transaction->code_transaction }}</a></li>
    @endforeach
</body>
</html>
