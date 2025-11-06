<?php

namespace App\Http\Controllers;

use App\Models\Equipo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\ValidationException;

class controllerEquipos extends Controller
{

    //Función para crear Equipos
    public function crearEquipo(Request $request)
    {
        $equipo = Equipo::create([
            'equ_nombre' => $request->equ_nombre,
            'equ_entrenador' => $request->equ_entrenador,
        ]);

        return response()->json([
            'equipo' => $equipo
        ]);
    }

    //Función para ver los equipos de un entrenador.
    public function verEquipos(Request $request)
    {
        
        $equipos = Equipo::where('equ_entrenador', $request->equ_entrenador)->get();

        return response()->json([
            'equipos' => $equipos
        ]);
    }



    //Función para eliminar el equipo con la ID pasada pr parámetros.
    public function eliminarEquipo(Request $request)
    {
        $equipo = Equipo::find($request->equ_id);

        if ($equipo) {
            $equipo->delete();
            return response()->json([
                'message' => 'Equipo eliminado correctamente'
            ]);
        } else {
            return response()->json([
                'message' => 'Equipo no encontrado'
            ], 404);
        }
    }
}
