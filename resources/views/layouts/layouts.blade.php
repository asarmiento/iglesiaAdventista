<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>@yield('title')</title>
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <link rel="shortcut icon" href="{{ asset('img/favicon.png') }}">
    {{HTML::style('css/bootstrap.min.css')}}
    {{HTML::style('css/ladda-themeless.min.css')}}
    {{HTML::style('css/main.css')}}
</head>
<body>
    <header>
        <div>
            <a href="{{url()}}"><img id="logo" src="{{ asset('img/LogoEs.png') }}" alt=""></a>
            <div class="auth">
                <span class="user">
                    Anwar Sarmiento, 
                </span>
                <span class="church">
                    Bienvenido a la Iglesia Quepos
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
                                <li><a href="{{url()}}/iglesias">Iglesias</a></li>
                                <li><a href="{{url()}}/miembros">Miembros</a></li>
                                <li><a href="{{url()}}/informes">Informe Semanal</a></li>
                                <li><a href="{{url()}}/gastos">Gastos</a></li>
                                <li><a href="{{url()}}/cheques">Cheques</a></li>
                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Configuración <span class="caret"></span></a>
                                    <ul class="dropdown-menu" role="menu">
                                        <li><a href="{{url()}}/departamentos">Departamentos</a></li>
                                        <li><a href="{{url()}}/tipos_fijos">Tipos Fijos</a></li>
                                        <li><a href="{{url()}}/tipos_variables">Tipos Variables</a></li>
                                        <li><a href="{{url()}}/type_users">Tipos de Usuarios</a></li>
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
    <aside class='page'>
        <div class="container">
            @yield('page')
        </div>
    </aside>
    <main>
        <div class="container">
            @yield('content')
        </div>
    </main>
    <footer>
        <div class="container">
            <p class="text-center">Elaborado por: Francisco Gamonal &AMP; Anwar Sarmiento &copy; Copyright </p>
        </div>
    </footer>
    {{HTML::script('js/lib/jquery.min.js')}}
    {{HTML::script('js/lib/bootstrap.min.js')}}
    {{HTML::script('js/lib/jquery.blockUI.min.js')}}
    {{HTML::script('js/lib/spin.min.js')}}
    {{HTML::script('js/lib/ladda.min.js')}}
    {{HTML::script('js/main.js')}}
</body>
</html>