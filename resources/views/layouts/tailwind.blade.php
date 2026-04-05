<!doctype html>
<html class="light" lang="en">
<head>
  <meta charset="utf-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>@yield('title', 'The Kudiflow')</title>
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <!-- Tailwind + Plugins -->
  <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&family=Inter:wght@400;500;600&display=swap" rel="stylesheet"/>
  <!-- Material Symbols -->
  <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>

  <script id="tailwind-config">
    tailwind.config = {
      darkMode: "class",
      theme: {
        extend: {
          colors: {
            "outline": "#6e7a70",
            "on-primary": "#ffffff",
            "secondary-fixed-dim": "#aec7f6",
            "on-tertiary-fixed": "#221b00",
            "inverse-on-surface": "#edf2eb",
            "surface-variant": "#dee4dd",
            "on-secondary-container": "#3f5881",
            "tertiary-container": "#c9a900",
            "primary": "#006b3f",
            "surface-dim": "#d6dcd4",
            "surface-bright": "#f5fbf3",
            "secondary": "#465f88",
            "inverse-primary": "#70db9d",
            "surface-container": "#eaefe8",
            "primary-container": "#008751",
            "on-surface": "#171d19",
            "primary-fixed": "#8df8b7",
            "surface-container-lowest": "#ffffff",
            "on-secondary-fixed": "#001b3d",
            "on-primary-fixed-variant": "#00522f",
            "on-tertiary-container": "#4c3f00",
            "secondary-container": "#b6d0ff",
            "surface-container-highest": "#dee4dd",
            "surface-tint": "#006d40",
            "surface-container-low": "#f0f5ee",
            "on-primary-fixed": "#002110",
            "surface": "#f5fbf3",
            "tertiary-fixed-dim": "#e9c400",
            "primary-fixed-dim": "#70db9d",
            "on-surface-variant": "#3e4a41",
            "on-error": "#ffffff",
            "on-tertiary": "#ffffff",
            "on-error-container": "#93000a",
            "secondary-fixed": "#d6e3ff",
            "on-secondary-fixed-variant": "#2d476f",
            "on-tertiary-fixed-variant": "#544600",
            "surface-container-high": "#e4eae2",
            "tertiary-fixed": "#ffe16d",
            "error": "#ba1a1a",
            "error-container": "#ffdad6",
            "background": "#f5fbf3",
            "on-background": "#171d19",
            "outline-variant": "#bdcabe",
            "on-secondary": "#ffffff",
            "on-primary-container": "#fdfff9",
            "inverse-surface": "#2c322d",
            "tertiary": "#705d00"
          },
          fontFamily: {
            "headline": ["Manrope", "ui-sans-serif", "system-ui"],
            "body": ["Inter", "ui-sans-serif", "system-ui"],
            "label": ["Inter", "ui-sans-serif", "system-ui"]
          },
          borderRadius: {"DEFAULT": "0.125rem", "lg": "0.25rem", "xl": "0.5rem", "full": "0.75rem"},
        },
      },
    }
  </script>
  <style>
    .material-symbols-outlined {
      font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
    }
    body { font-family: 'Inter', ui-sans-serif, system-ui, sans-serif; }
    h1,h2,h3,.display-lg { font-family: 'Manrope', ui-sans-serif, system-ui, sans-serif; }
    .profit-gradient { background: linear-gradient(135deg, #006b3f 0%, #008751 100%); }
  </style>

  @stack('styles')
</head>
<body class="bg-surface text-on-surface min-h-screen antialiased">
  {{-- Sidebar (shown unless page hides it) --}}
  @if (!View::hasSection('no-sidebar'))
    @include('partials.sidebar')
  @endif

  {{-- Content wrapper shifts if sidebar is visible --}}
  <div class="@if (!View::hasSection('no-sidebar')) ml-64 @endif flex flex-col min-h-screen">
    @include('partials.topbar')

    <main class="@yield('main_classes', 'p-8 max-w-7xl mx-auto space-y-8 w-full')">
      @yield('content')
    </main>
  </div>
   @include('partials.notifications-modal')

  @stack('scripts')
</body>
</html>