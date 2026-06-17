<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
          </div><!-- /.col -->
          <div class="col-sm-6">
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <!-- container-fluid -->
      <div class="container-fluid">
        <div class="row">
          <section class="col-lg-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">
                  Solicitudes en Tramite
                </h3>
              </div>
              <div class="card-body">
                <table class="table table-light table-hover table-bordered">
                  <thead>
                    <tr>
                      <td>Número de Orden</td>
                      <td>Fecha de Solicitud</td>
                      <td>Usuario Solicitantes</td>
                      <td>Acciones</td>
                    </tr>
                  </thead>
                  <tbody>
                    <?php echo $tbody;?>
                  </tbody>
                </table>
              </div>
            </div>
          </section>
        </div>
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>