<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'Sistem Manajemen Aset')</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Sora:wght@600;700;800&family=Inter:wght@400;500;600;700&family=IBM+Plex+Mono:wght@500;600&display=swap" rel="stylesheet">

    @stack('styles')

    <style>

        :root {
            --ink-900: #121316;
            --ink-850: #1b1c21;
            --ink-line: rgba(255, 255, 255, .08);
            --page-bg: #f4f4f5;
            --surface: #ffffff;
            --border: #e5e5e8;
            --text-ink: #17181c;
            --text-muted: #6e6f76;
            --text-faint: #a2a3aa;
            --mono-strong: #1a1b20;
            --mono-tint: #ececee;
            --radius: 12px;
        }

        * {
            box-sizing: border-box;
        }

        html,
        body {
            margin: 0;
            padding: 0;
            width: 100%;
            min-height: 100%;
            font-family: "Inter", "Source Sans Pro", Arial, sans-serif;
            background-color: var(--page-bg);
            color: var(--text-ink);
        }

        body {
            min-height: 100vh;
            overflow-x: hidden;
        }

        h1, h2, h3, h4, .brand a {
            font-family: "Sora", "Source Sans Pro", Arial, sans-serif;
        }

        /* =========================
           SIDEBAR
        ========================= */

        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: 250px;
            height: 100vh;
            background: linear-gradient(185deg, var(--ink-900) 0%, var(--ink-850) 100%);
            color: white;
            z-index: 1000;
            transition: all 0.3s ease;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
        }

        .sidebar::-webkit-scrollbar {
            width: 5px;
        }

        .sidebar::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, .12);
            border-radius: 10px;
        }

        /* =========================
           BRAND
        ========================= */

        .brand {
            height: 57px;
            display: flex;
            align-items: center;
            padding: 0 18px;
            background: transparent;
            border-bottom: 1px solid var(--ink-line);
            flex-shrink: 0;
        }

        .brand a {
            color: white;
            text-decoration: none;
            font-size: 15.5px;
            font-weight: 700;
            letter-spacing: .1px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .brand a .brand-mark {
            width: 32px;
            height: 32px;
            border-radius: 9px;
            background: linear-gradient(135deg, #2a2b31, #000);
            border: 1px solid var(--ink-line);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .brand a i {
            margin: 0;
            font-size: 14.5px;
        }

        /* =========================
           USER PANEL
        ========================= */

        .user-panel {
            padding: 14px 16px;
            margin: 10px 12px 4px;
            border: 1px solid var(--ink-line);
            border-radius: var(--radius);
            background: rgba(255, 255, 255, .04);
            display: flex;
            align-items: center;
            gap: 11px;
            flex-shrink: 0;
        }

        .user-panel .avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: linear-gradient(135deg, #3a3b42, #17181c);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            border: 1px solid var(--ink-line);
        }

        .user-panel .avatar i {
            font-size: 14px;
            color: #d6d7dc;
        }

        .user-panel .user-meta {
            line-height: 1.3;
        }

        .user-panel span.user-name {
            display: block;
            font-size: 13.5px;
            font-weight: 600;
        }

        .user-panel span.user-role {
            display: block;
            font-size: 11px;
            color: #8b8c94;
        }

        /* =========================
           SIDEBAR MENU
        ========================= */

        .sidebar-menu {
            list-style: none;
            padding: 6px 12px 16px;
            margin: 0;
            flex: 1;
        }

        .sidebar-menu li {
            margin-bottom: 2px;
        }

        .sidebar-menu a {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 12px;
            color: #bdbec6;
            text-decoration: none;
            border-radius: 10px;
            font-size: 13.6px;
            font-weight: 500;
            transition: background .15s ease, color .15s ease;
        }

        .sidebar-menu a:hover {
            background-color: rgba(255, 255, 255, .06);
            color: white;
        }

        .sidebar-menu a.active {
            background: linear-gradient(135deg, #2c2d33, #000);
            color: white;
            box-shadow: 0 6px 16px -8px rgba(0, 0, 0, .6);
            border: 1px solid var(--ink-line);
        }

        .sidebar-menu a.disabled {
            opacity: .38;
            pointer-events: none;
            cursor: not-allowed;
        }

        .sidebar-menu i {
            width: 18px;
            text-align: center;
            font-size: 15px;
        }

        /* =========================
           MENU TITLE
        ========================= */

        .menu-title {
            color: #6c6d75;
            font-size: 10.5px;
            font-weight: 600;
            letter-spacing: .09em;
            text-transform: uppercase;
            padding: 16px 12px 7px;
        }

        /* =========================
           NAVBAR
        ========================= */

        .main-navbar {
            position: fixed;
            top: 0;
            left: 250px;
            right: 0;
            height: 57px;
            background-color: rgba(255, 255, 255, .85);
            backdrop-filter: blur(8px);
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            padding: 0 22px;
            z-index: 999;
            transition: all 0.3s ease;
        }

        /* =========================
           SIDEBAR TOGGLE
        ========================= */

        .sidebar-toggle {
            border: 1px solid var(--border);
            background: var(--surface);
            width: 36px;
            height: 36px;
            border-radius: 10px;
            font-size: 15px;
            color: var(--text-muted);
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .sidebar-toggle:hover {
            color: var(--text-ink);
            border-color: #cfcfd4;
        }

        /* =========================
           NAVBAR RIGHT
        ========================= */

        .navbar-right {
            margin-left: auto;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .navbar-right a {
            color: var(--text-muted);
            text-decoration: none;
            font-size: 15px;
            width: 36px;
            height: 36px;
            border-radius: 10px;
            border: 1px solid var(--border);
            background: var(--surface);
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
        }

        .navbar-right a:hover {
            color: var(--text-ink);
            border-color: #cfcfd4;
        }

        .navbar-right a .dot {
            position: absolute;
            top: 6px;
            right: 7px;
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: #1a1b20;
            border: 1.5px solid var(--surface);
        }

        /* =========================
           MAIN CONTENT
        ========================= */

        .main-content {
            margin-left: 250px;
            padding-top: 57px;
            width: calc(100% - 250px);
            min-height: 100vh;
            transition: all 0.3s ease;
        }

        .content-wrapper {
            padding: 26px 28px;
        }

        /* =========================
           SIDEBAR COLLAPSE
        ========================= */

        body.sidebar-collapsed .sidebar {
            margin-left: -250px;
        }

        body.sidebar-collapsed .main-navbar {
            left: 0;
        }

        body.sidebar-collapsed .main-content {
            margin-left: 0;
            width: 100%;
        }

        /* =========================
           MOBILE
        ========================= */

        .sidebar-overlay {
            display: none;
        }

        @media (max-width: 768px) {

            .sidebar {
                margin-left: -250px;
            }

            .main-navbar {
                left: 0;
            }

            .main-content {
                margin-left: 0;
                width: 100%;
                min-height: 100vh;
            }

            body.sidebar-open .sidebar {
                margin-left: 0;
            }

            .content-wrapper {
                padding: 20px 15px;
            }

            .sidebar-overlay {
                display: none;
                position: fixed;
                inset: 0;
                background: rgba(0, 0, 0, 0.45);
                z-index: 999;
            }

            body.sidebar-open .sidebar-overlay {
                display: block;
            }
        }

    </style>

</head>

<body>

    <!-- =========================
         SIDEBAR
    ========================= -->

    <aside class="sidebar">

        <!-- BRAND -->

        <div class="brand">

            <a href="{{ url('/') }}">

                <span class="brand-mark">
                    <i class="fa-solid fa-boxes-stacked"></i>
                </span>

                Asset Management

            </a>

        </div>

        <!-- USER PANEL -->

        <div class="user-panel">

            <div class="avatar">

                <i class="fa-solid fa-user"></i>

            </div>

            <div class="user-meta">
                <span class="user-name">Administrator</span>
                <span class="user-role">Super admin</span>
            </div>

        </div>

        <!-- SIDEBAR MENU -->

        <ul class="sidebar-menu">

            <!-- MENU UTAMA -->

            <li class="menu-title">
                MENU UTAMA
            </li>

            <!-- DASHBOARD -->

            <li>

                <a href="{{ url('/') }}"
                    class="{{ request()->is('/') ? 'active' : '' }}">

                    <i class="fa-solid fa-gauge"></i>

                    <span>
                        Dashboard
                    </span>

                </a>

            </li>

            <!-- KATEGORI -->

            <li>

                <a href="{{ route('kategori.index') }}"
                    class="{{ request()->routeIs('kategori.*') ? 'active' : '' }}">

                    <i class="fa-solid fa-tags"></i>

                    <span>
                        Kategori
                    </span>

                </a>

            </li>

            <!-- DATA BARANG -->

            <li>

                <a href="{{ route('barang.index') }}"
                    class="{{ request()->routeIs('barang.*') ? 'active' : '' }}">

                    <i class="fa-solid fa-box"></i>

                    <span>
                        Data Barang
                    </span>

                </a>

            </li>

            <!-- RUANGAN -->

            <li>

                <a href="{{ route('ruangan.index') }}"
                    class="{{ request()->routeIs('ruangan.*') ? 'active' : '' }}">

                    <i class="fa-solid fa-building"></i>

                    <span>
                        Ruangan
                    </span>

                </a>

            </li>

            <!-- STOK -->

            <li>

                <a href="{{ route('stok.index') }}"
                    class="{{ request()->routeIs('stok.*') ? 'active' : '' }}">

                    <i class="fa-solid fa-boxes-stacked"></i>

                    <span>
                        Stok
                    </span>

                </a>

            </li>

            <!-- PENGATURAN -->

            <li class="menu-title">
                PENGATURAN
            </li>

            <!-- PENGGUNA -->

            <li>

                <a href="#" class="disabled" title="Route belum dibuat">

                    <i class="fa-solid fa-users"></i>

                    <span>
                        Pengguna
                    </span>

                </a>

            </li>

            <!-- PENGATURAN -->

            <li>

                <a href="#" class="disabled" title="Route belum dibuat">

                    <i class="fa-solid fa-gear"></i>

                    <span>
                        Pengaturan
                    </span>

                </a>

            </li>

        </ul>

    </aside>

    <!-- =========================
         OVERLAY MOBILE
    ========================= -->

    <div class="sidebar-overlay"></div>

    <!-- =========================
         NAVBAR
    ========================= -->

    <nav class="main-navbar">

        <!-- SIDEBAR TOGGLE -->

        <button
            class="sidebar-toggle"
            id="sidebarToggle">

            <i class="fa-solid fa-bars"></i>

        </button>

        <!-- NAVBAR RIGHT -->

        <div class="navbar-right">

            <!-- NOTIFICATION -->

            <a href="#" title="Notifikasi">

                <i class="fa-regular fa-bell"></i>
                <span class="dot"></span>

            </a>

            <!-- PROFILE -->

            <a href="#" title="Profil">

                <i class="fa-regular fa-user"></i>

            </a>

        </div>

    </nav>

    <!-- =========================
         MAIN CONTENT
    ========================= -->

    <div class="main-content">

        <div class="content-wrapper">

            @yield('content')

        </div>

    </div>

    <!-- =========================
         BOOTSTRAP JS
    ========================= -->

    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js">
    </script>

    <!-- =========================
         SIDEBAR SCRIPT
    ========================= -->

    <script>

        const sidebarToggle =
            document.getElementById('sidebarToggle');

        sidebarToggle.addEventListener(
            'click',
            function () {

                if (window.innerWidth <= 768) {

                    document.body.classList.toggle(
                        'sidebar-open'
                    );

                } else {

                    document.body.classList.toggle(
                        'sidebar-collapsed'
                    );

                }

            }
        );

        const overlay =
            document.querySelector('.sidebar-overlay');

        overlay.addEventListener(
            'click',
            function () {

                document.body.classList.remove(
                    'sidebar-open'
                );

            }
        );

    </script>

    @stack('scripts')

</body>

</html>