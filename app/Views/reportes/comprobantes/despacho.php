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

  <!--
  <img src="<php echo base_url(); ?>/img/cintillo2023.png" style="width:1400px; height: 70px;">
  <small class="float-right">Fecha de Solicitud: <php echo $fecsol; ?></small>
  <br>
  <img src="<php echo base_url(); ?>/img/logo_sis001.png" style="width:120px; height: 90px;"> -->


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
            <!-- <img src="<php echo base_url(); ?>/img/logo_sis001.png" style="max-width: 10rem; max-height: 10rem;"> -->
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
          </address>
        </div>
        <!-- /.col -->
        <div class="col-sm-4 invoice-col">
          <img src="<?php echo base_url(); ?>/img/logo_sis001.png" style="max-width: 10rem; max-height: 10rem;">
        </div>
        <!-- /.col -->
        <div class="col-sm-2 invoice-col">
          <b>Nº de Orden:</b> <?php echo $numorden; ?><br>
          <b>Fecha de Aprobacion:</b> <?php echo $fecaprob; ?><br>
          <b>Fecha de salida :</b> <?php echo $fecsal; ?><br>

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
                <th>N° Unidades aprobadass</th>
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
      <h6 class="text-dark"> <b>Comentario Solicitante:</b>
        &nbsp;&nbsp;<input type="text" id="comentario" name="" disabled="disabled" value="<?php echo $comentario  ?>" style="width: 1000px;">
        <br>
        <hr>
        <b>Comentario Almacenista:</b>
        &nbsp;&nbsp;<input type="text" id="comentario" name="" disabled="disabled" value="<?php echo $commsal  ?>" style="width: 1000px;">
        <hr>

        <div class="card">
          <form id="anual-report" name="anual-report" method="POST" class="form-horizontal">
            <!-- /.card -->
            <div class="row">
              <div class="col-3">
                <div class="card">
                  <div class="card-header">
                    <h5 class="text-primary"><i class="fas fa-angle-double-right"></i> Datos del Solicitante
                  </div>
                  <div class="card-body">
                    <div class="text-muted">
                      <h6 class="text-dark"><i class="fas fa-angle-double-right"></i> Nombre:
                        &nbsp;&nbsp;<input type="text" id="t_usuario" name="" disabled="disabled" value="<?php echo $usupnom . " " . $usupape; ?>" style="width: 200px;">
                        <h6 class="text-dark"><i class="fas fa-angle-double-right"></i> Ubicacion Administrativa:
                          <br> <?php echo $dirnom; ?>&nbsp;&nbsp;<?php echo $depnom; ?><br>
                          <h6 class="text-dark"><i class="fas fa-angle-double-right"></i> Fecha&nbsp;&nbsp;
                            <input type="text" disabled="disabled" id="t_emprendedor" name="" value="<?php echo $fecsol; ?>" style="width: 90px;">

                    </div>
                  </div>
                </div>
              </div>

              <div class="col-3">
                <div class="card">
                  <div class="card-header">
                    <h5 class="text-primary"><i class="fas fa-angle-double-right"></i> Datos del Aprobador
                  </div>
                  <div class="card-body">
                    <div class="text-muted">
                      <h6 class="text-dark"><i class="fas fa-angle-double-right"></i> Nombre:
                        &nbsp;&nbsp;<input type="text" id="t_usuario" name="" disabled="disabled" value="<?php echo $nomb_aprob . " " . $ape_aprob; ?>" style="width: 200px;">
                        <h6 class="text-dark"><i class="fas fa-angle-double-right"></i> Ubicacion Administrativa:
                          <br> <?php echo $dir_aprob; ?>&nbsp;&nbsp;<?php echo $dep_aprob; ?>
                          <h6 class="text-dark"><i class="fas fa-angle-double-right"></i> Fecha:&nbsp;&nbsp;
                            <input type="text" disabled="disabled" id="t_emprendedor" name="" value="<?php echo $fecaprob; ?>" style="width: 80px;">

                    </div>
                  </div>
                </div>
              </div>

              <div class="col-3">
                <div class="card">
                  <div class="card-header">
                    <h5 class="text-primary"><i class="fas fa-angle-double-right"></i> Datos del Almacenista
                  </div>
                  <div class="card-body">
                    <div class="text-muted">
                      <h6 class="text-dark"><i class="fas fa-angle-double-right"></i> Nombre:
                        &nbsp;&nbsp;<input type="text" id="t_usuario" name="" disabled="disabled" value="<?php echo $nomb_despacho . " " . $ape_despacho; ?>" style="width: 200px;">
                        <h6 class="text-dark"><i class="fas fa-angle-double-right"></i> Ubicacion Administrativa:
                          <br> <?php echo $dir_despacho; ?>&nbsp;&nbsp;<?php echo $dep_despacho; ?>
                          <h6 class="text-dark"><i class="fas fa-angle-double-right"></i> Fecha:&nbsp;&nbsp;
                            <input type="text" disabled="disabled" id="t_emprendedor" name="" value="<?php echo $fecsal; ?>" style="width:90px;">
                            <h6 class="text-dark"><i class="fas fa-angle-double-right"></i> Firma:<br> ________________________
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-3">
                <div class="card">
                  <div class="card-header">
                    <h5 class="text-primary"><i class="fas fa-angle-double-right"></i> Datos del Receptor:
                  </div>
                  <div class="card-body">
                    <div class="text-muted">
                      <h6 class="text-dark"><i class="fas fa-angle-double-right"></i> Nombre:________________
                    </div>
                    <br>

                    <h6 class="text-dark"><i class="fas fa-angle-double-right"></i> Fecha: ____________
                      <br> <br>
                      <h6 class="text-dark"><i class="fas fa-angle-double-right"></i> Firma:<br> <br> ________________________
                  </div>
                </div>
              </div>
            </div>

          </form>
        </div>







        <!-- /.col -->
  </div>
  <!-- /.row -->
  </section>
  <!-- /.content -->
  </div>
  <!-- ./wrapper -->

  <script type="text/javascript">
    window.addEventListener("load", window.print());
  </script>
</body>

</html>