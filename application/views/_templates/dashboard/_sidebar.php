<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">

	<!-- sidebar: style can be found in sidebar.less -->
	<section class="sidebar">

		<!-- Sidebar user panel (optional) -->
		<div class="user-panel">
			<div class="pull-left image">
				<img src="<?= base_url() ?>assets/dist/img/usersys-min.png" class="img-circle" alt="User Image">
			</div>
			<div class="pull-left info">
				<p><?= $user->username ?></p>
				<small><?= $user->email ?></small>
			</div>
		</div>

		<ul class="sidebar-menu" data-widget="tree">
			<li class="header">Menú Principal</li>
			<!-- Optionally, you can add icons to the links -->
			<?php
			$page = $this->uri->segment(1);
			$master = ["grupo", "clase", "curso", "profesor", "alumno"];
			$relasi = ["claseprofesor", "grupocurso"];
			$users = ["users"];
			?>
			<li class="<?= $page === 'dashboard' ? "active" : "" ?>"><a href="<?= base_url('dashboard') ?>"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a></li>
			<?php if ($this->ion_auth->is_admin()) : ?>
				<li class="treeview <?= in_array($page, $master)  ? "active menu-open" : ""  ?>">
					<a href="#"><i class="fa fa-folder-open"></i> <span>Dirección</span>
						<span class="pull-right-container">
							<i class="fa fa-angle-left pull-right"></i>
						</span>
					</a>
					<ul class="treeview-menu">
						<li class="<?= $page === 'grupo' ? "active" : "" ?>">
							<a href="<?= base_url('grupo') ?>">
								<i class="fa fa-bars"></i>
								Grupos
							</a>
						</li>
						<li class="<?= $page === 'clase' ? "active" : "" ?>">
							<a href="<?= base_url('clase') ?>">
								<i class="fa fa-bars"></i>
								Clases
							</a>
						</li>
						<li class="<?= $page === 'curso' ? "active" : "" ?>">
							<a href="<?= base_url('curso') ?>">
								<i class="fa fa-bars"></i>
								Cursos
							</a>
						</li>
						<li class="<?= $page === 'profesor' ? "active" : "" ?>">
							<a href="<?= base_url('profesor') ?>">
								<i class="fa fa-bars"></i>
								Profesor
							</a>
						</li>
						<li class="<?= $page === 'estudiante' ? "active" : "" ?>">
							<a href="<?= base_url('estudiante') ?>">
								<i class="fa fa-bars"></i>
								Estudiante
							</a>
						</li>
					</ul>
				</li>
				<li class="treeview <?= in_array($page, $relasi)  ? "active menu-open" : ""  ?>">
					<a href="#"><i class="fa fa-link"></i> <span>Relación</span>
						<span class="pull-right-container">
							<i class="fa fa-angle-left pull-right"></i>
						</span>
					</a>
					<ul class="treeview-menu">
						<li class="<?= $page === 'claseprofesor' ? "active" : "" ?>">
							<a href="<?= base_url('claseprofesor') ?>">
								<i class="fa fa-bars"></i>
								Clase - Profesor
							</a>
						</li>
						<li class="<?= $page === 'grupocurso' ? "active" : "" ?>">
							<a href="<?= base_url('grupocurso') ?>">
								<i class="fa fa-bars"></i>
								Grupo - Curso
							</a>
						</li>
					</ul>
				</li>
			<?php endif; ?>
			<?php if ($this->ion_auth->is_admin() || $this->ion_auth->in_group('Lecturer')) : ?>
				<li class="<?= $page === 'banco_preguntas' ? "active" : "" ?>">
					<a href="<?= base_url('banco_preguntas') ?>" rel="noopener noreferrer">
						<i class="fa fa-file-text"></i> <span>Banco de Preguntas</span>
					</a>
				</li>
			<?php endif; ?>
			<?php if ($this->ion_auth->in_group('Lecturer')) : ?>
				<li class="<?= $page === 'prueba' ? "active" : "" ?>">
					<a href="<?= base_url('prueba/master') ?>" rel="noopener noreferrer">
						<i class="fa fa-pencil"></i> <span>Examen</span>
					</a>
				</li>
			<?php endif; ?>
			<?php if ($this->ion_auth->in_group('Student')) : ?>
				<li class="<?= $page === 'prueba' ? "active" : "" ?>">
					<a href="<?= base_url('Prueba/list') ?>" rel="noopener noreferrer">
						<i class="fa fa-pencil"></i> <span>Examen</span>
					</a>
				</li>
			<?php endif; ?>
			<?php if (!$this->ion_auth->in_group('Student')) : ?>
				<li class="header">REPORTS</li>
				<li class="<?= $page === 'resultado_examen' ? "active" : "" ?>">
					<a href="<?= base_url('resultado_examen') ?>" rel="noopener noreferrer">
						<i class="fa fa-file"></i> <span>Resultados de Examen</span>
					</a>
				</li>
			<?php endif; ?>
			<?php if ($this->ion_auth->is_admin()) : ?>
				<li class="header">ADMINISTRATOR</li>
				<li class="<?= $page === 'users' ? "active" : "" ?>">
					<a href="<?= base_url('users') ?>" rel="noopener noreferrer">
						<i class="fa fa-users"></i> <span>Administración de Usuarios</span>
					</a>
				</li>
				<li class="<?= $page === 'settings' ? "active" : "" ?>">
					<a href="<?= base_url('settings') ?>" rel="noopener noreferrer">
						<i class="fa fa-cogs"></i> <span>Configuración</span>
					</a>
				</li>
			<?php endif; ?>
		</ul>

	</section>
	<!-- /.sidebar -->
</aside>