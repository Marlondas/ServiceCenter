<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Service Center - Lavado de Autos Premium</title>
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
            height: 100vh;
            background: linear-gradient(135deg, var(--primary-dark), var(--primary));
            display: flex;
            align-items: center;
            position: relative;
            overflow: hidden;
            padding-top: 80px;
        }

        .hero-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: relative;
            z-index: 1;
        }

        .hero-text {
            flex: 1;
            color: white;
            padding-right: 20px;
        }

        .hero-text h1 {
            font-size: 3.5rem;
            font-weight: 700;
            margin-bottom: 20px;
            line-height: 1.2;
            animation: fadeInUp 1s ease;
        }

        .hero-text p {
            font-size: 1.2rem;
            margin-bottom: 30px;
            line-height: 1.6;
            max-width: 500px;
            animation: fadeInUp 1s ease 0.2s;
            animation-fill-mode: both;
        }

        .hero-buttons {
            display: flex;
            gap: 15px;
            animation: fadeInUp 1s ease 0.4s;
            animation-fill-mode: both;
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

        .hero-image {
            flex: 1;
            position: relative;
            animation: float 6s ease-in-out infinite;
        }

        .hero-image img {
            max-width: 100%;
            height: auto;
            filter: drop-shadow(0 10px 15px rgba(0, 0, 0, 0.2));
        }

        /* Login Card */
        .login-card {
            background: white;
            border-radius: 20px;
            padding: 40px;
            width: 400px;
            max-width: 90%;
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
            animation: fadeInRight 1s ease;
            position: relative;
        }

        .login-card::before {
            content: '';
            position: absolute;
            top: -10px;
            left: -10px;
            right: -10px;
            bottom: -10px;
            background: linear-gradient(135deg, var(--accent), var(--primary-light));
            border-radius: 30px;
            z-index: -1;
            opacity: 0.5;
            filter: blur(15px);
        }

        .login-card h2 {
            margin-bottom: 25px;
            text-align: center;
            color: var(--primary-dark);
            font-size: 28px;
            position: relative;
        }

        .login-card h2::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 70px;
            height: 3px;
            background: linear-gradient(to right, var(--primary), var(--accent));
            border-radius: 50px;
        }

        .form-group {
            margin-bottom: 25px;
            position: relative;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: var(--dark);
            transition: all 0.3s ease;
        }

        .form-control {
            width: 100%;
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 12px;
            font-size: 16px;
            transition: all 0.3s ease;
            background-color: #f8f9fa;
        }

        .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(0, 98, 204, 0.2);
            outline: none;
            background-color: white;
        }

        .form-control:focus + .input-icon {
            color: var(--primary);
        }

        .input-icon {
            position: absolute;
            right: 15px;
            top: 45px;
            color: #aaa;
            transition: all 0.3s ease;
        }

        .login-footer {
            text-align: center;
            margin-top: 25px;
        }

        .login-footer a {
            color: var(--primary);
            text-decoration: none;
            transition: all 0.3s ease;
            font-weight: 500;
        }

        .login-footer a:hover {
            color: var(--accent);
            text-decoration: underline;
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

        .feature-card {
            background: white;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
            transition: all 0.5s ease;
            transform: translateY(50px);
            opacity: 0;
        }

        .feature-card:hover {
            transform: translateY(-10px) !important;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
        }

        .feature-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: -40px auto 20px;
            position: relative;
            z-index: 1;
            box-shadow: 0 10px 20px rgba(0, 98, 204, 0.2);
            font-size: 35px;
            color: white;
            transition: all 0.3s ease;
        }

        .feature-card:hover .feature-icon {
            transform: scale(1.1);
            background: linear-gradient(135deg, var(--accent), var(--primary));
        }

        .feature-content {
            padding: 0 30px 30px;
            text-align: center;
        }

        .feature-content h3 {
            margin-bottom: 15px;
            color: var(--primary-dark);
            font-weight: 600;
            font-size: 1.3rem;
        }

        .feature-content p {
            color: #6c757d;
            line-height: 1.6;
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

        /* Responsive */
        @media screen and (max-width: 992px) {
            .hero-container {
                flex-direction: column;
                text-align: center;
            }

            .hero-text {
                padding-right: 0;
                margin-bottom: 50px;
            }

            .hero-text p {
                margin: 0 auto 30px;
            }

            .hero-buttons {
                justify-content: center;
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

            .login-card {
                margin: 0 auto;
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

            .feature-card {
                max-width: 350px;
                margin: 0 auto;
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
                <li><a href="#" onclick="focusLogin()">Iniciar Sesión</a></li>
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
                    <a href="{{ route('register.form') }}" class="btn btn-primary">Registrarse</a>
                    <a href="#nosotros" class="btn btn-secondary">Conocer más</a>
                </div>
            </div>
            <div class="login-card">
                <h2>Iniciar Sesión</h2>
                <form action="{{ route('login') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="correo">Correo Electrónico</label>
                        <input type="email" id="correo" name="correo" class="form-control" required>
                        <div class="input-icon">✉️</div>
                    </div>
                    <div class="form-group">
                        <label for="contraseña">Contraseña</label>
                        <input type="password" id="contraseña" name="contraseña" class="form-control" required>
                        <div class="input-icon">🔒</div>
                    </div>
                    <button type="submit" class="btn btn-primary" style="width: 100%;">Ingresar</button>
                    <div class="login-footer">
                        <p>¿No tienes una cuenta? <a href="{{ route('register.form') }}">Regístrate</a></p>
                    </div>
                </form>
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
            <div class="feature-card">
                <div class="feature-icon">🚿</div>
                <div class="feature-content">
                    <h3>Lavado Básico</h3>
                    <p>Lavado exterior completo con productos de alta calidad que no dañan la pintura de tu vehículo.</p>
                </div>
            </div>
            <div class="feature-card">
                <div class="feature-icon">✨</div>
                <div class="feature-content">
                    <h3>Lavado Premium</h3>
                    <p>Incluye lavado exterior, aspirado interior, limpieza de tablero y cristales para un resultado impecable.</p>
                </div>
            </div>
            <div class="feature-card">
                <div class="feature-icon">🔍</div>
                <div class="feature-content">
                    <h3>Detallado Completo</h3>
                    <p>Proceso detallado que incluye encerado, pulido, tratamiento de cuero y limpieza profunda de interiores.</p>
                </div>
            </div>
            <div class="feature-card">
                <div class="feature-icon">🛡️</div>
                <div class="feature-content">
                    <h3>Protección de Pintura</h3>
                    <p>Aplicación de selladores y cerámicos que protegen la pintura de tu auto por meses.</p>
                </div>
            </div>
            <div class="feature-card">
                <div class="feature-icon">🧩</div>
                <div class="feature-content">
                    <h3>Lavado de Motor</h3>
                    <p>Limpieza especializada del compartimiento del motor para mejorar su desempeño y apariencia.</p>
                </div>
            </div>
            <div class="feature-card">
                <div class="feature-icon">📅</div>
                <div class="feature-content">
                    <h3>Reserva Online</h3>
                    <p>Sistema de agendamiento para que puedas reservar tu turno sin esperas ni contratiempos.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section class="about" id="nosotros">
        <div class="about-container">
            <div class="about-image">
                <img src="https://img.freepik.com/free-photo/man-washing-his-car-car-wash_1303-26858.jpg" alt="Servicio de lavado de autos">
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
                        <li><a href="{{ route('login.form') }}">Iniciar Sesión</a></li>
                        <li><a href="{{ route('register.form') }}">Registrarse</a></li>
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

        // Focus on login form
        function focusLogin() {
            document.getElementById('correo').focus();
        }

        // Animation on scroll
        const featureCards = document.querySelectorAll('.feature-card');
        
        // Initial setup
        featureCards.forEach(card => {
            card.style.opacity = "0";
            card.style.transform = "translateY(50px)";
        });
        
        // Check if element is in viewport
        function isInViewport(element) {
            const rect = element.getBoundingClientRect();
            return (
                rect.top <= (window.innerHeight || document.documentElement.clientHeight) * 0.8
            );
        }
        
        // Show elements when scrolled into view
        function checkVisibility() {
            featureCards.forEach((card, index) => {
                if (isInViewport(card)) {
                    setTimeout(() => {
                        card.style.opacity = "1";
                        card.style.transform = "translateY(0)";
                    }, index * 100); // staggered animation
                }
            });
        }
        
        // Check on load and scroll
        window.addEventListener('load', checkVisibility);
        window.addEventListener('scroll', checkVisibility);
    </script>
</body>
</html>