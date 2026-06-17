/*Para enviar el formulario de registro*/
$(document).on('submit', '#newProvider', function(e){
	e.preventDefault();
	var form = {
		numrif     : String($("#tipoper").val()+$("#numrif").val()),
		nomprov    : String($("#nomprov").val()),
		direccprov : String($("#direccprov").val()),
		telef1     : String($("#telef1").val()),
		telef2     : String($("#telef2").val()),
		email      : String($("#contemail").val())
	};
	$.ajax({
		contentType: 'application/x-www-form-urlencoded; charset=UTF-8',
		url:'/nuevoproveedor',
		method:'POST',
		data: {data: btoa(JSON.stringify(form))},
		dataType:'JSON',
		beforeSend:function(){
			$("button[type=submit").attr('disabled', 'true');
		},
		success:function(response){
			window.location = '/consultaproveedor';
		},
		error:function(request){
			Swal.fire('Error!', request.responseJSON.message, 'error');

		}
	});
	$("button[type=submit").removeAttr('disabled');
});

