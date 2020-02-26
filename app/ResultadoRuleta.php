<?php

namespace SimuladorRuleta;

use Illuminate\Database\Eloquent\Model;

class ResultadoRuleta extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'resultados_ruleta';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'consecutivo';

    public $timestamps = false;
    /**
     * @var array
     */
    protected $fillable = ['numero_juego', 'color_ganador','numero_ronda'];

}
