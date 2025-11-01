<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIGRAM - Sistema de Gestión de Atenciones Médicas</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Roboto', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .container {
            max-width: 1200px;
            width: 100%;
        }

        .header-nav {
            display: flex;
            justify-content: flex-end;
            gap: 15px;
            margin-bottom: 30px;
        }

        .btn-nav {
            padding: 10px 25px;
            background: rgba(255, 255, 255, 0.2);
            color: white;
            text-decoration: none;
            border-radius: 25px;
            font-weight: 500;
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        .btn-nav:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
        }

        .welcome-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            overflow: hidden;
        }

        .hero-section {
            background: linear-gradient(135deg, #2ecc71 0%, #27ae60 100%);
            padding: 60px 40px;
            text-align: center;
            color: white;
        }

        .logo-container {
            margin-bottom: 30px;
        }

        .logo-icon {
            font-size: 80px;
            margin-bottom: 20px;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0%, 100% {
                transform: scale(1);
            }
            50% {
                transform: scale(1.05);
            }
        }

        .hero-section h1 {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 15px;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);
        }

        .hero-section .subtitle {
            font-size: 1.2rem;
            font-weight: 300;
            margin-bottom: 10px;
        }

        .institution-name {
            font-size: 1.1rem;
            font-weight: 400;
            opacity: 0.9;
            margin-top: 10px;
        }

        .content-section {
            padding: 50px 40px;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 30px;
            margin-top: 40px;
        }

        .feature-card {
            text-align: center;
            padding: 30px;
            background: #f8f9fa;
            border-radius: 15px;
            transition: all 0.3s ease;
            border: 2px solid transparent;
        }

        .feature-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            border-color: #2ecc71;
        }

        .feature-icon {
            font-size: 3rem;
            color: #2ecc71;
            margin-bottom: 20px;
        }

        .feature-title {
            font-size: 1.3rem;
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 10px;
        }

        .feature-description {
            color: #7f8c8d;
            line-height: 1.6;
            font-size: 0.95rem;
        }

        .cta-section {
            text-align: center;
            margin-top: 50px;
            padding: 40px;
            background: linear-gradient(135deg, #3498db 0%, #2980b9 100%);
            border-radius: 15px;
            color: white;
        }

        .cta-section h2 {
            font-size: 2rem;
            margin-bottom: 20px;
        }

        .cta-buttons {
            display: flex;
            gap: 20px;
            justify-content: center;
            flex-wrap: wrap;
            margin-top: 30px;
        }

        .btn-cta {
            padding: 15px 40px;
            background: white;
            color: #3498db;
            text-decoration: none;
            border-radius: 30px;
            font-weight: 600;
            font-size: 1.1rem;
            transition: all 0.3s ease;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }

        .btn-cta:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
        }

        .btn-cta.secondary {
            background: transparent;
            color: white;
            border: 2px solid white;
        }

        .btn-cta.secondary:hover {
            background: white;
            color: #3498db;
        }

        .footer {
            text-align: center;
            padding: 30px;
            background: #34495e;
            color: white;
        }

        .footer p {
            margin: 5px 0;
        }

        @media (max-width: 768px) {
            .hero-section h1 {
                font-size: 1.8rem;
            }

            .hero-section .subtitle {
                font-size: 1rem;
            }

            .logo-icon {
                font-size: 60px;
            }

            .content-section {
                padding: 30px 20px;
            }

            .features-grid {
                grid-template-columns: 1fr;
            }

            .cta-section h2 {
                font-size: 1.5rem;
            }

            .cta-buttons {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Navigation -->
        @if (Route::has('login'))
            <div class="header-nav">
                @auth
                    <a href="{{ url('/dashboard') }}" class="btn-nav">
                        <i class="fas fa-home"></i> Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}" class="btn-nav">
                        <i class="fas fa-sign-in-alt"></i> Iniciar Sesión
                    </a>

                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="btn-nav">
                            <i class="fas fa-user-plus"></i> Registrarse
                        </a>
                    @endif
                @endauth
            </div>
        @endif

        <!-- Main Welcome Card -->
        <div class="welcome-card">
            <!-- Hero Section -->
            <div class="hero-section">
                <div class="logo-container">
                    <div class="logo-icon">
                        <i class="fas fa-heartbeat"></i>
                    </div>
                    <h1>SIGRAM</h1>
                    <p class="subtitle">Sistema de Gestión y Registro de Atenciones Médicas</p>
                    <p class="institution-name">
                        <i class="fas fa-hospital"></i> Tópico de Enfermería - La Salle Urubamba
                    </p>
                </div>
            </div>

            <!-- Content Section -->
            <div class="content-section">
                <div style="text-align: center; margin-bottom: 40px;">
                    <h2 style="color: #2c3e50; font-size: 2rem; margin-bottom: 15px;">
                        Gestión Integral de Salud Estudiantil
                    </h2>
                    <p style="color: #7f8c8d; font-size: 1.1rem; max-width: 800px; margin: 0 auto;">
                        Plataforma completa para el registro, seguimiento y análisis de atenciones médicas
                        en nuestro tópico institucional. Control eficiente de pacientes, medicamentos y reportes estadísticos.
                    </p>
                </div>

                <!-- Features Grid -->
                <div class="features-grid">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-user-injured"></i>
                        </div>
                        <h3 class="feature-title">Gestión de Pacientes</h3>
                        <p class="feature-description">
                            Registro completo de estudiantes y personal con historial médico detallado,
                            búsqueda rápida por DNI y seguimiento de atenciones.
                        </p>
                    </div>

                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-notes-medical"></i>
                        </div>
                        <h3 class="feature-title">Atenciones Médicas</h3>
                        <p class="feature-description">
                            Registro de consultas con motivos predefinidos, medicamentos administrados,
                            tiempos de atención y observaciones detalladas.
                        </p>
                    </div>

                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-pills"></i>
                        </div>
                        <h3 class="feature-title">Control de Medicamentos</h3>
                        <p class="feature-description">
                            Inventario completo de medicamentos, alertas de stock bajo,
                            control de vencimientos y registro de consumo.
                        </p>
                    </div>

                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-file-medical-alt"></i>
                        </div>
                        <h3 class="feature-title">Historial Clínico</h3>
                        <p class="feature-description">
                            Acceso completo al historial de cada paciente con generación de
                            reportes en PDF para seguimiento y referencia.
                        </p>
                    </div>

                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <h3 class="feature-title">Reportes Estadísticos</h3>
                        <p class="feature-description">
                            Análisis de atenciones por área, enfermedades más comunes,
                            con exportación a PDF para toma de decisiones.
                        </p>
                    </div>

                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-mobile-alt"></i>
                        </div>
                        <h3 class="feature-title">Diseño Responsive</h3>
                        <p class="feature-description">
                            Acceso desde cualquier dispositivo: computadora, tablet o móvil.
                            Interfaz adaptable y fácil de usar en todas las plataformas.
                        </p>
                    </div>
                </div>

                <!-- CTA Section -->
                <div class="cta-section">
                    <h2>¿Listo para comenzar?</h2>
                    <p style="font-size: 1.1rem; margin-bottom: 10px;">
                        Accede al sistema y gestiona las atenciones médicas de forma eficiente
                    </p>
                    <div class="cta-buttons">
                        @guest
                            <a href="{{ route('login') }}" class="btn-cta">
                                <i class="fas fa-sign-in-alt"></i> Iniciar Sesión
                            </a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="btn-cta secondary">
                                    <i class="fas fa-user-plus"></i> Crear Cuenta
                                </a>
                            @endif
                        @else
                            <a href="{{ url('/dashboard') }}" class="btn-cta">
                                <i class="fas fa-tachometer-alt"></i> Ir al Dashboard
                            </a>
                        @endguest
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <div class="footer">
                <p><strong>SIGRAM</strong> - Sistema de Gestión y Registro de Atenciones Médicas</p>
                <p style="margin-top: 10px; font-size: 0.9rem;">
                    <i class="fas fa-graduation-cap"></i> La Salle Urubamba
                </p>
                <p style="font-size: 0.85rem; opacity: 0.8; margin-top: 5px;">
                    © {{ date('Y') }} Todos los derechos reservados
                </p>
            </div>
        </div>
    </div>
</body>
</html>
