<!DOCTYPE html>
<html lang="es">
<head>
    <title>Mis Lavadas Registradas | Car Wash Pro</title>
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
        
        /* Controles de tema y vista */
        .controls {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .control-btn {
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
        
        .control-btn:hover {
            background-color: #e2e8f0;
        }
        
        .control-btn.active {
            background-color: var(--primary);
            color: white;
        }
        
        /* Modo oscuro */
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
        
        body.dark-mode .control-btn {
            color: #f8fafc;
        }
        
        body.dark-mode .control-btn:hover {
            background-color: #333333;
        }
        
        body.dark-mode .control-btn.active {
            background-color: var(--primary);
        }
        
        body.dark-mode .back-btn {
            background-color: #333333;
            color: #f8fafc;
        }
        
        /* Botón de regreso */
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
        
        /* Vista de tabla */
        .table-container {
            background-color: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            transition: all 0.3s;
            animation: fadeIn 0.5s ease-out;
        }
        
        @keyframes fadeIn {
            0% { opacity: 0; transform: translateY(20px); }
            100% { opacity: 1; transform: translateY(0); }
        }
        
        .lavadas-table {
            width: 100%;
            border-collapse: collapse;
        }
        
        .lavadas-table th {
            background-color: #f1f5f9;
            color: var(--dark);
            font-weight: 600;
            padding: 15px;
            text-align: left;
            border-bottom: 2px solid #e2e8f0;
            position: relative;
        }
        
        .lavadas-table th::after {
            content: '';
            position: absolute;
            left: 0;
            bottom: 0;
            width: 100%;
            height: 2px;
            background-color: var(--primary);
            transform: scaleX(0);
            transform-origin: left;
            transition: transform 0.3s ease;
        }
        
        .table-container:hover .lavadas-table th::after {
            transform: scaleX(1);
        }
        
        .lavadas-table td {
            padding: 15px;
            border-bottom: 1px solid #e2e8f0;
            transition: all 0.3s;
        }
        
        .lavadas-table tr {
            transition: all 0.3s;
        }
        
        .lavadas-table tr:hover {
            background-color: #f8fafc;
            transform: translateX(5px);
        }
        
        .lavadas-table tr:last-child td {
            border-bottom: none;
        }
        
        body.dark-mode .table-container {
            background-color: #1e1e1e;
        }
        
        body.dark-mode .lavadas-table th {
            background-color: #2d3748;
            color: #f8fafc;
            border-bottom-color: #4a5568;
        }
        
        body.dark-mode .lavadas-table td {
            border-bottom-color: #4a5568;
        }
        
        body.dark-mode .lavadas-table tr:hover {
            background-color: #2d3748;
        }
        
        /* Vista de tarjetas */
        .cards-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
            animation: fadeIn 0.5s ease-out;
        }
        
        .lavada-card {
            background-color: white;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
        }
        
        .lavada-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
        }
        
        .card-header {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 1px solid #e2e8f0;
        }
        
        .card-date {
            background-color: var(--primary);
            color: white;
            padding: 10px;
            border-radius: 10px;
            text-align: center;
            min-width: 75px;
        }
        
        .card-date .date {
            font-weight: 600;
            font-size: 0.9rem;
        }
        
        .card-date .time {
            font-size: 0.8rem;
            opacity: 0.9;
        }
        
        .card-vehicle {
            flex: 1;
        }
        
        .vehicle-plate {
            font-weight: 600;
            font-size: 1.1rem;
            color: var(--dark);
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .service-type {
            font-size: 0.9rem;
            color: #64748b;
            margin-top: 3px;
            display: inline-block;
            padding: 3px 10px;
            background-color: #e0f2fe;
            border-radius: 20px;
            color: var(--primary);
        }
        
        .card-actions {
            margin-top: 15px;
            display: flex;
            justify-content: flex-end;
        }
        
        body.dark-mode .lavada-card {
            background-color: #1e1e1e;
        }
        
        body.dark-mode .card-header {
            border-bottom-color: #4a5568;
        }
        
        body.dark-mode .vehicle-plate {
            color: #f8fafc;
        }
        
        body.dark-mode .service-type {
            background-color: #1e293b;
        }
        
        /* Estilo para el botón de acción */
        .action-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 5px;
            padding: 8px 15px;
            border-radius: 6px;
            background-color: var(--info);
            color: white;
            font-weight: 500;
            text-decoration: none;
            transition: all 0.3s ease;
        }
        
        .action-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            background-color: #0284c7;
        }
        
        .action-btn i {
            font-size: 0.9rem;
        }
        
        /* Paginación */
        .pagination {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 25px;
            flex-wrap: wrap;
            gap: 5px;
        }
        
        .pagination > div {
            display: flex;
            gap: 5px;
        }
        
        .pagination a, .pagination span {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 36px;
            height: 36px;
            padding: 0 10px;
            border-radius: 8px;
            background-color: white;
            color: var(--dark);
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
        }
        
        .pagination a:hover {
            background-color: #e0e7ff;
            transform: translateY(-2px);
        }
        
        .pagination .active {
            background-color: var(--primary);
            color: white;
            font-weight: 600;
        }
        
        .pagination .disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }
        
        body.dark-mode .pagination a, 
        body.dark-mode .pagination span {
            background-color: #1e1e1e;
            color: #f8fafc;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        }
        
        body.dark-mode .pagination a:hover {
            background-color: #2d3748;
        }
        
        /* Mensaje vacío */
        .empty-message {
            background-color: #f0f9ff;
            border-radius: 10px;
            padding: 30px;
            text-align: center;
            color: #64748b;
            margin-top: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 15px;
            animation: fadeIn 0.5s ease-out;
        }
        
        .empty-message i {
            font-size: 3rem;
            color: var(--primary);
            opacity: 0.7;
        }
        
        body.dark-mode .empty-message {
            background-color: #1e1e1e;
            color: #f8fafc;
        }
        
        /* Toggle de vistas */
        .view-mode {
            display: none;
        }
        
        .view-mode.active {
            display: block;
        }
        
        /* Media queries para responsividad */
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
            
            .cards-container {
                grid-template-columns: 1fr;
            }
            
            /* Responsive table */
            .lavadas-table {
                display: block;
                overflow-x: auto;
                white-space: nowrap;
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
            <a href="{{ route('empleado.turnos') }}" class="nav-item">
                <i class="fas fa-calendar-alt"></i>
                <span class="nav-item-text">Mis Turnos</span>
            </a>
            <a href="{{ route('empleado.lavadas.index') }}" class="nav-item active">
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
                <i class="fas fa-history"></i>
                Mis Lavadas Registradas
            </h1>
            <div class="controls">
                <!-- Botones para alternar vista -->
                <button class="control-btn" id="table-view-btn" title="Vista de tabla">
                    <i class="fas fa-table"></i>
                </button>
                <button class="control-btn" id="card-view-btn" title="Vista de tarjetas">
                    <i class="fas fa-th-large"></i>
                </button>
                <!-- Botón de tema -->
                <button class="control-btn" id="theme-toggle" title="Cambiar tema">
                    <i class="fas fa-moon"></i>
                </button>
            </div>
        </div>
        
        <!-- Enlace de retorno -->
        <a href="{{ route('empleado.dashboard') }}" class="back-btn">
            <i class="fas fa-arrow-left"></i>
            Volver al Dashboard
        </a>
        
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
        
        <!-- Contenido de Lavadas -->
        @if($lavadas->count() > 0)
            <!-- Vista de Tabla -->
            <div class="view-mode" id="table-view">
                <div class="table-container">
                    <table class="lavadas-table">
                        <thead>
                            <tr>
                                <th>Fecha</th>
                                <th>Hora</th>
                                <th>Vehículo</th>
                                <th>Servicio</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($lavadas as $lavada)
                                <tr>
                                    <td>{{ date('d/m/Y', strtotime($lavada->fecha)) }}</td>
                                    <td>{{ date('H:i', strtotime($lavada->hora)) }}</td>
                                    <td>{{ $lavada->vehiculo->placa }}</td>
                                    <td>{{ $lavada->turno->tipo_servicio ?? 'No especificado' }}</td>
                                    <td>
                                        <a href="{{ route('empleado.lavadas.show', $lavada->id_lavada) }}" class="action-btn">
                                            <i class="fas fa-eye"></i>
                                            Ver Detalle
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            
            <!-- Vista de Tarjetas -->
            <div class="view-mode" id="card-view">
                <div class="cards-container">
                    @foreach($lavadas as $lavada)
                        <div class="lavada-card">
                            <div class="card-header">
                                <div class="card-date">
                                    <div class="date">{{ date('d/m/Y', strtotime($lavada->fecha)) }}</div>
                                    <div class="time">{{ date('H:i', strtotime($lavada->hora)) }}</div>
                                </div>
                                <div class="card-vehicle">
                                    <div class="vehicle-plate">
                                        <i class="fas fa-car"></i>
                                        {{ $lavada->vehiculo->placa }}
                                    </div>
                                    <span class="service-type">
                                        {{ $lavada->turno->tipo_servicio ?? 'No especificado' }}
                                    </span>
                                </div>
                            </div>
                            <div class="card-actions">
                                <a href="{{ route('empleado.lavadas.show', $lavada->id_lavada) }}" class="action-btn">
                                    <i class="fas fa-eye"></i>
                                    Ver Detalle
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            
            <!-- Paginación -->
            <div class="pagination">
                {{ $lavadas->links() }}
            </div>
        @else
            <div class="empty-message">
                <i class="fas fa-car-wash"></i>
                <p>No has registrado lavados aún.</p>
            </div>
        @endif
    </main>

    <script>
        // Toggle del tema oscuro
        const themeToggle = document.getElementById('theme-toggle');
        const themeIcon = themeToggle.querySelector('i');
        
        // Verificar si hay una preferencia guardada de tema
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
        
        // Toggle de vista (tabla/tarjetas)
        const tableViewBtn = document.getElementById('table-view-btn');
        const cardViewBtn = document.getElementById('card-view-btn');
        const tableView = document.getElementById('table-view');
        const cardView = document.getElementById('card-view');
        
        // Verificar si hay una preferencia guardada de vista
        const viewMode = localStorage.getItem('viewMode') || 'table';
        
        // Aplicar vista según preferencia
        if (viewMode === 'table') {
            tableView.classList.add('active');
            tableViewBtn.classList.add('active');
        } else {
            cardView.classList.add('active');
            cardViewBtn.classList.add('active');
        }
        
        // Funciones para cambiar de vista
        tableViewBtn.addEventListener('click', function() {
            tableView.classList.add('active');
            cardView.classList.remove('active');
            tableViewBtn.classList.add('active');
            cardViewBtn.classList.remove('active');
            localStorage.setItem('viewMode', 'table');
        });
        
        cardViewBtn.addEventListener('click', function() {
            cardView.classList.add('active');
            tableView.classList.remove('active');
            cardViewBtn.classList.add('active');
            tableViewBtn.classList.remove('active');
            localStorage.setItem('viewMode', 'card');
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

        // Animaciones adicionales para las filas de la tabla y tarjetas
        document.addEventListener('DOMContentLoaded', function() {
            // Animación para filas de tabla
            const tableRows = document.querySelectorAll('.lavadas-table tbody tr');
            tableRows.forEach((row, index) => {
                row.style.opacity = '0';
                row.style.transform = 'translateY(10px)';
                row.style.transition = 'opacity 0.3s ease, transform 0.3s ease';
                
                setTimeout(() => {
                    row.style.opacity = '1';
                    row.style.transform = 'translateY(0)';
                }, 100 + (index * 50)); // Delay secuencial
            });
            
            // Animación para tarjetas
            const cards = document.querySelectorAll('.lavada-card');
            cards.forEach((card, index) => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(20px)';
                card.style.transition = 'opacity 0.4s ease, transform 0.4s ease';
                
                setTimeout(() => {
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0)';
                }, 150 + (index * 80)); // Delay secuencial
            });
        });
    </script>
</body>
</html>