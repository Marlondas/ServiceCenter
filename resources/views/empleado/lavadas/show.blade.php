<!DOCTYPE html>
<html lang="es">
<head>
    <title>Detalles del Lavado | Car Wash Pro</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Font Awesome para íconos -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #3B82F6;
            --secondary: #10b981;
            --dark: #1e293b;
            --light: #f8fafc;
            --danger: #ef4444;
            --success: #22c55e;
            --warning: #f59e0b;
            --info: #0ea5e9;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }
        
        body {
            background-color: #f1f5f9;
            overflow-x: hidden;
            min-height: 100vh;
            display: flex;
            transition: background-color 0.3s ease, color 0.3s ease;
        }
        
        /* Barra de navegación innovadora */
        .navbar {
            position: fixed;
            width: 80px;
            height: 100vh;
            background-color: var(--primary);
            left: 0;
            top: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 20px 0;
            transition: all 0.3s ease;
            z-index: 100;
            box-shadow: 3px 0 10px rgba(0, 0, 0, 0.1);
        }
        
        .navbar:hover {
            width: 200px;
        }
        
        .logo-container {
            width: 60px;
            height: 60px;
            display: flex;
            justify-content: center;
            align-items: center;
            margin-bottom: 30px;
            transition: all 0.3s;
            background-color: white;
            border-radius: 50%;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
        }
        
        .navbar:hover .logo-container {
            width: 140px;
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
        
        .nav-items {
            display: flex;
            flex-direction: column;
            width: 100%;
            gap: 5px;
            flex-grow: 1;
        }
        
        .nav-logout {
            width: 100%;
            margin-top: auto;
            padding-top: 20px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .logout-link {
            color: #ffcdd2 !important;
        }
        
        .logout-link:hover, .logout-link.active {
            background-color: rgba(255, 255, 255, 0.9) !important;
            color: var(--danger) !important;
        }
        
        .nav-item {
            display: flex;
            align-items: center;
            padding: 12px 15px;
            color: white;
            text-decoration: none;
            transition: all 0.3s;
            border-radius: 0 20px 20px 0;
            position: relative;
            width: 100%;
            overflow: hidden;
        }
        
        .nav-item:hover, .nav-item.active {
            background-color: white;
            color: var(--primary);
        }
        
        .nav-item i {
            font-size: 1.5rem;
            min-width: 50px;
            display: flex;
            justify-content: center;
            transition: all 0.3s;
        }
        
        .nav-item-text {
            visibility: hidden;
            opacity: 0;
            white-space: nowrap;
            transition: all 0.2s;
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
            width: 5px;
            background-color: var(--info);
        }
        
        /* Contenido principal */
        .main-content {
            flex: 1;
            margin-left: 80px;
            padding: 30px 20px;
            transition: all 0.3s;
        }
        
        .navbar:hover ~ .main-content {
            margin-left: 200px;
        }
        
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            flex-wrap: wrap;
            gap: 15px;
        }
        
        .page-title {
            font-size: 1.8rem;
            font-weight: 600;
            color: var(--dark);
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .page-title i {
            font-size: 1.8rem;
            color: var(--primary);
        }
        
        /* Modo oscuro */
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
            transition: all 0.3s ease;
        }
        
        .theme-toggle:hover {
            background-color: #e2e8f0;
        }
        
        body.dark-mode {
            background-color: #121212;
            color: #f8fafc;
        }
        
        body.dark-mode .main-content {
            background-color: #121212;
        }
        
        body.dark-mode .page-title {
            color: #f8fafc;
        }
        
        body.dark-mode .theme-toggle {
            color: #f8fafc;
        }
        
        body.dark-mode .theme-toggle:hover {
            background-color: #333333;
        }
        
        body.dark-mode .back-btn {
            background-color: #333333;
            color: #f8fafc;
        }
        
        /* Estilos para la página de detalles del lavado */
        .back-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 15px;
            border-radius: 8px;
            text-decoration: none;
            color: var(--primary);
            background-color: #e0e7ff;
            font-weight: 500;
            transition: all 0.3s ease;
            margin-bottom: 20px;
        }
        
        .back-btn:hover {
            background-color: #c7d2fe;
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
        
        .info-section {
            background-color: white;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
            animation: fadeInUp 0.5s ease-out;
        }
        
        @keyframes fadeInUp {
            0% { opacity: 0; transform: translateY(20px); }
            100% { opacity: 1; transform: translateY(0); }
        }
        
        .info-section:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
        }
        
        body.dark-mode .info-section {
            background-color: #1e1e1e;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.3);
        }
        
        .info-section h3 {
            display: flex;
            align-items: center;
            gap: 10px;
            color: var(--primary);
            font-size: 1.3rem;
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 1px solid #f1f5f9;
        }
        
        body.dark-mode .info-section h3 {
            border-bottom-color: #333333;
        }
        
        .info-section h3 i {
            color: var(--primary);
        }
        
        .info-section p {
            margin-bottom: 10px;
            line-height: 1.6;
        }
        
        .info-section p strong {
            color: var(--dark);
            display: inline-block;
            min-width: 120px;
        }
        
        body.dark-mode .info-section p strong {
            color: #e2e8f0;
        }
        
        .info-section p:last-child {
            margin-bottom: 0;
        }
        
        .image-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
            margin-top: 20px;
            animation-delay: 0.2s;
        }
        
        .image-box {
            background-color: white;
            border-radius: 12px;
            padding: 20px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        }
        
        .image-box:first-child {
            animation: slideInLeft 0.6s ease-out;
        }
        
        .image-box:last-child {
            animation: slideInRight 0.6s ease-out;
        }
        
        @keyframes slideInLeft {
            0% { opacity: 0; transform: translateX(-30px); }
            100% { opacity: 1; transform: translateX(0); }
        }
        
        @keyframes slideInRight {
            0% { opacity: 0; transform: translateX(30px); }
            100% { opacity: 1; transform: translateX(0); }
        }
        
        .image-box:hover {
            transform: scale(1.02);
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
        }
        
        body.dark-mode .image-box {
            background-color: #1e1e1e;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.3);
        }
        
        .image-box h3 {
            display: flex;
            align-items: center;
            gap: 10px;
            color: var(--primary);
            font-size: 1.2rem;
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 1px solid #f1f5f9;
        }
        
        body.dark-mode .image-box h3 {
            border-bottom-color: #333333;
        }
        
        .image-box h3 i {
            color: var(--primary);
        }
        
        .image-box img {
            width: 100%;
            height: auto;
            border-radius: 8px;
            transition: all 0.5s ease;
            transform-origin: center;
        }
        
        .image-box .img-wrapper {
            overflow: hidden;
            border-radius: 8px;
            position: relative;
        }
        
        .image-box .img-wrapper:hover img {
            transform: scale(1.05);
        }
        
        .image-box .img-wrapper::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(to bottom, rgba(0,0,0,0) 70%, rgba(0,0,0,0.1) 100%);
            border-radius: 8px;
            pointer-events: none;
        }
        
        .image-box p {
            text-align: center;
            padding: 20px;
            background-color: #f8fafc;
            border-radius: 8px;
            color: #64748b;
            border: 2px dashed #e2e8f0;
        }
        
        body.dark-mode .image-box p {
            background-color: #1e293b;
            color: #94a3b8;
            border-color: #333333;
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
        
        /* Media queries para responsive */
        @media (max-width: 768px) {
            .navbar {
                width: 60px;
                height: 60px;
                border-radius: 15px;
                bottom: 20px;
                right: 20px;
                left: auto;
                top: auto;
                padding: 0;
                overflow: hidden;
                box-shadow: 0 4px 15px rgba(0, 0, 0, 0.15);
            }
            
            .navbar.expanded {
                height: auto;
                width: 260px;
                padding: 15px;
            }
            
            .logo-container {
                width: 100%;
                height: 60px;
                margin-bottom: 0;
                border-radius: 0;
                box-shadow: none;
                background-color: transparent;
                cursor: pointer;
            }
            
            .logo-container i {
                color: white;
            }
            
            .navbar:hover .logo-container {
                width: 100%;
                border-radius: 0;
            }
            
            .nav-items {
                display: none;
            }
            
            .nav-logout {
                display: none;
                width: 100%;
                border-top: 1px solid rgba(255, 255, 255, 0.2);
                margin-top: 15px;
                padding-top: 15px;
            }
            
            .navbar.expanded .nav-items,
            .navbar.expanded .nav-logout {
                display: flex;
                margin-top: 20px;
            }
            
            .navbar:hover .nav-item-text {
                visibility: hidden;
                opacity: 0;
            }
            
            .navbar.expanded .nav-item-text {
                visibility: visible;
                opacity: 1;
            }
            
            .navbar:hover {
                width: 60px;
            }
            
            .navbar:hover .logo-text {
                display: none;
            }
            
            .main-content {
                margin-left: 0;
                padding-bottom: 80px;
            }
            
            .navbar:hover ~ .main-content {
                margin-left: 0;
            }
            
            .image-container {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <!-- Barra de navegación lateral -->
    <nav class="navbar" id="navbar">
        <div class="logo-container" id="nav-menu-toggle">
            <i class="fas fa-car-wash"></i>
            <span class="logo-text">Service Center</span>
        </div>
        <div class="nav-items">
            <a href="{{ route('empleado.dashboard') }}" class="nav-item">
                <i class="fas fa-home"></i>
                <span class="nav-item-text">Inicio</span>
            </a>
            <a href="{{ route('empleado.turnos') }}" class="nav-item active">
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
        <!-- Cabecera -->
        <div class="header">
            <h1 class="page-title">
                <i class="fas fa-car-wash"></i>
                Detalles del Lavado
            </h1>
            <button class="theme-toggle" id="theme-toggle">
                <i class="fas fa-moon"></i>
            </button>
        </div>
        
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
        
        <!-- Enlace de retorno -->
        <a href="{{ route('empleado.turnos') }}" class="back-btn">
            <i class="fas fa-arrow-left"></i>
            Volver a Turnos
        </a>
        
        <!-- Información del servicio -->
        <div class="info-section">
            <h3><i class="fas fa-info-circle"></i> Información del Servicio</h3>
            <p><strong>Cliente:</strong> {{ $lavada->vehiculo->cliente->usuario->nombre ?? 'No disponible' }}</p>
            <p><strong>Vehículo:</strong> {{ $lavada->vehiculo->placa }}</p>
            <p><strong>Tipo de Servicio:</strong> {{ $lavada->turno->tipo_servicio ?? 'No especificado' }}</p>
            <p><strong>Fecha y Hora:</strong> {{ date('d/m/Y', strtotime($lavada->fecha)) }} {{ date('H:i', strtotime($lavada->hora)) }}</p>
        </div>
        
        <!-- Observaciones -->
        <div class="info-section">
            <h3><i class="fas fa-comment-alt"></i> Observaciones</h3>
            <p>{{ $lavada->comentario ?? 'Sin observaciones' }}</p>
        </div>
        
        <!-- Contenedor de imágenes -->
        <div class="image-container">
            <div class="image-box">
                <h3><i class="fas fa-image"></i> Antes del Lavado</h3>
                @if($lavada->foto_antes)
                    <div class="img-wrapper">
                        <img src="{{ asset('storage/' . $lavada->foto_antes) }}" alt="Foto antes del lavado">
                    </div>
                @else
                    <p>No se subió imagen</p>
                @endif
            </div>
            
            <div class="image-box">
                <h3><i class="fas fa-image"></i> Después del Lavado</h3>
                @if($lavada->foto_despues)
                    <div class="img-wrapper">
                        <img src="{{ asset('storage/' . $lavada->foto_despues) }}" alt="Foto después del lavado">
                    </div>
                @else
                    <p>No se subió imagen</p>
                @endif
            </div>
        </div>
    </main>

    <script>
        // Toggle del tema oscuro
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
        const navMenuToggle = document.getElementById('nav-menu-toggle');
        const navbar = document.getElementById('navbar');
        
        navMenuToggle.addEventListener('click', function() {
            if (window.innerWidth <= 768) {
                navbar.classList.toggle('expanded');
            }
        });
        
        // Resize handler
        window.addEventListener('resize', function() {
            if (window.innerWidth > 768) {
                navbar.classList.remove('expanded');
            }
        });

        // Animaciones adicionales para las secciones
        document.addEventListener('DOMContentLoaded', function() {
            // Añadir un pequeño retraso para que las animaciones sean secuenciales
            const sections = document.querySelectorAll('.info-section');
            sections.forEach((section, index) => {
                section.style.animationDelay = (index * 0.1) + 's';
            });
            
            // Efecto de aparecer al hacer scroll para móviles
            if (window.innerWidth <= 768) {
                const imageBoxes = document.querySelectorAll('.image-box');
                
                const observer = new IntersectionObserver((entries) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            entry.target.style.opacity = 1;
                            entry.target.style.transform = 'translateY(0)';
                        }
                    });
                }, { threshold: 0.1 });
                
                imageBoxes.forEach(box => {
                    box.style.opacity = 0;
                    box.style.transform = 'translateY(20px)';
                    box.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
                    observer.observe(box);
                });
            }
        });
    </script>
</body>
</html>