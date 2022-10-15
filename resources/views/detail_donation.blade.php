<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    Judul {{ $donation->title }} <br>
    DEskrispi {{ $donation->description }} <br>
    TOatal dana {{ $donation->total_budget }} <br>

    <a id="pay-button" href="{{ route('donation.form', $donation->id) }}">Pay!</a>


</body>
</html>
