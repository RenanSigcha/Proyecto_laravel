<?php
 // app/Http/Controllers/UserController.php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    // Registro de un nuevo usuario
    public function register(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'correo_electronico' => 'required|email|unique:users',
            'telefono' => 'nullable|string',
            'direccion_envio' => 'nullable|string',
            'password' => 'required|string|confirmed|min:8',
        ]);

        $user = User::create([
            'nombre' => $request->nombre,
            'apellido' => $request->apellido,
            'correo_electronico' => $request->correo_electronico,
            'telefono' => $request->telefono,
            'direccion_envio' => $request->direccion_envio,
            'password' => Hash::make($request->password),
            'role' => 'cliente',  // Role por defecto
        ]);

        return response()->json(['message' => 'Usuario registrado correctamente'], 201);
    }

    // Login de usuario
    public function login(Request $request)
    {
        $request->validate([
            'correo_electronico' => 'required|email',
            'password' => 'required|string',
        ]);

        if (Auth::attempt(['correo_electronico' => $request->correo_electronico, 'password' => $request->password])) {
            $user = Auth::user();
            $token = $user->createToken('token_name')->plainTextToken;

            return response()->json(['message' => 'Login exitoso', 'token' => $token]);
        }

        throw ValidationException::withMessages([
            'correo_electronico' => ['Las credenciales proporcionadas son incorrectas.'],
        ]);
    }

    // Obtener los datos del usuario autenticado
    public function me()
    {
        return response()->json(Auth::user());
    }
}
