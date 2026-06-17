<head>
  <link rel="stylesheet" href="<?php echo base_url();?>/theme/dist/css/adminlte.min.css">
</head>
<body>
	<table class="table table-light">
		<tr>
			<td colspan="3">
				<img src="<?php echo $_SERVER["DOCUMENT_ROOT"];?>/img/Logosapi-2020.png" style="max-width: 10rem; max-height: 10rem;">
			</td>
		</tr>
		<tr>
			<td rowspan="3">
				Solicitud por: <?php echo $usupnom.' '.$usupape;?><br>
				<?php echo $dirnom;?><br>
				<?php echo $depnom;?><br>	
			</td>
			<td></td>
			<td rowspan="2" class="float-right">
				<b>Fecha :</b><?php echo $fecsol;?><br>
				<b>Estatus de solicitud: </b><?php echo $statusnom;?>
			</td>
		</tr>
	</table>
  <table style="border-style:solid; border-width: 2px; border-color: black" class="text-center table" id="detalles-orden">
    <thead>
    	<tr>
    		<th>Codigo de barras</th>
    		<th>Marca</th>
    		<th>Descripcion</th>
    		<th>Cantidad Solicitada</th>
    	</tr>
    </thead>
    <tbody>
    	<?php echo $tbody;?>
    </tbody>
  </table>
  <div class="w-100" style="break-after: always;"></div>
</body>
