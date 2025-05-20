<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Movimiento - Service Center</title>
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

        /* Formulario */
        .form-container {
            background-color: white;
            border-radius: 10px;
            padding: 30px;
            margin-bottom: 20px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            position: relative;
            animation: fadeInUp 0.5s forwards 0.2s;
            opacity: 0;
        }

        .form-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 5px;
            background: linear-gradient(to right, var(--info), var(--primary));
            border-radius: 10px 10px 0 0;
        }

        .form-header {
            margin-bottom: 25px;
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .form-icon {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background-color: rgba(33, 150, 243, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .form-icon i {
            font-size: 24px;
            color: var(--info);
        }

        .form-title-group {
            flex: 1;
        }

        .form-title {
            font-size: 20px;
            font-weight: 600;
            color: var(--dark);
            margin-bottom: 5px;
        }

        .form-subtitle {
            font-size: 14px;
            color: var(--gray);
        }

        .form-group {
            margin-bottom: 25px;
            position: relative;
        }

        .form-label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            font-size: 14px;
            color: var(--dark);
            display: flex;
            align-items: center;
        }

        .form-label i {
            margin-right: 8px;
            color: var(--primary);
            font-size: 15px;
        }

        .form-control {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid var(--gray-light);
            border-radius: 8px;
            font-family: 'Poppins', sans-serif;
            font-size: 14px;
            transition: all 0.3s ease;
            background-color: var(--light);
        }

        .form-control:focus {
            border-color: var(--info);
            box-shadow: 0 0 0 3px rgba(33, 150, 243, 0.1);
            outline: none;
            background-color: white;
        }

        .form-select {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid var(--gray-light);
            border-radius: 8px;
            font-family: 'Poppins', sans-serif;
            font-size: 14px;
            transition: all 0.3s ease;
            background-color: var(--light);
            appearance: none;
            background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="%236c757d"><path d="M7 10l5 5 5-5z"/></svg>');
            background-repeat: no-repeat;
            background-position: right 15px center;
        }

        .form-select:focus {
            border-color: var(--info);
            box-shadow: 0 0 0 3px rgba(33, 150, 243, 0.1);
            outline: none;
            background-color: white;
        }

        .form-textarea {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid var(--gray-light);
            border-radius: 8px;
            font-family: 'Poppins', sans-serif;
            font-size: 14px;
            transition: all 0.3s ease;
            background-color: var(--light);
            min-height: 120px;
            resize: vertical;
        }

        .form-textarea:focus {
            border-color: var(--info);
            box-shadow: 0 0 0 3px rgba(33, 150, 243, 0.1);
            outline: none;
            background-color: white;
        }

        .form-text {
            display: block;
            margin-top: 6px;
            font-size: 12px;
            color: var(--gray);
        }

        .form-errors {
            background-color: rgba(244, 67, 54, 0.05);
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 20px;
        }

        .form-errors ul {
            margin: 0;
            padding-left: 15px;
        }

        .form-errors li {
            color: var(--error);
            margin-bottom: 5px;
        }

        .form-actions {
            display: flex;
            gap: 15px;
            margin-top: 30px;
        }

        /* Tipos de movimiento */
        .movement-types {
            display: flex;
            gap: 15px;
            margin-bottom: 25px;
        }

        .movement-type-option {
            flex: 1;
            position: relative;
        }

        .movement-type-input {
            position: absolute;
            opacity: 0;
            width: 0;
            height: 0;
        }

        .movement-type-label {
            display: block;
            padding: 15px;
            background-color: var(--light);
            border: 2px solid var(--gray-light);
            border-radius: 10px;
            cursor: pointer;
            text-align: center;
            transition: all 0.3s ease;
        }

        .movement-type-icon {
            font-size: 24px;
            margin-bottom: 10px;
            color: var(--gray);
            transition: all 0.3s ease;
        }

        .movement-type-text {
            font-weight: 500;
            color: var(--gray);
            transition: all 0.3s ease;
        }

        .movement-type-input:checked + .movement-type-label {
            border-color: var(--info);
            background-color: rgba(33, 150, 243, 0.05);
        }

        .movement-type-input:checked + .movement-type-label .movement-type-icon,
        .movement-type-input:checked + .movement-type-label .movement-type-text {
            color: var(--info);
        }

        .movement-type-input[value="entrada"]:checked + .movement-type-label {
            border-color: var(--success);
            background-color: rgba(76, 175, 80, 0.05);
        }

        .movement-type-input[value="entrada"]:checked + .movement-type-label .movement-type-icon,
        .movement-type-input[value="entrada"]:checked + .movement-type-label .movement-type-text {
            color: var(--success);
        }

        .movement-type-input[value="salida"]:checked + .movement-type-label {
            border-color: var(--error);
            background-color: rgba(244, 67, 54, 0.05);
        }

        .movement-type-input[value="salida"]:checked + .movement-type-label .movement-type-icon,
        .movement-type-input[value="salida"]:checked + .movement-type-label .movement-type-text {
            color: var(--error);
        }

        /* Botones */
        .btn {
            padding: 12px 25px;
            border-radius: 50px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
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

        .btn-info {
            background-color: var(--info);
            color: white;
        }

        .btn-info:hover {
            background-color: #0b7dda;
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

        /* Vista previa del movimiento */
        .preview-card {
            background-color: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            margin-top: 30px;
            opacity: 0;
            animation: fadeInUp 0.5s forwards 0.4s;
        }

        .preview-header {
            background: linear-gradient(to right, var(--info), var(--primary));
            color: white;
            padding: 20px;
            display: flex;
            align-items: center;
        }

        .preview-title {
            font-size: 18px;
            font-weight: 600;
        }

        .preview-title i {
            margin-right: 10px;
        }

        .preview-body {
            padding: 20px;
        }

        .preview-row {
            display: flex;
            margin-bottom: 15px;
            padding-bottom: 15px;
            border-bottom: 1px dashed var(--gray-light);
            align-items: center;
        }

        .preview-row:last-child {
            margin-bottom: 0;
            padding-bottom: 0;
            border-bottom: none;
        }

        .preview-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            flex-shrink: 0;
        }

        .preview-icon.type-icon {
            background-color: rgba(33, 150, 243, 0.1);
        }

        .preview-icon.type-icon i {
            color: var(--info);
        }

        .preview-icon.product-icon {
            background-color: rgba(76, 175, 80, 0.1);
        }

        .preview-icon.product-icon i {
            color: var(--success);
        }

        .preview-icon.quantity-icon {
            background-color: rgba(255, 152, 0, 0.1);
        }

        .preview-icon.quantity-icon i {
            color: var(--warning);
        }

        .preview-content {
            flex: 1;
        }

        .preview-label {
            font-size: 12px;
            color: var(--gray);
            margin-bottom: 2px;
        }

        .preview-value {
            font-size: 16px;
            font-weight: 600;
            color: var(--dark);
        }

        .preview-badge {
            display: inline-flex;
            align-items: center;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 600;
        }

        .preview-badge i {
            margin-right: 5px;
            font-size: 11px;
        }

        .preview-badge-entrada {
            background-color: rgba(76, 175, 80, 0.1);
            color: var(--success);
        }

        .preview-badge-salida {
            background-color: rgba(244, 67, 54, 0.1);
            color: var(--error);
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

            .content-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 15px;
            }

            .content-header div:last-child {
                align-self: flex-end;
            }

            .form-header {
                flex-direction: column;
                align-items: flex-start;
            }

            .form-icon {
                margin-bottom: 10px;
            }
        }

        @media screen and (max-width: 768px) {
            .movement-types {
                flex-direction: column;
            }

            .form-actions {
                flex-direction: column;
            }

            .btn {
                width: 100%;
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

            .form-container {
                padding: 20px 15px;
            }

            .preview-header {
                padding: 15px;
            }

            .preview-body {
                padding: 15px;
            }

            .preview-icon {
                width: 30px;
                height: 30px;
            }

            .preview-icon i {
                font-size: 14px;
            }

            .preview-value {
                font-size: 14px;
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
        <div class="loader-subtitle">Cargando Registro de Movimiento...</div>
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
                    <h1 class="page-title">Registrar Movimiento de Inventario</h1>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.inventario.index') }}">Inventario</a></li>
                        <li class="breadcrumb-item">Registrar Movimiento</li>
                    </ul>
                </div>
                <div>
                    <a href="{{ route('admin.inventario.index') }}" class="btn btn-primary">
                        <i class="fas fa-arrow-left"></i> Volver al Inventario
                    </a>
                </div>
            </div>

            <!-- Alertas de error -->
            @if (session('error'))
                <div class="alert alert-error">
                    <div class="alert-icon">
                        <i class="fas fa-exclamation-circle"></i>
                    </div>
                    <div>{{ session('error') }}</div>
                </div>
            @endif
            
            <!-- Errores de validación -->
            @if ($errors->any())
                <div class="form-errors">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Formulario -->
            <div class="form-container">
                <div class="form-header">
                    <div class="form-icon">
                        <i class="fas fa-exchange-alt"></i>
                    </div>
                    <div class="form-title-group">
                        <h2 class="form-title">Registrar Nuevo Movimiento</h2>
                        <p class="form-subtitle">Complete los datos para registrar una entrada o salida de inventario</p>
                    </div>
                </div>
                
                <form action="{{ route('admin.inventario.registrarMovimiento') }}" method="POST" id="movement-form">
                    @csrf
                    
                    <!-- Tipo de movimiento con iconos -->
                    <div class="movement-types">
                        <div class="movement-type-option">
                            <input type="radio" id="tipo-entrada" name="tipo" value="entrada" class="movement-type-input" {{ old('tipo') == 'entrada' ? 'checked' : '' }} checked>
                            <label for="tipo-entrada" class="movement-type-label">
                                <div class="movement-type-icon">
                                    <i class="fas fa-arrow-down"></i>
                                </div>
                                <div class="movement-type-text">Entrada</div>
                            </label>
                        </div>
                        
                        <div class="movement-type-option">
                            <input type="radio" id="tipo-salida" name="tipo" value="salida" class="movement-type-input" {{ old('tipo') == 'salida' ? 'checked' : '' }}>
                            <label for="tipo-salida" class="movement-type-label">
                                <div class="movement-type-icon">
                                    <i class="fas fa-arrow-up"></i>
                                </div>
                                <div class="movement-type-text">Salida</div>
                            </label>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="id_producto" class="form-label">
                            <i class="fas fa-box"></i> Producto
                        </label>
                        <select id="id_producto" name="id_producto" class="form-select" required>
                            <option value="">Seleccione un producto</option>
                            @foreach($productos as $producto)
                                <option value="{{ $producto->id_producto }}" 
                                        {{ (old('id_producto') == $producto->id_producto || (isset($productoSeleccionado) && $productoSeleccionado->id_producto == $producto->id_producto)) ? 'selected' : '' }}
                                        data-stock="{{ $producto->cantidad }}"
                                        class="{{ $producto->cantidad <= 0 ? 'sin-stock' : '' }}">
                                    {{ $producto->nombre }} (Stock actual: {{ $producto->cantidad }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="cantidad" class="form-label">
                            <i class="fas fa-sort-amount-up"></i> Cantidad
                        </label>
                        <input type="number" id="cantidad" name="cantidad" value="{{ old('cantidad', 1) }}" min="1" class="form-control" required>
                        <span class="form-text" id="cantidad-msg">Ingrese la cantidad de unidades para este movimiento.</span>
                    </div>
                    
                    <div class="form-group">
                        <label for="descripcion" class="form-label">
                            <i class="fas fa-align-left"></i> Descripción
                        </label>
                        <textarea id="descripcion" name="descripcion" class="form-textarea" required>{{ old('descripcion') }}</textarea>
                        <span class="form-text">Añada una breve descripción sobre este movimiento (motivo, proveedor, etc.)</span>
                    </div>
                    
                    <div class="form-actions">
                        <button type="submit" class="btn btn-info">
                            <i class="fas fa-save"></i> Registrar Movimiento
                        </button>
                        <a href="{{ route('admin.inventario.index') }}" class="btn btn-danger">
                            <i class="fas fa-times"></i> Cancelar
                        </a>
                    </div>
                </form>
            </div>
            
            <!-- Vista previa del movimiento (actualizado en tiempo real) -->
            <div class="preview-card" id="preview-card">
                <div class="preview-header">
                    <h3 class="preview-title">
                        <i class="fas fa-eye"></i> Vista Previa del Movimiento
                    </h3>
                </div>
                <div class="preview-body">
                    <div class="preview-row">
                        <div class="preview-icon type-icon">
                            <i class="fas fa-exchange-alt"></i>
                        </div>
                        <div class="preview-content">
                            <div class="preview-label">Tipo de Movimiento</div>
                            <div class="preview-value">
                                <span class="preview-badge preview-badge-entrada" id="preview-tipo">
                                    <i class="fas fa-arrow-down"></i> Entrada
                                </span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="preview-row">
                        <div class="preview-icon product-icon">
                            <i class="fas fa-box"></i>
                        </div>
                        <div class="preview-content">
                            <div class="preview-label">Producto Seleccionado</div>
                            <div class="preview-value" id="preview-producto">Seleccione un producto</div>
                        </div>
                    </div>
                    
                    <div class="preview-row">
                        <div class="preview-icon quantity-icon">
                            <i class="fas fa-sort-amount-up"></i>
                        </div>
                        <div class="preview-content">
                            <div class="preview-label">Cantidad</div>
                            <div class="preview-value" id="preview-cantidad">1</div>
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
            
            // Actualización de vista previa
            const tipoEntrada = document.getElementById('tipo-entrada');
            const tipoSalida = document.getElementById('tipo-salida');
            const selectProducto = document.getElementById('id_producto');
            const inputCantidad = document.getElementById('cantidad');
            const cantidadMsg = document.getElementById('cantidad-msg');
            
            // Elementos de vista previa
            const previewTipo = document.getElementById('preview-tipo');
            const previewProducto = document.getElementById('preview-producto');
            const previewCantidad = document.getElementById('preview-cantidad');
            
            // Función para filtrar productos según el tipo de movimiento
            function filtrarProductos() {
                const tipoMovimiento = document.querySelector('input[name="tipo"]:checked').value;
                const opciones = selectProducto.options;
                
                // Para entradas mostramos todos los productos
                if (tipoMovimiento === 'entrada') {
                    for (let i = 0; i < opciones.length; i++) {
                        opciones[i].style.display = '';
                    }
                    cantidadMsg.textContent = 'Ingrese la cantidad de unidades que ingresan al inventario.';
                } else {
                    // Para salidas ocultamos los productos sin stock
                    for (let i = 0; i < opciones.length; i++) {
                        if (opciones[i].classList.contains('sin-stock')) {
                            opciones[i].style.display = 'none';
                            
                            // Si estaba seleccionado un producto sin stock, lo deseleccionamos
                            if (opciones[i].selected) {
                                selectProducto.value = '';
                            }
                        } else {
                            opciones[i].style.display = '';
                        }
                    }
                    cantidadMsg.textContent = 'Ingrese la cantidad de unidades que salen del inventario.';
                }
                
                // Actualizar vista previa del tipo
                if (tipoMovimiento === 'entrada') {
                    previewTipo.className = 'preview-badge preview-badge-entrada';
                    previewTipo.innerHTML = '<i class="fas fa-arrow-down"></i> Entrada';
                } else {
                    previewTipo.className = 'preview-badge preview-badge-salida';
                    previewTipo.innerHTML = '<i class="fas fa-arrow-up"></i> Salida';
                }
            }
            
            // Función para actualizar la vista previa del producto
            function actualizarVistaPrevia() {
                // Producto
                const selectedOption = selectProducto.options[selectProducto.selectedIndex];
                previewProducto.textContent = selectedOption ? selectedOption.text : 'Seleccione un producto';
                
                // Cantidad
                previewCantidad.textContent = inputCantidad.value || '1';
            }
            
            // Eventos
            tipoEntrada.addEventListener('change', filtrarProductos);
            tipoSalida.addEventListener('change', filtrarProductos);
            selectProducto.addEventListener('change', actualizarVistaPrevia);
            inputCantidad.addEventListener('input', actualizarVistaPrevia);
            
            // Inicializar
            filtrarProductos();
            actualizarVistaPrevia();
        });
    </script>
</body>
</html>