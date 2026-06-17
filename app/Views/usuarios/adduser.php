<div class="content-wrapper">
  <!-- Main content -->
  <section class="content p-2">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="card card-default color-palette-box">
            <div class="card-header">
              <h3 class="card-title">
                <i class="fas fa-user"></i>
                Añadir Usuario
              </h3>
            </div>
            <form role="form" method="POST" id="userinfodata">
              <div class="card-body">
                <input type="hidden" name="userid" id="userid" value="">
                <div class="form-group">
                  <label for="userpnom">Primer Nombre</label>
                  <input type="text" class="form-control required text" id="userpnom" value="" name="userpnom">
                </div>
                <div class="form-group">
                  <label for="usersnom">Segundo Nombre</label>
                  <input type="text" class="form-control required text" id="usersnom" value="" name="usersnom">
                </div>
                <div class="form-group">
                  <label for="userpape">Primer Apellido</label>
                  <input type="text" class="form-control required text" id="userpape" value="" name="userpape">
                </div>
                <div class="form-group">
                  <label for="userspae">Segundo Apellido</label>
                  <input type="text" class="form-control required text" id="userspae" class="" value="" name="userspae">
                </div>
                <div class="form-group">
                  <label for="useremail">Correo Electronico</label>
                  <input type="email" class="form-control required email" id="useremail" value="" name="useremail">
                </div>
                <div class="form-group">
                  <label for="userpass">Contraseña</label>
                  <input type="password" class="form-control required" id="userpass" value="" name="userpass">
                </div>
                <div class="form-group">
                  <label for="dirdep">Direccion</label>
                  <select class="form-control" id="usudir" name="usudir">
                  </select>
                </div>
                <div class="form-group">
                  <label for="depnom">Departamento</label>
                  <select class="form-control required" id="usudep" name="usudep" >
                  </select>
                </div>
                <div class="form-group">
                  <label for="roluser">Tipo de Usuario</label>
                  <select class="form-control required" id="usurol" name="usurol">
                  </select>
                </div>
              </div>
              <div class="card-footer justify-content-end">
                <button type="submit" class="btn btn-primary">Guardar</button>
                <button type="reset" class="btn btn-secondary">Limpiar</button>
                <a type="button" class="btn btn-default" href="javascript:history.back()">Cerrar</a>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>