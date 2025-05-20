<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - Service Center</title>
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
            --success: #4CAF50;
            --error: #f44336;
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
            min-height: 100vh;
            background: linear-gradient(135deg, var(--primary-dark), var(--primary), var(--secondary));
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            position: relative;
            overflow: hidden;
            perspective: 1000px;
        }

        /* Burbujas animadas de fondo */
        .bubbles {
            position: absolute;
            width: 100%;
            height: 100%;
            z-index: 1;
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

        .bubble:nth-child(8) {
            width: calc(var(--bubble-size) * 2.3);
            height: calc(var(--bubble-size) * 2.3);
            left: 25%;
            animation-duration: 10s;
            animation-delay: 1.5s;
        }

        .bubble:nth-child(9) {
            width: calc(var(--bubble-size) * 1.6);
            height: calc(var(--bubble-size) * 1.6);
            left: 75%;
            animation-duration: 8.5s;
            animation-delay: 2.5s;
        }

        .bubble:nth-child(10) {
            width: calc(var(--bubble-size) * 3.2);
            height: calc(var(--bubble-size) * 3.2);
            left: 45%;
            animation-duration: 13s;
            animation-delay: 0.5s;
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

        /* Contenedor principal */
        .login-container {
            background-color: white;
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 420px;
            padding: 40px;
            position: relative;
            z-index: 10;
            overflow: hidden;
            animation: fadeInUp 1s ease-out;
            transition: transform 0.8s ease-in-out;
            transform-style: preserve-3d;
        }

        .login-container.flip-exit {
            transform: rotateY(90deg);
        }

        .login-container::before {
            content: '';
            position: absolute;
            top: -10px;
            left: -10px;
            right: -10px;
            bottom: -10px;
            background: linear-gradient(135deg, var(--accent), var(--primary-light));
            border-radius: 30px;
            z-index: -1;
            opacity: 0.3;
            filter: blur(15px);
        }

        /* Encabezado */
        .login-header {
            text-align: center;
            margin-bottom: 30px;
            animation: fadeInDown 1s ease-out;
        }

        .login-header h1 {
            color: var(--primary-dark);
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 10px;
            position: relative;
            display: inline-block;
        }

        .login-header h1::after {
            content: '';
            position: absolute;
            width: 70%;
            height: 3px;
            background: linear-gradient(to right, var(--primary), var(--accent));
            bottom: -10px;
            left: 15%;
            border-radius: 50px;
        }

        .login-logo {
            font-size: 32px;
            font-weight: 800;
            color: var(--primary);
            margin-bottom: 10px;
            letter-spacing: 1px;
        }

        .login-logo span {
            color: var(--accent);
        }

        /* Alertas */
        .alert {
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 20px;
            animation: pulse 1.5s ease-in-out;
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

        .alert ul {
            margin: 10px 0 0 20px;
        }

        /* Formulario */
        .form-group {
            margin-bottom: 25px;
            position: relative;
            animation: fadeInRight 0.8s ease-out forwards;
            opacity: 0;
        }

        .form-group:nth-child(1) {
            animation-delay: 0.2s;
        }

        .form-group:nth-child(2) {
            animation-delay: 0.4s;
        }

        .form-group:nth-child(3) {
            animation-delay: 0.6s;
        }

        .form-group:nth-child(4) {
            animation-delay: 0.8s;
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
            padding: 15px 15px 15px 40px;
            border: 1px solid #ddd;
            border-radius: 12px;
            font-size: 16px;
            transition: all 0.3s ease;
            background-color: #f8f9fa;
            font-family: 'Poppins', sans-serif;
        }

        .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(0, 98, 204, 0.2);
            outline: none;
            background-color: white;
        }

        .form-control:focus + .input-icon {
            color: var(--primary);
            transform: scale(1.2);
        }

        .input-icon {
            position: absolute;
            left: 15px;
            top: 43px;
            color: #aaa;
            transition: all 0.3s ease;
        }

        /* Botón de login */
        .login-btn {
            background: linear-gradient(to right, var(--primary), var(--accent));
            color: white;
            border: none;
            border-radius: 50px;
            padding: 15px;
            width: 100%;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 10px;
            font-family: 'Poppins', sans-serif;
            position: relative;
            overflow: hidden;
            animation: fadeInUp 0.8s ease-out 0.9s forwards;
            opacity: 0;
        }

        .login-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 0%;
            height: 100%;
            background-color: rgba(255, 255, 255, 0.2);
            transition: all 0.3s ease;
        }

        .login-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(0, 103, 179, 0.3);
        }

        .login-btn:hover::before {
            width: 100%;
        }

        /* Footer */
        .login-footer {
            text-align: center;
            margin-top: 30px;
            font-size: 14px;
            color: #666;
            animation: fadeInUp 0.8s ease-out 1s forwards;
            opacity: 0;
        }

        .login-footer a {
            color: var(--primary);
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            position: relative;
        }

        .login-footer a::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: -2px;
            left: 0;
            background-color: var(--accent);
            transition: all 0.3s ease;
        }

        .login-footer a:hover {
            color: var(--accent);
        }

        .login-footer a:hover::after {
            width: 100%;
        }

        /* Animaciones */
        @keyframes fadeInUp {
            from {
                transform: translateY(40px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        @keyframes fadeInDown {
            from {
                transform: translateY(-40px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        @keyframes fadeInRight {
            from {
                transform: translateX(-30px);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        @keyframes pulse {
            0% {
                transform: scale(0.95);
                box-shadow: 0 0 0 0 rgba(0, 103, 179, 0.3);
            }
            70% {
                transform: scale(1);
                box-shadow: 0 0 0 15px rgba(0, 103, 179, 0);
            }
            100% {
                transform: scale(0.95);
                box-shadow: 0 0 0 0 rgba(0, 103, 179, 0);
            }
        }

        /* Responsive */
        @media screen and (max-width: 480px) {
            .login-container {
                padding: 30px 20px;
            }

            .login-header h1 {
                font-size: 24px;
            }

            .form-group {
                margin-bottom: 20px;
            }

            .form-control {
                padding: 12px 12px 12px 35px;
                font-size: 14px;
            }

            .input-icon {
                top: 39px;
            }

            .login-btn {
                padding: 12px;
                font-size: 15px;
            }

            /* Burbujas más pequeñas en móviles */
            :root {
                --bubble-size: 6px;
            }
        }

        /* Sponge Animation */
        .sponge-container {
            position: absolute;
            width: 100px;
            height: 60px;
            right: -20px;
            top: -20px;
            z-index: 5;
            animation: floatSponge 5s ease-in-out infinite;
            transform: scale(0.5) rotate(-20deg);
        }

        .sponge {
            position: absolute;
            width: 100%;
            height: 100%;
            background-color: #ffd54f;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
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

        .foam {
            position: absolute;
            width: 120px;
            height: 40px;
            background-color: white;
            border-radius: 50%;
            top: -20px;
            left: -10px;
            box-shadow: 
                20px -10px 0 -10px white,
                -20px -10px 0 -10px white;
            animation: foamBubble 2s ease-in-out infinite alternate;
        }

        @keyframes floatSponge {
            0%, 100% {
                transform: scale(0.5) rotate(-20deg) translateY(0);
            }
            50% {
                transform: scale(0.5) rotate(-20deg) translateY(-10px);
            }
        }

        @keyframes foamBubble {
            0% {
                transform: scale(1);
            }
            100% {
                transform: scale(1.1);
            }
        }

        /* Animación de tecleo para el formulario */
        .form-control.email {
            animation: typing 0.8s steps(20) 0.5s backwards;
        }

        @keyframes typing {
            from {
                width: 0;
            }
            to {
                width: 100%;
            }
        }

        /* Efecto de gotas de agua */
        .water-drop {
            position: absolute;
            background-color: rgba(255, 255, 255, 0.7);
            border-radius: 50%;
            width: 10px;
            height: 20px;
            pointer-events: none;
            z-index: 15;
            opacity: 0;
        }

        .water-drop.animate {
            animation: dropFall 1.5s ease-in forwards;
        }

        @keyframes dropFall {
            0% {
                transform: translateY(0) scale(1);
                opacity: 0.8;
            }
            80% {
                opacity: 0.8;
            }
            100% {
                transform: translateY(80px) scale(0.5);
                opacity: 0;
            }
        }

        /* Animación de transición a registro */
        .transition-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 103, 179, 0.9);
            z-index: 1000;
            display: flex;
            justify-content: center;
            align-items: center;
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.5s ease;
        }

        .transition-overlay.active {
            opacity: 1;
            visibility: visible;
        }

        .transition-container {
            text-align: center;
            color: white;
            transform: scale(0.8);
            transition: transform 0.5s ease;
        }

        .transition-overlay.active .transition-container {
            transform: scale(1);
        }

        .transition-title {
            font-size: 24px;
            margin-bottom: 20px;
            opacity: 0;
            transform: translateY(20px);
        }

        .transition-overlay.active .transition-title {
            animation: fadeInUpTransition 0.5s forwards 0.3s;
        }

        @keyframes fadeInUpTransition {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .water-wave {
            position: absolute;
            width: 300px;
            height: 300px;
            background: radial-gradient(circle, rgba(0, 229, 255, 0.8) 0%, rgba(0, 103, 179, 0) 70%);
            border-radius: 45% 45% 45% 45%;
            animation: waveAnimation 5s infinite ease-in-out;
            opacity: 0;
        }

        .transition-overlay.active .water-wave {
            opacity: 0.6;
        }

        @keyframes waveAnimation {
            0% {
                transform: rotate(0deg) scale(0.8);
            }
            50% {
                transform: rotate(180deg) scale(1.2);
            }
            100% {
                transform: rotate(360deg) scale(0.8);
            }
        }

        .spin-icon {
            font-size: 60px;
            display: inline-block;
            opacity: 0;
            transform: rotate(0deg);
        }

        .transition-overlay.active .spin-icon {
            opacity: 1;
            animation: spinEffect 1.5s ease-in-out;
        }

        @keyframes spinEffect {
            0% {
                transform: rotate(0deg) scale(0.5);
                opacity: 0;
            }
            50% {
                transform: rotate(360deg) scale(1.2);
                opacity: 1;
            }
            100% {
                transform: rotate(720deg) scale(1);
                opacity: 1;
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
        <div class="bubble"></div>
        <div class="bubble"></div>
        <div class="bubble"></div>
    </div>

    <!-- Overlay de transición -->
    <div class="transition-overlay" id="transitionOverlay">
        <div class="water-wave"></div>
        <div class="transition-container">
            <div class="spin-icon">🧽</div>
            <div class="transition-title">Cargando registro...</div>
        </div>
    </div>

    <!-- Contenedor principal -->
    <div class="login-container" id="loginContainer">
        <!-- Animación de esponja -->
        <div class="sponge-container">
            <div class="sponge">
                <div class="foam"></div>
            </div>
        </div>

        <!-- Encabezado -->
        <div class="login-header">
            <div class="login-logo">Service<span>Center</span></div>
            <h1>Iniciar Sesión</h1>
        </div>

        <!-- Alertas -->
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        
        @if ($errors->any())
            <div class="alert alert-error">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Formulario -->
        <form method="POST" action="{{ route('login') }}" id="loginForm">
            @csrf
            <div class="form-group">
                <label for="correo">Correo Electrónico</label>
                <input type="email" name="correo" id="correo" class="form-control email" value="{{ old('correo') }}" required>
                <div class="input-icon">✉️</div>
            </div>
            
            <div class="form-group">
                <label for="contraseña">Contraseña</label>
                <input type="password" name="contraseña" id="contraseña" class="form-control" required>
                <div class="input-icon">🔒</div>
            </div>
            
            <button type="submit" class="login-btn" id="loginBtn">Iniciar Sesión</button>
            
            <div class="login-footer">
                ¿No tienes una cuenta? <a href="{{ route('register.form') }}" id="registerLink">Registrarse</a>
            </div>
        </form>
    </div>

    <!-- Script para efectos adicionales -->
    <script>
        // Efecto de tecleo en el formulario cuando se carga la página
        document.addEventListener('DOMContentLoaded', function() {
            // Agregar efecto de gotas de agua al teclear en el formulario
            const inputs = document.querySelectorAll('.form-control');
            
            inputs.forEach(input => {
                input.addEventListener('keydown', function(e) {
                    // Solo en algunas pulsaciones para no saturar
                    if (Math.random() > 0.8) {
                        createWaterDrop(input);
                    }
                });
            });

            // Transición a la página de registro
            const registerLink = document.getElementById('registerLink');
            const transitionOverlay = document.getElementById('transitionOverlay');
            
            registerLink.addEventListener('click', function(e) {
                e.preventDefault();
                
                // Añadir clase flip-exit para que se voltee la tarjeta
                const loginContainer = document.getElementById('loginContainer');
                loginContainer.classList.add('flip-exit');
                
                // Mostrar overlay con efecto de transición
                transitionOverlay.classList.add('active');
                
                // Redirigir después de la animación
                setTimeout(function() {
                    window.location.href = registerLink.getAttribute('href');
                }, 2000);
            });
        });

        // Función para crear una gota de agua en un elemento específico
        function createWaterDrop(element) {
            const rect = element.getBoundingClientRect();
            const container = document.querySelector('.login-container');
            const containerRect = container.getBoundingClientRect();
            
            const drop = document.createElement('div');
            drop.classList.add('water-drop');
            
            // Posición relativa al elemento
            const leftPos = rect.left - containerRect.left + Math.random() * rect.width;
            const topPos = rect.top - containerRect.top;
            
            drop.style.left = `${leftPos}px`;
            drop.style.top = `${topPos}px`;
            
            container.appendChild(drop);
            
            // Iniciar animación
            setTimeout(() => {
                drop.classList.add('animate');
                
                // Eliminar después de la animación
                setTimeout(() => {
                    drop.remove();
                }, 1500);
            }, 10);
        }
    </script>
</body>
</html>