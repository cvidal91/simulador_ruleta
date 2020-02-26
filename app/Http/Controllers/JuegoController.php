<?php

namespace SimuladorRuleta\Http\Controllers;

use SimuladorRuleta\EstadoJuego;
use SimuladorRuleta\Jugador;
use SimuladorRuleta\Apuesta;
use SimuladorRuleta\ResultadoRuleta;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class JuegoController extends Controller
{
    public function index(){
        
        $j_curso = EstadoJuego::obtenerJuegoEnCurso();
        $en_curso = (isset($j_curso)? 1: 0);
        
        $resultado_ruleta['resultado_ruleta'] = null;
        $resultado_ruleta['resultados_apuesta'] = [];

        $resultado_simulacion = null;        

        if($en_curso === 1){
            $ronda = $j_curso->numero_ronda + 1;
            DB::beginTransaction();
            $resultado_ruleta = $this->simulacionTurno($j_curso->numero_juego,$ronda);
            $j_curso->numero_ronda = $ronda;
            if(!$j_curso->save()){
                DB::rollBack();
                return false;
            }
            DB::commit();
        }
            
        $jugadores_activos = Jugador::obtenerJugadoresActivos();

        return view('index',[
            'en_curso'=>$en_curso,
            'resultado_ruleta'=>$resultado_ruleta['resultado_ruleta'],
            'resultados_apuesta'=>$resultado_ruleta['resultados_apuesta'],
            'jugadores_activos'=>$jugadores_activos,
        ]);
    }

    public function simularProbabilidad($color){
        
        $arr= array();
        foreach($color as $k => $prob){
            for($i=1;$i<=$prob;$i++){
                $arr[] = $k;
            }
        }
        shuffle($arr);
        $indice = rand(0, count($arr)-1);
        return $arr[$indice];
    }

    public function crearJuego(Request $request){

        $juego = new EstadoJuego;
        $juego->estado_juego = 1;
        $juego->numero_ronda = 0;
        $juego->fecha_registro = date('Y-m-d h:i:s');

        if(!$juego->save())
            dd("ha ocurrido un error al guardar el juego");

        Jugador::reiniciarSaldosJugadores();

        return redirect('/');
        
    }

    public function simularMontoApuestaJugador($saldo){
        if($saldo == '0')
            return '0';
        
        $monto = $saldo;
        if($saldo > 1000){
            $por_monto = rand(8,15)/100;
            $monto = round($por_monto*$monto);
        }
        return $monto;
    }

    public function simulacionTurno($numero_juego,$numero_ronda){
        //simular ruleta
        //parametros de probabilidad
        $prob_ruleta = array(
            'verde' => 2,
            'negro' => 49,
            'rojo' => 49,
        );

        $multiplo_ganancia = array(
            'verde' => 15,
            'negro' => 2,
            'rojo' => 2,
        );

        $resultado_ruleta = $this->simularProbabilidad($prob_ruleta);

        $obj_result_ruleta = new ResultadoRuleta;
        $obj_result_ruleta->numero_juego = $numero_juego;
        $obj_result_ruleta->numero_ronda = $numero_ronda;
        $obj_result_ruleta->color_ganador = $resultado_ruleta;

        if(!$obj_result_ruleta->save()){
            DB::rollBack();
            return false;
        }
        //simular apuesta
        $jugadores = Jugador::obtenerJugadoresActivosConSaldo();
        $arr_resultados_ap = array();

        foreach($jugadores as $jugador){
            $apuesta = new Apuesta;
            $apuesta_jugador = $this->simularProbabilidad($prob_ruleta);
            $apuesta->numero_juego = $numero_juego; 
            $apuesta->id_jugador = $jugador->id_jugador;
            $apuesta->valor_apuesta = $this->simularMontoApuestaJugador($jugador->saldo_favor); 
            $apuesta->color_apuesta = $apuesta_jugador;
            $apuesta->numero_ronda = $numero_ronda;

            $jugador->saldo_favor = $jugador->saldo_favor - $apuesta->valor_apuesta;
            

            if($apuesta_jugador == $resultado_ruleta){
                $apuesta->sw_ganador = '1';
                $jugador->saldo_favor = $jugador->saldo_favor + ($apuesta->valor_apuesta * $multiplo_ganancia[$apuesta_jugador]);
            }else
                $apuesta->sw_ganador = '0';
            

            $arr_resultados_ap[] = [
                'nombre_jugador'=>$jugador->nombre_jugador,
                'valor_apuesta'=> $apuesta->valor_apuesta,
                'color_apuesta'=> $apuesta_jugador,
                'sw_gana'=> $apuesta->sw_ganador,
            ];

            if(!$apuesta->save()){
                DB::rollBack();
                return false;
            }

            if(!$jugador->save()){
                DB::rollBack();
                return false;
            }
        }
        return array('resultado_ruleta'=>$resultado_ruleta,'resultados_apuesta'=>$arr_resultados_ap);

    }

    public function terminarJuego(){
        $j_curso = EstadoJuego::obtenerJuegoEnCurso();
        $en_curso = (isset($j_curso)? 1: 0);
        if($en_curso){
            $j_curso->estado_juego = '0';
            $j_curso->save();
            return redirect('/');
        }else{
            dd('Error');
        }
    }
}
