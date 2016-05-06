<?php
/**
 * Created by PhpStorm.
 * User: Anwar Sarmiento
 * Date: 22/06/2015
 * Time: 12:18 PM
 */

function currentUser()
{
    return auth()->user();
}

function convertTitle($string){

    $string = strtolower($string);

    return ucwords($string);
}

function schoolSession($school){
    \Session::put('school', $school);
}

function userSchool(){

    return \Session::get('school');
}

function actionList(){
    return 'SchoolsController@listSchools';
}

function changeLetterMonth($month){
 $months=   ['01'=>'Enero','02'=>'Febrero','03'=>'Marzo','04'=>'Abril','05'=>'Mayo','06'=>'Junio','07'=>'Julio','08'=>'Agosto','09'=>'Septiembre','10'=>'Octubre','11'=>'Noviembre','12'=>'Diciembre'];
return $months[$month];
}

/**
 * @return mixed
 */
function periodSchool()
{
    if(1):
    return \SistemasAmigables\Entities\Period::where('church_id',1)->get()->last();
    endif;

    return false;

}
function period(){
    if(periodSchool()){
        return periodSchool()->month.'-'.periodSchool()->year;
    }else{
        return "No existe periodo contable.";
    }
}

function dayFinish($month){
    $finsh = ['01'=>31,'02'=>28,'03'=>31,'04'=>30,'05'=>31,'06'=>30,
        '07'=>31,'08'=>31,'09'=>30,'10'=>31,'11'=>30,'12'=>31];
    return $finsh[$month];
}
function dateShort()
{
    $mes_actual = date("n");

    $mes=periodSchool()->month;
    if($mes != $mes_actual):

        $year = periodSchool()->year;
        $dia = date("d",(mktime(0,0,0,$mes+1,1,$year)-1));

        return $salida ="$year/$mes/$dia";

    endif;
    return date("Y/m/d");
}