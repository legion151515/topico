<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIGRAM Tópico - La Salle Urubamba</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
        }

        .sidebar {
            position: fixed;
            left: 0;
            top: 0;
            width: 260px;
            height: 100vh;
            background: linear-gradient(180deg, #1e3c72 0%, #2a5298 100%);
            overflow-y: auto;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
            z-index: 1000;
        }

        .sidebar-header {
            padding: 30px 20px;
            text-align: center;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .sidebar-header h2 {
            color: white;
            font-size: 20px;
            font-weight: 700;
            margin-bottom: 5px;
        }

        .sidebar-header p {
            color: rgba(255, 255, 255, 0.7);
            font-size: 12px;
        }

        .sidebar-menu {
            list-style: none;
            padding: 20px 0;
        }

        .sidebar-menu li {
            margin: 0;
        }

        .sidebar-menu a {
            display: flex;
            align-items: center;
            padding: 15px 20px;
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            transition: all 0.3s ease;
            border-left: 4px solid transparent;
        }

        .sidebar-menu a:hover {
            background: rgba(255, 255, 255, 0.1);
            border-left-color: #4CAF50;
            color: white;
        }

        .sidebar-menu a.active {
            background: rgba(255, 255, 255, 0.15);
            border-left-color: #4CAF50;
            color: white;
        }

        .sidebar-menu i {
            width: 25px;
            margin-right: 15px;
            text-align: center;
        }

        .main-content {
            margin-left: 260px;
            min-height: 100vh;
            padding: 30px;
        }

        .topbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: white;
            padding: 20px 30px;
            border-radius: 10px;
            margin-bottom: 30px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        }

        .topbar-left h1 {
            color: #1e3c72;
            font-size: 28px;
            font-weight: 700;
        }

        .topbar-right {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .user-menu {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .user-menu form {
            margin: 0;
        }

        .btn-logout {
            background: #e74c3c;
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 6px;
            cursor: pointer;
            font-size: 14px;
            transition: all 0.3s ease;
        }

        .btn-logout:hover {
            background: #c0392b;
            transform: translateY(-2px);
        }

        .card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
            padding: 30px;
            margin-bottom: 30px;
            transition: all 0.3s ease;
        }

        .card:hover {
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.12);
        }

        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 20px;
            border-bottom: 2px solid #f0f0f0;
        }

        .card-header h2 {
            color: #1e3c72;
            font-size: 24px;
            font-weight: 600;
        }

        .btn {
            padding: 10px 20px;
            border-radius: 8px;
            border: none;
            cursor: pointer;
            font-size: 14px;
            font-weight: 500;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-primary {
            background: linear-gradient(135deg, #4CAF50 0%, #45a049 100%);
            color: white;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(76, 175, 80, 0.4);
        }

        .btn-secondary {
            background: #95a5a6;
            color: white;
        }

        .btn-secondary:hover {
            background: #7f8c8d;
        }

        .btn-danger {
            background: #e74c3c;
            color: white;
        }

        .btn-danger:hover {
            background: #c0392b;
        }

        .btn-info {
            background: #3498db;
            color: white;
        }

        .btn-info:hover {
            background: #2980b9;
        }

        .btn-warning {
            background: #f39c12;
            color: white;
        }

        .btn-warning:hover {
            background: #d68910;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
        }

        .table th {
            background: #f8f9fa;
            color: #1e3c72;
            padding: 15px;
            text-align: left;
            font-weight: 600;
            border-bottom: 2px solid #e0e0e0;
        }

        .table td {
            padding: 15px;
            border-bottom: 1px solid #f0f0f0;
        }

        .table tr:hover {
            background: #f8f9fa;
        }

        .alert {
            padding: 15px 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            border-left: 4px solid;
        }

        .alert-success {
            background: #d4edda;
            color: #155724;
            border-left-color: #28a745;
        }

        .alert-danger {
            background: #f8d7da;
            color: #721c24;
            border-left-color: #f5c6cb;
        }

        .alert-warning {
            background: #fff3cd;
            color: #856404;
            border-left-color: #ffc107;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #1e3c72;
            font-weight: 500;
            font-size: 14px;
        }

        .form-group input,
        .form-group textarea,
        .form-group select {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-size: 14px;
            transition: all 0.3s ease;
        }

        .form-group input:focus,
        .form-group textarea:focus,
        .form-group select:focus {
            outline: none;
            border-color: #4CAF50;
            box-shadow: 0 0 0 3px rgba(76, 175, 80, 0.1);
        }

        .badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }

        .badge-success {
            background: #d4edda;
            color: #155724;
        }

        .badge-danger {
            background: #f8d7da;
            color: #721c24;
        }

        .badge-warning {
            background: #fff3cd;
            color: #856404;
        }

        .badge-info {
            background: #d1ecf1;
            color: #0c5460;
        }

        /* Botón hamburguesa (solo móviles) */
        .menu-toggle {
            display: none;
            position: fixed;
            top: 20px;
            left: 20px;
            z-index: 1100;
            background: #1e3c72;
            color: white;
            border: none;
            padding: 12px 16px;
            border-radius: 8px;
            cursor: pointer;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        }

        .menu-toggle i {
            font-size: 20px;
        }

        /* Overlay para cerrar sidebar en móvil */
        .sidebar-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            z-index: 999;
        }

        .sidebar-overlay.active {
            display: block;
        }

        /* Tablas responsive */
        .table-responsive {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        .table-responsive table {
            min-width: 600px;
        }

        /* Botones en fila */
        .btn-sm {
            padding: 6px 12px;
            font-size: 12px;
        }

        /* RESPONSIVE: TABLETS (max-width: 1024px) */
        @media (max-width: 1024px) {
            .sidebar {
                width: 220px;
            }

            .main-content {
                margin-left: 220px;
                padding: 20px;
            }

            .topbar-left h1 {
                font-size: 24px;
            }

            .card {
                padding: 20px;
            }
        }

        /* RESPONSIVE: MÓVILES (max-width: 768px) */
        @media (max-width: 768px) {
            .menu-toggle {
                display: block;
            }

            .sidebar {
                transform: translateX(-100%);
                transition: transform 0.3s ease;
                width: 260px;
            }

            .sidebar.active {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
                padding: 80px 15px 15px;
            }

            .topbar {
                flex-direction: column;
                gap: 15px;
                align-items: flex-start;
                padding: 15px;
            }

            .topbar-left h1 {
                font-size: 20px;
            }

            .user-menu {
                flex-direction: column;
                gap: 10px;
                width: 100%;
            }

            .card-header {
                flex-direction: column;
                gap: 15px;
                align-items: flex-start;
            }

            .card-header h2 {
                font-size: 20px;
            }

            .btn {
                width: 100%;
                justify-content: center;
            }

            .float-right {
                float: none !important;
                width: 100%;
            }

            /* Tablas más pequeñas en móvil */
            .table {
                font-size: 13px;
            }

            .table th,
            .table td {
                padding: 10px 8px;
            }

            /* Formularios */
            .form-group label {
                font-size: 13px;
            }

            .row {
                margin-left: 0;
                margin-right: 0;
            }

            .col-md-1, .col-md-2, .col-md-3, .col-md-4,
            .col-md-5, .col-md-6, .col-md-7, .col-md-8,
            .col-md-9, .col-md-10, .col-md-11, .col-md-12 {
                width: 100%;
                padding-left: 0;
                padding-right: 0;
                margin-bottom: 15px;
            }
        }

        /* RESPONSIVE: MÓVILES PEQUEÑOS (max-width: 480px) */
        @media (max-width: 480px) {
            .sidebar-header h2 {
                font-size: 18px;
            }

            .sidebar-menu a {
                padding: 12px 15px;
                font-size: 14px;
            }

            .topbar-left h1 {
                font-size: 18px;
            }

            .card {
                padding: 15px;
            }

            .card-header h2 {
                font-size: 18px;
            }

            .btn {
                padding: 8px 16px;
                font-size: 13px;
            }

            .table {
                font-size: 12px;
            }

            .badge {
                font-size: 10px;
                padding: 3px 8px;
            }

            /* Ocultar columnas menos importantes en móviles muy pequeños */
            .table .hide-on-small {
                display: none;
            }
        }

        /* Clases de utilidad */
        .row {
            display: flex;
            flex-wrap: wrap;
            margin: -10px;
        }

        .row > * {
            padding: 10px;
        }

        .text-center {
            text-align: center;
        }

        .text-muted {
            color: #999;
        }

        .float-right {
            float: right;
        }

        .mt-3 {
            margin-top: 1rem;
        }

        .mb-0 {
            margin-bottom: 0;
        }

        .pl-3 {
            padding-left: 1rem;
        }

        .bg-light {
            background-color: #f8f9fa;
        }

        .invalid-feedback {
            color: #e74c3c;
            font-size: 13px;
            margin-top: 5px;
        }

        .is-invalid {
            border-color: #e74c3c !important;
        }

        .form-text {
            font-size: 12px;
            color: #666;
        }

        .table-warning {
            background-color: #fff3cd;
        }

        .table-striped tbody tr:nth-child(odd) {
            background-color: #f8f9fa;
        }

        .badge-secondary {
            background: #95a5a6;
            color: white;
        }

        .badge-primary {
            background: #3498db;
            color: white;
        }

        .badge-lg {
            font-size: 14px;
            padding: 6px 14px;
        }

        .alert-info {
            background: #d1ecf1;
            color: #0c5460;
            border-left-color: #17a2b8;
        }

        .alert-secondary {
            background: #e2e3e5;
            color: #383d41;
            border-left-color: #6c757d;
        }
    </style>
</head>
<body>
    <!-- BOTÓN HAMBURGUESA (solo móviles) -->
    <button class="menu-toggle" id="menuToggle">
        <i class="fas fa-bars"></i>
    </button>

    <!-- OVERLAY PARA CERRAR MENÚ -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <!-- SIDEBAR -->
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <h2>SIGRAM</h2>
            <p>Tópico La Salle</p>
        </div>
        <ul class="sidebar-menu">
            <li>
                <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <i class="fas fa-home"></i> Dashboard
                </a>
            </li>
            <li>
                <a href="{{ route('atenciones.index') }}" class="{{ request()->routeIs('atenciones.*') ? 'active' : '' }}">
                    <i class="fas fa-file-medical"></i> Atenciones
                </a>
            </li>
            <li>
                <a href="{{ route('pacientes.index') }}" class="{{ request()->routeIs('pacientes.*') ? 'active' : '' }}">
                    <i class="fas fa-users"></i> Pacientes
                </a>
            </li>
            <li>
                <a href="{{ route('medicamentos.index') }}" class="{{ request()->routeIs('medicamentos.*') ? 'active' : '' }}">
                    <i class="fas fa-pills"></i> Medicamentos
                </a>
            </li>
            <li>
                <a href="{{ route('carreras.index') }}" class="{{ request()->routeIs('carreras.*') ? 'active' : '' }}">
                    <i class="fas fa-graduation-cap"></i> Carreras
                </a>
            </li>
            <li>
                <a href="{{ route('motivos.index') }}" class="{{ request()->routeIs('motivos.*') ? 'active' : '' }}">
                    <i class="fas fa-stethoscope"></i> Motivos de Consulta
                </a>
            </li>
            <li>
                <a href="{{ route('historial.index') }}" class="{{ request()->routeIs('historial.*') ? 'active' : '' }}">
                    <i class="fas fa-file-medical-alt"></i> Historial Clínico
                </a>
            </li>
            <li>
                <a href="{{ route('reportes.index') }}" class="{{ request()->routeIs('reportes.*') ? 'active' : '' }}">
                    <i class="fas fa-chart-bar"></i> Reportes
                </a>
            </li>
        </ul>
    </aside>

    <!-- MAIN CONTENT -->
    <div class="main-content">
        <!-- TOPBAR -->
        <div class="topbar">
            <div class="topbar-left">
                <h1>@yield('page_title', 'Bienvenido')</h1>
            </div>
            <div class="topbar-right">
                <div class="user-menu">
                    <span>{{ Auth::user()->name }}</span>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn-logout">
                            <i class="fas fa-sign-out-alt"></i> Salir
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- ALERTS -->
        @if($message = Session::get('success'))
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i> {{ $message }}
            </div>
        @endif

        @if($message = Session::get('error'))
            <div class="alert alert-danger">
                <i class="fas fa-exclamation-circle"></i> {{ $message }}
            </div>
        @endif

        <!-- CONTENT -->
        @yield('content')
    </div>

    <!-- JAVASCRIPT PARA MENÚ MÓVIL -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const menuToggle = document.getElementById('menuToggle');
            const sidebar = document.getElementById('sidebar');
            const sidebarOverlay = document.getElementById('sidebarOverlay');

            // Abrir/cerrar menú
            menuToggle.addEventListener('click', function() {
                sidebar.classList.toggle('active');
                sidebarOverlay.classList.toggle('active');
            });

            // Cerrar menú al hacer clic en overlay
            sidebarOverlay.addEventListener('click', function() {
                sidebar.classList.remove('active');
                sidebarOverlay.classList.remove('active');
            });

            // Cerrar menú al hacer clic en un enlace (solo en móvil)
            const sidebarLinks = sidebar.querySelectorAll('a');
            sidebarLinks.forEach(link => {
                link.addEventListener('click', function() {
                    if (window.innerWidth <= 768) {
                        sidebar.classList.remove('active');
                        sidebarOverlay.classList.remove('active');
                    }
                });
            });
        });
    </script>
</body>
</html>