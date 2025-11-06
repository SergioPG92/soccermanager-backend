<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jugador extends Model
{
    use HasFactory;

    //Nombre de la tabla
    protected $table = 'jugadores';

    //Primary Key
    protected $primaryKey = 'jug_id';

    //Timestamps desactivados por defecto.
    public $timestamps = false;

    //Campos modificables
    protected $fillable = [
        'jug_nombre',
        'jug_apellido',
        'jug_edad',
        'jug_posicion',
        'jug_estado',
        'jug_equipo',
    ];

    // Relaciones de la tabla
    public function equipo()
    {
        //Belongsto: Pertenece a un equipo.
        return $this->belongsTo(Equipo::class, 'jug_equipo', 'equ_id');
    }

    public function participaciones()
    {
        //HasMany: Puede tener varias participaciones.
        return $this->hasMany(Participacion::class, 'par_jugador', 'jug_id');
    }
}
