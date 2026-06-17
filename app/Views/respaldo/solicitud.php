<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Nueva Requisicion</h1>
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
                <h3 class="card-title">Solicitud Nº : <?php echo $numorden; ?> </h3>
                <div class="card-tools">
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div id="catalog">
                                    <?php echo $tbody; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- /.card-body -->
            <div class="card-footer">
            </div>
            <!-- /.card-footer-->
        </div>
        <!-- /.card -->
        <!-- Default box -->

        <h3 class="card-title">Comentario Solicitante </h3>
        <textarea name="comentario" id="comentario" cols="155" required></textarea>
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Detalles preorden </h3>
                <div class="card-tools">
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div id="detalle-preorden">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- /.card-body -->
            <div class="card-footer">
                <a type="button" class="btn btn-sm btn-primary float-left p-2" href="javascript:history.back()">Aceptar</a>
                <div class="float-right">
                    <!-- <a class="btn btn-sm btn-danger" href="/eliminarpreorden/<php echo $numorden; ?>">Eliminar</a> -->
                    <!--  <a class="btn btn-sm btn-success" href="/confirmarpreorden/<php echo $numorden; ?>">Confirmar</a> -->
                    <a class="btn btn-sm btn-success" href="/confirmarpreorden/<?php echo $numorden; ?>" onclick="agregarComentarioAlEnlace(event)" id="boton-confirmar">Confirmar</a>

                </div>
            </div>
            <!-- /.card-footer-->
        </div>
        <!-- /.card -->

    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<div class=" modal fade" id="modal-detalle">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Añadir Cantidad</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form role="form" id="add-preorden-detalle">
                <input id="codbar" type="hidden">
                <input id="numorden" type="hidden" value="<?php echo $numorden; ?>">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="cantprod">Cantidad a solicitar</label>
                        <input type="number" class="form-control" id="cantprod" name="cantprod">
                    </div>

                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default cancelar" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Añadir</button>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<script>
    function agregarComentarioAlEnlace(event) {
        event.preventDefault();

        var comentario = document.getElementById("comentario").value;

        if (comentario.trim() === "") {
            alert("Por favor, ingresa un comentario antes de confirmar.");
            return;
        }

        var enlace = "/confirmarpreorden/<?php echo $numorden; ?>" + '/' + encodeURIComponent(comentario);

        document.getElementById("boton-confirmar").href = enlace;

        window.location = enlace
    }
</script>

<!-- /.modal -->