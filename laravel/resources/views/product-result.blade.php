<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>INLOCK - Shop in Algeria</title>
    <link rel="stylesheet" href="{{ asset('css/landing.css') }}">
    <style>
        .btn {
            display: inline-block;
            padding: 10px 20px;
            margin: 10px 5px;
            font-size: 16px;
            border-radius: 6px;
            text-decoration: none;
            color: #fff;
            cursor: pointer;
        }
        .btn-back { background-color: #6c757d; }
        .btn-buy { background-color: #28a745; }
        .btn-cancel { background-color: #dc3545; }
        .btn:disabled { background-color: #aaa; cursor: not-allowed; }
    </style>
</head>
<body>

<h2>Product Details 🛒</h2>

<p><strong>Title:</strong> {{ $product->title }}</p>
<img src="{{ asset('storage/'.$product->image) }}" alt="{{ $product->title }}" width="250" loading="lazy">

<p><strong>Price:</strong> {{ number_format($product->final_price_dzd, 2) }} DZD</p>
<p><strong>Quantity:</strong> {{ $product->quantity }}</p>

@if($product->color)
<p><strong>Color:</strong> {{ $product->color }}</p>
@endif

@if($product->size)
<p><strong>Size:</strong> {{ $product->size }}</p>
@endif

@if($product->custom_note)
<p><strong>Extra Details:</strong> {{ $product->custom_note }}</p>
@endif

@if($product->screenshot)
<p><strong>Screenshot:</strong></p>
<img src="{{ asset('storage/'.$product->screenshot) }}" alt="Screenshot" width="250">
@endif

<!-- Buttons -->
<div>
    <a href="{{ route('welcome') }}" class="btn btn-back">⬅ Back to Home Page</a>

    @if($product->status == 'priced')
        @auth
            <!-- Form to create order -->
            <form action="{{ route('orders.store') }}" method="POST" style="display:inline;">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <button type="submit" class="btn btn-buy">💳 Buy Now</button>
            </form>
        @else
            <!-- User not logged in -->
            <a href="{{ route('login') }}" class="btn btn-buy">💳 Login to Buy</a>
        @endauth
    @else
        <button class="btn btn-buy" disabled>💳 Buy Now (Not Ready)</button>
    @endif

    @if($product->status === 'pending_review')
        <form action="{{ route('cancel.request', $product->id) }}" method="POST" style="display:inline;">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-cancel">❌ Cancel Request</button>
        </form>
    @endif
</div>

</body>
</html>