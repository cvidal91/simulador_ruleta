@extends('layouts.main')
@section('title','Editar jugador')

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
                Editar jugador
            </div>
            <div class="card-body">
                {!!Form::model($jugador,['route'=>['jugador.actualizar'],'method'=>'post'])!!}
                    @csrf
                    
                    <input type="hidden" name="id_jugador" value="{{$jugador->id_jugador}}">
                    <div class="form-group">
                        <label>Nombre jugador</label><br>
                        @if($errors->has('nombre_jugador'))
                        <label class="control-label" for="inputError">{{$errors->first('nombre_jugador')}}</label>
                        @endif
                        {!!Form::text('nombre_jugador',null,['class'=>'form-control'])!!}

                        <label>Saldo $</label><br>
                        @if($errors->has('saldo_favor'))
                        <label class="control-label" for="inputError">{{$errors->first('saldo_favor')}}</label>
                        @endif
                        {!!Form::number('saldo_favor',null,['class'=>'form-control'])!!}

                        <label>Activo</label>
                        <input type="checkbox" name="sw_estado" {{(($jugador->sw_estado == '1')?'checked':'')}}>
                    </div>
                    <button type="submit" class="btn btn-success">Guardar</button>
                {!!Form::close()!!}
            </div>
            @if(session('status'))
            <div class="alert alert-success">
                Jugador actualizado satisfactoriamente!
            </div>
            @endif
        </div>
        <!-- /.card -->

    </div>
    <!-- /.col-lg-9 -->

</div>
@endsection