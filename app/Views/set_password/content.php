<body class="hold-transition login-page">
  <div class="login-box">
    <div class="login-logo">
      <img src="<?php echo base_url(); ?>/img/Logosapi-2020.png" style="max-width: 10rem; max-height: 10rem;">
    </div>
    <!-- /.login-logo -->
    <div class="card">
      <div class="card-body login-card-body">
        <p class="login-box-msg">Introduzca la contraseña nuevamente para volver a iniciar sesion</p>
        <form id="recoverPassword" method="post">
          <input type="hidden" name="username" id="username" value="<?php echo $email; ?>">
          <div class="input-group mb-3">
            <input type="password" id="newpass" name="newpass" class="form-control" placeholder="Introduzca la nueva contraseña">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <input type="password" id="confirmpass" name="confirmpass" class="form-control" placeholder="Confirme la nueva contraseña">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-12">
              <button type="submit" class="btn btn-primary btn-block">Cambiar clave</button>
            </div>
            <!-- /.col -->
          </div>
        </form>

        <p class="mt-3 mb-1">
          <a href="/">Iniciar Sesion</a>
        </p>
      </div>
      <!-- /.login-card-body -->
    </div>
  </div>
  <!-- /.login-box -->