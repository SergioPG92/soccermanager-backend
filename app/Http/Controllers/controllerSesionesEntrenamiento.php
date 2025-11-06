<?php

namespace App\Http\Controllers;

use App\Models\SesionEntrenamiento;
use App\Models\Jugador;
use App\Models\Participacion;
use Illuminate\Http\Request;

class controllerSesionesEntrenamiento extends Controller
{

    /*Función para crear una sesión dada la fecha, el tipo y el equipo. Automáticamente se crea una participación a esa sesión a
    todos los jugadores del equipo de la sesión. */ 
    public function crearSesion(Request $request)
    {
        $sesion = SesionEntrenamiento::create([
            'ses_fecha' => $request->ses_fecha,
            'ses_tipo' => $request->ses_tipo,
            'ses_equipo' => $request->ses_equipo
        ]);

        $jugadores = Jugador::where('jug_equipo', $request->ses_equipo)->get();
        foreach ($jugadores as $jugador) {
            Participacion::create([
                'par_jugador' => $jugador->jug_id,
                'par_sesion' => $sesion->ses_id
            ]);
        }

        $sesion->save();

        return response()->json([
            'status' => 'ok',
            'sesion' => $sesion
        ]);
    }


    //Función para ver  las sesiones de un equipo.
    public function verSesiones(Request $request)
    {

        $sesiones = SesionEntrenamiento::where('ses_equipo', $request->ses_equipo)->get();

        //Formateamos las sesiones para que tengan el formato que necesita el calendario
        $sesionesFormatoCorrecto = $sesiones->map(function ($s) {
            return [
                'id' => $s->ses_id,
                'title' => $s->ses_tipo,
                'date' => $s->ses_fecha
            ];
        });

        return response()->json([
            'status' => 'ok',
            'sesiones' => $sesionesFormatoCorrecto
        ]);
    }

    //Función para ver todas las sesiones de los equipos de un entrenador (pasado por parámetros).
    public function verTodasSesiones(Request $request)
    {
        $entrenadorID = $request->entrenador;

        $sesiones = SesionEntrenamiento::whereHas('equipo', function ($query) use ($entrenadorID) {
            $query->where('equ_entrenador', $entrenadorID);
        })->with(['equipo', 'participaciones'])->get();

        return response()->json([
            'sesiones' => $sesiones
        ]);
    }

    //Función para eliminar una sesión dado su id.
    public function eliminarSesion(Request $request)
    {

        $sesion = SesionEntrenamiento::find($request->ses_id);

        if ($sesion) {
            $sesion->delete();
            return response()->json([
                'message' => 'Sesión eliminada correctamente'
            ]);
        } else {
            return response()->json([
                'message' => 'Sesión no eliminada'
            ], 404);
        }
    }


    public function editarSesion(Request $request)
    {

        $sesion = SesionEntrenamiento::find($request->ses_id);

        if ($sesion) {
            $sesion->ses_fecha = $request->ses_fecha;
            $sesion->save();
            return response()->json([
                'sesion' => $sesion,
                'message' => 'Sesión editada correctamente'
            ]);
        } else {
            return response()->json([
                'message' => 'Sesión no actualizada'
            ], 404);
        }
    }
}
