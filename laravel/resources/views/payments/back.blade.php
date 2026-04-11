<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Status</title>
    <style>
        body { font-family: Arial, sans-serif; text-align: center; padding: 50px; }
        .status { font-size: 24px; margin: 20px 0; }
        .success { color: green; }
        .failed { color: red; }
        .pending { color: orange; }
    </style>
</head>
<body>
    <h1>Payment Confirmation</h1>

    <p>Checkout ID: <strong>{{ $checkout_id }}</strong></p>

    <p class="status 
        @if($status === 'paid') success 
        @elseif($status === 'canceled') failed 
        @else pending 
        @endif">
        Status: {{ ucfirst($status) }}
    </p>

    @if($amount)
        <p>Amount: <strong>{{ number_format($amount) }} DZD</strong></p>
    @endif

    <a href="{{ url('/') }}">Return to Home</a>
</body>
</html>