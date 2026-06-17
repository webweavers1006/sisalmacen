$(function() {
    let id_categoria=0;
    $("#table_existencias").dataTable().fnDestroy();
    let desde=null;
    let hasta=null;
    let direccion=null;
    llenar_depachos(Event,desde,hasta,direccion);
  
});




 

$(document).on('submit', '#filtrar', function(e) {
    e.preventDefault();
  
   let desde= $('#desde').val();
   let hasta= $('#hasta').val();
   let direccion= $('#direccion-consulta').val();
    $("#table_existencias").dataTable().fnDestroy();
   llenar_depachos(Event,desde,hasta,direccion);

});

function llenar_depachos(e,desde=null,hasta=null,direccion) {
   
    
    var now = new Date();
    var day = ("0" + now.getDate()).slice(-2);
    var month = ("0" + (now.getMonth() + 1)).slice(-2);
    var today = day + "/" + month + "/" + now.getFullYear();

    // Convertir la fecha
    var fechaOriginal = desde;
    var dataFormatada_desde = moment(fechaOriginal).format("DD-MM-YYYY");

    var fechaOriginal2 = hasta;
    var dataFormatada_hasta = moment(fechaOriginal2).format("DD-MM-YYYY");


    let ruta_imagen = rootpath;
    let encabezado = ''


    if (dataFormatada_desde != 'Invalid date' && dataFormatada_hasta != 'Invalid date') {
        encabezado = encabezado + 'Desde:' + ' ' + dataFormatada_desde + ' ' + ' ' + 'hasta' + ' ' + ' ' + dataFormatada_hasta + ' ' + ' ';
    }
   

 
    var table = $('#table_existencias').DataTable({
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
                        columns: [0, 1, 2, 3,4],
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
                            doc.pageMargins = [100, 95, 0, 70];
                        doc['header'] = (function(page, pages) {
                            doc.styles.title = {
                                color: '#4c8aa0',
                                fontSize: '18',
                                alignment: 'center',
                            }
                            return {
                                columns: [{
                                        margin: [10, 3, 40, 40],
                                        image: ruta_imagen,
                                        width: 780,
                                        height: 46,

                                    },
                                    {
                                        margin: [-800, 50, -25, 0],
                                        color: '#4c8aa0',
                                        fontSize: '18',
                                        alignment: 'center',
                                        text: ' Relación de Despachos Realizados',
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
                    title:  'Relación de Despachos Realizados',

                    download: 'open',
                    exportOptions: {
                        columns: [0, 1, 2, 3,4],
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
            "url": "/listar_reporte_despachos/"+desde+'/'+hasta+'/'+direccion,
            "type": "GET",
            dataSrc: ''
        },
        "columns": [
            //a.usupnom,a.ususnom,a.usupape,a.ususape,a.usuemail,b.depnom


            { data: 'numorden' },
            { data: 'statusnom' },
            { data: 'fecsal' },
            { data: 'direccion' },
            { data: 'ususol' },
            
            {
            orderable: true,
            data: null,
            render: function(data, type, row)
            {
                return '<a href="javascript:;" class="btn btn-xs btn-primary Detalles" style=" font-size:1px" data-toggle="tooltip" title="Detalles" numorden="' + row.numorden + '"  > <i class="material-icons " >search</i></a>' 
                         
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


//METODO PARA ELIMINAR UN SEGUIMIENTO
$('#listar_de_despachos').on('click', '.Detalles', function(e) {
    let numorden = $(this).attr('numorden');
    window.location='/detalledespacho/'+numorden;
    
});