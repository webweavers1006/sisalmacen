$("#detfac").hide();
$("#catalog").hide();



$("#fecfac").on('focus', function() {
    calendario(this);
});

$("#fecent").on('focus', function() {
    calendario(this);
});

/*Evento para buscar un proveedor en la BD*/
$("#busqueda-proveedor").on('click', function(e) {
    e.preventDefault();
    // CORRECCIÓN: Se agrega el guion para que coincida con V-19933177 en la DB
    let rif = $("#tipoprov").val() + "-" + $("#rifprov").val();
    if (rif.length >= 10) {
        $.ajax({
            url: '/buscarproveedor',
            method: 'POST',
            data: { "data": btoa(JSON.stringify({ "rif": rif })) },
            success: function(response) {
                $("#idprov").val(response.data.idprov);
                $("#nomprov").val(response.data.nomprov);
            },
            error: function(request) {
                $("#frmnewnumrif").val(rif);
                $("#add-proveedor").modal('show');
            }
        });
    }
});

/*Evento cuando un proveedor no este*/
$("#newProvider").on('submit', function(e) {
    e.preventDefault();
    var form = {
        numrif: String($("#frmnewnumrif").val()),
        nomprov: String($("#frmnewnomprov").val()),
        direccprov: String($("#frmnewdireccprov").val()),
        telef1: String($("#frmnewtelef1").val()),
        telef2: String($("#frmnewtelef2").val()),
        email: String($("#frmnewcontemail").val())
    };
    $.ajax({
        contentType: 'application/x-www-form-urlencoded; charset=UTF-8',
        url: '/nuevoproveedor',
        method: 'POST',
        data: { data: btoa(JSON.stringify(form)) },
        dataType: 'JSON',
        beforeSend: function() {
            //$("button[type=submit").attr('disabled', 'true');
        },
        success: function(response) {
            $.ajax({
                url: '/buscarproveedor',
                method: 'POST',
                data: { "data": btoa(JSON.stringify({ "rif": form.numrif })) },
                success: function(response) {
                    $("#idprov").val(response.data.idprov);
                    $("#nomprov").val(response.data.nomprov);
                    $("#newProvider")[0].reset();
                },
            });
            // CORRECCIÓN: slice(0, 1) para la letra y slice(2) para el número
            $("#tipoprov").val(form.numrif.slice(0, 1));
            $("#rifprov").val(form.numrif.slice(2));
            $("#add-proveedor").modal('hide');
        },
        error: function(request) {
            Swal.fire('Error!', request.responseJSON.message, 'error');

        }
    });
    // $("button[type=submit").removeAttr('disabled');
});

/*Evento que registra los datos de entrada del almacen*/
$("#datos-entrada").on('submit', function(e) {
    e.preventDefault();
    let form = {
        numfac: $("#numfac").val(),
        fecfac: invertirFecha($("#fecfac").val()),
        provid: $("#idprov").val(),
        fecent: invertirFecha($("#fecent").val()),
        entcoment: $("#entcoment").val()
    };
    $.ajax({
        url: '/addentrada',
        method: 'POST',
        data: { data: btoa(JSON.stringify(form)) },
        dataType: 'JSON',
        beforeSend: function() {
            // $("button[type=submit").attr('disabled', 'true');
        },
        success: function(response) {
            $("#numregent").val(response.num_op);
            // $("button[type=submit").removeAttr('disabled');
            $("#datos-entrada")[0].reset();
            $("#facdata").hide();
            $("#detfac").show();
            $("#catalog").show();
        },
        error: function(request) {
            Swal.fire('Error!', request.responseJSON.message, 'error');
        }
    });
});

/*Evento de busqueda de un nuevo producto*/
$(".buscar-cod-bar").on('click', function(e) {
    let codbar = $("#codbar").val();
    $.ajax({
        url: '/buscarxcodbar',
        method: 'POST',
        data: { data: btoa(JSON.stringify({ data: codbar })) },
        dataType: 'JSON',
        success: function(response) {
            $("#prodmar").val(response.data.prodmar);
            $("#prodmodel").val(response.data.prodmodel);
        },
        error: function(request) {
            $("#frmnewcodbar").val(codbar);
            $("#add-producto").modal('show');
        }
    });
});
/*Evento de registro de un nuevo producto*/
$("#newProduct").on('submit', function(e) {
    e.preventDefault();
    let form = {
        codbar: $("#frmnewcodbar").val(),
        prodmar: $("#frmnewprodmar").val(),
        prodmodel: $("#frmnewprodmodel").val(),
        modform: 1
    }
    $.ajax({
        url: '/addproduct',
        method: 'POST',
        data: { data: btoa(JSON.stringify(form)) },
        dataType: 'JSON',
        beforeSend: function() {
            //   $("button[type=submit]").attr('disabled', 'true');
        },
        success: function(response) {
            $("#prodmar").val(form.prodmar);
            $("#prodmodel").val(form.prodmodel);
            $("#add-producto").modal('hide');
            $("#newProduct")[0].reset();
        },
        error: function(request) {
            Swal.fire('Error!', request.responseJSON.message, 'error');
        }
    });
    // $("button[type=submit]").removeAttr('disabled');
});

/*Evento de registro de un detalle de la factura*/
$("#adddetalle").on('submit', function(e) {
    e.preventDefault();
    let form = {
        codbar: $("#codbar").val(),
        regent: $("#numregent").val(),
        numunid: $("#numuni").val(),
        costuni: $("#costuni").val(),
        prodpresent: $("#prodpresent").val(),
    }
    $.ajax({
        url: '/adddetalle',
        method: 'POST',
        data: { data: btoa(JSON.stringify(form)) },
        dataType: 'JSON',
        beforeSend: function() {
            // $("button[type=submit]").attr('disabled', 'true');
        },
        success: function(response) {
            $("#adddetalle")[0].reset();
            $("#add-detalle-factura").modal('hide');
            //Refrescamos la tabla
            actualizarTablaDetalles(form.regent);
            // CORRECCIÓN: Nombre corregido para coincidir con la definición de abajo
            actualizaCatalogo();
        },
        error: function(request) {
            Swal.fire('Error!', request.responseJSON.message, 'error');
        }
    });
    // $("button[type=submit]").removeAttr('disabled');
});

/*Funcion para actualizar en el catalogo*/
$(document).on('click', ".actualizar", function(e) {
    codbar = $(this).attr('id');
    regent = $("#numregent").val();
    Swal.mixin({
        confirmButtonText: 'Siguiente &rarr;',
        showCancelButton: true,
        progressSteps: ['1', '2', '3'],
        cancelButtonText: "Cancelar",
    }).queue([{
            title: 'Cantidad a ingresar',
            input: 'number',
        },
        {
            title: "Presentacion del producto",
            input: "text"
        },
        {
            title: "Costo unitario",
            input: 'text',
        }
    ]).then((result) => {
        if (result.value) {
            let data = {
                "codbar": codbar,
                "regent": regent,
                "prodpresent": result.value[1],
                "costuni": result.value[2],
                "numunid": result.value[0]
            }
            $.ajax({
                url: "/adddetalle",
                method: "POST",
                data: { data: btoa(JSON.stringify(data)) },
                dataType: "JSON",
                beforeSend: function() {
                    //  $("button[type=submit]").attr('disabled', "true");
                }
            }).then((response) => {
                actualizaCatalogo();
                actualizarTablaDetalles($("#numregent").val());
            }).catch((request) => {
                console.log(request);
            });
        }
    });
});


function actualizaCatalogo() {

    $.ajax({
        url: '/basecontroller/generarTabla',
        type: 'POST',
        dataType: 'json',
        success: function(response) {
            $.ajax({
                url: "/almacen/actualizarcatalogo",
                method: "POST",
                dataType: "JSON",
            }).then((response) => {
                $("#catalogo").html(response.data);

            }).catch((request) => {
                Swal.fire("Error!", "Ha ocurrido un error", "error");
            });
        },
        error: function(xhr, status, error) {
            // Manejar el error de la solicitud AJAX
        }
    });




}

// function agregarBuscador() {
//     $("#tablaCatalogo").DataTable({
//         language: {
//             search: "Buscar: ",
//             searchPlaceholder: "Ingrese término de búsqueda",
//         },
//     });
// }


/*Funcion que obtiene la tabla de detalles*/
function actualizarTablaDetalles(numregent) {
    $.ajax({
        url: '/detalles',
        method: 'POST',
        data: { data: btoa(JSON.stringify({ numregent: numregent })) },
        dataType: 'JSON',
        success: function(response) {
            $("#detallesFactura").html(response.data);
        },
        error: function(request) {
            Swal.fire('Error!', request.responseJSON.message, 'error');
        }
    });
}