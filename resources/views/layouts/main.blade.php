<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>@yield('title')- Simulador de ruleta</title>
    

    <link href="{{asset('css/bootstrap/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('css/shop-item.css')}}" rel="stylesheet">
    <script src="{{asset('js/jquery/jquery.min.js')}}"></script>  
    <link rel="stylesheet" type="text/css" href="{{asset('DataTables/datatables.min.css')}}"/>
    <script src="{{asset('DataTables/datatables.min.js')}}"></script>
    <link rel="stylesheet" type="text/css" href="{{asset('css/swal/sweetalert2.min.css')}}"/>
    <script src="{{asset('js/swal/sweetalert2.all.min.js')}}"></script>
    

</head>

<body>
  <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
        <div class="container">
            <a class="navbar-brand" href="#">SIMULADOR DE RULETA</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{url('/')}}">Inicio
                            <span class="sr-only">(current)</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{url('/jugador/listar')}}">Gestión de jugador</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

  <!-- Page Content -->
    <div class="container">
        @yield('content')  
    </div>
    <!-- /.container -->

   

</body>

</html>
