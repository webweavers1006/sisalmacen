 <!-- date-range-picker -->
 <script src="<?php echo base_url();?>/theme/plugins/daterangepicker/daterangepicker.js"></script>
 <!-- Select2 -->
 <script src="<?php echo base_url();?>/theme/plugins/select2/js/select2.full.min.js"></script>
 <!-- DataTables -->
 <script src="<?php echo base_url();?>/theme/plugins/datatables/jquery.dataTables.min.js"></script>
 <script src="<?php echo base_url();?>/theme/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
 <!-- DataTables Buttons -->
 <script src="<?php echo base_url();?>/theme/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
 <script src="<?php echo base_url();?>/theme/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
 <script src="<?php echo base_url();?>/theme/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
 <script src="<?php echo base_url();?>/theme/plugins/datatables-buttons/js/buttons.print.min.js"></script>
 <script src="<?php echo base_url();?>/theme/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
 <!-- JSZip for Excel -->
 <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
 <!-- pdfmake for PDF -->
 <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
 <!-- DataTables Responsive -->
 <script src="<?php echo base_url();?>/theme/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
 <script src="<?php echo base_url();?>/theme/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
 <script type="text/javascript" src="<?php echo base_url();?>/custom/js/reportes/6/custom.js"></script>
<!-- ******ESTO ES PARA INSERTAR LA IMAGEN EN EL PDF,******* -->
<?php
$path = ROOTPATH . 'public/img/cintillo_tradicional.png'; //this is the image path
$type = pathinfo($path, PATHINFO_EXTENSION);
$data = file_get_contents($path);
$base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
?>
<script>
    var rootpath = '<?php echo ($base64); ?>'
</script>

</body>
</html>