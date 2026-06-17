  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <style>
      @media print {
        .no-print { display: none !important; }
      }
    </style>
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
                    <img src="<?php echo base_url();?>/img/Logosapi-2020.png" style="max-width: 6rem; max-height: 6rem;">
                    <small class="float-right">Fecha de Entrada: <?php echo $fechent;?></small>
                  </h4>
                </div>
                <!-- /.col -->
              </div>
              <!-- info row -->
              <div class="row invoice-info">
                <div class="col-sm-4 invoice-col">
                  Proveedor
                  <address>
                    <strong><?php echo $provnom;?></strong><br>
                    Direccion: <?php echo $provdir;?><br>
                    Telefono Principal: <?php echo $provtel1;?><br>
                    Telefono Secundario: <?php echo $provtel2;?><br>
                    Email: <?php echo $provemail;?>
                  </address>
                </div>
                <!-- /.col -->
                <div class="col-sm-4 invoice-col">
                  
                </div>
                <!-- /.col -->
                <div class="col-sm-4 invoice-col">
                  <b>Factura N°: <?php echo $numfac;?></b><br>
                  <br>
                  <b>Registro de entrada N°:</b> <?php echo $numregent;?><br>
                  <b>Fecha de Factura:</b> <?php echo $fecfac;?><br>
                  <b>Recibido por:</b> <?php echo $usupnom.' '.$usupape;?><br>
                  <b>Comentario:</b> <?php echo $entcoment; ?>
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->

              <!-- Table row -->
              <div class="row">
                <div class="col-12 table-responsive">
                  <table class="table table-striped tabla">
                    <thead>
                    <tr>
                      <th>Producto</th>
                      <th>Presentacion</th>
                      <th>N° de Unidades</th>
                      <th>Costo Unitario</th>
                    </tr>
                    </thead>
                    <tbody>
                    	<?php echo $tbody;?>
                    </tbody>
                  </table>
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
                  <button onclick="window.print();" class="btn btn-default"><i class="fas fa-print"></i> Imprimir</button>
                  <a type="button" class="btn btn-success float-right" href="javascript:history.back()">Cerrar</a>
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