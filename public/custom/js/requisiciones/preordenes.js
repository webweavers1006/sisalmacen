//Funcion para obtener los detalles de la preorden al vuelo
function refreshCheckout(){
	let datos = {
		"numorden": $("#numorden").val()
	}
	$.ajax({
		url:"/detallesPreordenes",
		method:"POST",
		data: {
			data: btoa(JSON.stringify(datos))
		},
	}).then(function(response){
		$("#detalle-preorden").html(response.data);
	}).catch(function(request){
		Swal.fire("Atencion", request.message, "warning");
	});
}

//Evento para añadir detalles a la preorden
$(document).on('click',".add-detail" ,function(e){
	e.preventDefault();
	let codbar = $(this).attr('id');
	$("#codbar").val(codbar);
	$("#modal-detalle").modal('show');
});

//Evento para resetear todo
$(".cancelar").on('click', function(e){
	e.preventDefault();
	$("#add-preorden-detalle")[0].reset();
});

//Añadir items a la orden
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
			refreshCheckout();
			$("#modal-detalle").modal('hide');
		},
		error: function(request){
			Swal.fire('Error', 'Ha ocurrido un error', 'error');
		}
	});
});

//Elimina items de la preorden
$(document).on('click','.eliminar', function(e){
	e.preventDefault();
	let itemid = $(this).attr('id');
	let numorden = $("#numorden").val();
	Swal.fire({
			title: '¿Esta seguro de eliminar este item?',
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
						refreshCheckout();
					}
				});
				Swal.fire("Exito", "Operacion completada exitosamente",'success');
			}
		});
});
