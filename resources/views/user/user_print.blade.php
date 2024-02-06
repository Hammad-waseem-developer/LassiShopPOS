<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <table class="table">
        <th>
            <tr>
                <td>Id</td>
                <td>Username</td>
                <td>Email</td>
                <td>Status</td>
                <td>Role</td>
            </tr>
        </th>
        <tbody>
            @foreach($users as $user)
            <tr>
                <td>{{$user->id}}</td>
                <td>{{$user->username}}</td>
                <td>{{$user->email}}</td>
                <td>
                    @if($user->status)
                    <span class="badge badge-success m-2">{{ __('translate.Active') }}</span>
                    @else
                    <span class="badge badge-danger m-2">{{ __('translate.Inactive') }}</span>
                    @endif
                </td>
                <td>{{$user->RoleUser['name']}}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
<script>
    window.print();
</script>
</html>