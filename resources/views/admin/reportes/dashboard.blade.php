<!DOCTYPE html>
<html lang="es">
<head>
    <title>Dashboard de Reportes - Service Center</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            /* Paleta de colores para lavadero de autos */
            --primary: #0055b3;
            --primary-light: #3d8dff;
            --primary-dark: #003b7a;
            --secondary: #00c2ff;
            --accent: #19e6ff;
            --success: #00d67f;
            --error: #ff3b5c;
            --warning: #ffb300;
            --info: #00b3e6;
            --light: #f0f8ff;
            --dark: #102a43;
            --gray: #64748b;
            --gray-light: #e9f2ff;
            --gray-dark: #334155;
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
            background-color: #f5f9ff;
            background-image: 
                radial-gradient(circle at 10% 20%, rgba(0, 122, 255, 0.03) 0%, rgba(0, 122, 255, 0) 20%),
                radial-gradient(circle at 90% 80%, rgba(0, 194, 255, 0.03) 0%, rgba(0, 194, 255, 0) 20%);
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
            background: linear-gradient(145deg, var(--primary-dark), var(--primary));
            color: white;
            transition: all var(--transition-speed) ease;
            position: fixed;
            top: 0;
            left: 0;
            height: 100%;
            z-index: 100;
            box-shadow: 0 0 30px rgba(0, 0, 0, 0.15);
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

        /* Contenedor principal del dashboard */
        .container {
            max-width: 1200px;
            margin: 0 auto;
            background-color: transparent;
            padding: 0;
            border-radius: 0;
            box-shadow: none;
        }

        /* Header del contenido principal */
        .dashboard-header {
            background-color: white;
            border-radius: 16px;
            padding: 25px;
            margin-bottom: 25px;
            box-shadow: 0 10px 25px rgba(0, 55, 179, 0.1);
            position: relative;
            overflow: hidden;
            animation: slideDown 0.5s forwards;
        }

        /* Efecto de burbuja de agua para el header */
        .dashboard-header::before {
            content: '';
            position: absolute;
            top: -50px;
            right: -50px;
            width: 100px;
            height: 100px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(0, 194, 255, 0.2) 0%, rgba(0, 194, 255, 0) 70%);
            z-index: 0;
        }

        .dashboard-header::after {
            content: '';
            position: absolute;
            bottom: -30px;
            left: 30px;
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(0, 194, 255, 0.15) 0%, rgba(0, 194, 255, 0) 70%);
            z-index: 0;
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

        h1 {
            color: var(--primary-dark);
            border-bottom: none;
            padding-bottom: 10px;
            font-size: 28px;
            font-weight: 600;
            position: relative;
            z-index: 1;
        }

        h1::after {
            content: '';
            display: block;
            width: 40px;
            height: 4px;
            background: linear-gradient(to right, var(--primary), var(--secondary));
            border-radius: 2px;
            margin-top: 8px;
        }

        /* Navegación con tabs */
        .nav-tabs {
            display: flex;
            border-bottom: 1px solid var(--gray-light);
            margin-bottom: 25px;
            flex-wrap: wrap;
            position: relative;
            z-index: 1;
        }

        .nav-link {
            padding: 12px 20px;
            text-decoration: none;
            color: var(--gray);
            background-color: transparent;
            border: none;
            border-radius: 0;
            margin-right: 5px;
            position: relative;
            transition: all 0.3s ease;
            font-weight: 500;
            display: flex;
            align-items: center;
        }

        .nav-link i {
            margin-right: 8px;
            font-size: 18px;
        }

        .nav-link::after {
            content: '';
            position: absolute;
            width: 0;
            height: 3px;
            bottom: -1px;
            left: 0;
            background: linear-gradient(to right, var(--primary), var(--secondary));
            transition: width 0.3s ease;
        }

        .nav-link:hover {
            color: var(--primary);
        }

        .nav-link:hover::after {
            width: 100%;
        }

        .nav-link.active {
            color: var(--primary);
            background-color: transparent;
            border-bottom: none;
            font-weight: 600;
        }

        .nav-link.active::after {
            width: 100%;
        }

        /* Sección de filtros */
        .filters {
            background-color: white;
            padding: 20px;
            border-radius: 16px;
            margin-bottom: 25px;
            box-shadow: 0 10px 25px rgba(0, 55, 179, 0.1);
            position: relative;
            overflow: hidden;
            animation: slideUp 0.5s forwards;
        }

        @keyframes slideUp {
            from {
                transform: translateY(20px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .form-group {
            margin-bottom: 15px;
            position: relative;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: var(--dark);
            font-size: 0.9rem;
        }

        /* Estilos para inputs */
        input[type="date"], 
        select {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid var(--gray-light);
            background-color: rgba(245, 249, 255, 0.5);
            border-radius: 12px;
            font-size: 15px;
            font-family: 'Poppins', sans-serif;
            color: var(--dark);
            transition: all 0.3s cubic-bezier(0.165, 0.84, 0.44, 1);
            box-shadow: 0 3px 10px rgba(0, 55, 179, 0.03);
        }

        /* Efecto de focus para inputs */
        input:focus,
        select:focus {
            border-color: var(--primary-light);
            background-color: white;
            box-shadow: 0 5px 15px rgba(0, 55, 179, 0.1);
            outline: none;
        }

        /* Animación para hover en inputs */
        input:hover,
        select:hover {
            border-color: var(--primary-light);
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 12px 25px;
            border-radius: 50px;
            color: white;
            text-decoration: none;
            font-weight: 500;
            font-size: 15px;
            transition: all 0.3s cubic-bezier(0.165, 0.84, 0.44, 1);
            cursor: pointer;
            border: none;
            font-family: 'Poppins', sans-serif;
            position: relative;
            overflow: hidden;
            background: linear-gradient(145deg, var(--primary), var(--primary-dark));
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            z-index: 1;
        }

        .btn i {
            margin-right: 8px;
            font-size: 16px;
        }

        .btn::after {
            content: '';
            position: absolute;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.3) 0%, rgba(255, 255, 255, 0) 70%);
            transform: scale(0);
            transition: transform 0.5s cubic-bezier(0.165, 0.84, 0.44, 1);
            z-index: -1;
        }

        .btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(0, 55, 179, 0.2);
        }

        .btn:hover::after {
            transform: scale(2.5);
        }

        /* Tarjetas de KPI */
        .kpi-container {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
            margin-bottom: 30px;
        }

        .kpi-card {
            background: linear-gradient(145deg, #ffffff, #f5f9ff);
            border-radius: 16px;
            box-shadow: 0 10px 25px rgba(0, 55, 179, 0.08);
            padding: 25px;
            text-align: center;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            animation: fadeInUp 0.5s forwards;
            animation-delay: calc(var(--animation-order) * 0.1s);
            opacity: 0;
            transform: translateY(20px);
        }

        .kpi-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 15px 35px rgba(0, 55, 179, 0.15);
        }

        /* Efecto de gota de agua */
        .kpi-card::after {
            content: '';
            position: absolute;
            width: 15px;
            height: 15px;
            border-radius: 50%;
            background-color: rgba(0, 194, 255, 0.2);
            top: -8px;
            right: 40px;
            animation: dropletFall 4s infinite;
            animation-delay: calc(var(--animation-order) * 0.5s);
        }

        @keyframes dropletFall {
            0% {
                transform: translateY(0) scale(1);
                opacity: 0.8;
            }
            80% {
                transform: translateY(60px) scale(1.2);
                opacity: 0;
            }
            100% {
                transform: translateY(60px) scale(1.2);
                opacity: 0;
            }
        }

        .kpi-title {
            font-size: 0.9em;
            color: var(--gray);
            margin-bottom: 15px;
            font-weight: 500;
        }

        .kpi-value {
            font-size: 2.2em;
            font-weight: 700;
            color: var(--primary);
            position: relative;
            display: inline-block;
            background: linear-gradient(to right, var(--primary), var(--secondary));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .kpi-card:nth-child(2) .kpi-value {
            background: linear-gradient(to right, var(--primary-dark), var(--primary));
        }

        .kpi-card:nth-child(3) .kpi-value {
            background: linear-gradient(to right, var(--success), #7affb2);
        }

        .kpi-card:nth-child(4) .kpi-value {
            background: linear-gradient(to right, var(--warning), #ffd900);
        }

        /* Contenedores de gráficas */
        .chart-container {
            background-color: white;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 10px 25px rgba(0, 55, 179, 0.08);
            margin-bottom: 25px;
            padding: 25px;
            position: relative;
            animation: fadeInUp 0.5s forwards;
            animation-delay: calc(var(--animation-order) * 0.1s);
            opacity: 0;
            transform: translateY(20px);
            transition: all 0.3s ease;
        }

        .chart-container:hover {
            box-shadow: 0 15px 35px rgba(0, 55, 179, 0.15);
            transform: translateY(-5px);
        }

        .chart-title {
            font-size: 1.2em;
            font-weight: 600;
            margin-bottom: 20px;
            color: var(--primary-dark);
            position: relative;
            padding-left: 15px;
        }

        .chart-title::before {
            content: '';
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
            height: 18px;
            width: 4px;
            background: linear-gradient(to bottom, var(--primary), var(--secondary));
            border-radius: 2px;
        }

        .chart {
            height: 300px;
            position: relative;
        }

        /* Animación para gráficas al cargar */
        .chart canvas {
            animation: fadeInUp 0.8s ease;
        }

        /* Efecto de agua en gráficas */
        .chart::after {
            content: '';
            position: absolute;
            bottom: -20px;
            right: -20px;
            width: 100px;
            height: 100px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(0, 194, 255, 0.05) 0%, rgba(0, 194, 255, 0) 70%);
            z-index: 0;
            pointer-events: none;
        }

        /* Media queries para responsividad */
        @media screen and (max-width: 1200px) {
            .kpi-container {
                grid-template-columns: repeat(2, 1fr);
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
        }

        @media screen and (max-width: 768px) {
            .main-content {
                padding: 15px;
            }
            
            .dashboard-header {
                padding: 20px;
            }
            
            h1 {
                font-size: 24px;
            }
            
            .kpi-container {
                grid-template-columns: 1fr;
            }
            
            .chart-container {
                min-width: 100%;
            }
        }

        @media screen and (max-width: 576px) {
            .main-content {
                padding: 10px;
            }
            
            .dashboard-header {
                padding: 15px;
            }
            
            .filters form > div {
                flex-direction: column;
            }
            
            .form-group {
                width: 100%;
            }
            
            .nav-tabs {
                overflow-x: auto;
                white-space: nowrap;
                padding-bottom: 5px;
            }
            
            .nav-link {
                padding: 10px 15px;
            }
        }
    </style>
</head>
<body>
    <!-- Animación de carga inicial con silueta de carro avanzando -->
    <div class="page-loader">
        <div class="loader-title">Car Wash Premium <span style="color: var(--accent);">Panel Administrativo</span></div>
        <div class="car-animation">
            <div class="moving-car">
                <div class="car-silhouette"></div>
            </div>
            <div class="road"></div>
        </div>
        <div class="loader-subtitle">Cargando Dashboard de Reportes...</div>
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
                    <span>Car<span>Wash</span></span>
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
                <a href="{{ route('admin.inventario.index') }}" class="menu-item">
                    <i class="fas fa-boxes"></i>
                    <span>Inventario</span>
                    <div class="menu-tooltip">Inventario</div>
                </a>
                
                <div class="menu-label">Reportes y Análisis</div>
                <a href="{{ route('admin.reportes.dashboard') }}" class="menu-item active">
                    <i class="fas fa-chart-line"></i>
                    <span>Reportes</span>
                    <div class="menu-tooltip">Reportes</div>
                </a>
            </div>
        </aside>

        <!-- Contenido principal -->
        <main class="main-content">
            <div class="container">
                <!-- Header del dashboard -->
                <div class="dashboard-header">
                    <h1>Dashboard de Reportes</h1>
                    
                    <div class="nav-tabs">
                        <a href="{{ route('admin.reportes.dashboard') }}" class="nav-link active">
                            <i class="fas fa-chart-pie"></i> Dashboard
                        </a>
                        <a href="{{ route('admin.reportes.empleados') }}" class="nav-link">
                            <i class="fas fa-users"></i> Empleados
                        </a>
                        <a href="{{ route('admin.reportes.clientes') }}" class="nav-link">
                            <i class="fas fa-user-friends"></i> Clientes
                        </a>
                        <a href="{{ route('admin.reportes.servicios') }}" class="nav-link">
                            <i class="fas fa-car-wash"></i> Servicios
                        </a>
                        <a href="{{ route('admin.dashboard') }}" class="nav-link">
                            <i class="fas fa-arrow-left"></i> Volver a Admin
                        </a>
                    </div>
                </div>
                
                <!-- Filtros -->
                <div class="filters">
                    <form method="GET" action="{{ route('admin.reportes.dashboard') }}">
                        <div style="display: flex; gap: 15px; flex-wrap: wrap;">
                            <div class="form-group" style="flex: 1; min-width: 200px;">
                                <label for="periodo">
                                    <i class="fas fa-calendar-check" style="margin-right: 5px; color: var(--primary);"></i>
                                    Período Predefinido:
                                </label>
                                <select id="periodo" name="periodo" onchange="this.form.submit()">
                                    <option value="">Personalizado</option>
                                    <option value="hoy" {{ request('periodo') == 'hoy' ? 'selected' : '' }}>Hoy</option>
                                    <option value="semana" {{ request('periodo') == 'semana' ? 'selected' : '' }}>Esta Semana</option>
                                    <option value="mes" {{ request('periodo') == 'mes' ? 'selected' : '' }}>Este Mes</option>
                                    <option value="año" {{ request('periodo') == 'año' ? 'selected' : '' }}>Este Año</option>
                                </select>
                            </div>
                            <div class="form-group" style="flex: 1; min-width: 150px;">
                                <label for="desde">
                                    <i class="fas fa-calendar-day" style="margin-right: 5px; color: var(--primary);"></i>
                                    Desde:
                                </label>
                                <input type="date" id="desde" name="desde" value="{{ $desde->format('Y-m-d') }}">
                            </div>
                            <div class="form-group" style="flex: 1; min-width: 150px;">
                                <label for="hasta">
                                    <i class="fas fa-calendar-day" style="margin-right: 5px; color: var(--primary);"></i>
                                    Hasta:
                                </label>
                                <input type="date" id="hasta" name="hasta" value="{{ $hasta->format('Y-m-d') }}">
                            </div>
                            <div class="form-group" style="align-self: flex-end; flex: 0 0 auto;">
                                <button type="submit" class="btn">
                                    <i class="fas fa-filter"></i> Filtrar
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                
                <!-- KPIs con animaciones -->
                <div class="kpi-container">
                    <div class="kpi-card" style="--animation-order: 1;">
                        <div class="kpi-title">Total Ingresos</div>
                        <div class="kpi-value">${{ number_format($data['ingresos'], 0, '.', ',') }}</div>
                    </div>
                    <div class="kpi-card" style="--animation-order: 2;">
                        <div class="kpi-title">Total Servicios</div>
                        <div class="kpi-value">{{ $data['totalServicios'] }}</div>
                    </div>
                    <div class="kpi-card" style="--animation-order: 3;">
                        <div class="kpi-title">Calificación Promedio</div>
                        <div class="kpi-value">{{ number_format($data['promedio_calificacion'], 1) }}</div>
                    </div>
                    <div class="kpi-card" style="--animation-order: 4;">
                        <div class="kpi-title">Promedio Diario</div>
                        <div class="kpi-value">${{ number_format($data['ingresos'] / max(1, $desde->diffInDays($hasta)), 0, '.', ',') }}</div>
                    </div>
                </div>
                
                <!-- Gráficos con animaciones -->
                <div style="display: flex; flex-wrap: wrap; gap: 20px;">
                    <div class="chart-container" style="flex: 1; min-width: 450px; --animation-order: 5;">
                        <div class="chart-title">Ingresos por Día</div>
                        <div class="chart">
                            <canvas id="ingresosPorDiaChart"></canvas>
                        </div>
                    </div>
                    
                    <div class="chart-container" style="flex: 1; min-width: 450px; --animation-order: 6;">
                        <div class="chart-title">Servicios Más Populares</div>
                        <div class="chart">
                            <canvas id="serviciosPopularesChart"></canvas>
                        </div>
                    </div>
                </div>
                
                <div style="display: flex; flex-wrap: wrap; gap: 20px;">
                    <div class="chart-container" style="flex: 1; min-width: 450px; --animation-order: 7;">
                        <div class="chart-title">Servicios por Tipo de Vehículo</div>
                        <div class="chart">
                            <canvas id="tiposVehiculoChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
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
            
            // Datos para gráficos
            const ingresosPorDia = @json($data['serviciosPorDia'] ?? []);
            const serviciosPopulares = @json($data['servicios_populares'] ?? []);
            const serviciosPorTipoVehiculo = @json($data['servicios_por_tipo_vehiculo'] ?? []);
            
            // Paleta de colores para gráficas
            const primaryColor = '#0055b3';
            const secondaryColor = '#00c2ff';
            const accentColor = '#19e6ff';
            const successColor = '#00d67f';
            const warningColor = '#ffb300';
            const errorColor = '#ff3b5c';
            
            // Degradados para gráficas
            const createGradient = (ctx, colorStart, colorEnd) => {
                const gradient = ctx.createLinearGradient(0, 0, 0, 400);
                gradient.addColorStop(0, colorStart);
                gradient.addColorStop(1, colorEnd);
                return gradient;
            };
            
            // Gráfico de ingresos por día con animación
            const ingresosPorDiaCtx = document.getElementById('ingresosPorDiaChart').getContext('2d');
            new Chart(ingresosPorDiaCtx, {
                type: 'line',
                data: {
                    labels: ingresosPorDia.map(item => item.dia),
                    datasets: [{
                        label: 'Ingresos',
                        data: ingresosPorDia.map(item => item.ingresos),
                        backgroundColor: function() {
                            return createGradient(ingresosPorDiaCtx, 'rgba(0, 194, 255, 0.2)', 'rgba(0, 194, 255, 0)');
                        }(),
                        borderColor: secondaryColor,
                        borderWidth: 3,
                        pointBackgroundColor: primaryColor,
                        pointBorderColor: 'white',
                        pointBorderWidth: 2,
                        pointRadius: 5,
                        pointHoverRadius: 7,
                        tension: 0.4 // Línea curva
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            backgroundColor: 'rgba(16, 42, 67, 0.8)',
                            titleFont: {
                                family: 'Poppins',
                                size: 14
                            },
                            bodyFont: {
                                family: 'Poppins',
                                size: 13
                            },
                            padding: 15,
                            cornerRadius: 10,
                            boxPadding: 10,
                            callbacks: {
                                label: function(context) {
                                    return '$' + context.parsed.y.toLocaleString();
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: 'rgba(0, 0, 0, 0.05)'
                            },
                            ticks: {
                                callback: function(value) {
                                    return '$' + value.toLocaleString();
                                },
                                font: {
                                    family: 'Poppins',
                                    size: 12
                                }
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            },
                            ticks: {
                                font: {
                                    family: 'Poppins',
                                    size: 12
                                }
                            }
                        }
                    },
                    animation: {
                        duration: 2000,
                        easing: 'easeOutQuart'
                    }
                }
            });
            
            // Gráfico de servicios populares
            const serviciosPopularesCtx = document.getElementById('serviciosPopularesChart').getContext('2d');
            new Chart(serviciosPopularesCtx, {
                type: 'bar',
                data: {
                    labels: serviciosPopulares.map(item => item.nombre),
                    datasets: [{
                        label: 'Cantidad',
                        data: serviciosPopulares.map(item => item.total),
                        backgroundColor: function() {
                            return createGradient(serviciosPopularesCtx, 'rgba(0, 85, 179, 0.8)', 'rgba(0, 194, 255, 0.8)');
                        }(),
                        borderWidth: 0,
                        borderRadius: 8,
                        maxBarThickness: 40
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            backgroundColor: 'rgba(16, 42, 67, 0.8)',
                            titleFont: {
                                family: 'Poppins',
                                size: 14
                            },
                            bodyFont: {
                                family: 'Poppins',
                                size: 13
                            },
                            padding: 15,
                            cornerRadius: 10,
                            boxPadding: 10
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: 'rgba(0, 0, 0, 0.05)'
                            },
                            ticks: {
                                font: {
                                    family: 'Poppins',
                                    size: 12
                                }
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            },
                            ticks: {
                                font: {
                                    family: 'Poppins',
                                    size: 12
                                }
                            }
                        }
                    },
                    animation: {
                        delay: function(context) {
                            return context.dataIndex * 100;
                        },
                        duration: 1000,
                        easing: 'easeOutQuart'
                    }
                }
            });
            
            // Gráfico de tipos de vehículo
            const tiposVehiculoCtx = document.getElementById('tiposVehiculoChart').getContext('2d');
            new Chart(tiposVehiculoCtx, {
                type: 'doughnut',
                data: {
                    labels: serviciosPorTipoVehiculo.map(item => item.tipo),
                    datasets: [{
                        data: serviciosPorTipoVehiculo.map(item => item.total),
                        backgroundColor: [
                            primaryColor,
                            secondaryColor,
                            accentColor,
                            successColor,
                            warningColor
                        ],
                        borderWidth: 5,
                        borderColor: 'white',
                        hoverBorderColor: 'white',
                        hoverBorderWidth: 8,
                        hoverOffset: 15
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'right',
                            labels: {
                                font: {
                                    family: 'Poppins',
                                    size: 13
                                },
                                padding: 20,
                                usePointStyle: true,
                                pointStyle: 'circle'
                            }
                        },
                        tooltip: {
                            backgroundColor: 'rgba(16, 42, 67, 0.8)',
                            titleFont: {
                                family: 'Poppins',
                                size: 14
                            },
                            bodyFont: {
                                family: 'Poppins',
                                size: 13
                            },
                            padding: 15,
                            cornerRadius: 10,
                            boxPadding: 10
                        }
                    },
                    animation: {
                        animateRotate: true,
                        animateScale: true,
                        duration: 2000,
                        easing: 'easeOutQuart'
                    },
                    cutout: '60%'
                }
            });
        });
    </script>
</body>
</html>