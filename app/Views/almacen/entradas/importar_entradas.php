<!-- Content Wrapper -->
<div class="content-wrapper">
  <link rel="stylesheet" href="<?php echo base_url(); ?>/css/reportes.css">
  <script src="https://cdn.tailwindcss.com"></script>

  <style>
    .card { @apply bg-white rounded-xl shadow-lg border border-gray-200 overflow-hidden mb-6; }
    .card-header { @apply bg-[#3c4e5e] text-white font-bold text-lg p-6 rounded-t-xl flex justify-between items-center; }
    .card-body { @apply p-6; }
    .btn-primary { @apply bg-[#007bff] hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg shadow-md hover:shadow-lg transition-all; }
    .btn-success { @apply bg-[#28a745] hover:bg-green-700 text-white font-medium py-2 px-4 rounded-lg shadow-md hover:shadow-lg transition-all; }
    .btn-secondary { @apply bg-gray-500 hover:bg-gray-600 text-white font-medium py-2 px-4 rounded-lg shadow-md hover:shadow-lg transition-all; }
  </style>

  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="text-2xl font-bold text-gray-800">Importar Entradas desde Excel</h1>
        </div>
      </div>
    </div>
  </section>

  <section class="content">
    <div class="container-fluid">

      <!-- Instrucciones -->
      <div class="card">
        <div class="card-header">
          📋 Instrucciones
        </div>
        <div class="card-body">
          <ol class="list-decimal list-inside space-y-2 text-gray-700">
            <li>Descarga la <strong>plantilla Excel</strong> usando el botón de abajo.</li>
            <li>Llena los datos de tus entradas. <strong>No modifiques los nombres de las columnas.</strong></li>
            <li>Las filas con el <strong>mismo número de factura</strong> se agrupan en una sola entrada.</li>
            <li>Formatos de fecha: <code>YYYY-MM-DD</code> (ej: 2026-06-17) o <code>DD/MM/YYYY</code>.</li>
            <li><strong>Si el producto no existe</strong> (codbar nuevo), se crea automáticamente con la marca, modelo y categoría que pongas.</li>
            <li>Sube el archivo y haz clic en <strong>Procesar</strong>.</li>
          </ol>

          <div class="mt-4">
            <a href="<?php echo base_url(); ?>/descargar-plantilla" class="btn-secondary inline-block">
              📥 Descargar Plantilla Excel
            </a>
          </div>
        </div>
      </div>

      <!-- Formulario de carga -->
      <div class="card">
        <div class="card-header">
          📤 Cargar Archivo Excel
        </div>
        <div class="card-body">
          <form id="formImportar" enctype="multipart/form-data" method="post">
            <div class="mb-4">
              <label class="block text-sm font-medium text-gray-700 mb-2">
                Selecciona tu archivo Excel (.xlsx o .xls)
              </label>
              <input 
                type="file" 
                id="archivoExcel" 
                name="archivoExcel" 
                accept=".xlsx,.xls" 
                class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"
                required
              >
              <p class="mt-1 text-xs text-gray-500">Tamaño máximo: 10MB</p>
            </div>

            <div class="flex gap-3">
              <button type="submit" id="btnProcesar" class="btn-primary">
                ⚡ Procesar Archivo
              </button>
              <span id="loading" class="hidden text-blue-600 font-medium py-2">
                ⏳ Procesando... Esto puede tomar unos momentos.
              </span>
            </div>
          </form>

          <!-- Resultado -->
          <div id="resultado" class="mt-6 hidden"></div>
        </div>
      </div>

      <!-- Columnas esperadas -->
      <div class="card">
        <div class="card-header">
          📝 Columnas de la Plantilla
        </div>
        <div class="card-body overflow-x-auto">
          <table class="min-w-full text-sm">
            <thead class="bg-gray-100">
              <tr>
                <th class="p-2 border text-left">Columna</th>
                <th class="p-2 border text-left">Descripción</th>
                <th class="p-2 border text-left">Requerido</th>
                <th class="p-2 border text-left">Ejemplo</th>
              </tr>
            </thead>
            <tbody>
              <tr><td class="p-2 border font-mono">numfac</td><td class="p-2 border">Número de factura</td><td class="p-2 border">✅ Sí</td><td class="p-2 border">FAC-001</td></tr>
              <tr><td class="p-2 border font-mono">fecfac</td><td class="p-2 border">Fecha de la factura</td><td class="p-2 border">✅ Sí</td><td class="p-2 border">2026-06-17</td></tr>
              <tr><td class="p-2 border font-mono">fecent</td><td class="p-2 border">Fecha de entrada al almacén</td><td class="p-2 border">✅ Sí</td><td class="p-2 border">2026-06-17</td></tr>
              <tr><td class="p-2 border font-mono">provid</td><td class="p-2 border">ID del proveedor</td><td class="p-2 border">✅ Sí</td><td class="p-2 border">1</td></tr>
              <tr><td class="p-2 border font-mono">entcoment</td><td class="p-2 border">Comentario de la entrada</td><td class="p-2 border">⬚ Opcional</td><td class="p-2 border">Compra mensual</td></tr>
              <tr><td class="p-2 border font-mono">codbar</td><td class="p-2 border">Código de barras del producto</td><td class="p-2 border">✅ Sí</td><td class="p-2 border">45</td></tr>
              <tr><td class="p-2 border font-mono">prodmar</td><td class="p-2 border">Marca del producto</td><td class="p-2 border">✅ Sí (si es nuevo)</td><td class="p-2 border">Samsung</td></tr>
              <tr><td class="p-2 border font-mono">prodmodel</td><td class="p-2 border">Modelo / Descripción</td><td class="p-2 border">✅ Sí (si es nuevo)</td><td class="p-2 border">Monitor 24"</td></tr>
              <tr><td class="p-2 border font-mono">id_categoria</td><td class="p-2 border">Categoría del producto: <strong>1 = PRODUCTOS</strong>, <strong>2 = BIENES</strong></td><td class="p-2 border">⬚ Opcional (default: 1)</td><td class="p-2 border">1</td></tr>
              <tr><td class="p-2 border font-mono">numunid</td><td class="p-2 border">Cantidad de unidades</td><td class="p-2 border">✅ Sí</td><td class="p-2 border">100</td></tr>
              <tr><td class="p-2 border font-mono">costuni</td><td class="p-2 border">Costo unitario</td><td class="p-2 border">✅ Sí</td><td class="p-2 border">15.50</td></tr>
              <tr><td class="p-2 border font-mono">prodpresent</td><td class="p-2 border">Presentación del producto</td><td class="p-2 border">✅ Sí</td><td class="p-2 border">unidad</td></tr>
            </tbody>
          </table>
        </div>
      </div>

    </div>
  </section>
</div>

<script>
document.getElementById('formImportar').addEventListener('submit', function(e) {
    e.preventDefault();
    
    var fileInput = document.getElementById('archivoExcel');
    var file = fileInput.files[0];
    
    if (!file) {
        alert('Selecciona un archivo Excel primero.');
        return;
    }
    
    var ext = file.name.split('.').pop().toLowerCase();
    if (ext !== 'xlsx' && ext !== 'xls') {
        alert('Solo se permiten archivos .xlsx o .xls');
        return;
    }
    
    if (file.size > 10 * 1024 * 1024) {
        alert('El archivo no debe superar 10MB.');
        return;
    }
    
    document.getElementById('loading').classList.remove('hidden');
    document.getElementById('btnProcesar').disabled = true;
    document.getElementById('resultado').classList.add('hidden');
    
    var formData = new FormData();
    formData.append('archivoExcel', file);
    
    fetch('<?php echo base_url(); ?>/procesar-excel', {
        method: 'POST',
        body: formData
    })
    .then(function(response) { return response.json(); })
    .then(function(data) {
        document.getElementById('loading').classList.add('hidden');
        document.getElementById('btnProcesar').disabled = false;
        
        var resultado = document.getElementById('resultado');
        resultado.classList.remove('hidden');
        
        if (data.status === 'success') {
            resultado.innerHTML = '<div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg">' +
                '<strong>✅ Importación exitosa</strong><br>' +
                'Entradas creadas: ' + data.entradas + '<br>' +
                'Detalles procesados: ' + data.detalles + '<br>' +
                'Productos nuevos: ' + (data.productos_nuevos || 0) + '<br>' +
                (data.errores > 0 ? '⚠️ Filas con error: ' + data.errores + '<br><pre class="text-sm mt-2">' + data.detalle_errores + '</pre>' : '') +
                '</div>';
        } else {
            resultado.innerHTML = '<div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg">' +
                '<strong>❌ Error:</strong> ' + data.message +
                '</div>';
        }
    })
    .catch(function(err) {
        document.getElementById('loading').classList.add('hidden');
        document.getElementById('btnProcesar').disabled = false;
        document.getElementById('resultado').classList.remove('hidden');
        document.getElementById('resultado').innerHTML = '<div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg">' +
            '<strong>❌ Error de conexión:</strong> ' + err +
            '</div>';
    });
});
</script>
