<?php

namespace SimuladorRuleta;

use Illuminate\Database\Eloquent\Model;

class Apuesta extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'apuesta';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'id_apuesta';

    public $timestamps = false;
    /**
     * @var array
     */
    protected $fillable = ['numero_juego', 'id_jugador', 'valor_apuesta', 'sw_ganador', 'color_apuesta','numero_ronda'];

    
}
