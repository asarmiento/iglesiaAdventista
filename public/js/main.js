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

var ajaxForm = function (resource, type, data, form, method){
	var url= server + resource;
	var before = null;
	var error = null;
	var color = null;
	if(form === 'form') {
		before = "Registrando";
		error = "No se pueden grabar los datos.";
		color = "red";
	}
	if(type === 'delete' || (type === 'put' && method != 'restore')) {
		url += '/' + data.id;
	}
	if(method === 'restore') {
		url += '/restore/' + data.id;
	}
	return $.ajax({
			url: url,
		    type: type,
		    data: {data: JSON.stringify(data)},
		    datatype: 'json',
		    beforeSend: function(){
		    	if(before){
		    		loadingUI(before);	
		    	}else{
		    		console.log('Registrando');
		    	}
		    },
		    error:function(){
		        if(error){
		    		responseUI(error);	
		    	}else{
		    		console.log('No se pueden grabar los datos.');
		    	}
		    }
		});
};

var data = {};
var server = 'http://localhost/iglesiaQuepos/public/';

$(function(){

	/* Type User */
	$(document).on("click", "#btnDisabledTypeUser", function(e){
		e.preventDefault();
		var resource = $(this).data("resource");
		var id = $(this).parent().parent().find('.user_number').text();
		var name = $(this).parent().parent().find('.user_name').text();
		data.id = id;
		ajaxForm(resource, "delete", data, "form")
		.done(function(result){
			if(result == 1){
				window.location.href = server + 'type_users';
				responseUI("Se inhabilito el tipo de usuario "+name+" .", "green");
			}
			else {
				responseUI("No se pueden grabar los datos.", "red");
				console.log(result);
			}
		})
		.fail(function(){
            responseUI("Error del servidor","red");
        });
	});

	$(document).on("click", "#btnEnabledTypeUser", function(e){
		e.preventDefault();
		var resource = $(this).data("resource");
		var id = $(this).parent().parent().find('.user_number').text();
		var name = $(this).parent().parent().find('.user_name').text();
		data.id = id;

		ajaxForm(resource, "put", data, "form", "restore")
		.done(function(result){
			if(result == 1){
				window.location.href = server + 'type_users';
				responseUI("Se habilito el tipo de usuario "+name+" .", "green");
			}
			else {
				responseUI("No se pueden grabar los datos.", "red");
				console.log(result);	
			}
		})
		.fail(function(){
            responseUI("Error del servidor","red");
        });
	});

	$(document).on("click", "#editTypeUser", function(e){
		e.preventDefault();
		var id = $(this).parent().parent().find('.user_number').text();
		var name = $(this).parent().parent().find('.user_name').text();
		var state = $(this).parent().parent().find('.user_state').text().toLowerCase();
		if(state==='inactivo'){
			state = "0";
		}else{
			state = "1";
		}
		$("#id_typeUser").val(id);
		$("#name_typeUser").val(name);
		$("#slcState_typeUser").val(state);
		$('#modalEditTypeUser').modal();
	});

	$(document).on("click", "#btnUpdateTypeUser", function(e){
		e.preventDefault();
		var resource = $(this).data("resource");
		var message = null;
		data.id = $("#id_typeUser").val();;
		data.name = $("#name_typeUser").val();
		data.state = $("#slcState_typeUser").val();
		$("#btnLaddaEdit").show();		
		var l = Ladda.create(document.getElementById('btnLaddaEdit'));
		l.start();
		$("#msgEdit").html('');
		ajaxForm(resource, "put", data)
		.done(function(result){
			l.stop();
			$("#btnLaddaEdit").hide();
			if(result == 1){
				message = "<p class='color-green'><span class='glyphicon glyphicon-ok'></span> Se actualizaron los datos correctamente.</p>";
				$("#msgEdit").html(message);
				$("#modalEditTypeUser").attr('data-success', "1")
			}
			else {
				message = "<p class='color-red'><span class='glyphicon glyphicon-remove'></span> No se pueden grabar los datos. "+ result.errors.name[0] +" </p>";
				$("#msgEdit").html(message);
				console.log(result);
			}
		})
		.fail(function(){
            l.stop();
            $("#btnLaddaEdit").hide();
            message = "<p class='color-red'><span class='glyphicon glyphicon-remove'></span> Error del servidor.</p>";
            $("#msgEdit").html(message);
        });
	});

	$(document).on("click", "#btnCreateTypeUser", function(e){
		e.preventDefault();
		var resource = $(this).data("resource");
		var message = null;
		data.name = $("#name_new_typeUser").val();
		data.state = $("#slcState_new_typeUser").val();
		$("#btnLaddaCreate").show();		
		var l = Ladda.create(document.getElementById('btnLaddaCreate'));
		l.start();
		$("#msgCreate").html('');
		ajaxForm(resource, "post", data)
		.done(function(result){
			l.stop();
			$("#btnLaddaCreate").hide();
			if(result == 1){
				message = "<p class='color-green'><span class='glyphicon glyphicon-ok'></span> Se registraron los datos correctamente.</p>";
				$("#msgCreate").html(message);
				$("#modalCreateTypeUser").attr('data-success', "1")
			}
			else {
				message = "<p class='color-red'><span class='glyphicon glyphicon-remove'></span> "+ result.errors.name[0] +"</p>";
				$("#msgCreate").html(message);
				console.log(result.errors.name[0]);
			}
		})
		.fail(function(){
            l.stop();
            $("#btnLaddaCreate").hide();
            message = "<p class='color-red'><span class='glyphicon glyphicon-remove'></span> Error del servidor.</p>";
            $("#msgEdit").html(message);
        });
	});

	$('#modalEditTypeUser').on('hidden.bs.modal', function (e) {
		if($(this).attr('data-success') === "1") window.location.href = server + 'type_users';
		$(this).attr('data-success', "0");
	});

	$('#modalCreateTypeUser').on('hidden.bs.modal', function (e) {
		if($(this).attr('data-success') === "1") window.location.href = server + 'type_users';
		$(this).attr('data-success', "0");
	});

	$('#modalEditTypeUser').on('show.bs.modal', function (e) {
		$("#msgEdit").html('');
	});
	
	$('#modalCreateTypeUser').on('show.bs.modal', function (e) {
		$("#name_new_typeUser").val('');
        $("#msgCreate").html('');
	});

	/* Iglesias */

	$(document).on("click", "#btnDisabledIglesia", function(e){
		e.preventDefault();
		var resource = $(this).data("resource");
		var id = $(this).parent().parent().find('.iglesia_number').text();
		var name = $(this).parent().parent().find('.iglesia_name').text();
		data.id = id;

		ajaxForm(resource, "delete", data, "form")
		.done(function(result){
			if(result == 1){
				window.location.href = server + 'iglesias';
				responseUI("Se inhabilito la "+name+" .", "green");
			}
			else {
				responseUI("No se pueden grabar los datos.", "red");
				console.log(result);
			}
		})
		.fail(function(){
            responseUI("Error del servidor","red");
        });
	});

	$(document).on("click", "#btnEnabledIglesia", function(e){
		e.preventDefault();
		var resource = $(this).data("resource");
		var id = $(this).parent().parent().find('.iglesia_number').text();
		var name = $(this).parent().parent().find('.iglesia_name').text();
		data.id = id;

		ajaxForm(resource, "put", data, "form", "restore")
		.done(function(result){
			if(result == 1){
				window.location.href = server + 'iglesias';
				responseUI("Se habilito la "+name+" .", "green");
			}
			else {
				responseUI("No se pueden grabar los datos.", "red");
				console.log(result);	
			}
		})
		.fail(function(){
            responseUI("Error del servidor","red");
        });
	});

	$(document).on("click", "#editIglesia", function(e){
		e.preventDefault();
		var id = $(this).parent().parent().find('.iglesia_number').text();
		var name = $(this).parent().parent().find('.iglesia_name').text();
		var address = $(this).parent().parent().find('.iglesia_address').text();
		var phone = $(this).parent().parent().find('.iglesia_phone').text();
		var state = $(this).parent().parent().find('.iglesia_state').text().toLowerCase();
		if(state==='inactivo'){
			state = "0";
		}else{
			state = "1";
		}
		$("#id_iglesia").val(id);
		$("#name_iglesia").val(name);
		$("#address_iglesia").val(address);
		$("#phone_iglesia").val(phone);
		$("#slcState_iglesia").val(state);
		$('#modalEditIglesia').modal();
	});

	$(document).on("click", "#btnUpdateIglesia", function(e){
		e.preventDefault();
		var resource = $(this).data("resource");
		var message = null;
		data.id = $("#id_iglesia").val();;
		data.name = $("#name_iglesia").val();
		data.address = $("#address_iglesia").val();
		data.phone = $("#phone_iglesia").val();
		data.state = $("#slcState_iglesia").val();
		$("#btnLaddaEdit").show();		
		var l = Ladda.create(document.getElementById('btnLaddaEdit'));
		l.start();
		$("#msgEdit").html('');
		ajaxForm(resource, "put", data)
		.done(function(result){
			l.stop();
			$("#btnLaddaEdit").hide();
			if(result == 1){
				message = "<p class='color-green'><span class='glyphicon glyphicon-ok'></span> Se actualizaron los datos correctamente.</p>";
				$("#msgEdit").html(message);
				$("#modalEditIglesia").attr('data-success', "1")
			}
			else {
				message = "<p class='color-red'><span class='glyphicon glyphicon-remove'></span> No se pueden grabar los datos.";
                $.each(result.errors, function(){
                    message += " " + this + ".";
                });
                message += "</p>";
				$("#msgEdit").html(message);
				console.log(result);
			}
		})
		.fail(function(){
            l.stop();
            $("#btnLaddaEdit").hide();
            message = "<p class='color-red'><span class='glyphicon glyphicon-remove'></span> Error del servidor.</p>";
            $("#msgEdit").html(message);
        });
	});

	$(document).on("click", "#btnCreateIglesia", function(e){
		e.preventDefault();
		var resource = $(this).data("resource");
		var message = null;
		data.name = $("#name_new_iglesia").val();
		data.address = $("#address_new_iglesia").val();
		data.phone = $("#phone_new_iglesia").val();
		data.state = $("#slcState_new_iglesia").val();
		$("#btnLaddaCreate").show();		
		var l = Ladda.create(document.getElementById('btnLaddaCreate'));
		l.start();
		$("#msgCreate").html('');
		ajaxForm(resource, "post", data)
		.done(function(result){
			l.stop();
			$("#btnLaddaCreate").hide();
			if(result == 1){
				message = "<p class='color-green'><span class='glyphicon glyphicon-ok'></span> Se registraron los datos correctamente.</p>";
				$("#msgCreate").html(message);
				$("#modalCreateIglesia").attr('data-success', "1")
			}
			else {
				message = "<p class='color-red'><span class='glyphicon glyphicon-remove'></span> No se pueden grabar los datos.";
                $.each(result.errors, function(){
                    message += " " + this + ".";
                });
                message += "</p>";
                $("#msgCreate").html(message);
                console.log(result);
			}
		})
		.fail(function(){
            l.stop();
            $("#btnLaddaCreate").hide();
            message = "<p class='color-red'><span class='glyphicon glyphicon-remove'></span> Error del servidor.</p>";
            $("#msgEdit").html(message);
        });
	});

	$('#modalEditIglesia').on('hidden.bs.modal', function (e) {
		if($(this).attr('data-success') === "1") window.location.href = server + 'iglesias';
		$(this).attr('data-success', "0");
	});

	$('#modalCreateIglesia').on('hidden.bs.modal', function (e) {
		if($(this).attr('data-success') === "1") window.location.href = server + 'iglesias';
		$(this).attr('data-success', "0");
	});

	$('#modalEditIglesia').on('show.bs.modal', function (e) {
		$("#msgEdit").html('');
	});
	
	$('#modalCreateIglesia').on('show.bs.modal', function (e) {
		$("#name_new_typeUser").val('');
		$("#name_new_iglesia").val('');
		$("#address_new_iglesia").val('');
		$("#phone_new_iglesia").val('');
		$("#slcState_new_iglesia").val('0');
        $("#msgCreate").html('');
	});
	$('.number').on('blur', function(e){
		var that = $(this);
		var total = calculateBalance();
		var balance = parseFloat($('.balance').text().replace(/,/g, ''));
		if(total <= balance){
			if(total == balance)
			{
				$('#sendTotal').attr('disabled', false);
			}
			balance -= total;
			$('.balance_in').text(balance);
		}else{
			alert("No puede registrar más saldo con lo que ya cuenta");
			that.val('');
		}
	});

	var calculateBalance = function(){
		var total = 0;
		$('.number').each(function(index, el) {
			var number = parseFloat($(this).val());
			if( ! isNaN(number) && number > 0 ){
				total += number;
			}
		});
		return total;
	};
	dataTable('#type_fix', 'tipos fijos');

	if($('.select2').exists()){
		$('.select2').select2();
	}
});
