<!DOCHTML HTML>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>@yield('title')</title>
        <link rel="shortcut icon" href="{{ asset('assets/img/favicon.png') }}">
        {{HTML::style('assets/css/foundation.css')}}
        {{HTML::style('asset/css/bootstrap.css')}}
        {{HTML::style('assets/css/styles.css')}}
        {{HTML::style('assets/ui/jquery-ui.css')}}
        {{HTML::style('assets/css/normalize.css')}}
        {{HTML::script('assets/js/vendor/jquery.js')}}
        {{HTML::script('assets/ui/jquery-ui.js')}}
        {{HTML::script('assets/js/foundation/foundation.js')}}
         {{HTML::script('assets/js/global.js')}}
    </head>
    <body>
        <div class="row">
            <div class="columns-2 left">
                <img src="{{url()}}/assets/img/logo.jpg" width="170" height="170">
            </div>
            <div class="columns-11">
                <div class="contain-to-grid">
                    <nav class="top-bar" data-topbar>
                        <ul class="title-area">
                            <li class="name"></li>
                            <li class="toggle-topbar menu-icon"><a href="#"><span>Menu</span></a></li>
                        </ul>
                        <section class="top-bar-section">
                            <ul class="left">
                                <li><a href="{{url()}}/home">INICIO</a></li>
                                <li><a href="{{url()}}/iglesias">IGLESIA</a></li>
                                <li><a href="{{url()}}/miembros">MIEMBROS</a></li>
                                <li><a href="{{url()}}/informes">INFORME SEMANAL</a></li>
                                <li><a href="{{url()}}/gastos">GASTOS</a></li>
                                <li><a href="{{url()}}/cheques">CHEQUES</a></li>
                                <li class="has-dropdown">
                                    <a href="#">CONFIGURACIÓN</a>
                                    <ul class="dropdown">
                                        <li><a href="{{url()}}/departamentos">DEPARTAMENTOS</a></li>
                                        <li><a href="{{url()}}/tipos_fijos">TIPOS FIJOS</a></li>
                                        <li><a href="{{url()}}/tipos_variables">TIPOS VARIABLES</a></li>
                                        <li><a href="{{url()}}/type_users">TIPOS USUARIO</a></li>
                                    </ul>
                                </li>
                                <li><a href="/">SALIR</a></li>
                            </ul>

                        </section>
                    </nav>
                </div>        
            </div>    
        </div>

        <!-- End Header and Nav -->
        <!-- Second Band (Image Left with Text) -->
        <div class="row">
            <div class="large-12 columns">
                <h1 class="text-center">-- @yield('title-form') --</h1>
                <div class="container"> 
                @yield('content')
                </div>
            </div>
        </div>
        <!-- Footer -->
        <footer class="row">
            <div class="large-12 columns">
                <hr />
                <p class="text-center">Elaborado por: Francisco Gamonal &AMP; Anwar Sarmiento &copy; Copyright </p>
            </div>
        </footer>   

        
       
        
    </body>
</html>