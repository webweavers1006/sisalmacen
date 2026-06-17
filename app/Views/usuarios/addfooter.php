<!-- jquery-validation -->
<script src="<?php echo base_url(); ?>/theme/plugins/jquery-validation/jquery.validate.min.js"></script>
<script src="<?php echo base_url(); ?>/theme/plugins/jquery-validation/additional-methods.min.js"></script>


<!-- SweetAlert2 -->
<script src="<?php echo base_url(); ?>/custom/sweetalert2.all.js"></script>


<!--Custom Scripts-->
<script type="text/javascript" src="<?php echo base_url(); ?>/custom/js/admin.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>/custom/js/admin/edituser.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>/custom/js/admin/usuarios.js"></script>

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