<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administración de Lavadas - Service Center</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/es.js"></script>
    <style>
        :root {
            --primary: #0067b3;
            --primary-light: #4d94ff;
            --primary-dark: #003b7a;
            --secondary: #00c2ff;
            --accent: #00e5ff;
            --success: #4CAF50;
            --error: #f44336;
            --warning: #ff9800;
            --info: #2196F3;
            --light: #f8f9fa;
            --dark: #212529;
            --gray: #6c757d;
            --gray-light: #dee2e6;
            --gray-dark: #343a40;
            --white: #ffffff;
            --transition-speed: 0.3s;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            color: var(--dark);
            background-color: #f5f8ff;
            min-height: 100vh;
            overflow-x: hidden;
        }

        /* Animación de carga inicial */
        .page-loader {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, var(--primary-dark), var(--primary));
            z-index: 9999;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            transition: opacity 0.5s ease-in-out, visibility 0.5s ease-in-out;
        }

        .page-loader.hidden {
            opacity: 0;
            visibility: hidden;
        }

        .loader-title {
            color: white;
            font-size: 28px;
            font-weight: 600;
            margin-bottom: 40px;
            opacity: 0;
            transform: translateY(20px);
            animation: fadeInUp 1s forwards 0.5s;
        }

        .loader-subtitle {
            color: rgba(255, 255, 255, 0.8);
            font-size: 16px;
            margin-top: 20px;
            opacity: 0;
            animation: fadeInUp 1s forwards 1s;
        }

        /* Animación de silueta de carro avanzando con la carga */
        .car-animation {
            position: relative;
            width: 300px;
            height: 60px;
            margin-bottom: 30px;
        }

        .moving-car {
            position: absolute;
            width: 80px;
            height: 25px;
            background: transparent;
            left: 0;
            top: 20px;
            transition: transform 3s ease-out;
            z-index: 5;
        }

        .car-silhouette {
            position: absolute;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 40"><path d="M20,20 Q30,5 50,5 Q70,5 80,20 L95,20 Q100,20 100,25 L100,30 Q100,35 95,35 L90,35 L85,35 Q80,35 80,30 Q80,25 75,25 Q70,25 70,30 Q70,35 65,35 L35,35 Q30,35 30,30 Q30,25 25,25 Q20,25 20,30 Q20,35 15,35 L10,35 L5,35 Q0,35 0,30 L0,25 Q0,20 5,20 Z" fill="white"/></svg>');
            background-size: contain;
            background-repeat: no-repeat;
            filter: drop-shadow(0 5px 10px rgba(0,0,0,0.2));
        }

        .road {
            position: absolute;
            width: 100%;
            height: 3px;
            background-color: rgba(255,255,255,0.3);
            bottom: 5px;
            left: 0;
            border-radius: 2px;
        }

        .road::before {
            content: '';
            position: absolute;
            width: 100%;
            height: 1px;
            background-color: rgba(255,255,255,0.7);
            top: 50%;
            left: 0;
            transform: translateY(-50%);
            background: repeating-linear-gradient(90deg, rgba(255,255,255,0.7), rgba(255,255,255,0.7) 10px, transparent 10px, transparent 20px);
        }

        .progress-container {
            width: 300px;
            height: 6px;
            background-color: rgba(255, 255, 255, 0.2);
            border-radius: 3px;
            overflow: hidden;
            margin-top: 20px;
            opacity: 0;
            animation: fadeInUp 1s forwards 1.2s;
        }

        .progress-bar {
            height: 100%;
            width: 0;
            background-color: var(--accent);
            border-radius: 3px;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Layout principal */
        .dashboard-container {
            display: flex;
            min-height: 100vh;
            position: relative;
        }

        /* Barra lateral con mejoras para responsividad */
        .sidebar {
            width: 260px;
            background: linear-gradient(to bottom, var(--primary-dark), var(--primary));
            color: white;
            transition: all var(--transition-speed) ease;
            position: fixed;
            top: 0;
            left: 0;
            height: 100%;
            z-index: 100;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            overflow-y: auto;
            overflow-x: hidden;
        }

        .sidebar.collapsed {
            width: 70px;
        }

        .sidebar-header {
            padding: 20px 15px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .sidebar-logo {
            display: flex;
            align-items: center;
            font-size: 20px;
            font-weight: 700;
            white-space: nowrap;
            overflow: hidden;
            transition: all var(--transition-speed) ease;
        }

        .sidebar-logo i {
            font-size: 24px;
            margin-right: 10px;
        }

        .sidebar-logo span {
            color: var(--accent);
        }

        .sidebar.collapsed .sidebar-logo {
            justify-content: center;
        }

        .sidebar.collapsed .sidebar-logo span {
            display: none;
        }

        .toggle-sidebar {
            cursor: pointer;
            font-size: 20px;
            color: white;
            background: none;
            border: none;
            transition: all var(--transition-speed) ease;
        }

        .toggle-sidebar:hover {
            color: var(--accent);
        }

        .sidebar.collapsed .toggle-sidebar {
            transform: rotate(180deg);
        }

        .sidebar-user {
            padding: 20px;
            text-align: center;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .user-avatar {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            background-color: var(--primary-light);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
            overflow: hidden;
            transition: all var(--transition-speed) ease;
        }

        .user-avatar i {
            font-size: 30px;
            color: white;
        }

        .user-info {
            white-space: nowrap;
            transition: opacity var(--transition-speed) ease;
        }

        .user-name {
            font-size: 16px;
            font-weight: 600;
            margin-bottom: 5px;
        }

        .user-role {
            font-size: 12px;
            color: rgba(255, 255, 255, 0.7);
        }

        .sidebar.collapsed .user-info {
            display: none;
        }

        .sidebar.collapsed .user-avatar {
            width: 40px;
            height: 40px;
        }

        .sidebar-menu {
            padding: 20px 0;
        }

        .menu-item {
            position: relative;
            display: block;
            padding: 12px 20px;
            display: flex;
            align-items: center;
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            transition: all var(--transition-speed) ease;
            white-space: nowrap;
        }

        .menu-item:hover, .menu-item.active {
            background-color: rgba(255, 255, 255, 0.1);
            color: white;
        }

        .menu-item i {
            font-size: 20px;
            min-width: 35px;
            text-align: center;
            margin-right: 10px;
            transition: all var(--transition-speed) ease;
        }

        .sidebar.collapsed .menu-item span {
            display: none;
        }

        .sidebar.collapsed .menu-item i {
            margin-right: 0;
        }

        .sidebar.collapsed .menu-item {
            display: flex;
            justify-content: center;
            padding: 15px;
        }

        .menu-label {
            padding: 10px 20px;
            font-size: 12px;
            text-transform: uppercase;
            color: rgba(255, 255, 255, 0.5);
            letter-spacing: 1px;
            transition: opacity var(--transition-speed) ease;
        }

        .sidebar.collapsed .menu-label {
            opacity: 0;
            height: 0;
            padding: 0;
            overflow: hidden;
        }

        .menu-tooltip {
            position: absolute;
            background-color: var(--primary-dark);
            color: white;
            padding: 5px 12px;
            border-radius: 4px;
            font-size: 12px;
            left: 70px;
            white-space: nowrap;
            opacity: 0;
            visibility: hidden;
            transition: all var(--transition-speed) ease;
            z-index: 100;
            pointer-events: none;
        }

        .menu-tooltip::before {
            content: '';
            position: absolute;
            top: 50%;
            left: -6px;
            transform: translateY(-50%);
            border-width: 6px 6px 6px 0;
            border-style: solid;
            border-color: transparent var(--primary-dark) transparent transparent;
        }

        .sidebar.collapsed .menu-item:hover .menu-tooltip {
            opacity: 1;
            visibility: visible;
        }
        
        .sidebar::-webkit-scrollbar {
            width: 0;
            background: transparent;
        }

        /* Contenido principal */
        .main-content {
            flex: 1;
            margin-left: 260px;
            padding: 20px;
            transition: margin-left var(--transition-speed) ease;
            opacity: 0;
            animation: fadeIn 0.5s forwards 0.3s;
        }

        .sidebar.collapsed ~ .main-content {
            margin-left: 70px;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }

        /* Header del contenido principal */
        .content-header {
            background-color: white;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            display: flex;
            justify-content: space-between;
            align-items: center;
            animation: slideDown 0.5s forwards;
        }

        @keyframes slideDown {
            from {
                transform: translateY(-20px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .page-title {
            font-size: 24px;
            font-weight: 600;
            color: var(--primary-dark);
        }

        .breadcrumb {
            display: flex;
            align-items: center;
            list-style: none;
        }

        .breadcrumb-item {
            font-size: 14px;
            color: var(--gray);
        }

        .breadcrumb-item a {
            color: var(--primary);
            text-decoration: none;
        }

        .breadcrumb-item a:hover {
            text-decoration: underline;
        }

        .breadcrumb-item + .breadcrumb-item::before {
            content: '/';
            margin: 0 8px;
            color: var(--gray-light);
        }

        .header-actions {
            display: flex;
            gap: 10px;
        }

        /* Estadísticas */
        .stats-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 20px;
            animation: fadeInUp 0.5s forwards 0.4s;
        }

        .stat-card {
            background-color: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            display: flex;
            align-items: center;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }

        .stat-icon {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background-color: rgba(0, 103, 179, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
        }

        .stat-icon i {
            font-size: 24px;
            color: var(--primary);
        }

        .stat-content {
            flex: 1;
        }

        .stat-number {
            font-size: 28px;
            font-weight: 700;
            color: var(--primary-dark);
            margin-bottom: 5px;
        }

        .stat-label {
            font-size: 14px;
            color: var(--gray);
        }

        /* Alertas y notificaciones */
        .alert {
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 20px;
            animation: slideIn 0.5s ease-out;
            display: flex;
            align-items: center;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }

        @keyframes slideIn {
            from {
                transform: translateX(-20px);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        .alert-success {
            background-color: rgba(76, 175, 80, 0.1);
            border-left: 4px solid var(--success);
            color: var(--success);
        }

        .alert-error {
            background-color: rgba(244, 67, 54, 0.1);
            border-left: 4px solid var(--error);
            color: var(--error);
        }

        .alert-icon {
            margin-right: 15px;
            font-size: 20px;
        }

        /* Panel de filtros */
        .filter-panel {
            background-color: white;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            animation: fadeInUp 0.5s forwards;
        }

        .filter-title {
            font-size: 18px;
            font-weight: 600;
            color: var(--primary-dark);
            margin-bottom: 15px;
            display: flex;
            align-items: center;
        }

        .filter-title i {
            margin-right: 10px;
            font-size: 16px;
            color: var(--primary);
        }

        .filter-form {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 15px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            font-size: 14px;
            color: var(--dark);
        }

        .form-control {
            width: 100%;
            padding: 10px 15px;
            border: 1px solid var(--gray-light);
            border-radius: 8px;
            font-family: 'Poppins', sans-serif;
            font-size: 14px;
            transition: all var(--transition-speed) ease;
        }

        .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(0, 103, 179, 0.1);
            outline: none;
        }

        .filter-buttons {
            margin-top: 10px;
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        /* Botones */
        .btn {
            padding: 10px 20px;
            border-radius: 50px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            font-weight: 500;
            transition: all var(--transition-speed) ease;
            cursor: pointer;
            border: none;
            font-family: 'Poppins', sans-serif;
        }

        .btn i {
            margin-right: 8px;
        }

        .btn-primary {
            background-color: var(--primary);
            color: white;
        }

        .btn-primary:hover {
            background-color: var(--primary-dark);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .btn-outline {
            background-color: transparent;
            border: 2px solid var(--primary);
            color: var(--primary);
        }

        .btn-outline:hover {
            background-color: var(--primary);
            color: white;
        }

        .btn-sm {
            padding: 6px 15px;
            font-size: 13px;
        }

        /* Tarjetas de lavadas (reemplazo de la tabla) */
        .cards-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
            margin-top: 20px;
            animation: fadeInUp 0.6s forwards;
        }

        .service-card {
            background-color: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .service-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }

        .card-header {
            background-color: var(--primary);
            color: white;
            padding: 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .card-id {
            font-weight: 600;
            font-size: 16px;
        }

        .card-date {
            font-size: 13px;
            background-color: rgba(255, 255, 255, 0.2);
            padding: 4px 10px;
            border-radius: 20px;
        }

        .card-body {
            padding: 15px;
        }

        .card-info {
            margin-bottom: 4px;
            display: flex;
        }

        .card-label {
            width: 100px;
            min-width: 100px;
            font-weight: 500;
            color: var(--gray);
            font-size: 13px;
        }

        .card-value {
            flex: 1;
            font-size: 14px;
        }

        .card-divider {
            height: 1px;
            background-color: var(--gray-light);
            margin: 10px 0;
        }

        .card-service {
            font-weight: 600;
            color: var(--primary-dark);
            font-size: 15px;
            margin-bottom: 8px;
        }

        .card-footer {
            background-color: var(--light);
            padding: 15px;
            display: flex;
            justify-content: center;
        }

        /* Paginación */
        .pagination {
            margin-top: 30px;
            display: flex;
            justify-content: center;
        }

        .pagination a, .pagination span {
            display: inline-block;
            padding: 8px 16px;
            margin: 0 4px;
            border-radius: 50px;
            background-color: white;
            color: var(--primary);
            text-decoration: none;
            transition: all var(--transition-speed) ease;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
        }

        .pagination a:hover {
            background-color: var(--primary);
            color: white;
        }

        .pagination .active {
            background-color: var(--primary);
            color: white;
        }

        /* Mensaje de no hay datos */
        .no-data {
            background-color: white;
            padding: 40px;
            border-radius: 10px;
            text-align: center;
            margin-top: 20px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            animation: fadeInUp 0.5s forwards;
        }

        .no-data i {
            font-size: 60px;
            color: var(--gray-light);
            margin-bottom: 20px;
        }

        .no-data h3 {
            font-size: 20px;
            color: var(--dark);
            margin-bottom: 10px;
        }

        .no-data p {
            color: var(--gray);
            margin-bottom: 20px;
        }

        /* Responsividad */
        @media screen and (max-width: 991px) {
            .sidebar {
                width: 70px;
                overflow-x: hidden;
            }

            .sidebar .sidebar-logo span,
            .sidebar .user-info,
            .sidebar .menu-label,
            .sidebar .menu-item span {
                display: none;
            }

            .sidebar .user-avatar {
                width: 40px;
                height: 40px;
            }

            .sidebar .menu-item {
                display: flex;
                justify-content: center;
                padding: 15px 0;
            }

            .sidebar .menu-item i {
                margin-right: 0;
                font-size: 18px;
            }

            .main-content {
                margin-left: 70px;
            }

            .stats-container {
                grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            }

            .cards-container {
                grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            }
        }

        @media screen and (max-width: 768px) {
            .content-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 15px;
            }

            .content-header div:last-child {
                align-self: flex-end;
            }

            .stats-container {
                grid-template-columns: 1fr;
            }

            .filter-form {
                grid-template-columns: 1fr;
            }

            .cards-container {
                grid-template-columns: 1fr;
            }
        }

        @media screen and (max-width: 480px) {
            .main-content {
                padding: 15px;
            }

            .content-header {
                padding: 15px;
            }

            .page-title {
                font-size: 20px;
            }

            .filter-panel, .stat-card, .service-card {
                padding: 15px;
            }

            .filter-buttons {
                flex-direction: column;
            }

            .btn {
                width: 100%;
            }

            .pagination a, .pagination span {
                padding: 6px 12px;
                margin: 0 2px;
            }
        }
    </style>
</head>
<body>
    <!-- Animación de carga inicial con silueta de carro avanzando -->
    <div class="page-loader">
        <div class="loader-title">Service Center - Panel Administrativo</div>
        <div class="car-animation">
            <div class="moving-car">
                <div class="car-silhouette"></div>
            </div>
            <div class="road"></div>
        </div>
        <div class="loader-subtitle">Cargando Administración de Lavadas...</div>
        <div class="progress-container">
            <div class="progress-bar"></div>
        </div>
    </div>

    <div class="dashboard-container">
        <!-- Barra lateral -->
        <aside class="sidebar" id="sidebar">
            <div class="sidebar-header">
                <div class="sidebar-logo">
                    <i class="fas fa-car-side"></i>
                    <span>Service<span>Center</span></span>
                </div>
                <button class="toggle-sidebar" id="toggleSidebar">
                    <i class="fas fa-chevron-left"></i>
                </button>
            </div>
            
            <div class="sidebar-user">
                <div class="user-avatar">
                    <i class="fas fa-user"></i>
                </div>
                <div class="user-info">
                    <div class="user-name">{{ session('usuario')->nombre }}</div>
                    <div class="user-role">Administrador</div>
                </div>
            </div>
            
            <div class="sidebar-menu">
                <div class="menu-label">Principal</div>
                <a href="{{ route('admin.dashboard') }}" class="menu-item">
                    <i class="fas fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                    <div class="menu-tooltip">Dashboard</div>
                </a>
                <a href="{{ route('admin.turnos') }}" class="menu-item">
                    <i class="fas fa-calendar-alt"></i>
                    <span>Gestión de Turnos</span>
                    <div class="menu-tooltip">Gestión de Turnos</div>
                </a>
                
                <div class="menu-label">Gestión de Servicio</div>
                <a href="{{ route('admin.empleados.index') }}" class="menu-item">
                    <i class="fas fa-users"></i>
                    <span>Empleados</span>
                    <div class="menu-tooltip">Empleados</div>
                </a>
                <a href="{{ route('admin.billetera.index') }}" class="menu-item">
                    <i class="fas fa-wallet"></i>
                    <span>Comisiones</span>
                    <div class="menu-tooltip">Comisiones</div>
                </a>
                <a href="{{ route('admin.lavadas.index') }}" class="menu-item active">
                    <i class="fas fa-car-wash"></i>
                    <span>Lavados</span>
                    <div class="menu-tooltip">Lavados</div>
                </a>
                <a href="{{ route('admin.servicios.index') }}" class="menu-item">
                    <i class="fas fa-concierge-bell"></i>
                    <span>Servicios</span>
                    <div class="menu-tooltip">Servicios</div>
                </a>
                <a href="{{ route('admin.inventario.index') }}" class="menu-item">
                    <i class="fas fa-boxes"></i>
                    <span>Inventario</span>
                    <div class="menu-tooltip">Inventario</div>
                </a>
                
                <div class="menu-label">Reportes y Análisis</div>
                <a href="{{ route('admin.reportes.dashboard') }}" class="menu-item">
                    <i class="fas fa-chart-line"></i>
                    <span>Reportes</span>
                    <div class="menu-tooltip">Reportes</div>
                </a>
            </div>
        </aside>

        <!-- Contenido principal -->
        <main class="main-content">
            <!-- Header del contenido -->
            <div class="content-header">
                <div>
                    <h1 class="page-title">Administración de Lavadas</h1>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item">Administración de Lavadas</li>
                    </ul>
                </div>
            </div>

            <!-- Alertas -->
            @if (session('success'))
                <div class="alert alert-success">
                    <div class="alert-icon">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div>{{ session('success') }}</div>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-error">
                    <div class="alert-icon">
                        <i class="fas fa-exclamation-circle"></i>
                    </div>
                    <div>{{ session('error') }}</div>
                </div>
            @endif

            <!-- Estadísticas -->
            <div class="stats-container">
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-car-wash"></i>
                    </div>
                    <div class="stat-content">
                        <div class="stat-number">{{ $lavadas->total() }}</div>
                        <div class="stat-label">Total de Lavadas</div>
                    </div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-calendar-day"></i>
                    </div>
                    <div class="stat-content">
                        <div class="stat-number">{{ $lavadas->where('fecha', date('Y-m-d'))->count() }}</div>
                        <div class="stat-label">Lavadas Hoy</div>
                    </div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-calendar-week"></i>
                    </div>
                    <div class="stat-content">
                        <div class="stat-number">{{ $lavadas->where('fecha', '>=', date('Y-m-d', strtotime('-7 days')))->count() }}</div>
                        <div class="stat-label">Últimos 7 días</div>
                    </div>
                </div>
            </div>

            <!-- Panel de filtros -->
            <div class="filter-panel">
                <h3 class="filter-title"><i class="fas fa-filter"></i> Filtros</h3>
                <form action="{{ route('admin.lavadas.index') }}" method="GET" class="filter-form">
                    <div class="form-group">
                        <label for="fecha_desde" class="form-label">Desde Fecha</label>
                        <input type="date" id="fecha_desde" name="fecha_desde" value="{{ request('fecha_desde') }}" class="form-control datepicker">
                    </div>
                    
                    <div class="form-group">
                        <label for="fecha_hasta" class="form-label">Hasta Fecha</label>
                        <input type="date" id="fecha_hasta" name="fecha_hasta" value="{{ request('fecha_hasta') }}" class="form-control datepicker">
                    </div>
                    
                    <div class="form-group">
                        <label for="cliente" class="form-label">Cliente</label>
                        <input type="text" id="cliente" name="cliente" placeholder="Nombre del cliente" value="{{ request('cliente') }}" class="form-control">
                    </div>
                    
                    <div class="form-group">
                        <label for="empleado" class="form-label">Empleado</label>
                        <input type="text" id="empleado" name="empleado" placeholder="Nombre del empleado" value="{{ request('empleado') }}" class="form-control">
                    </div>
                    
                    <div class="form-group">
                        <label for="placa" class="form-label">Placa Vehículo</label>
                        <input type="text" id="placa" name="placa" placeholder="Placa" value="{{ request('placa') }}" class="form-control">
                    </div>
                    
                    <div class="filter-buttons">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-search"></i> Filtrar
                        </button>
                        <a href="{{ route('admin.lavadas.index') }}" class="btn btn-outline">
                            <i class="fas fa-redo"></i> Limpiar Filtros
                        </a>
                    </div>
                </form>
            </div>
            
            <!-- Tarjetas de lavadas (reemplazo de la tabla) -->
            @if($lavadas->count() > 0)
                <div class="cards-container">
                    @foreach($lavadas as $lavada)
                        <div class="service-card">
                            <div class="card-header">
                                <div class="card-id">Lavado #{{ $lavada->id_lavada }}</div>
                                <div class="card-date">{{ date('d/m/Y', strtotime($lavada->fecha)) }}</div>
                            </div>
                            <div class="card-body">
                                <div class="card-service">
                                    {{ $lavada->turno->tipo_servicio ?? 'No especificado' }}
                                </div>
                                
                                <div class="card-info">
                                    <div class="card-label">Hora:</div>
                                    <div class="card-value">{{ date('H:i', strtotime($lavada->hora)) }}</div>
                                </div>
                                
                                <div class="card-info">
                                    <div class="card-label">Cliente:</div>
                                    <div class="card-value">{{ $lavada->vehiculo->cliente->usuario->nombre ?? 'No disponible' }}</div>
                                </div>
                                
                                <div class="card-info">
                                    <div class="card-label">Vehículo:</div>
                                    <div class="card-value">{{ $lavada->vehiculo->placa }}</div>
                                </div>
                                
                                <div class="card-divider"></div>
                                
                                <div class="card-info">
                                    <div class="card-label">Empleado:</div>
                                    <div class="card-value">{{ $lavada->empleado->usuario->nombre ?? 'No disponible' }}</div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <a href="{{ route('admin.lavadas.show', $lavada->id_lavada) }}" class="btn btn-primary btn-sm">
                                    <i class="fas fa-eye"></i> Ver Detalle
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <div class="pagination">
                    {{ $lavadas->appends(request()->query())->links() }}
                </div>
            @else
                <div class="no-data">
                    <i class="fas fa-car-wash"></i>
                    <h3>No hay lavadas disponibles</h3>
                    <p>No se encontraron lavadas con los criterios seleccionados.</p>
                </div>
            @endif
        </main>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Animación de carga
            const car = document.querySelector('.moving-car');
            const progressBar = document.querySelector('.progress-bar');
            const loader = document.querySelector('.page-loader');
            
            let progress = 0;
            const interval = setInterval(() => {
                progress += 1;
                progressBar.style.width = progress + '%';
                car.style.transform = `translateX(${progress * 2}px)`;
                
                if (progress >= 100) {
                    clearInterval(interval);
                    setTimeout(() => {
                        loader.classList.add('hidden');
                    }, 500);
                }
            }, 20);
            
            // Toggle sidebar
            const sidebar = document.getElementById('sidebar');
            const toggleBtn = document.getElementById('toggleSidebar');
            const mainContent = document.querySelector('.main-content');
            
            toggleBtn.addEventListener('click', function() {
                sidebar.classList.toggle('collapsed');
                mainContent.style.marginLeft = sidebar.classList.contains('collapsed') ? '70px' : '260px';
            });
            
            // Verificar tamaño de pantalla
            function checkScreenSize() {
                if (window.innerWidth <= 991) {
                    sidebar.classList.add('collapsed');
                    mainContent.style.marginLeft = '70px';
                } else {
                    sidebar.classList.remove('collapsed');
                    mainContent.style.marginLeft = '260px';
                }
            }
            
            // Ejecutar al cargar
            checkScreenSize();
            
            // Ejecutar al redimensionar
            window.addEventListener('resize', checkScreenSize);
            
            // Inicializar datepicker
            if (typeof flatpickr !== 'undefined') {
                flatpickr('.datepicker', {
                    dateFormat: 'Y-m-d',
                    locale: 'es',
                    allowInput: true
                });
            }
        });
    </script>
</body>
</html>