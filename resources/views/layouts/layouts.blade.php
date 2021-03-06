<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>@yield('title')</title>
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <link rel="stylesheet" href="{{ asset( 'img/favicon.png' ) }}">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{ asset('css/ladda-themeless.min.css')}}">
    <link rel="stylesheet" href="{{ asset('packages/font-awesome-4.7.0/css/font-awesome.css')}}">
    <link rel="stylesheet" href="{{ asset('css/jquery.dataTables.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/lib/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/main.css')}}">
    <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<script>
  (adsbygoogle = window.adsbygoogle || []).push({
    google_ad_client: "ca-pub-9818954671091924",
    enable_page_level_ads: true
  });
</script>
    @yield('styles')
</head>
<body>
    <header>
        <div>
            <a href="#"><img id="logo" src="{{ asset('img/LogoEs.png') }}" alt=""></a>
            <div class="auth">
                <span class="user">

                </span>
                <span class="church">
                    Bienvenido a la Iglesia Adventista de Quepos
                </span>
            </div>
            <div class="menu">
                <nav class="navbar navbar-default">
                    <div class="container-fluid">
                        <div class="navbar-header">
                            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                                <span class="sr-only">Toggle navigation</span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                            </button>
                        </div>
                        <div id="navbar" class="navbar-collapse collapse">
                            <ul class="nav navbar-nav navbar-right">
                                <li class="dropdown">
                                    <a href="#"  class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Mision/Asociación<span class="caret"></span></a>
                                    <ul class="dropdown-menu">
                                        <li><a href="{{route('deposito-campo-ver')}}">Depositos</a></li>
                                        <li><a href="{{route('campo-ver')}}">Reporte de Pagos</a></li>
                                    </ul>
                                </li>
                                <li><a href="#"  class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Iglesia<span class="caret"></span></a>
                                    <ul class="dropdown-menu">
                                        <li><a href="{{route('periodos-saldos')}}">Saldos Por Mes</a></li>
                                        <li><a href="{{route('periodos-ver')}}">Periodos Ver</a></li>
                                        <li><a href="{{route('auditoria-ver')}}">Reporte Auditoria</a></li>
                                    </ul>
                                </li>
                                <li class="dropdown">
                                    <a href="#"  class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Departamentos<span class="caret"></span></a>
                                    <ul class="dropdown-menu">
                                        <li><a href="{{route('index-depart')}}">Departamentos</a></li>
                                        <li><a href="{{route('date-depart')}}">Movimiento x Departamentos</a></li>
                                        <li><a href="{{route('typeFix-lista')}}">Tipos de Ingresos</a></li>
                                        <li><a href="{{route('realacionar-typeFix')}}">Relacionar</a></li>
                                        <li><a href="{{route('typeExp-lista')}}">Tipos de Gastos</a></li>

                                    </ul>
                                </li>
                                <li class="dropdown">
                                    <a href="#"  class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Miembros<span class="caret"></span></a>
                                    <ul class="dropdown-menu">
                                        <li><a href="{{route('members-lista')}}">Lista de Miembros</a></li>
                                        <li><a href="{{route('members-mat')}}">Materiales</a></li>
                                        <li><a href="{{route('lista-diezmo')}}">Diezmos y Ofrendas Miembros</a></li>
                                   </ul>
                                </li>
                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Bancos<span class="caret"></span></a>
                                    <ul class="dropdown-menu">
                                        <li><a href="{{route('bank-ver')}}">Bancos</a></li>
                                        <li><a href="{{route('deposito-ver')}}">Depositos Iglesia</a></li>
                                        <li><a href="{{route('checks-lista')}}">Cheques</a></li>
                                    </ul>
                                </li>
                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Ingresos<span class="caret"></span></a>
                                    <ul class="dropdown-menu">
                                        <li><a href="{{route('index-record')}}">Informe Semanal</a></li>
                                        <li><a target="_blank" href="{{route('info-income')}}">Reporte Mensual</a></li>
                                        <li><a href="{{route('lista-incomes',date('Y'))}}">Reporte de Ingresos</a></li>
                                    </ul>
                                </li>
                                <li><a  href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Gastos<span class="caret"></span></a>
                                    <ul class="dropdown-menu">
                                        <li><a href="{{route('index-gasto')}}">Lista de Gastos</a></li>
                                        <li><a href="{{route('lista-gastos')}}">Reporte de Gastos</a></li>
                                    </ul>
                                </li>
                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Configuración <span class="caret"></span></a>
                                    <ul class="dropdown-menu" role="menu">
                                        <li><a href="{{route('fondos-report')}}">Reporte Fondos</a></li>
                                        <li><a href="{{route('ddd-store')}}">Traspaso de Fondos</a></li>
                                        <li><a href="{{url()}}/iglesia/type_users">Tipos de Usuarios</a></li>
                                    </ul>
                                </li>
                                <li><a href="{{url()}}">Salir</a></li>
                            </ul>
                        </div>
                    </div>
                </nav>
            </div>
        </div>
    </header>

    <main>
        <div class="container">
            @yield('content')
        </div>
    </main>
    <footer>
        <div class="container">
            <p class="text-center">Elaborado por: Sistemas Amigables de Costa Rica SAOR S.A. &copy; Copyright </p>
        </div>
    </footer>
    <script src="{{ asset('js/lib/jquery.js') }}"></script>
    <script src="{{ asset('js/lib/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/lib/jquery.blockUI.min.js') }}"></script>
    <script src="{{ asset('js/lib/spin.min.js') }}"></script>
    <script src="{{ asset('js/lib/ladda.min.js') }}"></script>
    <script src="{{ asset('js/lib/jquery.dataTables.js') }}"></script>
	<script src="{{ asset('js/lib/select2.min.js') }}"></script>
    @yield('scripts')
    <script src="{{ asset('js/main.js') }}"></script>
</body>
</html>
