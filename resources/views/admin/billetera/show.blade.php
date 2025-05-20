<!DOCTYPE html>
<html lang="es">
<head>
    <title>Detalle de Billetera</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            /* Paleta de colores para lavadero de autos */
            --primary: #0055b3;
            --primary-light: #3d8dff;
            --primary-dark: #003b7a;
            --secondary: #00c2ff;
            --accent: #19e6ff;
            --success: #00d67f;
            --error: #ff3b5c;
            --warning: #ffb300;
            --info: #00b3e6;
            --light: #f0f8ff;
            --dark: #102a43;
            --gray: #64748b;
            --gray-light: #e9f2ff;
            --gray-dark: #334155;
            --white: #ffffff;
            --transition-speed: 0.3s;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            color: var(--dark);
            background-color: #f5f9ff;
            background-image: 
                radial-gradient(circle at 10% 20%, rgba(0, 122, 255, 0.03) 0%, rgba(0, 122, 255, 0) 20%),
                radial-gradient(circle at 90% 80%, rgba(0, 194, 255, 0.03) 0%, rgba(0, 194, 255, 0) 20%);
            min-height: 100vh;
            overflow-x: hidden;
        }

        /* Animación de carga inicial */
        .page-loader {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, var(--primary-dark), var(--primary));
            z-index: 9999;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            transition: opacity 0.5s ease-in-out, visibility 0.5s ease-in-out;
        }

        .page-loader.hidden {
            opacity: 0;
            visibility: hidden;
        }

        .loader-title {
            color: white;
            font-size: 28px;
            font-weight: 600;
            margin-bottom: 40px;
            opacity: 0;
            transform: translateY(20px);
            animation: fadeInUp 1s forwards 0.5s;
        }

        .loader-subtitle {
            color: rgba(255, 255, 255, 0.8);
            font-size: 16px;
            margin-top: 20px;
            opacity: 0;
            animation: fadeInUp 1s forwards 1s;
        }

        /* Animación de silueta de carro avanzando con la carga */
        .car-animation {
            position: relative;
            width: 300px;
            height: 60px;
            margin-bottom: 30px;
        }

        .moving-car {
            position: absolute;
            width: 80px;
            height: 25px;
            background: transparent;
            left: 0;
            top: 20px;
            transition: transform 3s ease-out;
            z-index: 5;
        }

        .car-silhouette {
            position: absolute;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 40"><path d="M20,20 Q30,5 50,5 Q70,5 80,20 L95,20 Q100,20 100,25 L100,30 Q100,35 95,35 L90,35 L85,35 Q80,35 80,30 Q80,25 75,25 Q70,25 70,30 Q70,35 65,35 L35,35 Q30,35 30,30 Q30,25 25,25 Q20,25 20,30 Q20,35 15,35 L10,35 L5,35 Q0,35 0,30 L0,25 Q0,20 5,20 Z" fill="white"/></svg>');
            background-size: contain;
            background-repeat: no-repeat;
            filter: drop-shadow(0 5px 10px rgba(0,0,0,0.2));
        }

        .road {
            position: absolute;
            width: 100%;
            height: 3px;
            background-color: rgba(255,255,255,0.3);
            bottom: 5px;
            left: 0;
            border-radius: 2px;
        }

        .road::before {
            content: '';
            position: absolute;
            width: 100%;
            height: 1px;
            background-color: rgba(255,255,255,0.7);
            top: 50%;
            left: 0;
            transform: translateY(-50%);
            background: repeating-linear-gradient(90deg, rgba(255,255,255,0.7), rgba(255,255,255,0.7) 10px, transparent 10px, transparent 20px);
        }

        .progress-container {
            width: 300px;
            height: 6px;
            background-color: rgba(255, 255, 255, 0.2);
            border-radius: 3px;
            overflow: hidden;
            margin-top: 20px;
            opacity: 0;
            animation: fadeInUp 1s forwards 1.2s;
        }

        .progress-bar {
            height: 100%;
            width: 0;
            background-color: var(--accent);
            border-radius: 3px;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Layout principal */
        .dashboard-container {
            display: flex;
            min-height: 100vh;
            position: relative;
        }

        /* Barra lateral con mejoras para responsividad */
        .sidebar {
            width: 260px;
            background: linear-gradient(145deg, var(--primary-dark), var(--primary));
            color: white;
            transition: all var(--transition-speed) ease;
            position: fixed;
            top: 0;
            left: 0;
            height: 100%;
            z-index: 100;
            box-shadow: 0 0 30px rgba(0, 0, 0, 0.15);
            overflow-y: auto;
            overflow-x: hidden;
        }

        .sidebar.collapsed {
            width: 70px;
        }

        .sidebar-header {
            padding: 20px 15px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .sidebar-logo {
            display: flex;
            align-items: center;
            font-size: 20px;
            font-weight: 700;
            white-space: nowrap;
            overflow: hidden;
            transition: all var(--transition-speed) ease;
        }

        .sidebar-logo i {
            font-size: 24px;
            margin-right: 10px;
        }

        .sidebar-logo span {
            color: var(--accent);
        }

        .sidebar.collapsed .sidebar-logo {
            justify-content: center;
        }

        .sidebar.collapsed .sidebar-logo span {
            display: none;
        }

        .toggle-sidebar {
            cursor: pointer;
            font-size: 20px;
            color: white;
            background: none;
            border: none;
            transition: all var(--transition-speed) ease;
        }

        .toggle-sidebar:hover {
            color: var(--accent);
        }

        .sidebar.collapsed .toggle-sidebar {
            transform: rotate(180deg);
        }

        .sidebar-user {
            padding: 20px;
            text-align: center;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .user-avatar {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            background-color: var(--primary-light);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
            overflow: hidden;
            transition: all var(--transition-speed) ease;
        }

        .user-avatar i {
            font-size: 30px;
            color: white;
        }

        .user-info {
            white-space: nowrap;
            transition: opacity var(--transition-speed) ease;
        }

        .user-name {
            font-size: 16px;
            font-weight: 600;
            margin-bottom: 5px;
        }

        .user-role {
            font-size: 12px;
            color: rgba(255, 255, 255, 0.7);
        }

        .sidebar.collapsed .user-info {
            display: none;
        }

        .sidebar.collapsed .user-avatar {
            width: 40px;
            height: 40px;
        }

        .sidebar-menu {
            padding: 20px 0;
        }

        .menu-item {
            position: relative;
            display: block;
            padding: 12px 20px;
            display: flex;
            align-items: center;
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            transition: all var(--transition-speed) ease;
            white-space: nowrap;
        }

        .menu-item:hover, .menu-item.active {
            background-color: rgba(255, 255, 255, 0.1);
            color: white;
        }

        .menu-item i {
            font-size: 20px;
            min-width: 35px;
            text-align: center;
            margin-right: 10px;
            transition: all var(--transition-speed) ease;
        }

        .sidebar.collapsed .menu-item span {
            display: none;
        }

        .sidebar.collapsed .menu-item i {
            margin-right: 0;
        }

        .sidebar.collapsed .menu-item {
            display: flex;
            justify-content: center;
            padding: 15px;
        }

        .menu-label {
            padding: 10px 20px;
            font-size: 12px;
            text-transform: uppercase;
            color: rgba(255, 255, 255, 0.5);
            letter-spacing: 1px;
            transition: opacity var(--transition-speed) ease;
        }

        .sidebar.collapsed .menu-label {
            opacity: 0;
            height: 0;
            padding: 0;
            overflow: hidden;
        }

        .menu-tooltip {
            position: absolute;
            background-color: var(--primary-dark);
            color: white;
            padding: 5px 12px;
            border-radius: 4px;
            font-size: 12px;
            left: 70px;
            white-space: nowrap;
            opacity: 0;
            visibility: hidden;
            transition: all var(--transition-speed) ease;
            z-index: 100;
            pointer-events: none;
        }

        .menu-tooltip::before {
            content: '';
            position: absolute;
            top: 50%;
            left: -6px;
            transform: translateY(-50%);
            border-width: 6px 6px 6px 0;
            border-style: solid;
            border-color: transparent var(--primary-dark) transparent transparent;
        }

        .sidebar.collapsed .menu-item:hover .menu-tooltip {
            opacity: 1;
            visibility: visible;
        }
        
        /* Ocultar barra de desplazamiento pero mantener funcionalidad */
        .sidebar::-webkit-scrollbar {
            width: 0;
            background: transparent;
        }

        /* Contenido principal */
        .main-content {
            flex: 1;
            margin-left: 260px;
            padding: 20px;
            transition: margin-left var(--transition-speed) ease;
            opacity: 0;
            animation: fadeIn 0.5s forwards 0.3s;
        }

        .sidebar.collapsed ~ .main-content {
            margin-left: 70px;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }

        /* Header del contenido principal */
        .content-header {
            background-color: white;
            border-radius: 16px;
            padding: 25px;
            margin-bottom: 25px;
            box-shadow: 0 10px 25px rgba(0, 55, 179, 0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: relative;
            overflow: hidden;
            animation: slideDown 0.5s forwards;
        }

        /* Efecto de burbuja de agua para el header */
        .content-header::before {
            content: '';
            position: absolute;
            top: -50px;
            right: -50px;
            width: 100px;
            height: 100px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(0, 194, 255, 0.2) 0%, rgba(0, 194, 255, 0) 70%);
            z-index: 0;
        }

        .content-header::after {
            content: '';
            position: absolute;
            bottom: -30px;
            left: 30px;
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(0, 194, 255, 0.15) 0%, rgba(0, 194, 255, 0) 70%);
            z-index: 0;
        }

        @keyframes slideDown {
            from {
                transform: translateY(-20px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .page-title {
            font-size: 28px;
            font-weight: 600;
            color: var(--primary-dark);
            position: relative;
            z-index: 1;
        }

        .page-title::after {
            content: '';
            display: block;
            width: 40px;
            height: 4px;
            background: linear-gradient(to right, var(--primary), var(--secondary));
            border-radius: 2px;
            margin-top: 8px;
        }

        .breadcrumb {
            display: flex;
            align-items: center;
            list-style: none;
            flex-wrap: wrap;
            position: relative;
            z-index: 1;
        }

        .breadcrumb-item {
            font-size: 14px;
            color: var(--gray);
        }

        .breadcrumb-item a {
            color: var(--primary);
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .breadcrumb-item a:hover {
            color: var(--secondary);
        }

        .breadcrumb-item + .breadcrumb-item::before {
            content: '/';
            margin: 0 8px;
            color: var(--gray-light);
        }
        
        /* Estilos para el contenido específico del Detalle de Billetera */
        .info-box {
            background: linear-gradient(145deg, #ffffff, #f5f9ff);
            padding: 25px;
            border-radius: 16px;
            margin-bottom: 25px;
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            box-shadow: 0 5px 15px rgba(0, 55, 179, 0.08);
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .info-box:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(0, 55, 179, 0.12);
        }

        /* Efecto de goteo para info-box */
        .info-box::after {
            content: '';
            position: absolute;
            width: 15px;
            height: 15px;
            border-radius: 50%;
            background-color: rgba(0, 194, 255, 0.2);
            top: -8px;
            right: 40px;
            animation: dropletFall 4s infinite 1s;
        }

        @keyframes dropletFall {
            0% {
                transform: translateY(0) scale(1);
                opacity: 0.8;
            }
            80% {
                transform: translateY(80px) scale(1.2);
                opacity: 0;
            }
            100% {
                transform: translateY(80px) scale(1.2);
                opacity: 0;
            }
        }

        .info-item {
            text-align: center;
            flex: 1;
            min-width: 120px;
            margin: 10px;
            padding: 15px;
            border-radius: 12px;
            background-color: rgba(255, 255, 255, 0.5);
            box-shadow: 0 3px 10px rgba(0, 55, 179, 0.05);
            transition: all 0.3s ease;
        }

        .info-item:hover {
            background-color: white;
            box-shadow: 0 5px 15px rgba(0, 55, 179, 0.1);
        }

        .info-title {
            font-size: 0.9em;
            color: var(--gray);
            margin-bottom: 10px;
        }

        .info-value {
            font-size: 1.8em;
            font-weight: bold;
            margin-bottom: 5px;
            position: relative;
            display: inline-block;
        }

        /* Efectos de color con degradado para valores */
        .info-value::after {
            content: '';
            position: absolute;
            bottom: -3px;
            left: 50%;
            transform: translateX(-50%);
            width: 30px;
            height: 3px;
            border-radius: 2px;
            background: linear-gradient(to right, var(--primary-light), var(--secondary));
        }

        .info-green {
            color: var(--success);
        }

        .info-green::after {
            background: linear-gradient(to right, var(--success), #7affb2);
        }

        .info-blue {
            color: var(--primary);
        }

        .info-blue::after {
            background: linear-gradient(to right, var(--primary), var(--primary-light));
        }

        .info-red {
            color: var(--error);
        }

        .info-red::after {
            background: linear-gradient(to right, var(--error), #ff8599);
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 12px 25px;
            border-radius: 50px;
            color: white;
            text-decoration: none;
            margin-right: 10px;
            font-weight: 500;
            font-size: 15px;
            transition: all 0.3s cubic-bezier(0.165, 0.84, 0.44, 1);
            cursor: pointer;
            border: none;
            position: relative;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            z-index: 1;
        }

        .btn i {
            margin-right: 8px;
            font-size: 16px;
        }

        .btn::after {
            content: '';
            position: absolute;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.3) 0%, rgba(255, 255, 255, 0) 70%);
            transform: scale(0);
            transition: transform 0.5s cubic-bezier(0.165, 0.84, 0.44, 1);
            z-index: -1;
        }

        .btn:hover::after {
            transform: scale(2.5);
        }

        .btn-primary {
            background: linear-gradient(145deg, var(--primary), var(--primary-dark));
        }

        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(0, 55, 179, 0.2);
        }

        .btn-success {
            background: linear-gradient(145deg, var(--success), #00b368);
        }

        .btn-success:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(0, 214, 127, 0.2);
        }

        .btn-secondary {
            background: linear-gradient(145deg, var(--gray), var(--gray-dark));
        }

        .btn-secondary:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(100, 116, 139, 0.2);
        }

        .alert {
            padding: 18px;
            margin-bottom: 20px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            position: relative;
            overflow: hidden;
            animation: slideIn 0.5s ease;
        }

        @keyframes slideIn {
            from { transform: translateX(-20px); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }

        .alert-success {
            background-color: rgba(0, 214, 127, 0.1);
            border-left: 4px solid var(--success);
            color: var(--success);
        }

        /* Efecto de gota de agua para las alertas */
        .alert::before {
            content: '';
            position: absolute;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            background-color: rgba(255, 255, 255, 0.3);
            top: -10px;
            left: 20px;
            animation: dropletFall 3s infinite;
        }

        /* Estilos para tablas */
        .table-container {
            background-color: white;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 10px 25px rgba(0, 55, 179, 0.1);
            margin-bottom: 25px;
        }

        table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
        }

        thead {
            box-shadow: 0 3px 10px rgba(0, 55, 179, 0.05);
            position: relative;
            z-index: 2;
        }

        th {
            background: linear-gradient(to right, var(--light), white);
            color: var(--primary-dark);
            font-weight: 600;
            text-align: left;
            padding: 18px 20px;
            transition: all 0.3s ease;
            position: relative;
        }

        th:first-child {
            border-top-left-radius: 12px;
        }

        th:last-child {
            border-top-right-radius: 12px;
        }

        td {
            padding: 16px 20px;
            transition: all 0.3s ease;
            border-bottom: 1px solid var(--gray-light);
            position: relative;
            overflow: hidden;
        }

        /* Eliminar el borde de la última fila */
        tr:last-child td {
            border-bottom: none;
        }

        /* Efecto hover para filas */
        tbody tr {
            transition: all 0.3s ease;
            background-color: white;
        }

        tbody tr:hover {
            background-color: rgba(0, 194, 255, 0.05);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 55, 179, 0.08);
            z-index: 1;
            position: relative;
        }

        /* Animación de ondulación al hacer hover */
        tbody tr::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: linear-gradient(to right, var(--primary-light), var(--secondary));
            transform: scaleX(0);
            transform-origin: bottom right;
            transition: transform 0.5s ease;
            border-bottom-left-radius: 4px;
            border-bottom-right-radius: 4px;
        }

        tbody tr:hover::after {
            transform: scaleX(1);
            transform-origin: bottom left;
        }

        /* Estilos para badges */
        .badge {
            padding: 7px 12px;
            border-radius: 30px;
            font-size: 0.75rem;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
        }

        .badge i {
            margin-right: 5px;
            font-size: 12px;
        }

        .badge-success {
            background-color: rgba(0, 214, 127, 0.15);
            color: var(--success);
        }

        .badge-success:hover {
            background-color: rgba(0, 214, 127, 0.25);
        }

        .badge-danger {
            background-color: rgba(255, 59, 92, 0.15);
            color: var(--error);
        }

        .badge-danger:hover {
            background-color: rgba(255, 59, 92, 0.25);
        }

        /* Estilos para valores monetarios */
        .amount {
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .amount-positive {
            color: var(--success);
        }

        .amount-negative {
            color: var(--error);
        }

        /* Enlaces de navegación */
        .nav-links {
            margin-bottom: 25px;
            display: flex;
            flex-wrap: wrap;
        }

        .nav-link {
            text-decoration: none;
            color: var(--primary);
            margin-right: 20px;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            transition: all 0.3s ease;
        }

        .nav-link i {
            margin-right: 7px;
        }

        .nav-link:hover {
            color: var(--secondary);
            transform: translateX(3px);
        }

        /* Paginación mejorada */
        .pagination {
            margin-top: 25px;
            display: flex;
            list-style: none;
            justify-content: center;
            flex-wrap: wrap;
        }

        .pagination li {
            margin: 5px;
        }

        .pagination a, 
        .pagination span {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: white;
            color: var(--primary);
            text-decoration: none;
            transition: all 0.3s ease;
            border: 2px solid var(--gray-light);
            font-weight: 500;
        }

        .pagination a:hover {
            background-color: var(--primary-light);
            color: white;
            border-color: var(--primary-light);
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0, 55, 179, 0.15);
        }

        .pagination .active span {
            background-color: var(--primary);
            color: white;
            border-color: var(--primary);
        }

        /* Botón flotante para móviles */
        .floating-btn {
            position: fixed;
            bottom: 25px;
            right: 25px;
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: linear-gradient(145deg, var(--success), #00b368);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 5px 20px rgba(0, 214, 127, 0.3);
            cursor: pointer;
            z-index: 999;
            transition: all 0.3s ease;
            animation: pulse 2s infinite;
            display: none;
        }

        @keyframes pulse {
            0% {
                box-shadow: 0 0 0 0 rgba(0, 214, 127, 0.6);
            }
            70% {
                box-shadow: 0 0 0 15px rgba(0, 214, 127, 0);
            }
            100% {
                box-shadow: 0 0 0 0 rgba(0, 214, 127, 0);
            }
        }

        .floating-btn i {
            font-size: 24px;
        }

        .floating-btn:hover {
            transform: scale(1.1);
        }

        /* Media queries para responsividad */
        @media screen and (max-width: 991px) {
            .sidebar {
                width: 70px;
                overflow-x: hidden;
            }

            .sidebar .sidebar-logo span,
            .sidebar .user-info,
            .sidebar .menu-label,
            .sidebar .menu-item span {
                display: none;
            }

            .sidebar .user-avatar {
                width: 40px;
                height: 40px;
            }

            .sidebar .menu-item {
                display: flex;
                justify-content: center;
                padding: 15px 0;
            }

            .sidebar .menu-item i {
                margin-right: 0;
                font-size: 18px;
            }

            .main-content {
                margin-left: 70px;
            }
            
            .info-box {
                flex-direction: column;
            }
            
            .info-item {
                width: 100%;
                margin: 5px 0;
            }
            
            .content-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 15px;
            }
        }

        @media screen and (max-width: 768px) {
            .main-content {
                padding: 15px;
            }
            
            .content-header {
                padding: 20px;
            }
            
            table {
                display: block;
                overflow-x: auto;
                white-space: nowrap;
            }
            
            .floating-btn {
                display: flex;
            }
            
            .desktop-btn {
                display: none;
            }
        }

        @media screen and (max-width: 576px) {
            .main-content {
                padding: 10px;
            }
            
            .content-header {
                padding: 15px;
            }
            
            .page-title {
                font-size: 22px;
            }
            
            th, td {
                padding: 12px 15px;
            }
        }
    </style>
</head>
<body>
    <!-- Animación de carga inicial con silueta de carro avanzando -->
    <div class="page-loader">
        <div class="loader-title">Car Wash Premium <span style="color: var(--accent);">Panel Administrativo</span></div>
        <div class="car-animation">
            <div class="moving-car">
                <div class="car-silhouette"></div>
            </div>
            <div class="road"></div>
        </div>
        <div class="loader-subtitle">Cargando Detalle de Billetera...</div>
        <div class="progress-container">
            <div class="progress-bar"></div>
        </div>
    </div>

    <div class="dashboard-container">
        <!-- Barra lateral - Mantener exactamente igual que en el primer documento -->
        <aside class="sidebar" id="sidebar">
            <div class="sidebar-header">
                <div class="sidebar-logo">
                    <i class="fas fa-car-side"></i>
                    <span>Car<span>Wash</span></span>
                </div>
                <button class="toggle-sidebar" id="toggleSidebar">
                    <i class="fas fa-chevron-left"></i>
                </button>
            </div>
            
            <div class="sidebar-user">
                <div class="user-avatar">
                    <i class="fas fa-user"></i>
                </div>
                <div class="user-info">
                    <div class="user-name">{{ session('usuario')->nombre }}</div>
                    <div class="user-role">Administrador</div>
                </div>
            </div>
            
            <div class="sidebar-menu">
                <div class="menu-label">Principal</div>
                <a href="{{ route('admin.dashboard') }}" class="menu-item">
                    <i class="fas fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                    <div class="menu-tooltip">Dashboard</div>
                </a>
                <a href="{{ route('admin.turnos') }}" class="menu-item">
                    <i class="fas fa-calendar-alt"></i>
                    <span>Gestión de Turnos</span>
                    <div class="menu-tooltip">Gestión de Turnos</div>
                </a>
                
                <div class="menu-label">Gestión de Servicio</div>
                <a href="{{ route('admin.empleados.index') }}" class="menu-item">
                    <i class="fas fa-users"></i>
                    <span>Empleados</span>
                    <div class="menu-tooltip">Empleados</div>
                </a>
                <a href="{{ route('admin.billetera.index') }}" class="menu-item active">
                    <i class="fas fa-wallet"></i>
                    <span>Comisiones</span>
                    <div class="menu-tooltip">Comisiones</div>
                </a>
                <a href="{{ route('admin.lavadas.index') }}" class="menu-item">
                    <i class="fas fa-car-wash"></i>
                    <span>Lavados</span>
                    <div class="menu-tooltip">Lavados</div>
                </a>
                <a href="{{ route('admin.servicios.index') }}" class="menu-item">
                    <i class="fas fa-concierge-bell"></i>
                    <span>Servicios</span>
                    <div class="menu-tooltip">Servicios</div>
                </a>
                <a href="{{ route('admin.inventario.index') }}" class="menu-item">
                    <i class="fas fa-boxes"></i>
                    <span>Inventario</span>
                    <div class="menu-tooltip">Inventario</div>
                </a>
                
                <div class="menu-label">Reportes y Análisis</div>
                <a href="{{ route('admin.reportes.dashboard') }}" class="menu-item">
                    <i class="fas fa-chart-line"></i>
                    <span>Reportes</span>
                    <div class="menu-tooltip">Reportes</div>
                </a>
            </div>
        </aside>

        <!-- Contenido principal -->
        <main class="main-content">
            <!-- Header del contenido -->
            <div class="content-header">
                <div>
                    <h1 class="page-title">Billetera de {{ $empleado->usuario->nombre ?? 'Empleado #' . $empleado->id_empleado }}</h1>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="fas fa-home"></i> Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.billetera.index') }}">Billeteras</a></li>
                        <li class="breadcrumb-item">{{ $empleado->usuario->nombre ?? 'Empleado #' . $empleado->id_empleado }}</li>
                    </ul>
                </div>
                <div>
                    <a href="{{ route('admin.billetera.create-pago', $empleado->id_empleado) }}" class="btn btn-success desktop-btn">
                        <i class="fas fa-hand-holding-usd"></i> Registrar Pago
                    </a>
                </div>
            </div>
            
            @if (session('success'))
                <div class="alert alert-success">
                    <i class="fas fa-check-circle" style="margin-right: 10px; font-size: 20px;"></i>
                    {{ session('success') }}
                </div>
            @endif
            
            <div class="nav-links">
                <a href="{{ route('admin.billetera.index') }}" class="nav-link">
                    <i class="fas fa-arrow-left"></i> Volver a Billeteras
                </a>
            </div>
            
            <div class="info-box">
                <div class="info-item">
                    <div class="info-title">Comisión</div>
                    <div class="info-value info-blue">{{ $empleado->comision ?? 10 }}%</div>
                </div>
                <div class="info-item">
                    <div class="info-title">Total comisiones</div>
                    <div class="info-value info-green">${{ number_format($comisiones, 0, ',', '.') }}</div>
                </div>
                <div class="info-item">
                    <div class="info-title">Total pagos</div>
                    <div class="info-value info-red">${{ number_format($pagos, 0, ',', '.') }}</div>
                </div>
                <div class="info-item">
                    <div class="info-title">Saldo pendiente</div>
                    <div class="info-value info-green">${{ number_format($saldo, 0, ',', '.') }}</div>
                </div>
            </div>
            
            @if($transacciones->count() > 0)
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th><i class="fas fa-calendar-day" style="margin-right: 8px;"></i>Fecha</th>
                                <th><i class="fas fa-file-invoice" style="margin-right: 8px;"></i>Concepto</th>
                                <th><i class="fas fa-car" style="margin-right: 8px;"></i>Vehículo</th>
                                <th><i class="fas fa-tag" style="margin-right: 8px;"></i>Tipo</th>
                                <th><i class="fas fa-dollar-sign" style="margin-right: 8px;"></i>Monto</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($transacciones as $transaccion)
                                <tr>
                                    <td>{{ date('d/m/Y', strtotime($transaccion->fecha)) }}</td>
                                    <td>
                                        @if($transaccion->tipo == 'comision')
                                            Comisión por servicio
                                            @if($transaccion->lavada)
                                                <span style="color: var(--gray); font-size: 0.9em;">#{{ $transaccion->lavada->id_lavada }}</span>
                                            @endif
                                        @else
                                            {{ $transaccion->concepto ?? 'Pago de comisiones' }}
                                        @endif
                                    </td>
                                    <td>
                                        @if($transaccion->lavada && $transaccion->lavada->vehiculo)
                                            <span class="badge" style="background-color: rgba(0, 122, 255, 0.1); color: var(--primary);">
                                                <i class="fas fa-car"></i> {{ $transaccion->lavada->vehiculo->placa }}
                                            </span>
                                        @else
                                            <span>--</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($transaccion->tipo == 'comision')
                                            <span class="badge badge-success">
                                                <i class="fas fa-plus-circle"></i> Comisión
                                            </span>
                                        @else
                                            <span class="badge badge-danger">
                                                <i class="fas fa-minus-circle"></i> Pago
                                            </span>
                                        @endif
                                    </td>
                                    <td class="amount {{ $transaccion->tipo == 'comision' ? 'amount-positive' : 'amount-negative' }}">
                                        {{ $transaccion->tipo == 'comision' ? '+' : '-' }}${{ number_format($transaccion->monto_comision, 0, ',', '.') }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <div style="margin-top: 20px;">
                    {{ $transacciones->links() }}
                </div>
            @else
                <div style="text-align: center; padding: 40px; background-color: white; border-radius: 16px; box-shadow: 0 10px 25px rgba(0, 55, 179, 0.1);">
                    <i class="fas fa-info-circle" style="font-size: 50px; color: var(--gray-light); margin-bottom: 20px; display: block;"></i>
                    <h3 style="font-size: 20px; color: var(--dark); margin-bottom: 10px;">No hay transacciones registradas</h3>
                    <p style="color: var(--gray);">Este empleado no tiene transacciones registradas en el sistema.</p>
                </div>
            @endif
            
            <!-- Botón flotante para dispositivos móviles -->
            <a href="{{ route('admin.billetera.create-pago', $empleado->id_empleado) }}" class="floating-btn">
                <i class="fas fa-hand-holding-usd"></i>
            </a>
        </main>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Animación de carga inicial
            const car = document.querySelector('.moving-car');
            const progressBar = document.querySelector('.progress-bar');
            const loader = document.querySelector('.page-loader');
            
            let progress = 0;
            const interval = setInterval(() => {
                progress += 1;
                progressBar.style.width = progress + '%';
                car.style.transform = `translateX(${progress * 2}px)`;
                
                if (progress >= 100) {
                    clearInterval(interval);
                    setTimeout(() => {
                        loader.classList.add('hidden');
                    }, 500);
                }
            }, 20);
            
            // Toggle sidebar
            const sidebar = document.getElementById('sidebar');
            const toggleBtn = document.getElementById('toggleSidebar');
            const mainContent = document.querySelector('.main-content');
            
            toggleBtn.addEventListener('click', function() {
                sidebar.classList.toggle('collapsed');
                mainContent.style.marginLeft = sidebar.classList.contains('collapsed') ? '70px' : '260px';
            });
            
            // Verificar tamaño de pantalla
            function checkScreenSize() {
                if (window.innerWidth <= 991) {
                    sidebar.classList.add('collapsed');
                    mainContent.style.marginLeft = '70px';
                } else {
                    sidebar.classList.remove('collapsed');
                    mainContent.style.marginLeft = '260px';
                }
            }
            
            // Ejecutar al cargar y al redimensionar
            checkScreenSize();
            window.addEventListener('resize', checkScreenSize);
        });
    </script>
</body>
</html>