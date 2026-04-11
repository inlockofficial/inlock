<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>INLOCK - Shop in Algeria</title>
    <link rel="stylesheet" href="{{ asset('css/landing.css') }}">

</head>
<body>
<h1>Pending Requests</h1>

@if(session('success'))
    <p>{{ session('success') }}</p>
@endif

<table border="1" cellpadding="10">
    <tr>
        <th>ID</th>
        <th>AliExpress Link</th>
        <th>Status</th>
        <th>Action</th>
    </tr>
    @foreach($requests as $req)
    <tr>
        <td>{{ $req->id }}</td>
        <td><a href="{{ $req->ali_link }}" target="_blank">{{ $req->ali_link }}</a></td>
        <td>{{ $req->status }}</td>
        <td>
            <a href="{{ route('admin.request.show', $req->id) }}">Fill Details</a>
        </td>
    </tr>
    @endforeach
</table>
</body>
</html>