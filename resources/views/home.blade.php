<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Service Center</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #0067b3;
            --primary-light: #4d94ff;
            --primary-dark: #003b7a;
            --secondary: #00c2ff;
            --accent: #00e5ff;
            --light: #f8f9fa;
            --dark: #212529;
            --bubble-size: 10px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            color: var(--dark);
            overflow-x: hidden;
            background-color: #f5f8ff;
        }

        /* Animaciones de burbujas */
        .bubbles {
            position: absolute;
            width: 100%;
            height: 100%;
            z-index: -1;
            overflow: hidden;
            top: 0;
            left: 0;
        }

        .bubble {
            position: absolute;
            bottom: -100px;
            width: var(--bubble-size);
            height: var(--bubble-size);
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            opacity: 0.5;
            animation: rise 10s infinite ease-in;
        }

        .bubble:nth-child(1) {
            width: calc(var(--bubble-size) * 3);
            height: calc(var(--bubble-size) * 3);
            left: 10%;
            animation-duration: 8s;
        }

        .bubble:nth-child(2) {
            width: calc(var(--bubble-size) * 2);
            height: calc(var(--bubble-size) * 2);
            left: 20%;
            animation-duration: 5s;
            animation-delay: 1s;
        }

        .bubble:nth-child(3) {
            width: calc(var(--bubble-size) * 2.5);
            height: calc(var(--bubble-size) * 2.5);
            left: 35%;
            animation-duration: 7s;
            animation-delay: 2s;
        }

        .bubble:nth-child(4) {
            width: calc(var(--bubble-size) * 1.5);
            height: calc(var(--bubble-size) * 1.5);
            left: 50%;
            animation-duration: 11s;
            animation-delay: 0s;
        }

        .bubble:nth-child(5) {
            width: calc(var(--bubble-size) * 2.8);
            height: calc(var(--bubble-size) * 2.8);
            left: 65%;
            animation-duration: 6s;
            animation-delay: 3s;
        }

        .bubble:nth-child(6) {
            width: calc(var(--bubble-size) * 2.2);
            height: calc(var(--bubble-size) * 2.2);
            left: 80%;
            animation-duration: 9s;
            animation-delay: 2s;
        }

        .bubble:nth-child(7) {
            width: calc(var(--bubble-size) * 1.8);
            height: calc(var(--bubble-size) * 1.8);
            left: 90%;
            animation-duration: 12s;
            animation-delay: 1s;
        }

        @keyframes rise {
            0% {
                bottom: -100px;
                transform: translateX(0);
            }
            50% {
                transform: translateX(100px);
            }
            100% {
                bottom: 1080px;
                transform: translateX(-100px);
            }
        }

        /* Header */
        header {
            background: linear-gradient(135deg, var(--primary-dark), var(--primary), var(--secondary));
            color: white;
            padding: 1rem 0;
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1000;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        .logo {
            font-size: 24px;
            font-weight: 700;
            display: flex;
            align-items: center;
        }

        .logo span {
            color: var(--accent);
        }

        .nav-links {
            display: flex;
            list-style: none;
        }

        .nav-links li {
            margin-left: 30px;
        }

        .nav-links a {
            color: white;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
            position: relative;
        }

        .nav-links a:hover {
            color: var(--accent);
        }

        .nav-links a::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            background: var(--accent);
            bottom: -5px;
            left: 0;
            transition: width 0.3s ease;
        }

        .nav-links a:hover::after {
            width: 100%;
        }

        .burger {
            display: none;
            cursor: pointer;
        }

        .burger div {
            width: 25px;
            height: 3px;
            background-color: white;
            margin: 5px;
            transition: all 0.3s ease;
        }

        /* Hero Section */
        .hero {
            min-height: 100vh;
            /* Imagen 2 - Persona lavando auto con esponja */
            background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), url('{{ asset("images/car-wash-person.jpg") }}');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            filter: contrast(1.1);
            display: flex;
            align-items: center;
            position: relative;
            overflow: hidden;
            padding: 120px 0 80px;
        }

        .hero-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            z-index: 1;
            text-align: center;
        }

        .hero-text {
            color: white;
            transition: all 0.6s ease;
            max-width: 800px;
        }

        .hero-text h1 {
            font-size: 4rem;
            font-weight: 700;
            margin-bottom: 20px;
            line-height: 1.2;
            animation: fadeInUp 1s ease;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
        }

        .hero-text p {
            font-size: 1.3rem;
            margin-bottom: 30px;
            line-height: 1.6;
            margin: 0 auto 30px;
            animation: fadeInUp 1s ease 0.2s;
            animation-fill-mode: both;
            text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.5);
        }

        .hero-buttons {
            display: flex;
            gap: 15px;
            animation: fadeInUp 1s ease 0.4s;
            animation-fill-mode: both;
            justify-content: center;
        }

        .btn {
            display: inline-block;
            padding: 12px 30px;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
            font-size: 1rem;
        }

        .btn-primary {
            background-color: var(--accent);
            color: var(--dark);
        }

        .btn-primary:hover {
            background-color: #00f7ff;
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(0, 239, 255, 0.2);
        }

        .btn-secondary {
            background-color: transparent;
            color: white;
            border: 2px solid white;
        }

        .btn-secondary:hover {
            background-color: white;
            color: var(--primary);
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(255, 255, 255, 0.2);
        }

        /* Features Section */
        .features {
            padding: 100px 0;
            max-width: 1200px;
            margin: 0 auto;
        }

        .section-title {
            text-align: center;
            margin-bottom: 70px;
        }

        .section-title h2 {
            font-size: 2.5rem;
            color: var(--primary-dark);
            margin-bottom: 15px;
            font-weight: 700;
            position: relative;
            display: inline-block;
        }

        .section-title h2::after {
            content: '';
            position: absolute;
            bottom: -15px;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 3px;
            background: linear-gradient(to right, var(--primary), var(--accent));
            border-radius: 50px;
        }

        .section-title p {
            color: #6c757d;
            max-width: 700px;
            margin: 20px auto 0;
            font-size: 1.1rem;
        }

        .features-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
            padding: 0 20px;
        }

        /* Flip Cards para Servicios */
        .feature-card-container {
            perspective: 1000px;
            height: 300px;
            margin-bottom: 30px;
        }

        .feature-card {
            position: relative;
            width: 100%;
            height: 100%;
            transition: transform 0.8s;
            transform-style: preserve-3d;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
        }

        .feature-card-container:hover .feature-card {
            transform: rotateY(180deg);
        }

        .feature-card-front, .feature-card-back {
            position: absolute;
            width: 100%;
            height: 100%;
            -webkit-backface-visibility: hidden;
            backface-visibility: hidden;
            border-radius: 20px;
            overflow: hidden;
            background: white;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 30px;
        }

        .feature-card-back {
            transform: rotateY(180deg);
            text-align: center;
        }

        .service-logo {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
            box-shadow: 0 10px 20px rgba(0, 98, 204, 0.2);
            font-size: 40px;
            color: white;
        }

        .feature-card-front h3 {
            color: var(--primary-dark);
            margin-bottom: 10px;
            font-size: 1.5rem;
            font-weight: 600;
        }

        .feature-card-back p {
            color: #6c757d;
            line-height: 1.6;
            margin-bottom: 20px;
        }

        .feature-card-back .btn {
            margin-top: 10px;
            padding: 10px 20px;
            font-size: 0.9rem;
        }

        /* About Section */
        .about {
            background-color: white;
            padding: 100px 0;
            position: relative;
            overflow: hidden;
        }

        .about::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, rgba(0, 103, 179, 0.05), rgba(0, 229, 255, 0.05));
            z-index: 0;
        }

        .about-container {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            padding: 0 20px;
            position: relative;
            z-index: 1;
        }

        .about-image {
            flex: 1;
            padding-right: 50px;
            position: relative;
        }

        .about-image img {
            max-width: 100%;
            border-radius: 20px;
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .about-image::before {
            content: '';
            position: absolute;
            top: -15px;
            left: -15px;
            width: 80%;
            height: 80%;
            border: 3px solid var(--accent);
            border-radius: 20px;
            z-index: -1;
        }

        .about-text {
            flex: 1;
        }

        .about-text h2 {
            font-size: 2.5rem;
            color: var(--primary-dark);
            margin-bottom: 20px;
            font-weight: 700;
            position: relative;
            display: inline-block;
        }

        .about-text h2::after {
            content: '';
            position: absolute;
            bottom: -15px;
            left: 0;
            width: 80px;
            height: 3px;
            background: linear-gradient(to right, var(--primary), var(--accent));
            border-radius: 50px;
        }

        .about-text p {
            margin-bottom: 20px;
            line-height: 1.7;
            color: #6c757d;
        }

        .about-stats {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 30px;
            margin-top: 40px;
        }

        .stat {
            text-align: center;
            background: white;
            padding: 25px 15px;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
        }

        .stat:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        }

        .stat-number {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--primary);
            margin-bottom: 10px;
            background: linear-gradient(to right, var(--primary), var(--accent));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .stat-text {
            color: var(--dark);
            font-weight: 500;
        }

        /* Footer */
        footer {
            background: linear-gradient(135deg, var(--primary-dark), var(--primary));
            color: white;
            padding: 80px 0 20px;
            position: relative;
            overflow: hidden;
        }

        footer::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" preserveAspectRatio="none"><path d="M0,0 L100,0 L100,100 L0,100 Z" fill="none" stroke="rgba(255,255,255,0.05)" stroke-width="1"/></svg>');
            background-size: 30px 30px;
            z-index: 0;
        }

        .footer-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
            position: relative;
            z-index: 1;
        }

        .footer-top {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 40px;
            margin-bottom: 60px;
        }

        .footer-column h3 {
            font-size: 1.3rem;
            margin-bottom: 25px;
            font-weight: 600;
            position: relative;
            padding-bottom: 15px;
            color: white;
        }

        .footer-column h3::after {
            content: '';
            position: absolute;
            width: 50px;
            height: 2px;
            background: var(--accent);
            bottom: 0;
            left: 0;
        }

        .footer-column p {
            line-height: 1.7;
            margin-bottom: 20px;
            color: rgba(255, 255, 255, 0.8);
        }

        .footer-links {
            list-style: none;
        }

        .footer-links li {
            margin-bottom: 15px;
            transition: all 0.3s ease;
        }

        .footer-links li:hover {
            transform: translateX(5px);
        }

        .footer-links a {
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            transition: all 0.3s ease;
            display: block;
        }

        .footer-links a:hover {
            color: var(--accent);
        }

        .footer-bottom {
            text-align: center;
            padding-top: 40px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }

        .social-links {
            display: flex;
            justify-content: center;
            margin-bottom: 30px;
        }

        .social-links a {
            width: 45px;
            height: 45px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 12px;
            transition: all 0.3s ease;
            color: white;
            text-decoration: none;
            font-size: 20px;
        }

        .social-links a:hover {
            background: var(--accent);
            color: var(--dark);
            transform: translateY(-5px);
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

        @keyframes float {
            0% {
                transform: translateY(0px);
            }
            50% {
                transform: translateY(-20px);
            }
            100% {
                transform: translateY(0px);
            }
        }

        /* NUEVO: Overlay para la animación de login */
        .login-animation-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 103, 179, 0.9);
            z-index: 2000;
            display: flex;
            justify-content: center;
            align-items: center;
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.6s ease, visibility 0.6s ease;
            overflow: hidden;
        }

        .login-animation-overlay.active {
            opacity: 1;
            visibility: visible;
        }

        /* NUEVO: Animación de esponja y espuma */
        .sponge-animation {
            position: relative;
            width: 300px;
            height: 200px;
            transform: scale(0);
            transition: transform 0.6s ease;
        }

        .login-animation-overlay.active .sponge-animation {
            transform: scale(1);
        }

        /* Esponja */
        .sponge {
            position: absolute;
            width: 120px;
            height: 60px;
            background-color: #ffd54f;
            border-radius: 10px;
            bottom: 40px;
            left: 50%;
            transform: translateX(-50%);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
            z-index: 10;
            overflow: hidden;
        }

        .sponge::before {
            content: '';
            position: absolute;
            width: 100%;
            height: 100%;
            background-image: radial-gradient(circle, rgba(0,0,0,0.1) 2px, transparent 2px);
            background-size: 10px 10px;
            background-position: 0 0;
            opacity: 0.5;
        }

        /* Espuma */
        .foam {
            position: absolute;
            top: -40px;
            left: 20px;
            width: 80px;
            height: 30px;
            background-color: white;
            border-radius: 50%;
            box-shadow: 
                30px -10px 0 -5px white,
                -30px -10px 0 -5px white,
                0 -25px 0 -5px white;
            animation: moveSponge 2s ease-in-out infinite alternate;
        }

        @keyframes moveSponge {
            0% {
                transform: translateY(0) rotate(0);
            }
            100% {
                transform: translateY(15px) rotate(5deg);
            }
        }

        /* Burbujas de jabón */
        .soap-bubble {
            position: absolute;
            background-color: rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            border: 2px solid rgba(255, 255, 255, 0.5);
            animation: soapBubbleFloat 3s ease infinite;
            opacity: 0;
        }

        .login-animation-overlay.active .soap-bubble {
            opacity: 0.8;
        }

        .soap-bubble:nth-child(1) {
            width: 30px;
            height: 30px;
            top: 60px;
            left: 30%;
            animation-duration: 4s;
            animation-delay: 0.2s;
        }

        .soap-bubble:nth-child(2) {
            width: 20px;
            height: 20px;
            top: 80px;
            left: 50%;
            animation-duration: 3s;
            animation-delay: 0.5s;
        }

        .soap-bubble:nth-child(3) {
            width: 25px;
            height: 25px;
            top: 70px;
            left: 70%;
            animation-duration: 3.5s;
            animation-delay: 0.8s;
        }

        @keyframes soapBubbleFloat {
            0% {
                transform: translateY(100px);
                opacity: 0;
            }
            50% {
                transform: translateY(50px);
                opacity: 0.8;
            }
            100% {
                transform: translateY(0);
                opacity: 0;
            }
        }

        /* Mensaje de animación */
        .animation-message {
            position: absolute;
            bottom: 30%;
            color: white;
            font-size: 24px;
            font-weight: 700;
            text-align: center;
            opacity: 0;
            transform: translateY(20px);
        }

        .login-animation-overlay.active .animation-message {
            animation: messageAppear 3s ease forwards;
        }

        @keyframes messageAppear {
            0% {
                opacity: 0;
                transform: translateY(20px);
            }
            20% {
                opacity: 1;
                transform: translateY(0);
            }
            80% {
                opacity: 1;
                transform: translateY(0);
            }
            100% {
                opacity: 0;
                transform: translateY(-20px);
            }
        }

        /* Responsive */
        @media screen and (max-width: 992px) {
            .hero-text h1 {
                font-size: 3rem;
            }

            .about-container {
                flex-direction: column;
            }

            .about-image {
                padding-right: 0;
                margin-bottom: 50px;
                order: 2;
            }

            .about-text {
                order: 1;
                text-align: center;
                margin-bottom: 30px;
            }

            .about-text h2::after {
                left: 50%;
                transform: translateX(-50%);
            }
        }

        @media screen and (max-width: 768px) {
            body {
                font-size: 14px;
            }

            .hero-text h1 {
                font-size: 2.5rem;
            }

            .burger {
                display: block;
                z-index: 1001;
            }

            .nav-links {
                position: fixed;
                right: 0;
                top: 0;
                height: 100vh;
                width: 0;
                flex-direction: column;
                align-items: center;
                justify-content: center;
                background: var(--primary-dark);
                transition: width 0.5s ease;
                overflow: hidden;
                z-index: 1000;
            }

            .nav-links.active {
                width: 100%;
            }

            .nav-links li {
                margin: 20px 0;
                opacity: 0;
                transform: translateX(50px);
                transition: all 0.5s ease;
            }

            .nav-links.active li {
                opacity: 1;
                transform: translateX(0);
            }

            .nav-links li:nth-child(1) {
                transition-delay: 0.2s;
            }

            .nav-links li:nth-child(2) {
                transition-delay: 0.3s;
            }

            .nav-links li:nth-child(3) {
                transition-delay: 0.4s;
            }

            .nav-links li:nth-child(4) {
                transition-delay: 0.5s;
            }

            .burger.toggle .line1 {
                transform: rotate(-45deg) translate(-5px, 6px);
            }

            .burger.toggle .line2 {
                opacity: 0;
            }

            .burger.toggle .line3 {
                transform: rotate(45deg) translate(-5px, -6px);
            }

            .about-stats {
                grid-template-columns: 1fr;
            }

            .stat {
                padding: 20px 0;
            }

            /* Burbujas más pequeñas en móviles */
            :root {
                --bubble-size: 6px;
            }
        }
    </style>
</head>
<body>
    <!-- Burbujas animadas de fondo -->
    <div class="bubbles">
        <div class="bubble"></div>
        <div class="bubble"></div>
        <div class="bubble"></div>
        <div class="bubble"></div>
        <div class="bubble"></div>
        <div class="bubble"></div>
        <div class="bubble"></div>
    </div>

    <!-- NUEVO: Overlay de animación para el login -->
    <div class="login-animation-overlay" id="loginAnimation">
        <div class="sponge-animation">
            <div class="sponge">
                <div class="foam"></div>
            </div>
            <div class="soap-bubble"></div>
            <div class="soap-bubble"></div>
            <div class="soap-bubble"></div>
        </div>
        <div class="animation-message">Preparando su sesión...</div>
    </div>

    <!-- Header -->
    <header>
        <nav>
            <div class="logo">
                Service<span>Center</span>
            </div>
            <ul class="nav-links">
                <li><a href="#">Inicio</a></li>
                <li><a href="#servicios">Servicios</a></li>
                <li><a href="#nosotros">Nosotros</a></li>
                <li><a href="{{ route('login.form') }}" onclick="showLoginAnimation(event)">Iniciar Sesión</a></li>
            </ul>
            <div class="burger">
                <div class="line1"></div>
                <div class="line2"></div>
                <div class="line3"></div>
            </div>
        </nav>
    </header>

    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-container">
            <div class="hero-text">
                <h1>Tu auto merece <br>el mejor cuidado</h1>
                <p>Service Center ofrece un servicio premium de lavado y detallado para tu vehículo, con la posibilidad de agendar tu cita online y recibir atención personalizada.</p>
                <div class="hero-buttons">
                    <a href="{{ route('register.form') }}" onclick="showLoginAnimation(event)" class="btn btn-primary">Registrarse</a>
                    <a href="#nosotros" class="btn btn-secondary">Conocer más</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features" id="servicios">
        <div class="section-title">
            <h2>Nuestros Servicios</h2>
            <p>Ofrecemos una amplia gama de servicios diseñados para mantener tu vehículo impecable y extender su vida útil.</p>
        </div>
        <div class="features-container">
            <!-- Servicio 1: Lavado Básico -->
            <div class="feature-card-container">
                <div class="feature-card">
                    <div class="feature-card-front">
                        <div class="service-logo">🚿</div>
                        <h3>Lavado Básico</h3>
                    </div>
                    <div class="feature-card-back">
                        <h3>Lavado Básico</h3>
                        <p>Lavado exterior completo con productos de alta calidad que no dañan la pintura de tu vehículo.</p>
                        <a href="{{ route('register.form') }}" onclick="showLoginAnimation(event)" class="btn btn-primary">Solicitar</a>
                    </div>
                </div>
            </div>
            
            <!-- Servicio 2: Lavado Premium -->
            <div class="feature-card-container">
                <div class="feature-card">
                    <div class="feature-card-front">
                        <div class="service-logo">✨</div>
                        <h3>Lavado Premium</h3>
                    </div>
                    <div class="feature-card-back">
                        <h3>Lavado Premium</h3>
                        <p>Incluye lavado exterior, aspirado interior, limpieza de tablero y cristales para un resultado impecable.</p>
                        <a href="{{ route('register.form') }}" onclick="showLoginAnimation(event)" class="btn btn-primary">Solicitar</a>
                    </div>
                </div>
            </div>
            
            <!-- Servicio 3: Detallado Completo -->
            <div class="feature-card-container">
                <div class="feature-card">
                    <div class="feature-card-front">
                        <div class="service-logo">🔍</div>
                        <h3>Detallado Completo</h3>
                    </div>
                    <div class="feature-card-back">
                        <h3>Detallado Completo</h3>
                        <p>Proceso detallado que incluye encerado, pulido, tratamiento de cuero y limpieza profunda de interiores.</p>
                        <a href="{{ route('register.form') }}" onclick="showLoginAnimation(event)" class="btn btn-primary">Solicitar</a>
                    </div>
                </div>
            </div>
            
            <!-- Servicio 4: Protección de Pintura -->
            <div class="feature-card-container">
                <div class="feature-card">
                    <div class="feature-card-front">
                        <div class="service-logo">🛡️</div>
                        <h3>Protección de Pintura</h3>
                    </div>
                    <div class="feature-card-back">
                        <h3>Protección de Pintura</h3>
                        <p>Aplicación de selladores y cerámicos que protegen la pintura de tu auto por meses.</p>
                        <a href="{{ route('register.form') }}" onclick="showLoginAnimation(event)" class="btn btn-primary">Solicitar</a>
                    </div>
                </div>
            </div>
            
            <!-- Servicio 5: Lavado de Motor -->
            <div class="feature-card-container">
                <div class="feature-card">
                    <div class="feature-card-front">
                        <div class="service-logo">🧩</div>
                        <h3>Lavado de Motor</h3>
                    </div>
                    <div class="feature-card-back">
                        <h3>Lavado de Motor</h3>
                        <p>Limpieza especializada del compartimiento del motor para mejorar su desempeño y apariencia.</p>
                        <a href="{{ route('register.form') }}" onclick="showLoginAnimation(event)" class="btn btn-primary">Solicitar</a>
                    </div>
                </div>
            </div>
            
            <!-- Servicio 6: Reserva Online -->
            <div class="feature-card-container">
                <div class="feature-card">
                    <div class="feature-card-front">
                        <div class="service-logo">📅</div>
                        <h3>Reserva Online</h3>
                    </div>
                    <div class="feature-card-back">
                        <h3>Reserva Online</h3>
                        <p>Sistema de agendamiento para que puedas reservar tu turno sin esperas ni contratiempos.</p>
                        <a href="{{ route('register.form') }}" onclick="showLoginAnimation(event)" class="btn btn-primary">Solicitar</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section class="about" id="nosotros">
        <div class="about-container">
            <div class="about-image">
                <!-- Imagen 1 - Moto con espuma -->
                <img src="{{ asset('images/motorcycle-wash.jpg') }}" alt="Servicio de lavado de motos">
            </div>
            <div class="about-text">
                <h2>¿Por qué elegirnos?</h2>
                <p>En Service Center nos apasiona el cuidado de los vehículos. Fundados en 2020, hemos establecido un nuevo estándar en el servicio de lavado de autos, combinando técnicas tradicionales con tecnología moderna.</p>
                <p>Nuestro equipo está compuesto por profesionales capacitados que tratan cada vehículo como si fuera propio, utilizando únicamente productos premium que garantizan resultados excepcionales sin comprometer la integridad de tu auto.</p>
                <p>Además, nuestro sistema de reservas en línea te permite agendar tu servicio de forma rápida y sin complicaciones, adaptándose a tu horario y necesidades.</p>
                <div class="about-stats">
                    <div class="stat">
                        <div class="stat-number">5,000+</div>
                        <div class="stat-text">Clientes satisfechos</div>
                    </div>
                    <div class="stat">
                        <div class="stat-number">15+</div>
                        <div class="stat-text">Especialistas</div>
                    </div>
                    <div class="stat">
                        <div class="stat-number">100%</div>
                        <div class="stat-text">Satisfacción garantizada</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="footer-container">
            <div class="footer-top">
                <div class="footer-column">
                    <h3>Sobre Nosotros</h3>
                    <p>Service Center es un servicio premium de lavado y detallado de vehículos con más de 3 años de experiencia en el mercado.</p>
                </div>
                <div class="footer-column">
                    <h3>Enlaces Rápidos</h3>
                    <ul class="footer-links">
                        <li><a href="#">Inicio</a></li>
                        <li><a href="#servicios">Servicios</a></li>
                        <li><a href="#nosotros">Nosotros</a></li>
                        <li><a href="{{ route('login.form') }}" onclick="showLoginAnimation(event)">Iniciar Sesión</a></li>
                        <li><a href="{{ route('register.form') }}" onclick="showLoginAnimation(event)">Registrarse</a></li>
                    </ul>
                </div>
                <div class="footer-column">
                    <h3>Servicios</h3>
                    <ul class="footer-links">
                        <li><a href="#">Lavado Básico</a></li>
                        <li><a href="#">Lavado Premium</a></li>
                        <li><a href="#">Detallado Completo</a></li>
                        <li><a href="#">Protección de Pintura</a></li>
                        <li><a href="#">Lavado de Motor</a></li>
                    </ul>
                </div>
                <div class="footer-column">
                    <h3>Contacto</h3>
                    <ul class="footer-links">
                        <li>📍 Calle Principal #123, Soacha</li>
                        <li>📞 +57 300 123 4567</li>
                        <li>✉️ info@servicecenter.com</li>
                        <li>⏰ Lun-Sáb: 8:00 AM - 6:00 PM</li>
                    </ul>
                </div>
            </div>
            <div class="footer-bottom">
                <div class="social-links">
                    <a href="#">📱</a>
                    <a href="#">📘</a>
                    <a href="#">📸</a>
                    <a href="#">▶️</a>
                </div>
                <p>&copy; 2025 Service Center. Todos los derechos reservados.</p>
            </div>
        </div>
    </footer>

    <script>
        // Navegación móvil
        const burger = document.querySelector('.burger');
        const nav = document.querySelector('.nav-links');
        const navLinks = document.querySelectorAll('.nav-links li');

        burger.addEventListener('click', () => {
            // Toggle Nav
            nav.classList.toggle('active');
            
            // Toggle Burger Animation
            burger.classList.toggle('toggle');
            
            // Animate Links
            navLinks.forEach((link, index) => {
                if (link.style.animation) {
                    link.style.animation = '';
                } else {
                    link.style.animation = `navLinkFade 0.5s ease forwards ${index / 7 + 0.3}s`;
                }
            });
        });

        // Smooth Scroll
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                
                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });
                
                // Close mobile menu if open
                if (nav.classList.contains('active')) {
                    nav.classList.remove('active');
                    burger.classList.remove('toggle');
                }
            });
        });

        // MODIFICADO: Mostrar animación de login/registro antes de redireccionar
        function showLoginAnimation(event) {
            // Evitar la redirección inmediata
            event.preventDefault();
            
            // Guardar la URL de destino
            const targetUrl = event.currentTarget.getAttribute('href');
            
            // Mostrar la animación
            const loginAnimation = document.getElementById('loginAnimation');
            loginAnimation.classList.add('active');
            
            // Después de la animación, redireccionar
            setTimeout(() => {
                window.location.href = targetUrl;
            }, 3000); // Duración de la animación
        }

        // Animation on scroll for feature cards
        function checkVisibility() {
            const featureCards = document.querySelectorAll('.feature-card-container');
            const triggerBottom = window.innerHeight * 0.8;
            
            featureCards.forEach((card, index) => {
                const cardTop = card.getBoundingClientRect().top;
                
                if (cardTop < triggerBottom) {
                    setTimeout(() => {
                        card.style.opacity = 1;
                        card.style.transform = 'translateY(0)';
                    }, index * 100); // Animación escalonada
                }
            });
        }

        // Inicializar opacidad de tarjetas de servicios
        document.querySelectorAll('.feature-card-container').forEach(card => {
            card.style.opacity = 0;
            card.style.transform = 'translateY(50px)';
            card.style.transition = 'all 0.5s ease';
        });

        // Check visibility on load and scroll
        window.addEventListener('load', checkVisibility);
        window.addEventListener('scroll', checkVisibility);
    </script>
</body>
</html>