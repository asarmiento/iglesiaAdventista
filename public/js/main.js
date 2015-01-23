var ajaxForm = function (resource, type, data, method){
	var action = '';
	var url= server + resource;
	console.log(type, resource, data);
	if(type==='delete' || type==='put') {
		url += '/' + data.id;
	}
	if(method==='restore') {
		url += '/restore/' + data.id;
	}
	console.log(url);
	return $.ajax({
			url: url,
		    type: type,
		    data: {data: data},
		    datatype: 'json',
		    beforeSend: function(){
		        console.log('Registrando');
		    },
		    error:function(){
		        console.log("No se pueden grabar los datos.");
		    }
		});
};

var data = {};
var server = 'http://localhost/iglesiaQuepos/public/';

$(function(){

	$(document).on("click", "#btnDisabledTypeUser", function(e){
		e.preventDefault();
		var resource = $(this).data("resource");
		var id = $(this).parent().parent().find('.user_number').text();
		data.id = id;
		ajaxForm(resource, "delete", data)
		.done(function(result){
			if(result == 1){
				window.location.href = server + 'type_users';
			}
			else {
				console.log(result);	
			}
		});
	});

	$(document).on("click", "#btnEnabledTypeUser", function(e){
		e.preventDefault();
		var resource = $(this).data("resource");
		var id = $(this).parent().parent().find('.user_number').text();
		data.id = id;
		ajaxForm(resource, "put", data, "restore")
		.done(function(result){
			if(result == 1){
				window.location.href = server + 'type_users';
			}
			else {
				console.log(result);	
			}
		});
	});

	$(document).on("click", "#editTypeUser", function(e){
		e.preventDefault();
		var id = $(this).parent().parent().find('.user_number').text();
		var state = $(this).parent().parent().find('.user_state').text().toLowerCase();
		var name = $(this).parent().parent().find('.user_name').text();
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
		data.id = $("#id_typeUser").val();;
		data.name = $("#name_typeUser").val();
		data.state = $("#slcState_typeUser").val();

		ajaxForm(resource, "put", data)
		.done(function(result){
			if(result == 1){
				window.location.href = server + 'type_users';
			}
			else {
				console.log(result);	
			}
		});
	});

	$(document).on("click", "#btnCreateTypeUser", function(e){
		e.preventDefault();
		var resource = $(this).data("resource");
		data.name = $("#name_new_typeUser").val();
		data.state = $("#slcState_new_typeUser").val();

		ajaxForm(resource, "post", data)
		.done(function(result){
			if(result == 1){
				window.location.href = server + 'type_users';
			}
			else {
				console.log(result);	
			}
		});
	});

	/*$('#modalEditTypeUser').on('hidden.bs.modal', function (e) {
		window.location.href = server + "type_users";
	})*/
});
