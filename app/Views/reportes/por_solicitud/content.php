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
          <h3 class="card-title">Reporte Por Solicitud</h3>
        </div>
        <form role="form" id="consulta-fecha" method="POST">
          <div class="card-body">
            <div class="row">
              <div class="col-2">
                <label for="rango-consulta">Rango de Fecha</label>
                <input type="text" class="form-control" name="rango-consulta" id="rango-consulta">
              </div>
              <div class="col-3">
                <label for="numero-solicitud">N° de Solicitud</label>
                <input type="text" class="form-control" name="numero-solicitud" id="numero-solicitud">
              </div>
              <div class="col-4">
                <label for="direccion-consulta">Direccion</label>
                <select class="form-control" name="direccion-consulta" id="direccion-consulta">
                  <?php echo $selectDireccion;?>
                </select>
              </div>
              <div class="col-3">
                <label for="departamento-consulta">Departamento</label>
                <select class="form-control" name="departamento-consulta" id="departamento-consulta">
                  <option value="*">Todos</option>
                </select>
              </div>

             
            </div>
          </div>
          <div class="card-footer">
            <button type="submit" class="btn btn-primary">Consultar</button>
           
          </div>
        </form>
      </div>
      <!-- /.card -->

      <div class="card" id="detalles">
        <div class="card-header">
          <h3 class="card-title">Detalles de consulta</h3>
        </div>
        <div class="card-body">
          <div id="detalles-consulta">
          </div>
        </div>
        <!-- /.card-body -->
        <div class="card-footer" id="generar-reporte">
          
        </div>
        <!-- /.card-footer-->
      </div>

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <div class="modal fade" id="consulta-detalle">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Detalles</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body" id="detalle-consulta">
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal">Aceptar</button>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
  <!-- /.modal -->