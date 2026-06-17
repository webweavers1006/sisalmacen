  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h3 class=""> Orden N° : <?php echo $numorden; ?></h3>
          </div>
          <img src="<?php echo base_url(); ?>/img/cintillo2023.png" style="width:1400px; height: 55px;">
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


                  </h4>
                  <small class=" float-right">Fecha de Solicitud: <?php echo $fecsol; ?></small>
                </div>
                <!-- /.col -->
              </div>
              <!-- info row -->
              <div class="row invoice-info">
                <div class="col-sm-4 invoice-col">
                  Solicitante
                  <address>
                    <strong><?php echo $usupnom . " " . $usupape; ?></strong><br>
                    <?php echo $dirnom; ?><br>
                    <?php echo $depnom; ?><br>
                    <b> Comentario Solicitante:</b> <?php echo $comentario; ?><br>
                  </address>
                </div>

                <!-- /.col -->
                <div class="col-sm-4 invoice-col">

                </div>
                <!-- /.col -->
                <div class="col-sm-4 invoice-col">

                  <!-- <b>Fecha de Solicitud:</b> <php echo $fecsol; ?><br> -->
                  <b>Fecha de Aprobacion:</b> <?php echo $fecaprob; ?><br>
                  <b>Fecha de salida :</b> <?php echo $fecsal; ?><br>
                  <b>Comentario Almacenista:</b> <?php echo $commsal; ?><br>
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
                  <a href="javascript:history.back()" class="btn btn-success float-right">Volver</a>
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
