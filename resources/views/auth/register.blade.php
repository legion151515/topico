<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrarse - SIGRAM</title>
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

        .register-container {
            max-width: 500px;
            width: 100%;
        }

        .register-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            overflow: hidden;
        }

        .register-header {
            background: linear-gradient(135deg, #3498db 0%, #2980b9 100%);
            padding: 40px 30px;
            text-align: center;
            color: white;
        }

        .register-icon {
            font-size: 60px;
            margin-bottom: 15px;
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

        .register-header h1 {
            font-size: 1.8rem;
            font-weight: 600;
            margin-bottom: 5px;
        }

        .register-header p {
            font-size: 0.95rem;
            opacity: 0.9;
        }

        .register-body {
            padding: 40px 30px;
        }

        .alert {
            padding: 12px 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 0.9rem;
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .alert-error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .form-group {
            margin-bottom: 22px;
        }

        .form-label {
            display: block;
            font-weight: 500;
            color: #2c3e50;
            margin-bottom: 8px;
            font-size: 0.95rem;
        }

        .form-label i {
            margin-right: 5px;
            color: #3498db;
        }

        .form-control {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #e0e0e0;
            border-radius: 10px;
            font-size: 1rem;
            transition: all 0.3s ease;
            font-family: 'Roboto', sans-serif;
        }

        .form-control:focus {
            outline: none;
            border-color: #3498db;
            box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.1);
        }

        .input-error {
            color: #e74c3c;
            font-size: 0.85rem;
            margin-top: 5px;
            display: block;
        }

        .form-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 15px;
            margin-top: 25px;
        }

        .login-link {
            color: #3498db;
            text-decoration: none;
            font-size: 0.9rem;
            transition: color 0.3s ease;
        }

        .login-link:hover {
            color: #2980b9;
            text-decoration: underline;
        }

        .btn-register {
            padding: 12px 35px;
            background: linear-gradient(135deg, #3498db 0%, #2980b9 100%);
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(52, 152, 219, 0.3);
        }

        .btn-register:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(52, 152, 219, 0.4);
        }

        .btn-register:active {
            transform: translateY(0);
        }

        .back-home {
            text-align: center;
            margin-top: 20px;
        }

        .back-home a {
            color: white;
            text-decoration: none;
            font-size: 0.9rem;
            padding: 10px 20px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 20px;
            display: inline-block;
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
        }

        .back-home a:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: translateY(-2px);
        }

        .info-text {
            text-align: center;
            color: #7f8c8d;
            font-size: 0.85rem;
            margin-bottom: 25px;
            padding: 15px;
            background: #f8f9fa;
            border-radius: 10px;
            border-left: 4px solid #3498db;
        }

        .info-text i {
            color: #3498db;
            margin-right: 5px;
        }

        @media (max-width: 480px) {
            .register-header {
                padding: 30px 20px;
            }

            .register-header h1 {
                font-size: 1.5rem;
            }

            .register-body {
                padding: 30px 20px;
            }

            .form-footer {
                flex-direction: column;
                align-items: stretch;
            }

            .btn-register {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="register-container">
        <div class="register-card">
            <div class="register-header">
                <div class="register-icon">
                    <i class="fas fa-user-plus"></i>
                </div>
                <h1>Crear Cuenta</h1>
                <p>SIGRAM - Tópico de Enfermería</p>
            </div>

            <div class="register-body">
                <div class="info-text">
                    <i class="fas fa-info-circle"></i>
                    Crea tu cuenta para acceder al sistema de gestión de atenciones médicas
                </div>

                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <!-- Name -->
                    <div class="form-group">
                        <label for="name" class="form-label">
                            <i class="fas fa-user"></i> Nombre Completo
                        </label>
                        <input
                            id="name"
                            class="form-control @error('name') is-invalid @enderror"
                            type="text"
                            name="name"
                            value="{{ old('name') }}"
                            required
                            autofocus
                            autocomplete="name"
                            placeholder="Ingrese su nombre completo"
                        />
                        @error('name')
                            <span class="input-error">
                                <i class="fas fa-exclamation-circle"></i> {{ $message }}
                            </span>
                        @enderror
                    </div>

                    <!-- Email Address -->
                    <div class="form-group">
                        <label for="email" class="form-label">
                            <i class="fas fa-envelope"></i> Correo Electrónico
                        </label>
                        <input
                            id="email"
                            class="form-control @error('email') is-invalid @enderror"
                            type="email"
                            name="email"
                            value="{{ old('email') }}"
                            required
                            autocomplete="username"
                            placeholder="ejemplo@lasalle.edu.pe"
                        />
                        @error('email')
                            <span class="input-error">
                                <i class="fas fa-exclamation-circle"></i> {{ $message }}
                            </span>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="form-group">
                        <label for="password" class="form-label">
                            <i class="fas fa-lock"></i> Contraseña
                        </label>
                        <input
                            id="password"
                            class="form-control @error('password') is-invalid @enderror"
                            type="password"
                            name="password"
                            required
                            autocomplete="new-password"
                            placeholder="Mínimo 8 caracteres"
                        />
                        @error('password')
                            <span class="input-error">
                                <i class="fas fa-exclamation-circle"></i> {{ $message }}
                            </span>
                        @enderror
                    </div>

                    <!-- Confirm Password -->
                    <div class="form-group">
                        <label for="password_confirmation" class="form-label">
                            <i class="fas fa-lock"></i> Confirmar Contraseña
                        </label>
                        <input
                            id="password_confirmation"
                            class="form-control @error('password_confirmation') is-invalid @enderror"
                            type="password"
                            name="password_confirmation"
                            required
                            autocomplete="new-password"
                            placeholder="Repita su contraseña"
                        />
                        @error('password_confirmation')
                            <span class="input-error">
                                <i class="fas fa-exclamation-circle"></i> {{ $message }}
                            </span>
                        @enderror
                    </div>

                    <div class="form-footer">
                        <a class="login-link" href="{{ route('login') }}">
                            <i class="fas fa-sign-in-alt"></i> ¿Ya tienes una cuenta?
                        </a>

                        <button type="submit" class="btn-register">
                            <i class="fas fa-user-check"></i> Registrarse
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="back-home">
            <a href="{{ url('/') }}">
                <i class="fas fa-home"></i> Volver al Inicio
            </a>
        </div>
    </div>
</body>
</html>
