<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>@yield('title', 'MULABS')</title>
    <style>
        :root{ --card-bg:#fff; --primary:#1976d2; --muted:#6b7280 }
        html,body{margin:0;font-family:Inter, system-ui, -apple-system, 'Segoe UI', Roboto, 'Helvetica Neue', Arial}
        body{
            display:flex;align-items:center;justify-content:center;
            background: linear-gradient(135deg, rgb(23, 65, 77) 0%, rgb(45, 120, 150) 100%);
            min-height:100vh;padding:20px;margin:0;
        }
        .auth-card{
            width:100%;max-width:500px;background:var(--card-bg);border-radius:10px;padding:40px;
            box-shadow:0 8px 30px rgba(17,24,39,0.15);text-align:center;
            max-height:90vh;overflow-y:auto;
        }
        .auth-card .logo{width:140px;height:auto;margin:0 auto 18px;display:block}
        .auth-card h1{font-size:22px;margin:6px 0 18px;color:#111827;font-weight:600}
        .field{margin-bottom:16px;text-align:left}
        .field input, .field select, .field textarea{
            width:100%;padding:12px 14px;border:1px solid #e5e7eb;border-radius:8px;font-size:15px;color:#111827;
            box-sizing:border-box;outline:none;transition:box-shadow 0.12s, border-color 0.12s;font-family:inherit;
        }
        .field input::placeholder{color:#9ca3af}
        .field input:focus, .field select:focus, .field textarea:focus{border-color:var(--primary);box-shadow:0 0 0 4px rgba(25,118,210,0.06)}
        .btn-submit{display:inline-block;width:100%;padding:12px 14px;background:tomato;color:#fff;border:none;border-radius:8px;font-size:16px;cursor:pointer;font-weight:500;transition:filter 0.2s}
        .btn-submit:hover{filter:brightness(0.95)}
        .muted{color:var(--muted);font-size:14px;margin-top:12px}
        .error{color:#b91c1c;margin-bottom:12px;text-align:left;font-size:14px}
        .error ul{margin:4px 0;padding-left:18px}
        .success{color:#166534;margin-bottom:12px;text-align:left;font-size:14px}
        .small-link{margin-top:10px;display:block;text-align:left;font-size:13px}
        a.small-link{color:var(--primary);text-decoration:none}
        a.small-link:hover{text-decoration:underline}
        @media (max-width:480px){.auth-card{padding:24px;max-width:100%}}
    </style>
</head>
<body>
    <div class="auth-card">
        <img src="/logo.png" alt="Mzumbe University" class="logo">
        @yield('content')
    </div>
    <script>
        document.querySelectorAll('form[method="POST"]').forEach((form) => {
            if (form.querySelector('[name="return_to"]')) {
                return;
            }

            const returnTo = document.createElement('input');
            returnTo.type = 'hidden';
            returnTo.name = 'return_to';
            returnTo.value = document.referrer;
            form.appendChild(returnTo);
        });

        @if(session('success'))
            window.setTimeout(() => {
                document.querySelector('.success')?.remove();

                const returnTo = @json(session('return_to'));
                if (returnTo) {
                    window.location.assign(returnTo);
                }
            }, 3000);
        @endif
    </script>
</body>
</html>
