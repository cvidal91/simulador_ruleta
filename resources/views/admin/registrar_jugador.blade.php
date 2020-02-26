@extends('layouts.main')
@section('title','Registrar jugador')

@section('sidebar')

@endsection

@section('content')
<div class="row">
    <div class="col-lg-3">
        <h1 class="my-4" style="font-size:24px;">Gestión de jugador</h1>
        <div class="list-group">
            <a href="{{url('/jugador/registro')}}" class="list-group-item">Registrar jugador</a>
            <a href="{{url('/jugador/listar')}}" class="list-group-item">Consultar jugadores</a>
        </div>
    </div>
    <!-- /.col-lg-3 -->
    <div class="col-lg-9">

        <div class="card card-outline-secondary my-4">
            <div class="card-header">
                Registrar jugador
            </div>
            <div class="card-body">
                <form role="form" action="{{url('jugador/registrar')}}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label>Nombre jugador</label><br>
                        @if($errors->has('nombre_jugador'))
                        <label class="control-label" for="inputError">{{$errors->first('nombre_jugador')}}</label>
                        @endif
                        <input class="form-control {{($errors->has('nombre_jugador'))? 'is-invalid':''}}" type="text" name="nombre_jugador" value="{{old('nombre_jugador')}}">
                        
                        <label>Saldo $</label><br>
                        @if($errors->has('saldo_favor'))
                        <label class="control-label" for="inputError">{{$errors->first('saldo_favor')}}</label>
                        @endif
                        <input class="form-control {{($errors->has('saldo_favor'))? 'is-invalid':''}}" type="number" name="saldo_favor" value="10000" min="10000">                        
                        <label>Activo</label>
                        <input type="checkbox" name="sw_estado" checked>
                    </div>
                <button type="submit" class="btn btn-success">Guardar</button>              
                </form>
            </div>
            @if(session('status'))
            <div class="alert alert-success">
                Jugador registrado satisfactoriamente!
            </div>
            @endif
        </div>
        <!-- /.card -->

    </div>
    <!-- /.col-lg-9 -->

</div>
@endsection