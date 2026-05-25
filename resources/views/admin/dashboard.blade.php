<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Administrador - ABM Usuarios</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f6f9; margin: 0; padding: 20px; }
        .container { max-width: 1200px; margin: 0 auto; background: white; padding: 20px; border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); }
        .header { display: flex; justify-content: space-between; align-items: center; border-bottom: 2px solid #eee; padding-bottom: 15px; margin-bottom: 20px; }
        .btn-logout { background-color: #dc3545; color: white; border: none; padding: 10px 15px; border-radius: 4px; cursor: pointer; font-weight: bold; }
        .btn-logout:hover { background-color: #bd2130; }
        .alert { padding: 12px; border-radius: 4px; margin-bottom: 20px; font-weight: bold; }
        .alert-success { background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .alert-danger { background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
        .grid { display: grid; grid-template-columns: 1fr 2fr; gap: 20px; }
        @media(max-width: 900px) { .grid { grid-template-columns: 1fr; } }
        .card { background: #fafafa; padding: 15px; border: 1px solid #ddd; border-radius: 6px; }
        .form-group { margin-bottom: 12px; }
        .form-group label { display: block; margin-bottom: 5px; font-weight: bold; font-size: 0.9rem; }
        .form-group input, .form-group select { width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; }
        .btn-submit { background-color: #28a745; color: white; border: none; padding: 10px; width: 100%; border-radius: 4px; font-weight: bold; cursor: pointer; }
        .btn-submit:hover { background-color: #218838; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; background: white; }
        table th, table td { padding: 10px; text-align: left; border: 1px solid #eee; font-size: 0.9rem; }
        table th { background-color: #007bff; color: white; }
        .btn-edit { background-color: #ffc107; color: #212529; border: none; padding: 5px 10px; border-radius: 4px; cursor: pointer; font-size: 0.8rem; font-weight: bold; }
        .btn-delete { background-color: #dc3545; color: white; border: none; padding: 5px 10px; border-radius: 4px; cursor: pointer; font-size: 0.8rem; font-weight: bold; }
    </style>
</head>
<body>

<div class="container">
    <div class="header">
        <h2>Vista 1: Rol Administrador (Gestión ABM)</h2>
        <div>
            <span style="margin-right: 15px; font-weight: bold; color: #555;">Bienvenido, {{ Auth::user()->nombre }}</span>
            <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                @csrf
                <button type="submit" class="btn-logout">Cerrar Sesión</button>
            </form>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif
    @if($errors->any())
        <div class="alert alert-danger">
            <ul style="margin: 0; padding-left: 20px;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="grid">
        <div class="card">
            <h3 id="form-title">Alta de Usuario</h3>
            <form id="abm-form" action="{{ route('admin.users.store') }}" method="POST">
                @csrf
                <input type="hidden" id="method-field" name="_method" value="POST">

                <div class="form-group">
                    <label for="nombre">Nombre:</label>
                    <input type="text" id="nombre" name="nombre" required>
                </div>
                <div class="form-group">
                    <label for="apellido_paterno">Apellido Paterno:</label>
                    <input type="text" id="apellido_paterno" name="apellido_paterno" required>
                </div>
                <div class="form-group">
                    <label for="apellido_materno">Apellido Materno:</label>
                    <input type="text" id="apellido_materno" name="apellido_materno">
                </div>
                <div class="form-group">
                    <label for="ci">C.I.:</label>
                    <input type="text" id="ci" name="ci" required>
                </div>
                <div class="form-group">
                    <label for="username">Nombre de Usuario (Username):</label>
                    <input type="text" id="username" name="username" required>
                </div>
                <div class="form-group">
                    <label for="password">Contraseña:</label>
                    <input type="password" id="password" name="password" placeholder="Mínimo 6 caracteres">
                </div>
                <div class="form-group">
                    <label for="role">Rol:</label>
                    <select id="role" name="role" required>
                        <option value="usuario">Usuario</option>
                        <option value="admin">Administrador</option>
                    </select>
                </div>
                <button type="submit" id="btn-submit-text" class="btn-submit">Guardar Usuario</button>
                <button type="button" id="btn-cancel" class="btn-logout" style="width:100%; margin-top:5px; background-color:#6c757d; display:none;" onclick="resetForm()">Cancelar Edición</button>
            </form>
        </div>

        <div class="card" style="overflow-x: auto;">
            <h3>Listado de Usuarios Registrados</h3>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre Completo</th>
                        <th>C.I.</th>
                        <th>Usuario</th>
                        <th>Rol</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($usuarios as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->nombre }} {{ $user->apellido_paterno }} {{ $user->apellido_materno }}</td>
                        <td>{{ $user->ci }}</td>
                        <td>{{ $user->username }}</td>
                        <td><span style="padding:3px 6px; background:#eee; border-radius:3px; font-weight:bold;">{{ $user->role }}</span></td>
                        <td>
                            <button class="btn-edit" onclick="editUser({{ json_encode($user) }})">Editar</button>
                            
                            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('¿Está seguro de eliminar este usuario?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-delete">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    function editUser(user) {
        document.getElementById('form-title').innerText = 'Modificar Usuario ID: ' + user.id;
        document.getElementById('abm-form').action = '/admin/usuarios/' + user.id;
        document.getElementById('method-field').value = 'PUT';
        
        document.getElementById('nombre').value = user.nombre;
        document.getElementById('apellido_paterno').value = user.apellido_paterno;
        document.getElementById('apellido_materno').value = user.apellido_materno ? user.apellido_materno : '';
        document.getElementById('ci').value = user.ci;
        document.getElementById('username').value = user.username;
        document.getElementById('role').value = user.role;
        
        document.getElementById('password').placeholder = 'Dejar en blanco para no cambiar';
        document.getElementById('password').required = false;
        
        document.getElementById('btn-submit-text').innerText = 'Actualizar Datos';
        document.getElementById('btn-submit-text').style.backgroundColor = '#ffc107';
        document.getElementById('btn-submit-text').style.color = '#212529';
        document.getElementById('btn-cancel').style.display = 'block';
    }

    function resetForm() {
        document.getElementById('form-title').innerText = 'Alta de Usuario';
        document.getElementById('abm-form').action = "{{ route('admin.users.store') }}";
        document.getElementById('method-field').value = 'POST';
        
        document.getElementById('abm-form').reset();
        document.getElementById('password').placeholder = 'Mínimo 6 caracteres';
        
        document.getElementById('btn-submit-text').innerText = 'Guardar Usuario';
        document.getElementById('btn-submit-text').style.backgroundColor = '#28a745';
        document.getElementById('btn-submit-text').style.color = 'white';
        document.getElementById('btn-cancel').style.display = 'none';
    }
</script>
</body>
</html>