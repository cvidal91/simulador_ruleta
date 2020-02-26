<?php

namespace SimuladorRuleta\Http\Controllers\Admin;

use SimuladorRuleta\Jugador;
use Validator;
use Illuminate\Http\Request;
use SimuladorRuleta\Http\Controllers\Controller;

class JugadorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function mostrarRegistrar()
    {
        return view('admin.registrar_jugador');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function mostrarEditar($id_jugador)
    {	
    	$jugador = Jugador::obtenerJugadorPorId($id_jugador);
        return view('admin.editar_jugador',['jugador'=>$jugador]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function consultarJugadores()
    {
        $jugadores =Jugador::consultarJugadores();
        return view('admin.consultar_jugadores', ['jugadores'=>$jugadores]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $errors = [
            'nombre_jugador.required' => 'El campo NOMBRE es requerido',
            'saldo_favor.required' => 'El campo SALDO es requerido'
        ];
        $validador = Validator::make($request->all(),[
            'nombre_jugador' => 'required|unique:jugador|max:255',
            'saldo_favor' => 'required'
        ], $errors);

        if($validador->fails()){
            return redirect('jugador/registro')->withErrors($validador)->withInput();
        }

        //validar sw_estado
        $sw_estado = '1';
        if($request->input('sw_estado') == null)
            $sw_estado = '0';

        $nuevo_jugador = new Jugador;
        $nuevo_jugador->nombre_jugador = $request->input('nombre_jugador');
        $nuevo_jugador->saldo_favor = $request->input('saldo_favor');
        $nuevo_jugador->sw_estado = $sw_estado;
        $nuevo_jugador->fecha_registro = date('Y-m-d h:i:s');
        

        if($nuevo_jugador->save())
            $status = true;
        else 
            $status =false;

        return redirect('jugador/registro')->with('status',$status);
    }

    public function update(Request $request)
    {
    	$errors = [
            'nombre_jugador.required' => 'El campo NOMBRE es requerido',
            'nombre_jugador.unique' => 'El jugador con ese nombre ya se encuentra registrado',
            'saldo_favor.required' => 'El campo SALDO es requerido'
        ];

        $validador = Validator::make($request->all(),[
            'nombre_jugador' => 'required|unique:jugador,nombre_jugador,'.$request->input('id_jugador').',id_jugador|max:255',
            'saldo_favor' => 'required'
        ], $errors);

        if($validador->fails()){
            return redirect('jugador/editar/'.$request->input('id_jugador'))->withErrors($validador)->withInput();
        }

        //validar sw_estado
        $sw_estado = '1';
        if($request->input('sw_estado') == null)
            $sw_estado = '0';

        
        $jugador =  Jugador::obtenerJugadorPorId($request->input('id_jugador'));
        $jugador->nombre_jugador = $request->input('nombre_jugador');
        $jugador->saldo_favor = $request->input('saldo_favor');
        $jugador->sw_estado = $sw_estado;
        $jugador->fecha_modificacion = date('Y-m-d h:i:s');

        if($jugador->save())
            $status = true;
        else 
            $status =false;

        return redirect('jugador/editar/'.$request->input('id_jugador'))->with('status',$status);
    }

    public function eliminarJugador($id_jugador){

        $jugador =  Jugador::obtenerJugadorPorId($id_jugador);
        $jugador->sw_estado = '2';
        $jugador->fecha_eliminacion = date('Y-m-d h:i:s');

        if($jugador->save())
            $status = true;
        else 
            $status =false;

        return response()->json([
            'status' => $status,
        ]);
    }

}
