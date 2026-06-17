<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Requerimiento Nº : <?php echo $reqid;?></h1>
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
                      <img src="<?php echo base_url();?>/img/Logosapi-2020.png" style="max-width: 10rem; max-height: 10rem;">
                      <small class="float-right">Fecha: <?php echo $fechasol;?></small>
                    </h4>
                  </div>
                  <!-- /.col -->
                </div>
                <!-- info row -->
                  <div class="row invoice-info">
                    <div class="col-sm-4 invoice-col">
                      Solicitud por
                      <address>
                        <strong><?php echo $usupnom.' '.$usupape;?></strong><br>
                        <?php echo $dirnom;?><br>
                        <?php echo $depnom;?><br>
                      </address>
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-4 invoice-col">
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-4 invoice-col">
                    </div>
                    <!-- /.col -->
                  </div>
                  <!-- /.row -->

                  <!-- Table row -->
                  <form role="form" method="POST" id="nuevo-requerimiento">
                  	<input type="hidden" name="reqid" id="reqid" value="<?php echo $reqid;?>">
                    <input type="hidden" name="ususol" id="ususol" value="<?php echo $ususol;?>">
	                  <div class="row">
	                    <div class="col-12 table-responsive">
	                      		<?php echo $tbody;?>
	                    </div>
	                    <!-- /.col -->
	                  </div>
	                  <!-- /.row -->

	                  <div class="row">
	                    <!-- accepted payments column -->
	                    <div class="col-6">
	                    </div>
	                    <!-- /.col -->
	                    <div class="col-6">

	                      <div class="table-responsive">
	                        <table class="table">
	                        </table>
	                      </div>
	                    </div>
	                    <!-- /.col -->
	                  </div>
	                  <!-- /.row -->

	                  <!-- this row will not appear when printing -->
	                  <div class="row no-print">
	                    <div class="col-12">
                      <button id="<?php echo $reqid;?>" class="btn btn-sm btn-danger eliminar-solicitud"><i class="fas fa-trash"></i>Eliminar Requerimiento</button>
	                        
	                        <button type="submit" class="btn btn-success float-right p-2">Aprobar</button>
	                        <a type="button" class="btn btn-secondary float-right p-2" href="javascript:history.back()">Cerrar</a>
	                      </form>
	                    </div>
	                  </div>
	              </form>
              </div>
              <!-- /.invoice -->
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>