<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>@yield('title', 'MU-LABS')</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <style>
        body { margin: 0; font-family: Inter, system-ui, -apple-system, 'Segoe UI', Roboto, 'Helvetica Neue', Arial; background: #f8fafc; color: #111827; }
        .container { max-width: 960px; margin: 0 auto; padding: 24px; }
        .card { background: #ffffff; border-radius: 12px; box-shadow: 0 8px 24px rgba(15, 23, 42, 0.08); padding: 28px; }
        img { border-radius: 9999px; display: block; margin-bottom: 18px; }
        a { color: #2563eb; text-decoration: none; }
        a:hover { text-decoration: underline; }
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            @yield('content')
        </div>
    </div>
</body>
</html>
