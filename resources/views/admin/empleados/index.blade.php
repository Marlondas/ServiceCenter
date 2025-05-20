<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Empleados - Service Center</title>
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
        
        /* Ocultar barra de desplazamiento pero mantener funcionalidad */
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
            flex-wrap: wrap;
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
            transform: translateY(-2px);
        }

        .btn-success {
            background-color: var(--success);
            color: white;
        }

        .btn-success:hover {
            background-color: #3d8b40;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            transform: translateY(-2px);
        }

        .btn-danger {
            background-color: var(--error);
            color: white;
        }

        .btn-danger:hover {
            background-color: #c9302c;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            transform: translateY(-2px);
        }

        .btn-sm {
            padding: 6px 15px;
            font-size: 13px;
        }

        /* Tarjetas de empleados */
        .employee-cards {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
            margin-top: 20px;
            animation: fadeInUp 0.5s forwards 0.3s;
            opacity: 0;
        }

        .employee-card {
            background-color: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            transition: all var(--transition-speed) ease;
            position: relative;
        }

        .employee-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
        }

        .employee-header {
            position: relative;
            padding: 20px 20px 70px 20px;
            background: linear-gradient(45deg, var(--primary), var(--primary-light));
            color: white;
        }

        .employee-name {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 5px;
        }

        .employee-email {
            font-size: 14px;
            color: rgba(255, 255, 255, 0.8);
            margin-bottom: 10px;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .employee-avatar {
            position: absolute;
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background-color: white;
            bottom: -40px;
            right: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
            border: 4px solid white;
            overflow: hidden;
            transition: all var(--transition-speed) ease;
        }

        .employee-avatar i {
            font-size: 32px;
            color: var(--primary);
        }

        .employee-card:hover .employee-avatar {
            transform: scale(1.1);
        }

        .employee-content {
            padding: 30px 20px 20px;
        }

        .employee-details {
            margin-bottom: 20px;
        }

        .employee-detail {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
        }

        .employee-detail:last-child {
            margin-bottom: 0;
        }

        .detail-icon {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background-color: rgba(0, 103, 179, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 10px;
            flex-shrink: 0;
        }

        .detail-icon i {
            font-size: 16px;
            color: var(--primary);
        }

        .detail-content {
            flex: 1;
        }

        .detail-label {
            font-size: 12px;
            color: var(--gray);
            margin-bottom: 2px;
        }

        .detail-value {
            font-size: 14px;
            font-weight: 500;
            color: var(--dark);
        }

        .commission-badge {
            display: inline-flex;
            align-items: center;
            padding: 3px 10px;
            border-radius: 20px;
            background-color: rgba(0, 103, 179, 0.1);
            color: var(--primary);
            font-size: 13px;
            font-weight: 600;
        }

        .commission-badge i {
            margin-right: 5px;
            font-size: 12px;
        }

        .employee-actions {
            display: flex;
            gap: 10px;
            padding-top: 15px;
            border-top: 1px solid var(--gray-light);
        }

        .employee-actions .btn {
            flex: 1;
            font-size: 13px;
        }

        /* Vista de tabla para pantallas más grandes */
        .employee-table-container {
            background-color: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            margin-top: 20px;
            animation: fadeInUp 0.5s forwards 0.3s;
            opacity: 0;
            display: none;
        }

        .employee-table {
            width: 100%;
            border-collapse: collapse;
        }

        .employee-table th {
            background-color: var(--light);
            color: var(--primary-dark);
            font-weight: 600;
            text-align: left;
            padding: 15px;
            border-bottom: 2px solid var(--gray-light);
        }

        .employee-table td {
            padding: 15px;
            border-bottom: 1px solid var(--gray-light);
            vertical-align: middle;
        }

        .employee-table tr:last-child td {
            border-bottom: none;
        }

        .employee-table tr:hover {
            background-color: rgba(0, 103, 179, 0.02);
        }

        .table-actions {
            display: flex;
            gap: 8px;
        }

        /* Botón de cambio de vista */
        .view-toggle {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 20px;
            animation: fadeIn 0.5s forwards 0.2s;
            opacity: 0;
        }

        .view-btn {
            padding: 8px 15px;
            border-radius: 8px;
            background-color: var(--light);
            color: var(--gray);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all var(--transition-speed) ease;
            border: none;
            font-family: 'Poppins', sans-serif;
        }

        .view-btn i {
            margin-right: 5px;
        }

        .view-btn.active {
            background-color: var(--primary);
            color: white;
            box-shadow: 0 3px 10px rgba(0, 103, 179, 0.2);
        }

        /* Botón flotante para añadir empleado (visible en móviles) */
        .floating-btn {
            position: fixed;
            bottom: 20px;
            right: 20px;
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background-color: var(--success);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
            cursor: pointer;
            z-index: 99;
            transition: all var(--transition-speed) ease;
        }

        .floating-btn i {
            font-size: 24px;
        }

        .floating-btn:hover {
            transform: scale(1.1);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
        }

        /* Estado vacío */
        .empty-state {
            padding: 60px 20px;
            text-align: center;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            margin-top: 20px;
            animation: fadeInUp 0.5s forwards 0.3s;
            opacity: 0;
        }

        .empty-state i {
            font-size: 60px;
            color: var(--gray-light);
            margin-bottom: 20px;
        }

        .empty-state h3 {
            font-size: 20px;
            font-weight: 600;
            color: var(--gray-dark);
            margin-bottom: 10px;
        }

        .empty-state p {
            color: var(--gray);
            margin-bottom: 20px;
            max-width: 400px;
            margin-left: auto;
            margin-right: auto;
        }

        /* Animaciones adicionales */
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

        @keyframes pulse {
            0% {
                box-shadow: 0 0 0 0 rgba(0, 103, 179, 0.4);
            }
            70% {
                box-shadow: 0 0 0 10px rgba(0, 103, 179, 0);
            }
            100% {
                box-shadow: 0 0 0 0 rgba(0, 103, 179, 0);
            }
        }

        /* Media queries para responsividad */
        @media screen and (min-width: 992px) {
            .employee-table-container {
                display: block;
            }
            
            .employee-cards {
                display: none;
            }
            
            .view-btn[data-view="table"].active ~ .employee-table-container {
                display: block;
            }
            
            .view-btn[data-view="cards"].active ~ .employee-cards {
                display: grid;
            }
        }

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
        }

        @media screen and (max-width: 768px) {
            .employee-cards {
                grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            }
        }

        @media screen and (max-width: 576px) {
            .employee-cards {
                grid-template-columns: 1fr;
            }

            .main-content {
                padding: 15px;
            }

            .content-header {
                padding: 15px;
            }

            .page-title {
                font-size: 20px;
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
        <div class="loader-subtitle">Cargando Gestión de Empleados...</div>
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
                <a href="{{ route('admin.empleados.index') }}" class="menu-item active">
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
                    <h1 class="page-title">Gestión de Empleados</h1>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item">Empleados</li>
                    </ul>
                </div>
                <div>
                    <a href="{{ route('admin.empleados.create') }}" class="btn btn-success">
                        <i class="fas fa-user-plus"></i> Añadir Nuevo Empleado
                    </a>
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

            <!-- Toggle de vista (tarjetas o tabla) - visible sólo en pantallas grandes -->
            <div class="view-toggle">
                <button class="view-btn active" data-view="table" id="tableViewBtn">
                    <i class="fas fa-list"></i> Vista de Tabla
                </button>
                <button class="view-btn" data-view="cards" id="cardsViewBtn">
                    <i class="fas fa-th-large"></i> Vista de Tarjetas
                </button>
            </div>

            <!-- Contenido según si hay empleados o no -->
            @if(count($empleados) > 0)
                <!-- Vista de tabla (por defecto en pantallas grandes) -->
                <div class="employee-table-container">
                    <table class="employee-table">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Correo</th>
                                <th>Cargo</th>
                                <th>Comisión (%)</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($empleados as $empleado)
                                <tr>
                                    <td>{{ $empleado->usuario->nombre }}</td>
                                    <td>{{ $empleado->usuario->correo }}</td>
                                    <td>{{ $empleado->cargo }}</td>
                                    <td>
                                        <span class="commission-badge">
                                            <i class="fas fa-percentage"></i> {{ $empleado->comision }}%
                                        </span>
                                    </td>
                                    <td>
                                        <div class="table-actions">
                                            <a href="{{ route('admin.empleados.edit', $empleado->id_empleado) }}" class="btn btn-primary btn-sm">
                                                <i class="fas fa-edit"></i> Editar
                                            </a>
                                            
                                            <form action="{{ route('admin.empleados.destroy', $empleado->id_empleado) }}" method="POST" style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de eliminar este empleado? Esta acción también eliminará su cuenta de usuario.')">
                                                    <i class="fas fa-trash"></i> Eliminar
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Vista de tarjetas (por defecto en pantallas pequeñas) -->
                <div class="employee-cards">
                    @foreach($empleados as $empleado)
                        <div class="employee-card">
                            <div class="employee-header">
                                <h3 class="employee-name">{{ $empleado->usuario->nombre }}</h3>
                                <p class="employee-email">{{ $empleado->usuario->correo }}</p>
                                <div class="employee-avatar">
                                    <i class="fas fa-user"></i>
                                </div>
                            </div>
                            <div class="employee-content">
                                <div class="employee-details">
                                    <div class="employee-detail">
                                        <div class="detail-icon">
                                            <i class="fas fa-briefcase"></i>
                                        </div>
                                        <div class="detail-content">
                                            <span class="detail-label">Cargo</span>
                                            <span class="detail-value">{{ $empleado->cargo }}</span>
                                        </div>
                                    </div>
                                    <div class="employee-detail">
                                        <div class="detail-icon">
                                            <i class="fas fa-wallet"></i>
                                        </div>
                                        <div class="detail-content">
                                            <span class="detail-label">Comisión</span>
                                            <span class="detail-value">
                                                <span class="commission-badge">
                                                    <i class="fas fa-percentage"></i> {{ $empleado->comision }}%
                                                </span>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="employee-actions">
                                    <a href="{{ route('admin.empleados.edit', $empleado->id_empleado) }}" class="btn btn-primary btn-sm">
                                        <i class="fas fa-edit"></i> Editar
                                    </a>
                                    
                                    <form action="{{ route('admin.empleados.destroy', $empleado->id_empleado) }}" method="POST" style="flex: 1;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" style="width: 100%;" onclick="return confirm('¿Estás seguro de eliminar este empleado? Esta acción también eliminará su cuenta de usuario.')">
                                            <i class="fas fa-trash"></i> Eliminar
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <!-- Estado vacío cuando no hay empleados -->
                <div class="empty-state">
                    <i class="fas fa-users"></i>
                    <h3>No hay empleados registrados</h3>
                    <p>Añade tu primer empleado para comenzar a gestionar el personal de tu negocio.</p>
                    <a href="{{ route('admin.empleados.create') }}" class="btn btn-success">
                        <i class="fas fa-user-plus"></i> Añadir Primer Empleado
                    </a>
                </div>
            @endif

            <!-- Botón flotante para añadir empleado (visible en móviles) -->
            <a href="{{ route('admin.empleados.create') }}" class="floating-btn">
                <i class="fas fa-user-plus"></i>
            </a>
        </main>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Animación de carga inicial
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
            
            // Ejecutar al cargar y al redimensionar
            checkScreenSize();
            window.addEventListener('resize', checkScreenSize);
            
            // Toggle vista de tarjetas/tabla
            const tableViewBtn = document.getElementById('tableViewBtn');
            const cardsViewBtn = document.getElementById('cardsViewBtn');
            const tableContainer = document.querySelector('.employee-table-container');
            const cardsContainer = document.querySelector('.employee-cards');
            
            tableViewBtn.addEventListener('click', function() {
                tableViewBtn.classList.add('active');
                cardsViewBtn.classList.remove('active');
                tableContainer.style.display = 'block';
                cardsContainer.style.display = 'none';
            });
            
            cardsViewBtn.addEventListener('click', function() {
                cardsViewBtn.classList.add('active');
                tableViewBtn.classList.remove('active');
                cardsContainer.style.display = 'grid';
                tableContainer.style.display = 'none';
            });
            
            // Inicializar la vista según el tamaño de pantalla
            if (window.innerWidth < 992) {
                cardsViewBtn.click();
            } else {
                tableViewBtn.click();
            }
        });
    </script>
</body>
</html>