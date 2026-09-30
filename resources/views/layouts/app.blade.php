<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice & Budget Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        *, body { font-family: 'Inter', sans-serif; }
        body { background-color: #f1f5f9; padding-top: 64px; }

        /* ── Navbar ── */
        .top-navbar {
            height: 64px;
            background: linear-gradient(135deg, #0f172a 0%, #1e3a5f 100%);
            border-bottom: 1px solid rgba(255,255,255,0.08);
            box-shadow: 0 2px 16px rgba(0,0,0,0.3);
        }
        .brand-icon {
            width: 34px; height: 34px;
            background: linear-gradient(135deg, #3b82f6, #8b5cf6);
            border-radius: 9px;
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
        }
        .nav-user-pill {
            background: rgba(255,255,255,0.1);
            border: 1px solid rgba(255,255,255,0.15);
            border-radius: 50px;
            padding: 5px 14px;
            color: #e2e8f0;
            font-size: 0.83rem;
            font-weight: 500;
        }
        .btn-logout {
            background: rgba(239,68,68,0.15);
            border: 1px solid rgba(239,68,68,0.3);
            color: #fca5a5;
            border-radius: 50px;
            padding: 5px 14px;
            font-size: 0.83rem;
            font-weight: 500;
            transition: all 0.2s;
            cursor: pointer;
        }
        .btn-logout:hover { background: rgba(239,68,68,0.3); color: #fff; }

        /* ── Sidebar ── */
        .sidebar {
            position: fixed;
            top: 64px; left: 0;
            width: 220px;
            height: calc(100vh - 64px);
            background: #0f172a;
            overflow-y: auto;
            z-index: 100;
            box-shadow: 2px 0 12px rgba(0,0,0,0.2);
            scrollbar-width: thin;
            scrollbar-color: #334155 transparent;
        }
        .sidebar-label {
            font-size: 0.62rem;
            font-weight: 700;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            color: #475569;
            padding: 18px 16px 6px;
        }
        .sidebar .nav-link {
            display: flex;
            align-items: center;
            gap: 9px;
            color: #94a3b8;
            padding: 9px 14px;
            border-radius: 8px;
            margin: 1px 8px;
            font-size: 0.845rem;
            font-weight: 500;
            text-decoration: none;
            transition: all 0.18s ease;
        }
        .sidebar .nav-link i { font-size: 0.95rem; width: 18px; text-align: center; flex-shrink: 0; }
        .sidebar .nav-link:hover { background: #1e293b; color: #e2e8f0; }
        .sidebar .nav-link.active {
            background: linear-gradient(135deg, #3b82f6, #2563eb);
            color: #fff;
            box-shadow: 0 3px 10px rgba(59,130,246,0.35);
        }

        /* ── Main Content ── */
        .main-content {
            margin-left: 220px;
            padding: 26px;
            min-height: calc(100vh - 64px);
        }

        /* ── Cards ── */
        .card {
            border: none;
            border-radius: 14px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05), 0 4px 16px rgba(0,0,0,0.07);
        }
        .card-body { padding: 1.2rem; }

        /* ── Tables ── */
        .table thead th {
            background: #f8fafc;
            color: #475569;
            font-size: 0.76rem;
            font-weight: 600;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            border-bottom: 2px solid #e2e8f0;
            padding: 11px 14px;
        }
        .table td { padding: 11px 14px; vertical-align: middle; color: #334155; }
        .table-hover tbody tr:hover { background: #f8fafc; }

        /* ── Buttons ── */
        .btn { border-radius: 8px; font-weight: 500; font-size: 0.875rem; }
        .btn-primary { background: linear-gradient(135deg, #3b82f6, #2563eb); border: none; box-shadow: 0 2px 8px rgba(59,130,246,0.3); }
        .btn-primary:hover { background: linear-gradient(135deg, #2563eb, #1d4ed8); }
        .btn-warning { background: linear-gradient(135deg, #f59e0b, #d97706); border: none; color: #fff; }
        .btn-warning:hover { color: #fff; }
        .btn-danger  { background: linear-gradient(135deg, #ef4444, #dc2626); border: none; }

        /* ── Badges ── */
        .badge { border-radius: 50px; padding: 5px 11px; font-size: 0.73rem; font-weight: 600; }

        /* ── Alerts ── */
        .alert { border-radius: 10px; border: none; }

        /* ── Form controls ── */
        .form-control, .form-select {
            border-radius: 8px;
            border: 1.5px solid #e2e8f0;
            font-size: 0.875rem;
            padding: 9px 12px;
            color: #334155;
            transition: border-color 0.2s, box-shadow 0.2s;
        }
        .form-control:focus, .form-select:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59,130,246,0.12);
        }
        .form-label { font-weight: 500; font-size: 0.84rem; color: #374151; margin-bottom: 5px; }

        /* Page header */
        .page-header { margin-bottom: 22px; }
        .page-header h2 { font-size: 1.4rem; font-weight: 700; color: #0f172a; margin: 0; }

        @media (max-width: 767.98px) {
            .sidebar { width: 100%; height: auto; position: relative; top: 0; }
            .main-content { margin-left: 0; padding: 14px; }
        }
    </style>
</head>
<body>
    @auth
        <nav class="navbar fixed-top top-navbar">
            <div class="container-fluid">
                <a class="navbar-brand d-flex align-items-center gap-2" href="{{ route('dashboard') }}">
                    <div class="brand-icon">
                        <i class="bi bi-receipt text-white" style="font-size:0.95rem;"></i>
                    </div>
                    <span style="font-size:1rem;font-weight:700;color:#fff;" class="d-none d-md-block">
                        Invoice & <span style="color:#60a5fa;">Budget</span> MS
                    </span>
                </a>

                <button class="border-0 bg-transparent text-white d-md-none" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu">
                    <i class="bi bi-list fs-3"></i>
                </button>

                <div class="d-none d-md-flex align-items-center gap-3">
                    <div class="nav-user-pill d-flex align-items-center gap-2">
                        <div style="width:22px;height:22px;background:linear-gradient(135deg,#3b82f6,#8b5cf6);border-radius:50%;display:flex;align-items:center;justify-content:center;">
                            <i class="bi bi-person-fill text-white" style="font-size:0.6rem;"></i>
                        </div>
                        {{ auth()->user()->name }}
                    </div>
                    <form action="{{ route('logout') }}" method="POST" class="m-0">
                        @csrf
                        <button type="submit" class="btn-logout border-0">
                            <i class="bi bi-box-arrow-right me-1"></i>Logout
                        </button>
                    </form>
                </div>
            </div>
        </nav>

        <div class="d-flex">
            <nav id="sidebarMenu" class="sidebar collapse d-md-block">
                <div class="pt-1 pb-4">
                    <!-- Mobile: user info -->
                    <div class="d-md-none px-4 py-3 mb-1" style="border-bottom:1px solid #1e293b;">
                        <p class="text-white mb-1 fw-600 small">{{ auth()->user()->name }}</p>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn-logout border-0 w-100 text-start">
                                <i class="bi bi-box-arrow-right me-1"></i>Logout
                            </button>
                        </form>
                    </div>

                    <div class="sidebar-label">Main</div>
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                                <i class="bi bi-grid-1x2-fill"></i> Dashboard
                            </a>
                        </li>
                    </ul>

                    <div class="sidebar-label">Master Data</div>
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('customers.*') ? 'active' : '' }}" href="{{ route('customers.index') }}">
                                <i class="bi bi-people-fill"></i> Customers
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('suppliers.*') ? 'active' : '' }}" href="{{ route('suppliers.index') }}">
                                <i class="bi bi-truck"></i> Suppliers
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('products.*') ? 'active' : '' }}" href="{{ route('products.index') }}">
                                <i class="bi bi-box-seam-fill"></i> Products
                            </a>
                        </li>
                    </ul>

                    <div class="sidebar-label">Invoices</div>
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('sales-invoices.*') ? 'active' : '' }}" href="{{ route('sales-invoices.index') }}">
                                <i class="bi bi-file-earmark-text-fill"></i> Sales Invoices
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('purchase-invoices.*') ? 'active' : '' }}" href="{{ route('purchase-invoices.index') }}">
                                <i class="bi bi-file-earmark-arrow-down-fill"></i> Purchase Invoices
                            </a>
                        </li>
                    </ul>

                    <div class="sidebar-label">Finance</div>
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('budgets.*') ? 'active' : '' }}" href="{{ route('budgets.index') }}">
                                <i class="bi bi-pie-chart-fill"></i> Budgets
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('expenses.*') ? 'active' : '' }}" href="{{ route('expenses.index') }}">
                                <i class="bi bi-credit-card-fill"></i> Expenses
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('payments.*') ? 'active' : '' }}" href="{{ route('payments.index') }}">
                                <i class="bi bi-cash-stack"></i> Payments
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('reports.*') ? 'active' : '' }}" href="{{ route('reports.index') }}">
                                <i class="bi bi-bar-chart-fill"></i> Reports
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>

            <main class="main-content flex-grow-1">
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show d-flex align-items-center gap-2 mb-4" role="alert">
                        <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
                        <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
                    </div>
                @endif
                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center gap-2 mb-4" role="alert">
                        <i class="bi bi-exclamation-circle-fill"></i> {{ session('error') }}
                        <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
                    </div>
                @endif
                @yield('content')
            </main>
        </div>
    @else
        @yield('content')
    @endauth

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>