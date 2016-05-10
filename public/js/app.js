/**
 * Created by anwar on 06/02/16.
 */
var server = "/";

/**
 * [exists description]
 * @return {[type]} [description]
 */
jQuery.fn.exists = function() {
    return this.length>0;
}

/**
 * @param  {[string]} selector [id table]
 * @param  {[string]} list [comment the table]
 * @return {[dataTable]}   [table with options dataTable]
 */
var dataTable = function(selector, list){
    var options = {
        "order": [
            [0, "asc"]
        ],
        "bLengthChange": true,
        //'iDisplayLength': 7,
        "oLanguage": {
            "sLengthMenu": "_MENU_ registros por página",
            "sInfoFiltered": " - filtrada de _MAX_ registros",
            "sSearch": "Buscar: ",
            "sZeroRecords": "No existen, " + list,
            "sInfoEmpty": " ",
            "sInfo": 'Mostrando _END_ de _TOTAL_',
            "oPaginate": {
                "sPrevious": "Anterior",
                "sNext": "Siguiente"
            }
        }
    };
    $(selector).DataTable(options);
};
/**
 * [messageAjax - Response message after request ]
 * @param  {[json]} data [description messages error after request]
 * @return {[alert]}     [errors in alert]
 */
var box;
var messageAjax = function(data, no_bootbox) {
    //console.log(data.errors);
    $.unblockUI();
    if(data.success){
        if(data.message.redirect)
        {
            window.location.href = data.message.href;
        }else{
            if(! no_bootbox )
            {
                bootbox.alert('<p class="success-ajax">'+data.message+'</p>', function(){
                    location.reload();
                });
            }
        }
    }
    else{
        messageErrorAjax(data);
    }
};

/**
 * [messageErrorAjax description]
 * @param  {[type]} error [description]
 * @return {[type]}       [description]
 */
var messageErrorAjax = function(data){
    $.unblockUI();
    var errors = data.errors;
    var error  = "";
    if($.type(errors) === 'string'){
        error = data.errors;
    }else{
        for (var element in errors){
            if(errors.hasOwnProperty(element)){
                error += errors[element] + '<br>';
            }
        }
    }
    bootbox.alert('<p class="error-ajax">'+error+'</p>');
};

/**
 * [loadingUI - Message before ajax for request]
 * @param  {[string]} message [message for before ajax]
 * @return {[message]}        [blockUI response with message]
 */
var loadingUI = function (message, img){
    if(img){
        var msg = '<h2><img style="margin-right: 30px" src="' + server + 'images/spiffygif.gif" >' + message + '</h2>';
    }else{
        var msg = '<h2>' + message + '</h2>';
    }
    $.blockUI({ css: {
        border: 'none',
        padding: '15px',
        backgroundColor: '#000',
        '-webkit-border-radius': '10px',
        '-moz-border-radius': '10px',
        opacity: 0.5,
        color: '#fff'
    }, message: msg});
};


/**
 * [ajaxForm - setup ajax for request]
 * @param  {[string]} url  [description]
 * @param  {[string]} type [description]
 * @param  {[json]} data [description]
 * @return {[type]}      [description]
 */
var ajaxForm = function (url, type, data, msg, school){
    var message;
    var path = server + url;
    if(msg){
        message = msg
    }else{
        if(type == 'post'){
            message = 'Registrando Datos';
        }else{
            message = 'Actualizando Registros';
        }
    }
    if(school){
        path = server + window.location.pathname.split('/')[1] + '/' + window.location.pathname.split('/')[2] + ('/') +url;
    }
    return $.ajax({
        url: path,
        type: type,
        data: {data: JSON.stringify(data)},
        datatype: 'json',
        beforeSend: function(){
            loadingUI(message, 'img');
        },
        error:function(xhr, status, error){
            $.unblockUI();
            if(xhr.status == 401){
                bootbox.alert("<p class='red'>No estas registrado en la aplicación.</p>", function(response){
                    location.reload();
                });
            }else{
                bootbox.alert("<p class='red'>No se pueden grabar los datos.</p>");
            }
        }
    });
};




$(function(){
    //setup Ajax
    $.ajaxSetup({
        headers: {
            'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
        }
    });

    var data = {};



dataTable('#table_check', 'Cheques');
dataTable('#table_expense', 'Gastos');
dataTable('#table_income', 'Ingresos');
dataTable('#table_informe', 'Informe');
dataTable('#table_variable', 'Tipos Variables');
dataTable('#table_member', 'Miembros');
dataTable('#table_depart', 'Departamentos');
dataTable('#table_iglesia', 'Depositos Iglesia');
dataTable('#table_deposit', 'Depositos de Asociación');

    /* Titpo Usuarios  */
    $(document).off('click', '#saveTypeUser');
    $(document).on('click', '#saveTypeUser', function(e){
        e.preventDefault();
        url = $(this).data('url');
        url =  url + '/create';
        data.nameTypeUser  = $('#nameTypeUser').val();

        ajaxForm(url,'post',data)
            .done( function (data) {
                messageAjax(data);
            });
    });

});