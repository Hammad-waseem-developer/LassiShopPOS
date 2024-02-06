<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Clients Print</title>
</head>

<body>
 
    <table class="display table table-md">
        <th>
            <tr>
                <td>Clients Id</td>
                <td>Code</td>
                <td>Full Name</td>
                <td>Phone</td>
                <td>Total Sale Due</td> 
                <td>Total Sell Return Due</td> 
                <td>Status</td> 
            </tr>
        </th>
        @foreach($clients as $client)
        <tr>
            <td>{{$client->id}}</td>
            <td>{{$client->code}}</td>
            <td>{{$client->username}}</td>
            <td>{{$client->phone}}</td>
            <td>{{$client->total_sale_due}}</td>
            <td>{{$client->total_sell_return_due}}</td>
            <td>
                @if($client->status == 1)
                <span class="badge badge-success">Active</span>
                @else
                <span class="badge badge-danger">Inactive</span>
                @endif
            </td>
        </tr>
        @endforeach

    </table>
</body>
<script>
    window.print();
</script>
</html>
