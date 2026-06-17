  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
  <link rel="stylesheet" href="<?php echo base_url(); ?>/css/reportes.css">
    <script src="<?php echo base_url();?>/custom/js/excel.js"></script>




    <style>
      table.dataTable thead,
      table.dataTable tfoot {
        background: linear-gradient(to right, #a9b6c2, #a9b6c2, #a9b6c2);
      }
    </style>
    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-12 col-sm-12 col-md-12 p-2">
            <div class="card">
              <div class="card-header border-0">
                <div class="d-flex justify-content-between">
                  <h3 class="card-title">Consolidados de entradas y salidas de articulos</h3>
                    <!-- <button class="btn btn-light" id="generaArchivoExcel"><i class="fas fa-file-excel"></i> Generar Archivo Excel</button> -->
                </div>
              </div>
              <div class="card-body">
                <!--Form-->
                <form id="consulta-articulos" method="POST" class="form-row justify-content-between">
                  <div class="col-md-3">
                    <label for="desde">Desde:</label>
                    <input type="date" class="form-control" value="<?php echo date('Y-m-d'); ?>" name="desde" id="desde">
                  </div>
                  <div class="col-md-3">
                    <label for="hasta">Hasta:</label>
                    <input type="date" class="form-control" value="<?php echo date('Y-m-d'); ?>" name="hasta" id="hasta">
                  </div>
                  <div class="col-md-3">
                    <label for="tipo-operacion">Tipo de operacion</label>
                    <select id="tipo-operacion" name="tipo-operacion" class="form-control">
                      <option value="1">Entradas</option>
                      <option value="2">Salidas</option>
                      <option value="3">Todo</option>
                    </select>
                  </div>
              
            
                  <div class="col-md-3">
                  <label for="categoria">Categoria</label>
                  <select class="form-control" name="categoria" id="categoria" >
                  <option value="0" disabled>Seleccione</option>
                  </select>
                </div>
             
       
                <div >
                <br> 
                  <button type="submit" class="btn btn-primary" >Consultar</button>
                </div>
            
              </form>

              
           
                <br>
                 
                
        <div class="col-lg-12 col-sm-12 col-md-12 ">
          <div class="card" id="1" style="display: none;">
            <div class="card-body">
              <table class="display" id="tabla" style="width:100%" style="margin-top: 20px">
                  </table>
                  </div>
                  </div>
                </div>
              </div>

              <div class="card"id="2" style="display: none;">
            <div class="card-body">
              <table class="display" id="tabla2" style="width:100%" style="margin-top: 20px">
                 <th style="background-color: #3399ff">Código de barras</th>
                  </table>
                  </div>
                  </div>
                </div>
              </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
 
  


<!-- <script>

// Obtén una referencia al botón
const exportButton = document.getElementById('export-button');
// Agrega un evento click al botón
exportButton.addEventListener('click', () => {
  // Crea un nuevo documento PDF
  const doc = new jsPDF();

  // Obtén una referencia a la tabla
  const table = document.getElementById('tabla');

  // Convierte la tabla en una imagen base64
  html2canvas(table).then((canvas) => {
    const imgData = canvas.toDataURL('image/png');

    // Agrega la imagen al documento PDF
    doc.addImage(imgData, 'PNG', 10, 10, 180, 0);

    // Guarda el documento PDF
    doc.save('tabla.pdf');
  });
});


</script>
 -->


  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->