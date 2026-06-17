$("#aprueba-despacho").on('submit', function(e){
	e.preventDefault();
	Swal.fire({
		title: 'Añadir comentario adicional',
		input: 'text',
		inputAttributes: {
			autocapitalize: 'on'
		},
		showCancelButton: true,
		confirmButtonText: 'Confirmar',
		showLoaderOnConfirm: true,
		cancelButtonText: "Cancelar",
		preConfirm: (comment) => {
			let datos = {
				"numorden" : $("#numorden").val(),
				"depdest" : $("#deptdest").val(),
				"commsal"  : comment,
			};
			$.ajax({
				url:"/registrarsalida",
				method:"POST",
				data:{"data" : btoa(JSON.stringify(datos))},
				dataType: "JSON",
			}).then((response) => {
				Swal.fire({
					title:"Exito",
					showCancelButton: false,
					html:"<p>Despacho aprobado exitosamente</p>",
					confirmButtonText:"Aceptar",
					preConfirm : (comment) => {
						if(comment){
							window.location = "/despachos";
						}
					}
				});
			}).catch((request) => {
				Swal.fire("Error", response.message, "error");
			});
		}
	});
})