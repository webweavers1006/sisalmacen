$(document).ready(()=> {
	$("#grafico").hide();
    let departamentos = '<option value="*">Todos los departamentos</option>';
	let direcciones = '<option value="*">Todas las direcciones</option>';
    //obteniendo las direcciones
    $.ajax({
        url:"/direcciones",
        method:"GET",
        dataType:"JSON",
    }).then((response) => {
        /*Ponemos los select donde corresponda*/
		for(let i = 0; i<response.data.length; i++){
            let row = response.data[i];
            direcciones = direcciones + `<option value="${row[0]}">${row[1]}</option>`;
		}
        $("#direcciones").html(direcciones);
        $("#departamentos").html(departamentos);
    }).catch((request) => {
        Swal.alert("Error", "No hay departamentos cargados","error");
    });
});

//Evento cuando cambie las direcciones de manera dinamica
$(document).on('change', "#direcciones", () => {
    let dirid = $("#direcciones").val();
    $.ajax({
        url:'/getDepts/'+dirid,
        method:'GET',
        dataType:'JSON',
    }).then((response) => {
        html = '<option value="*">Todos los departamentos</option>';
        /*Ponemos los select donde corresponda*/
        for(let i = 0; i<response.data.length; i++){
            let row = response.data[i];
            html = html + `<option value="${row[0]}">${row[1]}</option>`;
        }
		$("#departamentos").html(html);
    }).catch((request) => {
        Swal.fire("error", "No hay departamentos cargados", "error");
    });
});

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

//Evento de envio del formulario al controlador
$(document).on('submit', "#consulta-articulos", (e) =>{
    e.preventDefault();
	let fechas = $("#rango-consulta").val().split(" - ");
    let datos = {
        "date_init"     : invertirFecha(fechas[0]),
		"date_end"      : invertirFecha(fechas[1]),
		"direccion": $("#direcciones").val(),
		"departamento": $("#departamentos").val()
    }
	$.ajax({
		url:"/consultadepartamentos",
		method:"POST",
		dataType:"JSON",
		data: {"data" : btoa(JSON.stringify(datos))}
	}).then((response) => {
		var ctx = document.getElementById('salida').getContext('2d');
		var myChart = new Chart(ctx, {
			type: 'bar',
			responsive:false,
			data: {
				labels: response.dataset.label,
				datasets: [{
					label: 'Nº de unidades',
					data: response.dataset.data,
					backgroundColor: 'rgba(15,'+response.dataset.length+',64,0.1)'
				}]
			},
			options: {
				scales: {
					yAxes: [{
						ticks: {
							beginAtZero: true
						}
					}]
				}
			}
		});
		$("#grafico").show();
		$("#tabla").html(response.tabla);
		tabla('.tabla');
	}).catch((request) => {
		Swal.alert("Atencion", request.responseJSON.message, "error");
	});
})

//Generacion de archivo csv 
$(document).on('click', "#generaArchivoExcel", function(e) {
	e.preventDefault();
	let fechas = $("#rango-consulta").val().split(" - ");
    let datos = {
        "date_init"     : invertirFecha(fechas[0]),
		"date_end"      : invertirFecha(fechas[1]),
		"direccion": $("#direcciones").val(),
		"departamento": $("#departamentos").val()
    }
	window.location = '/generarExcelDepartamentos/'+btoa(JSON.stringify(datos));
})