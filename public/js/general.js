$(document).ready(function() {
    $('tbody.list tr:odd').addClass('odd');
    $('tbody.list tr:even').addClass('even');
    
    $("#fechaCreatePlanilla").datepicker({
        dateFormat: "yy-mm-dd",
        dayNamesMin: ["Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa"],
        showOtherMonths: true,
        monthNamesShort: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic"],
        changeMonth: true,
        changeYear: true
    });
});