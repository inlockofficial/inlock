@if ($errors->any())
    <div style="color:red;">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>INLOCK - Shop in Algeria</title>
    <link rel="stylesheet" href="{{ asset('css/landing.css') }}">

</head>
<body>
<h1>Fill Product Details</h1>

<form action="{{ route('admin.request.update', $request->id) }}" method="POST" enctype="multipart/form-data">
    @csrf

    <label>Title *</label>
    <input type="text" name="title" value="{{ $request->title }}" required>

    <label>Product Image *</label>
    <input type="file" name="image" accept="image/*" required>

    <label>Price USD *</label>
    <input type="number" step="0.01" name="price_usd" value="{{ $request->price_usd }}" required>

    <label>Shipping USD</label>
    <input type="number" step="0.01" name="shipping_usd" value="{{ $request->shipping_usd ?? 0 }}">

    <label>Service Margin (optional, DZD)</label>
    <input type="number" step="0.01" name="service_margin" value="0">

    <button type="submit">Update Product</button>
</form>
</body>
</html>