$(document).ready(function(){
	$("#grafico").hide();
	llenar_categoria(Event);
})


 //FUNCION PARA LLENAR EL COMBO DE CATEGORIAS
 function llenar_categoria(e, id_categoria) {
    e.preventDefault;
    url = '/listar_categorias';
    $.ajax({
        url: url,
        method: 'GET',
        //data:{data:btoa(unescape(encodeURIComponent(JSON.stringify(data))))},
        dataType: 'JSON',
        beforeSend: function(data) {},
        success: function(data) {

            if (data.length >= 1) {
                $('#categoria').empty();
                $('#categoria').append('<option value=0>Seleccione</option>');
                if (id_categoria === undefined) {
                    $.each(data, function(i, item) {
                        //console.log(data)
                        $('#categoria').append('<option value=' + item.id + '>' + item.descripcion + '</option>');

                    });
                } else {
                    $.each(data, function(i, item) {
                        if (item.id === id_categoria) {
                            $('#categoria').append('<option value=' + item.id + ' selected>' + item.descripcion + '</option>');
                           
                        } else {
                            $('#categoria').append('<option value=' + item.id + '>' + item.descripcion + '</option>');
                            
                        }
                    });
                }
            }
        },
        error: function(xhr, status, errorThrown) {
            alert(xhr.status);
            alert(errorThrown);
        }
    });
}

//Inicializando calendario
$("#rango-consulta").on('focus', function(e) {
	e.preventDefault();
	$("#rango-consulta").daterangepicker({
		showDropdowns: true,
		maxDate: fecha(),
		locale: {
			format: 'DD/MM/YYYY',
			daysOfWeek: [
				"Do",
				"Lu",
				"Ma",
				"Mi",
				"Ju",
				"Vi",
				"Sa"
			],
			monthNames: [
				"Enero",
				"Febrero",
				"Marzo",
				"Abril",
				"Mayo",
				"Junio",
				"Julio",
				"Agosto",
				"Septiembre",
				"Octubre",
				"Noviembre",
				"Diciembre"
			]
		}
	});
});

// $(document).on('change', '#tipo-operacion', function(e) {
//     let mode= $('#tipo-operacion option:selected').val();
//    if (mode=='3') {
// 	$("#grafico").hide();
//    }

// });

//Evento de envio de formulario al controlador
$(document).on('submit', "#consulta-articulos", function(e) {
	e.preventDefault();
	
	let id_categoria= $('#categoria').val();
	let desde                =$('#desde').val();
	let hasta                =$('#hasta').val();
	if (desde=='') 
	{
		desde='null' 
	}
	 if (hasta=='') 
	{
		hasta='null' 
	}
	if (hasta=='null'&&desde=='null') 
	{
		alert('DEDE INDICAR UN RANGO DE FECHA');
	} 
	else if (desde=='null'&&hasta!='null') 
	{
		alert('DEDE INDICAR EL CAMPO DESDE');
		
	}
	else if (hasta=='null'&&desde!='null') 
	{
		alert('DEDE INDICAR EL CAMPO HASTA');
	} 
	else if (hasta<desde) {
	  alert('EL CAMPO DESDE ES MAYOR AL CAMPO HASTA')
	}else{
  
	
	let datos = {
		"date_init" : desde,
		"date_end"  : hasta,
		"mode"      : $("#tipo-operacion").val()
	}
	let modo =$("#tipo-operacion").val();
	let accion='';
	if (modo=='1') {
		accion='RelacionEntradas';						
	}
	else if (modo=='2') {
		accion='RelacionSalidas';						
	}
	else if (modo=='3') {
		accion='RelacionEntradas-Salidas';						
	}

	
	let fecha_desde = desde;
	let partesFecha = fecha_desde.split("-");
	let dataFormatada_desde = partesFecha[2] + "-" + partesFecha[1] + "-" + partesFecha[0];
	
	let fecha_hasta = hasta;
	let partesFecha_ = fecha_hasta.split("-");
	let dataFormatada_hasta = partesFecha_[2] + "-" + partesFecha_[1] + "-" + partesFecha_[0];


	
	let mensaje = `Desde ${dataFormatada_desde} hasta ${dataFormatada_hasta}`;

	$.ajax({
		url    : "/obtenerConsolidado/"+id_categoria,
		method : "POST",
		data : {"data" : btoa(JSON.stringify(datos))},
		beforeSend: function(){
			$("button[type=submit]").attr('disabled');
		}
	}).then((response) => {
		//alert(response);
		let modo=$("#tipo-operacion").val();
		if(modo=='1' || modo=="2"){
			$("#tabla").html(response.tabla);
			$("#2").hide();
			$("#1").show();
			$("#tabla").dataTable().fnDestroy();
			$('#tabla').DataTable({
				dom: "Blfrtip",
				buttons: {
				  dom: {
					button: {
					  className: 'btn-xs-xs'
					},
				  },
				  buttons: [{
					extend: "excel",
					text: 'Excel',
					className: 'btn-xs btn-dark',
					title: accion + ' ' + mensaje,
					download: 'open',
					exportOptions: {
					  columns: [0, 1, 2,3],
					},
					excelStyles: {
					  "template": [
						"blue_medium",
						"header_blue",
						"title_medium"
					  ]
					},
			  
				  }]
				},
				// Opciones de DataTables
				"language": {
				  "sProcessing": "Procesando...",
				  "sLengthMenu": "Mostrar _MENU_ registros",
				  "sZeroRecords": "No se encontraron resultados",
				  "sEmptyTable": "Ningún dato disponible en esta tabla",
				  "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
				  "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
				  "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
				  "sInfoPostFix": "",
				  "sSearch": "Buscar:",
				  "sUrl": "",
				  "sInfoThousands": ",",
				  "sLoadingRecords": "Cargando...",
				  "oPaginate": {
					"sFirst": "Primero",
					"sLast": "Último",
					"sNext": "Siguiente",
					"sPrevious": "Anterior"
				  },
				  "oAria": {
					"sSortAscending": ": Activar para ordenar la columna de manera ascendente",
					"sSortDescending": ": Activar para ordenar la columna de manera descendente"
				  },
				  "columnDefs": [{
					"targets": [0],
					"visible": false,
					"searchable": false
				  }, ]
				},
				"lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "Todos"]],
				"sLengthMenu": "Mostrar _MENU_ registros"
			  });
		}else{
			
			$("#tabla2").html(response.tabla);
			$("#1").hide();
			$("#2").show();
			$("#tabla2").dataTable().fnDestroy();
			$('#tabla2').DataTable({
				dom: "Blfrtip",
				buttons: {
				  dom: {
					button: {
					  className: 'btn-xs-xs'
					},
				  },
				  buttons: [{
					extend: "excel",
					text: 'Excel',
					className: 'btn-xs btn-dark',
					title: accion + ' ' + mensaje,
					download: 'open',
					exportOptions: {
					  columns: [0, 1, 2,3,4],
					},
					excelStyles: {
					  "template": [
						"blue_medium",
						"header_blue",
						"title_medium"
					  ]
					},
			  
				  }]
				},
				// Opciones de DataTables
				"language": {
				  "sProcessing": "Procesando...",
				  "sLengthMenu": "Mostrar _MENU_ registros",
				  "sZeroRecords": "No se encontraron resultados",
				  "sEmptyTable": "Ningún dato disponible en esta tabla",
				  "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
				  "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
				  "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
				  "sInfoPostFix": "",
				  "sSearch": "Buscar:",
				  "sUrl": "",
				  "sInfoThousands": ",",
				  "sLoadingRecords": "Cargando...",
				  "oPaginate": {
					"sFirst": "Primero",
					"sLast": "Último",
					"sNext": "Siguiente",
					"sPrevious": "Anterior"
				  },
				  "oAria": {
					"sSortAscending": ": Activar para ordenar la columna de manera ascendente",
					"sSortDescending": ": Activar para ordenar la columna de manera descendente"
				  },
				  "columnDefs": [{
					"targets": [0],
					"visible": false,
					"searchable": false
				  }, ]
				},
				"lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "Todos"]],
				"sLengthMenu": "Mostrar _MENU_ registros"
			  });
	 }	
	}).catch((request) => {
		Swal.alert("Error", request.messageJSON.message, "error");
	});
	}
});

//Generacion de archivo csv 
$(document).on('click', "#generaArchivoExcel", function(e){
	e.preventDefault();
	let fechas = $("#rango-consulta").val().split(" - ");
	window.location = '/generarConsolidadoExcel/' + invertirFecha(fechas[0]) + '/' + invertirFecha(fechas[1]) + '/' + $("#tipo-operacion").val();
})