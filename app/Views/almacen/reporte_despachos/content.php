<meta charset="utf-8">
<div class="content-wrapper">
  <link rel="stylesheet" href="<?php echo base_url(); ?>/css/reportes.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>/css/botones_datatable.css">
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

        </div>
      </div>
      <!--Form-->

      <div class="row">

        <div class="col-lg-12 col-sm-12 col-md-12 ">
          <div class="card">
            <form role="form" method="POST" id="filtrar">
                <div class="card-body">
                
                <div class="row">
                    <div class="col-12 d-flex between">
                        <div class="col-3">
                            <label for="rango-consulta">Rango de Fecha</label>
                            <label for="desde">Desde:</label>
                            <input type="date" class="form-control" value="<?php echo date('Y-m-d'); ?>" name="desde" id="desde">              
                        </div>                        
                        <div class="col-3">
                            <label for="hasta">Hasta:</label>
                            <input type="date" class="form-control" value="<?php echo date('Y-m-d'); ?>" name="hasta" id="hasta">  
                        </div>   

                        <div class="col-3">
                        <label for="direccion-consulta">Direccion</label>
                           <select class="form-control" name="direccion-consulta" id="direccion-consulta">
                              <?php echo $selectDireccion;?>
                        </select>
                        </div>   


                </div>
                <div class="card-footer">
           <button type="submit" class="btn btn-primary">Consultar</button>
          </div>
            </form>
          </div>

          


          <div class="row">
            <div class="col-1">
            </div>
            <div class="col-10 ">
              <table class="display" id="table_existencias" style="width:100%" style="margin-top: 20px">
                <thead>
                  <tr>
                    <th style="width:11%">Num_Orden</th>
                    <th style="width:11%">Estatus</th>
                    <th style="width:11%">Fecha salida</th>
                    <th style="width:40%">Direccion</th>
                    <th style="width:40%">Solicitante</th>
                    <th style="width:40%">Acciones</th>
                  </tr>
                </thead>
                <tbody id="listar_de_despachos">
                </tbody>
              </table>
            </div>
          </div>
          </div>
          </div>
        </div>
      </div>
    </div>

   
  </div>
  <!-- /.card -->

  </section>

  
</div>