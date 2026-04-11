<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Redirecting to Payment</title>
</head>
<body>
    <p>Redirecting to payment, please wait...</p>

    <form id="chargilyForm" action="{{ route('chargilypay.redirect') }}" method="POST">
        @csrf
        <input type="hidden" name="order_id" value="{{ $order_id }}">
    </form>

    <script>
        document.getElementById('chargilyForm').submit();
    </script>
</body>
</html>

<noscript>
    <p>JavaScript is disabled. Click below to continue:</p>
    <button type="submit" form="chargilyForm">Pay Now</button>
</noscript>