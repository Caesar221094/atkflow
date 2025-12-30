<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'ATKflow')</title>

    {{-- Sneat core & theme CSS (disalin ke public/sneat-1.0.0) --}}
    <link rel="stylesheet" href="{{ asset('sneat-1.0.0/assets/vendor/css/core.css') }}">
    <link rel="stylesheet" href="{{ asset('sneat-1.0.0/assets/vendor/css/theme-default.css') }}">
    <link rel="stylesheet" href="{{ asset('sneat-1.0.0/assets/css/demo.css') }}">

    <style>
        /* Kustom kecil di atas layout Sneat */

        body {
            background: linear-gradient(135deg, #f4f5ff 0%, #f7fbff 60%, #fef9ff 100%);
        }

        .layout-navbar.bg-navbar-theme {
            background: #ffffff;
            box-shadow: 0 4px 18px rgba(15, 23, 42, 0.04);
        }

        #layout-menu.menu-vertical.menu.bg-menu-theme {
            background: linear-gradient(180deg, #f3f4ff 0%, #ffffff 45%, #fdf7ff 100%);
        }

        .menu-inner > .menu-item.active > .menu-link {
            background: rgba(105, 108, 255, 0.12);
            box-shadow: 0 6px 16px rgba(105, 108, 255, 0.18);
        }

        .atk-page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
        }

        .atk-page-title {
            margin: 0;
            font-size: 1.1rem;
            font-weight: 600;
        }

        .atk-breadcrumb {
            font-size: 0.8rem;
            color: #9ea3b5;
        }

        .atk-stat-card {
            border-radius: 0.9rem;
            box-shadow: 0 10px 30px rgba(15, 23, 42, 0.05);
        }

        .atk-stat-label {
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: .04em;
            color: #9ea3b5;
        }

        .atk-stat-value {
            font-size: 1.3rem;
            font-weight: 600;
        }
    </style>

    {{-- Tempat menambahkan CSS Sneat jika diperlukan --}}
    @stack('styles')
<!-- Layout wrapper ala Sneat -->
</head>
<body>
<div class="layout-wrapper layout-content-navbar">
    <div class="layout-container">
        <!-- Sidebar -->
        <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
            <div class="app-brand demo d-flex align-items-center">
                <span class="app-brand-logo demo d-inline-flex align-items-center justify-content-center rounded-circle bg-primary text-white" style="width:36px; height:36px;">
                    <span class="fw-bold">A</span>
                </span>
                <span class="app-brand-text demo ms-2 text-capitalize">ATKflow</span>
            </div>

            <ul class="menu-inner py-1">
                <li class="menu-header small text-uppercase">
                    <span class="menu-header-text">Master</span>
                </li>
                <li class="menu-item {{ request()->routeIs('products.*') ? 'active' : '' }}">
                    <a href="{{ route('products.index') }}" class="menu-link">
                        <i class="menu-icon tf-icons bi bi-box"></i>
                        <div>Produk ATK</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->routeIs('categories.*') ? 'active' : '' }}">
                    <a href="{{ route('categories.index') }}" class="menu-link">
                        <i class="menu-icon tf-icons bi bi-folder"></i>
                        <div>Kategori ATK</div>
                    </a>
                </li>

                <li class="menu-header small text-uppercase mt-3">
                    <span class="menu-header-text">Transaksi</span>
                </li>
                <li class="menu-item {{ request()->routeIs('orders.*') ? 'active' : '' }}">
                    <a href="{{ route('orders.index') }}" class="menu-link">
                        <i class="menu-icon tf-icons bi bi-cart"></i>
                        <div>Permintaan ATK</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->routeIs('transactions.stock-in.*') ? 'active' : '' }}">
                    <a href="{{ route('transactions.stock-in.index') }}" class="menu-link">
                        <i class="menu-icon tf-icons bi bi-arrow-down-circle"></i>
                        <div>Penerimaan ATK</div>
                    </a>
                </li>

                <li class="menu-header small text-uppercase mt-3">
                    <span class="menu-header-text">Laporan</span>
                </li>
                <li class="menu-item {{ request()->routeIs('reports.stock-movements.*') ? 'active' : '' }}">
                    <a href="{{ route('reports.stock-movements.index') }}" class="menu-link">
                        <i class="menu-icon tf-icons bi bi-graph-up"></i>
                        <div>Mutasi Stok</div>
                    </a>
                </li>
            </ul>
        </aside>

        <!-- Layout page -->
        <div class="layout-page">
            <!-- Navbar -->
            <nav class="layout-navbar navbar navbar-expand-xl align-items-center bg-navbar-theme" id="layout-navbar">
                <div class="container-fluid">
                    <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
                        <span class="fw-semibold">@yield('topbar_title', 'Dashboard ATKflow')</span>
                        <ul class="navbar-nav flex-row align-items-center ms-auto">
                            <li class="nav-item d-none d-md-block me-3 text-muted small">
                                {{ now()->format('d M Y') }}
                            </li>
                            <li class="nav-item">
                                <span class="avatar avatar-online">
                                    <span class="avatar-initial rounded-circle bg-primary text-white">A</span>
                                </span>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>

            <!-- Content wrapper -->
            <div class="content-wrapper">
                <div class="container-xxl flex-grow-1 container-p-y">
                    <div class="atk-page-header mb-3">
                        <div>
                            <h1 class="atk-page-title">@yield('title', 'ATKflow')</h1>
                            <div class="atk-breadcrumb">@yield('breadcrumb')</div>
                        </div>
                        <div>
                            @yield('page_actions')
                        </div>
                    </div>

                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    @yield('content')
                </div>
            </div>
        </div>
    </div>
</div>

{{-- JS Sneat dan dependensi (diambil dari public/sneat-1.0.0) --}}
<script src="{{ asset('sneat-1.0.0/assets/vendor/libs/jquery/jquery.js') }}"></script>
<script src="{{ asset('sneat-1.0.0/assets/vendor/libs/popper/popper.js') }}"></script>
<script src="{{ asset('sneat-1.0.0/assets/vendor/js/bootstrap.js') }}"></script>
<script src="{{ asset('sneat-1.0.0/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
<script src="{{ asset('sneat-1.0.0/assets/vendor/js/menu.js') }}"></script>
<script src="{{ asset('sneat-1.0.0/assets/js/main.js') }}"></script>
{{-- Optional: dashboard contoh Sneat --}}
<script src="{{ asset('sneat-1.0.0/assets/js/dashboards-analytics.js') }}"></script>

@stack('scripts')
</body>
</html>
