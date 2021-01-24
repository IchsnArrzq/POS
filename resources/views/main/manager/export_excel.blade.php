<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

</head>

<body>
    <center>

        <h1>Transaction Report</h1>
   
    <table border="2" align="center">
        <thead>
            @php
            $nomor = 1;
            @endphp
            <tr>
                <th>#</th>
                <th>Date Of Entry</th>
                <th>Goods Id</th>
                <th>User Id</th>
                <th>Stock</th>
                <th>Total</th>
            </tr>
        </thead>
        @foreach($transactions as $transaction)
        <tbody>
            <tr>
                <td>{{ $nomor++ }}</td>
                <td>{{ $transaction->created_at->format('d F, Y') }}</td>
                <td>{{ $transaction->goods_id }}</td>
                <td>{{ $transaction->user_id }}</td>
                <td>{{ $transaction->stock }}</td>
                <td>{{ $transaction->total }}</td>
            </tr>
        </tbody>
        @endforeach
    </table>

    </center>
</body>

</html>