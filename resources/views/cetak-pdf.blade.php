<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style type="text/css">
        table,
        th,
        td {
            border: 1px solid black
        }
    
        .container{
          margin-left: 250px;
        }
    
        table{
          width: 500px
        }
    </style>
</head>

<body>
    <div class="container">
      <div class="con">

        <p>
            Created:
            {{ \Carbon\Carbon::now()->setTimezone('Asia/Jakarta')->locale('id')->isoFormat('D MMMM YYYY, HH:mm') }}
        </p>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">No</th>
                    <th scope="col">Menu</th>
                    <th scope="col">Qty</th>
                    <th scope="col">Harga</th>
                </tr>
            </thead>
            <tbody>
                @php
                $no=1;
                @endphp
                @foreach ($data['order_name'] as $index => $orname)
                <tr>
                    <th scope="row">{{$no++}}</th>
                    <td>{{$orname}}</td>
                    <td>{{$data['order_qty'][$index]}}</td>
                    <td>Rp {{$data['order_price'][$index]}}</td>
                </tr>
                @endforeach

            </tbody>
        </table>
        <p>Total : Rp {{$data['total']}}</p>
    </div>
  </div>

</body>

</html>
