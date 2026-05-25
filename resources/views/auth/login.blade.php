<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - Práctica 20</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f6f9; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
        .login-container { background: #fff; padding: 30px; border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); width: 100%; max-width: 400px; }
        .student-info { background: #e3f2fd; color: #0d47a1; padding: 10px; border-radius: 5px; text-align: center; font-weight: bold; margin-bottom: 20px; font-size: 0.9rem; }
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; margin-bottom: 5px; font-weight: bold; }
        .form-group input { width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; }
        .btn-submit { width: 100%; padding: 10px; background-color: #1a73e8; color: white; border: none; border-radius: 4px; font-size: 1rem; cursor: pointer; font-weight: bold; }
        .btn-submit:hover { background-color: #1557b0; }
        .error-message { color: #d32f2f; background: #ffebee; padding: 10px; border-radius: 4px; margin-bottom: 15px; font-size: 0.85rem; }
    </style>
</head>
<body>

<div class="login-container">

    <div class="student-info">
        Estudiante: Yuorvic Arduz Liendro
    </div>

    <h2 style="text-align: center; margin-bottom: 20px; color: #333;">ING-411 Laboratorio 20</h2>

    @if ($errors->any())
        <div class="error-message">
            @foreach ($errors->all() as $error)
                {{ $error }}
            @endforeach
        </div>
    @endif

    <form action="{{ route('login') }}" method="POST">
        @csrf <div class="form-group">
            <label for="username">Usuario:</label>
            <input type="text" id="username" name="username" value="{{ old('username') }}" placeholder="Ej. omarqm" required autofocus>
        </div>

        <div class="form-group">
            <label for="password">Contraseña:</label>
            <input type="password" id="password" name="password" placeholder="********" required>
        </div>

        <button type="submit" class="btn-submit">Ingresar</button>
    </form>

</div>

</body>
</html>