<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Solicitar Turno - Service Center</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://npmcdn.com/flatpickr/dist/l10n/es.js"></script>
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

        /* Formulario de solicitud de turno */
        .solicitud-container {
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

        /* Estilos para el formulario */
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

        .form-textarea {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid var(--gray-light);
            border-radius: 10px;
            font-family: 'Poppins', sans-serif;
            font-size: 14px;
            transition: all var(--transition-speed) ease;
            min-height: 120px;
            resize: vertical;
            background-color: transparent;
        }

        .form-textarea:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.1);
            outline: none;
        }

        body.dark-mode .form-textarea {
            background-color: #2d2d2d;
            border-color: #444;
            color: var(--light);
        }

        /* Animación checkbox verificación */
        .checkbox-container {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }

        .custom-checkbox {
            display: inline-block;
            width: 24px;
            height: 24px;
            background-color: white;
            border: 2px solid var(--gray-light);
            border-radius: 6px;
            margin-right: 10px;
            position: relative;
            cursor: pointer;
            transition: all var(--transition-speed) ease;
        }

        .custom-checkbox::after {
            content: '';
            position: absolute;
            display: none;
            left: 8px;
            top: 3px;
            width: 6px;
            height: 12px;
            border: solid white;
            border-width: 0 2px 2px 0;
            transform: rotate(45deg);
        }

        .checkbox-input {
            display: none;
        }

        .checkbox-input:checked + .custom-checkbox {
            background-color: var(--primary);
            border-color: var(--primary);
        }

        .checkbox-input:checked + .custom-checkbox::after {
            display: block;
        }

        body.dark-mode .custom-checkbox {
            background-color: #2d2d2d;
            border-color: #444;
        }

        .checkbox-label {
            font-size: 14px;
            color: var(--dark);
        }

        body.dark-mode .checkbox-label {
            color: var(--light);
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

        .btn-danger {
            background: linear-gradient(135deg, var(--error), #e57373);
            color: white;
        }

        .btn-danger:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(244, 67, 54, 0.3);
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

        /* Vista previa del turno */
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
            overflow: hidden;
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

        .turno-preview {
            border-radius: 18px;
            padding: 0;
            display: flex;
            flex-direction: column;
            position: relative;
            overflow: hidden;
            margin-bottom: 25px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
            transform: translateY(0);
            transition: all 0.3s ease;
        }
        
        .turno-preview:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.12);
        }

        .turno-header {
            background: linear-gradient(135deg, var(--primary), var(--primary-light));
            padding: 25px;
            color: white;
            position: relative;
            overflow: hidden;
            border-radius: 18px 18px 0 0;
        }

        .turno-header::before {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            bottom: 0;
            left: 0;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='100' height='100' viewBox='0 0 100 100'%3E%3Cpath fill='rgba(255,255,255,0.1)' d='M11 18c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm48 25c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm-43-7c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm63 31c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM34 90c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm56-76c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM12 86c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm28-65c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm23-11c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-6 60c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm29 22c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zM32 63c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm57-13c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-9-21c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM60 91c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM35 41c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM12 60c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2z'%3E%3C/path%3E%3C/svg%3E");
            opacity: 0.3;
        }

        .turno-title {
            font-size: 20px;
            font-weight: 600;
            margin-bottom: 15px;
            position: relative;
        }

        .vehicle-info {
            display: flex;
            align-items: center;
            position: relative;
        }

        .vehicle-icon {
            width: 40px;
            height: 40px;
            background-color: rgba(255, 255, 255, 0.2);
            border-radius: 10px;
            display: flex;
            justify-content: center;
            align-items: center;
            margin-right: 15px;
        }

        .vehicle-icon i {
            font-size: 20px;
            color: white;
        }

        .vehicle-text {
            font-size: 16px;
            font-weight: 500;
        }

        .turno-body {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 0 0 15px 15px;
        }

        body.dark-mode .turno-body {
            background-color: #2d2d2d;
        }

        .turno-detail {
            display: flex;
            margin-bottom: 15px;
            align-items: flex-start;
        }

        .turno-detail:last-child {
            margin-bottom: 0;
        }

        .detail-icon {
            width: 30px;
            height: 30px;
            background-color: rgba(67, 97, 238, 0.1);
            border-radius: 8px;
            display: flex;
            justify-content: center;
            align-items: center;
            margin-right: 15px;
            color: var(--primary);
            flex-shrink: 0;
        }

        body.dark-mode .detail-icon {
            background-color: rgba(67, 97, 238, 0.2);
        }

        .detail-content {
            flex: 1;
        }

        .detail-label {
            font-size: 12px;
            color: var(--gray);
            margin-bottom: 3px;
        }

        body.dark-mode .detail-label {
            color: var(--gray-light);
        }

        .detail-value {
            font-size: 15px;
            font-weight: 500;
            color: var(--dark);
        }

        body.dark-mode .detail-value {
            color: var(--light);
        }

        .price-tag {
            display: inline-block;
            padding: 5px 10px;
            background-color: rgba(67, 97, 238, 0.1);
            color: var(--primary);
            border-radius: 8px;
            font-weight: 600;
        }

        body.dark-mode .price-tag {
            background-color: rgba(67, 97, 238, 0.2);
        }

        .turno-datetime {
            display: flex;
            gap: 15px;
            margin-bottom: 15px;
        }

        .datetime-box {
            flex: 1;
            background-color: white;
            border-radius: 15px;
            padding: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            transition: all var(--transition-speed) ease;
            position: relative;
            overflow: hidden;
        }
        
        .datetime-box::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 3px;
            background: linear-gradient(90deg, var(--primary-light), var(--primary));
            opacity: 0;
            transition: opacity 0.3s ease;
        }
        
        .datetime-box:hover::after {
            opacity: 1;
        }

        body.dark-mode .datetime-box {
            background-color: #1e1e1e;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }

        .datetime-box i {
            font-size: 24px;
            color: var(--primary);
            margin-bottom: 10px;
        }

        .datetime-label {
            font-size: 12px;
            color: var(--gray);
            margin-bottom: 5px;
        }

        body.dark-mode .datetime-label {
            color: var(--gray-light);
        }

        .datetime-value {
            font-size: 15px;
            font-weight: 600;
            color: var(--dark);
        }

        body.dark-mode .datetime-value {
            color: var(--light);
        }

        .comments-box {
            background-color: white;
            border-radius: 10px;
            padding: 15px;
            margin-top: 15px;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.05);
            transition: all var(--transition-speed) ease;
        }

        body.dark-mode .comments-box {
            background-color: #1e1e1e;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.2);
        }

        .comments-label {
            font-size: 12px;
            color: var(--gray);
            margin-bottom: 5px;
            display: flex;
            align-items: center;
        }

        .comments-label i {
            margin-right: 5px;
            color: var(--primary);
        }

        body.dark-mode .comments-label {
            color: var(--gray-light);
        }

        .comments-value {
            font-size: 14px;
            color: var(--dark);
            white-space: pre-line;
            font-style: italic;
        }

        body.dark-mode .comments-value {
            color: var(--light);
        }

        .empty-comments {
            font-size: 14px;
            color: var(--gray);
            font-style: italic;
        }

        body.dark-mode .empty-comments {
            color: var(--gray-light);
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

        /* Estilos para Flatpickr */
        .flatpickr-calendar {
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.15);
            font-family: 'Poppins', sans-serif;
        }

        .flatpickr-day.selected, 
        .flatpickr-day.startRange, 
        .flatpickr-day.endRange, 
        .flatpickr-day.selected.inRange, 
        .flatpickr-day.startRange.inRange, 
        .flatpickr-day.endRange.inRange, 
        .flatpickr-day.selected:focus, 
        .flatpickr-day.startRange:focus, 
        .flatpickr-day.endRange:focus, 
        .flatpickr-day.selected:hover, 
        .flatpickr-day.startRange:hover, 
        .flatpickr-day.endRange:hover, 
        .flatpickr-day.selected.prevMonthDay, 
        .flatpickr-day.startRange.prevMonthDay, 
        .flatpickr-day.endRange.prevMonthDay, 
        .flatpickr-day.selected.nextMonthDay, 
        .flatpickr-day.startRange.nextMonthDay, 
        .flatpickr-day.endRange.nextMonthDay {
            background: var(--primary);
            border-color: var(--primary);
        }
        
        /* Estilos mejorados para días deshabilitados */
        .flatpickr-day.disabled,
        .flatpickr-day.disabled:hover,
        .flatpickr-day.prevMonthDay.disabled,
        .flatpickr-day.nextMonthDay.disabled,
        .flatpickr-day.notAllowed,
        .flatpickr-day.notAllowed.prevMonthDay,
        .flatpickr-day.notAllowed.nextMonthDay {
            background-color: #f0f0f0;
            border-color: transparent;
            color: #aaa;
            cursor: not-allowed;
            pointer-events: none;
            position: relative;
        }
        
        /* Estilo para días de meses adyacentes deshabilitados */
        .flatpickr-day.prevMonthDay.disabled,
        .flatpickr-day.nextMonthDay.disabled {
            background-color: #f7f7f7;
            color: #ccc;
        }

        .flatpickr-day.selected.startRange + .endRange:not(:nth-child(7n+1)), 
        .flatpickr-day.startRange.startRange + .endRange:not(:nth-child(7n+1)), 
        .flatpickr-day.endRange.startRange + .endRange:not(:nth-child(7n+1)) {
            box-shadow: -10px 0 0 var(--primary);
        }

        .flatpickr-time input:hover, 
        .flatpickr-time .flatpickr-am-pm:hover, 
        .flatpickr-time input:focus, 
        .flatpickr-time .flatpickr-am-pm:focus {
            background: rgba(67, 97, 238, 0.1);
        }

        .flatpickr-months .flatpickr-month {
            background: var(--primary);
            color: white;
        }

        .flatpickr-current-month .flatpickr-monthDropdown-months {
            background: var(--primary);
            color: white;
        }

        .flatpickr-current-month .flatpickr-monthDropdown-months .flatpickr-monthDropdown-month {
            background-color: white;
            color: var(--dark);
        }

        .flatpickr-weekdays {
            background: var(--primary);
            color: white;
        }

        span.flatpickr-weekday {
            background: var(--primary);
            color: white;
        }

        .flatpickr-months .flatpickr-prev-month,
        .flatpickr-months .flatpickr-next-month {
            fill: white;
        }

        body.dark-mode .flatpickr-calendar {
            background: #1e1e1e;
            color: var(--light);
            border-color: #444;
        }

        body.dark-mode .flatpickr-day {
            color: var(--light);
            border-color: #444;
        }

        body.dark-mode .flatpickr-day.prevMonthDay,
        body.dark-mode .flatpickr-day.nextMonthDay {
            color: #666;
        }

        body.dark-mode .flatpickr-day.disabled,
        body.dark-mode .flatpickr-day.disabled:hover,
        body.dark-mode .flatpickr-day.prevMonthDay.disabled,
        body.dark-mode .flatpickr-day.nextMonthDay.disabled,
        body.dark-mode .flatpickr-day.notAllowed,
        body.dark-mode .flatpickr-day.notAllowed.prevMonthDay,
        body.dark-mode .flatpickr-day.notAllowed.nextMonthDay {
            background-color: #2a2a2a;
            border-color: transparent;
            color: #555;
        }
        
        body.dark-mode .flatpickr-day.prevMonthDay.disabled,
        body.dark-mode .flatpickr-day.nextMonthDay.disabled {
            background-color: #252525;
            color: #444;
        }

        body.dark-mode .flatpickr-time {
            border-top-color: #444;
        }

        body.dark-mode .flatpickr-time input, 
        body.dark-mode .flatpickr-time .flatpickr-am-pm {
            color: var(--light);
            background: #2d2d2d;
        }

        body.dark-mode .flatpickr-time .flatpickr-time-separator {
            color: var(--light);
        }

        /* Estilos para iconos en los campos */
        .calendar-icon, .clock-icon {
            cursor: pointer;
        }

        /* Estilo para contenedor principal más responsivo */
        @media screen and (max-width: 1199px) {
            .main-content {
                padding: 25px;
            }
        }

        @media screen and (max-width: 991px) {
            .solicitud-container {
                grid-template-columns: 1fr;
                gap: 30px;
            }

            .preview-container {
                position: sticky;
                top: 20px;
                margin-bottom: 25px;
                order: -1;
                max-height: calc(100vh - 40px);
                overflow-y: auto;
            }

            .content-header {
                padding: 15px 20px;
                position: sticky;
                top: 0;
                z-index: 90;
                margin-bottom: 25px;
                transition: box-shadow 0.3s ease;
            }
            
            .content-header.sticky {
                box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            }

            .header-title {
                font-size: 22px;
            }
        }

        /* Mobile responsive styles */
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
                gap: 12px;
            }

            .btn {
                width: 100%;
            }

            .turno-datetime {
                flex-direction: column;
                gap: 15px;
            }
            
            /* Animación de carga para móviles */
            @keyframes driveCar {
                0% { transform: translateX(-30px) scaleX(1); }
                49% { transform: translateX(30px) scaleX(1); }
                50% { transform: translateX(30px) scaleX(-1); }
                99% { transform: translateX(-30px) scaleX(-1); }
                100% { transform: translateX(-30px) scaleX(1); }
            }
        }
        
        /* Extremely small screens */
        @media screen and (max-width: 480px) {
            .main-content {
                padding: 15px 12px;
            }
            
            .content-header {
                padding: 15px;
                margin-bottom: 20px;
            }
            
            .form-container, .preview-container {
                padding: 20px 15px;
            }

            .turno-header {
                padding: 20px 15px;
            }

            .turno-body {
                padding: 20px 15px;
            }
            
            .turno-preview {
                margin-bottom: 20px;
            }
            
            .preview-title, .form-title {
                font-size: 18px;
                margin-bottom: 20px;
            }
            
            .form-hint {
                font-size: 11px;
            }
            
            .form-control, .form-select, .form-textarea {
                padding: 10px 12px;
                font-size: 13px;
            }
            
            .validation-icon {
                right: 12px;
                top: 12px;
            }
            
            /* Labels more compact */
            .form-label {
                font-size: 13px;
                left: 12px;
                top: 10px;
            }
            
            .form-group.focused .form-label {
                transform: translateY(-22px) scale(0.85);
            }
            
            /* Even smaller device adjustments */
            @media screen and (max-width: 360px) {
                .form-container, .preview-container {
                    padding: 15px 12px;
                }
                
                .datetime-box i {
                    font-size: 20px;
                    margin-bottom: 5px;
                }
                
                .vehicle-icon {
                    width: 36px;
                    height: 36px;
                }
                
                .vehicle-text {
                    font-size: 14px;
                }
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
            <span class="logo-text">AutoService</span>
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
            <a href="{{ route('cliente.vehiculos.create') }}" class="nav-item">
                <i class="fas fa-plus-circle"></i>
                <span class="nav-item-text">Añadir Vehículo</span>
                <div class="menu-tooltip">Añadir Vehículo</div>
            </a>
            
            <div class="menu-label">Servicios</div>
            <a href="{{ route('cliente.turnos.solicitar') }}" class="nav-item active">
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
                <h1 class="header-title">Solicitar Turno</h1>
                <div class="header-subtitle">
                    <span>Programa un nuevo servicio para tu vehículo</span>
                </div>
            </div>
            <div class="header-actions">
                <button class="theme-toggle" id="themeToggle">
                    <i class="fas fa-moon"></i>
                </button>
            </div>
        </div>

        <!-- Alertas -->
        @if (session('success'))
            <div class="alert alert-success">
                <i class="fas fa-check-circle" style="margin-right: 10px;"></i>
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">
                <i class="fas fa-exclamation-circle" style="margin-right: 10px;"></i>
                {{ session('error') }}
            </div>
        @endif

        <!-- Contenedor principal con formulario y vista previa -->
        <div class="solicitud-container">
            <!-- Formulario de solicitud -->
            <div class="form-container">
                <h2 class="form-title">
                    <i class="fas fa-calendar-plus"></i> Detalles del turno
                </h2>

                <form method="POST" action="{{ route('cliente.turnos.store') }}" id="turnoForm">
                    @csrf
                    <!-- Campo oculto para enviar la fecha en formato correcto -->
                    <input type="hidden" id="fecha_hidden" name="fecha" value="{{ old('fecha') ? date('Y-m-d', strtotime(str_replace('/', '-', old('fecha')))) : '' }}">
                    
                    <!-- Campo vehículo -->
                    <div class="form-group">
                        <select id="id_vehiculo" name="id_vehiculo" class="form-select" required>
                            <option value="">Seleccione un vehículo</option>
                            @foreach($vehiculos as $vehiculo)
                                <option value="{{ $vehiculo->id_vehiculo }}" 
                                    {{ old('id_vehiculo') == $vehiculo->id_vehiculo ? 'selected' : '' }}
                                    data-tipo="{{ $vehiculo->tipo_vehiculo ?? 'carro' }}"
                                    data-placa="{{ $vehiculo->placa }}">
                                    {{ $vehiculo->placa }} - {{ ucfirst($vehiculo->tipo_vehiculo ?? 'carro') }}
                                </option>
                            @endforeach
                        </select>
                        @error('id_vehiculo')
                            <div class="validation-message show error">{{ $message }}</div>
                        @enderror
                        <span class="form-hint">Selecciona el vehículo que deseas llevar al servicio</span>
                    </div>
                    
                    <!-- Campo servicio -->
                    <div class="form-group">
                        <select id="id_servicio" name="id_servicio" class="form-select" required>
                            <option value="">Seleccione un vehículo primero</option>
                        </select>
                        @error('id_servicio')
                            <div class="validation-message show error">{{ $message }}</div>
                        @enderror
                        <span class="form-hint">El precio varía según el tipo de vehículo y servicio</span>
                    </div>
                    
                    <!-- Contenedor para fecha y hora en la misma fila -->
                    <div class="date-time-container" style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                        <!-- Campo fecha -->
                        <div class="form-group">
                            <input type="text" id="fecha_display" name="fecha_display" class="form-control datepicker-input" 
                                value="{{ old('fecha') }}" placeholder="Seleccionar fecha" required readonly>
                            <label for="fecha_display" class="form-label">Fecha</label>
                            <i class="fas fa-calendar-alt calendar-icon" style="position: absolute; right: 15px; top: 14px; color: var(--primary); cursor: pointer;"></i>
                            <i class="fas fa-check validation-icon" id="fechaValidIcon" style="right: 40px;"></i>
                            @error('fecha')
                                <div class="validation-message show error">{{ $message }}</div>
                            @enderror
                            <span class="form-hint">A partir de hoy</span>
                        </div>
                        
                        <!-- Campo hora -->
                        <div class="form-group">
                            <input type="text" id="hora" name="hora" class="form-control timepicker-input" 
                                value="{{ old('hora') }}" placeholder="Seleccionar hora" required readonly>
                            <label for="hora" class="form-label">Hora</label>
                            <i class="fas fa-clock clock-icon" style="position: absolute; right: 15px; top: 14px; color: var(--primary); cursor: pointer;"></i>
                            <i class="fas fa-check validation-icon" id="horaValidIcon" style="right: 40px;"></i>
                            @error('hora')
                                <div class="validation-message show error">{{ $message }}</div>
                            @enderror
                            <span class="form-hint">Entre 8:00 y 18:00</span>
                        </div>
                    </div>
                    
                    <!-- Campo comentarios -->
                    <div class="form-group">
                        <textarea id="comentarios" name="comentarios" class="form-textarea">{{ old('comentarios') }}</textarea>
                        <label for="comentarios" class="form-label">Comentarios (Opcional)</label>
                        @error('comentarios')
                            <div class="validation-message show error">{{ $message }}</div>
                        @enderror
                        <span class="form-hint">Agrega cualquier información adicional relevante para el servicio</span>
                    </div>
                    
                    <!-- Botones de acción -->
                    <div class="form-actions">
                        <button type="submit" class="btn btn-success" id="submitBtn">
                            <i class="fas fa-calendar-check"></i> Solicitar Turno
                        </button>
                        <a href="{{ route('cliente.turnos') }}" class="btn btn-danger">
                            <i class="fas fa-times"></i> Cancelar
                        </a>
                    </div>
                </form>
            </div>
            
            <!-- Vista previa del turno -->
            <div class="preview-container">
                <h2 class="preview-title">
                    <i class="fas fa-eye"></i> Vista previa
                </h2>
                
                <div class="turno-preview">
                    <div class="turno-header">
                        <h3 class="turno-title">Reserva de Servicio</h3>
                        <div class="vehicle-info">
                            <div class="vehicle-icon">
                                <i class="fas fa-car-side" id="previewVehicleIcon"></i>
                            </div>
                            <div class="vehicle-text" id="previewVehicleText">
                                Seleccione un vehículo
                            </div>
                        </div>
                    </div>
                    
                    <div class="turno-body">
                        <div class="turno-detail">
                            <div class="detail-icon">
                                <i class="fas fa-tools"></i>
                            </div>
                            <div class="detail-content">
                                <div class="detail-label">Servicio</div>
                                <div class="detail-value" id="previewServicio">
                                    Seleccione un servicio
                                </div>
                            </div>
                        </div>
                        
                        <div class="turno-detail">
                            <div class="detail-icon">
                                <i class="fas fa-tag"></i>
                            </div>
                            <div class="detail-content">
                                <div class="detail-label">Precio</div>
                                <div class="detail-value">
                                    <span class="price-tag" id="previewPrecio">$0</span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="turno-datetime">
                            <div class="datetime-box">
                                <i class="far fa-calendar-alt"></i>
                                <div class="datetime-label">Fecha</div>
                                <div class="datetime-value" id="previewFecha">--/--/----</div>
                            </div>
                            
                            <div class="datetime-box">
                                <i class="far fa-clock"></i>
                                <div class="datetime-label">Hora</div>
                                <div class="datetime-value" id="previewHora">--:--</div>
                            </div>
                        </div>
                        
                        <div class="comments-box">
                            <div class="comments-label">
                                <i class="fas fa-comment-alt"></i> Comentarios
                            </div>
                            <div class="comments-value" id="previewComentarios">
                                <span class="empty-comments">Sin comentarios</span>
                            </div>
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
        $(document).ready(function() {
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

            // Efectos de formulario - Labels flotantes
            const formControls = document.querySelectorAll('.form-control, .form-textarea');
            
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

            // Cargar servicios cuando cambia el vehículo
            $('#id_vehiculo').change(function() {
                var vehiculoId = $(this).val();
                
                // Actualizar la vista previa del vehículo
                if (vehiculoId) {
                    const selectedOption = $(this).find('option:selected');
                    const tipoVehiculo = selectedOption.data('tipo');
                    const placaVehiculo = selectedOption.data('placa');
                    
                    // Actualizar icono según tipo
                    if (tipoVehiculo === 'moto') {
                        $('#previewVehicleIcon').removeClass('fa-car-side').addClass('fa-motorcycle');
                    } else {
                        $('#previewVehicleIcon').removeClass('fa-motorcycle').addClass('fa-car-side');
                    }
                    
                    // Actualizar texto
                    $('#previewVehicleText').text(placaVehiculo + ' - ' + tipoVehiculo.charAt(0).toUpperCase() + tipoVehiculo.slice(1));
                    
                    // Realizar petición AJAX para obtener servicios
                    $.ajax({
                        url: '/servicios-por-vehiculo/' + vehiculoId,
                        type: 'GET',
                        dataType: 'json',
                        beforeSend: function() {
                            $('#id_servicio').html('<option value="">Cargando servicios...</option>');
                            $('#previewServicio').text('Cargando servicios...');
                            $('#previewPrecio').text('$0');
                        },
                        success: function(data) {
                            var servicioSelect = $('#id_servicio');
                            servicioSelect.empty();
                            
                            if (data.length === 0) {
                                servicioSelect.append('<option value="">No hay servicios disponibles para este vehículo</option>');
                                $('#previewServicio').text('No hay servicios disponibles');
                            } else {
                                servicioSelect.append('<option value="">Seleccione un servicio</option>');
                                $.each(data, function(key, value) {
                                    servicioSelect.append('<option value="' + value.id_servicio + '" data-precio="' + value.precio + '">' + 
                                        value.nombre + ' - $' + new Intl.NumberFormat('es-CO').format(value.precio) + '</option>');
                                });
                                $('#previewServicio').text('Seleccione un servicio');
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error('Error al obtener servicios:', error);
                            $('#id_servicio').empty().append('<option value="">Error al cargar servicios</option>');
                            $('#previewServicio').text('Error al cargar servicios');
                        }
                    });
                } else {
                    $('#id_servicio').empty().append('<option value="">Seleccione un vehículo primero</option>');
                    $('#previewVehicleIcon').removeClass('fa-motorcycle').addClass('fa-car-side');
                    $('#previewVehicleText').text('Seleccione un vehículo');
                    $('#previewServicio').text('Seleccione un servicio');
                    $('#previewPrecio').text('$0');
                }
            });
            
            // Actualizar vista previa cuando cambia el servicio
            $('#id_servicio').change(function() {
                var selectedOption = $(this).find('option:selected');
                
                if (selectedOption.val()) {
                    const nombreServicio = selectedOption.text().split(' - ')[0];
                    const precioServicio = selectedOption.data('precio');
                    
                    $('#previewServicio').text(nombreServicio);
                    $('#previewPrecio').text('$' + new Intl.NumberFormat('es-CO').format(precioServicio));
                } else {
                    $('#previewServicio').text('Seleccione un servicio');
                    $('#previewPrecio').text('$0');
                }
            });
            
            // Inicializar flatpickr para la fecha
            const fechaFlatpickr = flatpickr("#fecha_display", {
                locale: 'es',
                dateFormat: "d/m/Y",
                minDate: "today",
                disableMobile: "true", // Fuerza el uso del calendario incluso en móviles
                altInput: false,       // No usamos input alternativo para evitar confusiones
                allowInput: false,     // No permitimos escritura directa
                static: true,          // Para dispositivos móviles
                // Deshabilitar todos los días anteriores a hoy
                disable: [
                    {
                        from: "1900-01-01",
                        to: new Date(new Date().setDate(new Date().getDate() - 1))
                    }
                ],
                onChange: function(selectedDates, dateStr, instance) {
                    if (selectedDates.length > 0) {
                        // Actualizar la vista previa inmediatamente al cambiar
                        const fecha = selectedDates[0];
                        const dia = fecha.getDate().toString().padStart(2, '0');
                        const mes = (fecha.getMonth() + 1).toString().padStart(2, '0');
                        const anio = fecha.getFullYear();
                        
                        // Formatear la fecha en formato del backend (yyyy-mm-dd)
                        const formattedDate = anio + '-' + mes + '-' + dia;
                        
                        // Actualizar el campo oculto con la fecha en formato correcto para el backend
                        $('#fecha_hidden').val(formattedDate);
                        
                        // Actualizar la vista previa
                        $('#previewFecha').text(dia + '/' + mes + '/' + anio);
                        
                        // Validación de fecha
                        const fechaValidIcon = document.getElementById('fechaValidIcon');
                        const hoy = new Date();
                        hoy.setHours(0, 0, 0, 0);
                        
                        if (fecha >= hoy) {
                            fechaValidIcon.classList.add('valid');
                            fechaValidIcon.classList.remove('invalid');
                            $('#fecha_display').removeClass('is-invalid');
                        } else {
                            fechaValidIcon.classList.add('invalid');
                            fechaValidIcon.classList.remove('valid');
                            $('#fecha_display').addClass('is-invalid');
                        }
                        
                        // Manejar el label flotante
                        $('#fecha_display').parent().addClass('focused');
                    }
                }
            });
            
            // Hacer que el icono de calendario también abra el selector
            $('.calendar-icon').on('click', function() {
                fechaFlatpickr.open();
            });
            
            // Inicializar flatpickr para la hora
            const horaFlatpickr = flatpickr("#hora", {
                enableTime: true,
                noCalendar: true,
                dateFormat: "H:i",
                time_24hr: true,
                minTime: "08:00",
                maxTime: "17:59",
                disableMobile: "true", // Fuerza el uso del selector incluso en móviles
                static: true,          // Para dispositivos móviles
                locale: {
                    ...flatpickr.l10ns.es,
                    firstDayOfWeek: 1
                },
                onChange: function(selectedDates, dateStr, instance) {
                    if (dateStr) {
                        // Formatear la hora en formato de 12 horas AM/PM para la vista previa
                        const [hours, minutes] = dateStr.split(':');
                        const hora = parseInt(hours);
                        const ampm = hora >= 12 ? 'PM' : 'AM';
                        const hora12 = (hora % 12) || 12;
                        
                        $('#previewHora').text(hora12 + ':' + minutes + ' ' + ampm);
                        
                        // Validación de hora (de 8:00 a 18:00)
                        const horaValidIcon = document.getElementById('horaValidIcon');
                        
                        if (hora >= 8 && hora < 18) {
                            horaValidIcon.classList.add('valid');
                            horaValidIcon.classList.remove('invalid');
                            $('#hora').removeClass('is-invalid');
                        } else {
                            horaValidIcon.classList.add('invalid');
                            horaValidIcon.classList.remove('valid');
                            $('#hora').addClass('is-invalid');
                        }
                        
                        // Manejar el label flotante
                        $('#hora').parent().addClass('focused');
                    }
                }
            });
            
            // Hacer que el icono de reloj también abra el selector
            $('.clock-icon').on('click', function() {
                horaFlatpickr.open();
            });
            
            // Actualizar vista previa cuando cambian los comentarios
            $('#comentarios').on('input', function() {
                if (this.value.trim()) {
                    $('#previewComentarios').html(this.value.replace(/\n/g, '<br>'));
                } else {
                    $('#previewComentarios').html('<span class="empty-comments">Sin comentarios</span>');
                }
            });
            
            // Validación completa del formulario antes de enviar
            $('#turnoForm').on('submit', function(e) {
                let isValid = true;
                const errores = [];
                
                // Validar vehículo
                if (!$('#id_vehiculo').val()) {
                    isValid = false;
                    errores.push('Debe seleccionar un vehículo');
                    $('#id_vehiculo').addClass('is-invalid');
                } else {
                    $('#id_vehiculo').removeClass('is-invalid');
                }
                
                // Validar servicio
                if (!$('#id_servicio').val()) {
                    isValid = false;
                    errores.push('Debe seleccionar un servicio');
                    $('#id_servicio').addClass('is-invalid');
                } else {
                    $('#id_servicio').removeClass('is-invalid');
                }
                
                // Validar fecha
                if (!$('#fecha_hidden').val()) {
                    isValid = false;
                    errores.push('Debe seleccionar una fecha');
                    $('#fecha_display').addClass('is-invalid');
                } else {
                    $('#fecha_display').removeClass('is-invalid');
                }
                
                // Validar hora
                if (!$('#hora').val()) {
                    isValid = false;
                    errores.push('Debe seleccionar una hora');
                    $('#hora').addClass('is-invalid');
                }
                
                // Si hay errores, mostrar alerta y evitar envío
                if (!isValid) {
                    e.preventDefault();
                    
                    // Crear alerta de error
                    const alertaHTML = `
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-circle" style="margin-right: 10px;"></i>
                        <strong>Por favor corrija los siguientes errores:</strong>
                        <ul style="margin-top: 10px; margin-bottom: 0;">
                            ${errores.map(error => `<li>${error}</li>`).join('')}
                        </ul>
                    </div>`;
                    
                    // Insertar alerta antes del formulario
                    const alertaExistente = $('.alert.alert-danger');
                    if (alertaExistente.length) {
                        alertaExistente.remove();
                    }
                    $('.content-header').after(alertaHTML);
                    
                    // Scroll hacia la alerta
                    $('html, body').animate({
                        scrollTop: $('.alert.alert-danger').offset().top - 30
                    }, 500);
                    
                    return false;
                } else {
                    // Asegurarnos de enviar la fecha en formato correcto para el backend
                    // Si no existe el campo oculto, tomamos el valor del campo normal
                    if (!$('#fecha_hidden').length && $('#fecha').val()) {
                        const fechaArr = $('#fecha').val().split('/');
                        if (fechaArr.length === 3) {
                            const formattedDate = fechaArr[2] + '-' + fechaArr[1] + '-' + fechaArr[0];
                            $('<input>').attr({
                                type: 'hidden',
                                id: 'fecha_hidden',
                                name: 'fecha_hidden',
                                value: formattedDate
                            }).appendTo('#turnoForm');
                        }
                    }
                    
                    // Mostrar animación de carga
                    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Procesando...';
                    submitBtn.disabled = true;
                    
                    // Mostrar overlay de carga mejorado
                    const loadingOverlay = `
                    <div id="submitOverlay" style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; 
                         background-color: rgba(0, 0, 0, 0.7); backdrop-filter: blur(5px); z-index: 9999; 
                         display: flex; justify-content: center; align-items: center; flex-direction: column;">
                        <div class="loading-card" style="background: linear-gradient(135deg, #fff, #f8f9fa); padding: 35px 40px; 
                             border-radius: 20px; text-align: center; box-shadow: 0 15px 35px rgba(0, 0, 0, 0.3); 
                             max-width: 90%; width: 370px; transform: translateY(0); animation: float 3s infinite alternate ease-in-out;">
                            
                            <div class="vehicle-animation" style="position: relative; height: 70px; margin-bottom: 25px;">
                                <i class="fas fa-car-side" style="font-size: 45px; color: var(--primary); position: relative; 
                                   animation: driveCar 3s infinite linear;"></i>
                                <div style="position: absolute; bottom: 0; width: 100%; height: 2px; background: linear-gradient(90deg, transparent, var(--primary), transparent);"></div>
                                <div style="position: absolute; width: 12px; height: 12px; border-radius: 50%; background-color: var(--accent);
                                     top: 35%; left: 15%; animation: pulse 1.5s infinite ease-in-out;"></div>
                                <div style="position: absolute; width: 8px; height: 8px; border-radius: 50%; background-color: var(--secondary);
                                     top: 20%; right: 25%; animation: pulse 1.5s infinite ease-in-out; animation-delay: 0.5s;"></div>
                            </div>
                            
                            <h3 style="margin-bottom: 15px; font-size: 24px; color: var(--primary-dark); font-weight: 600;">Procesando su solicitud</h3>
                            <p style="margin-bottom: 25px; color: var(--gray-dark); font-size: 15px;">Estamos registrando su turno, por favor espere...</p>
                            
                            <div class="progress-container" style="width: 100%; height: 8px; background-color: rgba(0, 0, 0, 0.1);
                                 border-radius: 10px; overflow: hidden; margin: 15px 0;">
                                <div class="progress-bar-animated" style="height: 100%; width: 0; background: linear-gradient(90deg, var(--primary), var(--primary-light), var(--accent));
                                     border-radius: 10px; animation: loadProgressAnimated 2.5s forwards ease-in-out;"></div>
                            </div>
                            
                            <div style="font-size: 13px; color: var(--gray); margin-top: 15px;">
                                <i class="fas fa-check-circle" style="color: var(--success); margin-right: 5px;"></i> 
                                <span class="processing-status">Validando información...</span>
                            </div>
                        </div>
                    </div>
                    
                    <style>
                        @keyframes driveCar {
                            0% { transform: translateX(-50px) scaleX(1); }
                            49% { transform: translateX(50px) scaleX(1); }
                            50% { transform: translateX(50px) scaleX(-1); }
                            99% { transform: translateX(-50px) scaleX(-1); }
                            100% { transform: translateX(-50px) scaleX(1); }
                        }
                        
                        @keyframes pulse {
                            0%, 100% { transform: scale(0.8); opacity: 0.5; }
                            50% { transform: scale(1.3); opacity: 1; }
                        }
                        
                        @keyframes float {
                            0% { transform: translateY(0px); }
                            100% { transform: translateY(-10px); }
                        }
                        
                        @keyframes loadProgressAnimated {
                            0% { width: 0; }
                            15% { width: 15%; }
                            35% { width: 40%; }
                            65% { width: 70%; }
                            85% { width: 85%; }
                            100% { width: 98%; }
                        }
                        
                        @media (max-width: 576px) {
                            .loading-card {
                                padding: 25px !important;
                                width: 85% !important;
                            }
                            
                            .vehicle-animation {
                                height: 55px !important;
                                margin-bottom: 15px !important;
                            }
                            
                            .vehicle-animation i {
                                font-size: 35px !important;
                            }
                        }
                    </style>`;
                    
                    $('body').append(loadingOverlay);
                    
                    // Cambiar el texto de estado después de un tiempo
                    setTimeout(() => {
                        $('.processing-status').html('<span style="color: var(--success);">¡Información validada!</span> Guardando turno...');
                    }, 1500);
                    
                    // Cambiar color del texto en modo oscuro
                    if (document.body.classList.contains('dark-mode')) {
                        $('.loading-card').css({
                            'background': 'linear-gradient(135deg, #2a2a2a, #1e1e1e)',
                            'color': '#f8f9fa'
                        });
                        $('.loading-card h3').css('color', '#f8f9fa');
                        $('.loading-card p').css('color', '#adb5bd');
                    }
                }
                
                // Si hay errores, mostrar alerta y evitar envío
                if (!isValid) {
                    e.preventDefault();
                    
                    // Crear alerta de error
                    const alertaHTML = `
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-circle" style="margin-right: 10px;"></i>
                        <strong>Por favor corrija los siguientes errores:</strong>
                        <ul style="margin-top: 10px; margin-bottom: 0;">
                            ${errores.map(error => `<li>${error}</li>`).join('')}
                        </ul>
                    </div>`;
                    
                    // Insertar alerta antes del formulario
                    const alertaExistente = $('.alert.alert-danger');
                    if (alertaExistente.length) {
                        alertaExistente.remove();
                    }
                    $('.content-header').after(alertaHTML);
                    
                    // Scroll hacia la alerta
                    $('html, body').animate({
                        scrollTop: $('.alert.alert-danger').offset().top - 30
                    }, 500);
                    
                    return false;
                } else {
                    // Mostrar animación de carga
                    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Procesando...';
                    submitBtn.disabled = true;
                    
                    // Mostrar overlay de carga
                    const loadingOverlay = `
                    <div id="submitOverlay" style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; 
                         background-color: rgba(0, 0, 0, 0.5); z-index: 9999; display: flex; justify-content: center; 
                         align-items: center; flex-direction: column;">
                        <div style="background-color: white; padding: 30px; border-radius: 15px; text-align: center;
                             box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2); max-width: 90%;">
                            <i class="fas fa-car-side" style="font-size: 40px; color: var(--primary); margin-bottom: 20px;"></i>
                            <h3 style="margin-bottom: 15px;">Procesando su solicitud</h3>
                            <p style="margin-bottom: 20px;">Estamos registrando su turno, por favor espere...</p>
                            <div class="progress-container" style="width: 100%; height: 6px; background-color: rgba(0, 0, 0, 0.1);
                                 border-radius: 3px; overflow: hidden; margin-top: 10px;">
                                <div class="progress-bar" style="height: 100%; width: 0; background-color: var(--accent);
                                     border-radius: 3px; animation: loadProgress 2s forwards;"></div>
                            </div>
                        </div>
                    </div>`;
                    
                    $('body').append(loadingOverlay);
                    
                    // Cambiar color del texto en modo oscuro
                    if (document.body.classList.contains('dark-mode')) {
                        $('#submitOverlay').find('div').first().css('color', '#f8f9fa');
                    }
                }
            });
            
            // Disparar eventos para inicializar la vista previa si hay valores
            if ($('#id_vehiculo').val()) {
                $('#id_vehiculo').trigger('change');
            }
            
            // Efecto sticky header al hacer scroll
            $(window).scroll(function() {
                if ($(this).scrollTop() > 10) {
                    $('.content-header').addClass('sticky');
                } else {
                    $('.content-header').removeClass('sticky');
                }
            });
            
            // Animación suave en elementos al cargar
            setTimeout(function() {
                $('.form-container').css('opacity', '0').css('transform', 'translateY(20px)');
                $('.preview-container').css('opacity', '0').css('transform', 'translateY(20px)');
                
                setTimeout(function() {
                    $('.form-container').css({
                        'opacity': '1',
                        'transform': 'translateY(0)',
                        'transition': 'all 0.6s ease-out'
                    });
                    
                    setTimeout(function() {
                        $('.preview-container').css({
                            'opacity': '1',
                            'transform': 'translateY(0)',
                            'transition': 'all 0.6s ease-out'
                        });
                    }, 200);
                }, 100);
            }, 2200); // Después de que se complete la animación de carga inicial
            
            if ($('#hora').val()) {
                const [hours, minutes] = $('#hora').val().split(':');
                if (hours && minutes) {
                    const hora = parseInt(hours);
                    const ampm = hora >= 12 ? 'PM' : 'AM';
                    const hora12 = (hora % 12) || 12;
                    $('#previewHora').text(hora12 + ':' + minutes + ' ' + ampm);
                    const horaValidIcon = document.getElementById('horaValidIcon');
                    horaValidIcon.classList.add('valid');
                    $('#hora').parent().addClass('focused');
                }
            }
            
            if ($('#comentarios').val()) {
                $('#comentarios').trigger('input');
            }
        });
    </script>
</body>
</html>