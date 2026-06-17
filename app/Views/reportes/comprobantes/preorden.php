<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Sistema de Gestion de Almacen | Servicio Autonomo de la Propiedad Intelectual</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Bootstrap 4 -->
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>/theme/plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>/theme/dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<body>
  <div class="wrapper">
    <!-- Main content -->
    <section class="invoice">
      <!-- title row -->
      <br>
      <br>
      <div class="row">
        <div class="col-12">
          <h2 class="page-header">
            <img src="<?php echo base_url(); ?>/img/cintillo2023.png" style="width:1600px; height: 110px;">
            <br>
            <br>
            <small class="float-right">Fecha de Solicitud: <?php echo $fecsol; ?></small>
          </h2>
        </div>
        <!-- /.col -->
      </div>
      <br>
      <!-- info row -->
      <div class="row invoice-info">
        <div class="col-sm-5 invoice-col">
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
          <img src="<?php echo base_url(); ?>/img/logo_sis001.png" style="max-width: 10rem; max-height: 10rem;">
        </div>
        <!-- /.col -->
        <div class="col-sm-2 invoice-col">
          <b>Nº de Orden:</b> <?php echo $numorden; ?><br>
          <?php if (isset($fecaprob)): ?>
          <b>Fecha de Aprobacion:</b> <?php echo $fecaprob; ?><br>
          <?php endif; ?>
          <br>
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
      <br>
      <!-- Table row -->
      <div class="row">
        <div class="col-12 table-responsive">
          <table class="table table-striped">
            <thead>
              <tr class="text-center">
                <th>Producto</th>
                <th>Nº Unidades solicitadas</th>
                <?php if (isset($numuniap)): ?><th>N° Unidades aprobadas</th><?php endif; ?>
              </tr>
            </thead>
            <tbody>
              <?php echo base64_decode($tabla); ?>
            </tbody>
          </table>
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
      <br>
      <hr>
      <h6 class="text-dark"> <b>Comentario Solicitante:</b> <?php echo $comentario; ?><br>
        <?php if (isset($commsal)): ?>
        <hr>
        <b>Comentario Almacenista:</b> <?php echo $commsal; ?><br>
        <?php endif; ?>
        <hr>
      </h6>

      <?php if (isset($nomb_aprob) || isset($nomb_despacho)): ?>
      <div class="card">
        <div class="row">
          <?php if (isset($nomb_aprob)): ?>
          <div class="col-3">
            <div class="card">
              <div class="card-header">
                <h5 class="text-primary"><i class="fas fa-angle-double-right"></i> Datos del Aprobador</h5>
              </div>
              <div class="card-body">
                <div class="text-muted">
                  <h6 class="text-dark"><i class="fas fa-angle-double-right"></i> Nombre: <?php echo $nomb_aprob . " " . $ape_aprob; ?></h6>
                  <h6 class="text-dark"><i class="fas fa-angle-double-right"></i> Ubicacion: <?php echo $dir_aprob; ?> - <?php echo $dep_aprob; ?></h6>
                  <h6 class="text-dark"><i class="fas fa-angle-double-right"></i> Fecha: <?php echo $fecaprob; ?></h6>
                </div>
              </div>
            </div>
          </div>
          <?php endif; ?>
          <?php if (isset($nomb_despacho)): ?>
          <div class="col-3">
            <div class="card">
              <div class="card-header">
                <h5 class="text-primary"><i class="fas fa-angle-double-right"></i> Datos del Almacenista</h5>
              </div>
              <div class="card-body">
                <div class="text-muted">
                  <h6 class="text-dark"><i class="fas fa-angle-double-right"></i> Nombre: <?php echo $nomb_despacho . " " . $ape_despacho; ?></h6>
                  <h6 class="text-dark"><i class="fas fa-angle-double-right"></i> Ubicacion: <?php echo $dir_despacho; ?> - <?php echo $dep_despacho; ?></h6>
                  <h6 class="text-dark"><i class="fas fa-angle-double-right"></i> Fecha: <?php echo $fecsal; ?></h6>
                </div>
              </div>
            </div>
          </div>
          <?php endif; ?>
        </div>
      </div>
      <?php endif; ?>
    </section>
    <!-- /.content -->
  </div>
  <!-- ./wrapper -->

  <script type="text/javascript">
    window.addEventListener("load", window.print());
  </script>
</body>
</html>
