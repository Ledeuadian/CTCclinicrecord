<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name', 'Crist the King') }}</title>
        <style>
            body {
                margin: 0;
                min-height: 100vh;
                display: flex;
                align-items: center;
                justify-content: center;
                background: #f3f4f6;
                color: #111827;
                font-family: Inter, system-ui, sans-serif;
            }
            .container {
                width: min(100%, 420px);
                padding: 2rem;
                text-align: center;
                background: white;
                border-radius: 1rem;
                box-shadow: 0 24px 80px rgba(15, 23, 42, 0.12);
            }
            .logo-wrap {
                display: grid;
                place-items: center;
                margin-bottom: 1.5rem;
            }
            h1 {
                margin: 0;
                font-size: 2rem;
                letter-spacing: -0.03em;
                font-weight: 700;
            }
            p {
                margin: 0.75rem auto 2rem;
                color: #4b5563;
                line-height: 1.6;
                max-width: 320px;
            }
            .buttons {
                display: grid;
                gap: 1rem;
            }
            .button {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                padding: 0.95rem 1.25rem;
                border-radius: 0.85rem;
                text-decoration: none;
                font-weight: 600;
                transition: background 200ms ease, color 200ms ease, transform 200ms ease;
                border: 1px solid #111827;
            }
            .button:hover {
                transform: translateY(-1px);
            }
            .button-primary {
                color: white;
                background: #111827;
                border-color: #111827;
            }
            .button-secondary {
                color: #111827;
                background: #ffffff;
            }
            .button-secondary:hover {
                background: #f9fafb;
            }
            @media (prefers-color-scheme: dark) {
                body { background: #0f172a; color: #f8fafc; }
                .container { background: #0b1120; box-shadow: 0 24px 80px rgba(15, 23, 42, 0.4); }
                p { color: #cbd5e1; }
                .button-secondary { color: #f8fafc; background: #111827; border-color: #1f2937; }
                .button-secondary:hover { background: #111827; }
                .button-primary { background: #e2e8f0; color: #0f172a; border-color: #e2e8f0; }
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="logo-wrap">
                <x-application-logo class="w-32 h-auto" />
            </div>
            <h1>{{ config('app.name', 'Crist the King') }}</h1>
            <p>Choose how you want to sign in to the clinic record system.</p>
            <div class="buttons">
                <a href="{{ route('login') }}" class="button button-secondary">User Log in</a>
                <a href="{{ route('admin.login') }}" class="button button-primary">Admin Log in</a>
            </div>
        </div>
    </body>
</html>
