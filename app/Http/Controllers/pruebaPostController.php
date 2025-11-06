<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class pruebaPostController extends Controller
{
    public function index(Request $request)
    {
        $data = $request->all();
        $resultado=0;
        if($data['operacion'] == 'Suma'){
            $resultado = $data['num1'] + $data['num2'];
        } elseif($data['operacion'] == 'Resta'){
            $resultado = $data['num1'] - $data['num2'];
        } elseif($data['operacion'] == 'Multiplicacion'){
            $resultado = $data['num1'] * $data['num2'];
        } elseif($data['operacion'] == 'Division'){
            if($data['num2'] != 0){
                $resultado = $data['num1'] / $data['num2'];
            } else {
                return response()->json([
                    'message' => 'Error',
                    'result' => 'No se puede dividir entre cero'
                ]);
            }
        } else {
            return response()->json([
                'message' => 'Error',
                'result' => 'Operación no válida'
            ]);
        }
         // Retornar la respuesta en formato JSON
        return response()->json([
            'message' => 'Resultado',
            'result' => $resultado
        ]);
    }
}
