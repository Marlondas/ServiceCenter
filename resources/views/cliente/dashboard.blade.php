<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Cliente | Service Center</title>
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
            --water-1: #a2d5f2;
            --water-2: #7ec8e3;
            --bubble-color: rgba(255, 255, 255, 0.7);
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
            transition: opacity 0.8s ease-in-out, visibility 0.8s ease-in-out;
            overflow: hidden;
        }

        .page-loader.hidden {
            opacity: 0;
            visibility: hidden;
        }

        .water-wave {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 200px;
            background: url('data:image/svg+xml;utf8,<svg viewBox="0 0 1200 120" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none"><path d="M0,0V46.29c47.79,22.2,103.59,32.17,158,28,70.36-5.37,136.33-33.31,206.8-37.5C438.64,32.43,512.34,53.67,583,72.05c69.27,18,138.3,24.88,209.4,13.08,36.15-6,69.85-17.84,104.45-29.34C989.49,25,1113-14.29,1200,52.47V0Z" opacity=".25" fill="%237ec8e3" /></svg>');
            background-size: cover;
            animation: waveAnimation 10s linear infinite;
        }

        .water-wave:nth-child(2) {
            bottom: 0;
            opacity: 0.5;
            animation: waveAnimation 8s linear infinite;
        }

        .water-wave:nth-child(3) {
            bottom: 0;
            opacity: 0.2;
            animation: waveAnimation 6s linear infinite;
        }

        @keyframes waveAnimation {
            0% {
                transform: translateX(0) translateZ(0) scaleY(1);
            }
            50% {
                transform: translateX(-25%) translateZ(0) scaleY(0.8);
            }
            100% {
                transform: translateX(-50%) translateZ(0) scaleY(1);
            }
        }

        .loader-title {
            color: white;
            font-size: 28px;
            font-weight: 600;
            margin-bottom: 40px;
            opacity: 0;
            transform: translateY(20px);
            animation: fadeInUp 1s forwards 0.5s;
            text-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
            position: relative;
        }

        .loader-title::after {
            content: '';
            position: absolute;
            width: 0;
            height: 3px;
            background: linear-gradient(90deg, transparent, var(--accent), transparent);
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            animation: lineGrow 2s ease-in-out forwards 1s;
            border-radius: 3px;
        }

        @keyframes lineGrow {
            0% { width: 0; opacity: 0; }
            100% { width: 100%; opacity: 1; }
        }

        .loader-subtitle {
            color: rgba(255, 255, 255, 0.9);
            font-size: 16px;
            margin-top: 20px;
            opacity: 0;
            animation: fadeInUp 1s forwards 1s;
            text-shadow: 0 1px 3px rgba(0, 0, 0, 0.2);
        }

        /* Combinación de animaciones avanzadas */
        .splash-logo {
            position: relative;
            width: 200px;
            height: 200px;
            margin-bottom: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            perspective: 1000px;
        }

        .splash-logo i {
            font-size: 4rem;
            color: white;
            filter: drop-shadow(0 0 15px rgba(255, 255, 255, 0.7));
            animation: pulseLogo 2s infinite ease-in-out, rotateLogo 8s infinite linear;
            transform-style: preserve-3d;
        }

        @keyframes pulseLogo {
            0% { transform: scale(0.95); opacity: 0.8; }
            50% { transform: scale(1.1); opacity: 1; }
            100% { transform: scale(0.95); opacity: 0.8; }
        }

        @keyframes rotateLogo {
            0% { transform: rotateY(0deg); }
            100% { transform: rotateY(360deg); }
        }

        .splash-logo .cleaning-items {
            position: absolute;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            z-index: -1;
            opacity: 0.15;
            transform-style: preserve-3d;
            animation: rotateSlow 15s infinite linear;
        }

        @keyframes rotateSlow {
            0% { transform: rotateY(0deg); }
            100% { transform: rotateY(360deg); }
        }

        .splash-logo .cleaning-item {
            position: absolute;
            font-size: 1.8rem;
            color: white;
            filter: drop-shadow(0 0 10px rgba(255, 255, 255, 0.6));
            animation: floatItem 4s infinite ease-in-out;
        }

        @keyframes floatItem {
            0%, 100% { transform: translateY(0) rotate(0); }
            50% { transform: translateY(-10px) rotate(15deg); }
        }

        /* Animación del vehículo en movimiento */
        .moto-container {
            position: relative;
            width: 280px;
            height: 60px;
            margin: 20px auto 0;
            overflow: hidden;
            display: flex;
            justify-content: center;
        }
        
        .loading-track {
            position: absolute;
            bottom: 10px;
            width: 200px;
            height: 4px;
            background-color: rgba(255, 255, 255, 0.2);
            border-radius: 2px;
            left: 50%;
            transform: translateX(-50%);
        }
        
        .loading-progress {
            position: absolute;
            height: 100%;
            background: linear-gradient(90deg, var(--accent), var(--secondary));
            border-radius: 2px;
            animation: progress 5s infinite;
        }
        
        @keyframes progress {
            0% { width: 0%; }
            50% { width: 70%; }
            100% { width: 100%; }
        }
        
        .moto {
            position: absolute;
            font-size: 2.5rem;
            color: white;
            animation: drive 5s infinite ease-in-out;
            display: flex;
            align-items: center;
            transform: translateX(-50%);
            filter: drop-shadow(0 0 8px rgba(255, 255, 255, 0.4));
        }
        
        @keyframes drive {
            0% { left: -30px; }
            20% { left: 20%; }
            50% { left: 50%; }
            80% { left: 80%; }
            100% { left: calc(100% + 30px); }
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
            background: radial-gradient(circle at 30% 30%, rgba(67, 97, 238, 0.1), rgba(67, 97, 238, 0.03));
            box-shadow: inset 0 0 20px rgba(255, 255, 255, 0.5), 0 0 15px rgba(67, 97, 238, 0.1);
            opacity: 0.7;
            animation: rise 20s infinite ease-in;
            backdrop-filter: blur(1px);
        }
        
        .cleaning-bubble {
            display: flex;
            align-items: center;
            justify-content: center;
            color: rgba(67, 97, 238, 0.3);
            animation: spin 20s infinite linear;
            text-shadow: 0 0 10px rgba(67, 97, 238, 0.2);
        }
        
        .cleaning-bubble i {
            animation: pulseBubble 3s infinite alternate;
        }
        
        @keyframes pulseBubble {
            0% { transform: scale(0.9); opacity: 0.5; }
            100% { transform: scale(1.1); opacity: 0.9; }
        }
        
        body.dark-mode .bubble {
            background: radial-gradient(circle at 30% 30%, rgba(67, 97, 238, 0.2), rgba(67, 97, 238, 0.05));
            box-shadow: inset 0 0 20px rgba(255, 255, 255, 0.3), 0 0 15px rgba(67, 97, 238, 0.15);
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

        @keyframes spin {
            0% { transform: translateY(0) rotate(0); }
            100% { transform: translateY(0) rotate(360deg); }
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

        /* Contenido principal */
        .main-content {
            margin-left: 80px;
            padding: 30px;
            transition: margin-left var(--transition-speed) ease;
            position: relative;
        }

        .main-content::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: 
                radial-gradient(circle at 20% 30%, rgba(72, 149, 239, 0.03) 0%, transparent 70%),
                radial-gradient(circle at 80% 60%, rgba(76, 201, 240, 0.03) 0%, transparent 70%);
            opacity: 0.5;
            pointer-events: none;
            z-index: -1;
        }
        
        body.dark-mode .main-content::before {
            background: 
                radial-gradient(circle at 20% 30%, rgba(72, 149, 239, 0.1) 0%, transparent 70%),
                radial-gradient(circle at 80% 60%, rgba(76, 201, 240, 0.1) 0%, transparent 70%);
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
            transition: all var(--transition-speed);
            position: relative;
            overflow: hidden;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            transform: translateZ(0);
        }

        .content-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 5px;
            height: 100%;
            background: linear-gradient(to bottom, var(--info), var(--secondary));
            box-shadow: 0 0 15px rgba(76, 201, 240, 0.5);
            animation: glowingBorder 3s infinite alternate;
        }
        
        @keyframes glowingBorder {
            0% { box-shadow: 0 0 5px rgba(76, 201, 240, 0.3); }
            100% { box-shadow: 0 0 20px rgba(76, 201, 240, 0.7); }
        }

        body.dark-mode .content-header {
            background-color: rgba(30, 30, 30, 0.9);
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.03);
        }

        @keyframes slideDown {
            from {
                transform: translateY(-30px);
                opacity: 0;
                box-shadow: 0 0 0 rgba(0, 0, 0, 0);
            }
            to {
                transform: translateY(0);
                opacity: 1;
                box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
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
            position: relative;
            display: flex;
            align-items: center;
            text-shadow: 0 2px 3px rgba(0, 0, 0, 0.1);
        }

        .header-title i {
            margin-right: 10px;
            color: var(--info);
            animation: spinInfo 6s infinite linear;
            filter: drop-shadow(0 2px 4px rgba(33, 150, 243, 0.3));
            background: linear-gradient(135deg, var(--info), var(--secondary));
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        
        @keyframes spinInfo {
            0% { transform: rotateY(0deg); }
            100% { transform: rotateY(360deg); }
        }

        body.dark-mode .header-title {
            color: var(--light);
            text-shadow: 0 2px 3px rgba(0, 0, 0, 0.3);
        }

        .header-subtitle {
            font-size: 14px;
            color: var(--gray);
            position: relative;
            padding-left: 20px;
            opacity: 0;
            animation: fadeInLeft 0.5s forwards 0.5s;
        }
        
        .header-subtitle::before {
            content: '';
            position: absolute;
            width: 12px;
            height: 1px;
            background-color: var(--gray);
            left: 0;
            top: 50%;
        }

        body.dark-mode .header-subtitle {
            color: var(--gray-light);
        }
        
        body.dark-mode .header-subtitle::before {
            background-color: var(--gray-light);
        }

        .header-actions {
            display: flex;
            gap: 10px;
            animation: fadeInRight 0.5s forwards;
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
            transition: all 0.4s cubic-bezier(0.68, -0.55, 0.27, 1.55);
            position: relative;
            overflow: hidden;
        }

        .theme-toggle:hover {
            background-color: rgba(67, 97, 238, 0.1);
            transform: rotate(360deg);
        }
        
        .theme-toggle::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: radial-gradient(circle, rgba(67, 97, 238, 0.2) 0%, transparent 70%);
            opacity: 0;
            transition: opacity 0.3s ease;
        }
        
        .theme-toggle:hover::before {
            opacity: 1;
            animation: pulseBtn 1.5s infinite;
        }
        
        @keyframes pulseBtn {
            0% { transform: scale(0.8); opacity: 0.3; }
            50% { transform: scale(1.2); opacity: 0.5; }
            100% { transform: scale(0.8); opacity: 0.3; }
        }

        body.dark-mode .theme-toggle {
            color: var(--secondary);
        }

        /* Alertas */
        .notification {
            padding: 15px 20px;
            border-radius: 10px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            animation: slideIn 0.5s ease-out;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            position: relative;
            overflow: hidden;
            backdrop-filter: blur(5px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            transform: translateZ(0);
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

        .notification-success {
            background-color: rgba(76, 175, 80, 0.1);
            border-left: 4px solid var(--success);
            color: var(--success);
        }

        .notification-error {
            background-color: rgba(244, 67, 54, 0.1);
            border-left: 4px solid var(--error);
            color: var(--error);
        }

        .notification-icon {
            margin-right: 15px;
            font-size: 20px;
            animation: pulseNotification 2s infinite ease-in-out;
        }
        
        @keyframes pulseNotification {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.2); }
        }

        body.dark-mode .notification-success {
            background-color: rgba(76, 175, 80, 0.05);
        }

        body.dark-mode .notification-error {
            background-color: rgba(244, 67, 54, 0.05);
        }

        /* Tarjeta de bienvenida mejorada */
        .welcome-card {
            background: linear-gradient(135deg, var(--primary), var(--primary-light));
            color: white;
            border-radius: 15px;
            padding: 25px 30px;
            margin-bottom: 30px;
            box-shadow: 0 10px 30px rgba(67, 97, 238, 0.2);
            position: relative;
            overflow: hidden;
            animation: fadeInUp 0.7s forwards;
            transform: translateZ(0);
            transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
        }
        
        .welcome-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(67, 97, 238, 0.3);
        }

        .welcome-card h2 {
            font-weight: 600;
            margin-bottom: 15px;
            font-size: 22px;
            position: relative;
            z-index: 2;
            text-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        }
        
        .welcome-card h2::after {
            content: '';
            position: absolute;
            width: 40px;
            height: 3px;
            background: var(--accent);
            bottom: -8px;
            left: 0;
            border-radius: 3px;
            box-shadow: 0 2px 5px rgba(247, 37, 133, 0.3);
        }

        .welcome-card p {
            margin-bottom: 25px;
            opacity: 0.9;
            max-width: 600px;
            position: relative;
            z-index: 2;
            line-height: 1.6;
        }

        .waves-pattern {
            position: absolute;
            top: 0;
            right: 0;
            width: 100%;
            height: 100%;
            background: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"><path fill="rgba(255, 255, 255, 0.1)" d="M0,96L34.3,112C68.6,128,137,160,206,170.7C274.3,181,343,171,411,144C480,117,549,75,617,85.3C685.7,96,754,160,823,197.3C891.4,235,960,245,1029,224C1097.1,203,1166,149,1234,133.3C1302.9,117,1371,139,1406,149.3L1440,160L1440,320L1405.7,320C1371.4,320,1303,320,1234,320C1165.7,320,1097,320,1029,320C960,320,891,320,823,320C754.3,320,686,320,617,320C548.6,320,480,320,411,320C342.9,320,274,320,206,320C137.1,320,69,320,34,320L0,320Z"></path></svg>');
            background-repeat: no-repeat;
            background-size: cover;
            opacity: 0.3;
            z-index: 1;
            animation: waveBackground 15s infinite alternate ease-in-out;
        }
        
        @keyframes waveBackground {
            0% { transform: translateY(0); }
            100% { transform: translateY(10px); }
        }

        .welcome-actions {
            display: flex;
            gap: 15px;
            position: relative;
            z-index: 2;
        }

        .btn {
            padding: 12px 20px;
            border-radius: 10px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
            cursor: pointer;
            border: none;
            font-family: 'Poppins', sans-serif;
            position: relative;
            overflow: hidden;
            z-index: 1;
        }
        
        .btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.1);
            z-index: -1;
            transform: scale(0);
            transition: 0.3s ease;
            border-radius: 50%;
            opacity: 0;
        }
        
        .btn:hover::before {
            transform: scale(2.5);
            opacity: 1;
        }

        .btn-white {
            background-color: white;
            color: var(--primary);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .btn-white:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
        }

        .btn-outline {
            background-color: transparent;
            border: 2px solid rgba(255, 255, 255, 0.8);
            color: white;
        }

        .btn-outline:hover {
            background-color: rgba(255, 255, 255, 0.1);
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .btn i {
            margin-right: 8px;
            transition: transform 0.3s ease;
        }
        
        .btn:hover i {
            transform: translateX(-3px);
        }

        /* Efecto de ripple para botones */
        .btn-ripple {
            position: absolute;
            transform: translate(-50%, -50%);
            width: 0;
            height: 0;
            border-radius: 50%;
            background-color: rgba(255, 255, 255, 0.4);
            pointer-events: none;
            animation: rippleEffect 0.6s linear;
        }

        @keyframes rippleEffect {
            from {
                width: 0;
                height: 0;
                opacity: 0.8;
            }
            to {
                width: 500px;
                height: 500px;
                opacity: 0;
            }
        }

        /* Tarjetas de módulos mejoradas */
        .modules-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 25px;
            margin-bottom: 30px;
        }

        .module-card {
            background-color: white;
            border-radius: 15px;
            padding: 20px 25px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
            transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
            animation: fadeInUp 0.7s forwards;
            position: relative;
            overflow: hidden;
            border-left: 5px solid var(--info);
            transform: translateZ(0);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .module-card:nth-child(1) { animation-delay: 0.1s; }
        .module-card:nth-child(2) { animation-delay: 0.2s; }
        
        .module-card::before {
            content: '';
            position: absolute;
            left: -5px;
            top: 0;
            width: 5px;
            height: 0;
            background: linear-gradient(to bottom, var(--info), var(--secondary));
            opacity: 0;
            transition: height 0.6s ease-out, opacity 0.6s ease-out;
            box-shadow: 0 0 15px rgba(76, 201, 240, 0.5);
        }
        
        .module-card:hover::before {
            height: 100%;
            opacity: 1;
            animation: glowingBorder 3s infinite alternate;
        }

        body.dark-mode .module-card {
            background-color: rgba(30, 30, 30, 0.9);
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.03);
        }

        .module-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
            z-index: 2;
        }

        body.dark-mode .module-card:hover {
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.3);
        }

        .module-header {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }

        .module-icon {
            width: 50px;
            height: 50px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            color: white;
            font-size: 24px;
            flex-shrink: 0;
            transition: all 0.3s ease;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.15);
            background: linear-gradient(135deg, var(--primary), var(--primary-light));
            animation: floatIcon 3s infinite ease-in-out;
            filter: drop-shadow(0 3px 5px rgba(0, 0, 0, 0.2));
        }
        
        @keyframes floatIcon {
            0%, 100% { transform: translateY(0) scale(1); }
            50% { transform: translateY(-5px) scale(1.1); }
        }

        .module-vehicles .module-icon {
            background: linear-gradient(135deg, #4cc9f0, #4895ef);
        }

        .module-services .module-icon {
            background: linear-gradient(135deg, #f72585, #ff0a54);
        }

        .module-card:hover .module-icon {
            transform: scale(1.1) rotate(5deg);
            animation: spinIcon 6s infinite linear;
        }
        
        @keyframes spinIcon {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .module-card h3 {
            font-size: 20px;
            font-weight: 600;
            color: var(--dark);
            margin: 0;
        }

        body.dark-mode .module-card h3 {
            color: var(--light);
        }

        .module-links {
            list-style: none;
        }

        .module-link {
            margin-bottom: 10px;
            transition: all 0.3s ease;
        }

        .module-link:last-child {
            margin-bottom: 0;
        }

        .module-link a {
            display: flex;
            align-items: center;
            padding: 12px 15px;
            border-radius: 10px;
            text-decoration: none;
            color: var(--gray-dark);
            font-weight: 500;
            transition: all var(--transition-speed) ease;
            background-color: rgba(0, 0, 0, 0.02);
            position: relative;
            overflow: hidden;
        }
        
        .module-link a::after {
            content: '';
            position: absolute;
            width: 5px;
            height: 5px;
            background: var(--secondary);
            border-radius: 50%;
            left: 5px;
            top: 50%;
            transform: translateY(-50%);
            opacity: 0;
            transition: all 0.3s ease;
        }

        .module-link a:hover {
            background-color: rgba(67, 97, 238, 0.05);
            color: var(--primary);
            transform: translateX(5px);
            padding-left: 20px;
        }
        
        .module-link a:hover::after {
            opacity: 1;
        }

        body.dark-mode .module-link a {
            color: var(--gray-light);
            background-color: rgba(255, 255, 255, 0.05);
        }

        body.dark-mode .module-link a:hover {
            background-color: rgba(67, 97, 238, 0.1);
        }

        .module-link a i {
            margin-right: 10px;
            width: 20px;
            text-align: center;
            color: var(--gray);
            transition: all var(--transition-speed) ease;
        }

        .module-link a:hover i {
            color: var(--primary);
            transform: scale(1.2);
        }

        /* Animaciones */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeInLeft {
            from {
                opacity: 0;
                transform: translateX(-30px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes fadeInRight {
            from {
                opacity: 0;
                transform: translateX(30px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        /* Flotador de vehículos animado */
        .vehicles-container {
            position: fixed;
            bottom: 70px;
            right: 30px;
            width: 150px;
            height: 80px;
            z-index: -1;
            pointer-events: none;
        }

        .floating-vehicle {
            position: absolute;
            font-size: 24px;
            color: var(--primary-light);
            opacity: 0.3;
            filter: drop-shadow(0 2px 5px rgba(0, 0, 0, 0.2));
            animation: float 5s infinite ease-in-out;
            transform-style: preserve-3d;
        }

        .floating-vehicle:nth-child(1) {
            bottom: 20px;
            left: 10px;
            animation-delay: 0s;
        }

        .floating-vehicle:nth-child(2) {
            bottom: 40px;
            left: 60px;
            animation-delay: 0.5s;
        }

        .floating-vehicle:nth-child(3) {
            bottom: 0;
            left: 30px;
            animation-delay: 1s;
        }

        body.dark-mode .floating-vehicle {
            color: var(--primary-light);
            opacity: 0.2;
            filter: drop-shadow(0 2px 5px rgba(67, 97, 238, 0.3));
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

        /* Responsividad mejorada */
        @media screen and (max-width: 1199px) {
            .modules-grid {
                grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            }

            .welcome-actions {
                flex-wrap: wrap;
            }
        }

        @media screen and (max-width: 991px) {
            .main-content {
                padding: 25px;
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

            .header-title {
                font-size: 20px;
            }

            .content-header {
                flex-direction: column;
                align-items: flex-start;
                text-align: left;
                gap: 15px;
            }

            .header-actions {
                align-self: flex-end;
            }

            .welcome-card {
                padding: 20px;
            }

            .welcome-card h2 {
                font-size: 20px;
            }

            .btn {
                padding: 10px 15px;
                font-size: 14px;
            }

            .modules-grid {
                grid-template-columns: 1fr;
                gap: 20px;
            }

            .module-card {
                padding: 15px 20px;
            }
            
            .vehicles-container {
                bottom: 70px;
                right: 10px;
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
            
            .welcome-card {
                padding: 15px;
            }
            
            .welcome-actions {
                gap: 10px;
            }
            
            .btn {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <!-- Animación de carga inicial con perfil de persona -->
    <div class="page-loader" id="pageLoader">
        <div class="water-wave"></div>
        <div class="water-wave"></div>
        <div class="water-wave"></div>

        <div class="splash-logo">
            <i class="fas fa-car-wash"></i>
            <div class="cleaning-items">
                <i class="fas fa-spray-can cleaning-item" style="top: 10%; left: 20%;"></i>
                <i class="fas fa-broom cleaning-item" style="top: 30%; left: 70%;"></i>
                <i class="fas fa-tint cleaning-item" style="top: 60%; left: 40%;"></i>
                <i class="fas fa-brush cleaning-item" style="top: 80%; left: 80%;"></i>
                <i class="fas fa-soap cleaning-item" style="top: 50%; left: 10%;"></i>
            </div>
        </div>
        
        <div class="loader-title">Service Center - Panel de Cliente</div>
        
        <div class="moto-container">
            <div class="loading-track">
                <div class="loading-progress"></div>
            </div>
            <div class="moto">
                <i class="fas fa-car"></i>
            </div>
        </div>
        
        <div class="loader-subtitle">Cargando su perfil de cliente...</div>
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
            <a href="{{ route('cliente.dashboard') }}" class="nav-item active">
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
        <!-- Alertas -->
        @if (session('success'))
            <div class="notification notification-success">
                <i class="fas fa-check-circle notification-icon"></i>
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="notification notification-error">
                <i class="fas fa-exclamation-circle notification-icon"></i>
                {{ session('error') }}
            </div>
        @endif

        <!-- Header del contenido -->
        <div class="content-header">
            <div class="header-left">
                <h1 class="header-title">
                    <i class="fas fa-home"></i> Dashboard Cliente
                </h1>
                <div class="header-subtitle">
                    <span>Bienvenido, gestiona tus vehículos y servicios</span>
                </div>
            </div>
            <div class="header-actions">
                <button class="theme-toggle" id="themeToggle">
                    <i class="fas fa-moon"></i>
                </button>
            </div>
        </div>

        <!-- Tarjeta de bienvenida -->
        <div class="welcome-card">
            <div class="waves-pattern"></div>
            <h2>Bienvenido, {{ session('usuario')->nombre }}</h2>
            <p>Desde este panel podrás gestionar tus vehículos, solicitar turnos y revisar tus servicios anteriores. Todo en un solo lugar para brindarte la mejor experiencia.</p>
            <div class="welcome-actions">
                <a href="{{ route('cliente.turnos.solicitar') }}" class="btn btn-white">
                    <i class="fas fa-calendar-plus"></i> Solicitar Turno
                </a>
                <a href="{{ route('cliente.vehiculos.create') }}" class="btn btn-outline">
                    <i class="fas fa-car-side"></i> Añadir Vehículo
                </a>
            </div>
        </div>

        <!-- Módulos principales -->
        <div class="modules-grid">
            <div class="module-card module-vehicles">
                <div class="module-header">
                    <div class="module-icon">
                        <i class="fas fa-car"></i>
                    </div>
                    <h3>Mis Vehículos</h3>
                </div>
                <ul class="module-links">
                    <li class="module-link">
                        <a href="{{ route('cliente.vehiculos.index') }}">
                            <i class="fas fa-list"></i> Ver Vehículos
                        </a>
                    </li>
                    <li class="module-link">
                        <a href="{{ route('cliente.vehiculos.create') }}">
                            <i class="fas fa-plus"></i> Añadir Vehículo
                        </a>
                    </li>
                </ul>
            </div>

            <div class="module-card module-services">
                <div class="module-header">
                    <div class="module-icon">
                        <i class="fas fa-calendar-check"></i>
                    </div>
                    <h3>Servicios</h3>
                </div>
                <ul class="module-links">
                    <li class="module-link">
                        <a href="{{ route('cliente.turnos.solicitar') }}">
                            <i class="fas fa-calendar-plus"></i> Solicitar Turno
                        </a>
                    </li>
                    <li class="module-link">
                        <a href="{{ route('cliente.turnos') }}">
                            <i class="fas fa-calendar"></i> Mis Turnos
                        </a>
                    </li>
                    <li class="module-link">
                        <a href="{{ route('cliente.lavadas.index') }}">
                            <i class="fas fa-history"></i> Historial de Lavados
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </main>

    <!-- Flotador de vehículos -->
    <div class="vehicles-container">
        <i class="fas fa-car-side floating-vehicle"></i>
        <i class="fas fa-car floating-vehicle"></i>
        <i class="fas fa-truck-pickup floating-vehicle"></i>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Animación de carga
            setTimeout(function() {
                document.getElementById('pageLoader').classList.add('hidden');
            }, 3000);

            // Burbujas de fondo aleatorias
            const bubblesContainer = document.getElementById('bubbles');
            const cleaningIcons = [
                'fa-spray-can', 'fa-soap', 'fa-brush', 'fa-tint', 'fa-car-wash', 
                'fa-water', 'fa-shower', 'fa-faucet'
            ];
            const numBubbles = 20;
            
            for (let i = 0; i < numBubbles; i++) {
                const bubble = document.createElement('div');
                const isCleaningBubble = Math.random() > 0.5;
                
                const size = Math.random() * 80 + 30;
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

            // Efecto ripple en botones
            const buttons = document.querySelectorAll('.btn');
            buttons.forEach(button => {
                button.addEventListener('click', function(e) {
                    const rect = e.target.getBoundingClientRect();
                    const x = e.clientX - rect.left;
                    const y = e.clientY - rect.top;
                    
                    const ripple = document.createElement('span');
                    ripple.classList.add('btn-ripple');
                    ripple.style.left = x + 'px';
                    ripple.style.top = y + 'px';
                    
                    this.appendChild(ripple);
                    
                    setTimeout(() => {
                        ripple.remove();
                    }, 600);
                });
            });

            // Añadir clase active al enlace actual
            const currentLocation = window.location.href;
            const navItems = document.querySelectorAll('.nav-item');
            navItems.forEach(item => {
                const link = item.getAttribute('href');
                if (link && currentLocation.includes(link)) {
                    item.classList.add('active');
                }
            });
            
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
            
            // Efecto de parallax para las burbujas
            window.addEventListener('mousemove', function(e) {
                const moveX = (e.clientX / window.innerWidth - 0.5) * 20;
                const moveY = (e.clientY / window.innerHeight - 0.5) * 20;
                
                document.querySelectorAll('.bubble').forEach(bubble => {
                    const speed = parseFloat(bubble.style.width) / 100;
                    const x = moveX * speed;
                    const y = moveY * speed;
                    bubble.style.transform = `translate(${x}px, ${y}px)`;
                });
                
                // También agregamos el efecto a los vehículos flotantes
                document.querySelectorAll('.floating-vehicle').forEach(vehicle => {
                    const speed = 0.3;
                    const x = moveX * speed;
                    const y = moveY * speed;
                    vehicle.style.transform = `translate(${x}px, ${y}px)`;
                });
            });
        });
    </script>
</body>
</html>