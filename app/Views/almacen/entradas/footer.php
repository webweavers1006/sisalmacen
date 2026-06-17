<!-- date-range-picker -->
<script src="<?php echo base_url();?>/theme/plugins/daterangepicker/daterangepicker.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>/custom/js/almacen/entradas.js"></script>

<script>
$(document).ready(function() {
    // Configurar DataTable para tabla entradas: orden DESC por col 0 (Nº Registro)
    $("#entradas_table").DataTable({
        destroy: true,
        order: [[0, "desc"]],
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
            }],
        },
        lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "Todos"]]
    });
});
</script>
</body>
</html>
