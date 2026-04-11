<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>INLOCK — Reviewing Product</title>

    @vite(['resources/css/app.css','resources/js/app.js'])
</head>

<body class="bg-[#0b0f19] text-white min-h-screen flex items-center justify-center">

    <!-- Background glow -->
    <div class="absolute inset-0 opacity-20 blur-3xl
        bg-[radial-gradient(circle_at_center,#e9c38c_0%,transparent_60%)]">
    </div>

    <!-- CARD -->
    <div class="
        relative
        bg-[#171a21]
        border border-[#242833]
        rounded-2xl
        shadow-xl
        p-10
        max-w-lg
        w-full
        text-center
    ">

        <!-- Logo / Title -->
        <h1 class="text-3xl font-bold mb-3 tracking-wide">
            <span class="text-[#e9c38c]">INLOCK</span>
        </h1>

        <h2 class="text-xl font-semibold text-gray-200 mb-6">
            We're checking your product 🔎
        </h2>

        <!-- Loader -->
        <div class="flex justify-center mb-6">
            <div class="relative w-14 h-14">

                <div class="absolute inset-0 rounded-full
                    border-2 border-[#242833]"></div>

                <div class="absolute inset-0 rounded-full
                    border-2 border-[#e9c38c]
                    border-t-transparent
                    animate-spin">
                </div>

            </div>
        </div>

        <!-- Description -->
        <p class="text-gray-400 mb-6 leading-relaxed">
            Our team is reviewing your product and calculating the final price
            including shipping and service fees.
            <br>
            <span class="text-gray-500 text-sm">
                This usually takes 5–30 minutes.
            </span>
        </p>

        <!-- STATUS BADGE -->
        <div class="mb-6">
            <span id="status"
                class="px-4 py-2 rounded-full text-sm font-semibold
                bg-yellow-500/20 text-yellow-400 border border-yellow-500/30">
                {{ ucfirst($request->status) }}
            </span>
        </div>

        <!-- Info box -->
        <div class="
            bg-[#0f1115]
            border border-[#242833]
            rounded-lg
            p-4
            text-sm text-gray-400
        ">
            ⏳ You will be redirected automatically once pricing is ready.
        </div>

    </div>


<script>
    const requestId = {{ $request->id }};

    function checkStatus() {
        fetch(`/request/${requestId}/status`)
            .then(res => res.json())
            .then(data => {

                const statusEl = document.getElementById('status');
                statusEl.innerText =
                    data.status.charAt(0).toUpperCase() +
                    data.status.slice(1);

                // change badge color dynamically
                statusEl.className =
                    "px-4 py-2 rounded-full text-sm font-semibold border ";

                if (data.status === 'priced') {
                    statusEl.classList.add(
                        "bg-green-500/20",
                        "text-green-400",
                        "border-green-500/30"
                    );

                    setTimeout(() => {
                        window.location.href =
                            `/request/${requestId}/view`;
                    }, 1200);
                } else {
                    statusEl.classList.add(
                        "bg-yellow-500/20",
                        "text-yellow-400",
                        "border-yellow-500/30"
                    );
                }
            });
    }

    setInterval(checkStatus, 5000);
</script>

</body>
</html>