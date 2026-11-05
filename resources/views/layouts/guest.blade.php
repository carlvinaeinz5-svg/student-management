<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'Student Portal') }}</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <main class="auth-page">
            <div class="auth-layout">
                <aside class="auth-hero">
                    <div class="auth-decoration auth-decoration-orange"></div>
                    <div class="auth-decoration auth-decoration-green"></div>
                    <a class="auth-brand" href="{{ url('/') }}">
                        <span class="auth-brand-mark" aria-hidden="true">S</span>
                        <span>Student<span class="auth-brand-light">Portal</span></span>
                    </a>

                    <div class="auth-hero-copy">
                        <p class="auth-eyebrow">
                            <span></span>
                            LEARNING, ORGANIZED
                        </p>
                        <h1>Everything for your campus, in one place.</h1>
                        <p class="auth-hero-description">
                            Manage student records, explore courses, and keep registrations moving with one simple portal.
                        </p>
                    </div>

                    <div class="auth-feature-list">
                        <div>
                            <span class="auth-feature-dot auth-dot-green"></span>
                            Student records
                        </div>
                        <div>
                            <span class="auth-feature-dot auth-dot-orange"></span>
                            Course management
                        </div>
                        <div>
                            <span class="auth-feature-dot auth-dot-red"></span>
                            Easy registration
                        </div>
                    </div>

                    <p class="auth-hero-footer">A clearer way to stay on top of learning.</p>
                </aside>

                <section class="auth-form-panel">
                    <div class="auth-form-content">
                        {{ $slot }}
                    </div>
                    <p class="auth-security-note">
                        <span aria-hidden="true">●</span>
                        Secure access to your student portal
                    </p>
                </section>
            </div>
            <footer class="auth-page-footer">
                © {{ date('Y') }} Student Portal
                <span>•</span>
                Built for learning
            </footer>
        </main>
    </body>
</html>
