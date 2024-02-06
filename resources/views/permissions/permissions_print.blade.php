<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>
    <table class="table table-bordered">
        <thead>
            <tr>
                <td>Role Id</td>
                <td>Role Name</td>
                <td>Role Description</td>
            </tr>
        </thead>
        @foreach ($roles as $role)
            <tr>
                <td>{{ $role->id }}</td>
                <td>{{ $role->name }}</td>
                <td>{{ $role->description }}</td>
            </tr>
        @endforeach
    </table>
</body>
<script>
    window.print();
</script>
</html>
