<div class="content-wrapper">
    <link rel="stylesheet" href="<?php echo base_url(); ?>/css/reportes.css">
    <script src="custom/js/excel.js"></script>
    
    <style>
      :root {
        --azul-oscuro: #384c60;
      }

      .card.rounded-3 .card-header,
      table.dataTable thead,
      .custom-thead {
        background: var(--azul-oscuro) !important;
        color: white !important;
      }

      .container-wraper {
        width: 95%;
        max-width: 1200px;
        margin: 20px auto;
      }

      /* BOTONES MÁS ANCHOS */
      .btn-custom-wide {
        min-width: 100px; /* Ancho mínimo para que se vean uniformes */
        padding-left: 15px;
        padding-right: 15px;
        font-weight: 500;
      }

      /* ACERCAR AL TÍTULO: quitamos justify-content-between y usamos gap */
      .header-flex {
        display: flex;
        align-items: center;
        gap: 25px; /* Controla qué tan cerca están los botones del título */
      }

      .table-container {
        border-radius: 8px;
        overflow: hidden;
      }
      
      #listadoprod thead td {
        color: white !important;
        font-weight: 500;
        padding: 12px;
        border: none;
      }
    </style>

    <div class="container-wraper">
        <section class="content">
            <div class="card rounded-3 shadow-lg border-0">
                <div class="card-header header-flex">
                    <h3 class="card-title mb-0">Listado de productos cargados</h3>
                    <div class="card-tools d-flex gap-2">
                        <a href="/regprod" class="btn btn-sm btn-primary shadow-sm btn-custom-wide">Añadir</a>&nbsp;&nbsp;
                        <button id="sheetjsexport" class="btn btn-sm btn-success shadow-sm btn-custom-wide">Excel</button>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="table-container shadow-sm">
                                <table class="table table-hover tabla mb-0" id="listadoprod" style="width:100%">
                                    <thead>
                                        <tr class="custom-thead">
                                            <td>Código</td>
                                            <td>Marca</td>
                                            <td>Descripción</td>
                                            <td>Categoría</td>
                                            <td>Stock Mínimo</td>
                                            <td>Estatus</td>
                                            <td>Acciones</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php echo $tbody; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>

<script>
    document.getElementById("sheetjsexport").addEventListener('click', function() {
        var wb = XLSX.utils.table_to_book(document.getElementById("listadoprod"));
        XLSX.writeFile(wb, "Listado_Productos.xlsx");
    });
</script>