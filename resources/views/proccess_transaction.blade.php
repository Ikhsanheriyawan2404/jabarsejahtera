<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
        <form action="" method="post" id="transactionForm">
            <label for="nominal">nominal</label>
            <input type="number" name="nominal">
            <label for="nominal">nama</label>
            <input type="text" name="name">
            <label for="nominal">nomor hp</label>
            <input type="text" name="phone_number">
        </form>

        <button id="pay-button" data-id="{{ $donation->id }}">Pay!</button>

   <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}">
    </script>
    <script>
        const payButton = document.querySelector('#pay-button');
        payButton.addEventListener('click', function(e) {
            e.preventDefault();
            var formData = new FormData($('#transactionForm')[0]);
            $.ajax({
                var donation_id = $(this).data('id');
                url:"{{ route('transaction.index') }}" +'/' + donation_id,
                data: formData,
                contentType : false,
                processData : false,
                type: "POST",
                success:function(response) {
                    console.log('berhasli transaksi');
                },
                error:function(){
                    alert("error");
                }
            });
            snap.pay('{{ $snapToken }}', {
                // Optional
                onSuccess: function(result) {
                    /* You may add your own js here, this is just example */
                    // document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
                    console.log(result)
                },
                // Optional
                onPending: function(result) {
                    /* You may add your own js here, this is just example */
                    // document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
                    console.log(result)
                },
                // Optional
                onError: function(result) {
                    /* You may add your own js here, this is just example */
                    // document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
                    console.log(result)
                }
            });
        });
    </script>
</html>
