<div class="content-wrapper">
  <!-- Main content -->
  <section class="content p-2">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="card card-default color-palette-box">
            <div class="card-header">
              <h3 class="card-title">
                <i class="fas fa-edit"></i>
                Editar usuario &nbsp;&nbsp;&nbsp;&nbsp;<label for="user-pass">Activo</label>&nbsp;&nbsp;
                <input type="checkbox" class="usuopborrado" id="usuopborrado" name="usuopborrado" value='false'>
              </h3>
            </div>
            <form role="form" method="POST" id="userinfodata">
              <div class="card-body">
                <input type="hidden" name="userid" id="userid" value="<?php echo $userid; ?>">
                <input type="hidden" name="userid" id="editusudir" value="<?php echo $usudir; ?>">
                <input type="hidden" name="userid" id="editusudep" value="<?php echo $usudep; ?>">
                <input type="hidden" name="userid" id="editrol" value="<?php echo $usurol; ?>">
                <input type="hidden" name="borrado" id="borrado" value="<?php echo $borrado; ?>">
                <input type="hidden" name="borrado_actual" id="borrado_actual" value="<?php echo $borrado; ?>">
                <input type="hidden" name="optype" id="optype" value="0">
                <div class="form-group row">
                  <div class="col-md-6">
                    <label for="userpnom">Primer Nombre</label>
                    <input type="text" class="form-control" id="userpnom" value="<?php echo $userpnom; ?>">
                  </div>
                  <div class="col-md-6">
                    <label for="usersnom">Segundo Nombre</label>
                    <input type="text" class="form-control" id="usersnom" value="<?php echo $usersnom; ?>">
                  </div>
                </div>
                <div class="form-group row">
                  <div class="col-md-6">
                    <label for="userpape">Primer Apellido</label>
                    <input type="text" class="form-control" id="userpape" value="<?php echo $userpape; ?>">
                  </div>
                  <div class="col-md-6">
                    <label for="userspae">Segundo Apellido</label>
                    <input type="text" class="form-control" id="userspae" value="<?php echo $userspae; ?>">
                  </div>
                </div>
                <div class="form-group row">
                  <div class="col-md-6">
                    <label for="useremail">Correo Electrónico</label>
                    <input type="text" class="form-control" id="useremail" value="<?php echo $useremail; ?>">
                  </div>
                  <div class="col-md-6">
                    <label for="usudir">Dirección</label>
                    <select class="form-control" id="usudir" name="usudir" value="">
                      <option value="0" disabled>Seleccione</option>
                    </select>
                  </div>
                </div>
                <div class="form-group row">
                  <div class="col-md-6">
                    <label for="usudep">Departamento</label>
                    <select class="form-control" id="usudep" name="usudep" value="<?php echo $usudep; ?>">
                    </select>
                  </div>
                  <div class="col-md-6">
                    <label for="usurol">Tipo de Usuario</label>
                    <select class="form-control" id="usurol" value="<?php echo $usurol; ?>">
                    </select>
                  </div>
                </div>
              </div>
              <div class="card-footer d-flex justify-content-center">
                <button type="submit" class="btn btn-primary">Guardar</button>&nbsp;
                <button type="reset" class="btn btn-secondary">Limpiar</button>&nbsp;&nbsp;
                <a type="button" class="btn btn-default" href="javascript:history.back()">Cerrar</a>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>


  <!-- <div class="form-group">
                  <label for="userpass">Contraseña</label>
                  <input type="password" class="form-control" id="userpass" value="">
                </div> -->

</div>