<x-guest-layout>

    <h2 class="text-2xl font-semibold mb-6 text-center">
        Welcome Back
    </h2>

    <x-auth-session-status class="mb-4 text-green-400" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        <div>
            <x-input-label for="email" value="Email" />
            <x-text-input id="email" type="email" name="email"
                :value="old('email')" required autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-400"/>
        </div>

        <div>
            <x-input-label for="password" value="Password" />
            <x-text-input id="password" type="password"
                name="password" required />
            <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-400"/>
        </div>

        <label class="flex items-center text-sm text-gray-400">
            <input type="checkbox" name="remember"
                class="mr-2 rounded bg-[#0f1115] border-[#242833]">
            Remember me
        </label>

        <x-primary-button>
            Log in
        </x-primary-button>

        <div class="text-center text-sm text-gray-400">
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}"
                   class="hover:text-[#e9c38c] transition">
                    Forgot password?
                </a>
            @endif
        </div>

        <p class="text-center text-sm text-gray-500">
            No account?
            <a href="{{ route('register') }}"
               class="text-[#e9c38c] hover:underline">
                Create one
            </a>
        </p>

    </form>

</x-guest-layout>