$('.select2').select2({
    theme:"bootstrapbs4",
});


$("#rango-consulta").on('focus', function(e){
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

/*Funcion que realiza la fecha de hoy*/
function fecha(){
    var hoy = new Date();
    var dd = hoy.getDate();
    var mm = hoy.getMonth()+1;
    var yy = hoy.getFullYear();
    var fecha = '';
    if(dd<10){
        dd = '0'+dd;
    }
    else if(mm<10){
        mm = '0'+mm;
    }
    fecha = dd+"/"+mm+"/"+yy;
    return fecha;
}
//Funcion que invierte la fecha para la BD
function invertirFecha(fecha){
	let fectmp = fecha.split('/');
	let fechadb = `${fectmp[2].trim()}-${fectmp[1].trim()}-${fectmp[0].trim()}`;
	return fechadb;
}

//Validacion para que el numero de solicitud sea siempre un numero
$("#numero-solicitud").on('keyup', function(){
    let value = $("#numero-solicitud").val();
    if(value.match(/[0-9]*/).length > 0){
        if(value.match(/[0-9]*/)[0] === ""){
            $("#numero-solicitud").removeClass("is-valid");
            $("#numero-solicitud").addClass("is-invalid");
            $("button[type=submit]").attr('disabled', "true");    
        }
        else{
            $("button[type=submit]").removeAttr("disabled");
            $("#numero-solicitud").removeClass("is-invalid");
            $("#numero-solicitud").addClass("is-valid");    
        }
    }
    else{
        $("#numero-solicitud").removeClass("is-valid");
        $("#numero-solicitud").addClass("is-invalid");
        $("button[type=submit]").attr('disabled', "true");   
    }
})

//Evento de carga de departamentos cada vez que cambie el select de direcciones
$("#direccion-consulta").on('change', function(){
    let value = $("#direccion-consulta").val();
    $.ajax({
        url:"/getDepts/"+value,
        method:"GET",
        dataType:"JSON",
    }).then((response) => {
        html = `<option value="*">Todos</option>`;
        if(response.data.length > 0){
            for(let i = 0; i<response.data.length; i++){
                html = html + `<option value="${response.data[i][0]}">${response.data[i][1]}</option>`;
            }
        }
        $("#departamento-consulta").html(html);
    }).catch((request) => {
        Swal.fire("Atencion", "Ha ocurrido un error", "warning");
    });
});

//Evento cuando carga la pagina
$(document).ready(function(){
    $("#detalles").hide();
});

//Evento de envio del formulario para cargar los detalles
$(document).on('submit', "#consulta-fecha", function(e){
    e.preventDefault();
    //Validacion si el campo de fecha esta vacio
    if($("#rango-consulta").val().length == 0){
        $("#rango-consulta").val(fecha()+' - '+fecha());
    }
    //Recogemos los datos del formulario
    let datos = {
        "fecha_inicio" : invertirFecha($("#rango-consulta").val().split("-")[0]),
        "fecha_fin"    : invertirFecha($("#rango-consulta").val().split("-")[1]),
        "num_solicitud": $("#numero-solicitud").val(),
        "direccion"    : $("#direccion-consulta").val(),
        "departamento" : $("#departamento-consulta").val()
    }
    $.ajax({
        url:"/consultaSolicitud",
        method:"POST",
        dataType:"JSON",
        data: { data : btoa(JSON.stringify(datos))},
        beforeSend: function(){
            $("button[type=submit]").attr('disabled');
        }
    }).then((response) => {
        $("#detalles-consulta").html(response.data);
        $("#detalles").show();
    }).catch((request) => {
        Swal.fire('Atencion', request.message, "error");
    });
});