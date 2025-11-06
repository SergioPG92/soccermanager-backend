<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Equipo extends Model
{
    use HasFactory;

    //Nombre de la tabla
    protected $table = 'equipos';

    //Primary Key
    protected $primaryKey = 'equ_id';

    //Sin timestamps por defecto.
    public $timestamps = false;

    //Campos modificables
    protected $fillable = [
        'equ_nombre',
        'equ_entrenador',
    ];

   
    //Relaciones de la tabla
    public function entrenador()
    {
        //BelongsTo significa que puede pertenecer a un entrenador.
        return $this->belongsTo(Entrenador::class, 'equ_entrenador', 'ent_id');
    }

    public function jugadores()
    {
        //HasMany significa que puede tener varios jugadores
        return $this->hasMany(Jugador::class, 'jug_equipo', 'equ_id');
    }

    public function sesiones()
    {
        //HasMany significa que puede tener varias sesión de entrenamiento.
        return $this->hasMany(SesionEntrenamiento::class, 'ses_equipo', 'equ_id');
    }
}
