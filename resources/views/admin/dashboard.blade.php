<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Administrador</title>
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
            --bubble-size: 10px;
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
            position: relative;
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

        /* Nueva animación de carro en movimiento */
        .car-animation {
            position: relative;
            width: 200px;
            height: 80px;
            margin-bottom: 30px;
        }

        .moving-car {
            position: absolute;
            width: 120px;
            height: 40px;
            background-color: var(--primary-light);
            border-radius: 10px 30px 5px 5px;
            left: 0;
            top: 20px;
            animation: drivingCar 3s infinite linear;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
        }

        .moving-car::before {
            content: '';
            position: absolute;
            width: 30px;
            height: 15px;
            background-color: var(--accent);
            border-radius: 50% 50% 0 0;
            top: -15px;
            left: 30px;
        }

        .moving-car::after {
            content: '';
            position: absolute;
            width: 20px;
            height: 20px;
            background-color: #333;
            border-radius: 50%;
            bottom: -10px;
            left: 20px;
            box-shadow: 60px 0 0 #333;
        }

        .road {
            position: absolute;
            width: 100%;
            height: 5px;
            background-color: #555;
            bottom: 0;
            left: 0;
        }

        .road::before {
            content: '';
            position: absolute;
            width: 100%;
            height: 2px;
            background-color: #fff;
            top: 50%;
            left: 0;
            transform: translateY(-50%);
            background: repeating-linear-gradient(90deg, #fff, #fff 10px, transparent 10px, transparent 20px);
        }

        .exhaust {
            position: absolute;
            width: 10px;
            height: 5px;
            background-color: rgba(200, 200, 200, 0.7);
            border-radius: 5px;
            bottom: 5px;
            left: 5px;
            animation: smoke 0.5s infinite;
        }

        @keyframes drivingCar {
            0% {
                transform: translateX(-50px) translateY(0);
            }
            25% {
                transform: translateX(50px) translateY(-3px);
            }
            50% {
                transform: translateX(150px) translateY(0);
            }
            75% {
                transform: translateX(50px) translateY(3px);
            }
            100% {
                transform: translateX(-50px) translateY(0);
            }
        }

        @keyframes smoke {
            0% {
                opacity: 0.7;
                transform: translateX(-10px) translateY(0) scale(1);
            }
            100% {
                opacity: 0;
                transform: translateX(-20px) translateY(-5px) scale(2);
            }
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
            animation: loadProgress 3s forwards;
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

        @keyframes loadProgress {
            0% {
                width: 0;
            }
            20% {
                width: 20%;
            }
            50% {
                width: 50%;
            }
            80% {
                width: 80%;
            }
            100% {
                width: 100%;
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
            overflow-x: hidden; /* Evita el desplazamiento horizontal */
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

        /* Menú de opciones desplegable */
        .menu-item .menu-options {
            position: absolute;
            left: 100%;
            top: 0;
            width: 200px;
            background-color: var(--primary-light);
            border-radius: 0 5px 5px 0;
            box-shadow: 5px 0 15px rgba(0, 0, 0, 0.1);
            opacity: 0;
            visibility: hidden;
            transition: all var(--transition-speed) ease;
            transform: translateX(-10px);
            z-index: 10;
        }

        .menu-item:hover .menu-options {
            opacity: 1;
            visibility: visible;
            transform: translateX(0);
        }

        .menu-option {
            display: block;
            padding: 10px 15px;
            color: white;
            text-decoration: none;
            transition: all var(--transition-speed) ease;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .menu-option:hover {
            background-color: rgba(255, 255, 255, 0.1);
        }

        .menu-option i {
            margin-right: 8px;
            font-size: 16px;
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

        .header-action {
            background-color: var(--light);
            border: none;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all var(--transition-speed) ease;
            position: relative;
        }

        .header-action:hover {
            background-color: var(--gray-light);
        }

        .header-action i {
            font-size: 18px;
            color: var(--gray);
        }

        .notification-badge {
            position: absolute;
            top: -5px;
            right: -5px;
            background-color: var(--error);
            color: white;
            font-size: 10px;
            width: 18px;
            height: 18px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Alertas */
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

        /* Tarjetas de bienvenida y estadísticas */
        .welcome-card {
            background: linear-gradient(135deg, var(--primary), var(--primary-light));
            color: white;
            border-radius: 10px;
            padding: 25px;
            margin-bottom: 20px;
            box-shadow: 0 10px 25px rgba(0, 103, 179, 0.2);
            position: relative;
            overflow: hidden;
            animation: fadeInUp 0.5s forwards 0.5s;
            opacity: 0;
        }

        .welcome-card h2 {
            font-weight: 600;
            margin-bottom: 10px;
            font-size: 22px;
        }

        .welcome-card p {
            margin-bottom: 20px;
            opacity: 0.9;
            max-width: 600px;
        }

        .welcome-card .water-pattern {
            position: absolute;
            bottom: -20px;
            right: -20px;
            width: 200px;
            height: 200px;
            background: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><path d="M0,50 C20,35 35,20 50,0 C65,20 80,35 100,50 C80,65 65,80 50,100 C35,80 20,65 0,50 Z" fill="rgba(255,255,255,0.1)"/></svg>');
            background-size: cover;
            opacity: 0.2;
        }

        .welcome-actions {
            display: flex;
            gap: 15px;
        }

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

        .btn-white {
            background-color: white;
            color: var(--primary-dark);
        }

        .btn-white:hover {
            background-color: var(--light);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .btn-outline {
            background-color: transparent;
            border: 2px solid rgba(255, 255, 255, 0.8);
            color: white;
        }

        .btn-outline:hover {
            background-color: rgba(255, 255, 255, 0.1);
        }

        /* Tarjetas de estadísticas */
        .stats-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background-color: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            transition: all var(--transition-speed) ease;
            animation: fadeInUp 0.5s forwards;
            opacity: 0;
            display: flex;
            align-items: center;
            overflow: hidden;
            position: relative;
        }

        .stat-card:nth-child(1) { animation-delay: 0.6s; }
        .stat-card:nth-child(2) { animation-delay: 0.7s; }
        .stat-card:nth-child(3) { animation-delay: 0.8s; }
        .stat-card:nth-child(4) { animation-delay: 0.9s; }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }

        .stat-icon {
            font-size: 24px;
            width: 50px;
            height: 50px;
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            color: white;
            flex-shrink: 0;
        }

        .stat-content {
            flex: 1;
        }

        .stat-value {
            font-size: 24px;
            font-weight: 700;
            margin-bottom: 5px;
            background: linear-gradient(to right, var(--primary), var(--accent));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .stat-label {
            font-size: 14px;
            color: var(--gray);
            font-weight: 500;
        }

        .stat-bg-success { background-color: var(--success); }
        .stat-bg-primary { background-color: var(--primary); }
        .stat-bg-warning { background-color: var(--warning); }
        .stat-bg-info { background-color: var(--info); }

        .stat-change {
            font-size: 12px;
            margin-top: 5px;
            display: inline-flex;
            align-items: center;
            padding: 3px 8px;
            border-radius: 12px;
            font-weight: 500;
        }

        .stat-change.positive {
            background-color: rgba(76, 175, 80, 0.1);
            color: var(--success);
        }

        .stat-change.negative {
            background-color: rgba(244, 67, 54, 0.1);
            color: var(--error);
        }

        .stat-change i {
            font-size: 10px;
            margin-right: 3px;
        }

        /* Tarjetas de acciones principales */
        .modules-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .module-card {
            background-color: white;
            border-radius: 15px;
            padding: 20px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            transition: all var(--transition-speed) ease;
            position: relative;
            overflow: hidden;
            animation: fadeInUp 0.5s forwards;
            opacity: 0;
        }

        .module-card:nth-child(1) { animation-delay: 1.0s; }
        .module-card:nth-child(2) { animation-delay: 1.1s; }
        .module-card:nth-child(3) { animation-delay: 1.2s; }
        .module-card:nth-child(4) { animation-delay: 1.3s; }
        .module-card:nth-child(5) { animation-delay: 1.4s; }
        .module-card:nth-child(6) { animation-delay: 1.5s; }

        .module-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }

        .module-card:hover .module-icon {
            transform: scale(1.1) rotate(5deg);
        }

        .module-header {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
        }

        .module-icon {
            width: 45px;
            height: 45px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            color: white;
            font-size: 20px;
            flex-shrink: 0;
            transition: all var(--transition-speed) ease;
        }

        .module-card h3 {
            font-size: 18px;
            font-weight: 600;
            color: var(--dark);
            margin: 0;
        }

        .module-bg-1 { background: linear-gradient(135deg, #6B73FF, #000DFF); }
        .module-bg-2 { background: linear-gradient(135deg, #FF9950, #FC6B0A); }
        .module-bg-3 { background: linear-gradient(135deg, #4CAF50, #2E7D32); }
        .module-bg-4 { background: linear-gradient(135deg, #9C27B0, #6A1B9A); }
        .module-bg-5 { background: linear-gradient(135deg, #00BCD4, #00838F); }
        .module-bg-6 { background: linear-gradient(135deg, #F44336, #C62828); }

        .module-links {
            list-style: none;
        }

        .module-link {
            padding: 10px 15px;
            margin-bottom: 5px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            text-decoration: none;
            color: var(--gray-dark);
            transition: all var(--transition-speed) ease;
            font-weight: 500;
        }

        .module-link:hover {
            background-color: rgba(0, 0, 0, 0.03);
            color: var(--primary);
        }

        .module-link i {
            margin-right: 10px;
            color: var(--gray);
            transition: all var(--transition-speed) ease;
        }

        .module-link:hover i {
            color: var(--primary);
        }

        /* Botón de logout */
        .logout-container {
            margin-top: 20px;
            text-align: center;
            animation: fadeInUp 0.5s forwards 1.6s;
            opacity: 0;
        }

        .btn-logout {
            background-color: var(--error);
            color: white;
            padding: 10px 20px;
            border-radius: 8px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            font-weight: 500;
            transition: all var(--transition-speed) ease;
        }

        .btn-logout:hover {
            background-color: #d32f2f;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(244, 67, 54, 0.3);
        }

        .btn-logout i {
            margin-right: 8px;
        }

        /* Pantalla pequeña y responsive */
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

            .welcome-card .water-pattern {
                display: none;
            }
        }

        @media screen and (max-width: 767px) {
            .content-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 10px;
            }

            .header-actions {
                align-self: flex-end;
            }

            .welcome-actions {
                flex-direction: column;
                width: 100%;
            }

            .btn {
                width: 100%;
            }

            .stats-row {
                grid-template-columns: 1fr;
            }

            .modules-grid {
                grid-template-columns: 1fr;
            }
        }

        @media screen and (max-width: 480px) {
            .main-content {
                padding: 15px;
            }

            .welcome-card {
                padding: 20px;
            }

            .welcome-card h2 {
                font-size: 20px;
            }

            .stat-card {
                padding: 15px;
            }

            .module-card {
                padding: 15px;
            }
        }

        /* Tooltip para menú colapsado */
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

        /* Ajustes específicos para pantallas muy pequeñas */
        @media screen and (max-width: 360px) {
            .sidebar {
                width: 60px;
            }
            
            .sidebar .menu-item i {
                font-size: 16px;
            }
            
            .main-content {
                margin-left: 60px;
                padding: 10px;
            }
        }
    </style>
</head>
<body>
    <!-- Animación de carga inicial con carro en movimiento -->
    <div class="page-loader">
        <div class="loader-title">Service Center - Panel Administrativo</div>
        <div class="car-animation">
            <div class="moving-car">
                <div class="exhaust"></div>
            </div>
            <div class="road"></div>
        </div>
        <div class="loader-subtitle">Cargando panel de administración...</div>
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
                <a href="{{ route('admin.dashboard') }}" class="menu-item active">
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
                <a href="{{ route('admin.inventario.index') }}" class="menu-item ">
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
                    <h1 class="page-title">Dashboard</h1>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Inicio</a></li>
                        <li class="breadcrumb-item">Dashboard</li>
                    </ul>
                </div>
                <div class="header-actions">
                    <button class="header-action">
                        <i class="fas fa-bell"></i>
                        <span class="notification-badge">3</span>
                    </button>
                    <button class="header-action">
                        <i class="fas fa-cog"></i>
                    </button>
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

            <!-- Tarjeta de bienvenida -->
            <div class="welcome-card">
                <div class="water-pattern"></div>
                <h2>Bienvenido, {{ session('usuario')->nombre }}</h2>
                <p>Desde este panel de control puedes gestionar todos los aspectos de tu negocio de lavado de autos. Revisa las estadísticas, gestiona empleados, administra el inventario y mucho más.</p>
                <div class="welcome-actions">
                    <a href="{{ route('admin.reportes.dashboard') }}" class="btn btn-white">
                        <i class="fas fa-chart-bar"></i> Ver reportes
                    </a>
                    <a href="{{ route('admin.turnos') }}" class="btn btn-outline">
                        <i class="fas fa-calendar-alt"></i> Gestionar turnos
                    </a>
                </div>
            </div>

            <!-- Estadísticas rápidas -->
            <div class="stats-row">
                <div class="stat-card">
                    <div class="stat-icon stat-bg-success">
                        <i class="fas fa-car"></i>
                    </div>
                    <div class="stat-content">
                        <div class="stat-value">152</div>
                        <div class="stat-label">Lavados este mes</div>
                        <div class="stat-change positive">
                            <i class="fas fa-arrow-up"></i> 12.5%
                        </div>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon stat-bg-primary">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="stat-content">
                        <div class="stat-value">58</div>
                        <div class="stat-label">Clientes activos</div>
                        <div class="stat-change positive">
                            <i class="fas fa-arrow-up"></i> 8.3%
                        </div>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon stat-bg-warning">
                        <i class="fas fa-calendar-check"></i>
                    </div>
                    <div class="stat-content">
                        <div class="stat-value">24</div>
                        <div class="stat-label">Turnos pendientes</div>
                        <div class="stat-change negative">
                            <i class="fas fa-arrow-down"></i> 3.2%
                        </div>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon stat-bg-info">
                        <i class="fas fa-dollar-sign"></i>
                    </div>
                    <div class="stat-content">
                        <div class="stat-value">$4,250</div>
                        <div class="stat-label">Ingresos de hoy</div>
                        <div class="stat-change positive">
                            <i class="fas fa-arrow-up"></i> 15.8%
                        </div>
                    </div>
                </div>
            </div>

            <!-- Módulos principales -->
            <div class="modules-grid">
                <div class="module-card">
                    <div class="module-header">
                        <div class="module-icon module-bg-1">
                            <i class="fas fa-users"></i>
                        </div>
                        <h3>Empleados</h3>
                    </div>
                    <ul class="module-links">
                        <li><a href="{{ route('admin.empleados.index') }}" class="module-link">
                            <i class="fas fa-list"></i> Ver Empleados
                        </a></li>
                        <li><a href="{{ route('admin.empleados.create') }}" class="module-link">
                            <i class="fas fa-user-plus"></i> Añadir Empleado
                        </a></li>
                    </ul>
                </div>

                <div class="module-card">
                    <div class="module-header">
                        <div class="module-icon module-bg-2">
                            <i class="fas fa-boxes"></i>
                        </div>
                        <h3>Inventario</h3>
                    </div>
                    <ul class="module-links">
                        <li><a href="{{ route('admin.inventario.index') }}" class="module-link">
                            <i class="fas fa-list"></i> Ver Inventario
                        </a></li>
                        <li><a href="{{ route('admin.inventario.create') }}" class="module-link">
                            <i class="fas fa-plus-circle"></i> Añadir Producto
                        </a></li>
                        <li><a href="{{ route('admin.inventario.movimientoForm') }}" class="module-link">
                            <i class="fas fa-random"></i> Registrar Movimiento
                        </a></li>
                    </ul>
                </div>

                <div class="module-card">
                    <div class="module-header">
                        <div class="module-icon module-bg-3">
                            <i class="fas fa-calendar-alt"></i>
                        </div>
                        <h3>Turnos</h3>
                    </div>
                    <ul class="module-links">
                        <li><a href="{{ route('admin.turnos') }}" class="module-link">
                            <i class="fas fa-list-alt"></i> Gestionar Turnos
                        </a></li>
                        <li><a href="{{ route('admin.turnos.create') }}" class="module-link">
                            <i class="fas fa-plus-circle"></i> Crear Turno
                        </a></li>
                    </ul>
                </div>

                <div class="module-card">
                    <div class="module-header">
                        <div class="module-icon module-bg-4">
                            <i class="fas fa-car"></i>
                        </div>
                        <h3>Lavadas</h3>
                    </div>
                    <ul class="module-links">
                        <li><a href="{{ route('admin.lavadas.index') }}" class="module-link">
                            <i class="fas fa-list"></i> Gestión de Lavados
                        </a></li>
                        <li><a href="{{ route('admin.servicios.index') }}" class="module-link">
                            <i class="fas fa-cogs"></i> Gestión de Servicios
                        </a></li>
                    </ul>
                </div>

                <div class="module-card">
                    <div class="module-header">
                        <div class="module-icon module-bg-5">
                            <i class="fas fa-wallet"></i>
                        </div>
                        <h3>Comisiones</h3>
                    </div>
                    <ul class="module-links">
                        <li><a href="{{ route('admin.billetera.index') }}" class="module-link">
                            <i class="fas fa-money-bill-wave"></i> Gestionar Billeteras
                        </a></li>
                    </ul>
                </div>

                <div class="module-card">
                    <div class="module-header">
                        <div class="module-icon module-bg-6">
                            <i class="fas fa-chart-pie"></i>
                        </div>
                        <h3>Reportes</h3>
                    </div>
                    <ul class="module-links">
                        <li><a href="{{ route('admin.reportes.dashboard') }}" class="module-link">
                            <i class="fas fa-tachometer-alt"></i> Dashboard de Reportes
                        </a></li>
                        <li><a href="{{ route('admin.reportes.empleados') }}" class="module-link">
                            <i class="fas fa-users"></i> Reportes de Empleados
                        </a></li>
                        <li><a href="{{ route('admin.reportes.clientes') }}" class="module-link">
                            <i class="fas fa-user-friends"></i> Reportes de Clientes
                        </a></li>
                    </ul>
                </div>
            </div>

            <!-- Botón de Cerrar Sesión -->
            <div class="logout-container">
                <a href="{{ route('logout') }}" class="btn-logout">
                    <i class="fas fa-sign-out-alt"></i> Cerrar Sesión
                </a>
            </div>
        </main>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Simular carga y ocultar la animación de carga después de 3 segundos
            setTimeout(function() {
                document.querySelector('.page-loader').classList.add('hidden');
            }, 3000);

            // Toggle de la barra lateral con mejor manejo responsivo
            const sidebar = document.getElementById('sidebar');
            const toggleBtn = document.getElementById('toggleSidebar');
            const menuItems = document.querySelectorAll('.menu-item');

            toggleBtn.addEventListener('click', function() {
                sidebar.classList.toggle('collapsed');
                // Ajustar el contenido principal cuando cambia el estado de la barra lateral
                document.querySelector('.main-content').style.marginLeft = 
                    sidebar.classList.contains('collapsed') ? '70px' : '260px';
            });

            // Verificar y ajustar según el tamaño de la pantalla
            function checkWidth() {
                if (window.innerWidth <= 991) {
                    sidebar.classList.add('collapsed');
                    document.querySelector('.main-content').style.marginLeft = '70px';
                } else {
                    sidebar.classList.remove('collapsed');
                    document.querySelector('.main-content').style.marginLeft = '260px';
                }
            }

            // Verificar al cargar y al redimensionar
            checkWidth();
            window.addEventListener('resize', checkWidth);
        });
    </script>
</body>
</html>