@extends('layouts.main')
@section('title','Consulta jugadores')

@section('sidebar')

@endsection

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
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
                Listado de jugadores
            </div>
            <div class="card-body">
                <table class="table" id="tb">
                    <thead>
                        <tr>
                            <th scope="col">id</th>
                            <th scope="col">nombre</th>
                            <th scope="col">saldo</th>
                            <th scope="col">opciones</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($jugadores as $jugador)
                        <tr>
                            <td>{{$jugador->id_jugador}}</td>
                            <td>{{$jugador->nombre_jugador}}</td>
                            <td>{{$jugador->saldo_favor}}</td>
                            <td><a href="{{url('/jugador/editar/'.$jugador->id_jugador)}}">modificar</a><a class="btn-elimina-jugador" data-redireccion="{{url('jugador/listar')}}" href="{{url('/jugador/eliminar/'.$jugador->id_jugador)}}">Eliminar</a></td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <!-- /.card -->

    </div>
    <!-- /.col-lg-9 -->

</div>
<script>
    $(document).ready(function() {
        $('#tb').DataTable({
            "ordering": false,
            "info":     false,
            "bInfo": false,
            "bLengthChange": false,
        });
        $('.btn-elimina-jugador').on('click',function(e){
            e.preventDefault();

            Swal.fire({
                title: '¿Está seguro?',
                text: "¿Desea eliminar al jugador?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Eliminar'
            }).then((result) => {
                if (result.value) {
                    var url = $(this).prop('href');
                    var url_red = $(this).data('redireccion');
                    
                    $.ajax({
                            url: url,
                            method: 'POST',
                            dataType: 'json',
                            data: {"_token": $("meta[name='csrf-token']").attr("content")},
                            success: (response)=>{
                                if(response.status){
                                    Swal.fire(
                                        'Eliminado',
                                        'Jugador eliminado satisfactoriamente',
                                        'success'
                                    );
                                    window.location=url_red;
                                }else{
                                    Swal.fire(
                                        'Error',
                                        'Ha ocurrudo un error en la eliminación del jugador',
                                        'error'
                                    );
                                }
                                
                            }
                        }
                    );
                    
                }
            })





            
            
        });
    } );

    
</script>
@endsection