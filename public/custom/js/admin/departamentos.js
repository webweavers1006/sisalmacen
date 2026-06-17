/* Direcciones */
let departamentos = [];
/*Evento que busca el valor en la tabla y lo agrega o elimina segun el caso */
$(document).on('change', 'input[name=deptval]', function(){
	if($(this).is(':checked')){
		departamentos.push($(this).val());
	}
	else{
		departamentos.removeItem($(this).val());
	}
});
 /*Evento cuando se registra un departamento*/
 $(document).on('submit', "#depform", function(e){
 	$(this).attr('disabled');
 	e.preventDefault();
 	let datos = {
 		depid : $("#depid").val(),
 		depnom : $("#nomdep").val(),
 		dirid: $("#depdir").val(),
 	}
 	let request = btoa(JSON.stringify(datos));
 	create(request, '/departamentos', '#depid', "#adddep");
});

/*Para editar un registro*/
$(document).on('click', '.depedit', function(e){
	e.preventDefault();
	if(departamentos.length > 1){
		Swal.fire('Atencion!', 'Solo debe seleccionar un registro', 'warning');
	}
	else if(departamentos.length < 1){
		Swal.fire('Atencion!', 'Debe seleccionar un registro', 'warning');	
	}
	else{
		var id = departamentos[0];
		$.ajax({
			url:'/departamentos/'+id,
			method:'GET',
			dataType:'JSON',
			beforeSend:function(){
				$("button[type=submit]").addClass('disabled');
			},
			success:function(response){
				switch(response.status){
					case 200:
						$("#depid").val(response.data.depid);
						$("#nomdep").val(response.data.depnom);
						$("#depdir").val(response.data.dirid);
						$("#adddep").modal('show');
						departamentos.pop();
						$("button[type=submit]").removeClass('disabled');
					break;
					default:
						Swal.fire('Error!','No encontrado', 'error');
						$("button[type=submit]").removeClass('disabled');
					break;
				}
			}
		});
	}
});

/*Para borrar un registro de direcciones*/
$(document).on('click', '.depdel', function(e){
	e.preventDefault();
	if(departamentos.length > 1){
		Swal.fire('Atencion!', 'Solo debe seleccionar un registro', 'warning');
	}
	else if(departamentos.length < 1){
		Swal.fire('Atencion!', 'Debe seleccionar un registro', 'warning');	
	}
	else{
		let id = departamentos[0];
		Swal.fire({
			title: '¿Esta seguro de eliminar este registro?',
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
					url:'/departamentos/'+id,
					method:'DELETE',
					dataType:'JSON',
					success:function(response){
						if(response.status == 200){
							load_data();
							$("button[type=submit]").removeClass('disabled');
						}
					}
				});
				Swal.fire("Exito", "Operacion completada exitosamente",'success');
			}
		});
		departamentos.pop();
	}
});