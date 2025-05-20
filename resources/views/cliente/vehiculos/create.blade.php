<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Vehículo - Service Center</title>
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

        /* Contenedor principal con sistema de dos columnas */
        .registro-container {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 25px;
        }

        /* Formulario de registro */
        .form-container {
            background-color: white;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
            animation: fadeInUp 0.7s forwards;
            transition: background-color var(--transition-speed);
            position: relative;
            overflow: hidden;
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
            position: relative;
        }

        .form-group.focused .form-label {
            transform: translateY(-24px) scale(0.85);
            color: var(--primary);
        }

        body.dark-mode .form-group.focused .form-label {
            color: var(--primary-light);
        }

        .form-group.focused .form-control {
            border-color: var(--primary);
        }

        .form-label {
            position: absolute;
            left: 15px;
            top: 12px;
            font-size: 14px;
            color: var(--gray);
            transition: all var(--transition-speed) ease;
            padding: 0 5px;
            pointer-events: none;
            background-color: white;
        }

        body.dark-mode .form-label {
            color: var(--gray-light);
            background-color: #1e1e1e;
        }

        body.dark-mode .form-group.focused .form-control {
            border-color: var(--primary-light);
        }

        .form-hint {
            display: block;
            font-size: 12px;
            color: var(--gray);
            margin-top: 5px;
            margin-left: 5px;
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
            background-color: transparent;
        }

        .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.1);
            outline: none;
        }

        body.dark-mode .form-control {
            background-color: #2d2d2d;
            border-color: #444;
            color: var(--light);
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
            background-color: transparent;
        }

        .form-select:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.1);
            outline: none;
        }

        body.dark-mode .form-select {
            background-color: #2d2d2d;
            border-color: #444;
            color: var(--light);
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='%23adb5bd'%3E%3Cpath d='M7 10l5 5 5-5z'/%3E%3C/svg%3E");
        }

        /* Color picker */
        .color-picker-container {
            margin-top: 10px;
        }

        .color-options {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin-top: 10px;
        }

        .color-option {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            cursor: pointer;
            transition: all var(--transition-speed) ease;
            border: 2px solid transparent;
        }

        .color-option:hover {
            transform: scale(1.1);
        }

        .color-option.active {
            border: 2px solid var(--primary);
            transform: scale(1.1);
        }

        body.dark-mode .color-option.active {
            border: 2px solid var(--primary-light);
        }

        .color-rojo { background-color: #e53935; }
        .color-azul { background-color: #1e88e5; }
        .color-verde { background-color: #43a047; }
        .color-negro { background-color: #212121; }
        .color-blanco { background-color: #f5f5f5; }
        .color-gris { background-color: #757575; }
        .color-plata { background-color: #BDBDBD; }
        .color-amarillo { background-color: #FDD835; }
        .color-naranja { background-color: #FB8C00; }
        .color-morado { background-color: #8E24AA; }

        /* Toggle tipo vehículo */
        .toggle-container {
            display: flex;
            margin-top: 10px;
            background-color: #f5f7fa;
            border-radius: 10px;
            position: relative;
            height: 50px;
            margin-bottom: 20px;
            box-shadow: inset 0 2px 5px rgba(0, 0, 0, 0.05);
            overflow: hidden;
        }

        body.dark-mode .toggle-container {
            background-color: #333;
        }

        .toggle-option {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            position: relative;
            z-index: 2;
            transition: all var(--transition-speed) ease;
            color: var(--gray);
            border-radius: 10px;
        }

        .toggle-option i {
            margin-right: 8px;
            font-size: 18px;
        }

        .toggle-option.active {
            color: white;
        }

        #toggle-slider {
            position: absolute;
            top: 5px;
            left: 5px;
            bottom: 5px;
            width: calc(50% - 10px);
            background: linear-gradient(135deg, var(--primary), var(--primary-light));
            border-radius: 8px;
            transition: all var(--transition-speed) ease;
            z-index: 1;
            box-shadow: 0 2px 10px rgba(67, 97, 238, 0.3);
        }

        /* Estilo específico cuando la Moto está activa */
        #toggleMoto.active ~ #toggle-slider {
            left: calc(50% + 5px);
            background: linear-gradient(135deg, var(--info), #64b5f6);
            box-shadow: 0 2px 10px rgba(33, 150, 243, 0.3);
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

        .btn-success {
            background: linear-gradient(135deg, var(--success), #66bb6a);
            color: white;
        }

        .btn-success:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(76, 175, 80, 0.3);
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

        /* Vista previa del vehículo */
        .preview-container {
            background-color: white;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
            animation: fadeInUp 0.7s forwards;
            animation-delay: 0.2s;
            transition: background-color var(--transition-speed);
            display: flex;
            flex-direction: column;
            position: sticky;
            top: 30px;
            height: fit-content;
        }

        body.dark-mode .preview-container {
            background-color: #1e1e1e;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.2);
        }

        .preview-title {
            font-size: 20px;
            font-weight: 600;
            margin-bottom: 25px;
            color: var(--primary-dark);
            display: flex;
            align-items: center;
        }

        .preview-title i {
            margin-right: 10px;
            color: var(--primary);
            font-size: 24px;
        }

        body.dark-mode .preview-title {
            color: var(--light);
        }

        .vehicle-preview {
            background: linear-gradient(135deg, #f5f7fa, #e9ecef);
            border-radius: 12px;
            padding: 30px;
            margin-bottom: 20px;
            box-shadow: inset 0 2px 5px rgba(0, 0, 0, 0.05);
            display: flex;
            flex-direction: column;
            align-items: center;
            position: relative;
            overflow: hidden;
            transition: all var(--transition-speed) ease;
        }

        body.dark-mode .vehicle-preview {
            background: linear-gradient(135deg, #2d2d2d, #1e1e1e);
        }

        .vehicle-icon-container {
            width: 150px;
            height: 150px;
            background-color: var(--primary-light);
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            margin-bottom: 20px;
            transition: all var(--transition-speed) ease;
            box-shadow: 0 10px 25px rgba(67, 97, 238, 0.2);
            border: 8px solid #fff;
        }

        body.dark-mode .vehicle-icon-container {
            border-color: #333;
        }

        .vehicle-icon {
            font-size: 80px;
            color: white;
            transition: all var(--transition-speed) ease;
        }

        .vehicle-details {
            width: 100%;
        }

        .vehicle-detail {
            display: flex;
            justify-content: space-between;
            padding: 12px 0;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        }

        body.dark-mode .vehicle-detail {
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        }

        .vehicle-detail:last-child {
            border-bottom: none;
        }

        .detail-label {
            color: var(--gray);
            font-weight: 500;
        }

        body.dark-mode .detail-label {
            color: var(--gray-light);
        }

        .detail-value {
            font-weight: 600;
            color: var(--dark);
        }

        body.dark-mode .detail-value {
            color: var(--light);
        }

        .badge {
            display: inline-flex;
            align-items: center;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            background: linear-gradient(135deg, var(--primary), var(--primary-light));
            color: white;
        }

        .badge i {
            margin-right: 5px;
        }

        .badge-moto {
            background: linear-gradient(135deg, var(--info), #64b5f6);
        }

        .placa-preview {
            background-color: #f8f9fa;
            border: 2px solid #dee2e6;
            border-radius: 5px;
            padding: 8px 15px;
            font-size: 18px;
            font-weight: 600;
            letter-spacing: 2px;
            color: var(--dark);
            margin-bottom: 25px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);
            position: relative;
            overflow: hidden;
            text-transform: uppercase;
        }

        .placa-preview::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(to right, 
                transparent 0%, 
                rgba(255, 255, 255, 0.4) 50%, 
                transparent 100%);
            transform: translateX(-100%);
        }

        .placa-preview.shine::before {
            animation: shine 1.5s;
        }

        @keyframes shine {
            to {
                transform: translateX(100%);
            }
        }

        body.dark-mode .placa-preview {
            background-color: #343a40;
            border-color: #495057;
            color: white;
        }

        .preview-hint {
            text-align: center;
            margin-top: 20px;
            color: var(--gray);
            font-size: 14px;
        }

        body.dark-mode .preview-hint {
            color: var(--gray-light);
        }

        /* Validación en tiempo real */
        .validation-icon {
            position: absolute;
            right: 15px;
            top: 14px;
            font-size: 16px;
            opacity: 0;
            transition: all var(--transition-speed) ease;
        }

        .validation-icon.valid {
            color: var(--success);
            opacity: 1;
        }

        .validation-icon.invalid {
            color: var(--error);
            opacity: 1;
        }

        .validation-message {
            font-size: 12px;
            margin-top: 5px;
            margin-left: 5px;
            transition: all var(--transition-speed) ease;
            height: 0;
            overflow: hidden;
            opacity: 0;
        }

        .validation-message.show {
            height: auto;
            opacity: 1;
        }

        .validation-message.error {
            color: var(--error);
        }

        /* Estilos para los inputs cuando tienen errores de validación */
        .form-control.is-invalid {
            border-color: var(--error);
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='%23f44336'%3E%3Cpath d='M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 15px center;
            background-size: 20px;
            padding-right: 45px;
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

        /* Responsividad */
        @media screen and (max-width: 1199px) {
            .main-content {
                padding: 25px;
            }
        }

        @media screen and (max-width: 991px) {
            .registro-container {
                grid-template-columns: 1fr;
            }

            .preview-container {
                position: static;
                margin-bottom: 25px;
                order: -1;
            }

            .content-header {
                padding: 15px 20px;
            }

            .header-title {
                font-size: 22px;
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
            
            .form-container, .preview-container {
                padding: 15px;
            }

            .vehicle-preview {
                padding: 20px;
            }

            .vehicle-icon-container {
                width: 120px;
                height: 120px;
            }

            .vehicle-icon {
                font-size: 60px;
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
            <a href="{{ route('cliente.vehiculos.index') }}" class="nav-item">
                <i class="fas fa-car"></i>
                <span class="nav-item-text">Mis Vehículos</span>
                <div class="menu-tooltip">Mis Vehículos</div>
            </a>
            <a href="{{ route('cliente.vehiculos.create') }}" class="nav-item active">
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
                <h1 class="header-title">Registrar Nuevo Vehículo</h1>
                <div class="header-subtitle">
                    <span>Añade un nuevo vehículo a tu perfil</span>
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

        <!-- Contenedor principal con registro y vista previa -->
        <div class="registro-container">
            <!-- Formulario de registro -->
            <div class="form-container">
                <h2 class="form-title">
                    <i class="fas fa-plus-circle"></i> Información del vehículo
                </h2>

                <form method="POST" action="{{ route('cliente.vehiculos.store') }}" id="vehicleForm">
                    @csrf
                    
                    <!-- Selector tipo de vehículo -->
                    <div class="form-group">
                        <label class="form-label">Tipo de Vehículo</label>
                        <div class="toggle-container">
                            <div class="toggle-option active" data-value="carro" id="toggleCarro">
                                <i class="fas fa-car"></i> Carro
                            </div>
                            <div class="toggle-option" data-value="moto" id="toggleMoto">
                                <i class="fas fa-motorcycle"></i> Moto
                            </div>
                            <div id="toggle-slider"></div>
                        </div>
                        <input type="hidden" name="tipo_vehiculo" id="tipo_vehiculo" value="carro">
                    </div>
                    
                    <!-- Campo placa -->
                    <div class="form-group">
                        <input type="text" name="placa" id="placa" class="form-control" 
                               value="{{ old('placa') }}" required maxlength="7" autocomplete="off">
                        <label for="placa" class="form-label">Placa</label>
                        <i class="fas fa-check validation-icon" id="placaValidIcon"></i>
                        <div class="validation-message" id="placaValidationMessage"></div>
                        <span class="form-hint">Solo letras y números (ejemplo: ABC12A)</span>
                    </div>
                    
                    <!-- Campo marca -->
                    <div class="form-group">
                        <select name="marca" id="marca" class="form-select" onchange="toggleNuevaMarca()" required>
                            <option value="">Seleccione una marca</option>
                            @foreach ($marcas as $marca)
                                <option value="{{ $marca->id_marca }}" {{ old('marca') == $marca->id_marca ? 'selected' : '' }}>
                                    {{ $marca->nombre }}
                                </option>
                            @endforeach
                            <option value="nueva" {{ old('marca') == 'nueva' ? 'selected' : '' }}>Otra marca...</option>
                        </select>
                    </div>
                    
                    <!-- Campo nueva marca (oculto inicialmente) -->
                    <div id="nueva_marca_div" style="display: {{ old('marca') == 'nueva' ? 'block' : 'none' }};">
                        <div class="form-group">
                            <input type="text" name="nueva_marca" id="nueva_marca" class="form-control" 
                                   value="{{ old('nueva_marca') }}" autocomplete="off">
                            <label for="nueva_marca" class="form-label">Nueva Marca</label>
                            <i class="fas fa-check validation-icon" id="marcaValidIcon"></i>
                        </div>
                    </div>
                    
                    <!-- Campo modelo -->
                    <div class="form-group">
                        <input type="text" name="modelo" id="modelo" class="form-control" 
                               value="{{ old('modelo') }}" required autocomplete="off">
                        <label for="modelo" class="form-label">Modelo (año)</label>
                        <i class="fas fa-check validation-icon" id="modeloValidIcon"></i>
                        <div class="validation-message" id="modeloValidationMessage"></div>
                        <span class="form-hint">Solo números (ejemplo: 2022)</span>
                    </div>
                    
                    <!-- Campo color con selector visual -->
                    <div class="form-group">
                        <input type="text" name="color" id="color" class="form-control" 
                               value="{{ old('color', 'Blanco') }}" required autocomplete="off">
                        <label for="color" class="form-label">Color</label>
                        
                        <div class="color-picker-container">
                            <div class="color-options">
                                <div class="color-option color-rojo" data-color="Rojo" title="Rojo"></div>
                                <div class="color-option color-azul" data-color="Azul" title="Azul"></div>
                                <div class="color-option color-verde" data-color="Verde" title="Verde"></div>
                                <div class="color-option color-negro" data-color="Negro" title="Negro"></div>
                                <div class="color-option color-blanco active" data-color="Blanco" title="Blanco"></div>
                                <div class="color-option color-gris" data-color="Gris" title="Gris"></div>
                                <div class="color-option color-plata" data-color="Plata" title="Plata"></div>
                                <div class="color-option color-amarillo" data-color="Amarillo" title="Amarillo"></div>
                                <div class="color-option color-naranja" data-color="Naranja" title="Naranja"></div>
                                <div class="color-option color-morado" data-color="Morado" title="Morado"></div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Botones de acción -->
                    <div class="form-actions">
                        <button type="submit" class="btn btn-success" id="submitBtn">
                            <i class="fas fa-check"></i> Registrar Vehículo
                        </button>
                        <a href="{{ route('cliente.vehiculos.index') }}" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Cancelar
                        </a>
                    </div>
                </form>
            </div>
            
            <!-- Vista previa del vehículo -->
            <div class="preview-container">
                <h2 class="preview-title">
                    <i class="fas fa-eye"></i> Vista previa
                </h2>
                
                <div class="placa-preview" id="placaPreview">ABC12A</div>
                
                <div class="vehicle-preview">
                    <div class="vehicle-icon-container" id="vehicleIconBg">
                        <i class="fas fa-car-side vehicle-icon" id="vehicleIcon"></i>
                    </div>
                    
                    <div class="vehicle-details">
                        <div class="vehicle-detail">
                            <span class="detail-label">Tipo:</span>
                            <span class="detail-value">
                                <span class="badge" id="tipoVehiculo">
                                    <i class="fas fa-car-side"></i> Carro
                                </span>
                            </span>
                        </div>
                        <div class="vehicle-detail">
                            <span class="detail-label">Marca:</span>
                            <span class="detail-value" id="previewMarca">Seleccione una marca</span>
                        </div>
                        <div class="vehicle-detail">
                            <span class="detail-label">Modelo:</span>
                            <span class="detail-value" id="previewModelo">----</span>
                        </div>
                        <div class="vehicle-detail">
                            <span class="detail-label">Color:</span>
                            <span class="detail-value" id="previewColor">Blanco</span>
                        </div>
                    </div>
                </div>
                
                <div class="preview-hint">
                    <i class="fas fa-info-circle"></i> La vista previa se actualiza mientras completas el formulario
                </div>
            </div>
        </div>
    </main>

    <script>
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

            // Función para mostrar/ocultar el campo de nueva marca
            function toggleNuevaMarca() {
                var marcaSelect = document.getElementById('marca');
                var nuevaMarcaDiv = document.getElementById('nueva_marca_div');
                
                if (marcaSelect.value === 'nueva') {
                    nuevaMarcaDiv.style.display = 'block';
                    // Actualizar la vista previa
                    document.getElementById('previewMarca').textContent = 'Nueva marca';
                } else if (marcaSelect.value !== '') {
                    nuevaMarcaDiv.style.display = 'none';
                    // Actualizar la vista previa con la marca seleccionada
                    const marcaOption = marcaSelect.options[marcaSelect.selectedIndex];
                    document.getElementById('previewMarca').textContent = marcaOption.textContent;
                } else {
                    nuevaMarcaDiv.style.display = 'none';
                    document.getElementById('previewMarca').textContent = 'Seleccione una marca';
                }
            }
            
            // Exponer la función al alcance global
            window.toggleNuevaMarca = toggleNuevaMarca;
            
            // Selector de tipo de vehículo
            const toggleCarro = document.getElementById('toggleCarro');
            const toggleMoto = document.getElementById('toggleMoto');
            const tipoVehiculoInput = document.getElementById('tipo_vehiculo');
            const tipoVehiculoBadge = document.getElementById('tipoVehiculo');
            const vehicleIcon = document.getElementById('vehicleIcon');
            const vehicleIconBg = document.getElementById('vehicleIconBg');
            
            toggleCarro.addEventListener('click', function() {
                // Actualizar clases para reflejar selección
                toggleCarro.classList.add('active');
                toggleMoto.classList.remove('active');
                
                // Actualizar valor del input
                tipoVehiculoInput.value = 'carro';
                
                // Actualizar vista previa
                tipoVehiculoBadge.innerHTML = '<i class="fas fa-car-side"></i> Carro';
                tipoVehiculoBadge.classList.remove('badge-moto');
                vehicleIcon.className = 'fas fa-car-side vehicle-icon';
                vehicleIconBg.style.backgroundColor = '#4895ef';
            });
            
            toggleMoto.addEventListener('click', function() {
                toggleMoto.classList.add('active');
                toggleCarro.classList.remove('active');
                tipoVehiculoInput.value = 'moto';
                
                // Actualizar vista previa
                tipoVehiculoBadge.innerHTML = '<i class="fas fa-motorcycle"></i> Moto';
                tipoVehiculoBadge.classList.add('badge-moto');
                vehicleIcon.className = 'fas fa-motorcycle vehicle-icon';
                vehicleIconBg.style.backgroundColor = '#2196F3';
                
                // Forzar recálculo de estilos para asegurar que el toggle-slider se mueva correctamente
                document.getElementById('toggle-slider').style.background = 'linear-gradient(135deg, var(--info), #64b5f6)';
                document.getElementById('toggle-slider').style.boxShadow = '0 2px 10px rgba(33, 150, 243, 0.3)';
            });
            
            // Selector de color
            const colorOptions = document.querySelectorAll('.color-option');
            const colorInput = document.getElementById('color');
            const previewColor = document.getElementById('previewColor');
            const colorSaturation = {
                'Rojo': '#e53935',
                'Azul': '#1e88e5',
                'Verde': '#43a047',
                'Negro': '#212121',
                'Blanco': '#f5f5f5',
                'Gris': '#757575',
                'Plata': '#BDBDBD',
                'Amarillo': '#FDD835',
                'Naranja': '#FB8C00',
                'Morado': '#8E24AA'
            };
            
            colorOptions.forEach(option => {
                option.addEventListener('click', function() {
                    // Quitar class active de todas las opciones
                    colorOptions.forEach(opt => opt.classList.remove('active'));
                    
                    // Añadir active a la opción seleccionada
                    this.classList.add('active');
                    
                    // Actualizar input y vista previa
                    const selectedColor = this.getAttribute('data-color');
                    colorInput.value = selectedColor;
                    previewColor.textContent = selectedColor;
                    
                    // Animar cambio de color en la vista previa
                    vehicleIconBg.style.borderColor = colorSaturation[selectedColor] || '#fff';
                });
            });
            
            // Efectos de formulario
            const formControls = document.querySelectorAll('.form-control, .form-select');
            
            formControls.forEach(input => {
                const parent = input.parentElement;
                
                // Inicializar estado focused si ya tiene valor
                if (input.value) {
                    parent.classList.add('focused');
                }
                
                input.addEventListener('focus', function() {
                    parent.classList.add('focused');
                });
                
                input.addEventListener('blur', function() {
                    if (!this.value) {
                        parent.classList.remove('focused');
                    }
                });
            });
            
            // Validación en tiempo real para campos críticos
            const placaInput = document.getElementById('placa');
            const placaValidIcon = document.getElementById('placaValidIcon');
            const placaValidationMessage = document.getElementById('placaValidationMessage');
            const placaPreview = document.getElementById('placaPreview');
            
            placaInput.addEventListener('input', function() {
                // Convertir a mayúsculas
                this.value = this.value.toUpperCase();
                
                // Actualizar la vista previa
                placaPreview.textContent = this.value || 'ABC123';
                placaPreview.classList.add('shine');
                setTimeout(() => {
                    placaPreview.classList.remove('shine');
                }, 1500);
                
                // Validar formato de placa
                const placaRegex = /^[A-Z0-9]{3,7}$/;
                
                if (this.value === '') {
                    placaValidIcon.classList.remove('valid', 'invalid');
                    placaValidationMessage.classList.remove('show', 'error');
                    this.classList.remove('is-invalid');
                } else if (placaRegex.test(this.value)) {
                    placaValidIcon.classList.add('valid');
                    placaValidIcon.classList.remove('invalid');
                    placaValidationMessage.classList.remove('show', 'error');
                    this.classList.remove('is-invalid');
                } else {
                    placaValidIcon.classList.add('invalid');
                    placaValidIcon.classList.remove('valid');
                    placaValidationMessage.textContent = 'Formato inválido. Use solo letras y números.';
                    placaValidationMessage.classList.add('show', 'error');
                    this.classList.add('is-invalid');
                }
            });
            
            // Validación para el año del modelo
            const modeloInput = document.getElementById('modelo');
            const modeloValidIcon = document.getElementById('modeloValidIcon');
            const modeloValidationMessage = document.getElementById('modeloValidationMessage');
            const previewModelo = document.getElementById('previewModelo');
            
            modeloInput.addEventListener('input', function() {
                // Permitir solo números
                this.value = this.value.replace(/[^0-9]/g, '');
                
                // Actualizar vista previa
                previewModelo.textContent = this.value || '----';
                
                // Validar rango de años (1900 - año actual + 1)
                const currentYear = new Date().getFullYear();
                const modelYear = parseInt(this.value);
                
                if (this.value === '') {
                    modeloValidIcon.classList.remove('valid', 'invalid');
                    modeloValidationMessage.classList.remove('show', 'error');
                    this.classList.remove('is-invalid');
                } else if (modelYear >= 1900 && modelYear <= currentYear + 1) {
                    modeloValidIcon.classList.add('valid');
                    modeloValidIcon.classList.remove('invalid');
                    modeloValidationMessage.classList.remove('show', 'error');
                    this.classList.remove('is-invalid');
                } else {
                    modeloValidIcon.classList.add('invalid');
                    modeloValidIcon.classList.remove('valid');
                    modeloValidationMessage.textContent = `El año debe estar entre 1900 y ${currentYear + 1}`;
                    modeloValidationMessage.classList.add('show', 'error');
                    this.classList.add('is-invalid');
                }
            });
            
            // Campo de nueva marca
            const nuevaMarcaInput = document.getElementById('nueva_marca');
            const marcaValidIcon = document.getElementById('marcaValidIcon');
            
            nuevaMarcaInput.addEventListener('input', function() {
                document.getElementById('previewMarca').textContent = this.value || 'Nueva marca';
                
                if (this.value.length > 2) {
                    marcaValidIcon.classList.add('valid');
                } else {
                    marcaValidIcon.classList.remove('valid');
                }
            });
            
            // Actualizar marca en la vista previa cuando cambia el select
            document.getElementById('marca').addEventListener('change', toggleNuevaMarca);
            
            // Inicializar toggleNuevaMarca para cargar el estado correcto
            toggleNuevaMarca();
            
            // Efecto de validación para el formulario completo
            const vehicleForm = document.getElementById('vehicleForm');
            const submitBtn = document.getElementById('submitBtn');
            
            vehicleForm.addEventListener('submit', function(e) {
                // Podríamos agregar validación adicional aquí si es necesario
                
                // Animar el botón de envío
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Registrando...';
                submitBtn.disabled = true;
                
                // El formulario se enviará normalmente
            });
        });
    </script>
</body>
</html>