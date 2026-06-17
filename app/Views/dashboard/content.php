<div class="content-wrapper">
    <link rel="stylesheet" href="<?php echo base_url(); ?>/css/reportes.css">
    
    <style>
      :root { --azul-oscuro: #384c60; }

      .card.rounded-3 {
        border-radius: 12px !important;
        overflow: hidden;
      }

      .card.rounded-3 .card-header {
        background: var(--azul-oscuro) !important;
        color: white !important;
        padding: 15px 25px;
      }

      .container-wraper { width: 95%; max-width: 1400px; margin: 20px auto; }

      /* Estilo para los botones de la tabla */
      .btn-detalle, 
      #requisicionestable a[href*="detalle"],
      #requisicionestable a[href*="verpreorden"],
      #requisicionestable a[href*="detalledespacho"],
      #requisicionestable a:contains("Detalle") {
        display: inline-block;
        padding: 6px 16px;
        font-size: 0.875rem;
        font-weight: 500;
        line-height: 1.5;
        color: #fff;
        background-color: #007bff;
        border: 1px solid #007bff;
        border-radius: 6px;
        text-decoration: none;
        transition: all 0.3s ease;
        text-align: center;
        min-width: 80px;
        box-shadow: 0 2px 4px rgba(0,123,255,0.25);
      }

      .btn-detalle:hover, 
      #requisicionestable a[href*="detalle"]:hover,
      #requisicionestable a[href*="verpreorden"]:hover,
      #requisicionestable a[href*="detalledespacho"]:hover,
      #requisicionestable a:contains("Detalle"):hover {
        background-color: #0056b3;
        border-color: #0056b3;
        color: #fff;
        transform: translateY(-1px);
        box-shadow: 0 4px 8px rgba(0,123,255,0.3);
      }

      .btn-detalle:active,
      #requisicionestable a[href*="detalle"]:active,
      #requisicionestable a[href*="verpreorden"]:active,
      #requisicionestable a[href*="detalledespacho"]:active,
      #requisicionestable a:contains("Detalle"):active {
        transform: translateY(0);
        box-shadow: 0 2px 4px rgba(0,123,255,0.25);
      }

      .header-flex {
        display: flex;
        align-items: center;
      }

      /* Cabecera de tabla estilo SIAC */
      #requisicionestable thead th {
        background: #4b647c !important;
        color: white !important;
        font-weight: 500;
        border: none !important;
      }
    </style>

    <div class="container-wraper">
        <section class="content">
            
            <div class="card rounded-3 shadow-lg border-0 mb-5">
                <div class="card-header header-flex">
                    <h3 class="card-title mb-0" style="font-weight: 600;">Requisiciones Solicitadas</h3>
                </div>

                <div class="card-body p-0">
                    <div class="p-3">
                        <table class="table table-hover mb-0" id="requisicionestable" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Nº Orden</th>
                                    <th>Fecha de Solicitud</th>
                                    <th>Estatus</th>
                                    <th>Comentario</th>
                                    <th class="text-center">Acciones</th>
                                </tr>
                            </thead>
                            <tbody id="requisiciones">
                                </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="card rounded-3 shadow-lg border-0">
                <div class="card-header header-flex">
                    <h3 class="card-title mb-0" style="font-weight: 600;">Requerimientos Solicitados</h3>
                </div>
                <div class="card-body">
                    <div id="requerimientos">
                        </div>
                </div>
            </div>
        </section>
    </div>
</div>

