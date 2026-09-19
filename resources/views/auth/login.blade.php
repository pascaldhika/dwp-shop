<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | {{ config('app.name') }}</title>

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('images/favicon.png') }}">

    <meta name="description" content="Warm minimalism login form with organic curves and gentle press feedback.">
    <meta name="author" content="Aigars Silkalns / Colorlib">
    <link rel="canonical" href="https://puikinsh.github.io/login-forms/forms/soft-minimalism/">

    <meta property="og:type" content="website">
    <meta property="og:title" content="Soft Minimalism Login Form">
    <meta property="og:description" content="Warm minimalism login form with organic curves and gentle press feedback.">
    <meta property="og:url" content="https://puikinsh.github.io/login-forms/forms/soft-minimalism/">
    <meta property="og:image" content="https://puikinsh.github.io/login-forms/assets/screenshots/soft-minimalism.png">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Soft Minimalism Login Form">
    <meta name="twitter:description" content="Warm minimalism login form with organic curves and gentle press feedback.">
    <meta name="twitter:image" content="https://puikinsh.github.io/login-forms/assets/screenshots/soft-minimalism.png">
    <link rel="stylesheet" href="{{ asset('css/style-auth.css') }}?v=2">
</head>
<body>
    <div class="soft-background">
        <div class="floating-shapes">
            <div class="soft-blob blob-1"></div>
            <div class="soft-blob blob-2"></div>
            <div class="soft-blob blob-3"></div>
            <div class="soft-blob blob-4"></div>
        </div>
    </div>

    <div class="login-container">
        <div class="soft-card">
            <div class="comfort-header">
                <div class="gentle-logo">
                    <div class="logo-circle">
                        <div class="comfort-icon">
                            <img src="{{ asset('images/logo.png') }}" width="100px">
                        </div>
                        <div class="gentle-glow"></div>
                    </div>
                </div>
                <h1 class="comfort-title">{{ config('app.name') }}</h1>
                <p class="gentle-subtitle">Sign In to your account</p>
                @if(Session::has('account_deactivated'))
                    <div class="alert alert-danger" role="alert">
                        {{ Session::get('account_deactivated') }}
                    </div>
                @endif
            </div>
            
            <form class="comfort-form" id="login" method="post" action="{{ url('/login') }}">
                @csrf
                <div class="soft-field">
                    <div class="field-container">
                        <input type="text" id="username" name="username" required placeholder="">
                        <label for="username">Username</label>
                        <div class="field-accent"></div>
                    </div>
                    <span class="gentle-error" id="emailError"></span>
                </div>

                <div class="soft-field">
                    <div class="field-container">
                        <input type="password" id="password" name="password" required autocomplete="current-password" placeholder="">
                        <label for="password">Password</label>
                        <!-- <button type="button" class="gentle-toggle" id="passwordToggle" aria-label="Toggle password visibility">
                            <div class="toggle-icon">
                                <svg class="eye-open" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                    <path d="M10 3c-4.5 0-8.3 3.8-9 7 .7 3.2 4.5 7 9 7s8.3-3.8 9-7c-.7-3.2-4.5-7-9-7z" stroke="currentColor" stroke-width="1.5" fill="none"/>
                                    <circle cx="10" cy="10" r="3" stroke="currentColor" stroke-width="1.5" fill="none"/>
                                </svg>
                                <svg class="eye-closed" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                    <path d="M3 3l14 14M8.5 8.5a3 3 0 004 4m2.5-2.5C15 10 12.5 7 10 7c-.5 0-1 .1-1.5.3M10 13c-2.5 0-4.5-2-5-3 .3-.6.7-1.2 1.2-1.7" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </div>
                        </button> -->
                        <div class="field-accent"></div>
                    </div>
                    <span class="gentle-error" id="passwordError"></span>
                </div>

                <div class="comfort-options">
                    <label class="gentle-checkbox">
                        <input type="checkbox" id="remember" name="remember">
                        <span class="checkbox-soft">
                            <div class="check-circle"></div>
                            <svg class="check-mark" width="12" height="10" viewBox="0 0 12 10" fill="none">
                                <path d="M1 5l3 3 7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </span>
                        <span class="checkbox-text">Remember me</span>
                    </label>
                    <a href="{{ route('password.request') }}" class="comfort-link">Forgot password?</a>
                </div>

                <button id="submit" type="submit" class="comfort-button">
                    <div class="button-background"></div>
                    <span class="button-text">Sign in</span>
                    <div class="button-loader">
                        <div id="spinner" class="gentle-spinner">
                            <div class="spinner-circle"></div>
                        </div>
                    </div>
                    <div class="button-glow"></div>
                </button>
            </form>

        </div>
    </div>

    <script>
        let login = document.getElementById('login');
        let submit = document.getElementById('submit');
        let username = document.getElementById('username');
        let password = document.getElementById('password');
        let spinner = document.getElementById('spinner')

        login.addEventListener('submit', (e) => {
            submit.disabled = true;
            username.readonly = true;
            password.readonly = true;

            spinner.style.display = 'block';

            login.submit();
        });

        setTimeout(() => {
            submit.disabled = false;
            username.readonly = false;
            password.readonly = false;

            spinner.style.display = 'none';
        }, 3000);
    </script>
</body>
</html>