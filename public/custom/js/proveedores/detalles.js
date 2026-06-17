$(document).on('click', '.detalles', function(){
	let id = $(this).attr('id');
	$.ajax({
		url:'/detalleproveedor',
		method:'POST',
		dataType:'JSON',
		data: {data: id},
		success:function(response){
			$("#detdirecc").val(response.data.direccprov);
			$("#detemail").val(response.data.contemail);
			$("#detalleProveedor").modal('show');
		},
		error:function(request){
			Swal.fire('error', response.message, 'error');
		}
	});
});

$(document).on('click', '.editar', function(){
	let id = $(this).attr('id');
	$.ajax({
		url:'/detalleproveedor',
		method:'POST',
		dataType:'JSON',
		data: {data: id},
		success:function(response){
			$("#idprov").val(id);
			$("#tipoper").val(response.data.rifprov.substr(0,1));
			$("#numrif").val(response.data.rifprov.substr(1));
			$("#nomprov").val(response.data.nomprov);
			$("#direccprov").val(response.data.direccprov);
			$("#contemail").val(response.data.contemail);
			$("#telef1").val(response.data.telef1);
			$("#telef2").val(response.data.telef2);
			$("#editarProveedor").modal('show');
		},
		error:function(request){
			Swal.fire('error', response.message, 'error');
		}
	});
});


/*Para enviar el formulario de edicion*/
$(document).on('submit', '#editProvider', function(e){
	e.preventDefault();
	var form = {
		idprov     : String($("#idprov").val()),
		numrif     : String($("#tipoper").val()+$("#numrif").val()),
		nomprov    : String($("#nomprov").val()),
		direccprov : String($("#direccprov").val()),
		telef1     : String($("#telef1").val()),
		telef2     : String($("#telef2").val()),
		email      : String($("#contemail").val())
	};
	$.ajax({
		url:'/editarproveedor',
		method:'POST',
		data: {data: btoa(JSON.stringify(form))},
		dataType:'JSON',
		beforeSend:function(){
			$("button[type=submit").attr('disabled', 'true');
		},
		success:function(response){
			$("#editarProveedor").modal('hide');
		},
		error:function(request){
			Swal.fire('Error!', request.responseJSON.message, 'error');

		}
	});
	$("button[type=submit").removeAttr('disabled');
});