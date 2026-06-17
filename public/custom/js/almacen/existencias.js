$(function() {
    llenar_categoria();
    llenar_Existencias(0); 
});

/**
 * 1. CARGA DE CATEGORÍAS
 */
function llenar_categoria() {
    $.ajax({
        url: '/productos/listar_categoria',
        method: 'GET',
        dataType: 'JSON',
        success: function(data) {
            $('#categoria').empty().append('<option value="0">📂 Todas las Categorías</option>');
            $.each(data, function(i, item) {
                $('#categoria').append('<option value="' + item.id + '">📄 ' + item.descripcion + '</option>');
            });
        }
    });
}

/**
 * 2. FILTRO LÓGICO DE STOCK (DataTables)
 */
$.fn.dataTable.ext.search.push(function(settings, data, dataIndex) {
    let tipo = $('#filter_stock_type').val();
    let table = $('#table_existencias').DataTable();
    let rowData = table.row(dataIndex).data();
    
    if (!rowData) return true;

    let stock = parseInt(rowData.numexis) || 0;
    let min = parseInt(rowData.stock_minimo) || 0;

    if (tipo === 'todos') return true;
    if (tipo === 'disponibles') return stock > 10;
    if (tipo === 'agotados') return stock === 0;
    if (tipo === 'critico') return (stock > 0 && stock <= min);
    return true;
});

// Eventos de cambio en los filtros
$(document).on('change', '#categoria', function() {
    llenar_Existencias($(this).val());
});

$(document).on('change', '#filter_stock_type', function() {
    $('#table_existencias').DataTable().draw();
});

/**
 * 3. CONFIGURACIÓN DE DATATABLES
 */
function llenar_Existencias(id_categoria) {
    // Limpiamos el contenedor antes de recrear la tabla
    $('#contenedor-botones-dt').empty();

    var table = $('#table_existencias').DataTable({
        "destroy": true,
        "dom": "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>" +
               "<'row'<'col-sm-12'tr>>" +
               "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
        "buttons": [
            {
                // BOTÓN PDF PRIMERO
                "text": '<i class="fas fa-file-pdf"></i> PDF',
                "className": 'btn btn-danger btn-export shadow-sm',
                "action": function (e, dt, node, config) {
                    let datosParaExportar = dt.rows({ page: 'current', search: 'applied', order: 'applied' }).data().toArray();
                    if (datosParaExportar.length === 0) { 
                        alert("No hay registros en la vista actual."); 
                        return; 
                    }
                    ejecutarPDF(datosParaExportar, $('#categoria option:selected').text());
                }
            },
           // BOTÓN EXCEL SEGUNDO
{
    "extend": "excelHtml5",
    "text": '<i class="fas fa-file-excel"></i> EXCEL',
    "className": 'btn btn-success btn-export shadow-sm',
    "title": function() {
        let catNom = $('#categoria option:selected').text().replace(/[^\w\s]/gi, '').trim();
        let hoy = new Date();
        let dia = String(hoy.getDate()).padStart(2, '0');
        let mes = String(hoy.getMonth() + 1).padStart(2, '0');
        let anio = hoy.getFullYear();
        let fechaActual = `${dia}-${mes}-${anio}`;
        return `Inventario_${catNom.replace(/ /g, "_")}_${fechaActual}`;
    },
    "exportOptions": { 
        "columns": [1, 2, 3, 4], 
        "modifier": { "search": 'applied' } 
    }
}
        ],
        "ajax": { 
            "url": "/almacen/getExistenciasConImagenes/" + id_categoria, 
            "type": "GET", 
            "dataSrc": "" 
        },
        "columns": [
            { "data": 'codbar', "visible": false },
            { "data": 'itemid', "className": 'text-center' },
            { "data": 'prodmar' },
            { "data": 'prodmodel' },
            { 
                "data": 'numexis',
                "className": 'text-center',
                "render": function(data, type, row) {
                    let s = parseInt(data) || 0;
                    let m = parseInt(row.stock_minimo) || 0;
                    let clase = (s === 0) ? 'btnalerta' : (s <= m ? 'btncritico' : 'btnsolvente');
                    return `<span class="${clase}">${s}</span>`;
                }
            }
        ],
        "initComplete": function() { 
            // Inyectamos los botones en el contenedor al lado de los selects
            table.buttons().container().appendTo('#contenedor-botones-dt'); 
        },
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
        }
    });
}

/**
 * 4. GENERACIÓN DE PDF (Sin iconos en títulos)
 */
function ejecutarPDF(productos, nombreCat) {
    let fechaHoy = "25/03/2026";
    let textoFiltroRaw = $('#filter_stock_type option:selected').text();
    
    // Función para limpiar emojis y caracteres especiales de los títulos
    let limpiarTexto = (t) => t.replace(/[^\w\sáéíóúÁÉÍÓÚñÑ()<>:-]/gi, '').trim().toUpperCase();

    let tipoTitulo = (textoFiltroRaw.includes("Mostrar Todo")) ? "GENERAL" : limpiarTexto(textoFiltroRaw);
    let catFinal = (nombreCat.includes("Todas")) ? "GENERAL" : limpiarTexto(nombreCat);

    var docDefinition = {
        pageSize: 'LETTER',
        pageMargins: [40, 95, 40, 40],
        header: (typeof rootpath !== 'undefined') ? { image: rootpath, width: 500, alignment: 'center', margin: [0, 15, 0, 0] } : null,
        content: [
            { text: 'REPORTE: ' + tipoTitulo, fontSize: 11, bold: true, alignment: 'center', margin: [0, 5, 0, 2] },
            { text: 'CATEGORÍA: ' + catFinal + ' | FECHA: ' + fechaHoy, fontSize: 9, alignment: 'center', color: '#444', margin: [0, 0, 0, 20] }
        ],
        footer: (c, t) => ({ text: 'Página ' + c + ' de ' + t, alignment: 'center', fontSize: 7 })
    };

    for (var i = 0; i < productos.length; i += 2) {
        docDefinition.content.push({
            table: {
                widths: [40, 195, '*', 40, 195],
                body: [[
                    { stack: renderImg(productos[i]), margin: [0, 2, 0, 2] },
                    { stack: renderInfo(productos[i]), margin: [5, 2, 0, 2] },
                    { text: '' },
                    (productos[i+1] ? { stack: renderImg(productos[i+1]), margin: [0, 2, 0, 2] } : { text: '' }),
                    (productos[i+1] ? { stack: renderInfo(productos[i+1]), margin: [5, 2, 0, 2] } : { text: '' })
                ]]
            },
            layout: 'noBorders', 
            margin: [0, 0, 0, 12]
        });
    }

    pdfMake.createPdf(docDefinition).download("Reporte_" + catFinal.replace(/\s+/g, '_') + ".pdf");
}

/**
 * 5. HELPERS DE RENDERIZADO
 */
function renderImg(p) {
    if (!p) return [{ text: '', margin: [0, 10] }];
    let rawImg = p.imagen_base64 || p.prodimg || p.imagen;
    
    if (!rawImg || typeof rawImg !== 'string') {
        return [{ text: 'S/I', fontSize: 6, color: '#ccc', alignment: 'center', margin: [0, 12, 0, 0] }];
    }

    let cleanImg = rawImg.trim().replace(/\r?\n|\r/g, "").replace(/\s/g, "");
    if (cleanImg.length < 50) {
        return [{ text: 'S/I', fontSize: 6, color: '#ccc', alignment: 'center', margin: [0, 12, 0, 0] }];
    }

    if (!cleanImg.startsWith('data:image')) {
        cleanImg = 'data:image/jpeg;base64,' + cleanImg;
    }

    try {
        return [{ image: cleanImg, width: 38, height: 32, alignment: 'center' }];
    } catch (e) {
        return [{ text: 'S/I', fontSize: 6, color: '#ccc', alignment: 'center', margin: [0, 12, 0, 0] }];
    }
}
//fino
function renderInfo(p) {
    if (!p) return [];
    let s = parseInt(p.numexis) || 0;
    let m = parseInt(p.stock_minimo) || 0;
    let colorStock = (s === 0) ? '#e74c3c' : (s <= m ? '#f39c12' : '#27ae60');

    return [
        { text: (p.prodmodel || 'S/N').toUpperCase(), fontSize: 8.2, bold: true, color: '#2d3748', margin: [0, 0, 0, 3] },
        { 
            text: [
                { text: 'CAT: ', bold: true, fontSize: 7 }, (p.cat_nombre || 'General') + '\n',
                { text: 'COD: ', bold: true, fontSize: 7 }, (p.codbar || '-') + '\n',
                { text: 'MARCA: ', bold: true, fontSize: 7 }, (p.prodmar || '-') + '\n',
                { text: 'STOCK: ', bold: true, fontSize: 7 }, { text: s.toString(), color: colorStock, bold: true, fontSize: 9 }
            ], 
            fontSize: 7.2, lineHeight: 1.25 
        }
    ];
}