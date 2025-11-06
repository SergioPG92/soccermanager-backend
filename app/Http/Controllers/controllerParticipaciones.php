<?php

namespace App\Http\Controllers;

use App\Models\Participacion;
use App\Models\SesionEntrenamiento;
use Illuminate\Http\Request;

class controllerParticipaciones extends Controller
{
    //Función para crear una participación (en una sesion de entrenamiento) de un jugador. 
    public function crearParticipacion(Request $request)
    {
        $participacion = Participacion::create([
            'par_jugador'=> $request->par_jugador,
            'par_sesion'=> $request->par_sesion,
            'par_nota'=> $request->par_nota
        ]);

        return response()->json([
            'status' => 'ok',
            'participacion' => $participacion
        ]);
    }

    //Función para ver las participaciones de los jugadores que tengan al equipo pasado por parámetros.
    public function verParticipacionesEquipo(Request $request)
    {
        $sesionesConParticipaciones = SesionEntrenamiento::with('participaciones')
            ->where('ses_equipo', $request->equipo_id)
            ->get();


        return response()->json([
            'status' => 'ok',
            'sesionesConParticipaciones' => $sesionesConParticipaciones
        ]);
    }

    //Función para ver todas las participaciones, con su jugador y sesión de entrenamiento.
    public function verTodasParticipaciones()
    {
        $participaciones = Participacion::with(['jugador', 'sesionEntrenamiento'])->get();

        return response()->json([
            'status' => 'ok',
            'participaciones' => $participaciones
        ]);
    }
    

    //Función para editar la nota de una participación.
    public function editarParticipacion(Request $request)
    {
        $participacion = Participacion::find($request->par_id);

        if ($participacion) {
            $participacion->update([
                'par_nota' => $request->par_nota
            ]);

            return response()->json([
                'status' => 'ok',
                'participacion' => $participacion
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Participación no encontrada'
            ], 404);
        }
    }
}
