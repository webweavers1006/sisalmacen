<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
          </div><!-- /.col -->
          <div class="col-sm-6">
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      
      <!-- container-fluid -->
      <div class="container-fluid">
      <h3 class="card-title">Comentario Solicitante </h3>
    <textarea name="comentario" id="comentario" cols="155" required></textarea>
        <div class="row">
          <section class="col-lg-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">
                  Orden Nº: <?php echo $numorden;?>
                </h3>
                <div class="card-tools">
                  <a class="btn btn-sm btn-primary"  href="/editarpreorden/<?php echo $numorden;?>">Añadir</a>
                  <a class="btn btn-sm btn-danger"  href="/eliminarpreorden/<?php echo $numorden;?>">Eliminar</a>
                  <a class="btn btn-sm btn-success" href="/confirmarpreorden/<?php echo $numorden; ?>" onclick="agregarComentarioAlEnlace(event)" id="boton-confirmar">Cerrar/Enviar Requisición </a>
                </div>
              </div>
              <div class="card-body">
                <div id="detalles">
                  <?php echo $tbody;?>
                </div>
              </div>
            </div>
          </section>
        </div>
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <input type="hidden" id="numorden" name="numorden" value="<?php echo $numorden;?>">

  <script>
  function agregarComentarioAlEnlace(event) {
    event.preventDefault();

    var comentario = document.getElementById("comentario").value;
    comentario= comentario.replaceAll("/", "-");
    if (comentario.trim() === "") {
      alert("Por favor, ingresa un comentario antes de confirmar.");
      return;
    }
    var enlace = "/confirmarpreorden/<?php echo $numorden; ?>" + '/' + encodeURIComponent(comentario);

    document.getElementById("boton-confirmar").href = enlace;

    window.location = enlace
  }
</script>