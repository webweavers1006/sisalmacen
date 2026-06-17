
$('.custom-range').ionRangeSlider({
	step:1,
	prettify: true,
});

$("#aprobar-orden").on("submit", function(e){
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
		text: "¿Está seguro de aprobar la orden?",
		showCancelButton  : true,
		confirmButtonColor: '#3085d6',
		cancelButtonColor : '#d33',
		confirmButtonText : 'Aprobar',
		cancelButtonText  : 'Cancelar'
	}).then((result) => {
		if (result.value) {
			$.ajax({
				url:'/nuevaorden',
				method:"POST",
				data: {"data" : btoa(JSON.stringify(data))},
				dataType: "JSON",
			}).then(function(response){
				Swal.fire({ 
					title: '¡Exito!', 
					text: 'Orden Aprobada Exitosamente', 
					icon: 'success', 
					confirmButtonText: 'Aceptar',
					preConfirm: function(data){
						window.location = "/listarequisiciones";
					}
				});

			}).catch(function(request){
				Swal.fire({ title: '¡Error!', text: 'Orden ya aprobada', icon: 'Error', confirmButtonText: 'Aceptar'});
			});
		}
		else{
			Swal.fire('Atencion', 'No se ha aprobado la orden','warning');
		}
	});
	
	$("button[type=submit]").removeAttr('disabled');
});