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

    <!-- Google Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">

    @stack('styles')

    <style>

        /* =====================================================
           GLOBAL
        ===================================================== */

        :root {
            --primary: #2563eb;
            --primary-light: #eff6ff;
            --primary-soft: #dbeafe;
            --primary-hover: #1d4ed8;

            --bg: #f6f8fc;
            --white: #ffffff;

            --text: #14213d;
            --text-secondary: #64748b;
            --text-light: #94a3b8;

            --border: #e5eaf2;
            --border-blue: rgba(37, 99, 235, .35);

            --success: #16a34a;
            --danger: #dc2626;

            --sidebar-width: 250px;
            --navbar-height: 70px;

            --radius: 14px;

            --shadow:
                0 4px 20px rgba(15, 23, 42, .04);

            --shadow-hover:
                0 8px 30px rgba(37, 99, 235, .10);
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
        }

        body {
            font-family: "Inter", Arial, sans-serif;
            background: var(--bg);
            color: var(--text);
            overflow-x: hidden;
        }

        a {
            text-decoration: none;
        }


        /* =====================================================
           SIDEBAR
        ===================================================== */

        .sidebar {
            position: fixed;
            top: 0;
            left: 0;

            width: var(--sidebar-width);
            height: 100vh;

            background: #ffffff;

            border-right: 1px solid var(--border-blue);

            box-shadow:
                4px 0 25px rgba(37, 99, 235, .05);

            z-index: 1000;

            transition: all .3s ease;

            overflow-y: auto;

            display: flex;
            flex-direction: column;
        }

        .sidebar::after {
            content: "";

            position: absolute;

            top: 0;
            right: -1px;

            width: 1px;
            height: 100%;

            background: linear-gradient(
                to bottom,
                rgba(37, 99, 235, .8),
                rgba(59, 130, 246, .15),
                rgba(37, 99, 235, .55)
            );

            opacity: .7;
        }

        .sidebar::-webkit-scrollbar {
            width: 5px;
        }

        .sidebar::-webkit-scrollbar-thumb {
            background: #dbeafe;
            border-radius: 10px;
        }


        /* =====================================================
           BRAND
        ===================================================== */

        .brand {
            height: var(--navbar-height);

            display: flex;
            align-items: center;

            padding: 0 20px;

            border-bottom: 1px solid #edf1f7;

            flex-shrink: 0;
        }

        .brand a {
            display: flex;
            align-items: center;

            gap: 10px;

            color: var(--text);

            font-size: 19px;
            font-weight: 800;

            letter-spacing: -.5px;
        }

        .brand-mark {
            width: 35px;
            height: 35px;

            border-radius: 10px;

            display: flex;
            align-items: center;
            justify-content: center;

            color: white;

            background:
                linear-gradient(
                    135deg,
                    #2563eb,
                    #3b82f6
                );

            box-shadow:
                0 6px 15px rgba(37, 99, 235, .25);
        }

        .brand-mark i {
            font-size: 16px;
        }


        /* =====================================================
           USER PANEL
        ===================================================== */

        .user-panel {
            margin: 16px 15px 8px;

            padding: 11px;

            display: flex;
            align-items: center;

            gap: 10px;

            border-radius: 12px;

            background: #f8fafc;

            border: 1px solid #edf1f7;
        }

        .user-panel .avatar {
            width: 38px;
            height: 38px;

            border-radius: 50%;

            display: flex;
            align-items: center;
            justify-content: center;

            flex-shrink: 0;

            color: var(--primary);

            background: var(--primary-soft);
        }

        .user-panel .avatar i {
            font-size: 14px;
        }

        .user-meta {
            min-width: 0;
            flex: 1;

            line-height: 1.35;
        }

        .user-name {
            display: block;

            color: var(--text);

            font-size: 12.5px;
            font-weight: 700;

            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .user-role {
            display: block;

            margin-top: 2px;

            color: var(--text-secondary);

            font-size: 10.5px;

            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .logout-form {
            margin-left: auto;
        }

        .logout-btn {
            width: 30px;
            height: 30px;

            border: 0;
            border-radius: 8px;

            background: transparent;

            color: var(--text-light);

            display: flex;
            align-items: center;
            justify-content: center;

            cursor: pointer;

            transition: .2s;
        }

        .logout-btn:hover {
            background: #fef2f2;
            color: var(--danger);
        }


        /* =====================================================
           SIDEBAR MENU
        ===================================================== */

        .sidebar-menu {
            list-style: none;

            margin: 0;

            padding: 8px 14px 20px;

            flex: 1;
        }

        .sidebar-menu li {
            margin-bottom: 4px;
        }

        .menu-title {
            padding: 18px 12px 8px;

            color: #94a3b8;

            font-size: 10px;
            font-weight: 700;

            letter-spacing: .08em;

            text-transform: uppercase;
        }

        .sidebar-menu a {
            position: relative;

            display: flex;
            align-items: center;

            gap: 12px;

            padding: 11px 13px;

            color: #64748b;

            font-size: 13px;
            font-weight: 500;

            border-radius: 10px;

            transition:
                background .2s ease,
                color .2s ease,
                transform .2s ease;
        }

        .sidebar-menu a i {
            width: 18px;

            text-align: center;

            font-size: 14px;

            color: #64748b;

            transition: .2s;
        }

        .sidebar-menu a:hover {
            color: var(--primary);

            background: #f5f8ff;

            transform: translateX(2px);
        }

        .sidebar-menu a:hover i {
            color: var(--primary);
        }

        .sidebar-menu a.active {
            color: var(--primary);

            background:
                linear-gradient(
                    90deg,
                    #eff6ff,
                    #f4f7ff
                );

            font-weight: 600;

            box-shadow:
                inset 3px 0 0 var(--primary);
        }

        .sidebar-menu a.active i {
            color: var(--primary);
        }


        /* =====================================================
           NAVBAR
        ===================================================== */

        .main-navbar {
            position: fixed;

            top: 0;
            left: var(--sidebar-width);
            right: 0;

            height: var(--navbar-height);

            background: rgba(255, 255, 255, .96);

            backdrop-filter: blur(10px);

            border-bottom: 1px solid var(--border-blue);

            display: flex;
            align-items: center;

            padding: 0 25px;

            z-index: 999;

            transition: .3s;
        }

        .main-navbar::after {
            content: "";

            position: absolute;

            left: 0;
            right: 0;
            bottom: -1px;

            height: 1px;

            background: linear-gradient(
                to right,
                rgba(37, 99, 235, .8),
                rgba(59, 130, 246, .15),
                rgba(37, 99, 235, .55)
            );

            opacity: .7;
        }


        /* =====================================================
           TOGGLE BUTTON
        ===================================================== */

        .sidebar-toggle {
            width: 38px;
            height: 38px;

            border-radius: 10px;

            border: 1px solid var(--border);

            background: white;

            color: #475569;

            display: flex;
            align-items: center;
            justify-content: center;

            cursor: pointer;

            transition: .2s;
        }

        .sidebar-toggle:hover {
            color: var(--primary);

            background: var(--primary-light);

            border-color: #bfdbfe;
        }


        /* =====================================================
           SEARCH BAR
        ===================================================== */

        .navbar-search {
            width: 390px;

            margin-left: 20px;

            position: relative;
        }

        .navbar-search i {
            position: absolute;

            left: 14px;
            top: 50%;

            transform: translateY(-50%);

            color: #94a3b8;

            font-size: 14px;
        }

        .navbar-search input {
            width: 100%;

            height: 40px;

            border: 1px solid var(--border);

            border-radius: 10px;

            outline: none;

            padding: 0 15px 0 40px;

            font-size: 12px;

            color: var(--text);

            background: #fbfcfe;

            transition: .2s;
        }

        .navbar-search input:focus {
            background: white;

            border-color: #93c5fd;

            box-shadow:
                0 0 0 3px rgba(37, 99, 235, .08);
        }


        /* =====================================================
           NAVBAR RIGHT
        ===================================================== */

        .navbar-right {
            margin-left: auto;

            display: flex;
            align-items: center;

            gap: 20px;
        }

        .notification {
            position: relative;

            width: 36px;
            height: 36px;

            display: flex;
            align-items: center;
            justify-content: center;

            color: #475569;

            border-radius: 10px;

            transition: .2s;
        }

        .notification:hover {
            background: var(--primary-light);
            color: var(--primary);
        }

        .notification .badge {
            position: absolute;

            top: 3px;
            right: 2px;

            min-width: 15px;
            height: 15px;

            padding: 0;

            border-radius: 50%;

            background: var(--primary);

            color: white;

            font-size: 8px;

            display: flex;
            align-items: center;
            justify-content: center;
        }


        /* =====================================================
           NAVBAR PROFILE
        ===================================================== */

        .navbar-profile {
            display: flex;
            align-items: center;

            gap: 9px;

            cursor: pointer;
        }

        .navbar-profile .profile-avatar {
            width: 38px;
            height: 38px;

            border-radius: 50%;

            background: var(--primary-soft);

            display: flex;
            align-items: center;
            justify-content: center;

            color: var(--primary);
        }

        .profile-info {
            line-height: 1.25;
        }

        .profile-name {
            display: block;

            font-size: 12px;
            font-weight: 700;

            color: var(--text);
        }

        .profile-role {
            display: block;

            font-size: 10px;

            color: var(--text-secondary);
        }

        .profile-arrow {
            margin-left: 3px;

            color: #94a3b8;

            font-size: 10px;
        }


        /* =====================================================
           MAIN CONTENT
        ===================================================== */

        .main-content {
            margin-left: var(--sidebar-width);

            padding-top: var(--navbar-height);

            width: calc(100% - var(--sidebar-width));

            min-height: 100vh;

            transition: .3s;
        }

        .content-wrapper {
            padding: 28px;
        }


        /* =====================================================
           PAGE HEADER
        ===================================================== */

        .page-header {
            margin-bottom: 25px;
        }

        .page-header h1 {
            margin: 0;

            font-size: 25px;
            font-weight: 700;

            letter-spacing: -.5px;

            color: var(--text);
        }

        .page-header p {
            margin: 6px 0 0;

            color: var(--text-secondary);

            font-size: 13px;
        }


        /* =====================================================
           CARD
        ===================================================== */

        .card {
            border: 1px solid var(--border);

            background: white;

            border-radius: var(--radius);

            box-shadow: var(--shadow);

            color: var(--text);

            transition:
                transform .2s ease,
                box-shadow .2s ease;
        }

        .card:hover {
            box-shadow: var(--shadow-hover);
        }

        .card-header {
            background: white;

            border-bottom: 1px solid #edf1f7;

            padding: 17px 20px;

            font-weight: 700;

            color: var(--text);
        }

        .card-body {
            padding: 20px;
        }


        /* =====================================================
           BUTTON PRIMARY
        ===================================================== */

        .btn-primary {
            background: var(--primary);

            border-color: var(--primary);

            color: white;

            font-weight: 600;

            border-radius: 9px;

            box-shadow:
                0 4px 10px rgba(37, 99, 235, .15);
        }

        .btn-primary:hover,
        .btn-primary:focus,
        .btn-primary:active {
            background: var(--primary-hover) !important;

            border-color: var(--primary-hover) !important;

            color: white !important;
        }


        /* =====================================================
           SECONDARY BUTTON
        ===================================================== */

        .btn-secondary {
            background: white;

            border: 1px solid var(--border);

            color: #475569;

            border-radius: 9px;
        }

        .btn-secondary:hover {
            background: #f8fafc;

            border-color: #cbd5e1;

            color: var(--text);
        }


        /* =====================================================
           FORM
        ===================================================== */

        .form-control,
        .form-select {
            background: white;

            border: 1px solid #dfe5ed;

            color: var(--text);

            border-radius: 9px;

            font-size: 13px;

            min-height: 40px;
        }

        .form-control:focus,
        .form-select:focus {
            background: white;

            color: var(--text);

            border-color: #93c5fd;

            box-shadow:
                0 0 0 3px rgba(37, 99, 235, .08);
        }

        .form-control::placeholder {
            color: #a8b1bd;
        }

        .form-label {
            color: #475569;

            font-size: 12px;

            font-weight: 600;
        }


        /* =====================================================
           TABLE
        ===================================================== */

        .table {
            color: var(--text);

            --bs-table-bg: transparent;

            --bs-table-striped-bg: #fafbfc;

            --bs-table-hover-bg: #f7faff;

            --bs-table-border-color: #edf1f5;

            font-size: 13px;
        }

        .table thead th {
            background: #f8fafc;

            color: #64748b;

            font-size: 11px;

            font-weight: 700;

            text-transform: uppercase;

            letter-spacing: .04em;

            border-bottom: 1px solid #e8edf3;

            padding: 13px;
        }

        .table tbody td {
            padding: 13px;

            vertical-align: middle;

            color: #475569;
        }

        .table tbody tr:hover {
            background: #f7faff;
        }


        /* =====================================================
           BADGES
        ===================================================== */

        .badge {
            border-radius: 20px;

            padding: 5px 9px;

            font-size: 10px;

            font-weight: 600;
        }

        .badge.bg-success {
            background: #ecfdf3 !important;
            color: #16a34a !important;
        }

        .badge.bg-warning {
            background: #fffbeb !important;
            color: #d97706 !important;
        }

        .badge.bg-danger {
            background: #fef2f2 !important;
            color: #dc2626 !important;
        }

        .badge.bg-primary {
            background: var(--primary-light) !important;
            color: var(--primary) !important;
        }

        .badge.bg-secondary {
            background: #f1f5f9 !important;
            color: #64748b !important;
        }


        /* =====================================================
           ALERT
        ===================================================== */

        .alert-success {
            background: #ecfdf5;

            border: 1px solid #bbf7d0;

            color: #15803d;

            border-radius: 10px;
        }


        /* =====================================================
           MODAL
        ===================================================== */

        .modal-content {
            background: white;

            border: 1px solid var(--border);

            border-radius: 15px;

            box-shadow:
                0 20px 50px rgba(15, 23, 42, .15);

            color: var(--text);
        }

        .modal-header,
        .modal-footer {
            border-color: #edf1f7;
        }


        /* =====================================================
           SIDEBAR COLLAPSE
        ===================================================== */

        body.sidebar-collapsed .sidebar {
            margin-left: calc(var(--sidebar-width) * -1);
        }

        body.sidebar-collapsed .main-navbar {
            left: 0;
        }

        body.sidebar-collapsed .main-content {
            margin-left: 0;

            width: 100%;
        }


        /* =====================================================
           MOBILE
        ===================================================== */

        .sidebar-overlay {
            display: none;
        }

        @media (max-width: 992px) {

            .navbar-search {
                width: 280px;
            }

        }

        @media (max-width: 768px) {

            .sidebar {
                margin-left: calc(var(--sidebar-width) * -1);
            }

            .main-navbar {
                left: 0;

                padding: 0 15px;
            }

            .main-content {
                margin-left: 0;

                width: 100%;
            }

            .content-wrapper {
                padding: 20px 15px;
            }

            .navbar-search {
                display: none;
            }

            .profile-info,
            .profile-arrow {
                display: none;
            }

            body.sidebar-open .sidebar {
                margin-left: 0;
            }

            .sidebar-overlay {
                display: none;

                position: fixed;

                inset: 0;

                background: rgba(15, 23, 42, .35);

                backdrop-filter: blur(2px);

                z-index: 999;
            }

            body.sidebar-open .sidebar-overlay {
                display: block;
            }

        }

        /* Fix untuk Chart container agar tidak tumpang tindih */
        .chart-container {
            position: relative;
            height: 240px;
            width: 100%;
        }

    </style>

</head>


<body>


    <!-- =====================================================
          SIDEBAR
    ===================================================== -->

    <aside class="sidebar">


        <!-- BRAND -->

        <div class="brand">

            <a href="{{ url('/') }}">

                <span class="brand-mark">
                    <i class="fa-solid fa-boxes-stacked"></i>
                </span>

                <span>Asset Management</span>

            </a>

        </div>


        <!-- MENU -->

        <ul class="sidebar-menu">


            <!-- MENU UTAMA -->

            <li class="menu-title">
                Menu Utama
            </li>


            <!-- DASHBOARD -->

            <li>

                <a
                    href="{{ url('/') }}"
                    class="{{ request()->is('/') ? 'active' : '' }}">

                    <i class="fa-solid fa-gauge-high"></i>

                    <span>Dashboard</span>

                </a>

            </li>


            <!-- KATEGORI -->

            <li>

                <a
                    href="{{ route('kategori.index') }}"
                    class="{{ request()->routeIs('kategori.*') ? 'active' : '' }}">

                    <i class="fa-solid fa-tags"></i>

                    <span>Kategori</span>

                </a>

            </li>


            <!-- DATA BARANG -->

            <li>

                <a
                    href="{{ route('barang.index') }}"
                    class="{{ request()->routeIs('barang.*') ? 'active' : '' }}">

                    <i class="fa-solid fa-box"></i>

                    <span>Data Barang</span>

                </a>

            </li>


            <!-- RUANGAN -->

            <li>

                <a
                    href="{{ route('ruangan.index') }}"
                    class="{{ request()->routeIs('ruangan.*') ? 'active' : '' }}">

                    <i class="fa-solid fa-building"></i>

                    <span>Ruangan</span>

                </a>

            </li>


            <!-- STOK -->

            <li>

                <a
                    href="{{ route('stok.index') }}"
                    class="{{ request()->routeIs('stok.*') ? 'active' : '' }}">

                    <i class="fa-solid fa-boxes-stacked"></i>

                    <span>Stok</span>

                </a>

            </li>


        </ul>

    </aside>


    <!-- =====================================================
          MOBILE OVERLAY
    ===================================================== -->

    <div class="sidebar-overlay"></div>


    <!-- =====================================================
          NAVBAR
    ===================================================== -->

    <nav class="main-navbar">


        <!-- TOGGLE -->

        <button
            class="sidebar-toggle"
            id="sidebarToggle">

            <i class="fa-solid fa-bars"></i>

        </button>


        <!-- NAVBAR RIGHT -->

        <div class="navbar-right">


            <!-- PROFILE -->

            <div class="navbar-profile dropdown">

                <div class="d-flex align-items-center gap-2" data-bs-toggle="dropdown" aria-expanded="false" style="cursor: pointer;">

                    <div class="profile-avatar">

                        <i class="fa-solid fa-user"></i>

                    </div>

                    <div class="profile-info">

                        <span class="profile-name">
                            {{ auth()->user()->name ?? 'Admin' }}
                        </span>

                        <span class="profile-role">
                            Super Admin
                        </span>

                    </div>

                    <i class="fa-solid fa-chevron-down profile-arrow"></i>

                </div>

                <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 mt-2" style="border-radius: 10px;">

                    <li>
                        <span class="dropdown-item-text small text-muted">
                            {{ auth()->user()->email ?? '-' }}
                        </span>
                    </li>

                    <li><hr class="dropdown-divider"></li>

                    <li>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="dropdown-item text-danger">
                                <i class="fa-solid fa-right-from-bracket me-2"></i>Keluar
                            </button>
                        </form>
                    </li>

                </ul>

            </div>


        </div>

    </nav>


    <!-- =====================================================
          MAIN CONTENT
    ===================================================== -->

    <main class="main-content">

        <div class="content-wrapper">

            @yield('content')

        </div>

    </main>


    <!-- =====================================================
          BOOTSTRAP JS
    ===================================================== -->

    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js">
    </script>


    <!-- =====================================================
          SIDEBAR SCRIPT
    ===================================================== -->

    <script>

        const sidebarToggle =
            document.getElementById('sidebarToggle');

        const overlay =
            document.querySelector('.sidebar-overlay');


        sidebarToggle.addEventListener('click', function () {

            if (window.innerWidth <= 768) {

                document.body.classList.toggle(
                    'sidebar-open'
                );

            } else {

                document.body.classList.toggle(
                    'sidebar-collapsed'
                );

            }

        });


        overlay.addEventListener('click', function () {

            document.body.classList.remove(
                'sidebar-open'
            );

        });


    </script>


    @stack('scripts')

</body>

</html>