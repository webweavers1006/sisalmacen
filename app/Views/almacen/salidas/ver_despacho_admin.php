  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h3>Orden N°: <?php echo $numorden; ?> </h3>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">

            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">



            <!-- Main content -->
            <div class="invoice p-3 mb-3">
              <!-- title row -->
              <div class="row">
                <div class="col-12">
                  <h4>
                    <img src="<?php echo base_url(); ?>/img/Logosapi-2020.png" style="max-width: 10rem; max-height: 10rem;">
                    <small class="float-right">Fecha de Solicitud: <?php echo $fecsol; ?></small>
                  </h4>
                </div>
                <!-- /.col -->
              </div>
              <!-- info row -->
              <div class="row invoice-info">
                <div class="col-sm-4 invoice-col">
                  Solicitante 77
                  <address>
                    <strong><?php echo $usupnom . " " . $usupape; ?></strong><br>
                    <?php echo $dirnom; ?><br>
                    <?php echo $depnom; ?><br>
                  </address>
                </div>
                <!-- /.col -->
                <div class="col-sm-4 invoice-col">

                </div>
                <!-- /.col -->
                <div class="col-sm-4 invoice-col">
                  <b>Fecha de Aprobacion: <?php echo $fecaprob; ?></b><br>
                  <br>
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->

              <!-- Table row -->
              <div class="row">
                <div class="col-12 table-responsive">
                  <?php echo $tbody; ?>
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->

              <div class="row">

                <div class="col-6">
                </div>
                <!-- /.col -->
                <div class="col-6">
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->

              <!-- this row will not appear when printing -->
              <div class="row no-print">
                <div class="col-12">
                  <a href="/comprobanteDespacho/<?php echo $datos; ?>/<?php echo $status; ?>" target="_blank" class="btn btn-default"><i class="fas fa-print"></i> Imprimir</a>
                </div>
              </div>
            </div>
            <!-- /.invoice -->
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>