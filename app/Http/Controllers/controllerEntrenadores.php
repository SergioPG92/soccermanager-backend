<?php

namespace App\Http\Controllers;

use App\Models\Entrenador;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\ValidationException;

class controllerEntrenadores extends Controller
{

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



        //Se guarda el entrenador.
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

    

    public function login(Request $request)
    {
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


        $token = $entrenador->createToken('auth_token')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => $entrenador
        ]);
    }

    /*
        Peticion
            Header-->  Authorization :  Bearer <Token>
        }
    */
    public function logout(Request $request)
    {
        // Eliminar el token actual
        $request->user()->currentAccessToken()->delete();

        // Respuesta de éxito
        return response()->json(['message' => 'Logged out successfully']);
    }


    /*
        Peticion

            Header-->  Authorization :  Bearer <Token>
        }
    */
    public function perfil(Request $request)
    {
        // Retornar los datos del usuario autenticado
        return response()->json($request->user());
    }



    public function updateEnt(Request $request)
    {

        // Validación de los datos
        $datosUpdateEnt = $request;

        // Buscar al usuario por su correo electrónico
        $user = Entrenador::where('ent_email', $datosUpdateEnt['ent_email'])->first();

        if (!$user) {
            // Si no se encuentra el usuario, devolver un error
            return response()->json([
                'message' => 'Usuario no encontrado con ese correo electrónico.'
            ], 404);
        }

        // Actualizar los datos
        $user->ent_nombre = $datosUpdateEnt['ent_nombre'];
        $user->ent_apellido = $datosUpdateEnt['ent_apellido'];

        // Si se proporciona una nueva contraseña, actualizarla
        if (isset($datosUpdateEnt['ent_password'])) {
            $user->ent_password = bcrypt($datosUpdateEnt['ent_password']);  // Encriptar la contraseña antes de guardarla
        }

        // Guardar los cambios guardando el usuario.
        $user->save();

        // Retornar los datos actualizados
        return response()->json([
            'message' => 'Perfil actualizado con éxito.',
            'user' => [
                'ent_email' => $user->ent_email,
                'ent_nombre' => $user->ent_nombre,
                'ent_apellido' => $user->ent_apellido,
                'ent_password' => $user->ent_password,
                "ent_id"=>$user->ent_id
            ]
        ]);
    }
}
