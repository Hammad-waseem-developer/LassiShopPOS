<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Your Website Title')</title>
    <!-- Add your CSS stylesheets, meta tags, and other head content here -->
</head>
<body>
    <h1></h1>
    <table>
        <thead>
            <tr>
                <th>Id</th>
                <th>Type</th>
                <th>Name</th>
                <th>Code</th>
                <th>Category</th>
                <th>Brand</th>
                <th>product Cost</th>
                <th>product Price</th>
                <th>Current Stock</th>
            </tr>
        </thead>
        <tbody>
            @foreach($products as $product)
            <tr>
                <td>{{$product->id}}</td>
                <td>{{$product->type}}</td>
                <td>{{$product->name}}</td>
                <td>{{$product->code}}</td>
                <td>{{$product->category->name}}</td>
                <td>{{$product->brand->name}}</td>
                <td>{{$product->cost}}</td>
                <td>{{$product->price}}</td>
                <td>{{$product->PurchaseDetail->quantity ?? 0}}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
<script>
    window.print();
</script>