$('.custom-range').ionRangeSlider({
	step:1,
	prettify: true,
});

//Evento para el envio del formulario
$("#nuevo-requerimiento").on('submit', (e) => {
	e.preventDefault();
	//Arreglo para los id de los items
	let items = [];
	//Obtenemos toda la data del form
	let form = $("#nuevo-requerimiento").serialize().split("&");
	//numero del requerimiento
	let num_requerimiento = "";
	//Usuario que lo solicita
	let ususol = "";
	//Recorremos el form
	for(i = 0; i < form.length; i++){
		let buff = form[i].split("=");
		if(i === 0){
			num_requerimiento = buff[1];
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
		"num_req"  : num_requerimiento,
		"ususol"   : ususol,
		"items"    : items,
	};
	//Hacemos la solicitud AJAX
	Swal.fire({
		title: 'Confirmacion',
		text: "¿Está seguro de aprobar este requerimiento?",
		showCancelButton  : true,
		confirmButtonColor: '#3085d6',
		cancelButtonColor : '#d33',
		confirmButtonText : 'Aprobar',
		cancelButtonText  : 'Cancelar'
	}).then((result) => {
		if (result.value) {
			$.ajax({
				url:'/newreq',
				method:"POST",
				data: {"data" : btoa(JSON.stringify(data))},
				dataType: "JSON",
			}).then(function(response){
				Swal.fire({ 
					title: '¡Exito!', 
					text: 'Requerimiento aprobado exitosamente', 
					icon: 'success', 
					confirmButtonText: 'Aceptar',
					preConfirm: function(data){
						window.location = "/lista-requerimientos";
					}
				});

			}).catch(function(request){
				Swal.fire({ title: '¡Error!', text: 'Requerimiento ya aprobado', icon: 'Error', confirmButtonText: 'Aceptar'});
			});
		}
		else{
			Swal.fire('Atencion', 'El requerimiento no se ha aprobado','warning');
		}
	});
})