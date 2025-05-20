<!DOCTYPE html>
<html lang="es">
<head>
    <title>Dashboard - Empleado | Service Center</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Font Awesome para íconos -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #4361ee;
            --primary-light: #4c6ef5;
            --primary-dark: #3a56e4;
            --secondary: #10b981;
            --secondary-light: #34d399;
            --secondary-dark: #059669;
            --accent: #f59e0b;
            --accent-light: #fbbf24;
            --accent-dark: #d97706;
            --danger: #ef4444;
            --success: #22c55e;
            --warning: #f59e0b;
            --info: #0ea5e9;
            --dark: #1e293b;
            --light: #f8fafc;
            --gray: #64748b;
            --gray-light: #e2e8f0;
            --gray-dark: #475569;
            --money: #14b8a6;
            --money-light: #2dd4bf;
            --transition-time: 0.3s;
            --box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            --box-shadow-lg: 0 10px 25px rgba(0, 0, 0, 0.15);
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }
        
        body {
            background-color: #f1f5f9;
            background-image: 
                radial-gradient(circle at 10% 20%, rgba(67, 97, 238, 0.05) 0%, rgba(67, 97, 238, 0) 20%),
                radial-gradient(circle at 90% 80%, rgba(20, 184, 166, 0.05) 0%, rgba(20, 184, 166, 0) 20%);
            overflow-x: hidden;
            transition: background-color var(--transition-time) ease, color var(--transition-time) ease;
        }

        /* NUEVA ANIMACIÓN DE CARGA CON MOTO */
        .splash-screen {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, #3a56e4 0%, #4361ee 100%);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
            transition: all 0.8s ease-in-out;
            flex-direction: column;
        }
        
        .splash-screen.hidden {
            opacity: 0;
            visibility: hidden;
        }
        
        .splash-logo {
            margin-bottom: 30px;
            position: relative;
        }
        
        .splash-text {
            font-size: 2.5rem;
            color: var(--light);
            margin-bottom: 10px;
            font-weight: 700;
            letter-spacing: 1px;
            text-align: center;
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
        }
        
        .splash-subtitle {
            font-size: 1.1rem;
            color: rgba(255, 255, 255, 0.8);
            margin-bottom: 50px;
        }
        
        /* Moto Animation Container */
        .moto-track {
            width: 300px;
            height: 80px;
            position: relative;
            margin-bottom: 30px;
        }
        
        /* La moto */
        .motorcycle {
            position: absolute;
            width: 50px;
            height: 30px;
            top: 25px;
            left: 0;
            z-index: 2;
            animation: moveMoto 4s linear forwards;
            transform-origin: center;
        }
        
        .moto-body {
            position: absolute;
            width: 40px;
            height: 15px;
            background-color: #f59e0b;
            border-radius: 10px 5px 5px 10px;
            top: 10px;
            left: 5px;
        }
        
        .moto-seat {
            position: absolute;
            width: 15px;
            height: 8px;
            background-color: #0f172a;
            border-radius: 5px 5px 0 0;
            top: 5px;
            left: 20px;
        }
        
        .moto-front {
            position: absolute;
            width: 12px;
            height: 20px;
            background-color: #d1d5db;
            border-radius: 5px 5px 0 0;
            top: 0;
            left: 5px;
            transform: rotate(-20deg);
        }
        
        .moto-wheel {
            position: absolute;
            width: 15px;
            height: 15px;
            background-color: #0f172a;
            border: 2px solid #d1d5db;
            border-radius: 50%;
            bottom: 0;
            animation: wheelSpin 0.5s linear infinite;
        }
        
        .front-wheel {
            left: 5px;
        }
        
        .back-wheel {
            right: 5px;
        }
        
        @keyframes wheelSpin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        
        /* Puntos para que la moto "coma" */
        .dot {
            position: absolute;
            width: 10px;
            height: 10px;
            background-color: white;
            border-radius: 50%;
            top: 35px;
            animation: disappear 0.2s forwards;
            animation-play-state: paused;
        }
        
        .dot:nth-child(1) { left: 70px; animation-delay: 0.8s; }
        .dot:nth-child(2) { left: 100px; animation-delay: 1.1s; }
        .dot:nth-child(3) { left: 130px; animation-delay: 1.4s; }
        .dot:nth-child(4) { left: 160px; animation-delay: 1.7s; }
        .dot:nth-child(5) { left: 190px; animation-delay: 2.0s; }
        .dot:nth-child(6) { left: 220px; animation-delay: 2.3s; }
        .dot:nth-child(7) { left: 250px; animation-delay: 2.6s; }
        .dot:nth-child(8) { left: 280px; animation-delay: 2.9s; }
        
        @keyframes disappear {
            0% { transform: scale(1); opacity: 1; }
            50% { transform: scale(1.2); opacity: 0.5; }
            100% { transform: scale(0); opacity: 0; }
        }
        
        @keyframes moveMoto {
            0% { left: -50px; }
            100% { left: 320px; }
        }
        
        .progress-container {
            width: 300px;
            height: 6px;
            background-color: rgba(255, 255, 255, 0.2);
            border-radius: 3px;
            overflow: hidden;
            position: relative;
        }
        
        .progress-bar {
            height: 100%;
            width: 0;
            background: linear-gradient(to right, var(--info), var(--primary-light));
            border-radius: 3px;
            transition: width 4s linear;
            position: relative;
            overflow: hidden;
        }
        
        .progress-bar::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, 
                rgba(255, 255, 255, 0) 0%, 
                rgba(255, 255, 255, 0.3) 50%, 
                rgba(255, 255, 255, 0) 100%);
            animation: shimmer 2s infinite;
        }
        
        @keyframes shimmer {
            0% { transform: translateX(-100%); }
            100% { transform: translateX(100%); }
        }
        
        /* Barra de navegación */
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
            transition: all var(--transition-time) ease;
            z-index: 100;
            box-shadow: var(--box-shadow);
            overflow-x: hidden;
        }
        
        .navbar:hover {
            width: 220px;
        }
        
        .logo-container {
            width: 60px;
            height: 60px;
            display: flex;
            justify-content: center;
            align-items: center;
            margin-bottom: 30px;
            transition: all var(--transition-time);
            background-color: rgba(255, 255, 255, 0.15);
            border-radius: 15px;
            position: relative;
            overflow: hidden;
        }
        
        .logo-container::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(45deg, 
                rgba(255, 255, 255, 0) 0%, 
                rgba(255, 255, 255, 0.1) 50%, 
                rgba(255, 255, 255, 0) 100%);
            animation: shine 2s infinite;
        }
        
        @keyframes shine {
            0% { transform: translateX(-100%) rotate(45deg); }
            100% { transform: translateX(100%) rotate(45deg); }
        }
        
        .navbar:hover .logo-container {
            width: 140px;
            border-radius: 15px;
        }
        
        .logo-container i {
            font-size: 32px;
            color: white;
            filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.2));
        }
        
        .logo-text {
            display: none;
            margin-left: 10px;
            font-weight: 600;
            font-size: 18px;
            color: white;
            white-space: nowrap;
        }
        
        .navbar:hover .logo-text {
            display: block;
        }
        
        .nav-items {
            display: flex;
            flex-direction: column;
            width: 100%;
            gap: 5px;
            flex-grow: 1;
            padding: 0 10px;
        }
        
        .nav-logout {
            width: 100%;
            margin-top: auto;
            padding: 0 10px 10px;
        }
        
        .logout-link {
            color: rgba(255, 255, 255, 0.8) !important;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .logout-link:hover, .logout-link.active {
            background-color: var(--danger) !important;
            color: white !important;
            border-color: var(--danger);
        }
        
        .nav-item {
            display: flex;
            align-items: center;
            padding: 12px 15px;
            color: white;
            text-decoration: none;
            transition: all var(--transition-time);
            border-radius: 10px;
            position: relative;
            width: 100%;
            overflow: hidden;
        }
        
        .nav-item:hover, .nav-item.active {
            background-color: white;
            color: var(--primary);
            transform: translateX(5px);
        }
        
        .nav-item i {
            font-size: 1.5rem;
            min-width: 30px;
            display: flex;
            justify-content: center;
            transition: all var(--transition-time);
        }
        
        .nav-item-text {
            visibility: hidden;
            opacity: 0;
            white-space: nowrap;
            transition: all 0.2s;
            margin-left: 10px;
            font-weight: 500;
        }
        
        .navbar:hover .nav-item-text {
            visibility: visible;
            opacity: 1;
        }
        
        .nav-item.active::before {
            content: "";
            position: absolute;
            left: 0;
            top: 0;
            height: 100%;
            width: 4px;
            background-color: var(--info);
            border-radius: 0 2px 2px 0;
        }
        
        /* Contenido principal */
        .main-content {
            margin-left: 80px;
            padding: 30px 20px;
            transition: all var(--transition-time);
            min-height: 100vh;
        }
        
        .navbar:hover ~ .main-content {
            margin-left: 220px;
        }
        
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            flex-wrap: wrap;
            gap: 15px;
        }
        
        .greeting {
            display: flex;
            flex-direction: column;
        }
        
        .greeting h1 {
            font-size: 1.8rem;
            font-weight: 600;
            color: var(--dark);
            margin-bottom: 5px;
        }
        
        .greeting p {
            font-size: 1rem;
            color: #64748b;
        }
        
        .greeting span {
            font-weight: 600;
            color: var(--primary);
            position: relative;
            display: inline-block;
        }
        
        .greeting span::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 100%;
            height: 2px;
            background: linear-gradient(to right, var(--primary), var(--secondary));
            border-radius: 2px;
        }
        
        .user-actions {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        
        .theme-toggle {
            background: transparent;
            border: none;
            color: var(--dark);
            font-size: 1.2rem;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            transition: all var(--transition-time) ease;
        }
        
        .theme-toggle:hover {
            background-color: #e2e8f0;
            transform: rotate(45deg);
        }
        
        .logout-btn {
            background-color: var(--danger);
            color: var(--light);
            padding: 10px 15px;
            border-radius: 10px;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 5px;
            font-weight: 500;
            transition: all var(--transition-time) ease;
            border: none;
            cursor: pointer;
        }
        
        .logout-btn:hover {
            background-color: #dc2626;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(220, 38, 38, 0.3);
        }
        
        /* Notificaciones */
        .notification {
            border-radius: 10px;
            padding: 15px;
            margin-bottom: 20px;
            color: var(--light);
            display: flex;
            align-items: center;
            gap: 10px;
            animation: slideIn 0.5s ease-out;
            transform-origin: top;
            position: relative;
            overflow: hidden;
        }
        
        .notification::before {
            content: '';
            position: absolute;
            width: 15px;
            height: 15px;
            background-color: rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            top: -5px;
            left: 20px;
            animation: dropletFall 3s infinite ease-out;
        }
        
        @keyframes dropletFall {
            0% {
                transform: translateY(0) scale(1);
                opacity: 0.8;
            }
            80% {
                transform: translateY(40px) scale(1.2);
                opacity: 0;
            }
            100% {
                transform: translateY(40px) scale(1.2);
                opacity: 0;
            }
        }
        
        @keyframes slideIn {
            0% { transform: translateY(-20px); opacity: 0; }
            100% { transform: translateY(0); opacity: 1; }
        }
        
        .notification.success {
            background-color: var(--success);
        }
        
        .notification.error {
            background-color: var(--danger);
        }
        
        .notification i {
            font-size: 1.2rem;
        }
        
        /* TARJETAS FLIP (Volteables) */
        .cards-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 25px;
            margin-bottom: 30px;
        }
        
        .flip-card-container {
            perspective: 1000px;
            height: 200px;
        }
        
        .flip-card {
            position: relative;
            width: 100%;
            height: 100%;
            transition: transform 0.8s;
            transform-style: preserve-3d;
            cursor: pointer;
        }
        
        .flip-card.flipped {
            transform: rotateY(180deg);
        }
        
        .flip-card-front, .flip-card-back {
            position: absolute;
            width: 100%;
            height: 100%;
            backface-visibility: hidden;
            border-radius: 20px;
            box-shadow: var(--box-shadow);
            padding: 25px;
            display: flex;
            flex-direction: column;
        }
        
        .flip-card-front {
            background-color: var(--light);
            color: var(--dark);
            z-index: 2;
        }
        
        .flip-card-back {
            transform: rotateY(180deg);
            z-index: 1;
        }
        
        /* Estilos específicos para cada tarjeta */
        .card-turnos .flip-card-back {
            background: linear-gradient(135deg, var(--primary-light), var(--primary-dark));
            color: white;
        }
        
        .card-lavados .flip-card-back {
            background: linear-gradient(135deg, var(--secondary-light), var(--secondary-dark));
            color: white;
        }
        
        .card-wallet .flip-card-back {
            background: linear-gradient(135deg, var(--money-light), var(--money));
            color: white;
        }
        
        .flip-card-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 15px;
        }
        
        .flip-card-title {
            font-size: 1.1rem;
            font-weight: 600;
            color: inherit;
        }
        
        .flip-icon {
            position: absolute;
            top: 20px;
            right: 20px;
            width: 30px;
            height: 30px;
            border-radius: 50%;
            background-color: rgba(255, 255, 255, 0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.9rem;
            color: inherit;
            transition: all 0.3s ease;
        }
        
        .flip-card:hover .flip-icon {
            transform: rotate(180deg);
        }
        
        .card-icon {
            width: 45px;
            height: 45px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.4rem;
            border-radius: 12px;
            color: white;
            margin-bottom: 15px;
        }
        
        .icon-turnos {
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        }
        
        .icon-lavados {
            background: linear-gradient(135deg, var(--secondary), var(--secondary-dark));
        }
        
        .icon-wallet {
            background: linear-gradient(135deg, var(--money), #0d9488);
        }
        
        .metric-value-container {
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        
        .metric-label {
            color: var(--gray);
            font-size: 0.9rem;
            margin-bottom: 5px;
        }
        
        .metric-value {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--dark);
            font-family: 'Montserrat', sans-serif;
            display: inline-flex;
            align-items: center;
        }
        
        .flip-card-back .metric-label,
        .flip-card-back .metric-value {
            color: white;
        }
        
        .metric-value.money::before {
            content: '$';
            font-size: 1.6rem;
            margin-right: 5px;
            color: var(--money);
        }
        
        .flip-card-back .metric-value.money::before {
            color: white;
        }
        
        .metric-value .counter {
            display: inline-block;
        }
        
        /* Gráficos en el reverso de las tarjetas */
        .chart-container {
            flex-grow: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
        }
        
        /* Gráfico circular para turnos */
        .turnos-chart {
            width: 120px;
            height: 120px;
            position: relative;
        }
        
        .progress-ring {
            width: 120px;
            height: 120px;
        }
        
        .progress-ring-circle {
            fill: none;
            stroke: rgba(255, 255, 255, 0.3);
            stroke-width: 8;
        }
        
        .progress-ring-value {
            fill: none;
            stroke: white;
            stroke-width: 8;
            stroke-linecap: round;
            stroke-dasharray: 283;
            stroke-dashoffset: 283;
            transform: rotate(-90deg);
            transform-origin: center;
            transition: stroke-dashoffset 1s ease;
        }
        
        .chart-percentage {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 1.8rem;
            font-weight: 700;
            color: white;
        }
        
        /* Gráfico de barras para lavados */
        .lavados-chart {
            width: 100%;
            height: 90px;
            display: flex;
            align-items: flex-end;
            gap: 10px;
            padding-top: 15px;
        }
        
        .lavados-bar {
            flex: 1;
            background-color: rgba(255, 255, 255, 0.3);
            border-radius: 5px 5px 0 0;
            height: 10px;
            transition: height 1s cubic-bezier(0.34, 1.56, 0.64, 1);
            position: relative;
        }
        
        .lavados-bar::before {
            content: attr(data-value);
            position: absolute;
            top: -20px;
            left: 50%;
            transform: translateX(-50%);
            font-size: 0.7rem;
            color: rgba(255, 255, 255, 0.8);
        }
        
        /* Gráfico de línea para comisiones */
        .wallet-chart {
            width: 100%;
            height: 80px;
            position: relative;
            padding-top: 15px;
        }
        
        .wallet-line {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 100%;
            fill: none;
            stroke: rgba(255, 255, 255, 0.8);
            stroke-width: 3;
            stroke-linecap: round;
            stroke-linejoin: round;
            stroke-dasharray: 500;
            stroke-dashoffset: 500;
            transition: stroke-dashoffset 1.5s ease;
        }
        
        .wallet-dots {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 100%;
        }
        
        .wallet-dot {
            position: absolute;
            width: 8px;
            height: 8px;
            background-color: white;
            border-radius: 50%;
            transform: scale(0);
            transition: transform 0.5s ease;
        }
        
        /* TARJETAS DE ACCIÓN (BOTONES) */
        .action-cards-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 25px;
            margin-bottom: 30px;
        }
        
        .action-card {
            background-color: var(--light);
            border-radius: 20px;
            padding: 25px;
            box-shadow: var(--box-shadow);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            overflow: hidden;
            position: relative;
            height: 130px;
            display: flex;
            flex-direction: column;
            z-index: 1;
        }
        
        .action-card:hover {
            transform: translateY(-10px);
            box-shadow: var(--box-shadow-lg);
        }
        
        .action-card::before {
            content: '';
            position: absolute;
            width: 100%;
            height: 100%;
            left: 0;
            top: 0;
            background-color: var(--primary);
            z-index: -1;
            transform: scaleX(0);
            transform-origin: right;
            transition: transform 0.5s ease;
        }
        
        .action-card:hover::before {
            transform: scaleX(1);
            transform-origin: left;
        }
        
        .action-card.turnos-action::before {
            background-color: var(--primary);
        }
        
        .action-card.lavados-action::before {
            background-color: var(--secondary);
        }
        
        .action-card.wallet-action::before {
            background-color: var(--money);
        }
        
        .action-icon {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            margin-bottom: 15px;
            position: relative;
            z-index: 1;
            transition: all 0.3s ease;
        }
        
        .action-icon.turnos-action-icon {
            color: var(--primary);
            background-color: rgba(67, 97, 238, 0.1);
        }
        
        .action-icon.lavados-action-icon {
            color: var(--secondary);
            background-color: rgba(16, 185, 129, 0.1);
        }
        
        .action-icon.wallet-action-icon {
            color: var(--money);
            background-color: rgba(20, 184, 166, 0.1);
        }
        
        .action-title {
            font-size: 1.1rem;
            font-weight: 600;
            color: var(--dark);
            margin-bottom: 5px;
            position: relative;
            z-index: 1;
            transition: all 0.3s ease;
        }
        
        .action-description {
            font-size: 0.9rem;
            color: var(--gray);
            position: relative;
            z-index: 1;
            transition: all 0.3s ease;
        }
        
        .action-link {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 2;
            cursor: pointer;
        }
        
        .action-card:hover .action-icon,
        .action-card:hover .action-title,
        .action-card:hover .action-description {
            color: white;
        }
        
        .action-card:hover .action-icon {
            background-color: rgba(255, 255, 255, 0.2);
        }
        
        /* Coin Animation */
        .coin-animation {
            position: absolute;
            right: 30px;
            bottom: 20px;
            font-size: 1.8rem;
            color: #fcd34d;
            opacity: 0;
            z-index: 2;
        }
        
        .action-card.wallet-action:hover .coin-animation {
            animation: coinJump 0.5s 0.3s forwards;
        }
        
        @keyframes coinJump {
            0% {
                opacity: 0;
                transform: translateY(20px) rotate(0deg);
            }
            50% {
                opacity: 1;
                transform: translateY(-15px) rotate(180deg);
            }
            100% {
                opacity: 1;
                transform: translateY(0) rotate(360deg);
            }
        }
        
        /* Modo oscuro */
        body.dark-mode {
            background-color: #0f172a;
            color: #f8fafc;
        }
        
        body.dark-mode .flip-card-front,
        body.dark-mode .action-card {
            background-color: #1e293b;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
        }
        
        body.dark-mode .flip-card-title,
        body.dark-mode .greeting h1,
        body.dark-mode .action-title,
        body.dark-mode .metric-value {
            color: #f1f5f9;
        }
        
        body.dark-mode .greeting p,
        body.dark-mode .metric-label,
        body.dark-mode .action-description {
            color: #94a3b8;
        }
        
        body.dark-mode .theme-toggle {
            color: #f1f5f9;
        }
        
        body.dark-mode .theme-toggle:hover {
            background-color: #334155;
        }
        
        body.dark-mode .metric-value.money::before {
            color: var(--money-light);
        }
        
        body.dark-mode .action-icon.turnos-action-icon {
            background-color: rgba(67, 97, 238, 0.2);
        }
        
        body.dark-mode .action-icon.lavados-action-icon {
            background-color: rgba(16, 185, 129, 0.2);
        }
        
        body.dark-mode .action-icon.wallet-action-icon {
            background-color: rgba(20, 184, 166, 0.2);
        }
        
        /* Efectos decorativos adicionales */
        .bubble {
            position: fixed;
            border-radius: 50%;
            background-color: rgba(67, 97, 238, 0.1);
            opacity: 0.3;
            z-index: -1;
        }
        
        /* Animaciones para los elementos */
        .fade-in {
            animation: fadeIn 0.6s ease-out forwards;
            opacity: 0;
        }
        
        @keyframes fadeIn {
            0% { opacity: 0; transform: translateY(20px); }
            100% { opacity: 1; transform: translateY(0); }
        }
        
        /* Estilos responsivos */
        @media (max-width: 768px) {
            .navbar {
                width: 60px;
            }
            
            .main-content {
                margin-left: 60px;
                padding: 20px 15px;
            }
            
            .navbar:hover ~ .main-content {
                margin-left: 220px;
            }
            
            .cards-container {
                grid-template-columns: 1fr;
            }
            
            .action-cards-container {
                grid-template-columns: 1fr;
            }
        }
        
        @media (max-width: 576px) {
            .navbar {
                width: 0;
                z-index: 1001;
            }
            
            .navbar.expanded {
                width: 220px;
            }
            
            .main-content {
                margin-left: 0;
            }
            
            .navbar:hover ~ .main-content {
                margin-left: 0;
            }
            
            .header {
                flex-direction: column;
                align-items: flex-start;
                gap: 10px;
            }
            
            .user-actions {
                align-self: flex-end;
            }
            
            .mobile-menu-toggle {
                display: block;
                position: fixed;
                bottom: 20px;
                right: 20px;
                width: 50px;
                height: 50px;
                border-radius: 50%;
                background: linear-gradient(135deg, var(--primary), var(--primary-dark));
                color: white;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 1.5rem;
                cursor: pointer;
                z-index: 1000;
                border: none;
                box-shadow: 0 4px 15px rgba(67, 97, 238, 0.3);
                transition: all var(--transition-time) ease;
            }
            
            .mobile-menu-toggle:hover {
                transform: scale(1.1);
            }
            
            .mobile-menu-overlay {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background-color: rgba(0, 0, 0, 0.5);
                z-index: 1000;
                opacity: 0;
                visibility: hidden;
                transition: all var(--transition-time) ease;
            }
            
            .mobile-menu-overlay.visible {
                opacity: 1;
                visibility: visible;
            }
        }
    </style>
</head>
<body>
    <!-- Animación de carga con moto -->
    <div class="splash-screen" id="splash-screen">
        <div class="splash-logo">
            <i class="fas fa-car-wash" style="font-size: 4rem; color: white;"></i>
        </div>
        <div class="splash-text">Service Center</div>
        <div class="splash-subtitle">Panel de Empleado</div>
        
        <div class="moto-track">
            <div class="motorcycle">
                <div class="moto-front"></div>
                <div class="moto-body"></div>
                <div class="moto-seat"></div>
                <div class="moto-wheel front-wheel"></div>
                <div class="moto-wheel back-wheel"></div>
            </div>
            <!-- Puntos para que la moto "coma" -->
            <div class="dot"></div>
            <div class="dot"></div>
            <div class="dot"></div>
            <div class="dot"></div>
            <div class="dot"></div>
            <div class="dot"></div>
            <div class="dot"></div>
            <div class="dot"></div>
        </div>
        
        <div class="progress-container">
            <div class="progress-bar" id="progress-bar"></div>
        </div>
    </div>

    <!-- Botón de menú móvil -->
    <button class="mobile-menu-toggle" id="mobile-menu-toggle" style="display: none;">
        <i class="fas fa-bars"></i>
    </button>
    
    <!-- Overlay para menú móvil -->
    <div class="mobile-menu-overlay" id="mobile-menu-overlay"></div>
    
    <!-- Burbujas decorativas -->
    <div id="bubbles"></div>
    
    <!-- Barra de navegación lateral -->
    <nav class="navbar" id="navbar">
        <div class="logo-container" id="nav-menu-toggle">
            <i class="fas fa-car-wash"></i>
            <span class="logo-text">Service Center</span>
        </div>
        <div class="nav-items">
            <a href="{{ route('empleado.dashboard') }}" class="nav-item active">
                <i class="fas fa-home"></i>
                <span class="nav-item-text">Inicio</span>
            </a>
            <a href="{{ route('empleado.turnos') }}" class="nav-item">
                <i class="fas fa-calendar-alt"></i>
                <span class="nav-item-text">Mis Turnos</span>
            </a>
            <a href="{{ route('empleado.lavadas.index') }}" class="nav-item">
                <i class="fas fa-car"></i>
                <span class="nav-item-text">Historial Lavados</span>
            </a>
            <a href="{{ route('empleado.billetera') }}" class="nav-item">
                <i class="fas fa-wallet"></i>
                <span class="nav-item-text">Mi Billetera</span>
            </a>
        </div>
        <div class="nav-logout">
            <a href="{{ route('logout') }}" class="nav-item logout-link">
                <i class="fas fa-sign-out-alt"></i>
                <span class="nav-item-text">Cerrar Sesión</span>
            </a>
        </div>
    </nav>
    
    <!-- Contenido principal -->
    <main class="main-content">
        <!-- Notificaciones -->
        @if (session('success'))
            <div class="notification success">
                <i class="fas fa-check-circle"></i>
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="notification error">
                <i class="fas fa-exclamation-circle"></i>
                {{ session('error') }}
            </div>
        @endif
        
        <!-- Encabezado -->
        <header class="header">
            <div class="greeting">
                <h1>¡Bienvenido, <span>{{ session('usuario')->nombre }}</span>!</h1>
                <p>Panel de empleado - Service Center Autolavado</p>
            </div>
            <div class="user-actions">
                <button class="theme-toggle" id="theme-toggle" title="Cambiar tema">
                    <i class="fas fa-moon"></i>
                </button>
                <a href="{{ route('logout') }}" class="logout-btn">
                    <i class="fas fa-sign-out-alt"></i>
                    Salir
                </a>
            </div>
        </header>
        
        <!-- Tarjetas Flip con datos y gráficos -->
        <div class="cards-container">
            <!-- Tarjeta de turnos -->
            <div class="flip-card-container">
                <div class="flip-card card-turnos" id="turnos-card">
                    <div class="flip-card-front">
                        <div class="flip-card-header">
                            <h2 class="flip-card-title">Mis Turnos</h2>
                            <div class="flip-icon">
                                <i class="fas fa-sync-alt"></i>
                            </div>
                        </div>
                        
                        <div class="card-icon icon-turnos">
                            <i class="fas fa-calendar-check"></i>
                        </div>
                        
                        <div class="metric-value-container">
                            <div class="metric-label">Turnos pendientes</div>
                            <div class="metric-value">
                                <span class="counter" id="turnos-counter">0</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="flip-card-back">
                        <div class="flip-card-header">
                            <h2 class="flip-card-title">Progreso de Turnos</h2>
                            <div class="flip-icon">
                                <i class="fas fa-sync-alt"></i>
                            </div>
                        </div>
                        
                        <div class="chart-container">
                            <div class="turnos-chart">
                                <svg class="progress-ring">
                                    <circle class="progress-ring-circle" cx="60" cy="60" r="45"></circle>
                                    <circle class="progress-ring-value" cx="60" cy="60" r="45" id="turnos-progress"></circle>
                                </svg>
                                <div class="chart-percentage" id="turnos-percentage">0%</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Tarjeta de lavados -->
            <div class="flip-card-container">
                <div class="flip-card card-lavados" id="lavados-card">
                    <div class="flip-card-front">
                        <div class="flip-card-header">
                            <h2 class="flip-card-title">Mis Lavados</h2>
                            <div class="flip-icon">
                                <i class="fas fa-sync-alt"></i>
                            </div>
                        </div>
                        
                        <div class="card-icon icon-lavados">
                            <i class="fas fa-car-side"></i>
                        </div>
                        
                        <div class="metric-value-container">
                            <div class="metric-label">Lavados este mes</div>
                            <div class="metric-value">
                                <span class="counter" id="lavados-counter">0</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="flip-card-back">
                        <div class="flip-card-header">
                            <h2 class="flip-card-title">Lavados por Día</h2>
                            <div class="flip-icon">
                                <i class="fas fa-sync-alt"></i>
                            </div>
                        </div>
                        
                        <div class="chart-container">
                            <div class="lavados-chart" id="lavados-chart">
                                <div class="lavados-bar" data-value="L" style="height: 10%"></div>
                                <div class="lavados-bar" data-value="M" style="height: 10%"></div>
                                <div class="lavados-bar" data-value="M" style="height: 10%"></div>
                                <div class="lavados-bar" data-value="J" style="height: 10%"></div>
                                <div class="lavados-bar" data-value="V" style="height: 10%"></div>
                                <div class="lavados-bar" data-value="S" style="height: 10%"></div>
                                <div class="lavados-bar" data-value="D" style="height: 10%"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Tarjeta de billetera -->
            <div class="flip-card-container">
                <div class="flip-card card-wallet" id="wallet-card">
                    <div class="flip-card-front">
                        <div class="flip-card-header">
                            <h2 class="flip-card-title">Mi Billetera</h2>
                            <div class="flip-icon">
                                <i class="fas fa-sync-alt"></i>
                            </div>
                        </div>
                        
                        <div class="card-icon icon-wallet">
                            <i class="fas fa-wallet"></i>
                        </div>
                        
                        <div class="metric-value-container">
                            <div class="metric-label">Saldo disponible</div>
                            <div class="metric-value money">
                                <span class="counter" id="wallet-counter">0</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="flip-card-back">
                        <div class="flip-card-header">
                            <h2 class="flip-card-title">Tendencia de Comisiones</h2>
                            <div class="flip-icon">
                                <i class="fas fa-sync-alt"></i>
                            </div>
                        </div>
                        
                        <div class="chart-container">
                            <div class="wallet-chart">
                                <svg width="100%" height="100%" viewBox="0 0 300 80">
                                    <polyline class="wallet-line" id="wallet-line" 
                                             points="0,70 50,60 100,65 150,50 200,40 250,30 300,20" />
                                </svg>
                                
                                <div class="wallet-dots" id="wallet-dots">
                                    <div class="wallet-dot" style="bottom: 10px; left: 0px;"></div>
                                    <div class="wallet-dot" style="bottom: 20px; left: 50px;"></div>
                                    <div class="wallet-dot" style="bottom: 15px; left: 100px;"></div>
                                    <div class="wallet-dot" style="bottom: 30px; left: 150px;"></div>
                                    <div class="wallet-dot" style="bottom: 40px; left: 200px;"></div>
                                    <div class="wallet-dot" style="bottom: 50px; left: 250px;"></div>
                                    <div class="wallet-dot" style="bottom: 60px; left: 300px;"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Tarjetas de Acción (Botones) -->
        <div class="action-cards-container">
            <!-- Botón de turnos -->
            <div class="action-card turnos-action">
                <div class="action-icon turnos-action-icon">
                    <i class="fas fa-calendar-alt"></i>
                </div>
                <h3 class="action-title">Gestionar Turnos</h3>
                <p class="action-description">Ver y confirmar tus turnos asignados</p>
                <a href="{{ route('empleado.turnos') }}" class="action-link" aria-label="Ver turnos"></a>
            </div>
            
            <!-- Botón de lavados -->
            <div class="action-card lavados-action">
                <div class="action-icon lavados-action-icon">
                    <i class="fas fa-car-wash"></i>
                </div>
                <h3 class="action-title">Historial de Lavados</h3>
                <p class="action-description">Consulta todos tus lavados registrados</p>
                <a href="{{ route('empleado.lavadas.index') }}" class="action-link" aria-label="Ver lavados"></a>
            </div>
            
            <!-- Botón de billetera -->
            <div class="action-card wallet-action">
                <div class="action-icon wallet-action-icon">
                    <i class="fas fa-wallet"></i>
                </div>
                <h3 class="action-title">Detalle de Comisiones</h3>
                <p class="action-description">Consulta tus comisiones y pagos</p>
                <span class="coin-animation">
                    <i class="fas fa-coins"></i>
                </span>
                <a href="{{ route('empleado.billetera') }}" class="action-link" aria-label="Ver billetera"></a>
            </div>
        </div>
    </main>
    
    <!-- Elemento para sonidos -->
    <audio id="coin-sound" src="data:audio/mpeg;base64,SUQzBAAAAAABEVRYWFgAAAAtAAADY29tbWVudABCaWdTb3VuZEJhbmsuY29tIC8gTGFTb25vdGhlcXVlLm9yZwBURU5DAAAAHQAAA1N3aXRjaCBQbHVzIMKpIE5DSCBTb2Z0d2FyZQBUSVQyAAAABgAAAzIyMzUAVFNTRQAAAA8AAANMYXZmNTcuODMuMTAwAAAAAAAAAAAAAAD/80DEAAAAA0gAAAAATEFNRTMuMTAwVVVVVVVVVVVVVUxBTUUzLjEwMFVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVf/zQsRbAAADSAAAAABVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVf/zQMSkAAADSAAAAABVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVV" preload="auto"></audio>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Sistema de audio
            const coinSound = document.getElementById('coin-sound');
            
            // Función para reproducir sonido
            function playSound(sound) {
                sound.currentTime = 0;
                sound.play().catch(e => console.log("No se pudo reproducir el audio: ", e));
            }
            
            // Animación de carga con moto
            const splashScreen = document.getElementById('splash-screen');
            const progressBar = document.getElementById('progress-bar');
            const dots = document.querySelectorAll('.dot');
            
            // Iniciar animación de progreso
            progressBar.style.width = '100%';
            
            // Iniciar animación de puntos
            dots.forEach(dot => {
                dot.style.animationPlayState = 'running';
            });
            
            // Ocultar pantalla de carga después de 4 segundos
            setTimeout(function() {
                splashScreen.classList.add('hidden');
                
                // Mostrar botón de menú móvil en dispositivos pequeños
                if (window.innerWidth <= 576) {
                    document.getElementById('mobile-menu-toggle').style.display = 'flex';
                }
                
                // Iniciar animaciones después de la pantalla de carga
                initAnimations();
            }, 4000);
            
            // Crear burbujas decorativas
            createBubbles();
            
            // Toggle de tema oscuro
            const themeToggle = document.getElementById('theme-toggle');
            const themeIcon = themeToggle.querySelector('i');
            
            // Verificar si hay una preferencia guardada
            const darkMode = localStorage.getItem('darkMode') === 'true';
            
            // Aplicar tema según preferencia
            if (darkMode) {
                document.body.classList.add('dark-mode');
                themeIcon.classList.replace('fa-moon', 'fa-sun');
            }
            
            themeToggle.addEventListener('click', function() {
                document.body.classList.toggle('dark-mode');
                
                if (document.body.classList.contains('dark-mode')) {
                    themeIcon.classList.replace('fa-moon', 'fa-sun');
                    localStorage.setItem('darkMode', 'true');
                } else {
                    themeIcon.classList.replace('fa-sun', 'fa-moon');
                    localStorage.setItem('darkMode', 'false');
                }
            });
            
            // Menú móvil
            const mobileMenuToggle = document.getElementById('mobile-menu-toggle');
            const navbar = document.getElementById('navbar');
            const overlay = document.getElementById('mobile-menu-overlay');
            
            if (mobileMenuToggle) {
                mobileMenuToggle.addEventListener('click', function() {
                    navbar.classList.toggle('expanded');
                    mobileMenuToggle.classList.toggle('active');
                    overlay.classList.toggle('visible');
                    
                    if (mobileMenuToggle.classList.contains('active')) {
                        mobileMenuToggle.innerHTML = '<i class="fas fa-times"></i>';
                    } else {
                        mobileMenuToggle.innerHTML = '<i class="fas fa-bars"></i>';
                    }
                });
            }
            
            if (overlay) {
                overlay.addEventListener('click', function() {
                    navbar.classList.remove('expanded');
                    mobileMenuToggle.classList.remove('active');
                    overlay.classList.remove('visible');
                    mobileMenuToggle.innerHTML = '<i class="fas fa-bars"></i>';
                });
            }
            
            // Función para crear burbujas decorativas
            function createBubbles() {
                const bubblesContainer = document.getElementById('bubbles');
                const bubbleCount = 10; // Número de burbujas
                
                for (let i = 0; i < bubbleCount; i++) {
                    const bubble = document.createElement('div');
                    bubble.classList.add('bubble');
                    
                    // Tamaño aleatorio entre 50px y 150px
                    const size = Math.random() * 100 + 50;
                    bubble.style.width = `${size}px`;
                    bubble.style.height = `${size}px`;
                    
                    // Posición aleatoria
                    bubble.style.top = `${Math.random() * 100}vh`;
                    bubble.style.left = `${Math.random() * 100}vw`;
                    
                    // Añadir un retraso a la animación
                    bubble.style.animationDelay = `${Math.random() * 5}s`;
                    
                    bubblesContainer.appendChild(bubble);
                }
            }
            
            // Manejar click en tarjetas flip
            document.querySelectorAll('.flip-card').forEach(card => {
                card.addEventListener('click', function() {
                    this.classList.toggle('flipped');
                    
                    // Si se volteó la tarjeta, animar el gráfico correspondiente
                    if (this.classList.contains('flipped')) {
                        const cardId = this.id;
                        if (cardId === 'turnos-card') {
                            animateProgress();
                        } else if (cardId === 'lavados-card') {
                            animateBars();
                        } else if (cardId === 'wallet-card') {
                            animateLine();
                        }
                    }
                });
            });
            
            // Iniciar animaciones
            function initAnimations() {
                // Animación de contador de turnos
                animateCounter('turnos-counter', 5, 1500);
                
                // Animación de contador de lavados
                setTimeout(() => {
                    animateCounter('lavados-counter', 47, 1800);
                }, 200);
                
                // Animación de contador de billetera
                setTimeout(() => {
                    animateCounter('wallet-counter', 430, 2000);
                }, 400);
                
                // Sonido al hacer hover en botón de wallet
                const btnWallet = document.querySelector('.action-card.wallet-action');
                btnWallet.addEventListener('mouseenter', function() {
                    setTimeout(() => {
                        playSound(coinSound);
                    }, 300);
                });
            }
            
            // Función para animar el círculo de progreso
            function animateProgress() {
                const progress = document.getElementById('turnos-progress');
                const percentage = document.getElementById('turnos-percentage');
                
                // Valor de 70%
                const percentValue = 70;
                
                // Calcular el valor de stroke-dashoffset
                const circumference = 2 * Math.PI * 45;
                const offset = circumference - (percentValue / 100) * circumference;
                
                // Animar el círculo
                progress.style.strokeDashoffset = offset;
                
                // Animar el porcentaje
                animateCounter('turnos-percentage', percentValue, 1500, '%');
            }
            
            // Función para animar las barras de lavados
            function animateBars() {
                const bars = document.querySelectorAll('.lavados-bar');
                const heights = [40, 55, 30, 70, 50, 85, 60]; // Porcentajes de altura
                
                bars.forEach((bar, index) => {
                    setTimeout(() => {
                        bar.style.height = `${heights[index]}%`;
                    }, index * 100);
                });
            }
            
            // Función para animar la línea de comisiones
            function animateLine() {
                // Animar la línea
                const line = document.getElementById('wallet-line');
                line.style.strokeDashoffset = 0;
                
                // Animar los puntos
                const dots = document.querySelectorAll('.wallet-dot');
                dots.forEach((dot, index) => {
                    setTimeout(() => {
                        dot.style.transform = 'scale(1)';
                    }, 300 + index * 150);
                });
            }
            
            // Función para animar contadores numéricos
            function animateCounter(elementId, targetValue, duration, suffix = '') {
                const element = document.getElementById(elementId);
                if (!element) return;
                
                let startValue = 0;
                const increment = targetValue / (duration / 16);
                let currentValue = startValue;
                
                const updateCounter = () => {
                    currentValue += increment;
                    if (currentValue >= targetValue) {
                        currentValue = targetValue;
                        element.textContent = Math.round(currentValue) + suffix;
                        return;
                    }
                    
                    element.textContent = Math.round(currentValue) + suffix;
                    requestAnimationFrame(updateCounter);
                };
                
                updateCounter();
            }
            
            // Manejo de redimensión de ventana
            window.addEventListener('resize', function() {
                if (window.innerWidth <= 576) {
                    document.getElementById('mobile-menu-toggle').style.display = 'flex';
                } else {
                    document.getElementById('mobile-menu-toggle').style.display = 'none';
                    navbar.classList.remove('expanded');
                    overlay.classList.remove('visible');
                }
            });
        });
    </script>
</body>
</html>