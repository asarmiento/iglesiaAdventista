var ajaxForm = function (resource, type, data, method){
	var action = '';
	var url= '';
	console.log(type, resource, data);
	if(type==='delete') {
		url = server + resource + '/' + data.id;
	}
	if(method==='restore') {
		url = server + resource + '/restore/' + data.id;
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
		ajaxForm(resource, "delte", data)
		.done(function(result){
			console.log(result);
		});
	});

	$(document).on("click", "#btnEnabledTypeUser", function(e){
		e.preventDefault();
		var resource = $(this).data("resource");
		var id = $(this).parent().parent().find('.user_number').text();
		data.id = id;
		ajaxForm(resource, "put", data, "restore")
		.done(function(result){
			console.log(result);
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
		console.log(name);
		$("#name_typeUser").val(name);
		$("#slcState_typeUser").val(state);
		$("#id_typeUser").val(id);
		$('#modalEditTypeUser').modal();
	});

	$('#modalEditTypeUser').on('hidden.bs.modal', function (e) {
		window.location.href = server + "type_users";
	})
});
