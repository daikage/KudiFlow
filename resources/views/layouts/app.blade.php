<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>@yield('title', 'SME Automation')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --sidebar-bg: #0b2239;
            --sidebar-link: #cfe0ff;
            --sidebar-link-active: #fff;
            --sidebar-width: 260px;
        }
        body { background-color: #f5f7fb; }
        .sidebar {
            position: fixed; top: 0; bottom: 0; left: 0;
            width: var(--sidebar-width);
            background: var(--sidebar-bg); color: #fff; z-index: 1030;
            overflow-y: auto; padding: 1rem 0;
        }
        .sidebar .brand {
            padding: 0 1rem 1.2rem 1rem; border-bottom: 1px solid rgba(255,255,255,0.1);
            margin-bottom: 1rem;
        }
        .sidebar .nav-link {
            color: var(--sidebar-link); padding: .65rem 1rem; border-radius: .35rem; margin: .2rem .6rem;
        }
        .sidebar .nav-link.active, .sidebar .nav-link:hover {
            color: var(--sidebar-link-active); background: rgba(255,255,255,0.12);
        }
        .content {
            margin-left: var(--sidebar-width); min-height: 100vh; display: flex; flex-direction: column;
        }
        /* added: allow pages to hide sidebar and use full width */
        .content.no-sidebar { margin-left: 0; }
        .topbar {
            background: #fff; border-bottom: 1px solid #e9edf4; padding: .65rem 1rem;
        }
        .page-content { padding: 1.2rem; flex: 1; }
        .card-kpi { border: none; box-shadow: 0 1px 2px rgba(16, 24, 40, 0.06), 0 1px 1px rgba(16, 24, 40, 0.06); }
        .table thead th { background: #f7f9fc; font-weight: 600; }
        @media (max-width: 991px){
            .sidebar { transform: translateX(-100%); transition: transform .2s ease; }
            .sidebar.show { transform: translateX(0); }
            .content { margin-left: 0; }
        }
    </style>
    @stack('styles')
</head>
<body>
{{-- only include sidebar if the view didn't opt-out --}}

    @include('partials.sidebar')


<div class="content @hasSection('no-sidebar') no-sidebar @endif">
    @include('partials.topbar')

    <div class="page-content">
        @hasSection('page-header')
            <div class="d-flex align-items-center justify-content-between mb-3">
                <div>
                    <h4 class="mb-0">@yield('page-header')</h4>
                    @hasSection('breadcrumbs')
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb mb-0">
                                @yield('breadcrumbs')
                            </ol>
                        </nav>
                    @endif
                </div>
                @yield('page-actions')
            </div>
        @endif

        @yield('content')
    </div>

    <footer class="text-muted small text-center py-3">
        <span>&copy; {{ date('Y') }} SME Automation — Clarity & Control for Small Businesses</span>
    </footer>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
    const sidebar = document.querySelector('.sidebar');
    document.addEventListener('click', (e) => {
        if (e.target.closest('.btn-toggle-sidebar')) {
            e.preventDefault();
            sidebar?.classList.toggle('show');
        }
    });
</script>
@stack('scripts')
</body>
</html>
