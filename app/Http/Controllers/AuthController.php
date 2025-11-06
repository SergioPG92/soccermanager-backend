<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Entrenador;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{


    //Función para registrar un nuevo entrenador
    public function register(Request $request)
    {
        // Validación de los datos recibidos
        $request->validate([
            'ent_nombre' => 'required|string|max:255',
            'ent_apellido' => 'required|string|max:255',
            'ent_email' => 'required|email|unique:entrenadores,ent_email',
            'ent_password' => 'required|string|min:6|confirmed',
        ]);

        // Crear el nuevo entrenador
        $entrenador = Entrenador::create([
            'ent_nombre' => $request->ent_nombre,
            'ent_apellido' => $request->ent_apellido,
            'ent_email' => $request->ent_email,
            'ent_password' => Hash::make($request->ent_password),
            'rol' => $request->rol ?? 'entrenador',
        ]);



        // ASeguramos de que el modelo esté guardado para asignar el tokenable_id
        $entrenador->save();

        // Crear el token para el entrenador
        $token = $entrenador->createToken('auth_token')->plainTextToken;

        // Responder con el token y los datos del entrenador
        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => $entrenador
        ]);
    }

    //Función para iniciar sesión un entrenador
    public function login(Request $request)
    {
        // Validación de los datos de login
        $request->validate([
            'ent_email' => 'required|email',
            'ent_password' => 'required'
        ]);

        // Buscar al entrenador por su email
        $entrenador = Entrenador::where('ent_email', $request->ent_email)->first();

        // Verificar que el entrenador existe y que la contraseña es correcta
        if (!$entrenador || !Hash::check($request->ent_password, $entrenador->ent_password)) {
            return response()->json([
                'message' => 'Credenciales incorrectas',
            ], 401);
        }

        // Crear el token correctamente
        $token = $entrenador->createToken('auth_token')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => $entrenador
        ]);
    }


    //Función para obtener el perfil del entrenador logeado
    public function perfil(Request $request)
    {
        // Devolver los datos del entrenador
        return response()->json($request->user());
    }

    //Función para actualizar el perfil del entrenador
    public function updateEnt(Request $request)
    {

        $datosUpdateEnt = $request;

        // Buscar al usuario por su correo electrónico
        $user = Entrenador::where('ent_email', $datosUpdateEnt['ent_email'])->first();

        if (!$user) {
            // Si no se encuentra el usuario, devuelve un error.
            return response()->json([
                'message' => 'Usuario no encontrado con ese correo electrónico.'
            ], 404);
        }

        // Actualizar los datos
        $user->ent_nombre = $datosUpdateEnt['ent_nombre'];
        $user->ent_apellido = $datosUpdateEnt['ent_apellido'];

        // Si existe una nueva contraseña, actualizarla
        if (isset($datosUpdateEnt['ent_password'])) {
            $user->ent_password = bcrypt($datosUpdateEnt['ent_password']);  // Encriptar la contraseña antes de guardarla
        }

        // Guardar los cambios
        $user->save();

        // Devolver los datos actualizados
        return response()->json([
            'message' => 'Perfil actualizado con éxito.',
            'user' => [
                'ent_email' => $user->ent_email,
                'ent_nombre' => $user->ent_nombre,
                'ent_apellido' => $user->ent_apellido,
                'ent_password' => $user->ent_password,
            ]
        ]);
    }
}
