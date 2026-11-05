<x-guest-layout>
    <div class="auth-form-heading">
        <span class="auth-form-icon" aria-hidden="true">
            <svg viewBox="0 0 24 24" fill="none">
                <path
                    d="M4 10.5 12 5l8 5.5v8a1.5 1.5 0 0 1-1.5 1.5h-13A1.5 1.5 0 0 1 4 18.5v-8Z"
                    stroke="currentColor"
                    stroke-width="1.7"
                    stroke-linejoin="round"
                />
                <path
                    d="M9 20v-6h6v6M8 10h.01M12 10h.01M16 10h.01"
                    stroke="currentColor"
                    stroke-width="1.7"
                    stroke-linecap="round"
                />
            </svg>
        </span>
        <p class="auth-form-kicker">WELCOME BACK</p>
        <h2>Sign in to your account</h2>
        <p class="auth-form-subtitle">Use your email and password to continue.</p>
    </div>

    <x-auth-session-status class="auth-session-status" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="auth-form">
        @csrf

        <div class="auth-field">
            <x-input-label for="email" :value="__('Email address')" class="auth-label" />
            <input
                id="email"
                class="auth-input"
                type="email"
                name="email"
                value="{{ old('email') }}"
                placeholder="you@example.com"
                required
                autofocus
                autocomplete="username"
            />
            <x-input-error :messages="$errors->get('email')" class="auth-error" />
        </div>

        <div class="auth-field">
            <div class="auth-label-row">
                <x-input-label for="password" :value="__('Password')" class="auth-label" />
                @if (Route::has('password.request'))
                    <a class="auth-inline-link" href="{{ route('password.request') }}">Forgot password?</a>
                @endif
            </div>
            <input
                id="password"
                class="auth-input"
                type="password"
                name="password"
                placeholder="Enter your password"
                required
                autocomplete="current-password"
            />
            <x-input-error :messages="$errors->get('password')" class="auth-error" />
        </div>

        <div class="auth-remember-row">
            <label for="remember_me" class="auth-remember-label">
                <input id="remember_me" type="checkbox" name="remember" class="auth-checkbox">
                <span>Remember me</span>
            </label>
        </div>

        <button type="submit" class="auth-submit">
            <span>Sign in</span>
            <svg viewBox="0 0 24 24" fill="none" aria-hidden="true">
                <path
                    d="M5 12h14m-6-6 6 6-6 6"
                    stroke="currentColor"
                    stroke-width="1.8"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                />
            </svg>
        </button>
    </form>

    @if (Route::has('register'))
        <p class="auth-register-prompt">New to the portal? <a href="{{ route('register') }}">Create an account</a></p>
    @endif
</x-guest-layout>
