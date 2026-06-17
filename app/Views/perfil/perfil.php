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
                Editar usuario
              </h3>
            </div>
            <form role="form" method="POST" id="userinfodata">
              <div class="card-body">
                <input type="hidden" name="userid" id="userid" value="<?php echo $userid;?>">
                <input type="hidden" name="optype" id="optype" value="1">
                <div class="form-group">
                  <label for="userpnom">Primer Nombre</label>
                  <input type="text" class="form-control" id="userpnom" value="<?php echo $userpnom;?>" required>
                </div>
                <div class="form-group">
                  <label for="usersnom">Segundo Nombre</label>
                  <input type="text" class="form-control" id="usersnom"  value="<?php echo $usersnom;?>" required>
                </div>
                <div class="form-group">
                  <label for="userpape">Primer Apellido</label>
                  <input type="text" class="form-control" id="userpape" value="<?php echo $userpape;?>" required>
                </div>
                <div class="form-group">
                  <label for="userspae">Segundo Apellido</label>
                  <input type="text" class="form-control" id="userspae" value="<?php echo $userspae;?>" required>
                </div>
                <div class="form-group">
                  <label for="useremail">Correo Electronico</label>
                  <input type="text" class="form-control" id="useremail" value="<?php echo $useremail;?>" disabled required>
                </div>
                <div class="form-group">
                  <label for="userpass">Contraseña</label>
                  <input type="password" class="form-control" id="userpass" value="" required>
                </div>
                  <input type="hidden" id="usudir" name="usudir" value="<?php echo $usudir;?>" disabled required>
                  <input type="hidden" id="usudep" name="usudep" value="<?php echo $usudep;?>" disabled required>
                  <input type="hidden" id="usurol" value="<?php echo $usurol;?>" disabled required>
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