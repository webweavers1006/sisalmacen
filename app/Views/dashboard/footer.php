
<script type="text/javascript">
    // Función genérica de exportación compatible con tu archivo de productos
    function exportTableToExcel(tableId, fileName) {
        var table = document.getElementById(tableId);
        if (!table) {
            // Si el ID no existe, buscamos la primera tabla dentro del contenedor
            table = document.querySelector('#' + tableId + ' table') || document.querySelector('#requerimientos table');
        }
        
        if (table) {
            var wb = XLSX.utils.table_to_book(table);
            XLSX.writeFile(wb, fileName + "_" + new Date().toLocaleDateString() + ".xlsx");
        } else {
            alert("No hay datos disponibles para exportar");
        }
    }

    // Inicializador de tablas optimizado
    function initTable(id) {
        if ($.fn.DataTable.isDataTable(id)) {
            $(id).DataTable().destroy();
        }
        $(id).DataTable({
            "paging": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "responsive": true,
            "pageLength": 10,
            "order": [[1, "desc"]],
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

    function tabRequisiciones() {
        $.ajax({
            url: '/obtpreordenes',
            method: 'POST',
            success: function(response) {
                if (response && response.data) {
                    // Quitamos el decodeURIComponent si el backend envía HTML puro
                    $("#requisiciones").html(response.data);
                    initTable('#requisicionestable');
                }
            }
        });
    }

    function tabRequerimientos() {
        $.ajax({
            url: "/obtrequerimientos",
            method: "POST",
            success: function(response) {
                if (response && response.data) {
                    $("#requerimientos").html(response.data);
                    
                    // Asignamos un ID a la tabla que viene por AJAX para que Excel la encuentre
                    $("#requerimientos table").attr('id', 'requerimientos_table_ajax');
                    
                    $("#requerimientos table").each(function() {
                        initTable(this);
                    });
                }
            }
        });
    }

    $(document).ready(function() {
        tabRequisiciones();
        tabRequerimientos();
    });
</script>