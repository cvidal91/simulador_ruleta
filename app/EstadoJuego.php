<?php

namespace SimuladorRuleta;

use Illuminate\Database\Eloquent\Model;

class EstadoJuego extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'estado_juego';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'numero_juego';

    public $timestamps = false;
    /**
     * @var array
     */
    protected $fillable = ['estado_juego', 'fecha_registro','numero_ronda'];

    public static function obtenerJuegoEnCurso(){
        return self::where('estado_juego', '1')
            ->first();
    }
}
