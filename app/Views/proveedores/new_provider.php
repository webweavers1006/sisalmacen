<?php 
echo view('template/header');
echo view('template/nav_bar');

?>

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
          <h3 class="card-title">Nuevo Proveedor</h3>
        </div>
        <form role="form" method="POST" id="newProvider">
          <div class="card-body">
          	<label>Datos de la empresa</label>
          	<div class="row">
          		<div class="col-3">
	              <select name="tipoper" class="form-control" id="tipoper">
	              	<option value="V">V - Venezolano</option>
	              	<option value="J">J - Juridico</option>
	              	<option value="G">G - Gobierno</option>
	              </select>
	            </div>
	            <div class="col-3">
	            	<input type="number" name="numrif" id="numrif" class="form-control" placeholder="Número de RIF">
	            </div>
	            <div class="col-6">
	            	<input type="text" name="nomprov" id="nomprov" class="form-control" placeholder="Nombre de la empresa">
	            </div>
	        </div>
	        <label>Datos de contacto</label>
            <div class="row p-2">
            	<div class="col-12">
            		<input type="text" name="direccprov" id="direccprov" class="form-control" placeholder="Direccion de la empresa">
            	</div>
            </div>
            <div class="row p-2">
            	<div class="col-3">
            		<input class="form-control" type="text" name="telef1" id="telef1" placeholder="Telefono Principal">
            	</div>
            	<div class="col-3">
            		<input class="form-control" type="text" name="telef2" id="telef2" placeholder="Telefono Secundario">
            	</div>
            	<div class="col-6">
            		<input class="form-control" type="email" name="contemail" id="contemail" placeholder="Correo electronico">
            	</div>
            </div>
          </div>
          <!-- /.card-body -->
          <div class="card-footer">
            <button type="submit" class="btn btn-primary">Guardar</button>
            <button type="reset" class="btn btn-secondary">Limpiar</button>
            <a type="button" class="btn btn-danger" href="javascript:history.back()">Cerrar</a>
          </div>
        <!-- /.card-footer-->
        </form>
      </div>

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
<?php

echo view('template/footer');

?>
<script type="text/javascript" src="<?php echo base_url();?>/custom/js/proveedores/registrar.js"></script>
</body>
</html>