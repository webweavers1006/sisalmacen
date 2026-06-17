$(".add-detail").on('click', function(e){
	e.preventDefault();
	let codbar = $(this).attr('id');
	$("#codbar").val(codbar);
	$("#modal-detalle").modal('show');
});

$(".cancelar").on('click', function(e){
	e.preventDefault();
	$("#add-preorden-detalle")[0].reset();
});

$("#add-preorden-detalle").on('submit', function(e){
	e.preventDefault();
	var datos = {
		"codbar"  : $("#codbar").val(),
		"numorden": $("#numorden").val(),
		"numuni"  : $("#cantprod").val() 
	}
	$.ajax({
		url:'/addpreorddet',
		method:'POST',
		data : {data : btoa(JSON.stringify(datos))},
		beforeSend: function(){
			$("button[type=submit]").attr('disabled');
		},
		success: function(response){
			$("#add-preorden-detalle")[0].reset();
			$("#modal-detalle").modal('hide');
		},
		error: function(request){
			Swal.fire('Error', 'Ha ocurrido un error', 'error');
		}
	});
});


$(document).on('click','.eliminar', function(e){
	e.preventDefault();
	let itemid = $(this).attr('id');
	let numorden = $("#numorden").val();
	Swal.fire({
			title: '¿Esta seguro de este item?',
			text: "Esta Accion no se puede deshacer",
			icon: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Aceptar',
			cancelButtonText:'Cancelar',
		}).then((result) => {
			if (result.value) {
				$.ajax({
					url:'/eliminaritem',
					method:'POST',
					data: {data : btoa(JSON.stringify({itemid : itemid, numorden : numorden}))},
					dataType:'JSON',
					success:function(response){
						console.log(response);
						$("#detalles").html(response.data);
					}
				});
				Swal.fire("Exito", "Operacion completada exitosamente",'success');
			}
		});
})
