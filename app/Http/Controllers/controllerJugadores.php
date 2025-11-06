<?php

namespace App\Http\Controllers;

use App\Models\Equipo;
use App\Models\Jugador;
use Illuminate\Http\Request;

class controllerJugadores extends Controller
{

    //Función para ver los jugadores según cuyo jug_equipo sea igual al id pasado por parámetros.
    public function verJugadores(Request $request)
    {
        $jugadores = Jugador::where('jug_equipo', $request->jug_equipo)->get();

        return response()->json([
            'jugadores' => $jugadores
        ]);
    }

    //Función para ver todos los jugadores y sus participaciones de los equipos que tengan como entrenador al id de entrenador pasado por parámetros.
    public function verTodosJugadores(Request $request)
    {
        $entrenadorID = $request->entrenador;
        $jugadores = Jugador::whereHas('equipo', function ($equipo) use ($entrenadorID) {
            $equipo->where('equ_entrenador', $entrenadorID);
        })->with(['equipo', 'participaciones'])->get();

        return response()->json([
            'jugadores' => $jugadores
        ]);
    }


    //Función para crear jugadores
    public function crearJugador(Request $request)
    {
        $jugador = Jugador::create([
            'jug_nombre' => $request->jug_nombre,
            'jug_apellido' => $request->jug_apellido,
            'jug_edad' => $request->jug_edad,
            'jug_estado' => 'Disponible',
            'jug_posicion' => $request->jug_posicion,
            'jug_equipo' => $request->jug_equipo

        ]);

        return response()->json([
            'jugador' => $jugador
        ]);
    }

    //Función para eliminar jugador según el id pasado por parámetros.
    public function eliminarJugador(Request $request)
    {
        $jugador = Jugador::find($request->jug_id);

        if ($jugador) {
            $jugador->delete();
            return response()->json([
                'message' => 'Jugador eliminado correctamente'
            ]);
        } else {
            return response()->json([
                'message' => 'Jugador no encontrado'
            ], 404);
        }
    }

    //Función para actualizar los datos de un jugador.
    public function actualizarJugador(Request $request)
    {
        $jugador = Jugador::find($request->jug_id);

        if ($jugador) {
            $jugador->update([
                'jug_nombre' => $request->jug_nombre,
                'jug_apellido' => $request->jug_apellido,
                'jug_edad' => $request->jug_edad,
                'jug_estado' => $request->jug_estado,
                'jug_posicion' => $request->jug_posicion
            ]);
            return response()->json([
                'message' => 'Jugador actualizado correctamente'
            ]);
        } else {
            return response()->json([
                'message' => 'Jugador no encontrado'
            ], 404);
        }
    }

    public function perfilJugador(Request $request)
    {
        $jugador = Jugador::find($request->jug_id);
        return response()->json($jugador);
    }
}
