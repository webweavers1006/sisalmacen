<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Nuevo Requerimiento</h1>
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
        <h3 class="card-title">Solicitud Nº : <?php echo $prereqid; ?> </h3>
        <div class="card-tools">
          <a class="btn btn-success" href="#" data-toggle="modal" data-target="#addItem">Añadir</a>
        </div>
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col-lg-12">
            <div class="card">
              <div class="card-body">
                <div id="detalle-requerimiento">
                  <?php echo $tabla; ?>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- /.card-body -->
      <div class="card-footer">
        <form role="form" method="post" id="aprobar-requerimiento">
          <input type="hidden" name="reqid" id="reqid" value="<?php echo $prereqid; ?>">
          <button type="submit" class="btn btn-sm btn-success float-right p-2">Aprobar</button>
          <button id="<?php echo $prereqid; ?>" class="btn btn-sm btn-danger eliminar-solicitud"><i class="fas fa-trash"></i>Eliminar Solicitud</button>
          <a type="button" class="btn btn-sm btn-secondary float-right p-2" href="javascript:history.back()">Cerrar</a>
        </form>
      </div>
      <!-- /.card-footer-->
    </div>
    <!-- /.card -->

  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<div class="modal fade" id="addItem">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Añadir Cantidad</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="add-detalle-requerimiento" enctype="multipart/form-data" method="post">
        <input id="reqid" name="reqid" type="hidden" value="<?php echo $prereqid; ?>">
        <div class="modal-body">
          <div class="form-group">
            <label for="reqmarca">Marca del Producto</label>
            <input type="text" class="form-control" id="reqmarca" name="reqmarca">
          </div>
          <div class="form-group">
            <label for="reqmodelo">Descripcion del Producto</label>
            <input type="text" class="form-control" id="reqmodelo" name="reqmodelo">
          </div>
          <div class="form-group">
            <label for="reqcantidad">Cantidad a solicitar</label>
            <input type="number" class="form-control" id="reqcantidad" name="reqcantidad">
          </div>
          <div class="form-group">
            <label for="reqimgref">Imagen de referencia</label>
            <div class="input-group">
              <div class="custom-file">
                <input type="file" class="custom-file-input" id="reqimgref" name="reqimgref">
                <label class="custom-file-label" for="reqimgref">Elegir archivo</label>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default cancelar" data-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-primary float-right">Añadir</button>
        </div>
      </form>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->