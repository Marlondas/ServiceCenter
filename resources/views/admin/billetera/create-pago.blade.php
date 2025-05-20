<!DOCTYPE html>
<html lang="es">
<head>
    <title>Registrar Pago</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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

        /* Header del contenido principal */
        .content-header {
            background-color: white;
            border-radius: 16px;
            padding: 25px;
            margin-bottom: 25px;
            box-shadow: 0 10px 25px rgba(0, 55, 179, 0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: relative;
            overflow: hidden;
            animation: slideDown 0.5s forwards;
        }

        /* Efecto de burbuja de agua para el header */
        .content-header::before {
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

        .content-header::after {
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

        .page-title {
            font-size: 28px;
            font-weight: 600;
            color: var(--primary-dark);
            position: relative;
            z-index: 1;
        }

        .page-title::after {
            content: '';
            display: block;
            width: 40px;
            height: 4px;
            background: linear-gradient(to right, var(--primary), var(--secondary));
            border-radius: 2px;
            margin-top: 8px;
        }

        .breadcrumb {
            display: flex;
            align-items: center;
            list-style: none;
            flex-wrap: wrap;
            position: relative;
            z-index: 1;
        }

        .breadcrumb-item {
            font-size: 14px;
            color: var(--gray);
        }

        .breadcrumb-item a {
            color: var(--primary);
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .breadcrumb-item a:hover {
            color: var(--secondary);
        }

        .breadcrumb-item + .breadcrumb-item::before {
            content: '/';
            margin: 0 8px;
            color: var(--gray-light);
        }

        /* Estilos específicos para Registrar Pago */
        .nav-links {
            margin-bottom: 25px;
            display: flex;
            flex-wrap: wrap;
        }

        .nav-link {
            text-decoration: none;
            color: var(--primary);
            margin-right: 20px;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            transition: all 0.3s ease;
        }

        .nav-link i {
            margin-right: 7px;
        }

        .nav-link:hover {
            color: var(--secondary);
            transform: translateX(3px);
        }

        /* Información del empleado */
        .info-box {
            background: linear-gradient(145deg, #ffffff, #f5f9ff);
            padding: 25px;
            border-radius: 16px;
            margin-bottom: 30px;
            box-shadow: 0 5px 15px rgba(0, 55, 179, 0.08);
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .info-box:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(0, 55, 179, 0.12);
        }

        /* Efecto de goteo para info-box */
        .info-box::after {
            content: '';
            position: absolute;
            width: 15px;
            height: 15px;
            border-radius: 50%;
            background-color: rgba(0, 194, 255, 0.2);
            top: -8px;
            right: 40px;
            animation: dropletFall 4s infinite 1s;
        }

        @keyframes dropletFall {
            0% {
                transform: translateY(0) scale(1);
                opacity: 0.8;
            }
            80% {
                transform: translateY(80px) scale(1.2);
                opacity: 0;
            }
            100% {
                transform: translateY(80px) scale(1.2);
                opacity: 0;
            }
        }

        .info-item {
            position: relative;
            display: flex;
            align-items: center;
            margin-bottom: 15px;
        }

        .info-item:last-child {
            margin-bottom: 0;
        }

        .info-icon {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            background: linear-gradient(145deg, var(--primary-light), var(--primary));
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            box-shadow: 0 5px 10px rgba(0, 55, 179, 0.15);
            flex-shrink: 0;
        }

        .info-icon i {
            font-size: 20px;
            color: white;
        }

        .info-icon.success {
            background: linear-gradient(145deg, var(--success), #00b368);
        }

        .info-content {
            flex: 1;
        }

        .info-label {
            font-weight: 500;
            margin-right: 5px;
            font-size: 0.9rem;
            color: var(--gray);
        }

        .info-value {
            font-size: 1.1em;
            color: var(--dark);
            font-weight: 500;
        }

        .info-value-large {
            font-size: 1.8em;
            font-weight: 700;
            color: var(--success);
            display: block;
            margin-top: 5px;
        }

        /* Formulario con efectos de agua */
        .form-container {
            background-color: white;
            border-radius: 16px;
            padding: 30px;
            box-shadow: 0 10px 25px rgba(0, 55, 179, 0.1);
            position: relative;
            overflow: hidden;
        }

        /* Efecto de ondas de agua para formularios */
        .form-container::before {
            content: '';
            position: absolute;
            top: -60px;
            right: -60px;
            width: 120px;
            height: 120px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(0, 194, 255, 0.1) 0%, rgba(0, 194, 255, 0) 70%);
            z-index: 0;
        }

        .form-container::after {
            content: '';
            position: absolute;
            bottom: -40px;
            left: -40px;
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(0, 194, 255, 0.05) 0%, rgba(0, 194, 255, 0) 70%);
            z-index: 0;
        }

        .form-inner {
            position: relative;
            z-index: 1;
        }

        .form-group {
            margin-bottom: 25px;
            position: relative;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: var(--gray-dark);
            display: flex;
            align-items: center;
        }

        label i {
            margin-right: 8px;
            color: var(--primary);
            font-size: 16px;
        }

        /* Estilos para inputs */
        input[type="text"],
        input[type="number"],
        input[type="date"],
        textarea {
            width: 100%;
            padding: 15px;
            border: 2px solid var(--gray-light);
            background-color: rgba(245, 249, 255, 0.5);
            border-radius: 12px;
            font-size: 16px;
            font-family: 'Poppins', sans-serif;
            color: var(--dark);
            transition: all 0.3s cubic-bezier(0.165, 0.84, 0.44, 1);
            box-shadow: 0 3px 10px rgba(0, 55, 179, 0.03);
        }

        /* Efecto de focus para inputs */
        input:focus,
        textarea:focus {
            border-color: var(--primary-light);
            background-color: white;
            box-shadow: 0 5px 15px rgba(0, 55, 179, 0.1);
            outline: none;
        }

        /* Animación para hover en inputs */
        input:hover,
        textarea:hover {
            border-color: var(--primary-light);
        }

        textarea {
            height: 120px;
            resize: vertical;
        }

        small {
            display: block;
            margin-top: 8px;
            color: var(--gray);
            font-size: 0.85rem;
        }

        .error {
            color: var(--error);
            font-size: 0.875rem;
            margin-top: 8px;
            display: flex;
            align-items: center;
        }

        .error::before {
            content: '\f071'; /* Icono de advertencia */
            font-family: 'Font Awesome 6 Free';
            font-weight: 900;
            margin-right: 6px;
            font-size: 14px;
        }

        /* Botones */
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 12px 25px;
            border-radius: 50px;
            color: white;
            text-decoration: none;
            margin-right: 10px;
            font-weight: 500;
            font-size: 15px;
            transition: all 0.3s cubic-bezier(0.165, 0.84, 0.44, 1);
            cursor: pointer;
            border: none;
            font-family: 'Poppins', sans-serif;
            position: relative;
            overflow: hidden;
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

        .btn:hover::after {
            transform: scale(2.5);
        }

        .btn-primary {
            background: linear-gradient(145deg, var(--primary), var(--primary-dark));
        }

        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(0, 55, 179, 0.2);
        }

        .btn-secondary {
            background: linear-gradient(145deg, var(--gray), var(--gray-dark));
        }

        .btn-secondary:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(100, 116, 139, 0.2);
        }

        /* Alerta de error */
        .error-alert {
            background-color: rgba(255, 59, 92, 0.1);
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 25px;
            display: flex;
            align-items: center;
            box-shadow: 0 5px 15px rgba(255, 59, 92, 0.1);
            position: relative;
            overflow: hidden;
        }

        .error-alert i {
            font-size: 24px;
            color: var(--error);
            margin-right: 15px;
        }

        .error-alert p {
            color: var(--error);
            font-weight: 600;
        }

        /* Efectos de burbujas para el formulario */
        .form-bubbles {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: 0;
            overflow: hidden;
        }

        .bubble {
            position: absolute;
            background: radial-gradient(circle, rgba(0, 194, 255, 0.08) 0%, rgba(0, 194, 255, 0) 70%);
            border-radius: 50%;
        }

        .bubble:nth-child(1) {
            width: 80px;
            height: 80px;
            top: 20%;
            right: 10%;
            animation: floatBubble 8s ease-in-out infinite;
        }

        .bubble:nth-child(2) {
            width: 60px;
            height: 60px;
            bottom: 30%;
            left: 5%;
            animation: floatBubble 6s ease-in-out infinite 1s;
        }

        .bubble:nth-child(3) {
            width: 40px;
            height: 40px;
            bottom: 20%;
            right: 20%;
            animation: floatBubble 7s ease-in-out infinite 2s;
        }

        @keyframes floatBubble {
            0%, 100% {
                transform: translateY(0) scale(1);
            }
            50% {
                transform: translateY(-15px) scale(1.05);
            }
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
        }

        @media screen and (max-width: 768px) {
            .main-content {
                padding: 15px;
            }
            
            .content-header {
                padding: 20px;
            }
            
            .btn {
                padding: 10px 15px;
                font-size: 14px;
            }

            .btn-container {
                display: flex;
                flex-direction: column;
                gap: 10px;
                width: 100%;
            }

            .btn-container .btn {
                margin: 0;
                width: 100%;
            }
        }

        @media screen and (max-width: 576px) {
            .main-content {
                padding: 10px;
            }
            
            .content-header {
                padding: 15px;
            }
            
            .page-title {
                font-size: 22px;
            }
            
            .info-box {
                padding: 15px;
            }
            
            .form-container {
                padding: 20px;
            }
            
            label {
                font-size: 0.9rem;
            }
            
            input[type="text"],
            input[type="number"],
            input[type="date"],
            textarea {
                padding: 12px;
                font-size: 15px;
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
        <div class="loader-subtitle">Cargando Registro de Pago...</div>
        <div class="progress-container">
            <div class="progress-bar"></div>
        </div>
    </div>

    <div class="dashboard-container">
        <!-- Barra lateral - Mantener exactamente igual que en el primer documento -->
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
                <a href="{{ route('admin.billetera.index') }}" class="menu-item active">
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
                    <h1 class="page-title">Registrar Pago a Empleado</h1>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="fas fa-home"></i> Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.billetera.index') }}">Billeteras</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.billetera.show', $empleado->id_empleado) }}">{{ $empleado->usuario->nombre ?? 'Empleado #' . $empleado->id_empleado }}</a></li>
                        <li class="breadcrumb-item">Registrar Pago</li>
                    </ul>
                </div>
            </div>
            
            <div class="nav-links">
                <a href="{{ route('admin.billetera.show', $empleado->id_empleado) }}" class="nav-link">
                    <i class="fas fa-arrow-left"></i> Volver a Billetera del Empleado
                </a>
            </div>
            
            <div class="info-box">
                <div class="info-item">
                    <div class="info-icon">
                        <i class="fas fa-user"></i>
                    </div>
                    <div class="info-content">
                        <span class="info-label">Empleado:</span>
                        <span class="info-value">{{ $empleado->usuario->nombre ?? 'Empleado #' . $empleado->id_empleado }}</span>
                    </div>
                </div>
                <div class="info-item">
                    <div class="info-icon success">
                        <i class="fas fa-wallet"></i>
                    </div>
                    <div class="info-content">
                        <span class="info-label">Saldo Disponible:</span>
                        <span class="info-value-large">${{ number_format($saldoPendiente, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>
            
            @if($saldoPendiente <= 0)
                <div class="error-alert">
                    <i class="fas fa-exclamation-circle"></i>
                    <p>No hay saldo pendiente de pago para este empleado.</p>
                </div>
            @else
                <div class="form-container">
                    <div class="form-bubbles">
                        <div class="bubble"></div>
                        <div class="bubble"></div>
                        <div class="bubble"></div>
                    </div>
                    
                    <div class="form-inner">
                        <form action="{{ route('admin.billetera.store-pago', $empleado->id_empleado) }}" method="POST">
                            @csrf
                            
                            <div class="form-group">
                                <label for="monto_comision">
                                    <i class="fas fa-dollar-sign"></i> Monto a Pagar ($):
                                </label>
                                <input type="number" id="monto_comision" name="monto_comision" value="{{ old('monto_comision', $saldoPendiente) }}" min="0" max="{{ $saldoPendiente }}" step="1000" required>
                                <small>Valor máximo: ${{ number_format($saldoPendiente, 0, ',', '.') }}</small>
                                @error('monto_comision')
                                    <div class="error">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="form-group">
                                <label for="fecha">
                                    <i class="fas fa-calendar-alt"></i> Fecha:
                                </label>
                                <input type="date" id="fecha" name="fecha" value="{{ old('fecha', date('Y-m-d')) }}" required>
                                @error('fecha')
                                    <div class="error">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="form-group">
                                <label for="concepto">
                                    <i class="fas fa-sticky-note"></i> Concepto (Opcional):
                                </label>
                                <textarea id="concepto" name="concepto" placeholder="Describe el motivo del pago...">{{ old('concepto') }}</textarea>
                                @error('concepto')
                                    <div class="error">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="btn-container" style="display: flex; gap: 15px; flex-wrap: wrap;">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Registrar Pago
                                </button>
                                <a href="{{ route('admin.billetera.show', $empleado->id_empleado) }}" class="btn btn-secondary">
                                    <i class="fas fa-times"></i> Cancelar
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            @endif
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
        });
    </script>
</body>
</html>