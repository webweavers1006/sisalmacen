<!-- Content Wrapper. Contains page content -->
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

      .header-flex {
        display: flex;
        align-items: center;
      }

      /* Cabecera de tabla estilo SIAC */
      table thead th {
        background: #4b647c !important;
        color: white !important;
        font-weight: 500;
        border: none !important;
      }
    </style>

    <div class="container-wraper">
        <section class="content">
            <div class="card rounded-3 shadow-lg border-0">
              <div class="card-header header-flex">
                <h3 class="card-title mb-0" style="font-weight: 600;">
                  Requerimientos por aprobar
                </h3>
              </div>
              <div class="card-body">
                <?php echo $tabla;?>
              </div>
            </div>
          </section>
        </div>
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>