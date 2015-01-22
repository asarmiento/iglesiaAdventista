var ajaxForm = function (resource, type, data){
	var server = 'http://localhost/iglesiaQuepos/public/';
	console.log(type, resource, data);
	return $.ajax({
			url: server + resource + '/' +data.id,
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

$(function(){
	$(document).on("click", "#btnRemoveTypeUser", function(e){
		e.preventDefault();
		var resource = $(this).data("resource");
		var id = $(this).parent().parent().find('.user_number').text();
		data.id = id;
		console.log(data)
		ajaxForm(resource, "delete", data)
		.done(function(result){
			console.log(result);
		});
	});
});
