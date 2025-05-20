<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalle de Lavado - Service Center</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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

        /* Tarjetas de información */
        .info-card {
            background-color: white;
            border-radius: 10px;
            margin-bottom: 20px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            overflow: hidden;
            animation: fadeInUp 0.5s forwards;
            animation-delay: calc(var(--order) * 0.1s);
            opacity: 0;
        }

        .info-card-header {
            padding: 15px 20px;
            border-bottom: 1px solid var(--gray-light);
            display: flex;
            align-items: center;
            background-color: var(--primary);
            color: white;
        }

        .info-card-icon {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background-color: rgba(255, 255, 255, 0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
        }

        .info-card-icon i {
            font-size: 18px;
        }

        .info-card-title {
            font-size: 18px;
            font-weight: 600;
        }

        .info-card-body {
            padding: 20px;
        }

        .info-row {
            display: flex;
            margin-bottom: 15px;
        }

        .info-row:last-child {
            margin-bottom: 0;
        }

        .info-label {
            width: 150px;
            min-width: 150px;
            font-weight: 500;
            color: var(--gray);
        }

        .info-value {
            flex: 1;
        }

        /* Estados */
        .status-badge {
            display: inline-flex;
            align-items: center;
            padding: 6px 12px;
            border-radius: 50px;
            font-size: 13px;
            font-weight: 600;
        }

        .status-badge i {
            margin-right: 5px;
            font-size: 12px;
        }

        .status-pending {
            background-color: rgba(255, 193, 7, 0.15);
            color: #d39e00;
        }

        .status-confirmed {
            background-color: rgba(0, 123, 255, 0.15);
            color: #0069d9;
        }

        .status-completed {
            background-color: rgba(40, 167, 69, 0.15);
            color: #218838;
        }

        .status-cancelled {
            background-color: rgba(220, 53, 69, 0.15);
            color: #c82333;
        }

        /* Tarjeta de imágenes */
        .images-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }

        .image-card {
            background-color: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            animation: fadeInUp 0.5s forwards;
            animation-delay: 0.6s;
            opacity: 0;
        }

        .image-card-header {
            padding: 15px;
            background-color: var(--primary);
            color: white;
            font-weight: 600;
            display: flex;
            align-items: center;
        }

        .image-card-header i {
            margin-right: 8px;
        }

        .image-content {
            padding: 20px;
            text-align: center;
        }

        .image-content img {
            max-width: 100%;
            max-height: 400px;
            border-radius: 5px;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
        }

        .no-image {
            padding: 40px 20px;
            color: var(--gray);
            text-align: center;
        }

        .no-image i {
            font-size: 40px;
            color: var(--gray-light);
            margin-bottom: 10px;
        }

        /* Estrellas de calificación */
        .stars-container {
            display: flex;
            align-items: center;
        }

        .star {
            color: #ffc107;
            font-size: 20px;
            margin-right: 2px;
        }

        .star-empty {
            color: #e5e5e5;
        }

        .rating-value {
            margin-left: 10px;
            font-weight: 500;
        }

        /* Cliente comentario */
        .customer-comment {
            background-color: var(--light);
            padding: 15px;
            border-radius: 8px;
            font-style: italic;
            margin-top: 10px;
            border-left: 3px solid var(--primary-light);
        }

        /* Botones y acciones */
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

        .btn-warning {
            background-color: var(--warning);
            color: white;
        }

        .btn-warning:hover {
            background-color: #e59400;
        }

        .actions-container {
            display: flex;
            justify-content: flex-start;
            gap: 15px;
            margin-top: 20px;
            flex-wrap: wrap;
        }

        /* Animación adicional */
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

            .images-container {
                grid-template-columns: 1fr;
            }

            .info-row {
                flex-direction: column;
            }

            .info-label {
                width: 100%;
                margin-bottom: 5px;
            }
        }

        @media screen and (max-width: 768px) {
            .content-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 15px;
            }

            .info-row {
                flex-direction: column;
            }

            .info-label {
                width: 100%;
                margin-bottom: 5px;
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

            .info-card-header, .info-card-body {
                padding: 15px;
            }

            .actions-container {
                flex-direction: column;
            }

            .btn {
                width: 100%;
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
        <div class="loader-subtitle">Cargando Detalle de Lavado...</div>
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
                    <h1 class="page-title">Detalle de Lavado #{{ $lavada->id_lavada }}</h1>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.lavadas.index') }}">Administración de Lavadas</a></li>
                        <li class="breadcrumb-item">Detalle de Lavado</li>
                    </ul>
                </div>
            </div>

            <!-- Información del Servicio -->
            <div class="info-card" style="--order: 1">
                <div class="info-card-header">
                    <div class="info-card-icon">
                        <i class="fas fa-info-circle"></i>
                    </div>
                    <div class="info-card-title">Información del Servicio</div>
                </div>
                <div class="info-card-body">
                    <div class="info-row">
                        <div class="info-label">Fecha:</div>
                        <div class="info-value">{{ date('d/m/Y', strtotime($lavada->fecha)) }}</div>
                    </div>
                    
                    <div class="info-row">
                        <div class="info-label">Hora:</div>
                        <div class="info-value">{{ date('H:i', strtotime($lavada->hora)) }}</div>
                    </div>
                    
                    <div class="info-row">
                        <div class="info-label">Tipo de Servicio:</div>
                        <div class="info-value">{{ $lavada->turno->tipo_servicio ?? 'No especificado' }}</div>
                    </div>
                    
                    <div class="info-row">
                        <div class="info-label">Estado del Turno:</div>
                        <div class="info-value">
                            @if($lavada->turno)
                                @if($lavada->turno->estado == 'pendiente')
                                    <span class="status-badge status-pending">
                                        <i class="fas fa-clock"></i> Pendiente
                                    </span>
                                @elseif($lavada->turno->estado == 'confirmado')
                                    <span class="status-badge status-confirmed">
                                        <i class="fas fa-check"></i> Confirmado
                                    </span>
                                @elseif($lavada->turno->estado == 'completado')
                                    <span class="status-badge status-completed">
                                        <i class="fas fa-check-double"></i> Completado
                                    </span>
                                @elseif($lavada->turno->estado == 'cancelado')
                                    <span class="status-badge status-cancelled">
                                        <i class="fas fa-times"></i> Cancelado
                                    </span>
                                @endif
                            @else
                                <span style="color: var(--gray);">No disponible</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Información del Cliente y Vehículo -->
            <div class="info-card" style="--order: 2">
                <div class="info-card-header">
                    <div class="info-card-icon">
                        <i class="fas fa-user"></i>
                    </div>
                    <div class="info-card-title">Cliente y Vehículo</div>
                </div>
                <div class="info-card-body">
                    <div class="info-row">
                        <div class="info-label">Cliente:</div>
                        <div class="info-value">{{ $lavada->vehiculo->cliente->usuario->nombre ?? 'No disponible' }}</div>
                    </div>
                    
                    <div class="info-row">
                        <div class="info-label">Teléfono:</div>
                        <div class="info-value">{{ $lavada->vehiculo->cliente->telefono ?? 'No disponible' }}</div>
                    </div>
                    
                    <div class="info-row">
                        <div class="info-label">Vehículo:</div>
                        <div class="info-value">{{ $lavada->vehiculo->marca->nombre ?? '' }} {{ $lavada->vehiculo->anio ?? '' }}</div>
                    </div>
                    
                    <div class="info-row">
                        <div class="info-label">Placa:</div>
                        <div class="info-value">{{ $lavada->vehiculo->placa }}</div>
                    </div>
                    
                    <div class="info-row">
                        <div class="info-label">Color:</div>
                        <div class="info-value">{{ $lavada->vehiculo->color ?? 'No especificado' }}</div>
                    </div>
                </div>
            </div>

            <!-- Información del Empleado -->
            <div class="info-card" style="--order: 3">
                <div class="info-card-header">
                    <div class="info-card-icon">
                        <i class="fas fa-id-badge"></i>
                    </div>
                    <div class="info-card-title">Empleado</div>
                </div>
                <div class="info-card-body">
                    <div class="info-row">
                        <div class="info-label">Nombre:</div>
                        <div class="info-value">{{ $lavada->empleado->usuario->nombre ?? 'No disponible' }}</div>
                    </div>
                    
                    <div class="info-row">
                        <div class="info-label">Cargo:</div>
                        <div class="info-value">{{ $lavada->empleado->cargo ?? 'No especificado' }}</div>
                    </div>
                </div>
            </div>

            <!-- Observaciones -->
            <div class="info-card" style="--order: 4">
                <div class="info-card-header">
                    <div class="info-card-icon">
                        <i class="fas fa-clipboard-list"></i>
                    </div>
                    <div class="info-card-title">Observaciones</div>
                </div>
                <div class="info-card-body">
                    @if($lavada->comentario)
                        <p>{{ $lavada->comentario }}</p>
                    @else
                        <p style="color: var(--gray);">Sin observaciones registradas</p>
                    @endif
                </div>
            </div>

            <!-- Calificación del Cliente -->
            <div class="info-card" style="--order: 5">
                <div class="info-card-header">
                    <div class="info-card-icon">
                        <i class="fas fa-star"></i>
                    </div>
                    <div class="info-card-title">Calificación del Cliente</div>
                </div>
                <div class="info-card-body">
                    @if($lavada->calificacion)
                        <div class="info-row">
                            <div class="info-label">Puntuación:</div>
                            <div class="info-value">
                                <div class="stars-container">
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($i <= $lavada->calificacion)
                                            <i class="fas fa-star star"></i>
                                        @else
                                            <i class="far fa-star star star-empty"></i>
                                        @endif
                                    @endfor
                                    <span class="rating-value">({{ $lavada->calificacion }}/5)</span>
                                </div>
                            </div>
                        </div>
                        
                        @if($lavada->comentario_cliente)
                            <div class="info-row">
                                <div class="info-label">Comentario:</div>
                                <div class="info-value">
                                    <div class="customer-comment">
                                        "{{ $lavada->comentario_cliente }}"
                                    </div>
                                </div>
                            </div>
                        @endif
                    @else
                        <p style="color: var(--gray);">El cliente aún no ha calificado este servicio.</p>
                    @endif
                </div>
            </div>

            <!-- Imágenes del lavado -->
            <div class="images-container">
                <div class="image-card">
                    <div class="image-card-header">
                        <i class="fas fa-image"></i> Antes del Lavado
                    </div>
                    <div class="image-content">
                        @if($lavada->foto_antes)
                            <img src="{{ asset('storage/' . $lavada->foto_antes) }}" alt="Foto antes del lavado">
                        @else
                            <div class="no-image">
                                <i class="fas fa-image"></i>
                                <p>No se subió imagen</p>
                            </div>
                        @endif
                    </div>
                </div>
                
                <div class="image-card">
                    <div class="image-card-header">
                        <i class="fas fa-image"></i> Después del Lavado
                    </div>
                    <div class="image-content">
                        @if($lavada->foto_despues)
                            <img src="{{ asset('storage/' . $lavada->foto_despues) }}" alt="Foto después del lavado">
                        @else
                            <div class="no-image">
                                <i class="fas fa-image"></i>
                                <p>No se subió imagen</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            
            <!-- Acciones -->
            <div class="actions-container">
                <a href="{{ route('admin.lavadas.index') }}" class="btn btn-primary">
                    <i class="fas fa-arrow-left"></i> Volver al Listado
                </a>
                
                @if($lavada->turno)
                    <a href="{{ route('admin.turnos.edit', $lavada->turno->id_turno) }}" class="btn btn-warning">
                        <i class="fas fa-calendar-alt"></i> Ver Turno Asociado
                    </a>
                @endif
            </div>
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
        });
    </script>
</body>
</html>