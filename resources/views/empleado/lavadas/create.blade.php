<!DOCTYPE html>
<html lang="es">
<head>
    <title>Registrar Lavado | Service Center</title>
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
        
        body.dark-mode .service-card {
            background-color: #1e1e1e;
            border-color: #333333;
        }

        body.dark-mode .upload-container {
            background-color: #1e1e1e;
        }
        
        body.dark-mode .form-card {
            background-color: #1e1e1e;
        }
        
        body.dark-mode .form-label {
            color: #f8fafc;
        }
        
        body.dark-mode .form-control {
            background-color: #333333;
            border-color: #4b5563;
            color: #f8fafc;
        }
        
        body.dark-mode .form-control::placeholder {
            color: #9ca3af;
        }
        
        body.dark-mode .dropzone {
            background-color: #333333;
            border-color: #4b5563;
        }
        
        body.dark-mode .dropzone:hover {
            background-color: #3f3f46;
        }
        
        /* Estilos específicos para registro de lavado */
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
        }

        /* Tarjeta de información del servicio */
        .service-card {
            background-color: white;
            border-radius: 15px;
            padding: 20px;
            margin-bottom: 30px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            transition: all 0.3s;
            border: 1px solid #e2e8f0;
        }
        
        .service-card h3 {
            font-size: 1.25rem;
            margin-bottom: 20px;
            color: var(--dark);
            display: flex;
            align-items: center;
            gap: 10px;
            padding-bottom: 10px;
            border-bottom: 1px solid #e2e8f0;
        }
        
        .service-card h3 i {
            color: var(--primary);
        }
        
        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
        }
        
        .info-item {
            margin-bottom: 10px;
        }
        
        .info-label {
            font-size: 0.875rem;
            color: #64748b;
            margin-bottom: 5px;
            display: block;
        }
        
        .info-value {
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .info-value i {
            color: var(--primary);
            font-size: 1rem;
        }
        
        .service-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.875rem;
            font-weight: 500;
            background-color: #e0f2fe;
            color: var(--primary);
        }
        
        /* Formulario de carga de imágenes */
        .upload-container {
            background-color: white;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            margin-bottom: 30px;
        }
        
        .upload-heading {
            font-size: 1.25rem;
            margin-bottom: 20px;
            color: var(--dark);
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .upload-heading i {
            color: var(--primary);
        }
        
        .dropzone-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
            margin-bottom: 20px;
        }
        
        .dropzone-group {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }
        
        .dropzone-label {
            font-weight: 500;
            color: var(--dark);
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .dropzone-label i {
            color: var(--primary);
        }
        
        .dropzone {
            width: 100%;
            height: 200px;
            border: 2px dashed #cbd5e1;
            border-radius: 10px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s;
            position: relative;
            overflow: hidden;
            padding: 20px;
        }
        
        .dropzone:hover {
            border-color: var(--primary);
            background-color: #f8fafc;
        }
        
        .dropzone input[type="file"] {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            opacity: 0;
            cursor: pointer;
            z-index: 2;
        }
        
        .dropzone-icon {
            font-size: 3rem;
            color: #cbd5e1;
            margin-bottom: 15px;
            transition: all 0.3s;
        }
        
        .dropzone:hover .dropzone-icon {
            color: var(--primary);
        }
        
        .dropzone-text {
            text-align: center;
            color: #64748b;
            font-size: 0.9rem;
            transition: all 0.3s;
        }
        
        .dropzone:hover .dropzone-text {
            color: var(--primary);
        }
        
        .preview-container {
            width: 100%;
            height: 100%;
            position: absolute;
            top: 0;
            left: 0;
            border-radius: 8px;
            overflow: hidden;
            z-index: 1;
        }
        
        .image-preview {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        .preview-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            border-radius: 8px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: all 0.3s;
            z-index: 3;
        }
        
        .dropzone:hover .preview-overlay {
            opacity: 1;
        }
        
        .overlay-icon {
            font-size: 2rem;
            color: white;
            margin-bottom: 10px;
        }
        
        .overlay-text {
            color: white;
            font-size: 0.9rem;
            font-weight: 500;
        }
        
        /* Sección de comentarios */
        .comment-section {
            background-color: white;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            margin-bottom: 30px;
        }
        
        .comment-heading {
            font-size: 1.25rem;
            margin-bottom: 20px;
            color: var(--dark);
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .comment-heading i {
            color: var(--primary);
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: var(--dark);
        }
        
        .form-control {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            font-size: 1rem;
            transition: all 0.3s;
            resize: vertical;
        }
        
        .form-control:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }
        
        .form-control::placeholder {
            color: #94a3b8;
        }
        
        textarea.form-control {
            min-height: 120px;
        }
        
        /* Botones de acción */
        .action-buttons {
            display: flex;
            gap: 15px;
        }
        
        .btn {
            padding: 12px 20px;
            border-radius: 10px;
            font-size: 1rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s;
            border: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            flex: 1;
        }
        
        .btn-primary {
            background-color: var(--primary);
            color: white;
        }
        
        .btn-primary:hover {
            background-color: #2563eb;
            transform: translateY(-2px);
        }
        
        .btn-secondary {
            background-color: #e2e8f0;
            color: #64748b;
        }
        
        .btn-secondary:hover {
            background-color: #cbd5e1;
            transform: translateY(-2px);
        }
        
        .error-message {
            color: var(--danger);
            font-size: 0.875rem;
            margin-top: 5px;
        }
        
        /* Media queries para responsive */
        @media (max-width: 768px) {
            .dropzone-container {
                grid-template-columns: 1fr;
            }
            
            .action-buttons {
                flex-direction: column;
            }
            
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
                <i class="fas fa-spray-can"></i>
                Registrar Lavado Completado
            </h1>
            <button class="theme-toggle" id="theme-toggle">
                <i class="fas fa-moon"></i>
            </button>
        </div>
        
        <!-- Notificaciones -->
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
        <div class="service-card">
            <h3>
                <i class="fas fa-info-circle"></i>
                Información del Servicio
            </h3>
            <div class="info-grid">
                <div class="info-item">
                    <span class="info-label">Cliente</span>
                    <div class="info-value">
                        <i class="fas fa-user"></i>
                        @if(isset($turno->vehiculo->cliente->usuario->nombre))
                            {{ $turno->vehiculo->cliente->usuario->nombre }}
                        @else
                            Cliente no disponible
                        @endif
                    </div>
                </div>
                
                <div class="info-item">
                    <span class="info-label">Vehículo</span>
                    <div class="info-value">
                        <i class="fas fa-car"></i>
                        {{ $turno->vehiculo->placa }}
                    </div>
                </div>
                
                <div class="info-item">
                    <span class="info-label">Tipo de Servicio</span>
                    <div class="info-value">
                        <span class="service-badge">{{ $turno->tipo_servicio }}</span>
                    </div>
                </div>
                
                <div class="info-item">
                    <span class="info-label">Fecha y Hora</span>
                    <div class="info-value">
                        <i class="far fa-calendar-alt"></i>
                        {{ date('d/m/Y', strtotime($turno->fecha)) }} - {{ date('H:i', strtotime($turno->hora)) }}
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Formulario para registro de lavado -->
        <form action="{{ route('empleado.lavadas.store', $turno->id_turno) }}" method="POST" enctype="multipart/form-data" id="lavadoForm">
            @csrf
            
            <!-- Sección de carga de imágenes -->
            <div class="upload-container">
                <h3 class="upload-heading">
                    <i class="fas fa-camera"></i>
                    Fotografías del Servicio
                </h3>
                
                <div class="dropzone-container">
                    <div class="dropzone-group">
                        <label class="dropzone-label">
                            <i class="fas fa-car-side"></i>
                            Foto Antes del Lavado
                        </label>
                        <div class="dropzone" id="dropzone-antes">
                            <input type="file" name="foto_antes" id="foto_antes" accept="image/*">
                            <i class="fas fa-cloud-upload-alt dropzone-icon"></i>
                            <div class="dropzone-text">
                                <p>Arrastra una imagen aquí o haz clic para seleccionarla</p>
                                <p class="mt-2 text-xs text-gray-500">PNG, JPG o JPEG (máx. 10MB)</p>
                            </div>
                            <div class="preview-container" style="display: none;">
                                <img id="preview-antes" class="image-preview">
                                <div class="preview-overlay">
                                    <i class="fas fa-exchange-alt overlay-icon"></i>
                                    <span class="overlay-text">Cambiar imagen</span>
                                </div>
                            </div>
                        </div>
                        @error('foto_antes')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    <div class="dropzone-group">
                        <label class="dropzone-label">
                            <i class="fas fa-car"></i>
                            Foto Después del Lavado
                        </label>
                        <div class="dropzone" id="dropzone-despues">
                            <input type="file" name="foto_despues" id="foto_despues" accept="image/*">
                            <i class="fas fa-cloud-upload-alt dropzone-icon"></i>
                            <div class="dropzone-text">
                                <p>Arrastra una imagen aquí o haz clic para seleccionarla</p>
                                <p class="mt-2 text-xs text-gray-500">PNG, JPG o JPEG (máx. 10MB)</p>
                            </div>
                            <div class="preview-container" style="display: none;">
                                <img id="preview-despues" class="image-preview">
                                <div class="preview-overlay">
                                    <i class="fas fa-exchange-alt overlay-icon"></i>
                                    <span class="overlay-text">Cambiar imagen</span>
                                </div>
                            </div>
                        </div>
                        @error('foto_despues')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
            
            <!-- Sección de comentarios -->
            <div class="comment-section">
                <h3 class="comment-heading">
                    <i class="fas fa-comment"></i>
                    Observaciones o Detalles Adicionales
                </h3>
                
                <div class="form-group">
                    <textarea name="comentario" id="comentario" class="form-control" placeholder="Ingrese sus observaciones sobre el servicio realizado...">{{ old('comentario') }}</textarea>
                    @error('comentario')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>
                
                <div class="action-buttons">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i>
                        Registrar Lavado Completado
                    </button>
                    <a href="{{ route('empleado.turnos') }}" class="btn btn-secondary">
                        <i class="fas fa-times"></i>
                        Cancelar
                    </a>
                </div>
            </div>
        </form>
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
        
        // Previsualización de imágenes
        function setupImagePreview(inputId, previewId, dropzoneId) {
            const input = document.getElementById(inputId);
            const preview = document.getElementById(previewId);
            const dropzone = document.getElementById(dropzoneId);
            const previewContainer = dropzone.querySelector('.preview-container');
            const dropzoneIcon = dropzone.querySelector('.dropzone-icon');
            const dropzoneText = dropzone.querySelector('.dropzone-text');
            
            input.addEventListener('change', function() {
                if (this.files && this.files[0]) {
                    const reader = new FileReader();
                    
                    reader.onload = function(e) {
                        preview.src = e.target.result;
                        previewContainer.style.display = 'block';
                        dropzoneIcon.style.display = 'none';
                        dropzoneText.style.display = 'none';
                    }
                    
                    reader.readAsDataURL(this.files[0]);
                } else {
                    previewContainer.style.display = 'none';
                    dropzoneIcon.style.display = 'block';
                    dropzoneText.style.display = 'block';
                }
            });
        }
        
        // Configurar previsualización para ambas imágenes
        setupImagePreview('foto_antes', 'preview-antes', 'dropzone-antes');
        setupImagePreview('foto_despues', 'preview-despues', 'dropzone-despues');
        
        // Validación del formulario
        document.getElementById('lavadoForm').addEventListener('submit', function(e) {
            let isValid = true;
            
            // Validar que ambas fotos se han cargado
            const fotoAntes = document.getElementById('foto_antes');
            const fotoDespues = document.getElementById('foto_despues');
            
            if (!fotoAntes.files || fotoAntes.files.length === 0) {
                const errorElement = document.createElement('span');
                errorElement.className = 'error-message';
                errorElement.textContent = 'Debes subir una foto antes del lavado';
                
                const errorContainer = fotoAntes.closest('.dropzone-group');
                
                // Remover cualquier mensaje de error previo
                const existingError = errorContainer.querySelector('.error-message');
                if (existingError) {
                    existingError.remove();
                }
                
                errorContainer.appendChild(errorElement);
                isValid = false;
            }
            
            if (!fotoDespues.files || fotoDespues.files.length === 0) {
                const errorElement = document.createElement('span');
                errorElement.className = 'error-message';
                errorElement.textContent = 'Debes subir una foto después del lavado';
                
                const errorContainer = fotoDespues.closest('.dropzone-group');
                
                // Remover cualquier mensaje de error previo
                const existingError = errorContainer.querySelector('.error-message');
                if (existingError) {
                    existingError.remove();
                }
                
                errorContainer.appendChild(errorElement);
                isValid = false;
            }
            
            if (!isValid) {
                e.preventDefault();
            }
        });
        
        // Efecto de arrastrar y soltar (drag and drop)
        ['dropzone-antes', 'dropzone-despues'].forEach(dropzoneId => {
            const dropzone = document.getElementById(dropzoneId);
            
            ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
                dropzone.addEventListener(eventName, preventDefaults, false);
            });
            
            function preventDefaults(e) {
                e.preventDefault();
                e.stopPropagation();
            }
            
            ['dragenter', 'dragover'].forEach(eventName => {
                dropzone.addEventListener(eventName, highlight, false);
            });
            
            ['dragleave', 'drop'].forEach(eventName => {
                dropzone.addEventListener(eventName, unhighlight, false);
            });
            
            function highlight() {
                dropzone.style.borderColor = '#3B82F6';
                dropzone.style.backgroundColor = '#f0f7ff';
            }
            
            function unhighlight() {
                dropzone.style.borderColor = '#cbd5e1';
                dropzone.style.backgroundColor = '';
            }
            
            dropzone.addEventListener('drop', handleDrop, false);
            
            function handleDrop(e) {
                const dt = e.dataTransfer;
                const files = dt.files;
                
                // Obtener el input correspondiente
                const input = dropzone.querySelector('input[type="file"]');
                
                if (files.length > 0) {
                    input.files = files;
                    
                    // Disparar evento change para activar la previsualización
                    const event = new Event('change', { bubbles: true });
                    input.dispatchEvent(event);
                }
            }
        });
    </script>
</body>
</html>