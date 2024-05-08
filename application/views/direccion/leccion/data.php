<div class="box">
	<div class="box-header with-border">
		<h3 class="box-title"><?= $subtitulo ?></h3>
		<div class="box-tools pull-right">
			<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
			</button>
		</div>
	</div>
	<div class="box-body">
		<div class="mt-2 mb-3">
						<?php
						if ($this->ion_auth->in_group('Lecturer') ) {

						?>
				<a href="<?= base_url('leccion/add') ?>" class="btn btn-sm bg-blue btn-flat"><i class="fa fa-plus"></i> Nueva Lección</a>
				<?php } ?>
				<button type="button" onclick="reload_ajax()" class="btn btn-sm bg-maroon btn-flat btn-default"><i class="fa fa-refresh"></i> Recargar</button>
				<div class="pull-right">
				<!-- data-toggle="modal" data-target="#myModal" -->
					
					<?php
						if ($this->ion_auth->in_group('Lecturer') ) {

						?>
					<button onclick="leccion_edit()" class="btn btn-sm btn-flat btn-primary" type="button"><i class="fa fa-edit"></i> Editar</button>
					<button onclick="leccion_delete()" class="btn btn-sm btn-flat btn-danger" type="button"><i class="fa fa-trash"></i> Eliminar</button>
					<?php } ?>
				</div>
		</div>
		<?= form_open('leccion/view', array('id' => 'bulk')) ?>
		<table id="leccion" class="w-100 table table-striped table-bordered table-hover">
			<thead>
				<tr>
					<th>#</th>
					<th>Titulo</th>
					<th>Video</th>
					<th>Estado</th>
					<th>Fecha máxima</th>
					<th>Acción</th>
					
				</tr>
			</thead>
		</table>
		<?= form_close() ?>
	</div>
</div>



<script src="<?= base_url() ?>assets/dist/js/app/master/leccion/data.js"></script>