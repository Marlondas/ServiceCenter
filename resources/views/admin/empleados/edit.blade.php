<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Empleado - Service Center</title>
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
            --edit-color: #ff9800; /* Color naranja para edición */
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
            color: var(--edit-color);
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

        /* Formulario moderno y animado */
        .form-container {
            background-color: white;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            margin-bottom: 20px;
            animation: fadeInUp 0.5s forwards 0.3s;
            opacity: 0;
            position: relative;
            overflow: hidden;
        }

        .form-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 5px;
            background: linear-gradient(to right, var(--edit-color), var(--primary));
            border-radius: 15px 15px 0 0;
        }

        .form-header {
            margin-bottom: 25px;
            position: relative;
        }

        .form-section-title {
            font-size: 20px;
            font-weight: 600;
            color: var(--edit-color);
            margin-bottom: 5px;
            display: flex;
            align-items: center;
            position: relative;
        }

        .form-section-title i {
            margin-right: 10px;
            font-size: 24px;
            color: var(--edit-color);
        }

        .form-section-subtitle {
            color: var(--gray);
            font-size: 14px;
            margin-left: 34px;
        }

        .form-divider {
            height: 1px;
            background-color: var(--gray-light);
            margin: 30px 0;
            position: relative;
        }

        .form-divider::before {
            content: '';
            position: absolute;
            top: -15px;
            left: 0;
            width: 30px;
            height: 30px;
            background-color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 1px solid var(--gray-light);
            z-index: 1;
        }

        .form-divider span {
            position: absolute;
            top: -10px;
            left: 15px;
            transform: translateX(-50%);
            background-color: white;
            padding: 0 10px;
            color: var(--gray);
            font-size: 14px;
        }

        .form-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 25px;
            position: relative;
        }

        .form-group:last-child {
            margin-bottom: 0;
        }

        .form-floating {
            position: relative;
        }

        .form-floating .form-control {
            height: 55px;
            padding: 20px 15px 10px;
        }

        .form-floating .form-label {
            position: absolute;
            top: 0;
            left: 15px;
            height: 100%;
            padding: 18px 0;
            pointer-events: none;
            border: 1px solid transparent;
            transform-origin: 0 0;
            transition: opacity .1s ease-in-out, transform .1s ease-in-out;
            color: var(--gray);
        }

        .form-floating .form-control:focus,
        .form-floating .form-control:not(:placeholder-shown) {
            padding-top: 25px;
            padding-bottom: 5px;
        }

        .form-floating .form-control:focus ~ .form-label,
        .form-floating .form-control:not(:placeholder-shown) ~ .form-label {
            opacity: .65;
            transform: scale(.85) translateY(-0.5rem) translateX(0.15rem);
            color: var(--edit-color);
        }

        .form-floating .form-control:focus {
            border-color: var(--edit-color);
            box-shadow: 0 0 0 3px rgba(255, 152, 0, 0.1);
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
            padding: 12px 15px;
            border: 1px solid var(--gray-light);
            border-radius: 8px;
            font-family: 'Poppins', sans-serif;
            font-size: 14px;
            transition: all var(--transition-speed) ease;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--edit-color);
            box-shadow: 0 0 0 3px rgba(255, 152, 0, 0.1);
        }

        .form-text {
            display: block;
            margin-top: 6px;
            font-size: 12px;
            color: var(--gray);
        }

        .form-error-list {
            background-color: rgba(244, 67, 54, 0.05);
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 20px;
            border-left: 4px solid var(--error);
        }

        .form-error-list ul {
            margin: 0;
            padding-left: 15px;
        }

        .form-error-list li {
            color: var(--error);
            margin-bottom: 5px;
        }

        .form-error-list li:last-child {
            margin-bottom: 0;
        }

        /* Elementos de formulario personalizados */
        .input-group {
            position: relative;
            display: flex;
            align-items: stretch;
            width: 100%;
        }

        .input-group .form-control {
            position: relative;
            flex: 1 1 auto;
            width: 1%;
            min-width: 0;
        }

        .input-group-text {
            display: flex;
            align-items: center;
            padding: 0 15px;
            font-size: 14px;
            font-weight: 500;
            color: var(--dark);
            text-align: center;
            white-space: nowrap;
            background-color: var(--light);
            border: 1px solid var(--gray-light);
            border-radius: 8px;
            border-top-right-radius: 0;
            border-bottom-right-radius: 0;
        }

        .input-group .form-control:not(:first-child) {
            border-top-left-radius: 0;
            border-bottom-left-radius: 0;
        }

        .input-group:focus-within .input-group-text {
            border-color: var(--edit-color);
        }

        /* Toggle de contraseña */
        .password-toggle {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: var(--gray);
            z-index: 10;
        }

        /* Botones de acción estilizados */
        .form-actions {
            display: flex;
            gap: 15px;
            margin-top: 30px;
        }

        .btn {
            padding: 12px 25px;
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

        .btn-edit {
            background-color: var(--edit-color);
            color: white;
        }

        .btn-edit:hover {
            background-color: #e68a00;
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

        /* Vista previa del empleado */
        .preview-card {
            background-color: white;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            animation: fadeInUp 0.5s forwards 0.5s;
            opacity: 0;
            overflow: hidden;
            width: 100%;
            margin-bottom: 30px;
            transition: all var(--transition-speed) ease;
        }

        .preview-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        }

        .preview-header {
            position: relative;
            padding: 20px 20px 60px 20px;
            background: linear-gradient(45deg, var(--edit-color), var(--primary));
            color: white;
        }

        .preview-title {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 5px;
            display: flex;
            align-items: center;
        }

        .preview-title i {
            margin-right: 10px;
        }

        .preview-subtitle {
            font-size: 14px;
            color: rgba(255, 255, 255, 0.8);
        }

        .preview-avatar {
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

        .preview-avatar i {
            font-size: 32px;
            color: var(--edit-color);
        }

        .preview-body {
            padding: 30px 20px 20px;
        }

        .preview-content {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
        }

        .preview-item {
            background-color: var(--light);
            padding: 15px;
            border-radius: 10px;
            position: relative;
            overflow: hidden;
            transition: all var(--transition-speed) ease;
        }

        .preview-item:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }

        .preview-item::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 5px;
            height: 100%;
            background-color: var(--edit-color);
        }

        .preview-item-title {
            font-size: 14px;
            font-weight: 600;
            color: var(--edit-color);
            margin-bottom: 5px;
        }

        .preview-item-value {
            font-size: 16px;
            color: var(--dark);
        }

        .preview-commission {
            font-weight: 600;
            color: var(--edit-color);
        }

        /* Animaciones adicionales */
        @keyframes pulse {
            0% {
                transform: scale(1);
            }
            50% {
                transform: scale(1.05);
            }
            100% {
                transform: scale(1);
            }
        }

        .btn-edit:hover {
            animation: pulse 1s infinite;
        }

        /* Media queries para responsividad */
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

            .form-container {
                padding: 20px;
            }

            .preview-content {
                grid-template-columns: 1fr;
            }
        }

        @media screen and (max-width: 768px) {
            .form-row {
                grid-template-columns: 1fr;
            }

            .form-actions {
                flex-direction: column;
            }
            
            .btn {
                width: 100%;
            }
        }

        @media screen and (max-width: 576px) {
            .main-content {
                padding: 15px;
            }

            .content-header {
                padding: 15px;
            }

            .page-title {
                font-size: 20px;
            }

            .preview-header {
                padding: 15px 15px 60px 15px;
            }

            .preview-body {
                padding: 30px 15px 15px;
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
        <div class="loader-subtitle">Cargando Formulario de Edición...</div>
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
                    <h1 class="page-title">Editar Empleado</h1>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.empleados.index') }}">Empleados</a></li>
                        <li class="breadcrumb-item">Editar Empleado</li>
                    </ul>
                </div>
                <div>
                    <a href="{{ route('admin.empleados.index') }}" class="btn btn-primary">
                        <i class="fas fa-arrow-left"></i> Volver a Empleados
                    </a>
                </div>
            </div>

            <!-- Errores de validación -->
            @if ($errors->any())
                <div class="form-error-list">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Vista previa del empleado que se está editando -->
            <div class="preview-card" id="preview-card">
                <div class="preview-header">
                    <h3 class="preview-title">
                        <i class="fas fa-user-edit"></i> Vista Previa del Empleado
                    </h3>
                    <p class="preview-subtitle">Información actual con los cambios aplicados</p>
                    <div class="preview-avatar">
                        <i class="fas fa-user"></i>
                    </div>
                </div>
                <div class="preview-body">
                    <div class="preview-content">
                        <div class="preview-item">
                            <div class="preview-item-title">Nombre Completo</div>
                            <div class="preview-item-value" id="preview-nombre">{{ old('nombre', $empleado->usuario->nombre) }}</div>
                        </div>
                        <div class="preview-item">
                            <div class="preview-item-title">Correo Electrónico</div>
                            <div class="preview-item-value" id="preview-correo">{{ old('correo', $empleado->usuario->correo) }}</div>
                        </div>
                        <div class="preview-item">
                            <div class="preview-item-title">Cargo</div>
                            <div class="preview-item-value" id="preview-cargo">{{ old('cargo', $empleado->cargo) }}</div>
                        </div>
                        <div class="preview-item">
                            <div class="preview-item-title">Comisión</div>
                            <div class="preview-item-value">
                                <span class="preview-commission" id="preview-comision">{{ old('comision', $empleado->comision) }}%</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Formulario de edición de empleado -->
            <div class="form-container">
                <form action="{{ route('admin.empleados.update', $empleado->id_empleado) }}" method="POST" id="employee-form">
                    @csrf
                    @method('PUT')
                    
                    <!-- Sección de información de usuario -->
                    <div class="form-header">
                        <h2 class="form-section-title">
                            <i class="fas fa-user-circle"></i> Información de Usuario
                        </h2>
                        <p class="form-section-subtitle">Datos básicos de la cuenta de usuario</p>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <div class="form-floating">
                                <input type="text" class="form-control" id="nombre" name="nombre" value="{{ old('nombre', $empleado->usuario->nombre) }}" placeholder=" " required>
                                <label for="nombre" class="form-label">Nombre Completo</label>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <div class="form-floating">
                                <input type="email" class="form-control" id="correo" name="correo" value="{{ old('correo', $empleado->usuario->correo) }}" placeholder=" " required>
                                <label for="correo" class="form-label">Correo Electrónico</label>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <div class="form-floating" style="position: relative;">
                                <input type="password" class="form-control" id="contraseña" name="contraseña" placeholder=" ">
                                <label for="contraseña" class="form-label">Nueva Contraseña</label>
                                <span class="password-toggle" id="password-toggle">
                                    <i class="fas fa-eye" id="password-icon"></i>
                                </span>
                            </div>
                            <span class="form-text">Dejar en blanco para mantener la contraseña actual</span>
                        </div>
                    </div>
                    
                    <!-- Divider entre secciones -->
                    <div class="form-divider">
                        <span>Perfil Empleado</span>
                    </div>
                    
                    <!-- Sección de información de empleado -->
                    <div class="form-header">
                        <h2 class="form-section-title">
                            <i class="fas fa-id-badge"></i> Información de Empleado
                        </h2>
                        <p class="form-section-subtitle">Datos relacionados con el rol y compensación del empleado</p>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <div class="form-floating">
                                <input type="text" class="form-control" id="cargo" name="cargo" value="{{ old('cargo', $empleado->cargo) }}" placeholder=" " required>
                                <label for="cargo" class="form-label">Cargo</label>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="comision" class="form-label">Comisión (%)</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-percentage"></i></span>
                                <input type="number" class="form-control" id="comision" name="comision" value="{{ old('comision', $empleado->comision) }}" min="0" max="100" step="0.01" required>
                            </div>
                            <span class="form-text">Porcentaje de comisión por servicio (0-100)</span>
                        </div>
                    </div>
                    
                    <div class="form-actions">
                        <button type="submit" class="btn btn-edit">
                            <i class="fas fa-sync-alt"></i> Actualizar Empleado
                        </button>
                        <a href="{{ route('admin.empleados.index') }}" class="btn btn-danger">
                            <i class="fas fa-times"></i> Cancelar
                        </a>
                    </div>
                </form>
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
            
            // Toggle de contraseña
            const passwordField = document.getElementById('contraseña');
            const passwordToggle = document.getElementById('password-toggle');
            const passwordIcon = document.getElementById('password-icon');
            
            passwordToggle.addEventListener('click', function() {
                const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordField.setAttribute('type', type);
                
                // Cambiar el ícono
                if (type === 'text') {
                    passwordIcon.classList.remove('fa-eye');
                    passwordIcon.classList.add('fa-eye-slash');
                } else {
                    passwordIcon.classList.remove('fa-eye-slash');
                    passwordIcon.classList.add('fa-eye');
                }
            });
            
            // Vista previa del empleado
            const nombreInput = document.getElementById('nombre');
            const correoInput = document.getElementById('correo');
            const cargoInput = document.getElementById('cargo');
            const comisionInput = document.getElementById('comision');
            
            const previewNombre = document.getElementById('preview-nombre');
            const previewCorreo = document.getElementById('preview-correo');
            const previewCargo = document.getElementById('preview-cargo');
            const previewComision = document.getElementById('preview-comision');
            
            function actualizarVistaPrevia() {
                previewNombre.textContent = nombreInput.value || '-';
                previewCorreo.textContent = correoInput.value || '-';
                previewCargo.textContent = cargoInput.value || '-';
                previewComision.textContent = comisionInput.value ? `${comisionInput.value}%` : '-';
            }
            
            // Actualizar la vista previa en tiempo real
            nombreInput.addEventListener('input', actualizarVistaPrevia);
            correoInput.addEventListener('input', actualizarVistaPrevia);
            cargoInput.addEventListener('input', actualizarVistaPrevia);
            comisionInput.addEventListener('input', actualizarVistaPrevia);
            
            // Inicializar la vista previa
            actualizarVistaPrevia();
        });
    </script>
</body>
</html>