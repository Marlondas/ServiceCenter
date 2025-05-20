<!DOCTYPE html>
<html lang="es">
<head>
    <title>Cambiar Contraseña - Car & Moto Wash</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
        
        :root {
            --primary: #3498db;
            --primary-dark: #2980b9;
            --secondary: #2ecc71;
            --accent: #f39c12;
            --danger: #e74c3c;
            --light: #ecf0f1;
            --dark: #34495e;
            --text: #2c3e50;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f9f9f9;
            color: var(--text);
            overflow-x: hidden;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: linear-gradient(135deg, #a1c4fd, #c2e9fb);
        }
        
        .container {
            max-width: 450px;
            width: 90%;
            margin: 50px auto;
            background: white;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
            transform: translateY(50px);
            opacity: 0;
            animation: slideIn 0.8s forwards, fadeIn 1s forwards;
        }
        
        @keyframes slideIn {
            to {
                transform: translateY(0);
            }
        }
        
        @keyframes fadeIn {
            to {
                opacity: 1;
            }
        }
        
        @keyframes waterWave {
            0% {
                background-position: 0% 50%;
            }
            50% {
                background-position: 100% 50%;
            }
            100% {
                background-position: 0% 50%;
            }
        }
        
        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }
        
        @keyframes pulse {
            0% {
                transform: scale(1);
            }
            50% {
                transform: scale(1.05);
            }
            100% {
                transform: scale(1);
            }
        }
        
        .header {
            background: linear-gradient(-45deg, var(--primary), var(--primary-dark), var(--secondary), var(--primary));
            background-size: 300% 300%;
            animation: waterWave 15s ease infinite;
            color: white;
            text-align: center;
            padding: 30px 0;
            border-radius: 20px 20px 0 0;
            position: relative;
        }
        
        .header h1 {
            font-size: 24px;
            margin-bottom: 10px;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 12px;
        }
        
        .header p {
            font-size: 14px;
            opacity: 0.9;
            max-width: 80%;
            margin: 0 auto;
        }
        
        .header .icon {
            display: flex;
            justify-content: center;
            margin-bottom: 15px;
        }
        
        .header .icon i {
            font-size: 40px;
            animation: pulse 2s infinite;
        }
        
        .car-wash-icon {
            position: absolute;
            width: 100%;
            height: 40px;
            bottom: 0;
            left: 0;
            display: flex;
            justify-content: space-around;
            align-items: flex-end;
            overflow: hidden;
        }
        
        .bubble {
            background-color: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            position: absolute;
            animation: bubbleRise 2s infinite linear;
        }
        
        @keyframes bubbleRise {
            0% {
                transform: translateY(0) scale(1);
                opacity: 0;
            }
            50% {
                opacity: 0.5;
            }
            100% {
                transform: translateY(-60px) scale(0);
                opacity: 0;
            }
        }
        
        .form-container {
            padding: 30px;
        }
        
        .form-group {
            margin-bottom: 25px;
            position: relative;
            transform: translateX(-50px);
            opacity: 0;
            animation: slideRight 0.5s forwards;
        }
        
        .form-group:nth-child(1) {
            animation-delay: 0.3s;
        }
        
        .form-group:nth-child(2) {
            animation-delay: 0.5s;
        }
        
        .form-group:nth-child(3) {
            animation-delay: 0.7s;
        }
        
        @keyframes slideRight {
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }
        
        .form-control {
            width: 100%;
            padding: 15px 20px;
            border: 2px solid #e1e5ea;
            border-radius: 10px;
            font-size: 14px;
            transition: all 0.3s ease;
            padding-right: 45px;
        }
        
        .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(52, 152, 219, 0.1);
            outline: none;
        }
        
        .form-label {
            display: block;
            margin-bottom: 10px;
            font-weight: 500;
            font-size: 14px;
            transform: translateY(0);
            transition: all 0.3s ease;
        }
        
        .form-control:focus + .form-icon {
            color: var(--primary);
        }
        
        .form-icon {
            position: absolute;
            right: 15px;
            top: 47px;
            color: #a0a0a0;
            transition: all 0.3s ease;
        }
        
        .form-help {
            margin-top: 8px;
            font-size: 12px;
            color: #999;
            display: flex;
            align-items: center;
            gap: 5px;
        }
        
        .form-help i {
            font-size: 10px;
        }
        
        .password-strength {
            margin-top: 12px;
            height: 5px;
            border-radius: 10px;
            background: #e1e5ea;
            overflow: hidden;
            position: relative;
        }
        
        .password-strength-bar {
            height: 100%;
            width: 0%;
            border-radius: 10px;
            transition: all 0.5s ease;
            background: #e74c3c;
        }
        
        .password-strength.weak .password-strength-bar {
            width: 33%;
            background: #e74c3c;
        }
        
        .password-strength.medium .password-strength-bar {
            width: 66%;
            background: #f39c12;
        }
        
        .password-strength.strong .password-strength-bar {
            width: 100%;
            background: #2ecc71;
        }
        
        .password-tips {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.5s ease;
            margin-top: 5px;
            font-size: 12px;
            color: #777;
        }
        
        .password-tips.show {
            max-height: 500px;
        }
        
        .password-tip {
            margin-top: 8px;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .password-tip i {
            font-size: 10px;
            width: 14px;
            height: 14px;
            border-radius: 50%;
            background: #e1e5ea;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
        }
        
        .password-tip.valid i {
            background: #2ecc71;
        }
        
        .alert {
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 20px;
            font-size: 14px;
            opacity: 0;
            transform: scale(0.8);
            animation: alertShow 0.5s forwards;
        }
        
        @keyframes alertShow {
            to {
                opacity: 1;
                transform: scale(1);
            }
        }
        
        .alert-danger {
            background-color: rgba(231, 76, 60, 0.1);
            color: #e74c3c;
            border-left: 4px solid #e74c3c;
        }
        
        .alert ul {
            margin: 0;
            padding-left: 20px;
        }
        
        .btn {
            display: block;
            width: 100%;
            padding: 15px;
            border: none;
            border-radius: 10px;
            background: var(--primary);
            color: white;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        
        .btn:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }
        
        .btn:active {
            transform: translateY(0);
        }
        
        .btn .btn-content {
            position: relative;
            z-index: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 10px;
        }
        
        .btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: all 0.5s ease;
        }
        
        .btn:hover::before {
            left: 100%;
        }
        
        @media (max-width: 500px) {
            .container {
                width: 95%;
                margin: 20px auto;
            }
            
            .form-container {
                padding: 20px;
            }
            
            .header {
                padding: 20px 0;
            }
            
            .header h1 {
                font-size: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="icon">
                <i class="fas fa-key"></i>
            </div>
            <h1>Cambiar Contraseña <i class="fas fa-lock"></i></h1>
            <p>Por seguridad, debes actualizar tu contraseña antes de continuar</p>
            
            <div class="car-wash-icon">
                <!-- Burbujas animadas -->
                <div class="bubble" style="left: 10%; width: 8px; height: 8px; animation-duration: 3s;"></div>
                <div class="bubble" style="left: 25%; width: 12px; height: 12px; animation-duration: 2.5s; animation-delay: 0.2s;"></div>
                <div class="bubble" style="left: 40%; width: 6px; height: 6px; animation-duration: 4s; animation-delay: 0.6s;"></div>
                <div class="bubble" style="left: 65%; width: 10px; height: 10px; animation-duration: 3.5s; animation-delay: 0.4s;"></div>
                <div class="bubble" style="left: 80%; width: 7px; height: 7px; animation-duration: 3.2s; animation-delay: 0.8s;"></div>
            </div>
        </div>
        
        <div class="form-container">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            
            <form action="{{ route('cambiar.password.post') }}" method="POST" id="passwordForm">
                @csrf
                <div class="form-group">
                    <label for="nueva_contraseña" class="form-label">Nueva Contraseña</label>
                    <input type="password" id="nueva_contraseña" name="nueva_contraseña" class="form-control" required>
                    <i class="fas fa-lock form-icon"></i>
                    
                    <div class="password-strength">
                        <div class="password-strength-bar"></div>
                    </div>
                    
                    <div class="password-tips">
                        <div class="password-tip" data-requirement="length">
                            <i class="fas fa-check"></i>
                            <span>Mínimo 6 caracteres</span>
                        </div>
                        <div class="password-tip" data-requirement="uppercase">
                            <i class="fas fa-check"></i>
                            <span>Al menos una mayúscula</span>
                        </div>
                        <div class="password-tip" data-requirement="number">
                            <i class="fas fa-check"></i>
                            <span>Al menos un número</span>
                        </div>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="nueva_contraseña_confirmation" class="form-label">Confirmar Contraseña</label>
                    <input type="password" id="nueva_contraseña_confirmation" name="nueva_contraseña_confirmation" class="form-control" required>
                    <i class="fas fa-check-circle form-icon"></i>
                    <div class="form-help">
                        <i class="fas fa-info-circle"></i>
                        <span>Las contraseñas deben coincidir</span>
                    </div>
                </div>
                
                <div class="form-group">
                    <button type="submit" class="btn">
                        <span class="btn-content">
                            <i class="fas fa-sync-alt"></i>
                            Actualizar Contraseña
                        </span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const passwordInput = document.getElementById('nueva_contraseña');
            const confirmInput = document.getElementById('nueva_contraseña_confirmation');
            const passwordStrength = document.querySelector('.password-strength');
            const passwordStrengthBar = document.querySelector('.password-strength-bar');
            const passwordTips = document.querySelector('.password-tips');
            const passwordTipItems = document.querySelectorAll('.password-tip');
            const form = document.getElementById('passwordForm');
            
            // Mostrar tips de contraseña cuando el campo obtiene el foco
            passwordInput.addEventListener('focus', function() {
                passwordTips.classList.add('show');
            });
            
            // Validar fuerza de contraseña y actualizar indicadores
            passwordInput.addEventListener('input', function() {
                const value = this.value;
                
                // Validar cada requerimiento
                const hasLength = value.length >= 6;
                const hasUppercase = /[A-Z]/.test(value);
                const hasNumber = /[0-9]/.test(value);
                
                // Actualizar indicadores de tips
                updateTip('length', hasLength);
                updateTip('uppercase', hasUppercase);
                updateTip('number', hasNumber);
                
                // Calcular fuerza de contraseña
                let strength = 0;
                if (hasLength) strength++;
                if (hasUppercase) strength++;
                if (hasNumber) strength++;
                
                // Actualizar barra de fuerza
                passwordStrength.className = 'password-strength';
                if (value.length > 0) {
                    if (strength === 1) {
                        passwordStrength.classList.add('weak');
                    } else if (strength === 2) {
                        passwordStrength.classList.add('medium');
                    } else if (strength === 3) {
                        passwordStrength.classList.add('strong');
                    }
                }
            });
            
            // Validar coincidencia de contraseñas
            confirmInput.addEventListener('input', function() {
                const password = passwordInput.value;
                const confirm = this.value;
                
                if (confirm.length > 0) {
                    if (password === confirm) {
                        this.style.borderColor = '#2ecc71';
                        document.querySelector('.form-help').style.color = '#2ecc71';
                    } else {
                        this.style.borderColor = '#e74c3c';
                        document.querySelector('.form-help').style.color = '#e74c3c';
                    }
                } else {
                    this.style.borderColor = '#e1e5ea';
                    document.querySelector('.form-help').style.color = '#999';
                }
            });
            
            // Validación del formulario antes de enviar
            form.addEventListener('submit', function(e) {
                const password = passwordInput.value;
                const confirm = confirmInput.value;
                
                if (password.length < 6) {
                    e.preventDefault();
                    alert('La contraseña debe tener al menos 6 caracteres.');
                    return false;
                }
                
                if (!/[A-Z]/.test(password)) {
                    e.preventDefault();
                    alert('La contraseña debe contener al menos una letra mayúscula.');
                    return false;
                }
                
                if (!/[0-9]/.test(password)) {
                    e.preventDefault();
                    alert('La contraseña debe contener al menos un número.');
                    return false;
                }
                
                if (password !== confirm) {
                    e.preventDefault();
                    alert('Las contraseñas no coinciden.');
                    return false;
                }
                
                return true;
            });
            
            function updateTip(requirement, isValid) {
                const tip = document.querySelector(`.password-tip[data-requirement="${requirement}"]`);
                if (isValid) {
                    tip.classList.add('valid');
                } else {
                    tip.classList.remove('valid');
                }
            }
            
            // Animación del botón al hacer clic
            document.querySelector('.btn').addEventListener('click', function() {
                // Esta función se ejecuta al hacer clic, pero la validación ocurre en el evento submit
                const icon = this.querySelector('i');
                
                // Solo cambiamos el ícono y estilo si pasa la validación
                if (validarFormulario()) {
                    icon.classList.remove('fa-sync-alt');
                    icon.classList.add('fa-spinner');
                    icon.classList.add('fa-spin');
                    this.style.backgroundColor = '#2ecc71';
                }
            });
            
            function validarFormulario() {
                const password = passwordInput.value;
                const confirm = confirmInput.value;
                
                return password.length >= 6 && 
                       /[A-Z]/.test(password) && 
                       /[0-9]/.test(password) && 
                       password === confirm;
            }
            
            // Crear animación de burbujas adicionales cada pocos segundos
            setInterval(() => {
                createBubble();
            }, 2000);
            
            function createBubble() {
                const bubble = document.createElement('div');
                bubble.classList.add('bubble');
                
                // Propiedades aleatorias para la burbuja
                const size = Math.floor(Math.random() * 8) + 5;
                const left = Math.floor(Math.random() * 90) + 5;
                const duration = Math.random() * 2 + 2;
                
                bubble.style.width = `${size}px`;
                bubble.style.height = `${size}px`;
                bubble.style.left = `${left}%`;
                bubble.style.animationDuration = `${duration}s`;
                
                document.querySelector('.car-wash-icon').appendChild(bubble);
                
                // Eliminar la burbuja después de la animación
                setTimeout(() => {
                    bubble.remove();
                }, duration * 1000);
            }
        });
    </script>
</body>
</html>