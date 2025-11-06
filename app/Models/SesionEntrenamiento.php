<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SesionEntrenamiento extends Model
{
    use HasFactory;

    //Nombre de la tabla
    protected $table = 'sesiones_de_entrenamiento';

    //Primary Key
    protected $primaryKey = 'ses_id';

    //Timestamps desactivados por defecto
    public $timestamps = false;

    //Campos modificables
    protected $fillable = [
        'ses_equipo',
        'ses_fecha',
        'ses_hora',
        'ses_tipo',
    ];

    // Relaciones de la tabla
    public function equipo()
    {
        //Pertenece a un equipo
        return $this->belongsTo(Equipo::class, 'ses_equipo', 'equ_id');
    }

    public function participaciones()
    {
        //Puede tener varias participaciones
        return $this->hasMany(Participacion::class, 'par_sesion', 'ses_id');
    }
}
