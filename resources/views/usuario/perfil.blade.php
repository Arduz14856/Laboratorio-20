<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Perfil - Sistema Larav20</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f6f9; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
        .profile-container { background: white; padding: 30px; border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); width: 100%; max-width: 500px; }
        .profile-header { text-align: center; border-bottom: 2px solid #eee; padding-bottom: 15px; margin-bottom: 20px; }
        .profile-header h2 { margin: 0; color: #333; }
        .profile-header .role-badge { display: inline-block; background-color: #28a745; color: white; padding: 4px 10px; border-radius: 20px; font-size: 0.85rem; font-weight: bold; margin-top: 5px; }
        .info-group { display: flex; justify-content: space-between; padding: 10px 0; border-bottom: 1px solid #f1f1f1; }
        .info-label { font-weight: bold; color: #555; }
        .info-value { color: #333; }
        .btn-logout { width: 100%; padding: 12px; background-color: #dc3545; color: white; border: none; border-radius: 4px; font-size: 1rem; cursor: pointer; font-weight: bold; margin-top: 25px; transition: background 0.2s; }
        .btn-logout:hover { background-color: #c82333; }
    </style>
</head>
<body>

<div class="profile-container">
    
    <div class="profile-header">
        <h2>Vista 2: Perfil del Usuario</h2>
        <span class="role-badge">Rol: {{ ucfirst(Auth::user()->role) }}</span>
    </div>

    <div class="info-group">
        <span class="info-label">Nombre Completo:</span>
        <span class="info-value">{{ Auth::user()->nombre }} {{ Auth::user()->apellido_paterno }} {{ Auth::user()->apellido_materno }}</span>
    </div>

    <div class="info-group">
        <span class="info-label">C.I.:</span>
        <span class="info-value">{{ Auth::user()->ci }}</span>
    </div>

    <div class="info-group">
        <span class="info-label">Nombre de Usuario:</span>
        <span class="info-value" style="font-family: monospace; font-size: 1rem;">{{ Auth::user()->username }}</span>
    </div>

    <div class="info-group">
        <span class="info-label">Miembro desde:</span>
        <span class="info-value">{{ Auth::user()->created_at->format('d/m/Y H:i') }}</span>
    </div>

    <form action="{{ route('logout') }}" method="POST">
        @csrf <button type="submit" class="btn-logout">Cerrar Sesión Activa</button>
    </form>

</div>

</body>
</html>