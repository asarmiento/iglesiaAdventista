<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap core CSS -->
        <link type="text/css" href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link type="text/css" href="bootstrap/css/bootstrap.theme.min.css" rel="stylesheet">
        <!-- Custom styles for this template -->
        <link  type="text/css" href="bootstrap/css/justific-nav.css" rel="stylesheet">
        <!-- Jquery, Bootstrap  core js -->
        <script type="text/javascript" src="bootstrap/js/jquery.js"></script>
        <script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>
        <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
        <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
        <script type="text/javascript" src="bootstrap/js/ie-emulation-modes-warning.js"></script>
       
        @yield('head')
  </head>

  <body>

    <div class="container">

        <h1><span class="glyphicon glyphicon-fire"></span>Error 404, La pagina solicitada no existe</h1>
        <a href="{{URL::route('inicio')}}">Regresar a la pagina inicio</a>
      <!-- Site footer -->
     

    </div> <!-- /container -->


 <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
        <script type="text/javascript" src="bootstrap/js/ie10-viewport-bug-workaround.js"></script>
  </body>
</html>
