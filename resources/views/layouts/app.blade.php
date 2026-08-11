<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@hasSection('title')@yield('title') - @endif{{ config('app.name', 'Sipesat') }}</title>
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&family=Outfit:wght@800;900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        :root {
            --color-primary: #1F6E43;
            --color-primary-dark: #16502F;
            --color-primary-light: #E8F3EC;
            --color-accent: #7FB069;
            --color-info: #2E7DA3;
            --color-warning: #E8A33D;
            --color-danger: #C1443C;
            --color-dark: #1F2A24;
            --color-muted: #6B7280;
            --color-bg: #F6F7F5;
            --color-surface: #FFFFFF;
            --color-border: #E2E5E1;
            
            --font-display: 'Plus Jakarta Sans', sans-serif;
            --font-body: 'Plus Jakarta Sans', sans-serif;
            --font-mono: 'JetBrains Mono', monospace;
            
            --radius-md: 10px;
            --shadow-card: 0 2px 8px rgba(31, 42, 36, 0.06);
        }
        body { font-family: var(--font-body); background-color: var(--color-bg); color: var(--color-dark); }
        h1, h2, h3, h4, h5, h6, .navbar-brand { font-family: var(--font-display); font-weight: 700; }
        .font-mono { font-family: var(--font-mono); }
        .btn-primary { background-color: var(--color-primary); border-color: var(--color-primary); }
        .btn-primary:hover { background-color: var(--color-primary-dark); border-color: var(--color-primary-dark); }
        .text-primary { color: var(--color-primary) !important; }
        .bg-primary { background-color: var(--color-primary) !important; }
        .card { border: 1px solid var(--color-border); border-radius: var(--radius-md); box-shadow: var(--shadow-card); }
        
        .sidebar { background-color: var(--color-primary-dark); min-height: 100vh; color: white; padding-top: 1rem; }
        .sidebar a { color: rgba(255,255,255,0.8); text-decoration: none; padding: 12px 20px; display: block; border-left: 3px solid transparent; }
        .sidebar a:hover, .sidebar a.active { background-color: rgba(255,255,255,0.12); border-left-color: white; color: white; }
        .navbar-custom { background-color: white; border-bottom: 1px solid var(--color-border); }
    </style>
</head>
<body>
    @auth
        @if(auth()->user()->role->name === 'masyarakat')
            <nav class="navbar navbar-expand-lg navbar-custom">
                <div class="container">
                    <a class="navbar-brand text-primary" href="{{ route('masyarakat.dashboard') }}"><i class="fa-solid fa-leaf"></i> SIPESAT</a>
                    <div class="ms-auto d-flex align-items-center">
                        <span class="me-3">Halo, {{ auth()->user()->name }}</span>
                        <form action="{{ route('logout') }}" method="POST">@csrf <button class="btn btn-sm btn-outline-danger"><i class="fa-solid fa-right-from-bracket"></i> Keluar</button></form>
                    </div>
                </div>
            </nav>
            <main class="py-4">
                @yield('content')
            </main>
        @else
            <div class="d-flex">
                <div class="sidebar flex-shrink-0" style="width: 250px;">
                    <div class="px-3 mb-4">
                        <h4 class="m-0"><i class="fa-solid fa-leaf text-accent"></i> SIPESAT</h4>
                        <small class="text-white-50">Kab. Magetan</small>
                    </div>
                    @if(auth()->user()->role->name === 'admin')
                        <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"><i class="fa-solid fa-gauge-high me-2"></i> Dashboard</a>
                        <a href="{{ route('admin.laporan.index') }}" class="{{ request()->routeIs('admin.laporan.*') || request()->routeIs('admin.monitoring.*') ? 'active' : 'text-white-50' }}"><i class="fa-solid fa-clipboard-check me-2"></i> Manajemen Laporan</a>
                        <a href="{{ route('admin.statistik.index') }}" class="{{ request()->routeIs('admin.statistik.*') ? 'active' : 'text-white-50' }}"><i class="fa-solid fa-chart-column me-2"></i> Statistik</a>
                        
                        <div class="mt-3 mb-2 px-3"><small class="text-white-50 fw-bold">DATA MASTER</small></div>
                        <a href="{{ route('admin.kategori-sampah.index') }}" class="{{ request()->routeIs('admin.kategori-sampah.*') ? 'active' : 'text-white-50' }}"><i class="fa-solid fa-tags me-2"></i> Kategori Sampah</a>
                        <a href="{{ route('admin.wilayah.index') }}" class="{{ request()->routeIs('admin.wilayah.*') ? 'active' : 'text-white-50' }}"><i class="fa-solid fa-map-location-dot me-2"></i> Wilayah</a>
                        <a href="{{ route('admin.petugas.index') }}" class="{{ request()->routeIs('admin.petugas.*') ? 'active' : 'text-white-50' }}"><i class="fa-solid fa-users me-2"></i> Petugas</a>
                        
                        <div class="mt-3 mb-2 px-3"><small class="text-white-50 fw-bold">LAINNYA</small></div>
                        <a href="{{ route('admin.berita.index') }}" class="{{ request()->routeIs('admin.berita.*') ? 'active' : 'text-white-50' }}"><i class="fa-solid fa-newspaper me-2"></i> Berita & Edukasi</a>
                        <a href="{{ route('admin.activity-log.index') }}" class="{{ request()->routeIs('admin.activity-log.*') ? 'active' : 'text-white-50' }}"><i class="fa-solid fa-clock-rotate-left me-2"></i> Log Aktivitas</a>
                    @else
                        <a href="{{ route('petugas.dashboard') }}" class="{{ request()->routeIs('petugas.dashboard') ? 'active' : 'text-white-50' }}"><i class="fa-solid fa-gauge-high me-2"></i> Dashboard</a>
                        <a href="{{ route('petugas.tugas.index') }}" class="{{ request()->routeIs('petugas.tugas.*') ? 'active' : 'text-white-50' }}"><i class="fa-solid fa-clipboard-list me-2"></i> Tugas Saya</a>
                    @endif
                </div>
                <div class="flex-grow-1" style="min-width: 0;">
                    <nav class="navbar navbar-custom px-4 py-3 d-flex justify-content-between">
                        <h5 class="m-0">@yield('title')</h5>
                        <div class="d-flex align-items-center">
                            <span class="me-3">{{ auth()->user()->name }} <span class="badge bg-secondary ms-1">{{ auth()->user()->role->label }}</span></span>
                            <form action="{{ route('logout') }}" method="POST">@csrf <button class="btn btn-sm btn-outline-danger"><i class="fa-solid fa-right-from-bracket"></i> Keluar</button></form>
                        </div>
                    </nav>
                    <main class="p-4">
                        @yield('content')
                    </main>
                </div>
            </div>
        @endif
    @else
        @yield('content')
    @endauth
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>