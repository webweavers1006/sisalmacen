function cargarUsuarios(){
	$.ajax({
		url:'/usuarios',
		method:"GET",
		dataType:'JSON',
		success:function(response){
			let table = '';
			switch(response.status){
				case 200:
					/*Ponemos los select donde corresponda*/
					for(let i = 0; i<response.data.length; i++){
						let row = response.data[i];
						table = table + `<option value="${row[0]}">${row[1]} ${row[3]}</option>`;
					}
					$("#usuario-consulta").html(table);
					break;
					case 404:
						/*Creamos la tabla para las direcciones*/
						table = `<option>No hay usuarios registrados</option>`;
						$("#usuario-consulta").html(table);
					break;
			}
		}
	});
}

//Evento para la consulta de los reportes pór usuario en pantalla
$(document).on('submit', "#consulta-usuario", function(e){
	e.preventDefault();
	let datos = {
		'tipo_consulta' : $("#tipo-consulta").val(),
		'usuario_consulta': $("#usuario-consulta").val()
	}
	$.ajax({
		url:"/consultausuario",
		method:"POST",
		dataType:"JSON",
		data:{data: btoa(JSON.stringify(datos))}
	}).then(function(response){
		$("#tipo-reporte").val(datos.tipo_consulta);
		$("#usuario-reporte").val(datos.usuario_consulta);
		$("#detalles").show();
		$("#detalles-consulta").html(response.data);
	}).catch(function(request){
		Swal.fire("Error", "Ha ocurrido un error", 'error');
	});
});

//E



//Evento para la generacion en PDF del reporte
/*$(document).on('submit', "#generar-reporte", function(e){
	e.preventDefault();
	let datos = {
		'tipo_reporte': $("#tipo-reporte").val(),
		'usuario_reporte': $("#usuario-reporte").val(),
	}
	//abre una nueva pestaña para generar el pdf
	window.open("/generareporte/3?q="+btoa(JSON.stringify(datos)), "_blank");
});
*/

$(document).ready(function(){
	$("#detalles").hide();
	cargarUsuarios();
});