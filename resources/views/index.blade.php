@extends('layouts.main')
@section('title','Inicio')

@section('sidebar')

@endsection

@section('content')
<div class="row">
    <div class="col-lg-12">

        <div class="card card-outline-secondary my-4">
            <div class="card-header">
                Datos del jugador
            </div>
            <div class="card-body">
                <table class="table" id="tb">
                    <thead>
                        <tr>
                            <th scope="col">Nombre jugador</th>
                            <th scope="col">Saldo</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($jugadores_activos as $jugador)
                    <tr>
                        <td>{{$jugador->nombre_jugador}}</td>
                        <td>{{$jugador->saldo_favor}}</td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <!-- /.card -->

        <div class="card card-outline-secondary my-4">
            <div class="card-header">
                Resultado de simulación
            </div>
            <div class="card-body">
                <table class="table" id="tb">
                    <thead>
                        <tr>
                            <th scope="col">Nombre jugador</th>
                            <th scope="col">Valor apuestas</th>
                            <th scope="col">Color apuesta</th>
                            <th scope="col">Gana</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($resultados_apuesta as $resultado)
                    <tr>
                        <td>{{$resultado['nombre_jugador']}}</td>
                        <td>{{$resultado['valor_apuesta']}}</td>
                        <td>{{$resultado['color_apuesta']}}</td>
                        <td>{{(($resultado['sw_gana']=='1')?'Gano': 'No gano')}}</td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
                <p><b>Resultado de ruleta:</b> {{$resultado_ruleta}}</p>
            </div>
        </div>
        @if(isset($jugadores_activos) && count($jugadores_activos) > 0)
        @if($en_curso)
        <a href="{{url('/')}}" class="btn btn-success" >Jugar otra ronda</a>
        <a href="{{url('/terminar_juego')}}" class="btn btn-danger" >Terminar juego</a>
        <script>
            setTimeout(function(){ window.location=self.location; }, 30000);
        </script>
        @else
        <form method="post" action="{{url('/crear_juego')}}">
            @csrf
            <button type="submit" class="btn btn-success">Iniciar simulación</button>
            <input hidden="iniciar" value="1">
        </form>
        @endif
        @endif
        <!-- /.card -->

    </div>
    <!-- /.col-lg-9 -->
</div>

@endsection