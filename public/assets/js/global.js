/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$(document).ready(function(){
     /**
     * @date 10-04-13
     * @update 00-00-00
     * @author Anwar Sarmiento
     */
    $("#date").datepicker({
        dateFormat: "yy-mm-dd",
        dayNamesMin: [ "Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa" ],
        showOtherMonths: true,
        monthNamesShort: [ "Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic" ],
        changeMonth:true,
        changeYear:true,
        minDate: new Date(1940, 1 - 1, 1)
    });
});

