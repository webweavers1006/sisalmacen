$('.select2').select2({
    theme: "bootstrapbs4",
});

var table;

// Evento para resetear el formulario
$("button[type=reset]").on('click', function() {
    if (table) {
        table.destroy();
        table = null;
    }
    $("#detalles").hide();
    $("#consulta-fecha")[0].reset();
});

// Evento para deshabilitar proveedor si es salida
$("#tipo-consulta").on('change', function() {
    if ($("#tipo-consulta").val() == "2") {
        $("#proveedor-consulta").attr('disabled', "true");
    } else {
        $("#proveedor-consulta").removeAttr('disabled');
    }
});

// Inicializar categorías
llenar_categoria(window.event);

function llenar_categoria(e, id_categoria) {
    let url = '/listar_categorias';
    $.ajax({
        url: url,
        method: 'GET',
        dataType: 'JSON',
        success: function(data) {
            if (data.length >= 1) {
                $('#categoria').empty();
                $('#categoria').append('<option value=0>Seleccione</option>');
                $.each(data, function(i, item) {
                    let selected = (item.id === id_categoria) ? 'selected' : '';
                    $('#categoria').append('<option value=' + item.id + ' ' + selected + '>' + item.descripcion + '</option>');
                });
            }
        }
    });
}

// Configuración del daterangepicker en español
$("#rango-consulta").on('focus', function(e) {
    $(this).daterangepicker({
        showDropdowns: true,
        maxDate: new Date(),
        locale: {
            format: 'DD/MM/YYYY',
            separator: " - ",
            applyLabel: "Aplicar",
            cancelLabel: "Cancelar",
            daysOfWeek: ["Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa"],
            monthNames: ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"]
        }
    });
});

// Envío del formulario
$("#consulta-fecha").on('submit', function(e) {
    e.preventDefault();
    let desde = $('#desde').val() || 'null';
    let hasta = $('#hasta').val() || 'null';
    let id_categoria = $('#categoria').val();

    if (desde == 'null' || hasta == 'null') {
        Swal.fire("Atención", "Debe indicar un rango de fecha completo", "warning");
        return;
    }

    let datos = {
        'modo': $("#tipo-consulta").val(),
        'fecha_inicio': desde,
        'fecha_fin': hasta,
        'usuario-consulta': $("#usuario-consulta").val(),
        'producto-consulta': $("#producto-consulta").val(),
        'proveedor-consulta': $("#proveedor-consulta").val(),
    };

    $.ajax({
        url: "/consultaFecha/" + id_categoria,
        method: "POST",
        dataType: "JSON",
        data: { "data": btoa(JSON.stringify(datos)) },
        beforeSend: function() {
            $("button[type=submit]").attr("disabled", "true");
        }
    }).done(function(response) {
        $("#detalles-consulta").html(atob(response.data.tabla));
        $("#generar-reporte").html(response.data.footer);

        if ($.fn.DataTable.isDataTable('#detalles-consulta')) {
            table.destroy();
        }

        let modo = $("#tipo-consulta").val();
        let titulo_reporte = 'Reporte de Almacén';
        let encabezado = (modo == '1') ? 'REPORTE DE ENTRADAS' : 'REPORTE DE SALIDAS';

        table = $('#detalles-consulta').DataTable({
            dom: 'lBfrtip',
            responsive: true,
            pageLength: 25,
            lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "Todos"]],
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json'
            },
            order: [[0, 'desc']],
            buttons: [
                {
                    extend: "pdf",
                    text: 'PDF',
                    className: 'btn-xs btn-dark mr-2',
                    orientation: 'landscape',
                    pageSize: 'LETTER',
                    exportOptions: { 
                        // CAMBIO AQUÍ: Definimos los índices de las columnas manualmente
                        // 0 es el botón de expandir, así que empezamos desde 1 si no lo quieres
                        columns: [1, 2, 3, 4, 5, 6, 7,8,9], 
                        modifier: { page: 'current' } 
                    },
                    customize: function(doc) {
                        doc.styles.tableHeader = { fillColor: '#4c8aa0', color: 'white', alignment: 'center', bold: true };
                        doc.pageMargins = [40, 110, 40, 60];
                        doc['header'] = function(page, pages) {
                            return {
                                columns: [
                                    { image: rootpath, width: 520, margin: [40, 20, 0, 0] },
                                    {
                                        stack: [
                                            { text: titulo_reporte, fontSize: 14, bold: true, color: '#4c8aa0' },
                                            { text: encabezado, fontSize: 11, margin: [0, 5, 0, 0] }
                                        ],
                                        margin: [-520, 75, 0, 0],
                                        alignment: 'center'
                                    }
                                ]
                            };
                        };
                    }
                },
                {
                    extend: "excel",
                    text: 'Excel',
                    className: 'btn-xs btn-dark',
                    title: titulo_reporte,
                    exportOptions: { 
                        // MISMO CAMBIO: Índices manuales para asegurar que se lleven todas
                        columns: [1, 2, 3, 4, 5, 6, 7,8,9], 
                        modifier: { page: 'current' } 
                    }
                }
            ]
        });

        $("#detalles").show();
    }).fail(function() {
        Swal.fire("Error", "No se pudo procesar la consulta", "error");
    }).always(function() {
        $("button[type=submit]").removeAttr("disabled");
    });
});

$(document).ready(function() {
    $("#detalles").hide();
});