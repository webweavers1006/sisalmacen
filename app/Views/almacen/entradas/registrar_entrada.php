<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <link rel="stylesheet" href="<?php echo base_url(); ?>/css/reportes.css">
  <script src="https://cdn.tailwindcss.com"></script>





<style>
    /* DataTables + RegEntrada custom */
    table.dataTable thead th { background: #5d7384 !important; color: white !important; text-transform: uppercase !important; font-weight: bold !important; }
    table.dataTable tbody tr:nth-child(even) { background-color: #ebf5ff !important; }
    table.dataTable tbody tr:nth-child(odd) { background-color: white !important; }
    table.dataTable tbody tr:hover { background-color: #e3f2fd !important; }
    table.dataTable th, table.dataTable td { border-bottom: 1px solid #e0e0e0 !important; }
    /* Forms & inputs */
    .form-control { @apply border border-gray-300 rounded-md px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500; }
    label { @apply block text-sm font-medium text-gray-700 mb-1; }
    /* Buttons */
    .btn-primary { @apply bg-[#007bff] hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg shadow-md hover:shadow-lg transition-all; }
    .btn { @apply inline-flex items-center justify-center rounded-md font-medium transition-colors; }
    /* Cards */
    .card { @apply bg-white rounded-xl shadow-lg border border-gray-200 overflow-hidden mb-6; }
    .card-header { @apply bg-[#3c4e5e] text-white font-bold text-lg p-6 rounded-t-xl flex justify-between items-center; }
    .card-body { @apply p-6; }
    .card-footer { @apply bg-gray-50 px-6 py-4 border-t border-gray-200 flex justify-end space-x-3; }
    /* Modals */
    .modal-content { @apply bg-white rounded-2xl shadow-2xl; }
    .modal-header { @apply bg-[#3c4e5e] text-white p-6 rounded-t-2xl border-b; }
    .modal-body { @apply p-6; }
    /* Table catalogo */
    #tablaCatalogo { @apply w-full border-collapse; }
  </style>
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
        </div>
        <div class="col-sm-6">
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <section class="content">
    <!--Datos principales-->
    <div class="row" id="facdata">
      <div class="col-12">
        <!-- Default box -->
        <div class="bg-white rounded-xl shadow-lg border border-gray-200 overflow-hidden">
          <div class="bg-[#3c4e5e] text-white font-bold text-lg p-6 rounded-t-xl flex justify-between items-center">
            <h3 class="mb-0">Datos de la factura</h3>
          </div>
          <form role="form" id="datos-entrada" method="POST">
            <div class="card-body">
              <div class="row">
                <div class="col-2">
                  <label for="numfac">Factura Nº</label>
                  <input type="number" class="form-control" id="numfac" name="numfac" required>
                </div>
                <div class="col-2">
                  <label for="fecfac">Fecha Factura</label>
                  <input type="text" class="form-control" id="fecfac" name="fecfac" required>
                </div>
                <div class="col-1">
                  <label for="tipoprov">Tipo</label>
                  <select class="form-control" name="tipoprov" id="tipoprov">
                    <option value="J">J</option>
                    <option value="G">G</option>
                    <option value="V">V</option>
                  </select>
                </div>
                <div class="input-group col-3 mb-3">
                  <label>N° de Rif</label>
                  <div class="w-100"></div>
                  <input type="number" id="rifprov" name="rifprov" class="form-control" required>
                  <div class="input-group-append">
                    <button class="input-group-text" id="busqueda-proveedor"><i class="fas fa-search"></i></button>
                  </div>
                </div>
                <input type="hidden" name="idprov" id="idprov">
                <div class="col-4">
                  <label for="nomprov">Nombre o Razon social</label>
                  <input type="text" class="form-control" id="nomprov" name="nomprov" disabled required>
                </div>
              </div>
              <div class="row pt-3">
                <div class="col-2">
                  <label for="fecfac">Fecha de Entrada</label>
                  <input type="text" class="form-control" id="fecent" name="fecent" placeholder="Fecha de entrada al almacen" value="" required>
                </div>
                <div class="col-10">
                  <label for="entcoment">Comentario Adicional</label>
                  <textarea class="form-control" id="entcoment" name="entcoment" required></textarea>
                </div>
              </div>
            </div>
            <!-- /.card-body -->

            <div class="card-footer">
              <button type="submit" class="btn btn-primary">Guardar</button>
              <button type="reset" class="btn btn-light">Limpiar</button>
              <a type="button" class="btn btn-default" href="javascript:history.back()">Cerrar</a>
            </div>
          </form>
        </div>
      </div>
    </div>
    <!-- /.Datos principales-->
    <!--Carrito de compras-->
    <div class="row" id="detfac">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Detalles de entrada</h3>
            <div class="card-tools">
              <button type="button" class="btn btn-light btn-sm" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                <i class="fas fa-minus"></i>
              </button>
            </div>
          </div>
          <div class="card-body">
            <div id="detallesFactura">

            </div>
          </div>
        </div>
      </div>
      &nbsp;&nbsp;&nbsp;<a type="button" class="btn btn-primary" href="/entradas">Aceptar</a>

    </div>
    <br>
    <div class="row" id="catalog">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Catalogo de Existencias</h3>
            <div class="card-tools">
              <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#add-detalle-factura">Añadir Producto</button>
            </div>
          </div>

          <div class="card-body" id="catalogo">

            <table id="tablaCatalogo">
              <thead>
                <!-- Aquí van las filas de encabezado de la tabla -->
              </thead>
              <tbody>
                <?php echo $tbody; ?>
              </tbody>
            </table>
          </div>
          <div class="card-footer">

          </div>
        </div>

      </div>
    </div>

  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<!-- Modal para añadir detalle de factura-->
<div class="modal fade" id="add-detalle-factura">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Añadir Item Factura</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form role="form" id="adddetalle">
        <div class="modal-body">
          <div class="row">
            <label for="">
          </div>
          <div class="form-group">
            <input type="hidden" name="numregent" id="numregent">
            <div class="input-group mb-3">
              <input type="text" class="form-control" id="codbar" name="codbar" placeholder="Código de barras">
              <div class="input-group-append">
                <span class="input-group-text"><i class="fas fa-search buscar-cod-bar"></i></span>
              </div>
            </div>
          </div>
          <div class="row">
            <div>
            </div>
          </div>
          <div class="form-group">
            <label for="prodmar">Marca</label>
            <input type="text" class="form-control" id="prodmar" placeholder="Marca del producto" disabled>
          </div>
          <div class="form-group">
            <label for="prodmodel">Descripcion del producto</label>
            <input type="text" class="form-control" id="prodmodel" placeholder="Descripcion del producto" disabled>
          </div>
          <div class="row">
            <div class="col-4">
              <label for="prodpresent">Presentacion de Producto</label>
              <input type="text" class="form-control" id="prodpresent" name="prodpresent">
            </div>
            <div class="col-4">
              <label for="numuni">Costo Unitario</label>
              <input type="text" class="form-control" id="costuni">
            </div>
            <div class="col-">
              <label for="numuni">Nº de unidades</label>
              <input type="number" class="form-control" id="numuni">
            </div>
          </div>
        </div>
        <div class="modal-footer justify-content-between">
          <button type="reset" class="btn btn-default" data-dismiss="modal">Cerrar</button>
          <button type="submit" class="btn btn-primary">Guardar</button>
        </div>
      </form>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>

<!--Modal para añadir el proveedor-->
<div class="modal fade" id="add-proveedor">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Nuevo Proveedor</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form role="form" method="POST" id="newProvider">
        <div class="modal-body">
          <label>Datos de la empresa</label>
          <div class="row">
            <div class="col-4">
              <input type="text" disabled name="frmnewnumrif" id="frmnewnumrif" class="form-control" placeholder="Número de RIF">
            </div>
            <div class="col-8">
              <input type="text" name="frmnewnomprov" id="frmnewnomprov" class="form-control" placeholder="Nombre de la empresa">
            </div>
          </div>
          <label>Datos de contacto</label>
          <div class="row p-2">
            <div class="col-12">
              <input type="text" name="frmnewdireccprov" id="frmnewdireccprov" class="form-control" placeholder="Direccion de la empresa">
            </div>
          </div>
          <div class="row p-2">
            <div class="col-3">
              <input class="form-control" type="text" name="frmnewtelef1" id="frmnewtelef1" placeholder="Telefono Principal">
            </div>
            <div class="col-3">
              <input class="form-control" type="text" name="frmnewtelef2" id="frmnewtelef2" placeholder="Telefono Secundario">
            </div>
            <div class="col-6">
              <input class="form-control" type="email" name="frmnewcontemail" id="frmnewcontemail" placeholder="Correo electronico">
            </div>
          </div>
        </div>
        <!-- /.card-body -->
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Guardar</button>
          <button type="reset" class="btn btn-secondary">Limpiar</button>
          <button type="reset" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        </div>
        <!-- /.card-footer-->
      </form>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>

<!--Modal para añadir el producto si no aparece-->
<div class="modal fade" id="add-producto">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Nuevo Producto</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form role="form" method="POST" id="newProduct">
        <input type="hidden" id="modform" name="modform" value="1">
        <div class="modal-body">
          <div class="form-group">
            <label for="codbar">Código de barras</label>
            <input disabled class="form-control" type="number" name="frmnewcodbar" id="frmnewcodbar">
          </div>
          <div class="form-group">
            <label for="prodmar">Marca del producto</label>
            <input class="form-control" type="text" name="frmnewprodmar" id="frmnewprodmar">
          </div>
          <div class="form-group">
            <label for="prodmodel">Descripcion</label>
            <input class="form-control" type="text" name="frmnewprodmodel" id="frmnewprodmodel">
          </div>
        </div>
        <!-- /.card-body -->
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Guardar</button>
          <button type="reset" class="btn btn-secondary">Limpiar</button>
          <button type="reset" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        </div>
        <!-- /.card-footer-->
      </form>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>