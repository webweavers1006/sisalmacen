<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
  <img src="<?php echo base_url();?>/img/Logosapi-2020.png" style="max-width: 10rem; max-height: 10rem;">
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">Introduzca el correo electronico para recuperar su contraseña</p>

      <form id="recover-pass" method="post">
        <div class="input-group mb-3">
          <input type="email" name="email" id="email" class="form-control" placeholder="Ej: nombre.apellido@sapi.gob.ve">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-12">
            <button type="submit" class="btn btn-primary btn-block">Recuperar contraseña</button>
          </div>
          <!-- /.col -->
        </div>
      </form>

      <p class="mt-3 mb-1">
        <a href="/">Iniciar Sesion</a>
      </p>
      <p class="mb-0">
      </p>
    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->