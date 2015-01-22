var ajaxForm = function (resource, type, data){
	var server = 'http://localhost/iglesiaQuepos/public/';
	console.log(type, resource, data);
	$.ajax({
		url: server + resource + '/' +data,
        type: type,
        data: data,
        beforeSend: function(){
            console.log('Registrando');
        },
        error:function(){
            console.log("No se pueden grabar los datos.");
        }
	});
};

$(function(){
	$(document).on("click", "#btnRemoveTypeUser", function(e){
		e.preventDefault();
		var resource = $(this).data("resource");
		var data = $(this).parent().parent().find('.user_number').text();
		ajaxForm(resource, "delete", data);
	});
});
