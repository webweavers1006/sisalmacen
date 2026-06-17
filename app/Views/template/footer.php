<!-- /.content-wrapper -->
<footer class="main-footer">
  <strong>Copyleft &copy; 2020 SAPI</strong>
  <div class="float-right d-none d-sm-inline-block">
    <b>Sistema Creado por Bryan Useche</b>
  </div>
</footer>

<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
  <!-- Control sidebar content goes here -->
</aside>
<!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->
<!-- jQuery -->
<script src="<?php echo base_url(); ?>/theme/plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="<?php echo base_url(); ?>/theme/plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="<?php echo base_url(); ?>/theme/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- daterangepicker -->
<script src="<?php echo base_url(); ?>/theme/plugins/moment/moment.min.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="<?php echo base_url(); ?>/theme/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Summernote -->
<script src="<?php echo base_url(); ?>/theme/plugins/summernote/summernote-bs4.min.js"></script>
<!-- overlayScrollbars -->
<script src="<?php echo base_url(); ?>/theme/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo base_url(); ?>/theme/dist/js/adminlte.js"></script>
<!-- SweetAlert2 -->
<script src="<?php echo base_url(); ?>/theme/plugins/sweetalert2/sweetalert2.min.js"></script>
<!-- DataTables -->
<script src="<?php echo base_url(); ?>/theme/plugins/datatables/jquery.dataTables.js"></script>
<script src="<?php echo base_url(); ?>/theme/plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script>
<!--Core Functions-->
<script src="<?php echo base_url(); ?>/custom/js/core.js"></script>
<!--Cerrar Sesion-->


<script type="text/javascript" src="<?php echo base_url(); ?>/js_paginas/cdn/pdfmake.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>/js_paginas/cdn/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>/js_paginas/cdn/jszip.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>/js_paginas/cdn/vfs_fonts.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>/js_paginas/cdn/buttons.html5.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>/js_paginas/cdn/buttons.print.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>/js_paginas/cdn/buttons.html5.styles.templates.min.js"></script>











<script type="text/javascript">
  $("#logout").on('click', function(e) {
    e.preventDefault();
    Swal.fire({
      title: 'Salir del Sistema',
      text: "¿Está seguro de salir del sistema?",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Aceptar',
      cancelButtonText: 'Cancelar',
    }).then((result) => {
      if (result.value) {
        window.location = '/logout';
      }
    });
  });
</script>
<!-- ******ESTO ES PARA INSERTAR LA IMAGEN EN EL PDF,******* -->
<?php
$path = ROOTPATH . 'public/img/header.png'; //this is the image path
$type = pathinfo($path, PATHINFO_EXTENSION);
$data = file_get_contents($path);
$base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
?>
<script>
  var rootpath = '<?php echo ($base64); ?>'
</script>