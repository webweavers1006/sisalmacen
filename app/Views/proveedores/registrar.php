<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
          </div>
          <div class="col-sm-6">
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Nuevo proveedor</h3>

          <div class="card-tools">
          </div>
        </div>
        <form role="form" method="POST">
          <div class="card-body">
            <label>Datos de la empresa</label>
            <div class="row">
              <div class="col-1">
                <select class="form-control" id="tipoper" name="tipoper">
                  <option>V</option>
                  <option>J</option>
                  <option>G</option>
                </select>
              </div>
              <div class="col-4">
                <input class="form-control" type="number" name="numrif" id="numrif" placeholder="RIF de la empresa">
              </div>
              <div class="col-7">
                <input class="form-control" type="text" name="nomprov" id="nomprov" placeholder="Nombre de la empresa">
              </div>
            </div>
            <label>Datos de contacto</label>
            <div class="row">
              <div class="col-4">
                <input class="form-control" type="email" name="email" id="email" placeholder="Correo electronico">
              </div>
              <div class="col-6">
                <textarea class="form-control" name="direccprov" id="direccprov" placeholder="Direccion"></textarea>
              </div>
            </div>
            <div class="row p-2">
              <div class="col-5">
                <input class="form-control" placeholder="Telefono principal" type="text" name="telef1" id="telef1">
              </div>
              <div class="col-5">
                <input class="form-control" placeholder="Telefono secundario" type="text" name="telef2" id="telef2">
              </div>
            </div>
          </div>
          <!-- /.card-body -->
          <div class="card-footer">
            <button class="btn btn-primary" type="submit">Guardar</button>
            <button class="btn btn-primary" type="reset">Limpiar</button>
            <a type="button" class="btn btn-danger" href="javascript:history.back()">Cerrar</a>
          </div>
          <!-- /.card-footer-->
        </form>
      </div>
      <!-- /.card -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->