<?php

/*
  |--------------------------------------------------------------------------
  | Application Routes
  |--------------------------------------------------------------------------
  |
  | Here is where you can register all of the routes for an application.
  | It's a breeze. Simply tell Laravel the URIs it should respond to
  | and give it the Closure to execute when that URI is requested.
  |
 */


// Nos mostrarÃ¡ el formulario de login.
Route::get('login', 'AuthController@showLogin');

// Validamos los datos de inicio de sesiÃ³n.
Route::post('login', 'AuthController@postLogin');

// Nos indica que las rutas que estÃ¡n dentro de Ã©l sÃ³lo serÃ¡n mostradas si antes el usuario se ha autenticado.
Route::group(array('before' => 'auth'), function() {
    // Esta serÃ¡ nuestra ruta de bienvenida.
    Route::get('/', function() {
        return View::make('hello');
    });

    Route::controller('users', 'UserController');

    Route::controller('setup','SetupController');
    // Esta ruta nos servirÃ¡ para cerrar sesiÃ³n.
    Route::get('logout', 'AuthController@logOut');
});


use Anouar\Fpdf\Fpdf as baseFpdf;
class PDF extends baseFpdf
{
// Page header
function Header()
{
    // Logo
   //  $this->Image('',10,6,30);
    // Arial bold 15
    $this->SetFont('Arial','B',15);
    // Move to the right
   // Title
    $this->Cell(0,5,'MINISTERIO DE EDUCACION PUBLICA',0,1,'C');
    $this->Cell(0,5,'DIRECCION REGIONAL DE EDUCACION DE AGUIRRE',0,1,'C');
    // Line break
    $this->Ln(20);
}

// Page footer
function Footer()
{
    // Position at 1.5 cm from bottom
    $this->SetY(-15);
    // Arial italic 8
    $this->SetFont('Arial','I',8);
    // Page number
    $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
}
}
