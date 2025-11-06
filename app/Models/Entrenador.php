<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Laravel\Sanctum\PersonalAccessToken;

class Entrenador extends Authenticatable
{
    use HasApiTokens, Notifiable;
    
    //Nombre de la tabla
    protected $table = 'entrenadores';

    // Primary Key
    protected $primaryKey = 'ent_id';

    // Indicamos que es autoincremental
    public $incrementing = true;

    
    // Campos modificables
    protected $fillable = ['ent_nombre', 'ent_apellido', 'ent_email', 'ent_password', 'rol'];

    // Campos ocultos
    protected $hidden = ['ent_password', 'remember_token'];

    public function equipos()
    {
        //Tipo de relación con entrenadores (hasMany significa que un entrenador puede tener varios equipos)
        return $this->hasMany(Equipo::class, 'equ_entrenador', 'ent_id');
    }
}
