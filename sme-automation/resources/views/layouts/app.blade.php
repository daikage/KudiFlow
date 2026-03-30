<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>{{ $title ?? 'SME Automation' }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Minimal styles for quick preview; safe to remove if not needed -->
    <link href="https://cdn.jsdelivr.net/npm/@picocss/pico@1/css/pico.min.css" rel="stylesheet">
    <style>
        body { max-width: 1000px; margin: 2rem auto; }
        .tag { background:#eef; padding:.2rem .5rem; border-radius:.3rem; font-size:.85rem; }
    </style>
</head>
<body>
<main>
    <header>
        <h3>{{ $title ?? 'SME Automation' }}</h3>
        <p class="tag">Placeholder Blade view (Stitch will provide the real UI)</p>
        <nav>
            <small>
                <a href="/ui/dashboard">Dashboard</a> |
                <a href="/ui/products">Products</a> |
                <a href="/ui/categories">Categories</a> |
                <a href="/ui/sales">Sales</a> |
                <a href="/ui/expenses">Expenses</a> |
                <a href="/ui/staff">Staff</a> |
                <a href="/ui/admin">Admin</a> |
                <a href="/ui/admin/subscriptions">Subscriptions</a>
            </small>
        </nav>
        <hr/>
    </header>

    <section>
        @yield('content')
    </section>
</main>
</body>
</html>
