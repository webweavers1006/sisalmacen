/*Funcion que elimina items de un arreglo*/


Array.prototype.removeItem = function(a) {
    for (var i = 0; i < this.length; i++) {
        if (this[i] == a) {
            for (var i2 = i; i2 < this.length - 1; i2++) {
                this[i2] = this[i2 + 1];
            }
            this.length = this.length - 1;
            return;
        }
    }
};
$(function() {
    llenar_Usuarios(Event);
    setTimeout(function() {
        $('#complementos1').show();


    }, 2000);


});

function llenar_Usuarios() {
    let encabezado = ''
        //let ruta_imagen = rootpath;

    var table = $('#table_usuarios').DataTable({
        dom: "Bfrtip",
        buttons: {
            dom: {
                button: {
                    className: 'btn-xs-xs'
                },
            },
            buttons: [{
                    //definimos estilos del boton de pd
                    extend: "pdf",
                    text: 'PDF',
                    className: 'btn-xs btn-dark',
                    orientation: 'landscape',
                    pageSize: 'LETTER',
                    header: true,
                    footer: true,
                    download: 'open',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5],
                    },
                    alignment: 'center',

                    customize: function(doc) {
                        //Remove the title created by datatTables
                        doc.content.splice(0, 1);
                        doc.styles.title = {
                            color: '#4c8aa0',
                            fontSize: '18',
                            alignment: 'center'
                        }
                        doc.styles['td:nth-child(2)'] = {
                                width: '130px',
                                'max-width': '130px'
                            },
                            doc.styles.tableHeader = {
                                fillColor: '#4c8aa0',
                                color: 'white',
                                alignment: 'center'
                            },
                            // Create a header
                            doc.pageMargins = [50, 95, 0, 70];
                        doc['header'] = (function(page, pages) {
                            doc.styles.title = {
                                color: '#4c8aa0',
                                fontSize: '18',
                                alignment: 'center',
                            }
                            return {
                                columns: [{
                                        margin: [10, 3, 40, 40],
                                        // image: ruta_imagen,
                                        width: 780,
                                        height: 46,

                                    },
                                    {
                                        margin: [-800, 50, -25, 0],
                                        color: '#4c8aa0',
                                        fontSize: '18',
                                        alignment: 'center',
                                        text: 'Control de Usuarios',
                                        fontSize: 18,
                                    },
                                    {
                                        margin: [-600, 80, -25, 0],
                                        text: encabezado,
                                    },
                                ],
                            }
                        });
                        // Create a footer
                        doc['footer'] = (function(page, pages) {
                            return {
                                columns: [{
                                    alignment: 'center',
                                    text: ['pagina ', { text: page.toString() }, ' of ', { text: pages.toString() }]
                                }],
                            }
                        });

                    },
                },

                {
                    //definimos estilos del boton de excel
                    extend: "excel",
                    text: 'Excel',
                    className: 'btn-xs btn-dark',
                    title: 'Control de',

                    download: 'open',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5],
                    },
                    excelStyles: {
                        "template": [
                            "blue_medium",
                            "header_blue",
                            "title_medium"
                        ]
                    },

                }
            ]
        },
        "order": [
            [0, "asc"]
        ],
        "paging": true,
        "lengthChange": true,

        dom: 'Blfrtip',
        "searching": true,
        "lengthMenu": [
            [10, 25, 50, -1],
            ['10', '25', '50', 'Todos']
        ],
        "ordering": true,
        "info": true,
        "autoWidth": true,
        //"dom": 'Bfrt<"col-md-6 inline"i> <"col-md-6 inline"p>',
        "ajax": {
            "url": "/listar_Usuarios/",
            "type": "GET",
            dataSrc: ''
        },
        "columns": [
            //a.usupnom,a.ususnom,a.usupape,a.ususape,a.usuemail,b.depnom

            { data: 'usupnom' },
            { data: 'ususnom' },
            { data: 'usupape' },
            { data: 'ususape' },
            { data: 'usuemail' },
            { data: 'depnom' },
            {
                orderable: true,
                render: function(data, type, row) {

                    return '<a href="javascript:;" class="btn btn-xs btn-primary Editar" style=" font-size:1px" data-toggle="tooltip" title="Editar" id=' + row.userid + ' > <i class="material-icons " >create</i></a>' + ' ' + '<a href="javascript:;" class="btn btn-xs btn-success Password" style=" font-size:1px" data-toggle="tooltip" title="Cambiar clave" id=' + row.userid + ' > <i class="material-icons " >add</i></a>'




                }
            }

        ],




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
    });
}

$('#users').on('click', '.Editar', function(e) {
    alert('click');
    // var id = $(this).attr('id');
    // window.location = '/usuarios/' + id;

});

$('#users').on('click', '.Password', function(e) {
    var id = $(this).attr('id');
    $("#cambiar_clave").modal("show");

    $('#cambiar_clave').find('#id_usuario').val(id);

});

//Verificacion si las dos contraseñas son iguales al agregar
$(document).on('keyup', "#edit-user-confirm-pass", (e) => {
    e.preventDefault();
    let pass = $("#edit-user-confirm-pass").val();
    if ($("#edit-user-pass").val() != pass) {
        $("#edit-user-pass").addClass('is-invalid');
        $("#edit-user-confirm-pass").addClass('is-invalid');
        $("button[type=submit]").attr('disabled', 'true');
    } else {
        $("#edit-user-pass").removeClass('is-invalid');
        $("#edit-user-confirm-pass").removeClass('is-invalid');
        $("#edit-user-pass").addClass('is-valid');
        $("#edit-user-confirm-pass").addClass('is-valid');
        $("button[type=submit]").removeAttr('disabled');
    }
});




/*Evento para enviar el formulario*/
$(document).on('click', '#guadar_clave', function(e) {
    e.preventDefault();
    var id_user = $('#id_usuario').val();
    let mode = $("#optype").val();
    let datos = {

        userpass: $("#edit-user-confirm-pass").val(),
        id_user: id_user,
    }
    $.ajax({
        url: 'reset_password',
        method: 'POST',
        data: { data: btoa(JSON.stringify(datos)) },
        beforeSend: function() {
            $("button[type=submit]").attr('disabled', 'true');
        },
        dataType: 'JSON',
        success: function(mensaje) {
            if (mensaje === 1) {
                Swal.fire({
                    icon: "success",
                    type: 'success',
                    html: '<strong>Operacion Exitosa </strong>',
                    toast: true,
                    position: "center",
                    showConfirmButton: false,
                    //timer: 3500,

                });
                setTimeout(function() {
                    window.location = "/admin";
                }, 1500);
            } else {
                Swal.fire({
                    icon: "error",
                    type: 'error',
                    html: '<strong>Ocurrio un error durante la operacion </strong>',
                    toast: true,
                    position: "center",
                    showConfirmButton: false,
                    //timer: 1500,
                });
                setTimeout(function() {
                    window.location = "/inicio";
                }, 1500);

            }

        }

    });
});





















/*Funcion que carga los datos de las direcciones segun sea el caso*/
function load_directions() {
    $.ajax({
        url: '/direcciones/',
        method: 'GET',
        dataType: 'JSON',
        success: function(response) {
            let html = '<option>Seleccione una opcion</option>';
            let table = ''
            switch (response.status) {
                case 200:
                    /*Ponemos los select donde corresponda*/
                    for (let i = 0; i < response.data.length; i++) {
                        let row = response.data[i];
                        html = html + `<option value="${row[0]}">${row[1]}</option>`;
                        table = table + `<tr><td><input name="dirval" class="dir_record" type="checkbox" value="${row[0]}"></td><td>${row[0]}</td><td>${row[1]}</td></tr>`;
                    }
                    $("#depdir").html(html);
                    //$("#usudir").html(html);
                    $("#directions").html(table);
                    break;
                case 404:
                    /*Creamos la tabla para las direcciones*/
                    select = '<option>No hay datos cargados</option>';
                    table = '';
                    table = table + `<tr><td colspan="3" class="text-center">Sin Registros</td></tr>`;
                    $("#depdir").html(select);
                    $("#usudir").html(select);
                    $("#directions").html(table);
                    break;
            }
        }
    });
}

/*Funcion que carga los datos de los roles segun sea el caso*/
function load_roles() {
    $.ajax({
        url: '/roles/',
        method: 'GET',
        dataType: 'JSON',
        success: function(response) {
            let html = '<option>Seleccione una opcion</option>';
            let table = ''
            switch (response.status) {
                case 200:
                    /*Ponemos los select donde corresponda*/
                    for (let i = 0; i < response.data.length; i++) {
                        let row = response.data[i];
                        html = html + `<option value="${row[0]}">${row[1]}</option>`;
                        table = table + `<tr><td><input name="rolval" class="rol_record" type="checkbox" value="${row[0]}"></td><td>${row[1]}</td></tr>`;
                    }
                    // $("#usurol").html(html);
                    $("#roles").html(table);
                    break;
                case 404:
                    /*Creamos la tabla para las direcciones*/
                    select = '<option>No hay datos cargados</option>';
                    table = '';
                    table = table + `<tr><td colspan="3" class="text-center">Sin Registros</td></tr>`;
                    $("#usurol").html(html);
                    $("#roles").html(table);
                    break;
            }
        }
    });
}




function load_data() {
    load_directions();
    load_departments();
    load_roles();
    // load_users();
}
/*Funcion generica para crear registros*/
function create(datos, ruta, id_hidden, modal) {
    $.ajax({
        url: ruta,
        method: 'POST',
        dataType: 'JSON',
        data: { data: datos },
        beforeSend: function() {
            $("button[type=submit]").addClass('disabled');
        },
        success: function(response) {
            switch (response.status) {
                case 200:
                    Swal.fire('Exito!', 'Operacion realizada exitosamente', 'success');
                    $(modal).modal('hide');
                    $(id_hidden).val('');
                    load_data();
                    $("button[type=submit]").removeClass('disabled');
                    break;
                default:
                    Swal.fire("Error", 'Operacion no completada', 'error');
                    $("button[type=submit]").removeClass('disabled');
                    break;
            }
        },
        error: function(request) {
            Swal.fire('Oops!', 'Ha ocurrido un error', 'error');
        }
    });
    return;
}

/*Funcion que carga los datos de los departamentos segun sea el caso*/
function load_departments() {
    $.ajax({
        url: '/departamentos',
        method: 'GET',
        dataType: 'JSON',
        success: function(response) {
            let html = '';
            switch (response.status) {
                case 200:
                    /*Creamos la tabla para los departamentos*/
                    html = '';
                    for (let i = 0; i < response.data.length; i++) {
                        let row = response.data[i];
                        html = html + `<tr><td><input name="deptval" class="dept_record" type="checkbox" value="${row[0]}"></td><td>${row[1]}</td><td>${row[2]}</td></tr>`;
                    }
                    $("#departaments").html(html);
                    break;
                case 404:
                    html = '';
                    html = html + `<tr><td colspan="3" class="text-center">Sin Registros</td></tr>`;
                    $("#departaments").html(html);
                    break;
            }
        }
    })
}
/*Evento de carga de la pagina*/
$(document).ready(function() {
    /*Carga de datos*/
    load_data();
});