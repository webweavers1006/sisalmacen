<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <link rel="stylesheet" href="<?php echo base_url(); ?>/css/reportes.css">

  <link rel="stylesheet" href="<?php echo base_url(); ?>/css/botones_datatable.css">
  <style>
    table.dataTable thead,
    table.dataTable tfoot {
      background: linear-gradient(to right, #a9b6c2, #a9b6c2, #a9b6c2);
    }
  </style>
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Panel de Control</h1>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <!-- Tabla de Usuarios -->
      <div class="row">
        <div class="col-12">
          <div class="card card-default color-palette-box">
            <div class="card-header">
              <h3 class="card-title">
                <i class="fas fa-user"></i>
                Usuarios
              </h3>
              <div class="card-tools">
                <button type="button" class="btn btn-sm btn-light dropdown-toggle dropdown-icon" data-toggle="dropdown"><i class="fas fa-plus"></i></button>
                <div class="dropdown-menu">
                  <a class="dropdown-item" alt="Añadir Usuario" href="/adduser">Añadir</a>
                  <a class="dropdown-item userdel">Borrar</a>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-lg-12 col-sm-12 col-md-12 ">
                <div class="card-body">
                  <table class="display" id="table_usuarios" style="width:100%" style="margin-top: 20px">
                    <thead>
                      <tr>
                        <td>Primer Nombre</td>
                        <td>Segundo Nombre</td>
                        <td>Primer Apellido</td>
                        <td>Segundo Apeliido</td>
                        <td>Correo Electronico</td>
                        <td>Departamento</td>
                        <td>Estatus</td>
                        <td class="text-center" style="width: 5%;">Editar</td>
                      </tr>
                    </thead>
                    <tbody id="users">
                    </tbody>
                  </table>
                </div>
              </div>
            </div>

          </div>
        </div>
      </div>
      <!-- Tabla de Departamentos, Direcciones  -->
      <div class="row " id="complementos1" style="display: none;">
        <div class="col-6">
          <div class="card card-default color-palette-box">
            <div class="card-header">
              <h3 class="card-title">
                <i class="fas fa-user"></i>
                Departamentos
              </h3>
              <div class="card-tools">
                <button type="button" class="btn btn-sm btn-light dropdown-toggle dropdown-icon" data-toggle="dropdown"><i class="fas fa-plus"></i></button>
                <div class="dropdown-menu">
                  <a class="dropdown-item" alt="Añadir Usuario" data-toggle="modal" data-target="#adddep">Añadir</a>
                  <a class="dropdown-item depedit">Editar</a>
                  <a class="dropdown-item depdel">Borrar</a>
                </div>
              </div>
            </div>
            <div class="card-body p-0">
              <table class="table table-responsive table-hover table-striped">
                <thead>
                  <tr>
                    <td></td>
                    <td>Nombre Departamento</td>
                    <td>Dependencia</td>
                  </tr>
                </thead>
                <tbody id="departaments">

                </tbody>
              </table>
            </div>
          </div>
        </div>
        <div class="col-6">
          <div class="card card-default color-palette-box">
            <div class="card-header">
              <h3 class="card-title">
                <i class="fas fa-user"></i>
                Direcciones
              </h3>
              <div class="card-tools">
                <button type="button" class="btn btn-sm btn-light dropdown-toggle dropdown-icon" data-toggle="dropdown"><i class="fas fa-ellipsis"></i></button>
                <div class="dropdown-menu">
                  <a class="dropdown-item" alt="Añadir Usuario" data-toggle="modal" data-target="#adddir">Añadir</a>
                  <a class="dropdown-item diredit">Editar</a>
                  <a class="dropdown-item dirdel">Borrar</a>
                </div>
              </div>
            </div>
            <div class="card-body p-0">
              <table class="table table-responsive table-hover table-striped">
                <thead>
                  <td></td>
                  <td>Nº</td>
                  <td>Nombre</td>
                </thead>
                <tbody id="directions">
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
      <!-- Tabla de Roles  -->


      <div class="row" id="complementos2" style="display: none;">
        <div class="col-6">
          <div class="card card-default color-palette-box">
            <div class="card-header">
              <h3 class="card-title">
                <i class="fas fa-user"></i>
                Roles
              </h3>
              <div class="card-tools">
                <button type="button" class="btn btn-sm btn-light dropdown-toggle dropdown-icon" data-toggle="dropdown"><i class="fas fa-plus"></i></button>
                <div class="dropdown-menu">
                  <a class="dropdown-item" alt="Añadir Modulo" data-toggle="modal" data-target="#addrol">Añadir</a>
                  <a class="dropdown-item roledit">Editar</a>
                  <a class="dropdown-item roldel">Borrar</a>
                </div>
              </div>
            </div>
            <div class="card-body">
              <table class="table table-responsive table-hover table-striped tabla">
                <thead>
                  <tr>
                    <td style="max-width: 33%"></td>
                    <td>Nombre</td>
                  </tr>
                </thead>
                <tbody id="roles">
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>

      <!-- /.row -->
    </div><!-- /.container-fluid -->
  </section>
  <!-- /.content -->
  <!--Modal para añadir los departamentos-->
  <div class="modal fade" id="adddep">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Añadir Departamento</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form role="form" method="POST" id="depform">
          <div class="modal-body">
            <input type="hidden" id="depid" name="depid">
            <div class="form-group">
              <label for="nomdep">Nombre del departamento</label>
              <input class="form-control" type="text" name="nomdep" id="nomdep">
            </div>
            <div class="form-group">
              <label for="dirdep">Dependencia</label>
              <select class="form-control" id="depdir">
              </select>
            </div>
          </div>
          <div class="modal-footer justify-content-end">
            <button type="submit" class="btn btn-primary">Guardar</button>
            <button type="reset" class="btn btn-secondary">Limpiar</button>
            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
          </div>
        </form>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
  <!--Modal para añadir las direcciones-->
  <div class="modal fade" id="adddir">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Añadir Direccion</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form role="form" method="POST" id="dirform">
          <input type="hidden" name="iddir" id="iddir">
          <div class="modal-body">
            <div class="form-group">
              <label for="nomdir">Nombre de la direccion</label>
              <input class="form-control" type="text" name="nomdir" id="nomdir">
            </div>
          </div>
          <div class="modal-footer justify-content-end">
            <button type="submit" class="btn btn-primary">Guardar</button>
            <button type="reset" class="btn btn-secondary">Limpiar</button>
            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
          </div>
        </form>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
  <!--Modal para añadir los modulos-->
  <div class="modal fade" id="addrol">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Añadir Rol de usuario</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form role="form" method="POST" id="rolform">
          <div class="modal-body">
            <input type="hidden" name="rolid" id="rolid">
            <div class="form-group">
              <label for="modnom">Nombre de Rol</label>
              <input class="form-control" type="text" name="rolnom" id="rolnom">
            </div>
          </div>
          <div class="modal-footer justify-content-end">
            <button type="submit" class="btn btn-primary">Guardar</button>
            <button type="reset" class="btn btn-secondary">Limpiar</button>
            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
          </div>
        </form>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
  <!-- /.modal -->


  <!--/.Cambiar clave-->
  <div class="modal fade" id="cambiar_clave">
    <div class="modal-dialog modal-md">
      <div class="modal-content">
        <form id="caso-remitido" method="POST">
          <div class="modal-header">
            <h4 class="modal-title">Cambio de Password</h4>
            <input type="hidden" id="idcaso" name="" value="">
            <button type=" button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="form-group">
              <input type="hidden" name="id_usuario" id="id_usuario" class="form-control">
              <label for="user-pass">Contraseña</label>
              <input type="password" name="edit-user-pass" id="edit-user-pass" class="form-control">
              <label for="user-pass">Confirmar Contraseña</label>
              <input type="password" name="edit-user-confirm-pass" id="edit-user-confirm-pass" class="form-control">
            </div>
          </div>
          <div class="modal-footer justify-content-between">
            <button type="reset" class="btn btn-sm  btn-default" data-dismiss="modal">Cerrar</button>
            <button type="button" disabled="disabled " id="guadar_clave" class="btn  btn-sm  btn-primary">Guardar</button>
          </div>
        </form>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>

</div>




<a id="back-to-top" href="#" class="btn btn-primary back-to-top" role="button" aria-label="Scroll to top">
  <i class="fas fa-chevron-up"></i>
</a>
</div>
<!-- /.content-wrapper -->