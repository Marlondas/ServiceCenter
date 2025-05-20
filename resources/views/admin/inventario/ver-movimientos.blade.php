<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historial de Movimientos - Service Center</title>
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

        .btn-info {
            background-color: var(--info);
            color: white;
        }

        .btn-info:hover {
            background-color: #0b7dda;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        /* Tarjeta de información del producto */
        .product-card {
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            border-radius: 10px;
            overflow: hidden;
            color: white;
            margin-bottom: 25px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            animation: fadeInUp 0.5s forwards;
            position: relative;
        }

        .product-card::after {
            content: '';
            position: absolute;
            top: -50px;
            right: -50px;
            width: 150px;
            height: 150px;
            background-color: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            z-index: 1;
        }

        .product-card::before {
            content: '';
            position: absolute;
            bottom: -30px;
            left: -30px;
            width: 100px;
            height: 100px;
            background-color: rgba(255, 255, 255, 0.05);
            border-radius: 50%;
            z-index: 1;
        }

        .product-header {
            padding: 25px;
            position: relative;
            z-index: 2;
        }

        .product-name {
            font-size: 24px;
            font-weight: 700;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
        }

        .product-name i {
            font-size: 24px;
            margin-right: 10px;
        }

        .product-stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
            gap: 20px;
        }

        .product-stat {
            display: flex;
            flex-direction: column;
        }

        .stat-label {
            font-size: 13px;
            color: rgba(255, 255, 255, 0.7);
            margin-bottom: 5px;
        }

        .stat-value {
            font-size: 20px;
            font-weight: 600;
        }

        .product-status {
            padding: 4px 12px;
            border-radius: 20px;
            background-color: rgba(255, 255, 255, 0.2);
            font-size: 13px;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
        }

        .product-status i {
            margin-right: 5px;
            font-size: 12px;
        }

        /* Tabla de movimientos */
        .table-container {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            overflow: hidden;
            margin-bottom: 30px;
            animation: fadeInUp 0.5s forwards 0.2s;
            opacity: 0;
        }

        .table-header {
            background-color: var(--primary);
            color: white;
            padding: 20px;
            display: flex;
            align-items: center;
        }

        .table-title {
            font-size: 18px;
            font-weight: 600;
        }

        .table-title i {
            margin-right: 10px;
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
        }

        .data-table th {
            background-color: rgba(0, 103, 179, 0.05);
            color: var(--primary-dark);
            padding: 15px;
            text-align: left;
            font-weight: 600;
            border-bottom: 2px solid var(--gray-light);
        }

        .data-table td {
            padding: 15px;
            border-bottom: 1px solid var(--gray-light);
            color: var(--dark);
        }

        .data-table tr:last-child td {
            border-bottom: none;
        }

        .data-table tr:hover {
            background-color: rgba(0, 103, 179, 0.02);
        }

        .movement-type {
            display: inline-flex;
            align-items: center;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 600;
        }

        .movement-in {
            background-color: rgba(76, 175, 80, 0.1);
            color: var(--success);
        }

        .movement-out {
            background-color: rgba(244, 67, 54, 0.1);
            color: var(--error);
        }

        .movement-type i {
            margin-right: 5px;
            font-size: 12px;
        }

        .no-movements {
            padding: 30px;
            text-align: center;
            color: var(--gray);
        }

        .no-movements i {
            font-size: 40px;
            color: var(--gray-light);
            margin-bottom: 15px;
        }

        .no-movements p {
            margin-bottom: 20px;
        }

        /* Acciones */
        .actions-container {
            display: flex;
            gap: 15px;
            margin-bottom: 20px;
            animation: fadeInUp 0.5s forwards 0.3s;
            opacity: 0;
        }

        /* Responsive */
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

            .content-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 15px;
            }

            .content-header div:last-child {
                align-self: flex-end;
            }

            .product-stats {
                grid-template-columns: 1fr 1fr;
            }
        }

        @media screen and (max-width: 768px) {
            .product-stats {
                grid-template-columns: 1fr 1fr;
                gap: 15px;
            }

            .actions-container {
                flex-direction: column;
            }

            .btn {
                width: 100%;
            }

            .table-container {
                overflow-x: auto;
            }

            .data-table {
                min-width: 650px;
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

            .product-header {
                padding: 15px;
            }

            .product-name {
                font-size: 20px;
            }

            .product-stats {
                grid-template-columns: 1fr;
            }

            .table-header {
                padding: 15px;
            }

            .table-title {
                font-size: 16px;
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
        <div class="loader-subtitle">Cargando Historial de Movimientos...</div>
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
                <a href="{{ route('admin.lavadas.index') }}" class="menu-item">
                    <i class="fas fa-car-wash"></i>
                    <span>Lavados</span>
                    <div class="menu-tooltip">Lavados</div>
                </a>
                <a href="{{ route('admin.servicios.index') }}" class="menu-item">
                    <i class="fas fa-concierge-bell"></i>
                    <span>Servicios</span>
                    <div class="menu-tooltip">Servicios</div>
                </a>
                <a href="{{ route('admin.inventario.index') }}" class="menu-item active">
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
                    <h1 class="page-title">Historial de Movimientos</h1>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.inventario.index') }}">Inventario</a></li>
                        <li class="breadcrumb-item">Historial de Movimientos</li>
                    </ul>
                </div>
                <div>
                    <a href="{{ route('admin.inventario.index') }}" class="btn btn-primary">
                        <i class="fas fa-arrow-left"></i> Volver al Inventario
                    </a>
                </div>
            </div>

            <!-- Acciones rápidas -->
            <div class="actions-container">
                <a href="{{ route('admin.inventario.movimientoForm', $producto->id_producto) }}" class="btn btn-info">
                    <i class="fas fa-plus"></i> Registrar Nuevo Movimiento
                </a>
                <a href="{{ route('admin.inventario.edit', $producto->id_producto) }}" class="btn btn-primary">
                    <i class="fas fa-edit"></i> Editar Producto
                </a>
            </div>

            <!-- Tarjeta de información del producto -->
            <div class="product-card">
                <div class="product-header">
                    <h2 class="product-name">
                        <i class="fas fa-box"></i> {{ $producto->nombre }}
                    </h2>
                    <div class="product-stats">
                        <div class="product-stat">
                            <span class="stat-label">Stock Actual</span>
                            <span class="stat-value">{{ $producto->cantidad }}</span>
                        </div>
                        <div class="product-stat">
                            <span class="stat-label">Stock Mínimo</span>
                            <span class="stat-value">{{ $producto->stock_minimo }}</span>
                        </div>
                        <div class="product-stat">
                            <span class="stat-label">Estado</span>
                            @if($producto->sinStock())
                                <span class="product-status">
                                    <i class="fas fa-exclamation-circle"></i> CRÍTICO
                                </span>
                            @elseif($producto->tieneStockBajo())
                                <span class="product-status">
                                    <i class="fas fa-exclamation-triangle"></i> BAJO STOCK
                                </span>
                            @else
                                <span class="product-status">
                                    <i class="fas fa-check-circle"></i> SUFICIENTE
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tabla de movimientos -->
            <div class="table-container">
                <div class="table-header">
                    <h3 class="table-title">
                        <i class="fas fa-history"></i> Historial de Movimientos
                    </h3>
                </div>
                @if($producto->movimientos->count() > 0)
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Fecha</th>
                                <th>Tipo</th>
                                <th>Cantidad</th>
                                <th>Descripción</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($producto->movimientos->sortByDesc('fecha') as $movimiento)
                                <tr>
                                    <td>{{ date('d/m/Y', strtotime($movimiento->fecha)) }}</td>
                                    <td>
                                        @if($movimiento->tipo == 'entrada')
                                            <span class="movement-type movement-in">
                                                <i class="fas fa-arrow-down"></i> Entrada
                                            </span>
                                        @else
                                            <span class="movement-type movement-out">
                                                <i class="fas fa-arrow-up"></i> Salida
                                            </span>
                                        @endif
                                    </td>
                                    <td>{{ $movimiento->cantidad }}</td>
                                    <td>{{ $movimiento->descripcion }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="no-movements">
                        <i class="fas fa-inbox"></i>
                        <p>No hay movimientos registrados para este producto</p>
                        <a href="{{ route('admin.inventario.movimientoForm', $producto->id_producto) }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Registrar Primer Movimiento
                        </a>
                    </div>
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