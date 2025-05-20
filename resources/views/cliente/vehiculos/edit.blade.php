<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Vehículo - Service Center</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #4361ee;
            --primary-light: #4895ef;
            --primary-dark: #3a0ca3;
            --secondary: #4cc9f0;
            --accent: #f72585;
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
            font-family: 'Poppins', sans-serif;
        }

        body {
            background-color: #f5f8ff;
            min-height: 100vh;
            position: relative;
            overflow-x: hidden;
            color: var(--dark);
            transition: background-color var(--transition-speed);
        }

        body.dark-mode {
            background-color: #121212;
            color: var(--light);
        }

        /* Animación de carga inicial con perfil de persona */
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

        /* Animación de carga de perfil con espuma */
        .profile-loader {
            position: relative;
            width: 220px;
            height: 220px;
            margin-bottom: 30px;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .profile-avatar {
            width: 120px;
            height: 120px;
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative;
            z-index: 5;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            animation: pulseProfile 2s infinite ease-in-out;
        }

        .profile-avatar i {
            font-size: 60px;
            color: var(--primary);
        }

        .profile-bubbles {
            position: absolute;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            z-index: 4;
        }

        .bubble-small, .bubble-medium, .bubble-large {
            position: absolute;
            border-radius: 50%;
            background-color: rgba(255, 255, 255, 0.7);
            animation: bubbleFloat infinite ease-in-out;
        }

        .bubble-small {
            width: 20px;
            height: 20px;
            top: 20%;
            right: 0;
            animation-duration: 3s;
        }

        .bubble-medium {
            width: 30px;
            height: 30px;
            bottom: 15%;
            right: 5%;
            animation-duration: 4s;
            animation-delay: 0.5s;
        }

        .bubble-large {
            width: 25px;
            height: 25px;
            bottom: 30%;
            left: 0;
            animation-duration: 5s;
            animation-delay: 1s;
        }

        .cleaning-elements {
            position: absolute;
            width: 100%;
            height: 100%;
            z-index: 3;
        }

        .foam {
            position: absolute;
            background-color: rgba(255, 255, 255, 0.8);
            border-radius: 50% 50% 50% 50% / 60% 60% 40% 40%;
            filter: blur(5px);
            z-index: 3;
            animation: foamMove 4s infinite alternate ease-in-out;
        }

        .left-foam {
            width: 80px;
            height: 60px;
            top: 65%;
            left: 10%;
            transform: rotate(-20deg);
            animation-delay: 0.5s;
        }

        .right-foam {
            width: 70px;
            height: 50px;
            top: 30%;
            right: 10%;
            transform: rotate(20deg);
            animation-delay: 1s;
        }

        .cleaning-items {
            position: absolute;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            z-index: 1;
            opacity: 0.8;
        }
        
        .cleaning-item {
            position: absolute;
            font-size: 1.5rem;
            color: white;
            filter: drop-shadow(0 0 5px rgba(255, 255, 255, 0.5));
            animation: float 3s infinite ease-in-out;
        }

        @keyframes pulseProfile {
            0% {
                transform: scale(0.95);
                box-shadow: 0 0 0 0 rgba(255, 255, 255, 0.5);
            }
            70% {
                transform: scale(1);
                box-shadow: 0 0 0 15px rgba(255, 255, 255, 0);
            }
            100% {
                transform: scale(0.95);
                box-shadow: 0 0 0 0 rgba(255, 255, 255, 0);
            }
        }

        @keyframes bubbleFloat {
            0%, 100% { transform: translateY(0) translateX(0); }
            25% { transform: translateY(-10px) translateX(5px); }
            50% { transform: translateY(-5px) translateX(10px); }
            75% { transform: translateY(5px) translateX(-5px); }
        }

        @keyframes foamMove {
            0% { transform: translateY(0) rotate(-20deg) scale(1); }
            100% { transform: translateY(-15px) rotate(-10deg) scale(1.1); }
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

        @keyframes float {
            0%, 100% { transform: translateY(0) rotate(0); }
            50% { transform: translateY(-10px) rotate(5deg); }
        }

        /* Burbujas de fondo */
        .bubbles {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
            overflow: hidden;
            pointer-events: none;
        }
        
        .bubble {
            position: absolute;
            bottom: -100px;
            border-radius: 50%;
            background-color: rgba(67, 97, 238, 0.05);
            opacity: 0.7;
            animation: rise 20s infinite ease-in;
        }
        
        .cleaning-bubble {
            display: flex;
            align-items: center;
            justify-content: center;
            color: rgba(67, 97, 238, 0.2);
        }
        
        body.dark-mode .bubble {
            background-color: rgba(67, 97, 238, 0.1);
        }
        
        @keyframes rise {
            0% {
                bottom: -100px;
                transform: translateX(0) scale(0.4);
                opacity: 0;
            }
            10% {
                opacity: 0.7;
            }
            50% {
                transform: translateX(100px) scale(1);
                opacity: 0.7;
            }
            100% {
                bottom: 1080px;
                transform: translateX(-200px) scale(0.2);
                opacity: 0;
            }
        }

        /* Barra de navegación mejorada con botón flotante para móvil */
        .navbar {
            position: fixed;
            width: 80px;
            height: 100vh;
            background: linear-gradient(to bottom, var(--primary-dark), var(--primary));
            left: 0;
            top: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 20px 0;
            transition: all var(--transition-speed) ease;
            z-index: 100;
            box-shadow: 3px 0 20px rgba(0, 0, 0, 0.1);
            transform: translateX(0);
        }

        .navbar:hover {
            width: 240px;
        }

        .logo-container {
            width: 60px;
            height: 60px;
            display: flex;
            justify-content: center;
            align-items: center;
            margin-bottom: 30px;
            transition: all var(--transition-speed);
            background-color: white;
            border-radius: 50%;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .navbar:hover .logo-container {
            width: 180px;
            border-radius: 15px;
        }

        .logo-container i {
            font-size: 32px;
            color: var(--primary);
        }

        .logo-text {
            display: none;
            margin-left: 10px;
            font-weight: 600;
            font-size: 18px;
            color: var(--primary);
            white-space: nowrap;
        }

        .navbar:hover .logo-text {
            display: block;
        }

        .sidebar-user {
            padding: 15px 10px;
            text-align: center;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            margin-bottom: 15px;
            width: 100%;
        }

        .user-avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background-color: var(--primary-light);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
            font-size: 20px;
            color: white;
            font-weight: 600;
            transition: all var(--transition-speed) ease;
        }

        .user-info {
            white-space: nowrap;
            transition: opacity var(--transition-speed) ease;
            display: none;
        }

        .user-name {
            font-size: 16px;
            font-weight: 600;
            margin-bottom: 5px;
            color: white;
        }

        .user-role {
            font-size: 12px;
            color: rgba(255, 255, 255, 0.7);
        }

        .navbar:hover .user-info {
            display: block;
        }

        .sidebar-menu {
            width: 100%;
            overflow-y: auto;
            padding: 10px 0;
            flex-grow: 1;
        }

        .menu-label {
            padding: 10px 15px;
            font-size: 12px;
            text-transform: uppercase;
            color: rgba(255, 255, 255, 0.5);
            letter-spacing: 1px;
            white-space: nowrap;
            display: none;
        }

        .navbar:hover .menu-label {
            display: block;
        }

        .nav-item {
            position: relative;
            display: flex;
            align-items: center;
            padding: 12px 15px;
            margin: 5px 10px;
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            transition: all var(--transition-speed) ease;
            border-radius: 10px;
            white-space: nowrap;
        }

        .nav-item:hover, .nav-item.active {
            background-color: rgba(255, 255, 255, 0.1);
            color: white;
        }

        .nav-item.active {
            background-color: rgba(255, 255, 255, 0.2);
        }

        .nav-item i {
            font-size: 20px;
            min-width: 35px;
            display: flex;
            justify-content: center;
            transition: all var(--transition-speed) ease;
        }

        .nav-item-text {
            visibility: hidden;
            opacity: 0;
            transition: all var(--transition-speed) ease;
            margin-left: 10px;
        }

        .navbar:hover .nav-item-text {
            visibility: visible;
            opacity: 1;
        }

        .nav-logout {
            margin-top: auto;
            width: 100%;
            padding: 15px 0;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }

        .logout-link {
            color: rgba(255, 255, 255, 0.7) !important;
        }

        .logout-link:hover {
            background-color: rgba(244, 67, 54, 0.2) !important;
        }

        /* Menú tooltip para barra colapsada */
        .menu-tooltip {
            position: absolute;
            left: 75px;
            top: 50%;
            transform: translateY(-50%);
            background-color: var(--primary-dark);
            color: white;
            padding: 5px 12px;
            border-radius: 4px;
            font-size: 12px;
            opacity: 0;
            visibility: hidden;
            transition: all var(--transition-speed) ease;
            pointer-events: none;
            z-index: 101;
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

        .nav-item:hover .menu-tooltip {
            opacity: 1;
            visibility: visible;
        }

        .navbar:hover .menu-tooltip {
            opacity: 0;
            visibility: hidden;
        }

        /* Botón flotante para menú en móvil */
        .menu-toggle {
            display: none;
            position: fixed;
            bottom: 20px;
            right: 20px;
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary), var(--primary-light));
            color: white;
            text-align: center;
            line-height: 60px;
            font-size: 24px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
            z-index: 200;
            cursor: pointer;
            transition: all var(--transition-speed) ease;
        }

        .menu-toggle:hover {
            transform: scale(1.05);
            box-shadow: 0 6px 25px rgba(0, 0, 0, 0.3);
        }

        .menu-toggle.active {
            transform: rotate(90deg);
        }

        /* Overlay para cuando el menú está abierto en móvil */
        .menu-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 99;
            transition: opacity var(--transition-speed) ease;
            opacity: 0;
        }

        .menu-overlay.active {
            display: block;
            opacity: 1;
        }

        /* Botón de logout en móvil */
        .mobile-logout {
            display: none;
            position: fixed;
            top: 20px;
            right: 20px;
            background-color: var(--error);
            color: white;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            justify-content: center;
            align-items: center;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
            z-index: 98;
            transition: all var(--transition-speed) ease;
        }

        .mobile-logout:hover {
            transform: scale(1.1);
            background-color: #d32f2f;
        }

        /* Contenido principal */
        .main-content {
            margin-left: 80px;
            padding: 30px;
            transition: margin-left var(--transition-speed) ease;
        }

        .navbar:hover ~ .main-content {
            margin-left: 240px;
        }

        /* Header del contenido */
        .content-header {
            background-color: white;
            border-radius: 15px;
            padding: 20px 25px;
            margin-bottom: 25px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
            display: flex;
            justify-content: space-between;
            align-items: center;
            animation: slideDown 0.5s forwards;
            transition: background-color var(--transition-speed);
        }

        body.dark-mode .content-header {
            background-color: #1e1e1e;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.2);
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

        .header-left {
            display: flex;
            flex-direction: column;
        }

        .header-title {
            font-size: 24px;
            font-weight: 600;
            color: var(--primary-dark);
            margin-bottom: 5px;
        }

        body.dark-mode .header-title {
            color: var(--light);
        }

        .header-subtitle {
            font-size: 14px;
            color: var(--gray);
        }

        body.dark-mode .header-subtitle {
            color: var(--gray-light);
        }

        .header-actions {
            display: flex;
            gap: 10px;
        }

        .theme-toggle {
            background: transparent;
            border: none;
            font-size: 22px;
            cursor: pointer;
            color: var(--primary);
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all var(--transition-speed) ease;
        }

        .theme-toggle:hover {
            background-color: rgba(67, 97, 238, 0.1);
        }

        body.dark-mode .theme-toggle {
            color: var(--secondary);
        }

        /* Estilos para alertas */
        .alert {
            padding: 15px 20px;
            border-radius: 10px;
            margin-bottom: 20px;
            animation: slideIn 0.5s ease-out;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }

        .alert-success {
            background-color: rgba(76, 175, 80, 0.1);
            border-left: 4px solid var(--success);
            color: var(--success);
        }

        .alert-danger {
            background-color: rgba(244, 67, 54, 0.1);
            border-left: 4px solid var(--error);
            color: var(--error);
        }

        body.dark-mode .alert-success {
            background-color: rgba(76, 175, 80, 0.05);
        }

        body.dark-mode .alert-danger {
            background-color: rgba(244, 67, 54, 0.05);
        }

        /* Formulario de edición */
        .form-container {
            background-color: white;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
            animation: fadeInUp 0.7s forwards;
            transition: background-color var(--transition-speed);
        }

        body.dark-mode .form-container {
            background-color: #1e1e1e;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.2);
        }

        .form-title {
            font-size: 20px;
            font-weight: 600;
            margin-bottom: 25px;
            color: var(--primary-dark);
            display: flex;
            align-items: center;
        }

        .form-title i {
            margin-right: 10px;
            color: var(--primary);
            font-size: 24px;
        }

        body.dark-mode .form-title {
            color: var(--light);
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: var(--dark);
        }

        body.dark-mode .form-label {
            color: var(--light);
        }

        .form-hint {
            display: block;
            font-size: 12px;
            color: var(--gray);
            margin-top: 5px;
        }

        body.dark-mode .form-hint {
            color: var(--gray-light);
        }

        .form-control {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid var(--gray-light);
            border-radius: 10px;
            font-family: 'Poppins', sans-serif;
            font-size: 14px;
            transition: all var(--transition-speed) ease;
        }

        .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.2);
            outline: none;
        }

        .form-control:disabled, .form-control[readonly] {
            background-color: #f8f9fa;
            cursor: not-allowed;
        }

        body.dark-mode .form-control {
            background-color: #333;
            border-color: #444;
            color: var(--light);
        }

        body.dark-mode .form-control:disabled, 
        body.dark-mode .form-control[readonly] {
            background-color: #222;
        }

        .form-select {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid var(--gray-light);
            border-radius: 10px;
            font-family: 'Poppins', sans-serif;
            font-size: 14px;
            transition: all var(--transition-speed) ease;
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='%236c757d'%3E%3Cpath d='M7 10l5 5 5-5z'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 15px center;
            background-size: 20px;
        }

        .form-select:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.2);
            outline: none;
        }

        body.dark-mode .form-select {
            background-color: #333;
            border-color: #444;
            color: var(--light);
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='%23adb5bd'%3E%3Cpath d='M7 10l5 5 5-5z'/%3E%3C/svg%3E");
        }

        /* Botones y acciones */
        .btn {
            padding: 12px 20px;
            border-radius: 10px;
            font-weight: 500;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: all var(--transition-speed) ease;
            cursor: pointer;
            border: none;
            font-family: 'Poppins', sans-serif;
            font-size: 14px;
            position: relative;
            overflow: hidden;
            min-width: 120px;
        }

        .btn i {
            margin-right: 8px;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary), var(--primary-light));
            color: white;
        }

        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(67, 97, 238, 0.3);
        }

        .btn-info {
            background: linear-gradient(135deg, var(--info), #64b5f6);
            color: white;
        }

        .btn-info:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(33, 150, 243, 0.3);
        }

        .btn-secondary {
            background-color: #f8f9fa;
            color: var(--dark);
            border: 1px solid var(--gray-light);
        }

        .btn-secondary:hover {
            background-color: #e9ecef;
        }

        body.dark-mode .btn-secondary {
            background-color: #333;
            color: var(--light);
            border-color: #444;
        }

        body.dark-mode .btn-secondary:hover {
            background-color: #444;
        }

        .form-actions {
            display: flex;
            gap: 15px;
            margin-top: 30px;
        }

        /* Responsividad */
        @media screen and (max-width: 1199px) {
            .main-content {
                padding: 25px;
            }
        }

        @media screen and (max-width: 991px) {
            .content-header {
                padding: 15px 20px;
            }

            .header-title {
                font-size: 22px;
            }

            .form-container {
                padding: 20px;
            }
        }

        @media screen and (max-width: 767px) {
            /* Mostrar botón de menú móvil */
            .menu-toggle {
                display: block;
            }
            
            /* Ocultar navbar por defecto en móvil */
            .navbar {
                width: 0;
                overflow: hidden;
                transform: translateX(-100%);
            }
            
            /* Mostrar navbar cuando está activo */
            .navbar.mobile-active {
                width: 240px;
                transform: translateX(0);
            }
            
            .navbar:hover {
                width: 240px;
            }
            
            /* Ajustar contenido principal */
            .main-content {
                margin-left: 0;
                padding: 20px 15px;
            }
            
            .navbar:hover ~ .main-content,
            .navbar.mobile-active ~ .main-content {
                margin-left: 0;
            }

            .mobile-logout {
                display: flex;
            }

            .content-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 15px;
            }

            .header-actions {
                align-self: flex-end;
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
                padding: 15px 12px;
            }
            
            .content-header {
                padding: 15px;
                margin-bottom: 20px;
            }
            
            .form-container {
                padding: 15px;
            }
        }

        /* Estilo específico para el campo nueva_marca */
        #nueva_marca_div {
            animation: fadeIn 0.3s forwards;
            padding: 15px;
            border-radius: 10px;
            background-color: rgba(67, 97, 238, 0.05);
            margin-bottom: 20px;
            border-left: 4px solid var(--primary);
        }

        body.dark-mode #nueva_marca_div {
            background-color: rgba(67, 97, 238, 0.1);
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }
    </style>
</head>
<body>
    <!-- Animación de carga inicial con perfil de persona -->
    <div class="page-loader" id="pageLoader">
        <div class="loader-title">Service Center - Panel de Cliente</div>
        <div class="profile-loader">
            <div class="profile-avatar">
                <i class="fas fa-user"></i>
                <div class="profile-bubbles">
                    <div class="bubble-small"></div>
                    <div class="bubble-medium"></div>
                    <div class="bubble-large"></div>
                </div>
            </div>
            <div class="cleaning-elements">
                <div class="foam left-foam"></div>
                <div class="foam right-foam"></div>
                <div class="cleaning-items">
                    <i class="fas fa-soap cleaning-item" style="top: 10%; left: 20%;"></i>
                    <i class="fas fa-spray-can cleaning-item" style="top: 30%; left: 70%;"></i>
                    <i class="fas fa-tint cleaning-item" style="top: 60%; left: 30%;"></i>
                    <i class="fas fa-brush cleaning-item" style="top: 80%; left: 60%;"></i>
                </div>
            </div>
        </div>
        <div class="loader-subtitle">Cargando su perfil de cliente...</div>
        <div class="progress-container">
            <div class="progress-bar"></div>
        </div>
    </div>

    <!-- Botón flotante para menú en móvil -->
    <div class="menu-toggle" id="menuToggle">
        <i class="fas fa-bars"></i>
    </div>
    
    <!-- Overlay para cuando el menú está abierto en móvil -->
    <div class="menu-overlay" id="menuOverlay"></div>

    <!-- Burbujas decorativas de fondo -->
    <div class="bubbles" id="bubbles"></div>

    <!-- Barra de navegación lateral -->
    <nav class="navbar" id="navbar">
        <div class="logo-container">
            <i class="fas fa-car-side"></i>
            <span class="logo-text">ServiceCenter</span>
        </div>
        
        <div class="sidebar-user">
            <div class="user-avatar">
                {{ substr(session('usuario')->nombre, 0, 1) }}
            </div>
            <div class="user-info">
                <div class="user-name">{{ session('usuario')->nombre }}</div>
                <div class="user-role">Cliente</div>
            </div>
        </div>
        
        <div class="sidebar-menu">
            <div class="menu-label">Principal</div>
            <a href="{{ route('cliente.dashboard') }}" class="nav-item">
                <i class="fas fa-home"></i>
                <span class="nav-item-text">Inicio</span>
                <div class="menu-tooltip">Inicio</div>
            </a>
            
            <div class="menu-label">Vehículos</div>
            <a href="{{ route('cliente.vehiculos.index') }}" class="nav-item active">
                <i class="fas fa-car"></i>
                <span class="nav-item-text">Mis Vehículos</span>
                <div class="menu-tooltip">Mis Vehículos</div>
            </a>
            <a href="{{ route('cliente.vehiculos.create') }}" class="nav-item">
                <i class="fas fa-plus-circle"></i>
                <span class="nav-item-text">Añadir Vehículo</span>
                <div class="menu-tooltip">Añadir Vehículo</div>
            </a>
            
            <div class="menu-label">Servicios</div>
            <a href="{{ route('cliente.turnos.solicitar') }}" class="nav-item">
                <i class="fas fa-calendar-plus"></i>
                <span class="nav-item-text">Solicitar Turno</span>
                <div class="menu-tooltip">Solicitar Turno</div>
            </a>
            <a href="{{ route('cliente.turnos') }}" class="nav-item">
                <i class="fas fa-calendar-check"></i>
                <span class="nav-item-text">Mis Turnos</span>
                <div class="menu-tooltip">Mis Turnos</div>
            </a>
            <a href="{{ route('cliente.lavadas.index') }}" class="nav-item">
                <i class="fas fa-history"></i>
                <span class="nav-item-text">Historial de Lavados</span>
                <div class="menu-tooltip">Historial de Lavados</div>
            </a>
        </div>
        
        <div class="nav-logout">
            <a href="{{ route('logout') }}" class="nav-item logout-link">
                <i class="fas fa-sign-out-alt"></i>
                <span class="nav-item-text">Cerrar Sesión</span>
                <div class="menu-tooltip">Cerrar Sesión</div>
            </a>
        </div>
    </nav>

    <!-- Botón de logout para móvil -->
    <a href="{{ route('logout') }}" class="mobile-logout">
        <i class="fas fa-sign-out-alt"></i>
    </a>

    <!-- Contenido principal -->
    <main class="main-content">
        <!-- Header del contenido -->
        <div class="content-header">
            <div class="header-left">
                <h1 class="header-title">Editar Vehículo</h1>
                <div class="header-subtitle">
                    <span>Modifica los datos de tu vehículo</span>
                </div>
            </div>
            <div class="header-actions">
                <button class="theme-toggle" id="themeToggle">
                    <i class="fas fa-moon"></i>
                </button>
            </div>
        </div>

        <!-- Alertas de errores -->
        @if ($errors->any())
            <div class="alert alert-danger">
                <i class="fas fa-exclamation-circle" style="margin-right: 10px;"></i>
                <ul style="margin: 0; padding-left: 20px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Formulario de edición -->
        <div class="form-container">
            <h2 class="form-title">
                <i class="fas fa-edit"></i> Modificar información del vehículo
            </h2>

            <form method="POST" action="{{ route('cliente.vehiculos.update', $vehiculo->id_vehiculo) }}">
                @csrf
                @method('PUT')
                
                <div class="form-group">
                    <label for="placa" class="form-label">Placa:</label>
                    <input type="text" name="placa" id="placa" value="{{ $vehiculo->placa }}" readonly class="form-control">
                    <span class="form-hint">La placa no se puede editar</span>
                </div>
                
                <div class="form-group">
                    <label for="marca" class="form-label">Marca:</label>
                    <select name="marca" id="marca" onchange="toggleNuevaMarca()" required class="form-select">
                        <option value="">Seleccione una marca</option>
                        @foreach ($marcas as $marca)
                            <option value="{{ $marca->id_marca }}" {{ (old('marca', $vehiculo->id_marca) == $marca->id_marca) ? 'selected' : '' }}>
                                {{ $marca->nombre }}
                            </option>
                        @endforeach
                        <option value="nueva" {{ old('marca') == 'nueva' ? 'selected' : '' }}>Otra marca...</option>
                    </select>
                </div>
                
                <div id="nueva_marca_div" style="display: {{ old('marca') == 'nueva' ? 'block' : 'none' }};">
                    <div class="form-group">
                        <label for="nueva_marca" class="form-label">Nueva Marca:</label>
                        <input type="text" name="nueva_marca" id="nueva_marca" value="{{ old('nueva_marca') }}" class="form-control">
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="modelo" class="form-label">Modelo:</label>
                    <input type="text" name="modelo" id="modelo" value="{{ old('modelo', $vehiculo->modelo) }}" required class="form-control">
                    <span class="form-hint">Solo números</span>
                </div>
                
                <div class="form-group">
                    <label for="color" class="form-label">Color:</label>
                    <input type="text" name="color" id="color" value="{{ old('color', $vehiculo->color) }}" required class="form-control">
                </div>
                
                <div class="form-group">
                    <label for="tipo_vehiculo" class="form-label">Tipo de Vehículo:</label>
                    <select name="tipo_vehiculo" id="tipo_vehiculo" required class="form-select">
                        <option value="carro" {{ old('tipo_vehiculo', $vehiculo->tipo_vehiculo ?? 'carro') == 'carro' ? 'selected' : '' }}>
                            Carro
                        </option>
                        <option value="moto" {{ old('tipo_vehiculo', $vehiculo->tipo_vehiculo ?? '') == 'moto' ? 'selected' : '' }}>
                            Moto
                        </option>
                    </select>
                </div>
                
                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Actualizar Vehículo
                    </button>
                    <a href="{{ route('cliente.vehiculos.index') }}" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Cancelar
                    </a>
                </div>
            </form>
        </div>
    </main>

    <script>
        // Función para mostrar/ocultar el campo de nueva marca
        function toggleNuevaMarca() {
            var marcaSelect = document.getElementById('marca');
            var nuevaMarcaDiv = document.getElementById('nueva_marca_div');
            
            if (marcaSelect.value === 'nueva') {
                nuevaMarcaDiv.style.display = 'block';
            } else {
                nuevaMarcaDiv.style.display = 'none';
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            // Animación de carga
            setTimeout(function() {
                document.getElementById('pageLoader').classList.add('hidden');
            }, 2000);

            // Burbujas de fondo aleatorias
            const bubblesContainer = document.getElementById('bubbles');
            const cleaningIcons = [
                'fa-spray-can', 'fa-soap', 'fa-brush', 'fa-tint', 'fa-car-wash', 
                'fa-water', 'fa-shower', 'fa-faucet'
            ];
            const numBubbles = 15;
            
            for (let i = 0; i < numBubbles; i++) {
                const bubble = document.createElement('div');
                const isCleaningBubble = Math.random() > 0.5;
                
                const size = Math.random() * 60 + 30;
                const left = Math.random() * 100;
                const delay = Math.random() * 15;
                const duration = Math.random() * 15 + 15;
                
                bubble.style.width = `${size}px`;
                bubble.style.height = `${size}px`;
                bubble.style.left = `${left}%`;
                bubble.style.animationDelay = `${delay}s`;
                bubble.style.animationDuration = `${duration}s`;
                
                if (isCleaningBubble) {
                    bubble.classList.add('bubble', 'cleaning-bubble');
                    const randomIcon = cleaningIcons[Math.floor(Math.random() * cleaningIcons.length)];
                    bubble.innerHTML = `<i class="fas ${randomIcon}"></i>`;
                } else {
                    bubble.classList.add('bubble');
                }
                
                bubblesContainer.appendChild(bubble);
            }

            // Cambiar tema claro/oscuro
            const themeToggle = document.getElementById('themeToggle');
            const themeIcon = themeToggle.querySelector('i');
            
            themeToggle.addEventListener('click', function() {
                document.body.classList.toggle('dark-mode');
                
                if (document.body.classList.contains('dark-mode')) {
                    themeIcon.classList.remove('fa-moon');
                    themeIcon.classList.add('fa-sun');
                    localStorage.setItem('theme', 'dark');
                } else {
                    themeIcon.classList.remove('fa-sun');
                    themeIcon.classList.add('fa-moon');
                    localStorage.setItem('theme', 'light');
                }
            });
            
            // Verificar tema guardado en localStorage
            const savedTheme = localStorage.getItem('theme');
            if (savedTheme === 'dark') {
                document.body.classList.add('dark-mode');
                themeIcon.classList.remove('fa-moon');
                themeIcon.classList.add('fa-sun');
            }
            
            // Funcionalidad para el menú móvil
            const menuToggle = document.getElementById('menuToggle');
            const navbar = document.getElementById('navbar');
            const menuOverlay = document.getElementById('menuOverlay');
            
            menuToggle.addEventListener('click', function() {
                navbar.classList.toggle('mobile-active');
                menuToggle.classList.toggle('active');
                menuOverlay.classList.toggle('active');
                
                // Bloquear scroll cuando el menú está abierto
                if (navbar.classList.contains('mobile-active')) {
                    document.body.style.overflow = 'hidden';
                } else {
                    document.body.style.overflow = '';
                }
            });
            
            // Cerrar el menú al hacer clic en el overlay
            menuOverlay.addEventListener('click', function() {
                navbar.classList.remove('mobile-active');
                menuToggle.classList.remove('active');
                menuOverlay.classList.remove('active');
                document.body.style.overflow = '';
            });
            
            // Cerrar el menú al hacer clic en un enlace del menú (solo en móvil)
            const navItems = document.querySelectorAll('.nav-item');
            navItems.forEach(item => {
                item.addEventListener('click', function() {
                    if (window.innerWidth <= 767) {
                        navbar.classList.remove('mobile-active');
                        menuToggle.classList.remove('active');
                        menuOverlay.classList.remove('active');
                        document.body.style.overflow = '';
                    }
                });
            });
            
            // Ajustar vistas en cambio de tamaño de ventana
            window.addEventListener('resize', function() {
                if (window.innerWidth > 767) {
                    navbar.classList.remove('mobile-active');
                    menuToggle.classList.remove('active');
                    menuOverlay.classList.remove('active');
                    document.body.style.overflow = '';
                }
            });
        });
    </script>
</body>
</html>