/* Direcciones */
let direcciones = [];
/*Evento que busca el valor en la tabla y lo agrega o elimina segun el caso */
$(document).on('change', 'input[name=dirval]', function(){
	if($(this).is(':checked')){
		direcciones.push($(this).val());
		console.log(direcciones.length);
	}
	else{
		direcciones.removeItem($(this).val());
	}
});


/*Para editar un registro en direcciones*/
$(document).on('click', '.diredit', function(e){
	e.preventDefault();
	if(direcciones.length > 1){
		Swal.fire('Atencion!', 'Solo debe seleccionar un registro', 'warning');
	}
	else if(direcciones.length < 1){
		Swal.fire('Atencion!', 'Debe seleccionar un registro', 'warning');	
	}
	else{
		var id = direcciones[0];
		$.ajax({
			url:'/direcciones/'+id,
			method:'GET',
			dataType:'JSON',
			beforeSend:function(){
				$("button[type=submit]").addClass('disabled');
			},
			success:function(response){
				switch(response.status){
					case 200:
						$("#iddir").val(response.data.dirid);
						$("#nomdir").val(response.data.dirnom);
						$("#adddir").modal('show');
						direcciones.pop();
						$("button[type=submit]").removeClass('disabled');
					break;
					default:
						Swal.fire("Atencion", "Hubo un error al realizar la operacion", 'warning');
						$("button[type=submit]").removeClass('disabled');
					break;
				}
			}
		});
	}
});

/*Para borrar un registro de direcciones*/
$(document).on('click', '.dirdel', function(e){
	e.preventDefault();
	if(direcciones.length > 1){
		Swal.fire('Atencion!', 'Solo debe seleccionar un registro', 'warning');
	}
	else if(direcciones.length < 1){
		Swal.fire('Atencion!', 'Debe seleccionar un registro', 'warning');	
	}
	else{
		let id = direcciones[0];
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
					url:'/direcciones/'+id,
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
		direcciones.pop();
	}
});

/*Evento de carga para el form de las direcciones*/
$(document).on('submit', '#dirform',function(e){
	e.preventDefault();
	var datos = {
		'iddireccion'  : $("#iddir").val(),
		'nomdireccion' : $("#nomdir").val(),
	}
	var request = btoa(JSON.stringify(datos));
	$.ajax({
		url:'/direcciones',
		method:'POST',
		data: {data : request},
		dataType:'JSON',
		beforeSend:function(){
			$("button[type=submit]").addClass('disabled');
		},
		success:function(response){
			$("button[type=submit]").removeClass('disabled');
			switch(response.status){
				case 200:
					Swal.fire('Exito!','Operacion realizada exitosamente','success');
					$("#adddir").modal('hide');
					load_data();
					$("#iddir").val('');
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