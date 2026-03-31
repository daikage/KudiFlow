<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'SME Automation') }} — Login & Register</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    <!-- Styles / Scripts -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif

    <style>
        :root {
            --bg: #FDFDFC;
            --bg-dark: #0a0a0a;
            --text: #1b1b18;
            --muted: #706f6c;
            --brand: #f53003;
            --card: #ffffff;
            --border: #e3e3e0;
            --input-bg: #fff;
            --input-border: #dcdcdc;
            --input-focus: #f53003;
        }
        @media (prefers-color-scheme: dark) {
            :root {
                --bg: #0a0a0a;
                --text: #EDEDEC;
                --muted: #A1A09A;
                --card: #161615;
                --border: #3E3E3A;
                --input-bg: #161615;
                --input-border: #3E3E3A;
            }
        }
        * { box-sizing: border-box; }
        body {
            margin: 0; min-height: 100vh; display: flex; align-items: center; justify-content: center;
            background: var(--bg); color: var(--text); font-family: "Instrument Sans", ui-sans-serif, system-ui, sans-serif;
        }
        .auth-wrapper { width: 100%; max-width: 960px; display: grid; grid-template-columns: 1fr 1fr; gap: 0; border: 1px solid var(--border); border-radius: 12px; overflow: hidden; background: var(--card); }
        .auth-visual { background: #fff2f2; padding: 32px; display: none; align-items: center; justify-content: center; }
        .auth-visual h2 { color: var(--brand); margin: 0 0 8px; }
        .auth-visual p { color: var(--muted); margin: 0; }
        .auth-card { padding: 32px; }
        .brand { display: flex; align-items: center; gap: 10px; margin-bottom: 8px; }
        .brand .dot { width: 10px; height: 10px; border-radius: 50%; background: var(--brand); }
        .muted { color: var(--muted); font-size: 0.95rem; }
        .tabs { display: flex; gap: 8px; margin: 20px 0 8px; }
        .tab {
            flex: 1; text-align: center; padding: 10px 14px; border: 1px solid var(--border);
            border-radius: 8px; cursor: pointer; user-select: none; transition: all .15s ease;
        }
        .tab.active { background: var(--brand); color: #fff; border-color: var(--brand); }
        form { display: none; }
        form.active { display: block; }
        .field { display: grid; gap: 6px; margin: 12px 0; }
        .field label { font-weight: 600; }
        .input {
            width: 100%; padding: 12px 14px; border: 1px solid var(--input-border); background: var(--input-bg);
            border-radius: 8px; color: var(--text); outline: none; transition: border-color .15s ease, box-shadow .15s ease;
        }
        .input:focus { border-color: var(--input-focus); box-shadow: 0 0 0 3px rgba(245,48,3,0.1); }
        .actions { display: flex; align-items: center; justify-content: space-between; margin-top: 18px; }
        .btn {
            display: inline-flex; align-items: center; justify-content: center; gap: 8px; border: 1px solid var(--border);
            background: var(--text); color: #fff; padding: 10px 16px; border-radius: 8px; cursor: pointer; text-decoration: none;
        }
        .btn.secondary { background: #fff; color: var(--text); }
        .helper { font-size: 0.9rem; color: var(--muted); margin-top: 10px; }
        .errors { background: #fff2f2; border: 1px solid #ffd2d2; color: #7a1b1b; padding: 10px 12px; border-radius: 8px; margin-bottom: 12px; }
        .sep { display: grid; grid-template-columns: 1fr auto 1fr; align-items: center; gap: 12px; margin: 16px 0; color: var(--muted); }
        .sep:before, .sep:after { content: ""; height: 1px; background: var(--border); display: block; }
        @media (min-width: 960px) {
            .auth-visual { display: flex; }
        }
    </style>
</head>
<body>
    <div class="auth-wrapper">
        <div class="auth-visual">
            <div>
                <h2>SME Automation</h2>
                <p>Clarity & Control for Small Businesses</p>
                <p class="muted" style="margin-top:8px;">Track sales, manage inventory, understand profit.</p>
            </div>
        </div>

        <div class="auth-card">
            <div class="brand">
                <span class="dot"></span>
                <strong>Welcome</strong>
            </div>
            <div class="muted">Sign in to continue, or create your account.</div>

            <div class="tabs" role="tablist" aria-label="Authentication tabs">
                <div id="tab-login" class="tab active" role="tab" aria-controls="panel-login" aria-selected="true">Login</div>
                <div id="tab-register" class="tab" role="tab" aria-controls="panel-register" aria-selected="false">Register</div>
            </div>

            @if ($errors->any())
                <div class="errors">
                    <ul style="margin:0; padding-left: 18px;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Login --}}
            <form id="panel-login" class="active" method="POST" action="{{ Route::has('login') ? route('login') : '/login' }}" aria-labelledby="tab-login">
                @csrf
                <div class="field">
                    <label for="login-email">Email</label>
                    <input id="login-email" class="input" type="email" name="email" placeholder="you@example.com" required autofocus />
                </div>
                <div class="field">
                    <label for="login-password">Password</label>
                    <input id="login-password" class="input" type="password" name="password" placeholder="••••••••" required />
                </div>
                <div class="actions">
                    <label style="display:flex; align-items:center; gap:8px;">
                        <input type="checkbox" name="remember" value="1" />
                        <span class="muted">Remember me</span>
                    </label>
                    <button type="submit" class="btn">Sign In</button>
                </div>
                <div class="helper">Don’t have an account? <a href="#" id="go-register">Register</a></div>
            </form>

            {{-- Register --}}
            <form id="panel-register" method="POST" action="{{ Route::has('register') ? route('register') : '/register' }}" aria-labelledby="tab-register">
                @csrf
                <div class="field">
                    <label for="reg-name">Business/Owner Name</label>
                    <input id="reg-name" class="input" type="text" name="name" placeholder="e.g. Adewale Stores" required />
                </div>
                <div class="field">
                    <label for="reg-email">Email</label>
                    <input id="reg-email" class="input" type="email" name="email" placeholder="you@example.com" required />
                </div>
                <div class="field">
                    <label for="reg-password">Password</label>
                    <input id="reg-password" class="input" type="password" name="password" placeholder="Create a strong password" required />
                </div>
                <div class="field">
                    <label for="reg-password-confirm">Confirm Password</label>
                    <input id="reg-password-confirm" class="input" type="password" name="password_confirmation" placeholder="Re-enter password" required />
                </div>
                <div class="actions">
                    <div></div>
                    <button type="submit" class="btn">Create Account</button>
                </div>
                <div class="sep"><span>or</span></div>
                <a class="btn secondary" href="#" id="go-login">Already have an account? Sign in</a>
            </form>

            <div class="helper" style="margin-top:16px;">
                For a quick demo of features without login, visit:
                <a href="/ui/dashboard">Dashboard Preview</a>
            </div>
        </div>
    </div>

    <script>
        const tabLogin = document.getElementById('tab-login');
        const tabRegister = document.getElementById('tab-register');
        const panelLogin = document.getElementById('panel-login');
        const panelRegister = document.getElementById('panel-register');
        const goRegister = document.getElementById('go-register');
        const goLogin = document.getElementById('go-login');

        function showLogin() {
            tabLogin.classList.add('active');
            tabRegister.classList.remove('active');
            panelLogin.classList.add('active');
            panelRegister.classList.remove('active');
            tabLogin.setAttribute('aria-selected', 'true');
            tabRegister.setAttribute('aria-selected', 'false');
        }

        function showRegister() {
            tabRegister.classList.add('active');
            tabLogin.classList.remove('active');
            panelRegister.classList.add('active');
            panelLogin.classList.remove('active');
            tabRegister.setAttribute('aria-selected', 'true');
            tabLogin.setAttribute('aria-selected', 'false');
        }

        tabLogin.addEventListener('click', showLogin);
        tabRegister.addEventListener('click', showRegister);
        if (goRegister) goRegister.addEventListener('click', (e) => { e.preventDefault(); showRegister(); });
        if (goLogin) goLogin.addEventListener('click', (e) => { e.preventDefault(); showLogin(); });
    </script>
</body>
</html>