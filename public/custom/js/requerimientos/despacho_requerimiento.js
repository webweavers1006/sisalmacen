//Variables globales
let items = [];
$(document).ready(function(){
    $("#despacho-requerimiento").hide();
});
$("#fecfac").on('focus', function(){
	calendario(this);
});

/*Evento para buscar un proveedor en la BD*/
$("#busqueda-proveedor").on('click',function(e){
	e.preventDefault();
	let rif = $("#tipoprov").val()+$("#rifprov").val();
	if(rif.length >= 10){
        $("#rifprov").removeClass('is-invalid');
        $("#rifprov").addClass('is-valid');
        $("#busqueda-proveedor").removeAttr('disabled');
        $.ajax({
			url:'/buscarproveedor',
			method:'POST',
			data:{"data": btoa(JSON.stringify({"rif":rif}))},
		}).then(function(response){
            $("#idprov").val(response.data.idprov);
            $("#nomprov").val(response.data.nomprov);            
        }).catch(function(request){
            $("#frmnewnumrif").val(rif);
			$("#add-proveedor").modal('show');
        });
    }
    else{
        $("#rifprov").addClass('is-invalid');
        $("#busqueda-proveedor").attr('disabled');
    }
});

/*Evento cuando un proveedor no este*/
$("#newProvider").on('submit', function(e){
	e.preventDefault();
	var form = {
		numrif     : String($("#frmnewnumrif").val()),
		nomprov    : String($("#frmnewnomprov").val()),
		direccprov : String($("#frmnewdireccprov").val()),
		telef1     : String($("#frmnewtelef1").val()),
		telef2     : String($("#frmnewtelef2").val()),
		email      : String($("#frmnewcontemail").val())
	};
	$.ajax({
		contentType: 'application/x-www-form-urlencoded; charset=UTF-8',
		url:'/nuevoproveedor',
		method:'POST',
		data: {data: btoa(JSON.stringify(form))},
		dataType:'JSON',
		beforeSend:function(){
			$("button[type=submit").attr('disabled', 'true');
		}
    }).then(function(response){
        $.ajax({
            url:'/buscarproveedor',
            method:'POST',
            data:{"data": btoa(JSON.stringify({"rif":form.numrif}))},
            success:function(response){
                $("#idprov").val(response.data.idprov);
                $("#nomprov").val(response.data.nomprov);
                $("#newProvider")[0].reset();
            },
        });
        $("#tipoprov").val(form.numrif.slice(0,0));
        $("#rifprov").val(form.numrif.slice(1,9));
        $("#add-proveedor").modal('hide');
        $("button[type=submit").removeAttr('disabled');
    }).catch(function(request){
        Swal.fire('Error!', "Ha ocurrido un error", 'error');
    });
});
/*Evento que registra los datos de entrada del almacen*/
$("#detalle-entrada").on('submit', function(e){
	e.preventDefault();
	let form = {
		numfac   : $("#numfac").val(),
		fecfac   : invertirFecha($("#fecfac").val()),
		provid   : $("#idprov").val(),
		fecent   : invertirFecha($("#fecent").val()),
		entcoment: $("#entcoment").val()
	};
	$.ajax({
		url:'/addentrada',
		method:'POST',
		data:{data:btoa(JSON.stringify(form))},
		dataType:'JSON',
		beforeSend:function(){
			$("button[type=submit").attr('disabled', 'true');
		},
		success:function(response){
			$("#numregent").val(response.num_op);
			$("button[type=submit").removeAttr('disabled');
			$("#detalle-entrada")[0].reset();
			$("#detalle-entrada").hide();
			$("#despacho-requerimiento").show();
		},
		error:function(request){
			Swal.fire('Error!', request.responseJSON.message, 'error');			
		}
	});
});

/*Evento para el envio de los detalles del requerimiento*/
$("#despacho-requerimiento").on('submit', function(e){
    e.preventDefault();
    let form = $(this).serialize().split('&');
    let reqid = '';
    let usuid = '';
    for(let i = 0; i<form.length; i++){
        let temp = form[i].split("=");
        if(i == 0){
            reqid = temp[1];
        }
        else if(i == 1){
            usuid = temp[1];
        }
    }
    //Levantamos un SweetAlert para generar la entrada y la salida de la operacion
    Swal.fire({
		title: 'Añadir comentario adicional',
		input: 'text',
		inputAttributes: {
			autocapitalize: 'on'
		},
		showCancelButton: true,
        confirmButtonText: 'Confirmar',
        allowOutsideClick: false,
		showLoaderOnConfirm: true,
		cancelButtonText: "Cancelar",
		preConfirm: (comment) => {
			let datos = {
				"reqid"    : reqid,
				"ususol"   : usuid,
                "commsal"  : comment,
				"usureg"   : $("#usureg").val(),
				"items"    : items,
				"numregent": $("#numregent").val()
			};
			$.ajax({
				url:"/registraDespacho",
				method:"POST",
				data:{"data" : btoa(JSON.stringify(datos))},
				dataType: "JSON",
			}).then((response) => {
				Swal.fire({
					title:"Exito", 
					text: response.message, 
					type:"success",
					preConfirm: (comment) => {
						if(comment){
							window.location = "/despachos";
						}
					}
				});
			}).catch((request) => {
				Swal.fire("Error", request.message, "error");
			});
		}
	});
});

//Evento para cargar los detalles del producto
$(".codbar").on('change', function(e){
	e.preventDefault();
	$(this).removeClass('is-invalid');
	let codbar = $(this).val();
	let itemid = $(this).attr('id');
	if(codbar.length <= 0){
		$(this).removeClass('is-valid');
        $(this).addClass('is-invalid');
	}
	else{
		Swal.mixin({
			confirmButtonText: 'Siguiente &rarr;',
			showCancelButton: true,
			progressSteps: ['1', '2'],
			allowOutsideClick: false,
			allowEscapeKey: false,
			allowEnterKey: false,
		}).queue([
			{
				input: "text",
				text: 'Costo Unitario',
				},
				{
					input: "text",
					text: 'Presentacion del producto',
				},
			]).then((result) => {
				if (result.value) {
					items.push({
						codbar     : codbar,
						itemid     : itemid,
						costuni    : result.value[0],
						prodpresent: result.value[1],
					});
				}
			});
		}
});