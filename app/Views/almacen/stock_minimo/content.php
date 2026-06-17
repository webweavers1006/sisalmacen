<meta charset="utf-8">
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
      #table_stock_minimo thead th {
        background: #4b647c !important;
        color: white !important;
        font-weight: 500;
        border: none !important;
      }
    </style>
  <!-- Main content777 -->
  <div class="content">
    <div class="container-wraper">
      <div class="row">
        <div class="col-lg-12 col-sm-12 col-md-12 p-2">

        </div>
      </div>
      <!--Form-->

      <div class="row">

        <div class="col-lg-12 col-sm-12 col-md-12 ">
            <div class="card rounded-3 shadow-lg border-0">
              <div class="card-header header-flex">
                <h3 class="card-title mb-0" style="font-weight: 600;">Stock Mínimo</h3>
              </div>
              <div class="card-body">
                <form role="form" method="POST" id="filtrar">
                  <div class="form-group">
                  <label for="categoria">Stock Minimo</label>
                  
                </div>
              </form>
            <div class="p-3">
              <table class="table table-hover mb-0" id="table_stock_minimo" style="width:100%">
                <thead>
                  <tr>
                    <th style="width:11%">Codigo</th>
                    <th style="width:11%">ID Item</th>
                    <th>Marca</th>
                    <th style="width:40%">Producto</th>
                    <th style="width:11%">Cant</th>
                  </tr>
                </thead>
                <tbody id="listar_casos">
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- /.card-body -->
    <!-- <div class="card-footer">
      <div class="row">
        <div class="col-1">
          Leyenda:
        </div>
        <div class="col-2">
          <span class="badge badge-warning">Pocas Unidades</span>
        </div>
        <div class="col-2">
          <span class="badge badge-danger">Agotado</span>
        </div>
      </div>
    </div> -->
  </div>
  <!-- /.card -->

  </section>

  <!-- <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
  <script>
    $.extend($.fn.dataTable.defaults, {
      language: {
        url: '//cdn.datatables.net/plug-ins/1.10.24/i18n/Spanish.json'
      },
      // Otros ajustes del DataTable
    });
  </script> -->
</div>

    <!-- /.card-body -->
    <!-- <div class="card-footer">
      <div class="row">
        <div class="col-1">
          Leyenda:
        </div>
        <div class="col-2">
          <span class="badge badge-warning">Pocas Unidades</span>
        </div>
        <div class="col-2">
          <span class="badge badge-danger">Agotado</span>
        </div>
      </div>
    </div> -->
  </div>
  <!-- /.card -->

  </section>

  <!-- <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
  <script>
    $.extend($.fn.dataTable.defaults, {
      language: {
        url: '//cdn.datatables.net/plug-ins/1.10.24/i18n/Spanish.json'
      },
      // Otros ajustes del DataTable
    });
  </script> -->
</div>