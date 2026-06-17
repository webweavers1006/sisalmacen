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

    <!-- Main content -->
    <section class="content">
      <!-- Default box -->
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Consulta Proveedores</h3>
          <div class="card-tools">
          	<a class="btn btn-sm btn-primary" href="/newprovider" >Añadir</a>
          </div>
        </div>
        <div class="card-body">
        	<div id="listaProveedores">
                <?php echo base64_decode($tbody);?>
            </div>
          </div>
          <!-- /.card-body -->
        <!-- /.card-footer-->
      </div>

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

<div class="modal fade" id="detalleProveedor"> 
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Detalles Proveedor</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form role="form" method="POST" id="provDetalle">
                <div class="modal-body">
                    <label>Direccion</label>
                    <div class="row p-2">
                        <div class="col-12">
                            <input disabled type="text" name="detdirecc" id="detdirecc" class="form-control" placeholder="Direccion de la empresa">
                        </div>
                    </div>
                    <label>Correo Electronico</label>
                    <div class="row p-2">
                        <div class="col-6">
                            <input disabled class="form-control" type="email" name="detemail" id="detemail" placeholder="Correo electronico">
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                </div>
            </form>
        </div>
        <!-- /.modal-dialog -->
    </div>
</div>

<div class="modal fade" id="editarProveedor">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Editar Proveedor</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form role="form" method="POST" id="editProvider">
                <input type="hidden" id="idprov" name="idprov">
                <div class="modal-body">
                    <label>Datos de la empresa</label>
                    <div class="row">
                        <div class="col-3">
                            <select name="tipoper" class="form-control" id="tipoper">
                                <option value="V">V - Venezolano</option>
                                <option value="J">J - Juridico</option>
                                <option value="G">G - Gobierno</option>
                            </select>
                        </div>
                        <div class="col-3">
                            <input type="number" name="numrif" id="numrif" class="form-control" placeholder="Número de RIF">
                        </div>
                        <div class="col-6">
                            <input type="text" name="nomprov" id="nomprov" class="form-control" placeholder="Nombre de la empresa">
                        </div>
                    </div>
                    <label>Datos de contacto</label>
                    <div class="row p-2">
                        <div class="col-12">
                            <input type="text" name="direccprov" id="direccprov" class="form-control" placeholder="Direccion de la empresa">
                        </div>
                    </div>
                    <div class="row p-2">
                        <div class="col-3">
                            <input class="form-control" type="text" name="telef1" id="telef1" placeholder="Telefono Principal">
                        </div>
                        <div class="col-3">
                            <input class="form-control" type="text" name="telef2" id="telef2" placeholder="Telefono Secundario">
                        </div>
                        <div class="col-6">
                            <input class="form-control" type="email" name="contemail" id="contemail" placeholder="Correo electronico">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                    <button type="reset" class="btn btn-secondary">Limpiar</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                </div>
            </form>
        </div>
    </div>
</div>







