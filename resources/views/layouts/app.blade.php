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

    <style>

        * {
            box-sizing: border-box;
        }

        html,
        body {
            margin: 0;
            padding: 0;
            width: 100%;
            min-height: 100%;
            font-family: "Source Sans Pro", Arial, sans-serif;
            background-color: #f4f6f9;
        }

        body {
            min-height: 100vh;
            overflow-x: hidden;
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

            background-color: #343a40;
            color: white;

            z-index: 1000;

            transition: all 0.3s ease;

            overflow-y: auto;
        }


        /* BRAND */

        .brand {
            height: 57px;

            display: flex;
            align-items: center;

            padding: 0 20px;

            background-color: #343a40;

            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .brand a {
            color: white;

            text-decoration: none;

            font-size: 19px;

            font-weight: 600;
        }

        .brand a i {
            margin-right: 8px;
        }


        /* =========================
           USER PANEL
        ========================= */

        .user-panel {
            padding: 15px;

            border-bottom: 1px solid rgba(255, 255, 255, 0.1);

            display: flex;
            align-items: center;

            gap: 10px;
        }

        .user-panel .avatar {
            width: 35px;
            height: 35px;

            border-radius: 50%;

            background-color: #6c757d;

            display: flex;
            align-items: center;
            justify-content: center;
        }

        .user-panel span {
            font-size: 14px;
        }


        /* =========================
           SIDEBAR MENU
        ========================= */

        .sidebar-menu {
            list-style: none;

            padding: 10px 8px;

            margin: 0;
        }

        .sidebar-menu li {
            margin-bottom: 4px;
        }

        .sidebar-menu a {
            display: flex;

            align-items: center;

            gap: 12px;

            padding: 11px 14px;

            color: #c2c7d0;

            text-decoration: none;

            border-radius: 5px;

            font-size: 14px;

            transition: 0.2s;
        }

        .sidebar-menu a:hover,
        .sidebar-menu a.active {
            background-color: #007bff;

            color: white;
        }

        .sidebar-menu i {
            width: 20px;

            text-align: center;
        }


        /* MENU TITLE */

        .menu-title {
            color: #8f9296;

            font-size: 11px;

            text-transform: uppercase;

            padding: 15px 14px 7px;
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

            background-color: white;

            border-bottom: 1px solid #dee2e6;

            display: flex;

            align-items: center;

            padding: 0 20px;

            z-index: 999;

            transition: all 0.3s ease;
        }


        /* TOGGLE */

        .sidebar-toggle {
            border: none;

            background: transparent;

            font-size: 20px;

            color: #495057;

            cursor: pointer;

            padding: 5px 10px;
        }

        .sidebar-toggle:hover {
            color: #007bff;
        }


        /* NAVBAR RIGHT */

        .navbar-right {
            margin-left: auto;

            display: flex;

            align-items: center;

            gap: 20px;
        }

        .navbar-right a {
            color: #495057;

            text-decoration: none;

            font-size: 17px;
        }

        .navbar-right a:hover {
            color: #007bff;
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


        /* CONTENT */

        .content-wrapper {
            padding: 25px 25px;
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

                background: rgba(0, 0, 0, 0.4);

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

            <a href="#">

                <i class="fa-solid fa-boxes-stacked"></i>

                Asset Management

            </a>

        </div>


        <!-- USER PANEL -->

        <div class="user-panel">

            <div class="avatar">

                <i class="fa-solid fa-user"></i>

            </div>

            <span>
                Administrator
            </span>

        </div>


        <!-- SIDEBAR MENU -->

        <ul class="sidebar-menu">


            <!-- MENU UTAMA -->

            <li class="menu-title">
                MENU UTAMA
            </li>


            <!-- DASHBOARD -->

            <li>

                <a href="#"
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

                <a href="#">

                    <i class="fa-solid fa-box"></i>

                    <span>
                        Data Barang
                    </span>

                </a>

            </li>


            <!-- RUANGAN -->

            <li>

                <a href="#">

                    <i class="fa-solid fa-building"></i>

                    <span>
                        Ruangan
                    </span>

                </a>

            </li>


            <!-- LAPORAN -->

            <li>

                <a href="#">

                    <i class="fa-solid fa-file-lines"></i>

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

                <a href="#">

                    <i class="fa-solid fa-users"></i>

                    <span>
                        Pengguna
                    </span>

                </a>

            </li>


            <!-- PENGATURAN -->

            <li>

                <a href="#">

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