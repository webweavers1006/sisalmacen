
/* Roles */
let roles = [];

/*Evento que busca el valor en la tabla y lo agrega o elimina segun el caso */
$(document).on('change', 'input[name=rolval]', function(){
	if($(this).is(':checked')){
		roles.push($(this).val());
	}
	else{
		roles.removeItem($(this).val());
	}
	if(roles.length > 1){
		Swal.fire('Atencion!', 'Solo debe seleccionar un registro', 'warning');
		$(this).attr(':unchecked');
	}
});


/*Para editar un registro en direcciones*/
$(document).on('click', '.roledit', function(e){
	e.preventDefault();
	if(roles.length < 1){
		Swal.fire("Atencion", "Debe seleccionar un registro", 'warning');
	}
	else if(roles.length > 1){
		Swal.fire("Atencion", "Debe seleccionar solo un registro", 'warning');	
	}
	else{
		var id = roles[0];
		$.ajax({
			url:'/roles/'+id,
			method:'GET',
			dataType:'JSON',
			beforeSend:function(){
				$("button[type=submit]").addClass('disabled');
			},
			success:function(response){
				switch(response.status){
					case 200:
						$("#rolid").val(response.data.rolid);
						$("#rolnom").val(response.data.rolnom);
						$("#addrol").modal('show');
						roles.pop();
						$("button[type=submit]").removeClass('disabled');
					break;
					default:
						Swal.fire("Atencion", "Hubo un error al realizar la operacion", 'warning');
					break;
				}
			}
		});
	}
});

/*Para borrar un registro de direcciones*/
$(document).on('click', '.roldel', function(e){
	if(roles.length < 1){
		Swal.fire("Atencion", "Debe seleccionar un registro", 'warning');
	}
	else if(roles.length > 1){
		Swal.fire("Atencion", "Debe seleccionar solo un registro", 'warning');	
	}
	else{
		e.preventDefault();
		let id = roles[0];
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
					url:'/roles/'+id,
					method:'DELETE',
					dataType:'JSON',
					beforeSend:function(){
						$("button[type=submit]").addClass('disabled');
					},
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
		roles.pop();
	}
});

/*Evento de carga para el form de las direcciones*/
$(document).on('submit', '#rolform',function(e){
	e.preventDefault();
	var datos = {
		'rolid'  : $("#rolid").val(),
		'rolnom' : $("#rolnom").val(),
	}
	var request = btoa(JSON.stringify(datos));
	$.ajax({
		url:'/roles',
		method:'POST',
		data: {data : request},
		dataType:'JSON',
		beforeSend:function(){
			$("button[type=submit]").addClass('disabled');
		},
		success:function(response){
			switch(response.status){
				case 200:
					Swal.fire('Exito!','Operacion realizada exitosamente','success');
					$("#addrol").modal('hide');
					load_data();
					$("#rolid").val('');
					$("button[type=submit]").removeClass('disabled');
					break;
				default:
					load_data();
					$("button[type=submit]").removeClass('disabled');
					break;
			}
		}
	});
});