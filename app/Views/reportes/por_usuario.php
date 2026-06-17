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
          <h3 class="card-title">Reporte Por Usuario</h3>
        </div>
        <div class="card-body">
          <form role="form" id="consulta-usuario" method="POST">
            <div class="form-group">
              <label for="tipo-consulta">Tipo de Consulta</label>
              <select  id="tipo-consulta" name="tipo-consulta" class="form-control">
                <option value="1">Requisiciones</option>
                <option value="2">Requerimientos</option>
              </select>
            </div>
            <div class="form-group">
              <label for="usuario-consulta">Usuario a Consultar</label>
              <select id="usuario-consulta" name="usuario-consulta" class="form-control">
                <!--Usuarios Cargados dinamicamente-->
              </select>
            </div>
            <button type="submit" class="btn btn-primary">Consultar</button>
            <button type="reset" class="btn btn-success">Limpiar</button>
            <a href="javascript:history.back();" class="btn btn-secondary">Volver</a>
          </form>
        </div>
      </div>
      <!-- /.card -->

      <div class="card" id="detalles">
        <div class="card-header">
          <h3 class="card-title">Detalles de consulta</h3>
        </div>
        <div class="card-body">
          <table class="table table-light table-hover text-center">
            <thead>
              <tr>
                <th>N° Orden</th>
                <th>Estatus</th>
                <th>Detalles</th>
              </tr>
            </thead>
            <tbody id="detalles-consulta">
            </tbody>
          </table>
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
          <form id="generar-reporte" role="form">
            <input type="hidden" id="tipo-reporte" value="">
            <input type="hidden" id="usuario-reporte" value="">
            <button type="submit" class="btn btn-success btn-sm"><i class="fas fa-pdf"></i> Generar Reporte</button>
          </form>
        </div>
        <!-- /.card-footer-->
      </div>

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->