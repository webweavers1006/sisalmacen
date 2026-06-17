$('.custom-range').ionRangeSlider({
	step:1,
	prettify: true,
});

//Evento para anular la orden
$("#anular").on('click', function(e){
	e.preventDefault();
	Swal.fire({
		title: 'Confirmacion',
		text: "¿Está seguro de anular esta orden?",
		icon: 'warning',
		showCancelButton: true,
		confirmButtonColor: '#3085d6',
		cancelButtonColor: '#d33',
		confirmButtonText: 'Aceptar',
		cancelButtonText: "Cancelar",
	}).then((result) => {
		if (result.value) {
			$.ajax({
				url:"/anular-orden",
				method:"POST",
				dataType:"JSON",
				data:{"data": btoa(JSON.stringify({"numorden" : $("#numorden").val()}))}
			}).then((response) => {
				Swal.fire("Exito", "Orden Anulada", "success");
				window.location = history.back();
			}).catch((request) => {
				Swal.fire("Error", "Ha ocurrido un error", "error");
			});
		}
	});
});


//Evento para actualizar una orden
$("#editar-orden").on('submit', function(e){
	e.preventDefault();
	//Arreglo para los id de los items
	let items = [];
	//Obtenemos toda la data del form
	let form = $(this).serialize().split("&");
	//Numero de orden
	let numorden = "";
	//Usuario que lo solicita
	let ususol = "";
	//Recorremos el form
	for(i = 0; i < form.length; i++){
		let buff = form[i].split("=");
		if(i === 0){
			numorden = buff[1];
		}
		else if(i === 1){
			ususol = buff[1];
		}
		else{
			items.push({itemid: buff[0], numuniap: buff[1]});
		}
	}
	//Objeto para convertir en JSON en la solicitud AJAX
	let data = {
		"numorden" : numorden,
		"ususol"   : ususol,
		"items"    : items,
	};
	//Hacemos la solicitud AJAX
	Swal.fire({
		title: 'Confirmacion',
		text: "¿Está seguro de actualizar esta orden?",
		showCancelButton  : true,
		confirmButtonColor: '#3085d6',
		cancelButtonColor : '#d33',
		confirmButtonText : 'Actualizar',
		cancelButtonText  : 'Cancelar'
	}).then((result) => {
		if (result.value) {
			$.ajax({
				url:'/actualizarOrden',
				method:"POST",
				data: {"data" : btoa(JSON.stringify(data))},
				dataType: "JSON",
			}).then(function(response){
				Swal.fire({ 
					title: '¡Exito!', 
					text: 'Orden Actualizada Exitosamente', 
					icon: 'success', 
					confirmButtonText: 'Aceptar',
					preConfirm: function(data){
						window.location = history.back();
					}
				});

			}).catch(function(request){
				Swal.fire({ title: '¡Error!', text: 'Ha ocurrido un error', icon: 'Error', confirmButtonText: 'Aceptar'});
			});
		}
		else{
			Swal.fire('Atencion', 'No se ha aprobado la orden','warning');
		}
	});
});