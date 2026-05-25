<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        $usuarios = User::paginate(10);

        return view('admin.dashboard', compact('usuarios'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido_paterno' => 'required|string|max:255',
            'apellido_materno' => 'nullable|string|max:255',
            'ci' => 'required|string|unique:users,ci',
            'username' => 'required|string|unique:users,username|max:255',
            'password' => 'required|string|min:6',
            'role' => 'required|in:admin,usuario',
        ]);

        User::create([
            'nombre' => $request->nombre,
            'apellido_paterno' => $request->apellido_paterno,
            'apellido_materno' => $request->apellido_materno,
            'ci' => $request->ci,
            'username' => $request->username,
            'password' => $request->password,
            'role' => $request->role,
        ]);

        return redirect()
            ->route('admin.dashboard')
            ->with('success', 'Usuario registrado exitosamente.');
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido_paterno' => 'required|string|max:255',
            'apellido_materno' => 'nullable|string|max:255',
            'ci' => 'required|string|unique:users,ci,' . $user->id,
            'username' => 'required|string|unique:users,username,' . $user->id,
            'role' => 'required|in:admin,usuario',
            'password' => 'nullable|string|min:6',
        ]);

        $user->nombre = $request->nombre;
        $user->apellido_paterno = $request->apellido_paterno;
        $user->apellido_materno = $request->apellido_materno;
        $user->ci = $request->ci;
        $user->username = $request->username;
        $user->role = $request->role;

        if ($request->filled('password')) {
            $user->password = $request->password;
        }

        $user->save();

        return redirect()
            ->route('admin.dashboard')
            ->with('success', 'Usuario actualizado correctamente.');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);

        if (auth()->user()->id === $user->id) {

            return redirect()
                ->route('admin.dashboard')
                ->with('error', 'No puedes eliminar tu propia cuenta en sesión.');
        }

        $user->delete();

        return redirect()
            ->route('admin.dashboard')
            ->with('success', 'Usuario eliminado del sistema.');
    }
}