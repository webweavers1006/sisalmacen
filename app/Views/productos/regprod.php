<link rel="stylesheet" href="<?php echo base_url(); ?>/css/productos.css">

<div class="content-wrapper">
  <section class="content-header p-3 text-center">
    <h1 class="fw-bold" style="color: #1e3a8a; font-size: 1.6rem;">
      <i class="fas fa-plus-circle me-2"></i>Nuevo Producto
    </h1>
  </section>

  <section class="content">
    <div class="container-fluid">
      <div class="card shadow">
        <div class="card-header text-center">
          <h3 class="card-title">
            <i class="fas fa-info-circle me-2"></i>Información del Registro
          </h3>
        </div>
        
        <form role="form" method="POST" id="nuevoproducto" enctype="multipart/form-data">
          <input type="checkbox" style="display: none;" class="borrado" id="borrado" name="borrado" value='false'>
          <input type="hidden" name="borrado_actual" id="borrado_actual" value="0">
          <input type="hidden" id="modform" name="modform" value="1">
          
          <div class="card-body">
            <div class="row g-3"> <div class="form-group col-md-6">
                <label for="codbar">Código de barras</label>
                <input class="form-control" type="number" name="codbar" id="codbar" required placeholder="00000000" value="<?php echo isset($next_codbar) ? str_pad($next_codbar, 8, '0', STR_PAD_LEFT) : ''; ?>">
                <?php if (isset($next_codbar)): ?>
                <small class="form-text text-success fw-bold">Siguiente disponible: <span id="next-codbar-display"><?php echo str_pad($next_codbar, 8, '0', STR_PAD_LEFT); ?></span> (puedes editarlo)</small>
                <?php endif; ?>
              </div>

              <div class="form-group col-md-6">
                <label for="prodmar">Marca</label>
                <input class="form-control" type="text" name="prodmar" id="prodmar" required placeholder="Marca del producto">
              </div>

              <div class="form-group col-12">
                <label for="prodmodel">Descripción completa</label>
                <input class="form-control" type="text" name="prodmodel" id="prodmodel" required placeholder="Modelo o nombre descriptivo">
              </div>

              <div class="form-group col-md-7">
                <label for="categoria">Categoría</label>
                <select class="form-control" name="categoria" id="categoria">
                  <option value="0" disabled selected>Seleccione...</option>
                </select>
              </div>

              <div class="form-group col-md-5">
                <label for="stock_min">Stock Mínimo</label>
                <input class="form-control" type="number" onkeypress="return valideKey(event);" name="stock_min" id="stock_min" placeholder="0">
              </div>
            </div>

            <div id="seccion_documentos" class="siac-docs-card">
              <div class="siac-docs-header">
                <h6><i class="fas fa-camera me-2"></i>Imagen del Producto</h6>
              </div>
              <div class="siac-docs-body p-3 bg-light">
                <div class="row align-items-center">
                  <div class="col-md-7">
                    <input type="file" class="form-control siac-file-input" name="imagen" id="imagen" accept="image/*">
                  </div>
                  <div class="col-md-5">
                    <div class="preview-container mt-2 mt-md-0">
                      <img id="img_nueva" src="/documentos_productos/sin_img.png" alt="Preview">
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="card-footer">
            <button type="submit" class="btn siac-btn-primary px-4">
              <i class="fas fa-save me-1"></i> Registrar
            </button>
            <a class="btn siac-btn-danger text-white" href="javascript:history.back()">
              Cancelar
            </a>
          </div>
        </form>
      </div>
    </div>
  </section>
</div>