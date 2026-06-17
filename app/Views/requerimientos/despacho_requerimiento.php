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
                      <b>Fecha de Aprobacion: <?php echo $fecapsol;?></b>
                      <br>
                    </div>
                    <!-- /.col -->
                  </div>
                  <!-- /.row -->

                  <!--Form para la carga de la factura-->
                  <form role="form" method="POST" id="detalle-entrada">
                    <div class="row p-1">
                      <div class="card">
                        <div class="card-header">
                          <h3 class="card-title">Detalles de la factura</h3>
                        </div>
                        <div class="card-body">
                          <div class="row">
                            <div class="col-2">
                              <label for="numfac">Factura Nº</label>
                              <input type="number" class="form-control" id="numfac" name="numfac" required>
                            </div>
                            <div class="col-2">
                              <label for="fecfac">Fecha Factura</label>
                              <input type="text" class="form-control" id="fecfac" name="fecfac" required>
                            </div>
                            <div class="col-1">
                              <label for="tipoprov">Tipo</label>
                              <select class="form-control" name="tipoprov" id="tipoprov">
                                <option value="J">J</option>
                                <option value="G">G</option>
                                <option value="V">V</option>
                              </select>
                            </div>
                            <div class="input-group col-3 mb-3">
                              <label>N° de Rif</label>
                              <div class="w-100"></div>
                              <input type="number" id="rifprov" name="rifprov" class="form-control" required>
                              <div class="input-group-append">
                                <button class="input-group-text" id="busqueda-proveedor"><i class="fas fa-search"></i></button> 
                              </div> 
                            </div>
                            <input type="hidden" name="idprov" id="idprov">
                            <div class="col-4">
                              <label for="nomprov">Nombre o Razon social</label>
                              <input type="text" class="form-control" id="nomprov" name="nomprov" disabled required>
                            </div>
                          </div>
                          <div class="row pt-3">
                            <div class="col-2">
                              <label for="fecfac">Fecha de Entrada</label>
                              <input type="text" class="form-control" id="fecent" name="fecent" placeholder="Fecha de entrada al almacen" disabled value="<?php echo date('d/m/Y');?>" required>
                            </div>
                            <div class="col-10">
                              <label for="entcoment">Comentario Adicional</label>
                              <input type="text" class="form-control" id="entcoment" name="entcoment" value="<?php echo $entcomment;?>" disabled required>
                            </div>
                          </div>
                          <div class="row pt-3">
                            <div class="col-12">
                              <div class="float-right">
                                <button class="btn btn-sm btn-success" type="submit">Aceptar</button>
                                <button class="btn btn-sm btn-primary" type="reset">Limpiar</button>
                                <a class="btn btn-sm btn-danger" href="javascript:history.back()">Volver</a>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </form>
                  <!-- Table row -->
                  <input type="hidden" name="numregent" id="numregent">
                  <form role="form" method="POST" id="despacho-requerimiento">
                  	<input type="hidden" name="reqid" id="reqid" value="<?php echo $reqid;?>">
                    <input type="hidden" name="ususol" id="ususol" value="<?php echo $ususol;?>">
                    <input type="hidden" name="usureg" id="usureg" value="<?php echo $usureg;?>">
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
	                      <a href="#" target="_blank" class="btn btn-default"><i class="fas fa-print"></i>Imprimir</a>
	                        
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
  <!--Modal para añadir el proveedor-->
  <div class="modal fade" id="add-proveedor">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Nuevo Proveedor</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form role="form" method="POST" id="newProvider">
          <div class="modal-body">
            <label>Datos de la empresa</label>
            <div class="row">
              <div class="col-4">
                <input type="text" disabled name="frmnewnumrif" id="frmnewnumrif" class="form-control" placeholder="Número de RIF">
              </div>
              <div class="col-8">
                <input type="text" name="frmnewnomprov" id="frmnewnomprov" class="form-control" placeholder="Nombre de la empresa">
              </div>
          </div>
          <label>Datos de contacto</label>
            <div class="row p-2">
              <div class="col-12">
                <input type="text" name="frmnewdireccprov" id="frmnewdireccprov" class="form-control" placeholder="Direccion de la empresa">
              </div>
            </div>
            <div class="row p-2">
              <div class="col-3">
                <input class="form-control" type="text" name="frmnewtelef1" id="frmnewtelef1" placeholder="Telefono Principal">
              </div>
              <div class="col-3">
                <input class="form-control" type="text" name="frmnewtelef2" id="frmnewtelef2" placeholder="Telefono Secundario">
              </div>
              <div class="col-6">
                <input class="form-control" type="email" name="frmnewcontemail" id="frmnewcontemail" placeholder="Correo electronico">
              </div>
            </div>
          </div>
          <!-- /.card-body -->
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Guardar</button>
            <button type="reset" class="btn btn-secondary">Limpiar</button>
            <button type="reset" class="btn btn-default" data-dismiss="modal">Cerrar</button>
          </div>
        <!-- /.card-footer-->
        </form>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>