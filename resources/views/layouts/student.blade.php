<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Student Dashboard</title>

    <link rel="stylesheet" href="{{ asset('vendor/adminlte/dist/css/adminlte.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Roboto', sans-serif;
        }

        .brand-link {
            white-space: normal;
        }

        .main-header .navbar-nav .nav-item img {
            object-fit: cover;
        }

        @media (max-width: 991.98px) {
            .content-wrapper,
            .main-footer,
            .main-header {
                margin-left: 0 !important;
            }
        }
    </style>
</head>
<body class="hold-transition sidebar-mini layout-fixed">

@php
    $student = Auth::guard('student')->user();

    $accountMenuOpen = request()->routeIs(
        'student.account.view',
        'student.account.edit',
        'student.account.deactivate.form'
    );
@endphp

<div class="wrapper">

    <!-- NAVBAR -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" id="menu-toggle" href="#">
                    <i class="fas fa-bars"></i>
                </a>
            </li>
        </ul>

        <ul class="navbar-nav ml-auto">
            <li class="nav-item d-flex align-items-center pr-3">
                <img
                    src="https://ui-avatars.com/api/?name={{ urlencode($student->name) }}"
                    alt="Student Avatar"
                    class="img-circle elevation-2 mr-2"
                    width="35"
                    height="35"
                >
                <span class="d-none d-sm-inline">{{ $student->name }}</span>
            </li>
        </ul>
    </nav>

    <!-- SIDEBAR -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <a href="#" class="brand-link text-center">
            <span class="brand-text font-weight-light">Student Dashboard</span>
        </a>

        <div class="sidebar">
            <nav class="mt-2">
                <ul
                    class="nav nav-pills nav-sidebar flex-column"
                    data-widget="treeview"
                    role="menu"
                    data-accordion="false"
                >
                    <!-- Dashboard -->
                    <li class="nav-item">
                        <a href="{{ route('student.dashboard') }}"
                           class="nav-link {{ request()->routeIs('student.dashboard') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-home"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>

                    <!-- Manage My Account -->
                    <li class="nav-item {{ $accountMenuOpen ? 'menu-open' : '' }}" id="account-nav-item">
                        <a href="#" class="nav-link {{ $accountMenuOpen ? 'active' : '' }}" id="account-menu-toggle">
                            <i class="nav-icon fas fa-user-cog"></i>
                            <p>
                                Manage My Account
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>

                        <ul class="nav nav-treeview" id="account-submenu" style="{{ $accountMenuOpen ? 'display: block;' : 'display: none;' }}">
                            <li class="nav-item">
                                <a href="{{ route('student.account.view') }}"
                                   class="nav-link {{ request()->routeIs('student.account.view') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>View Profile</p>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="{{ route('student.account.edit') }}"
                                   class="nav-link {{ request()->routeIs('student.account.edit') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Update Profile</p>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="{{ route('student.account.deactivate.form') }}"
                                   class="nav-link {{ request()->routeIs('student.account.deactivate.form') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Deactivate</p>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <!-- Logout -->
                    <li class="nav-item">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="nav-link btn btn-link text-left w-100 text-white">
                                <i class="nav-icon fas fa-sign-out-alt"></i>
                                <p class="d-inline">Logout</p>
                            </button>
                        </form>
                    </li>
                </ul>
            </nav>
        </div>
    </aside>

    <!-- PAGE CONTENT -->
    <div class="content-wrapper">
        <section class="content pt-3">
            <div class="container-fluid">
                @yield('content')
            </div>
        </section>
    </div>

    <!-- FOOTER -->
    <footer class="main-footer text-center">
        <small>© Web-Based UniFAST Information Management System</small>
    </footer>
</div>

<!-- JS -->
<script src="{{ asset('vendor/adminlte/plugins/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('vendor/adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('vendor/adminlte/dist/js/adminlte.min.js') }}"></script>

<script>
    document.getElementById("menu-toggle").addEventListener("click", function(e) {
        e.preventDefault();

        if (window.innerWidth < 992) {
            document.body.classList.toggle("sidebar-open");
        } else {
            document.body.classList.toggle("sidebar-collapse");
        }
    });
</script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        function closeSidebarMobile() {
            if (window.innerWidth < 992) {
                document.body.classList.remove("sidebar-open");
            }
        }

        const content = document.querySelector(".content-wrapper");

        if (content) {
            content.addEventListener("click", closeSidebarMobile);
        }

        document.addEventListener("click", function(e) {
            if (e.target.classList.contains("sidebar-overlay")) {
                closeSidebarMobile();
            }
        });
    });
</script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const accountMenuToggle = document.getElementById("account-menu-toggle");
        const accountNavItem = document.getElementById("account-nav-item");
        const accountSubmenu = document.getElementById("account-submenu");

        if (accountMenuToggle && accountNavItem && accountSubmenu) {
            accountMenuToggle.addEventListener("click", function (e) {
                e.preventDefault();

                accountNavItem.classList.toggle("menu-open");
                this.classList.toggle("active");

                if (accountNavItem.classList.contains("menu-open")) {
                    accountSubmenu.style.display = "block";
                } else {
                    accountSubmenu.style.display = "none";
                }
            });
        }
    });
</script>

</body>
</html>