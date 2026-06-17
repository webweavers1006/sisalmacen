<head>
  <link rel="stylesheet" href="<?php echo base_url();?>/theme/dist/css/adminlte.min.css">
  <style type="text/css">
  	thead{
  		font-style:initial;
  	}
  	.table-report{
  		border-color:black;
  	}
  </style>
</head>
<body>
	<table class="table table-light">
		<tr>
			<td colspan="3">
				<img src="<?php echo $_SERVER["DOCUMENT_ROOT"];?>/img/Logosapi-2020.png" style="max-width: 10rem; max-height: 10rem;">
			</td>
			<td colspan="3">
				Entradas y Salidas del Almacen desde el <?php echo $fechainicial;?> al <?php echo $fechafinal;?>	
			</td>
		</tr>
	</table>
	<?php echo $tabla;?>
	<table>
		<tr>
			<td>
				<img src="<?php echo $_SERVER["DOCUMENT_ROOT"];?>/img/pie_de_pagina.jpg">
			</td>
		</tr>
	</table>
	<div class="w-100" style="page-break-before: all;"></div>
</body>

