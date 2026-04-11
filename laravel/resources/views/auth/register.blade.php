<x-guest-layout>

    <h2 class="text-2xl font-semibold mb-6 text-center">
        Create your INLOCK account
    </h2>

    <form method="POST" action="{{ route('register') }}" class="space-y-5">
        @csrf

        <div>
            <x-input-label for="name" value="Name" />
            <x-text-input id="name" type="text" name="name"
                :value="old('name')" required autofocus />
            <x-input-error :messages="$errors->get('name')" class="mt-2 text-red-400"/>
        </div>

        <div>
            <x-input-label for="email" value="Email" />
            <x-text-input id="email" type="email"
                name="email" :value="old('email')" required />
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-400"/>
        </div>

        <div>
            <x-input-label for="password" value="Password" />
            <x-text-input id="password" type="password"
                name="password" required />
            <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-400"/>
        </div>

        <div>
            <x-input-label for="password_confirmation" value="Confirm Password" />
            <x-text-input id="password_confirmation"
                type="password"
                name="password_confirmation" required />
        </div>

        <x-primary-button>
            Register
        </x-primary-button>

        <p class="text-center text-sm text-gray-500">
            Already registered?
            <a href="{{ route('login') }}"
               class="text-[#e9c38c] hover:underline">
                Log in
            </a>
        </p>

    </form>

</x-guest-layout>