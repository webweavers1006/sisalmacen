<link rel="stylesheet" href="<?php echo base_url(); ?>/css/edit_productos.css">

<div class="content-wrapper">
 <section class="content-header p-2">
  <div class="container-fluid" style="position: relative; display: flex; align-items: center; justify-content: center; padding: 0 40px;">
    
    <h1 class="m-0 fw-bold" style="color: #1e3a8a; font-size: 1.5rem;">
      <i class="fas fa-edit me-2"></i>Edición de Producto
    </h1>

    <div style="position: absolute; right: 40px;"> 
      <a href="/consultaproducto" class="btn btn-light btn-sm shadow-sm" title="Regresar a lista" style="font-weight: 500; border: 1px solid #dee2e6;">
        <i class="fas fa-arrow-left me-1"></i> Regresar
      </a>
    </div>

  </div>
</section>

  <section class="content">
    <div class="container-fluid">
      <div class="card shadow">
        <div class="card-header d-flex justify-content-between align-items-center" style="background-color: #384c60 !important;">
          <h3 class="card-title text-white">
            <i class="fas fa-barcode me-2"></i>COD: <?php echo $codbar; ?>
          </h3>
          <div class="card-tools d-flex align-items-center">
            <label class="text-white mb-0 me-2 small">Estado Activo:</label>&nbsp;&nbsp;&nbsp;
            <input type="checkbox" class="borrado" id="borrado" name="borrado">
            <input type="hidden" name="borrado_actual" id="borrado_actual" value="<?php echo $borrado; ?>">
           
          </div>
        </div>

        <form role="form" method="POST" id="nuevoproducto" enctype="multipart/form-data">
          <input type="hidden" id="modform" name="modform" value="<?php echo $modform; ?>">
          <input id="id_categoria" type="hidden" value="<?php echo $id_categoria; ?>">
          
          <div class="card-body">
            <div class="row g-3">
              <div class="form-group col-md-6">
                <label for="codbar">Código de barras (Lectura)</label>
                <input class="form-control" disabled type="text" name="codbar" id="codbar" value="<?php echo $codbar; ?>" style="background-color: #e9ecef; cursor: not-allowed;">
              </div>

              <div class="form-group col-md-6">
                <label for="prodmar">Marca</label>
                <input class="form-control" type="text" name="prodmar" id="prodmar" value="<?php echo $prodmar; ?>" required>
              </div>

              <div class="form-group col-12">
                <label for="prodmodel">Descripción / Modelo</label>
                <input class="form-control" type="text" name="prodmodel" id="prodmodel" value="<?php echo $prodmodel; ?>" required>
              </div>

              <div class="form-group col-md-8">
                <label for="categoria">Categoría</label>
                <select class="form-control" name="categoria" id="categoria"></select>
              </div>

              <div class="form-group col-md-4">
                <label for="stock_min">Stock Mínimo</label>
                <input class="form-control" type="number" onkeypress="return valideKey(event);" name="stock_min" id="stock_min" value="<?php echo $stock_minimo; ?>">
              </div>
            </div>

            <div id="seccion_documentos" class="siac-docs-card">
              <div class="siac-docs-header" style="background-color: #384c60 !important;">
                <h6 class="text-white"><i class="fas fa-image me-2"></i>Gestión de Imagen</h6>
              </div>
              <div class="siac-docs-body p-3 bg-light">
                <div class="row align-items-center">
                  <div class="col-md-4 text-center">
                    <label class="small fw-bold d-block mb-2">Imagen Actual</label>
                    <div class="preview-container border bg-white" style="height: 120px;">
                      <img id="img_actual" src="/documentos_productos/<?php echo ($prodimg != '' && $prodimg != 'sin_img.png') ? $prodimg : 'sin_img.png'; ?>" 
                           alt="Imagen actual" class="img-fluid" style="max-height: 110px;">
                    </div>
                  </div>
                  
                  <div class="col-md-8 mt-3 mt-md-0">
                    <div class="form-group mb-2">
                      <label class="small fw-bold">Reemplazar fotografía</label>
                      <input type="file" class="form-control siac-file-input" name="imagen" id="imagen" accept="image/*">
                    </div>
                    
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="card-footer d-flex justify-content-center gap-3">
            <button type="submit" class="btn px-5 text-white" style="background-color: #384c60 !important;">
              <i class="fas fa-sync-alt me-1"></i> Actualizar
            </button>
            <a class="btn btn-secondary px-4" href="javascript:history.back()">
              Regresar
            </a>
          </div>
        </form>
      </div>
    </div>
  </section>
</div>