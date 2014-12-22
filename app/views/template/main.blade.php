@extends('template.base')
@section('content')
<nav class="navbar navbar-inverse" role="navigation">    
    <div class="container-fluid">      
        <!-- Brand and toggle get grouped for better mobile display -->  
        <!-- Collect the nav links, forms, and other content for toggling -->    
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1"> 
            <ul class="nav navbar-nav">         
            </ul>        
            <ul class="nav navbar-nav navbar-right ">   
                <li class="dropdown">                  
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Miembros<span class="caret"></span></a>  
                    <ul class="dropdown-menu" role="menu">                        
                        <li><a>{{ HTML::link('/miembros/new', 'Nuevos Miembros') }}</a></li>    
                        <li><a>{{ HTML::link('/miembros/list', 'Lista Miembros') }}</a></li>    
                    </ul>               
                </li>               
                <li class="dropdown">   
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Ingresos<span class="caret"></span></a>  
                    <ul class="dropdown-menu" role="menu">                   
                        <li><a>{{ HTML::link('/users/add', 'Agregar Usuario') }}</a></li>    
                    </ul>                
                </li>              
                <li class="dropdown">  
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Gastos<span class="caret"></span></a>   
                    <ul class="dropdown-menu" role="menu">              
                        <li><a>{{ HTML::link('/users/add', 'Agregar Usuario') }}</a></li> 
                    </ul>               
                </li>              
                <li class="dropdown">   
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Reportes<span class="caret"></span></a>   
                    <ul class="dropdown-menu" role="menu">                       
                        <li><a>{{ HTML::link('/users/add', 'Agregar Usuario') }}</a></li>  
                    </ul>               
                </li>               
                <li class="dropdown">   
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Usuarios<span class="caret"></span></a>                    
                    <ul class="dropdown-menu" role="menu">                        
                        <li><a>{{ HTML::link('/users/add', 'Agregar Usuario') }}</a></li> 
                    </ul>                </li>               
                <li class="dropdown">                   
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Opciones&nbsp;<span class=" glyphicon glyphicon-cog"></span></a>   
                    <ul class="dropdown-menu" role="menu">                      
                        <li>{{ HTML::link('/logout', 'Cerrar sesión') }}</li>       
                    </ul>              
                </li>           
            </ul>       
        </div><!-- /.navbar-collapse -->   
    </div><!-- /.container-fluid --></nav>
<div class="container principal">@yield('container')</div>
@stop