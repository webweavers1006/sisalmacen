//Evento de envio de formulario
$("#add-detalle-requerimiento").on('submit', function(e) {
    e.preventDefault();
    $.ajax({
        url: "/requerimientos",
        method: "POST",
        dataType: "JSON",
        data: new FormData(this),
        contentType: false,
        cache: false,
        processData: false,
        beforeSend: function() {
            $("button[type=submit]").attr('disabled', 'true');
        },
    }).then(function(response) {
        Swal.fire('Exito', "Item añadido exitosamente", "success");
        $("button[type=submit]").removeAttr('disabled');
        $("#addItem").modal('hide');
        $("#add-detalle-requerimiento")[0].reset();
        actualizarTabla();
    }).catch(function(request) {
        Swal.fire('Error', "Item ya existente", "error");
        $("button[type=submit]").removeAttr('disabled');
        $("#addItem").modal('hide');
        $("#add-detalle-requerimiento")[0].reset();
    });
    $("#add-detalle-requerimiento")[0].reset();
    actualizarTabla();
});
//Evento de eliminar un item del requerimiento
$(document).on('click', ".eliminar", function(e) {
    e.preventDefault();
    let iditem = $(this).attr('id');
    Swal.fire({
        title: 'Confirmacion',
        text: "¿Está seguro de eliminar este item?",
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Aprobar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.value) {
            $.ajax({
                url: '/requerimientos/delete/' + (iditem),
                method: "POST",
                data: { "data": btoa(JSON.stringify({ "detid": iditem })) },
                dataType: "JSON",
            }).then(function(response) {
                actualizarTabla();
                Swal.fire({
                    title: '¡Exito!',
                    text: 'Item Eliminado',
                    icon: 'success',
                    confirmButtonText: 'Aceptar',
                });

            }).catch(function(request) {
                Swal.fire({ title: '¡Error!', text: 'Error al eliminar', icon: 'Error', confirmButtonText: 'Aceptar' });
            });
        } else {
            Swal.fire('Atencion', 'No se ha aprobado la orden', 'warning');
        }
    });
})

//Evento de confirmacion del requerimiento
$(document).on('submit', "#aprobar-requerimiento", function(e) {
    e.preventDefault();
    let datos = {
        "reqid": $("#reqid").val(),
        "status": 1
    }
    let reqid = $("#reqid").val()
    Swal.fire({
        title: '¿Está seguro de confirmar este requerimiento?',
        text: "Esta accion no se podrá deshacer",
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Aprobar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.value) {
            $.ajax({
                url: '/confirmprereq',
                method: "POST",
                data: { "data": btoa(JSON.stringify(datos)) },
                dataType: "JSON",
            }).then(function(response) {
                Swal.fire({
                    title: '¡Exito!',
                    text: 'Confirmacion realizada exitosamente',
                    icon: 'success',
                    confirmButtonText: 'Aceptar',
                    preConfirm: function(value) {
                        window.location = "/inicio";
                    }
                });
            }).catch(function(request) {
                Swal.fire({ title: '¡Error!', text: 'Ha ocurrido un error', icon: 'Error', confirmButtonText: 'Aceptar' });
            });

            // window.location = '/inicio/'
        } else {
            Swal.fire('Atencion', 'No se ha aprobado el requermiento', 'warning');
        }
    });
});




//Metodo para eliminar un pre requerimiento
$(document).on('click', ".eliminar-solicitud", function(e) {
    e.preventDefault();
    let reqid = $(".eliminar-solicitud").attr('id');
    Swal.fire({
        title: '¿Está seguro de eliminar esta solicitud?',
        text: "Esta accion no se podrá deshacer",
        showCancelButton: true,
        confirmButtonColor: '#E22555',
        cancelButtonColor: '#3338FD',
        confirmButtonText: 'Eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.value) {
            $.ajax({
                url: "/borrarPreReq",
                method: "POST",
                data: { data: btoa(JSON.stringify({ prereqid: reqid })) },
                dataType: "JSON",
            }).then((response) => {
                Swal.fire({
                    title: '¡Exito!',
                    text: 'Solicitud Eliminada',
                    icon: 'success',
                    confirmButtonText: 'Aceptar',
                    preConfirm: function(value) {
                        window.location = "/inicio";
                    }
                });
            }).catch((request) => {
                Swal.fire('Error', "Ha ocurrido un error", "error");
            });
        } else {
            Swal.fire("Atencion", "Solicitud no eliminada", "warning");
        }
    });
});
$(document).ready(function() {
        $('.custom-range').ionRangeSlider({
            step: 1,
            prettify: true,
        });
    })
    //Funcion para actualizar la tabla de items
function actualizarTabla() {
    $.ajax({
        url: "/requerimientos/" + $("#reqid").val(),
        method: "GET",
        dataType: "JSON",
    }).then(function(response) {
        $("#detalle-requerimiento").html(response.data);
    }).catch(function(request) {
        Swal.fire("Error", "Ha ocurrido un error", "error");
    });
}