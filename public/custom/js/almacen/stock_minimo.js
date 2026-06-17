$(function() {
    let id_categoria=0;
    $("#table_stock_minimo").dataTable().fnDestroy();
    llenar_Existencias(Event,id_categoria);
    
});





function llenar_Existencias(e,id_categoria) {
    var fechaActual = new Date();
    var dia = fechaActual.getDate();
    var mes = fechaActual.getMonth() + 1; // Los meses comienzan desde 0, por lo que se suma 1
    var año = fechaActual.getFullYear(); 
    // Formatear el día y el mes con dos dígitos
    if (dia < 10) {
      dia = "0" + dia;
    }
    if (mes < 10) {
      mes = "0" + mes;
    }
        // Paso 3: Genera el formato "dia mes año"
        var fecha = dia + "-" + mes + "-" + año;
   
    let ruta_imagen = rootpath;
    let encabezado = ''
    
    
    var table = $('#table_stock_minimo').DataTable({
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
                        columns: [0, 1, 2, 3, 4],
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
                       
                            doc.styles.tableHeader = {
                                fillColor: '#4c8aa0',
                                color: 'white',
                                alignment: 'center'
                            },
                            // Create a header
                            doc.pageMargins = [20, 95, 0, 70];
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
                                        text: 'Stock Minimo al dia '+' '+fecha,
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
                    title: 'StockMinimo'+fecha,

                    download: 'open',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4],
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
            "url": "/listar_stock_minimo",
            "type": "GET",
            dataSrc: ''
        },
        "columns": [
           


            { data: 'codbar' },
            { data: 'itemid' },
            { data: 'prodmar' },
            { data: 'prodmodel' },
            //{ data: 'numexis' },
            {orderable: true,
                    render:function(data, type, row)
                    {
                     if(parseInt(row.numexis)<=parseInt(row.stock_minimo))
                      {
                         return '<button id="btnalerta"class="   btnalerta "disabled="disabled">'+row.numexis+'</button>'
                      }
                      else 
                      {
                         return '<button id="btnsolvente"class="btnsolvente "disabled="disabled">'+row.numexis+'</button>'
                       
                      } 
                   
                    }
               },

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