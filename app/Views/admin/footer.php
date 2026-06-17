<!--Custom Script-->
<script type="text/javascript" src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/plug-ins/1.13.1/dataRender/datetime.js"></script><!-- OPTIONAL SCRIPTS -->
<!-- Script -->
<script type="text/javascript" src="<?php echo base_url(); ?>/custom/js/admin.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>/custom/js/admin/roles.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>/custom/js/admin/direcciones.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>/custom/js/admin/departamentos.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>/custom/js/admin/usuarios.js"></script><!-- Para los estilos en Excel     -->

<script src="https://cdn.jsdelivr.net/npm/datatables-buttons-excel-styles@1.1.1/js/buttons.html5.styles.templates.min.js"></script>
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


</body>

</html>









