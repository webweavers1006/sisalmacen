<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1>Orden Nº : <?php echo $numorden; ?></h1>
				</div>
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
					</ol>
				</div>
			</div>
		</div><!-- /.container-fluid -->
	</section>

	<section class="content">
		<div class="container-fluid">
			<div class="row">
				<div class="col-12">
					<!-- Main content -->
					<div class="invoice p-3 mb-3">
						<!-- title row -->
						<div class="row">
							<div class="col-12">
								<h4>
									<img src="<?php echo base_url(); ?>/img/Logosapi-2020.png" style="max-width: 6rem; max-height: 6rem;">
									<small class="float-right">Fecha: <?php echo $fecsol; ?></small>
								</h4>
							</div>
							<!-- /.col -->
						</div>
						<!-- info row -->
						<form id="aprobar-orden" role="form">
							<input type="hidden" name="numorden" id="numorden" value="<?php echo $numorden; ?>">
							<input type="hidden" name="ususol" id="ususol" value="<?php echo $userid; ?>">
							<div class="row invoice-info">
								<div class="col-sm-4 invoice-col">
									Solicitud por
									<address>
										<strong><?php echo $usupnom . ' ' . $usupape; ?></strong><br>
										<?php echo $dirnom; ?><br>
										<?php echo $depnom; ?><br>
										<b>Comentario Almacenista :</b>
										<?php echo $comentario; ?><br>
									</address>
								</div>
								<!-- /.col -->
								<div class="col-sm-4 invoice-col">
								</div>
								<!-- /.col -->
								<div class="col-sm-4 invoice-col">
								</div>
								<!-- /.col -->
							</div>
							<!-- /.row -->

							<!-- Table row -->
							<div class="row">
								<div class="col-12 table-responsive">
									<?php echo $tbody; ?>
								</div>
								<!-- /.col -->
							</div>
							<!-- /.row -->

							<div class="row">
								<!-- accepted payments column -->
								<div class="col-6">
								</div>
								<!-- /.col -->
								<div class="col-6">

									<div class="table-responsive">
										<table class="table">
										</table>
									</div>
								</div>
								<!-- /.col -->
							</div>
							<!-- /.row -->

							<!-- this row will not appear when printing -->
							<div class="row no-print justify-content-end">
								<div class="col-12">
									<a href="#" target="_blank" class="btn btn-default"><i class="fas fa-print"></i>Imprimir</a>
									<button type="submit" class="btn btn-success float-right">Aprobar</button>
									<a type="button" class="btn btn-danger float-right rechazar" href="/rechazar-orden/<?php echo $numorden; ?>">Rechazar</a>
									<a type="button" class="btn btn-secondary float-right" href="javascript:history.back()">Cerrar</a>
								</div>
							</div>
						</form>
					</div>
					<!-- /.invoice -->
				</div><!-- /.col -->
			</div><!-- /.row -->
		</div><!-- /.container-fluid -->
	</section>
	<!-- /.content -->
</div>