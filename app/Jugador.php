<?php

namespace SimuladorRuleta;

use Illuminate\Database\Eloquent\Model;

class Jugador extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'jugador';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'id_jugador';

    public $timestamps = false;
    /**
     * @var array
     */
    protected $fillable = ['nombre_jugador', 'saldo_favor', 'sw_estado','fecha_registro','fecha_modificacion','fecha_eliminacion'];

    public static function obtenerJugadorPorId($id_jugador){
        return self::where('id_jugador', $id_jugador)
            ->first();
    }

    public static function consultarJugadores(){
        return self::where('sw_estado','1')
                ->orWhere('sw_estado','0')
                ->get();
    }

    public static function obtenerJugadoresActivosConSaldo(){
        return self::where('sw_estado','1')
                ->where('saldo_favor','>','0')
                ->get();
    }

    public static function obtenerJugadoresActivos(){
        return self::where('sw_estado','1')
                ->get();
    }

    public static function reiniciarSaldosJugadores(){
        return self::where('sw_estado','1')
                ->update(['saldo_favor'=>'10000.00']);
    }
}
