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
            
            --pending: #f59e0b;
            --confirmed: #0ea5e9;
            --completed: #10b981;
            --cancelled: #ef4444;
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
        
        body.dark-mode .vehicle-info-card {
            background-color: #1e1e1e;
            border-color: #333333;
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
        
        body.dark-mode .upload-area {
            background-color: #333333;
            border-color: #4b5563;
        }
        
        body.dark-mode .car-info-title {
            color: #f8fafc;
            border-bottom-color: #333333;
        }
        
        body.dark-mode .car-info-group {
            border-bottom-color: #333333;
        }
        
        body.dark-mode .car-info-label {
            color: #9ca3af;
        }
        
        /* Estilos específicos para el registro de lavado */
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
        
        .form-content {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
        }
        
        .vehicle-info-card {
            background-color: white;
            border-radius: 15px;
            padding: 0;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            overflow: hidden;
            border: 1px solid #e2e8f0;
            height: fit-content;
            transition: all 0.3s ease;
        }
        
        .vehicle-info-card:hover {
            box-shadow: 0 10px 15px rgba(0, 0, 0, 0.05);
            transform: translateY(-5px);
        }
        
        .car-header {
            background-color: var(--primary);
            color: white;
            padding: 15px 20px;
            display: flex;
            align-items: center;
            gap: 15px;
        }
        
        .car-icon {
            font-size: 2rem;
            background-color: rgba(255, 255, 255, 0.2);
            width: 50px;
            height: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 10px;
        }
        
        .car-title {
            font-size: 1.2rem;
            font-weight: 600;
        }
        
        .car-info-content {
            padding: 20px;
        }
        
        .car-info-title {
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: 15px;
            color: var(--dark);
            padding-bottom: 10px;
            border-bottom: 1px solid #f1f5f9;
        }
        
        .car-info-list {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }
        
        .car-info-group {
            padding-bottom: 10px;
            border-bottom: 1px dashed #f1f5f9;
        }
        
        .car-info-group:last-child {
            border-bottom: none;
        }
        
        .car-info-label {
            font-size: 0.85rem;
            color: #64748b;
            margin-bottom: 3px;
        }
        
        .car-info-value {
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .car-info-value i {
            font-size: 1rem;
            color: var(--primary);
        }
        
        .service-badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 500;
            background-color: #e0f2fe;
            color: var(--primary);
        }
        
        /* Formulario */
        .form-card {
            background-color: white;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        }
        
        .form-section {
            margin-bottom: 30px;
        }
        
        .form-section:last-child {
            margin-bottom: 0;
        }
        
        .form-section-title {
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: 15px;
            color: var(--primary);
            display: flex;
            align-items: center;
            gap: 8px;
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
            border-radius: 8px;
            font-size: 1rem;
            transition: all 0.3s ease;
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
            resize: vertical;
        }
        
        /* Área de carga de imágenes */
        .upload-container {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }
        
        .upload-group {
            position: relative;
        }
        
        .upload-area {
            width: 100%;
            height: 200px;
            border: 2px dashed #e2e8f0;
            border-radius: 10px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 10px;
            cursor: pointer;
            padding: 20px;
            text-align: center;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        
        .upload-area:hover {
            border-color: var(--primary);
        }
        
        .upload-area.active {
            border-color: var(--primary);
            background-color: rgba(59, 130, 246, 0.05);
        }
        
        .upload-icon {
            font-size: 2.5rem;
            color: #94a3b8;
            transition: all 0.3s ease;
        }
        
        .upload-text {
            font-size: 0.9rem;
            color: #64748b;
            transition: all 0.3s ease;
        }
        
        .upload-area:hover .upload-icon,
        .upload-area.active .upload-icon {
            color: var(--primary);
        }
        
        .upload-area:hover .upload-text,
        .upload-area.active .upload-text {
            color: var(--primary);
        }
        
        .upload-input {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            opacity: 0;
            cursor: pointer;
            z-index: 2;
        }
        
        .image-preview {
            width: 100%;
            height: 100%;
            object-fit: cover;
            position: absolute;
            top: 0;
            left: 0;
            z-index: 1;
            border-radius: 8px;
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
            gap: 10px;
            opacity: 0;
            transition: all 0.3s ease;
            z-index: 2;
        }
        
        .upload-area:hover .preview-overlay {
            opacity: 1;
        }
        
        .change-text {
            color: white;
            font-size: 0.9rem;
            font-weight: 500;
        }
        
        /* Botones de formulario */
        .form-buttons {
            display: flex;
            gap: 15px;
            margin-top: 20px;
        }
        
        .form-btn {
            padding: 12px 20px;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            border: none;
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }
        
        .btn-primary {
            background-color: var(--primary);
            color: white;
        }
        
        .btn-primary:hover {
            background-color: #2563eb;
            transform: translateY(-2px);
        }
        
        .btn-cancel {
            background-color: #f1f5f9;
            color: #64748b;
        }
        
        .btn-cancel:hover {
            background-color: #e2e8f0;
            transform: translateY(-2px);
        }
        
        /* Estilos responsive */
        @media (max-width: 992px) {
            .form-content {
                grid-template-columns: 1fr;
                gap: 20px;
            }
        }
        
        @media (max-width: 768px) {
            .upload-container {
                grid-template-columns: 1fr;
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
            
            .form-buttons {
                flex-direction: column;
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
                Registrar Lavado
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
        
        <!-- Formulario -->
        <form method="post" enctype="multipart/form-data" id="registroLavadoForm">
            @csrf
            
            <div class="form-content">
                <!-- Información del vehículo -->
                <div class="vehicle-info-card">
                    <div class="car-header">
                        <div class="car-icon">
                            <i class="fas fa-car"></i>
                        </div>
                        <div class="car-title">Información del Servicio</div>
                    </div>
                    
                    <div class="car-info-content">
                        <h3 class="car-info-title">Detalles del Vehículo</h3>
                        
                        <div class="car-info-list">
                            <div class="car-info-group">
                                <div class="car-info-label">Cliente</div>
                                <div class="car-info-value">
                                    <i class="fas fa-user"></i>
                                    @if(isset($turno->vehiculo->cliente->usuario->nombre))
                                        {{ $turno->vehiculo->cliente->usuario->nombre }}
                                    @else
                                        Cliente no disponible
                                    @endif
                                </div>
                            </div>
                            
                            <div class="car-info-group">
                                <div class="car-info-label">Vehículo</div>
                                <div class="car-info-value">
                                    <i class="fas fa-car-side"></i>
                                    @if(is_object($turno->vehiculo->marca))
                                        {{ $turno->vehiculo->marca->nombre }}
                                    @else
                                        {{ $turno->vehiculo->marca }}
                                    @endif
                                    {{ $turno->vehiculo->modelo }}
                                </div>
                            </div>
                            
                            <div class="car-info-group">
                                <div class="car-info-label">Placa</div>
                                <div class="car-info-value">
                                    <i class="fas fa-id-card"></i>
                                    {{ $turno->vehiculo->placa }}
                                </div>
                            </div>
                            
                            <div class="car-info-group">
                                <div class="car-info-label">Color</div>
                                <div class="car-info-value">
                                    <i class="fas fa-palette"></i>
                                    {{ $turno->vehiculo->color }}
                                </div>
                            </div>
                            
                            <div class="car-info-group">
                                <div class="car-info-label">Tipo de Servicio</div>
                                <div class="car-info-value">
                                    <span class="service-badge">{{ $turno->tipo_servicio }}</span>
                                </div>
                            </div>
                            
                            <div class="car-info-group">
                                <div class="car-info-label">Fecha y Hora</div>
                                <div class="car-info-value">
                                    <i class="fas fa-clock"></i>
                                    {{ date('d/m/Y', strtotime($turno->fecha)) }} - {{ date('H:i', strtotime($turno->hora)) }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Formulario de registro -->
                <div class="form-card">
                    <div class="form-section">
                        <h3 class="form-section-title">
                            <i class="fas fa-camera"></i>
                            Fotografías del Servicio
                        </h3>
                        
                        <div class="upload-container">
                            <div class="upload-group">
                                <label class="form-label">Foto Antes del Lavado</label>
                                <div class="upload-area" id="upload-area-antes">
                                    <input type="file" name="foto_antes" id="foto_antes" class="upload-input" accept="image/*">
                                    <i class="fas fa-cloud-upload-alt upload-icon"></i>
                                    <span class="upload-text">Haz clic o arrastra una imagen aquí</span>
                                    <img id="preview-antes" class="image-preview" style="display: none;">
                                    <div class="preview-overlay">
                                        <i class="fas fa-exchange-alt upload-icon"></i>
                                        <span class="change-text">Cambiar imagen</span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="upload-group">
                                <label class="form-label">Foto Después del Lavado</label>
                                <div class="upload-area" id="upload-area-despues">
                                    <input type="file" name="foto_despues" id="foto_despues" class="upload-input" accept="image/*">
                                    <i class="fas fa-cloud-upload-alt upload-icon"></i>
                                    <span class="upload-text">Haz clic o arrastra una imagen aquí</span>
                                    <img id="preview-despues" class="image-preview" style="display: none;">
                                    <div class="preview-overlay">
                                        <i class="fas fa-exchange-alt upload-icon"></i>
                                        <span class="change-text">Cambiar imagen</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-section">
                        <h3 class="form-section-title">
                            <i class="fas fa-comment-alt"></i>
                            Comentarios
                        </h3>
                        
                        <div class="form-group">
                            <label for="comentario" class="form-label">Observaciones (opcional)</label>
                            <textarea id="comentario" name="comentario" class="form-control" placeholder="Ingrese sus observaciones sobre el servicio realizado..."></textarea>
                        </div>
                    </div>
                    
                    <div class="form-buttons">
                        <button type="submit" name="registrar_lavado" class="form-btn btn-primary">
                            <i class="fas fa-save"></i>
                            Registrar Lavado
                        </button>
                        <a href="{{ route('empleado.turnos') }}" class="form-btn btn-cancel">
                            <i class="fas fa-times"></i>
                            Cancelar
                        </a>
                    </div>
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
        function setupImagePreview(inputId, previewId, uploadAreaId) {
            const input = document.getElementById(inputId);
            const preview = document.getElementById(previewId);
            const uploadArea = document.getElementById(uploadAreaId);
            
            input.addEventListener('change', function() {
                if (this.files && this.files[0]) {
                    const reader = new FileReader();
                    
                    reader.onload = function(e) {
                        preview.src = e.target.result;
                        preview.style.display = 'block';
                        uploadArea.classList.add('active');
                        
                        // Ocultar ícono y texto cuando hay imagen
                        const uploadIcon = uploadArea.querySelector('.upload-icon');
                        const uploadText = uploadArea.querySelector('.upload-text');
                        if (uploadIcon && uploadText) {
                            uploadIcon.style.display = 'none';
                            uploadText.style.display = 'none';
                        }
                    }
                    
                    reader.readAsDataURL(this.files[0]);
                } else {
                    preview.style.display = 'none';
                    uploadArea.classList.remove('active');
                    
                    // Mostrar ícono y texto cuando no hay imagen
                    const uploadIcon = uploadArea.querySelector('.upload-icon');
                    const uploadText = uploadArea.querySelector('.upload-text');
                    if (uploadIcon && uploadText) {
                        uploadIcon.style.display = 'block';
                        uploadText.style.display = 'block';
                    }
                }
            });
        }
        
        // Configurar previsualización para ambas imágenes
        setupImagePreview('foto_antes', 'preview-antes', 'upload-area-antes');
        setupImagePreview('foto_despues', 'preview-despues', 'upload-area-despues');
        
        // Validación de formulario
        document.getElementById('registroLavadoForm').addEventListener('submit', function(e) {
            const fotoAntes = document.getElementById('foto_antes');
            const fotoDespues = document.getElementById('foto_despues');
            let isValid = true;
            
            // Validar que al menos una foto se ha subido
            if (!fotoAntes.files || fotoAntes.files.length === 0) {
                alert('Por favor, sube una foto antes del lavado');
                isValid = false;
            }
            
            if (!fotoDespues.files || fotoDespues.files.length === 0) {
                alert('Por favor, sube una foto después del lavado');
                isValid = false;
            }
            
            if (!isValid) {
                e.preventDefault();
            }
        });
        
        // Efecto de arrastrar y soltar
        function setupDragAndDrop(uploadAreaId, inputId) {
            const uploadArea = document.getElementById(uploadAreaId);
            const input = document.getElementById(inputId);
            
            ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
                uploadArea.addEventListener(eventName, preventDefaults, false);
            });
            
            function preventDefaults(e) {
                e.preventDefault();
                e.stopPropagation();
            }
            
            ['dragenter', 'dragover'].forEach(eventName => {
                uploadArea.addEventListener(eventName, highlight, false);
            });
            
            ['dragleave', 'drop'].forEach(eventName => {
                uploadArea.addEventListener(eventName, unhighlight, false);
            });
            
            function highlight() {
                uploadArea.classList.add('active');
            }
            
            function unhighlight() {
                uploadArea.classList.remove('active');
            }
            
            uploadArea.addEventListener('drop', handleDrop, false);
            
            function handleDrop(e) {
                const dt = e.dataTransfer;
                const files = dt.files;
                
                if (files.length > 0) {
                    input.files = files;
                    
                    // Disparar evento change para activar la previsualización
                    const event = new Event('change', { bubbles: true });
                    input.dispatchEvent(event);
                }
            }
        }
        
        // Configurar arrastrar y soltar para ambas áreas de carga
        setupDragAndDrop('upload-area-antes', 'foto_antes');
        setupDragAndDrop('upload-area-despues', 'foto_despues');
    </script>
</body>
</html>