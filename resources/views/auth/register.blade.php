<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro - Service Center</title>
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

        /* Burbujas animadas de fondo - Dirección invertida */
        .bubbles {
            position: absolute;
            width: 100%;
            height: 100%;
            z-index: 1;
            overflow: hidden;
            top: 0;
            left: 0;
            transform: rotateY(180deg);
        }

        .bubble {
            position: absolute;
            bottom: -100px;
            width: var(--bubble-size);
            height: var(--bubble-size);
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            opacity: 0.5;
            animation: riseReverse 10s infinite ease-in;
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

        @keyframes riseReverse {
            0% {
                bottom: 1080px;
                transform: translateX(0);
            }
            50% {
                transform: translateX(-100px);
            }
            100% {
                bottom: -100px;
                transform: translateX(100px);
            }
        }

        /* Contenedor principal */
        .register-container {
            background-color: white;
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 500px;
            padding: 40px;
            position: relative;
            z-index: 10;
            overflow: hidden;
            animation: entranceFlip 1s ease-out;
        }

        @keyframes entranceFlip {
            0% {
                opacity: 0;
                transform: rotateY(-90deg);
            }
            100% {
                opacity: 1;
                transform: rotateY(0);
            }
        }

        .register-container::before {
            content: '';
            position: absolute;
            top: -10px;
            left: -10px;
            right: -10px;
            bottom: -10px;
            background: linear-gradient(135deg, var(--primary-light), var(--accent));
            border-radius: 30px;
            z-index: -1;
            opacity: 0.3;
            filter: blur(15px);
        }

        /* Encabezado */
        .register-header {
            text-align: center;
            margin-bottom: 30px;
            animation: fadeInDown 1s ease-out;
        }

        .register-header h1 {
            color: var(--primary-dark);
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 10px;
            position: relative;
            display: inline-block;
        }

        .register-header h1::after {
            content: '';
            position: absolute;
            width: 70%;
            height: 3px;
            background: linear-gradient(to right, var(--accent), var(--primary));
            bottom: -10px;
            left: 15%;
            border-radius: 50px;
        }

        .register-logo {
            font-size: 32px;
            font-weight: 800;
            color: var(--primary);
            margin-bottom: 10px;
            letter-spacing: 1px;
        }

        .register-logo span {
            color: var(--accent);
        }

        /* Alertas */
        .alert {
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 20px;
            animation: pulse 1.5s ease-in-out;
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
        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .form-grid .form-group:nth-child(2n+1) {
            animation-delay: 0.2s;
        }

        .form-grid .form-group:nth-child(2n) {
            animation-delay: 0.3s;
        }

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
            animation-delay: 0.3s;
        }

        .form-group:nth-child(3) {
            animation-delay: 0.4s;
        }

        .form-group:nth-child(4) {
            animation-delay: 0.5s;
        }

        .form-group:nth-child(5) {
            animation-delay: 0.6s;
        }

        .form-group:nth-child(6) {
            animation-delay: 0.7s;
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
            border-color: var(--accent);
            box-shadow: 0 0 0 3px rgba(0, 229, 255, 0.2);
            outline: none;
            background-color: white;
        }

        .form-control:focus + .input-icon {
            color: var(--accent);
            transform: scale(1.2);
        }

        .input-icon {
            position: absolute;
            left: 15px;
            top: 43px;
            color: #aaa;
            transition: all 0.3s ease;
        }

        /* Botón de registro */
        .register-btn {
            background: linear-gradient(to right, var(--accent), var(--primary));
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
            grid-column: span 2;
        }

        .register-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 0%;
            height: 100%;
            background-color: rgba(255, 255, 255, 0.2);
            transition: all 0.3s ease;
        }

        .register-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(0, 229, 255, 0.3);
        }

        .register-btn:hover::before {
            width: 100%;
        }

        /* Footer */
        .register-footer {
            text-align: center;
            margin-top: 30px;
            font-size: 14px;
            color: #666;
            animation: fadeInUp 0.8s ease-out 1s forwards;
            opacity: 0;
            grid-column: span 2;
        }

        .register-footer a {
            color: var(--accent);
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            position: relative;
        }

        .register-footer a::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: -2px;
            left: 0;
            background-color: var(--primary);
            transition: all 0.3s ease;
        }

        .register-footer a:hover {
            color: var(--primary);
        }

        .register-footer a:hover::after {
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
                box-shadow: 0 0 0 0 rgba(0, 229, 255, 0.3);
            }
            70% {
                transform: scale(1);
                box-shadow: 0 0 0 15px rgba(0, 229, 255, 0);
            }
            100% {
                transform: scale(0.95);
                box-shadow: 0 0 0 0 rgba(0, 229, 255, 0);
            }
        }

        /* Responsive */
        @media screen and (max-width: 600px) {
            .register-container {
                padding: 30px 20px;
            }

            .register-header h1 {
                font-size: 24px;
            }

            .form-grid {
                grid-template-columns: 1fr;
            }

            .form-group {
                margin-bottom: 20px;
            }

            .register-btn, .register-footer {
                grid-column: span 1;
            }

            .form-control {
                padding: 12px 12px 12px 35px;
                font-size: 14px;
            }

            .input-icon {
                top: 39px;
            }

            /* Burbujas más pequeñas en móviles */
            :root {
                --bubble-size: 6px;
            }
        }

        /* Sponge Animation - Invertida en el otro lado */
        .sponge-container {
            position: absolute;
            width: 100px;
            height: 60px;
            left: -20px;
            top: -20px;
            z-index: 5;
            animation: floatSpongeLeft 5s ease-in-out infinite;
            transform: scale(0.5) rotate(20deg);
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

        @keyframes floatSpongeLeft {
            0%, 100% {
                transform: scale(0.5) rotate(20deg) translateY(0);
            }
            50% {
                transform: scale(0.5) rotate(20deg) translateY(-10px);
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

        /* Ola de agua para efectos */
        .water-wave {
            position: absolute;
            bottom: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(ellipse at center, rgba(0, 229, 255, 0.3) 0%, rgba(0, 103, 179, 0) 70%);
            opacity: 0.3;
            border-radius: 43%;
            animation: rotate 15s linear infinite;
        }

        .water-wave:nth-child(2) {
            animation-duration: 30s;
            opacity: 0.1;
        }

        @keyframes rotate {
            from {
                transform: rotate(0deg);
            }
            to {
                transform: rotate(360deg);
            }
        }

        /* Efecto de gotas de agua */
        .water-drop {
            position: absolute;
            background-color: rgba(0, 229, 255, 0.5);
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

        /* Animación de transición a login */
        .transition-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 229, 255, 0.8);
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

        /* Animación de verificación para campos completados */
        .form-control:valid + .input-check {
            position: absolute;
            right: 15px;
            top: 43px;
            color: var(--success);
            opacity: 0;
            transform: scale(0);
            transition: all 0.3s ease;
        }

        .form-control:valid:focus + .input-check {
            opacity: 1;
            transform: scale(1);
        }

        /* Campos de formulario con indicador de fuerza */
        .password-strength {
            height: 5px;
            background: #eee;
            border-radius: 3px;
            margin-top: 8px;
            position: relative;
            overflow: hidden;
            display: none;
        }

        .password-strength-bar {
            position: absolute;
            top: 0;
            left: 0;
            height: 100%;
            width: 0;
            transition: width 0.3s ease, background 0.3s ease;
        }

        /* Se muestra cuando el input está en foco */
        #contraseña:focus ~ .password-strength {
            display: block;
        }
    </style>
</head>
<body>
    <!-- Burbujas animadas de fondo - Dirección invertida -->
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

    <!-- Efecto de olas -->
    <div class="water-wave"></div>
    <div class="water-wave"></div>

    <!-- Overlay de transición -->
    <div class="transition-overlay" id="transitionOverlay">
        <div class="transition-container">
            <div class="spin-icon">🧼</div>
            <div class="transition-title">Cargando inicio de sesión...</div>
        </div>
    </div>

    <!-- Contenedor principal -->
    <div class="register-container" id="registerContainer">
        <!-- Animación de esponja - en el lado opuesto -->
        <div class="sponge-container">
            <div class="sponge">
                <div class="foam"></div>
            </div>
        </div>

        <!-- Encabezado -->
        <div class="register-header">
            <div class="register-logo">Service<span>Center</span></div>
            <h1>Registro de Usuario</h1>
        </div>

        <!-- Alertas -->
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
        <form method="POST" action="{{ route('register') }}" id="registerForm" class="form-grid">
            @csrf
            <div class="form-group">
                <label for="nombre">Nombre Completo</label>
                <input type="text" name="nombre" id="nombre" class="form-control" value="{{ old('nombre') }}" required>
                <div class="input-icon">👤</div>
                <div class="input-check">✓</div>
            </div>
            
            <div class="form-group">
                <label for="correo">Correo Electrónico</label>
                <input type="email" name="correo" id="correo" class="form-control" value="{{ old('correo') }}" required>
                <div class="input-icon">✉️</div>
                <div class="input-check">✓</div>
            </div>
            
            <div class="form-group">
                <label for="contraseña">Contraseña</label>
                <input type="password" name="contraseña" id="contraseña" class="form-control" required>
                <div class="input-icon">🔒</div>
                <div class="password-strength">
                    <div class="password-strength-bar" id="passwordStrengthBar"></div>
                </div>
            </div>
            
            <div class="form-group">
                <label for="contraseña_confirmation">Confirmar Contraseña</label>
                <input type="password" name="contraseña_confirmation" id="contraseña_confirmation" class="form-control" required>
                <div class="input-icon">🔒</div>
            </div>
            
            <div class="form-group">
                <label for="telefono">Teléfono</label>
                <input type="text" name="telefono" id="telefono" class="form-control" value="{{ old('telefono') }}" required>
                <div class="input-icon">📱</div>
                <div class="input-check">✓</div>
            </div>
            
            <div class="form-group">
                <label for="direccion">Dirección</label>
                <input type="text" name="direccion" id="direccion" class="form-control" value="{{ old('direccion') }}" required>
                <div class="input-icon">📍</div>
                <div class="input-check">✓</div>
            </div>
            
            <button type="submit" class="register-btn" id="registerBtn">Registrarse</button>
            
            <div class="register-footer">
                ¿Ya tienes una cuenta? <a href="{{ route('login.form') }}" id="loginLink">Iniciar Sesión</a>
            </div>
        </form>
    </div>

    <!-- Script para efectos adicionales -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Agregar efecto de gotas de agua al teclear en el formulario
            const inputs = document.querySelectorAll('.form-control');
            
            inputs.forEach(input => {
                input.addEventListener('keydown', function(e) {
                    // Solo en algunas pulsaciones para no saturar
                    if (Math.random() > 0.85) {
                        createWaterDrop(input);
                    }
                });
            });

            // Transición a la página de login
            const loginLink = document.getElementById('loginLink');
            const transitionOverlay = document.getElementById('transitionOverlay');
            
            loginLink.addEventListener('click', function(e) {
                e.preventDefault();
                
                // Mostrar overlay con efecto de transición
                transitionOverlay.classList.add('active');
                
                // Redirigir después de la animación
                setTimeout(function() {
                    window.location.href = loginLink.getAttribute('href');
                }, 2000);
            });

            // Medidor de fortaleza de contraseña
            const passwordInput = document.getElementById('contraseña');
            const strengthBar = document.getElementById('passwordStrengthBar');
            
            passwordInput.addEventListener('input', function() {
                const password = this.value;
                let strength = 0;
                
                if (password.length >= 8) strength += 20;
                if (password.match(/[A-Z]/)) strength += 20;
                if (password.match(/[a-z]/)) strength += 20;
                if (password.match(/[0-9]/)) strength += 20;
                if (password.match(/[^A-Za-z0-9]/)) strength += 20;
                
                strengthBar.style.width = strength + '%';
                
                if (strength < 40) {
                    strengthBar.style.background = '#f44336'; // Rojo - débil
                } else if (strength < 80) {
                    strengthBar.style.background = '#ffa726'; // Naranja - media
                } else {
                    strengthBar.style.background = '#66bb6a'; // Verde - fuerte
                }
            });

            // Verificar coincidencia de contraseñas
            const confirmPasswordInput = document.getElementById('contraseña_confirmation');
            
            confirmPasswordInput.addEventListener('input', function() {
                if (passwordInput.value === this.value) {
                    this.style.borderColor = '#66bb6a';
                } else {
                    this.style.borderColor = '#f44336';
                }
            });
        });

        // Función para crear una gota de agua en un elemento específico
        function createWaterDrop(element) {
            const rect = element.getBoundingClientRect();
            const container = document.querySelector('.register-container');
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