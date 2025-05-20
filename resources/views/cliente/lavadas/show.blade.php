<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalle de Lavado - Service Center</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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

        /* Animación de carga de perfil con espuma */
        .profile-loader {
            position: relative;
            width: 220px;
            height: 220px;
            margin-bottom: 30px;
            display: flex;
            justify-content: center;
            align-items: center;
            perspective: 800px;
        }

        .profile-avatar {
            width: 120px;
            height: 120px;
            background: linear-gradient(145deg, rgba(255, 255, 255, 0.9), rgba(255, 255, 255, 0.7));
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative;
            z-index: 5;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2), inset 0 -5px 15px rgba(0, 0, 0, 0.1);
            animation: pulseProfile 2s infinite ease-in-out, rotateAvatar 10s infinite linear;
            overflow: hidden;
        }
        
        @keyframes rotateAvatar {
            0% { transform: rotateY(0deg); }
            100% { transform: rotateY(360deg); }
        }

        .profile-avatar::after {
            content: '';
            position: absolute;
            width: 150%;
            height: 150%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            transform: rotate(45deg);
            top: -25%;
            left: -25%;
            animation: shineEffect 3s infinite ease-in-out;
        }

        @keyframes shineEffect {
            0% { left: -150%; }
            50% { left: 150%; }
            100% { left: -150%; }
        }

        .profile-avatar i {
            font-size: 60px;
            background: linear-gradient(135deg, var(--primary), var(--primary-light));
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
            filter: drop-shadow(0 2px 3px rgba(0, 0, 0, 0.2));
            animation: colorShift 8s infinite alternate;
        }

        @keyframes colorShift {
            0% { filter: hue-rotate(0deg) drop-shadow(0 2px 3px rgba(0, 0, 0, 0.2)); }
            100% { filter: hue-rotate(30deg) drop-shadow(0 2px 3px rgba(0, 0, 0, 0.2)); }
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
            background: radial-gradient(circle at 30% 30%, var(--bubble-color), rgba(255, 255, 255, 0.3));
            box-shadow: inset 0 0 10px rgba(255, 255, 255, 0.5), 0 0 10px rgba(255, 255, 255, 0.2);
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
            top: 0;
            left: 0;
            z-index: 3;
            transform-style: preserve-3d;
        }

        .foam {
            position: absolute;
            background: radial-gradient(circle at 30% 30%, rgba(255, 255, 255, 0.9), rgba(255, 255, 255, 0.4));
            border-radius: 50% 50% 50% 50% / 60% 60% 40% 40%;
            filter: blur(5px);
            z-index: 3;
            animation: foamMove 4s infinite alternate ease-in-out, foamPulse 3s infinite alternate;
            box-shadow: inset 0 0 10px rgba(255, 255, 255, 0.5), 0 0 15px rgba(255, 255, 255, 0.3);
        }
        
        @keyframes foamPulse {
            0% { opacity: 0.6; filter: blur(5px); }
            100% { opacity: 0.9; filter: blur(3px); }
        }

        .left-foam {
            width: 80px;
            height: 60px;
            top: 65%;
            left: 10%;
            transform: rotate(-20deg) translateZ(-10px);
            animation-delay: 0.5s;
        }

        .right-foam {
            width: 70px;
            height: 50px;
            top: 30%;
            right: 10%;
            transform: rotate(20deg) translateZ(-5px);
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
            transform-style: preserve-3d;
        }
        
        .cleaning-item {
            position: absolute;
            font-size: 1.5rem;
            color: white;
            filter: drop-shadow(0 0 5px rgba(255, 255, 255, 0.5));
            animation: float 3s infinite ease-in-out, spin 10s infinite linear;
            text-shadow: 0 0 10px rgba(255, 255, 255, 0.5);
        }
        
        @keyframes spin {
            0% { transform: translateY(0) rotate(0); }
            100% { transform: translateY(0) rotate(360deg); }
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
            min-height: 100vh;
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
            gap: 15px;
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

        /* Botones de acción */
        .btn {
            padding: 12px 20px;
            border-radius: 10px;
            font-weight: 500;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
            cursor: pointer;
            border: none;
            font-family: 'Poppins', sans-serif;
            font-size: 14px;
            position: relative;
            overflow: hidden;
            min-width: 120px;
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

        .btn i {
            margin-right: 8px;
            transition: transform 0.3s ease;
        }
        
        .btn:hover i {
            transform: translateX(-3px);
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary), var(--primary-light));
            color: white;
            box-shadow: 0 4px 15px rgba(67, 97, 238, 0.2);
        }

        .btn-primary:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(67, 97, 238, 0.4);
        }

        .btn-info {
            background: linear-gradient(135deg, var(--info), var(--secondary));
            color: white;
            box-shadow: 0 4px 15px rgba(33, 150, 243, 0.2);
        }

        .btn-info:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(33, 150, 243, 0.4);
        }

        .btn-secondary {
            background: transparent;
            border: 1px solid var(--gray);
            color: var(--gray);
        }

        .btn-secondary:hover {
            background-color: rgba(108, 117, 125, 0.1);
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(108, 117, 125, 0.2);
            color: var(--primary);
            border-color: var(--primary);
        }

        .btn-sm {
            padding: 8px 15px;
            font-size: 13px;
            min-width: unset;
        }

        /* Estilos para los paneles de información */
        .info-panel {
            background-color: white;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
            margin-bottom: 30px;
            overflow: hidden;
            animation: fadeInUp 0.5s forwards;
            transition: all var(--transition-speed);
            border-left: 5px solid var(--info);
            position: relative;
            transform: translateZ(0);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        
        .info-panel:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
        }
        
        .info-panel::before {
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
        
        .info-panel:hover::before {
            height: 100%;
            opacity: 1;
            animation: glowingBorder 3s infinite alternate;
        }

        body.dark-mode .info-panel {
            background-color: rgba(30, 30, 30, 0.9);
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.03);
        }
        
        body.dark-mode .info-panel:hover {
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.3);
        }

        .panel-header {
            padding: 20px 25px;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            position: relative;
            transition: all var(--transition-speed);
            overflow: hidden;
        }
        
        .panel-header::after {
            content: '';
            position: absolute;
            width: 150%;
            height: 100%;
            top: -100%;
            left: -25%;
            background: linear-gradient(to bottom, rgba(76, 201, 240, 0.05), transparent);
            transform: rotate(25deg);
            transition: top 0.5s ease;
        }
        
        .info-panel:hover .panel-header::after {
            top: 100%;
        }

        body.dark-mode .panel-header {
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        }

        .panel-title {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 0;
            color: var(--primary-dark);
            display: flex;
            align-items: center;
            transition: all var(--transition-speed);
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
        }

        .panel-title i {
            margin-right: 10px;
            color: var(--info);
            transition: all 0.4s ease;
            animation: floatIcon 3s infinite ease-in-out;
            filter: drop-shadow(0 2px 3px rgba(33, 150, 243, 0.3));
            transform-origin: center;
        }
        
        @keyframes floatIcon {
            0%, 100% { transform: translateY(0) scale(1); }
            50% { transform: translateY(-5px) scale(1.1); }
        }
        
        .info-panel:hover .panel-title i {
            color: var(--secondary);
            animation: spinIcon 6s infinite linear;
        }
        
        @keyframes spinIcon {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        body.dark-mode .panel-title {
            color: var(--light);
        }

        .panel-body {
            padding: 25px;
            position: relative;
            overflow: hidden;
            transition: all var(--transition-speed);
        }
        
        .panel-body::before {
            content: '';
            position: absolute;
            width: 200px;
            height: 200px;
            background: radial-gradient(circle, rgba(76, 201, 240, 0.05) 0%, transparent 70%);
            top: -100px;
            right: -100px;
            border-radius: 50%;
            transition: all 0.5s ease;
            opacity: 0;
        }
        
        .info-panel:hover .panel-body::before {
            top: -50px;
            right: -50px;
            opacity: 1;
        }

        /* Detalles del servicio */
        .service-details {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 25px;
            animation-delay: 0.2s;
            opacity: 0;
            animation: fadeInUp 0.5s forwards 0.2s;
        }

        .service-detail-item {
            margin-bottom: 15px;
            transition: all 0.4s ease;
            position: relative;
            padding-left: 5px;
        }
        
        .service-detail-item:hover {
            transform: translateX(5px);
        }
        
        .service-detail-item::before {
            content: '';
            position: absolute;
            left: -5px;
            top: 0;
            height: 100%;
            width: 2px;
            background: linear-gradient(to bottom, var(--secondary), transparent);
            opacity: 0;
            transition: opacity 0.3s ease;
        }
        
        .service-detail-item:hover::before {
            opacity: 1;
        }

        .detail-label {
            font-size: 12px;
            color: var(--gray);
            margin-bottom: 5px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            transition: all var(--transition-speed);
            position: relative;
            display: inline-block;
        }
        
        .detail-label::after {
            content: '';
            position: absolute;
            width: 0;
            height: 1px;
            background-color: var(--secondary);
            left: 0;
            bottom: -2px;
            transition: width 0.3s ease;
        }
        
        .service-detail-item:hover .detail-label::after {
            width: 100%;
        }

        body.dark-mode .detail-label {
            color: var(--gray-light);
        }

        .detail-value {
            font-size: 15px;
            font-weight: 500;
            color: var(--dark);
            display: flex;
            align-items: center;
            transition: all var(--transition-speed);
        }

        .detail-value i {
            margin-right: 8px;
            color: var(--primary);
            transition: all 0.4s ease;
            filter: drop-shadow(0 2px 3px rgba(67, 97, 238, 0.2));
        }
        
        .service-detail-item:hover .detail-value i {
            transform: scale(1.2);
            color: var(--secondary);
        }

        body.dark-mode .detail-value {
            color: var(--light);
        }

        /* Panel de observaciones */
        .observation-text {
            color: var(--dark);
            font-size: 14px;
            line-height: 1.7;
            position: relative;
            padding: 10px 15px;
            border-radius: 8px;
            background-color: rgba(76, 201, 240, 0.03);
            box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.05);
            transition: all var(--transition-speed);
            border-left: 2px solid rgba(76, 201, 240, 0.2);
            animation: fadeInUp 0.5s forwards 0.3s;
            opacity: 0;
        }
        
        .observation-text:hover {
            background-color: rgba(76, 201, 240, 0.07);
            box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.1);
            border-left: 2px solid rgba(76, 201, 240, 0.5);
            transform: translateX(3px);
        }
        
        .observation-text::before {
            content: '\f075';
            font-family: 'Font Awesome 6 Free';
            position: absolute;
            left: -10px;
            top: -8px;
            font-size: 18px;
            color: rgba(76, 201, 240, 0.3);
            transition: all var(--transition-speed);
            opacity: 0;
        }
        
        .observation-text:hover::before {
            opacity: 1;
            transform: translateY(-3px);
        }

        body.dark-mode .observation-text {
            color: var(--light);
            background-color: rgba(76, 201, 240, 0.05);
            box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.1);
        }
        
        body.dark-mode .observation-text:hover {
            background-color: rgba(76, 201, 240, 0.1);
        }

        /* Panel de imágenes */
        .images-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 25px;
            opacity: 0;
            animation: fadeInUp 0.5s forwards 0.4s;
        }

        .image-box {
            display: flex;
            flex-direction: column;
            transition: all var(--transition-speed);
        }
        
        .image-box:hover {
            transform: translateY(-5px);
        }

        .image-title {
            font-size: 16px;
            font-weight: 600;
            margin-bottom: 15px;
            color: var(--dark);
            display: flex;
            align-items: center;
            position: relative;
            transition: all var(--transition-speed);
        }
        
        .image-title::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            background: linear-gradient(90deg, var(--info), transparent);
            left: 0;
            bottom: -5px;
            transition: width 0.4s ease;
        }
        
        .image-box:hover .image-title::after {
            width: 100%;
        }

        .image-title i {
            margin-right: 8px;
            color: var(--info);
            transition: all 0.4s ease;
        }
        
        .image-box:hover .image-title i {
            transform: scale(1.2) rotate(15deg);
            color: var(--secondary);
        }

        body.dark-mode .image-title {
            color: var(--light);
        }

        .image-wrapper {
            position: relative;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            transition: all 0.5s cubic-bezier(0.165, 0.84, 0.44, 1);
            aspect-ratio: 16 / 9;
            background-color: rgba(0, 0, 0, 0.03);
            transform: perspective(1000px) rotateY(0deg);
            transform-style: preserve-3d;
        }

        .image-wrapper:hover {
            transform: perspective(1000px) rotateY(5deg);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.2), 0 5px 15px rgba(76, 201, 240, 0.2);
        }
        
        .image-wrapper::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, rgba(76, 201, 240, 0.3) 0%, transparent 50%, rgba(67, 97, 238, 0.3) 100%);
            opacity: 0;
            transition: opacity 0.5s ease;
            z-index: 1;
            pointer-events: none;
        }
        
        .image-wrapper:hover::after {
            opacity: 0.5;
        }

        body.dark-mode .image-wrapper {
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
            background-color: rgba(255, 255, 255, 0.05);
        }
        
        body.dark-mode .image-wrapper:hover {
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.3), 0 5px 15px rgba(76, 201, 240, 0.3);
        }

        .image-wrapper img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 10px;
            transition: all 0.5s cubic-bezier(0.165, 0.84, 0.44, 1);
            transform: scale(1);
            filter: brightness(1) contrast(1);
        }
        
        .image-wrapper:hover img {
            transform: scale(1.05);
            filter: brightness(1.05) contrast(1.05);
        }

        .no-image {
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            color: var(--gray);
            font-size: 14px;
            text-align: center;
            background: linear-gradient(135deg, rgba(222, 226, 230, 0.1) 0%, rgba(222, 226, 230, 0.05) 100%);
            transition: all var(--transition-speed);
            position: relative;
            overflow: hidden;
        }
        
        .no-image::before {
            content: '';
            position: absolute;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(76, 201, 240, 0.1) 0%, transparent 70%);
            top: -50%;
            left: -50%;
            opacity: 0;
            transition: opacity 0.5s ease;
            animation: rotateBg 15s infinite linear;
        }
        
        @keyframes rotateBg {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        
        .image-wrapper:hover .no-image::before {
            opacity: 1;
        }

        .no-image i {
            font-size: 36px;
            margin-bottom: 10px;
            opacity: 0.5;
            transition: all 0.4s ease;
            transform-origin: center;
            filter: drop-shadow(0 2px 3px rgba(0, 0, 0, 0.1));
        }
        
        .image-wrapper:hover .no-image i {
            opacity: 0.8;
            transform: scale(1.1) rotate(15deg);
            color: var(--info);
        }
        
        .no-image p {
            position: relative;
            z-index: 2;
            transition: all 0.3s ease;
        }
        
        .image-wrapper:hover .no-image p {
            font-weight: 500;
            transform: translateY(3px);
            color: var(--primary);
        }

        body.dark-mode .no-image {
            color: var(--gray-light);
            background: linear-gradient(135deg, rgba(40, 40, 40, 0.5) 0%, rgba(30, 30, 30, 0.5) 100%);
        }

        /* Panel de calificación */
        .rating-container {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
            opacity: 0;
            animation: fadeInLeft 0.5s forwards 0.5s;
            position: relative;
            padding: 10px 15px;
            border-radius: 10px;
            background-color: rgba(255, 193, 7, 0.03);
            transition: all var(--transition-speed);
        }
        
        .rating-container:hover {
            background-color: rgba(255, 193, 7, 0.07);
            transform: translateX(5px);
        }

        .rating-label {
            font-size: 15px;
            font-weight: 500;
            margin-right: 15px;
            color: var(--dark);
            position: relative;
            transition: all var(--transition-speed);
        }
        
        .rating-label::after {
            content: '';
            position: absolute;
            width: 0;
            height: 1px;
            background-color: var(--warning);
            left: 0;
            bottom: -2px;
            transition: width 0.3s ease;
        }
        
        .rating-container:hover .rating-label::after {
            width: 100%;
        }

        body.dark-mode .rating-label {
            color: var(--light);
        }

        .stars-container {
            display: flex;
            position: relative;
        }
        
        .stars-container::before {
            content: '';
            position: absolute;
            width: 0;
            height: 100%;
            background: linear-gradient(90deg, rgba(255, 193, 7, 0.1), transparent);
            left: 0;
            top: 0;
            transition: width 0.4s ease;
            border-radius: 20px;
            z-index: -1;
        }
        
        .rating-container:hover .stars-container::before {
            width: 100%;
        }

        .star {
            color: var(--warning);
            font-size: 20px;
            margin-right: 3px;
            transition: all 0.4s ease;
            filter: drop-shadow(0 2px 3px rgba(255, 193, 7, 0.2));
            transform-origin: center;
        }
        
        .rating-container:hover .star {
            animation: starPulse 1.5s infinite alternate ease-in-out;
        }
        
        @keyframes starPulse {
            0% { transform: scale(1); filter: drop-shadow(0 2px 3px rgba(255, 193, 7, 0.2)); }
            100% { transform: scale(1.15); filter: drop-shadow(0 2px 5px rgba(255, 193, 7, 0.4)); }
        }
        
        .rating-container:hover .star:nth-child(1) { animation-delay: 0s; }
        .rating-container:hover .star:nth-child(2) { animation-delay: 0.1s; }
        .rating-container:hover .star:nth-child(3) { animation-delay: 0.2s; }
        .rating-container:hover .star:nth-child(4) { animation-delay: 0.3s; }
        .rating-container:hover .star:nth-child(5) { animation-delay: 0.4s; }

        .star-empty {
            color: var(--gray-light);
            transition: all 0.4s ease;
        }
        
        .rating-container:hover .star-empty {
            color: rgba(255, 193, 7, 0.3);
        }

        .comment-container {
            margin-top: 20px;
            opacity: 0;
            animation: fadeInRight 0.5s forwards 0.6s;
        }

        .comment-label {
            font-size: 15px;
            font-weight: 500;
            margin-bottom: 10px;
            color: var(--dark);
            position: relative;
            display: inline-block;
            transition: all var(--transition-speed);
        }
        
        .comment-label::after {
            content: '';
            position: absolute;
            width: 0;
            height: 1px;
            background-color: var(--info);
            left: 0;
            bottom: -2px;
            transition: width 0.3s ease;
        }
        
        .comment-container:hover .comment-label::after {
            width: 100%;
        }

        body.dark-mode .comment-label {
            color: var(--light);
        }

        .comment-text {
            color: var(--dark);
            background-color: rgba(33, 150, 243, 0.03);
            padding: 15px 20px;
            border-radius: 10px;
            font-style: italic;
            font-size: 14px;
            line-height: 1.7;
            border-left: 3px solid var(--info);
            margin-bottom: 15px;
            position: relative;
            overflow: hidden;
            transition: all var(--transition-speed);
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.03);
            transform: translateZ(0);
        }
        
        .comment-text:hover {
            background-color: rgba(33, 150, 243, 0.07);
            transform: translateY(-3px);
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.05);
            border-left-color: var(--secondary);
        }
        
        .comment-text::before {
            content: '\f10d';
            font-family: 'Font Awesome 6 Free';
            font-weight: 900;
            position: absolute;
            left: 10px;
            top: 10px;
            font-size: 18px;
            color: rgba(33, 150, 243, 0.1);
            transition: all var(--transition-speed);
            opacity: 0;
            z-index: 1;
        }
        
        .comment-text:hover::before {
            opacity: 1;
            transform: translateY(-3px);
        }
        
        .comment-text::after {
            content: '\f10e';
            font-family: 'Font Awesome 6 Free';
            font-weight: 900;
            position: absolute;
            right: 10px;
            bottom: 10px;
            font-size: 18px;
            color: rgba(33, 150, 243, 0.1);
            transition: all var(--transition-speed);
            opacity: 0;
            z-index: 1;
        }
        
        .comment-text:hover::after {
            opacity: 1;
            transform: translateY(3px);
        }

        body.dark-mode .comment-text {
            color: var(--light);
            background-color: rgba(33, 150, 243, 0.05);
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
        }
        
        body.dark-mode .comment-text:hover {
            background-color: rgba(33, 150, 243, 0.1);
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.15);
        }

        .feedback-message {
            color: var(--gray);
            font-size: 14px;
            margin-top: 15px;
            padding: 10px 15px;
            border-radius: 8px;
            background-color: rgba(76, 175, 80, 0.05);
            position: relative;
            transition: all var(--transition-speed);
            opacity: 0;
            animation: fadeInUp 0.5s forwards 0.7s;
            display: flex;
            align-items: center;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.03);
        }
        
        .feedback-message:hover {
            background-color: rgba(76, 175, 80, 0.1);
            transform: translateY(-3px);
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.05);
        }
        
        .feedback-message i {
            margin-right: 10px;
            transition: all 0.4s ease;
        }
        
        .feedback-message:hover i {
            transform: scale(1.2) rotate(15deg);
        }

        body.dark-mode .feedback-message {
            color: var(--gray-light);
            background-color: rgba(76, 175, 80, 0.07);
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
        }
        
        body.dark-mode .feedback-message:hover {
            background-color: rgba(76, 175, 80, 0.12);
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.15);
        }

        .no-rating {
            text-align: center;
            padding: 40px 30px;
            position: relative;
            overflow: hidden;
            transition: all var(--transition-speed);
            opacity: 0;
            animation: fadeInUp 0.5s forwards 0.5s;
            background: radial-gradient(circle at center, rgba(255, 193, 7, 0.03) 0%, transparent 70%);
            border-radius: 15px;
        }
        
        .no-rating::before {
            content: '';
            position: absolute;
            top: -150px;
            left: -150px;
            width: 300px;
            height: 300px;
            background: radial-gradient(circle, rgba(255, 193, 7, 0.05) 0%, transparent 70%);
            border-radius: 50%;
            opacity: 0;
            transition: all 0.8s ease;
            z-index: -1;
        }
        
        .no-rating:hover::before {
            opacity: 1;
            transform: scale(1.5);
        }
        
        .no-rating::after {
            content: '\f005';
            font-family: 'Font Awesome 6 Free';
            position: absolute;
            top: 10px;
            right: 20px;
            font-size: 80px;
            color: rgba(255, 193, 7, 0.05);
            z-index: -1;
            transition: all 0.5s ease;
            transform: rotate(10deg);
        }
        
        .no-rating:hover::after {
            transform: rotate(25deg) scale(1.2);
            color: rgba(255, 193, 7, 0.1);
        }

        .no-rating p {
            color: var(--gray);
            margin-bottom: 30px;
            font-size: 16px;
            font-weight: 400;
            position: relative;
            z-index: 2;
            transition: all var(--transition-speed);
            text-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        }
        
        .no-rating:hover p {
            transform: scale(1.05);
        }

        body.dark-mode .no-rating p {
            color: var(--gray-light);
            text-shadow: 0 1px 3px rgba(0, 0, 0, 0.2);
        }
        
        .no-rating .btn {
            position: relative;
            z-index: 2;
            opacity: 0;
            transform: translateY(20px);
            animation: fadeInUp 0.5s forwards 0.8s;
        }
        
        .no-rating .btn i {
            animation: starSpin 4s infinite linear;
            transform-origin: center;
        }
        
        @keyframes starSpin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        /* Mobile responsive */
        @media screen and (max-width: 991px) {
            .service-details {
                grid-template-columns: repeat(2, 1fr);
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

            .service-details {
                grid-template-columns: 1fr;
            }

            .images-container {
                grid-template-columns: 1fr;
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

            .panel-header, .panel-body {
                padding: 15px;
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
        <div class="loader-title">Service Center - Detalle de Lavado</div>
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
        <div class="loader-subtitle">Cargando detalles del servicio...</div>
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
            <a href="{{ route('cliente.lavadas.index') }}" class="nav-item active">
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
                <h1 class="header-title">
                    <i class="fas fa-info-circle"></i> Detalle de Lavado
                </h1>
                <div class="header-subtitle">
                    <span>Información completa sobre el servicio realizado</span>
                </div>
            </div>
            <div class="header-actions">
                <a href="{{ route('cliente.lavadas.index') }}" class="btn btn-info btn-sm">
                    <i class="fas fa-arrow-left"></i> Volver al Historial
                </a>
                <button class="theme-toggle" id="themeToggle">
                    <i class="fas fa-moon"></i>
                </button>
            </div>
        </div>

        <!-- Panel de información del servicio -->
        <div class="info-panel">
            <div class="panel-header">
                <h2 class="panel-title">
                    <i class="fas fa-car-wash"></i> Información del Servicio
                </h2>
            </div>
            <div class="panel-body">
                <div class="service-details">
                    <div class="service-detail-item">
                        <div class="detail-label">Vehículo</div>
                        <div class="detail-value">
                            <i class="{{ $lavada->vehiculo->tipo_vehiculo == 'moto' ? 'fas fa-motorcycle' : 'fas fa-car' }}"></i> 
                            {{ $lavada->vehiculo->placa }}
                        </div>
                    </div>
                    <div class="service-detail-item">
                        <div class="detail-label">Tipo de Servicio</div>
                        <div class="detail-value">
                            <i class="fas fa-soap"></i> 
                            {{ $lavada->turno->tipo_servicio ?? 'No especificado' }}
                        </div>
                    </div>
                    <div class="service-detail-item">
                        <div class="detail-label">Empleado</div>
                        <div class="detail-value">
                            <i class="fas fa-user-cog"></i> 
                            {{ $lavada->empleado->usuario->nombre ?? 'No disponible' }}
                        </div>
                    </div>
                    <div class="service-detail-item">
                        <div class="detail-label">Fecha</div>
                        <div class="detail-value">
                            <i class="fas fa-calendar-day"></i> 
                            {{ date('d/m/Y', strtotime($lavada->fecha)) }}
                        </div>
                    </div>
                    <div class="service-detail-item">
                        <div class="detail-label">Hora</div>
                        <div class="detail-value">
                            <i class="fas fa-clock"></i> 
                            {{ date('H:i', strtotime($lavada->hora)) }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Panel de observaciones -->
        <div class="info-panel">
            <div class="panel-header">
                <h2 class="panel-title">
                    <i class="fas fa-comment-alt"></i> Observaciones
                </h2>
            </div>
            <div class="panel-body">
                <div class="observation-text">
                    {{ $lavada->comentario ?? 'Sin observaciones registradas por el técnico.' }}
                </div>
            </div>
        </div>

        <!-- Panel de imágenes -->
        <div class="info-panel">
            <div class="panel-header">
                <h2 class="panel-title">
                    <i class="fas fa-images"></i> Imágenes del Servicio
                </h2>
            </div>
            <div class="panel-body">
                <div class="images-container">
                    <div class="image-box">
                        <div class="image-title">
                            <i class="fas fa-camera"></i> Antes del Lavado
                        </div>
                        <div class="image-wrapper">
                            @if($lavada->foto_antes)
                                <img src="{{ asset('storage/' . $lavada->foto_antes) }}" alt="Foto antes del lavado">
                            @else
                                <div class="no-image">
                                    <i class="fas fa-image"></i>
                                    <p>No se subió imagen</p>
                                </div>
                            @endif
                        </div>
                    </div>
                    
                    <div class="image-box">
                        <div class="image-title">
                            <i class="fas fa-camera"></i> Después del Lavado
                        </div>
                        <div class="image-wrapper">
                            @if($lavada->foto_despues)
                                <img src="{{ asset('storage/' . $lavada->foto_despues) }}" alt="Foto después del lavado">
                            @else
                                <div class="no-image">
                                    <i class="fas fa-image"></i>
                                    <p>No se subió imagen</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Panel de calificación -->
        <div class="info-panel">
            <div class="panel-header">
                <h2 class="panel-title">
                    <i class="fas fa-star"></i> Calificación
                </h2>
            </div>
            <div class="panel-body">
                @if($lavada->calificacion)
                    <div class="rating-container">
                        <div class="rating-label">Tu calificación:</div>
                        <div class="stars-container">
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= $lavada->calificacion)
                                    <i class="fas fa-star star"></i>
                                @else
                                    <i class="far fa-star star star-empty"></i>
                                @endif
                            @endfor
                        </div>
                    </div>
                    
                    @if($lavada->comentario_cliente)
                        <div class="comment-container">
                            <div class="comment-label">Tu comentario:</div>
                            <div class="comment-text">
                                "{{ $lavada->comentario_cliente }}"
                            </div>
                        </div>
                    @endif
                    
                    <div class="feedback-message">
                        <i class="fas fa-check-circle" style="color: var(--success);"></i>
                        ¡Gracias por tu retroalimentación! Tu opinión nos ayuda a mejorar.
                    </div>
                @else
                    <div class="no-rating">
                        <p>Aún no has calificado este servicio. Tu opinión es importante para nosotros y nos ayuda a mejorar.</p>
                        <a href="{{ route('cliente.lavadas.calificar', $lavada->id_lavada) }}" class="btn btn-primary">
                            <i class="fas fa-star"></i> Calificar Ahora
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </main>

    <script>
        $(document).ready(function() {
            // Animación de carga
            setTimeout(function() {
                document.getElementById('pageLoader').classList.add('hidden');
            }, 2500);

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

            // Zoom de imágenes al hacer clic
            $('.image-wrapper img').on('click', function() {
                // Agregar clase para zoom
                $(this).toggleClass('zoomed');
                
                // Si tiene la clase zoomed, crear un overlay para ver mejor
                if ($(this).hasClass('zoomed')) {
                    // Crear overlay
                    const overlay = document.createElement('div');
                    overlay.className = 'image-zoom-overlay';
                    overlay.style.position = 'fixed';
                    overlay.style.top = '0';
                    overlay.style.left = '0';
                    overlay.style.width = '100%';
                    overlay.style.height = '100%';
                    overlay.style.backgroundColor = 'rgba(0, 0, 0, 0.8)';
                    overlay.style.zIndex = '9999';
                    overlay.style.display = 'flex';
                    overlay.style.justifyContent = 'center';
                    overlay.style.alignItems = 'center';
                    overlay.style.transition = 'opacity 0.3s ease';
                    overlay.style.opacity = '0';
                    
                    // Crear contenedor de imagen
                    const imgContainer = document.createElement('div');
                    imgContainer.style.maxWidth = '90%';
                    imgContainer.style.maxHeight = '90%';
                    imgContainer.style.position = 'relative';
                    imgContainer.style.animation = 'zoomIn 0.3s forwards';
                    
                    // Clonar imagen original
                    const imgClone = $(this).clone()[0];
                    imgClone.style.maxWidth = '100%';
                    imgClone.style.maxHeight = '90vh';
                    imgClone.style.objectFit = 'contain';
                    imgClone.style.borderRadius = '5px';
                    imgClone.style.boxShadow = '0 5px 25px rgba(0, 0, 0, 0.5)';
                    
                    // Crear botón de cierre
                    const closeBtn = document.createElement('button');
                    closeBtn.innerHTML = '<i class="fas fa-times"></i>';
                    closeBtn.style.position = 'absolute';
                    closeBtn.style.top = '-20px';
                    closeBtn.style.right = '-20px';
                    closeBtn.style.width = '40px';
                    closeBtn.style.height = '40px';
                    closeBtn.style.borderRadius = '50%';
                    closeBtn.style.backgroundColor = 'white';
                    closeBtn.style.color = '#333';
                    closeBtn.style.border = 'none';
                    closeBtn.style.boxShadow = '0 2px 10px rgba(0, 0, 0, 0.2)';
                    closeBtn.style.cursor = 'pointer';
                    closeBtn.style.fontSize = '18px';
                    closeBtn.style.display = 'flex';
                    closeBtn.style.justifyContent = 'center';
                    closeBtn.style.alignItems = 'center';
                    closeBtn.style.transition = 'all 0.3s ease';
                    
                    // Añadir evento al botón de cierre
                    closeBtn.addEventListener('mouseenter', function() {
                        this.style.backgroundColor = '#f44336';
                        this.style.color = 'white';
                        this.style.transform = 'scale(1.1)';
                    });
                    
                    closeBtn.addEventListener('mouseleave', function() {
                        this.style.backgroundColor = 'white';
                        this.style.color = '#333';
                        this.style.transform = 'scale(1)';
                    });
                    
                    closeBtn.addEventListener('click', function() {
                        overlay.style.opacity = '0';
                        setTimeout(() => {
                            document.body.removeChild(overlay);
                            $('.image-wrapper img').removeClass('zoomed');
                        }, 300);
                    });
                    
                    // Añadir elementos al DOM
                    imgContainer.appendChild(imgClone);
                    imgContainer.appendChild(closeBtn);
                    overlay.appendChild(imgContainer);
                    document.body.appendChild(overlay);
                    
                    // Mostrar overlay con animación
                    setTimeout(() => {
                        overlay.style.opacity = '1';
                    }, 10);
                    
                    // También cerrar al hacer clic en el overlay
                    overlay.addEventListener('click', function(e) {
                        if (e.target === overlay) {
                            overlay.style.opacity = '0';
                            setTimeout(() => {
                                document.body.removeChild(overlay);
                                $('.image-wrapper img').removeClass('zoomed');
                            }, 300);
                        }
                    });
                    
                    // Añadir estilos para animación
                    const style = document.createElement('style');
                    style.innerHTML = `
                        @keyframes zoomIn {
                            from {
                                opacity: 0;
                                transform: scale(0.8);
                            }
                            to {
                                opacity: 1;
                                transform: scale(1);
                            }
                        }
                    `;
                    document.head.appendChild(style);
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
            });
            
            // Animación para paneles al hacer scroll
            const observerOptions = {
                threshold: 0.2
            };
            
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('animate-in');
                    }
                });
            }, observerOptions);
            
            // Agregar clase para la animación por CSS
            const style = document.createElement('style');
            style.innerHTML = `
                .info-panel {
                    opacity: 0;
                    transform: translateY(30px);
                    transition: opacity 0.5s ease, transform 0.5s ease;
                }
                
                .info-panel.animate-in {
                    opacity: 1;
                    transform: translateY(0);
                }
                
                .info-panel:nth-child(2) {
                    transition-delay: 0.1s;
                }
                
                .info-panel:nth-child(3) {
                    transition-delay: 0.2s;
                }
                
                .info-panel:nth-child(4) {
                    transition-delay: 0.3s;
                }
            `;
            document.head.appendChild(style);
            
            // Observar todos los paneles
            document.querySelectorAll('.info-panel').forEach(panel => {
                observer.observe(panel);
            });
        });
    </script>
</body>
</html>