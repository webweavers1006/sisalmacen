<meta charset="UTF-8" />
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>/theme/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>/theme/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>/theme/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">

<!-- Contenedor de contenido. Contiene el contenido de la página -->
<div class="content-wrapper">
  <!-- Encabezado de contenido (Encabezado de la página) -->
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

  <!-- Contenido principal -->
  <section class="content">

    <!-- Caja por defecto -->
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">Reporte de Entradas y Salidas</h3>
      </div>
      <form role="form" id="consulta-fecha" method="POST">
        <div class="card-body">
          <div class="row">
            <div class="col-2">
              <label for="tipo-consulta">Tipo de consulta</label>
              <select class="form-control" name="tipo-consulta" id="tipo-consulta">
                <option value="1">Entradas</option>
                <option value="2">Salidas</option>
              </select>
            </div>
            <div class="col-md-3">
                <label for="categoria">Categoría</label>
                <select class="form-control" name="categoria" id="categoria">
                <option value="0" disabled>Seleccione</option>
                </select>
              </div>
            <div class="col-2">
              <label for="rango-consulta">Rango de Fecha</label>
                  <label for="desde">Desde:</label>
                  <input type="date" class="form-control" value="<?php echo date('Y-m-d'); ?>" name="desde" id="desde">
             
            </div>
                  
            <div class="col-2">
                  <label for="hasta">Hasta:</label>
                  <input type="date" class="form-control" value="<?php echo date('Y-m-d'); ?>" name="hasta" id="hasta">  
            </div>
            <div class="col-6">
              <label for="usuario-consulta">Usuario Operante</label>
              <select class="form-control select2" style="height: 36%;" name="usuario-consulta" id="usuario-consulta">
                <?php echo $selectUsuarios;?>
              </select>
            </div>
          </div>
          <div class="row pt-2">
            <div class="col-6">
              <label for="producto-consulta">Producto</label>
              <select class="form-control select2" style="height: 36%;" name="producto-consulta" id="producto-consulta">
                <?php echo $selectProducto;?>
              </select>
            </div>
            <div class="col-6">
              <label for="proveedor-consulta">Proveedor</label>
              <select class="form-control select2" style="height: 36%;" name="proveedor-consulta" id="proveedor-consulta">
                <?php echo $selectProveedor;?>
              </select>
            </div>
            
          </div>
        </div>
        <div class="card-footer">
          <button type="submit" class="btn btn-primary">Consultar</button>
          <button type="reset" class="btn btn-success">Limpiar</button>
          <a href="javascript:history.back();" class="btn btn-secondary">Volver</a>
          <button type="button" id="genera-pdf" class="btn btn-primary"><i class="fas fa-pdf"></i> Generar Reporte </button>
        </div>
      </form>
    </div>
    <!-- /.card -->

    <div class="card" id="detalles">
      <div class="card-header">
        <h3 class="card-title">Detalles de consulta</h3>
      </div>
      <div class="card-body">
        <table class="table table-striped table-hover text-center display responsive nowrap" style="width:100%" id="detalles-consulta">
          <thead></thead>
        </table>
      </div>
      <!-- /.card-body -->
      <div class="card-footer" id="generar-reporte">
        
      </div>
      <!-- /.card-footer-->
    </div>

  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<div class="modal fade" id="consulta-detalle">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Detalles</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="detalle-consulta">
      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-default" data-dismiss="modal">Aceptar</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->