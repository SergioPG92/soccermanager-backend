<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Participacion extends Model
{
    use HasFactory;

    //Nombre de la tabla
    protected $table = 'participaciones';

    //Primary key
    protected $primaryKey = 'par_id';

    //Timestamps desactivadas por defecto.
    public $timestamps = false;

    //Campos modificables
    protected $fillable = [
        'par_jugador',
        'par_sesion',
        'par_nota',
    ];

    // Relaciones de la tabla
    public function jugador()
    {
        //Pertenece a un jugador
        return $this->belongsTo(Jugador::class, 'par_jugador', 'jug_id');
    }

    public function sesion()
    {
        //Pertenece a una sesión de entrenamiento
        return $this->belongsTo(SesionEntrenamiento::class, 'par_sesion', 'ses_id');
    }
}
