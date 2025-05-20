<!DOCTYPE html>
<html lang="es">
<head>
    <title>Turnos Asignados | Service Center</title>
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
        
        body.dark-mode .date-divider {
            color: #f8fafc;
            border-bottom-color: #333333;
        }
        
        body.dark-mode .turnos-card {
            background-color: #1e1e1e;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.3);
        }
        
        body.dark-mode .turno-item {
            border-bottom-color: #333333;
        }
        
        body.dark-mode .turno-item:last-child {
            border-bottom-color: transparent;
        }
        
        body.dark-mode .empty-message {
            background-color: #1e1e1e;
            color: #f8fafc;
        }

        /* Estilos para la sección de turnos */
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
        
        .date-divider {
            margin: 30px 0 15px;
            font-size: 1.3rem;
            font-weight: 600;
            color: var(--dark);
            padding-bottom: 8px;
            border-bottom: 2px solid #e2e8f0;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .date-divider i {
            color: var(--primary);
        }
        
        .turnos-container {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }
        
        .turnos-card {
            background-color: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
        }
        
        .turnos-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
        }
        
        .turno-item {
            padding: 15px;
            border-bottom: 1px solid #f1f5f9;
            transition: all 0.3s ease;
        }
        
        .turno-item:last-child {
            border-bottom: none;
        }
        
        .turno-item:hover {
            background-color: #f8fafc;
        }
        
        .turno-grid {
            display: grid;
            grid-template-columns: auto 1fr auto;
            gap: 15px;
            align-items: center;
        }
        
        .turno-time {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            background-color: var(--primary);
            color: white;
            padding: 10px;
            border-radius: 8px;
            width: 70px;
            height: 70px;
            font-weight: 600;
        }
        
        .turno-hour {
            font-size: 1.2rem;
        }
        
        .turno-minutes {
            font-size: 0.9rem;
            opacity: 0.8;
        }
        
        .turno-info {
            display: flex;
            flex-direction: column;
            gap: 5px;
        }
        
        .turno-cliente {
            font-weight: 600;
            font-size: 1rem;
        }
        
        .turno-vehiculo {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 0.9rem;
            color: #64748b;
        }
        
        .turno-servicio {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 15px;
            background-color: #e0f2fe;
            color: var(--primary);
            font-size: 0.8rem;
            font-weight: 500;
            margin-top: 5px;
        }
        
        .turno-actions {
            display: flex;
            flex-direction: column;
            gap: 8px;
            align-items: flex-end;
        }
        
        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 500;
            white-space: nowrap;
        }
        
        .status-badge i {
            font-size: 0.8rem;
        }
        
        .status-pending {
            background-color: #fff7ed;
            color: var(--pending);
        }
        
        .status-confirmed {
            background-color: #eff6ff;
            color: var(--confirmed);
        }
        
        .status-completed {
            background-color: #ecfdf5;
            color: var(--completed);
        }
        
        .status-cancelled {
            background-color: #fef2f2;
            color: var(--cancelled);
        }
        
        .action-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 5px;
            padding: 6px 12px;
            border-radius: 6px;
            font-size: 0.9rem;
            font-weight: 500;
            text-decoration: none;
            cursor: pointer;
            border: none;
            transition: all 0.3s ease;
            white-space: nowrap;
        }
        
        .action-btn:hover {
            transform: translateY(-2px);
        }
        
        .btn-confirm {
            background-color: var(--confirmed);
            color: white;
        }
        
        .btn-cancel {
            background-color: var(--cancelled);
            color: white;
        }
        
        .btn-complete {
            background-color: var(--completed);
            color: white;
        }
        
        .btn-view {
            background-color: var(--info);
            color: white;
        }
        
        .empty-message {
            background-color: #f0f9ff;
            border-radius: 10px;
            padding: 20px;
            text-align: center;
            font-size: 1rem;
            color: #64748b;
            margin-top: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 10px;
        }
        
        .empty-message i {
            font-size: 2.5rem;
            color: var(--primary);
            margin-bottom: 10px;
        }
        
        /* Media queries para responsive */
        @media (max-width: 768px) {
            .turno-grid {
                grid-template-columns: 1fr;
                gap: 10px;
            }
            
            .turno-time {
                width: 100%;
                height: auto;
                flex-direction: row;
                justify-content: space-between;
                padding: 8px 15px;
                gap: 10px;
            }
            
            .turno-actions {
                flex-direction: row;
                align-items: center;
                justify-content: flex-end;
                gap: 10px;
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
                <i class="fas fa-calendar-check"></i>
                Mis Turnos Asignados
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
        <a href="{{ route('empleado.dashboard') }}" class="back-btn">
            <i class="fas fa-arrow-left"></i>
            Volver al Dashboard
        </a>
        
        @php
            $tieneConfirmados = false;
            foreach($turnosPorFecha as $fecha => $turnos) {
                if($turnos->where('estado', 'confirmado')->count() > 0) {
                    $tieneConfirmados = true;
                    break;
                }
            }
        @endphp
        
        <!-- Contenido de turnos -->
        @if(count($turnosPorFecha) > 0)
            <div class="turnos-container">
                @foreach($turnosPorFecha as $fecha => $turnos)
                    <div class="date-section">
                        <h2 class="date-divider">
                            <i class="fas fa-calendar-day"></i>
                            {{ date('d/m/Y', strtotime($fecha)) }}
                        </h2>
                        <div class="turnos-card">
                            @foreach($turnos as $turno)
                                <div class="turno-item">
                                    <div class="turno-grid">
                                        <div class="turno-time">
                                            <span class="turno-hour">{{ date('H:i', strtotime($turno->hora)) }}</span>
                                            <span class="turno-minutes">hrs</span>
                                        </div>
                                        
                                        <div class="turno-info">
                                            <div class="turno-cliente">
                                                @if(isset($turno->vehiculo->cliente->usuario->nombre))
                                                    {{ $turno->vehiculo->cliente->usuario->nombre }}
                                                @else
                                                    Cliente no disponible
                                                @endif
                                            </div>
                                            <div class="turno-vehiculo">
                                                <i class="fas fa-car"></i>
                                                {{ $turno->vehiculo->placa }}
                                                <span class="separator">•</span>
                                                @if(is_object($turno->vehiculo->marca))
                                                    {{ $turno->vehiculo->marca->nombre }}
                                                @else
                                                    {{ $turno->vehiculo->marca }}
                                                @endif
                                                {{ $turno->vehiculo->modelo }}
                                            </div>
                                            <span class="turno-servicio">{{ $turno->tipo_servicio }}</span>
                                        </div>
                                        
                                        <div class="turno-actions">
                                            @if($turno->estado == 'pendiente')
                                                <span class="status-badge status-pending">
                                                    <i class="fas fa-clock"></i>
                                                    Pendiente
                                                </span>
                                                <div class="action-buttons">
                                                    @if(!$tieneConfirmados)
                                                        <form action="{{ route('empleado.turnos.estado', $turno->id_turno) }}" method="POST" style="display: inline;">
                                                            @csrf
                                                            @method('PUT')
                                                            <input type="hidden" name="estado" value="confirmado">
                                                            <button type="submit" class="action-btn btn-confirm">
                                                                <i class="fas fa-check"></i>
                                                                Confirmar
                                                            </button>
                                                        </form>
                                                    @endif
                                                    
                                                    <form action="{{ route('empleado.turnos.estado', $turno->id_turno) }}" method="POST" style="display: inline;">
                                                        @csrf
                                                        @method('PUT')
                                                        <input type="hidden" name="estado" value="cancelado">
                                                        <button type="submit" class="action-btn btn-cancel" onclick="return confirm('¿Está seguro de cancelar este turno?')">
                                                            <i class="fas fa-times"></i>
                                                            Cancelar
                                                        </button>
                                                    </form>
                                                </div>
                                            @elseif($turno->estado == 'confirmado')
                                                <span class="status-badge status-confirmed">
                                                    <i class="fas fa-check-circle"></i>
                                                    Confirmado
                                                </span>
                                                <a href="{{ route('empleado.lavadas.create', $turno->id_turno) }}" class="action-btn btn-complete">
                                                    <i class="fas fa-soap"></i>
                                                    Registrar Lavado
                                                </a>
                                            @elseif($turno->estado == 'completado')
                                                <span class="status-badge status-completed">
                                                    <i class="fas fa-check-double"></i>
                                                    Completado
                                                </span>
                                                @if($turno->lavada)
                                                    <a href="{{ route('empleado.lavadas.show', $turno->lavada->id_lavada) }}" class="action-btn btn-view">
                                                        <i class="fas fa-eye"></i>
                                                        Ver Detalles
                                                    </a>
                                                @endif
                                            @elseif($turno->estado == 'cancelado')
                                                <span class="status-badge status-cancelled">
                                                    <i class="fas fa-ban"></i>
                                                    Cancelado
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="empty-message">
                <i class="fas fa-calendar-xmark"></i>
                <p>No tienes turnos asignados en este momento.</p>
            </div>
        @endif
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
    </script>
</body>
</html>