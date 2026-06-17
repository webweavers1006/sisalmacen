  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-12 col-sm-12 col-md-12 p-2">
            <div class="card">
              <div class="card-header border-0">
                <div class="d-flex justify-content-between">
                  <h3 class="card-title">Consolidados de entradas y salidas de articulos por departamentos</h3>
                    <button class="btn btn-light" id="generaArchivoExcel"><i class="fas fa-file-excel"></i> Generar Archivo Excel</button>
                </div>
              </div>
              <div class="card-body">
                <!--Form-->
                <form id="consulta-articulos" method="POST">
                  <div class="row">
                    <div class="col-3">
                      <label for="rango-consulta">Rango de consulta</label>
                      <input type="text" class="form-control" id="rango-consulta" name="rango-consulta" required>
                    </div>
                    <div class="col-3">
                      <label for="direcciones">Direcciones</label>
                      <select id="direcciones" name="direcciones" class="form-control">
                      </select>
                    </div>
                    <div class="col-3">
                      <label for="departamentos">Departamentos</label>
                      <select id="departamentos" name="departamentos" class="form-control">
                      </select>
                    </div>
                    <div class="col-2">
                      <div class="p-3"></div>
                      <button type="submit" class="btn btn-primary">Consultar</button>
                    </div>
                  </div>
                </form>
                <!--Chart-->
                <div class="row" id="grafico">
                  <div class="col-12 p-4">
                    <div class="d-flex">
                      <p class="d-flex flex-column">
                        <span class="text-bold text-lg">Grafico de operaciones</span>
                      </p>
                    </div>
                    <!-- /.d-flex -->
                    <div class="position-relative mb-4">
                      <canvas id="salida" height="200"></canvas>
                    </div>
                  </div>
                </div>
                <!-- /Chart-->
                <!--Table result-->
                <div class="row">
                  <div class="col-12 p-2">
                    <div id="tabla">
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>


  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->