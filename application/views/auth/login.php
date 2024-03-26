<style>
	html,
	body {
		width: 100%;
		height: 100%;
	}

	body {
		/* background-image: url('<?= base_url('uploads/default/wallpaper.jpg') ?>') !important; */
		background-color: #e74a3b !important;
		background-size: cover !important;
		background-repeat: no-repeat !important;
		background-position: center center !important;
	}

	/* #login-main {
		flex-direction: column;
		justify-content: center;
		align-items: center;
	} */

	/*Login style*/

	.login-container-image {
		margin: 0 auto;
		margin-top: 100px;
		width: 905px;
		height: 450px;
		display: flex;
		flex-direction: row;
		justify-content: center;
		align-items: center;
	}

	/*Imagen* */

	.logo-login-principal {
		margin-left: 160px;
		margin-bottom: 20px;
	}

	.imagen-background {
		width: 100%;
		height: 100%;
	}

	.imagen-background img {
		height: 100%;
		width: 100%;
		background-position: center;
		background-repeat: no-repeat;
		background-size: cover;
	}


	/*Formulario*/

	.login-box-body {
		width: 100%;
		height: 100%;
	}

	.form-control {
		border: none;
		border-radius: 1.2rem;
		height: 46px;
		border: 1px solid #ced4da;
	}

	/*End login style*/
</style>
<div class="container">
	<div class="row justify-content-center">
		<div class="col-xl-10 col-lg-12 col-md-9">
			<div class="login-container-image" id="login-main">
				<!--Contenedor de la imagen-->
				<div class="imagen-background">
					<img class="image-background-login" src="https://images.unsplash.com/photo-1532012197267-da84d127e765?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80" alt="">
				</div>

				<!-- Formulario de login -->
				<div class="login-box-body">
					<img class="logo-login-principal" src="<?= base_url('uploads/default/logo.jpeg') ?>" alt="">
					<h3 class="text-center mt-0 mb-4">
						Sistema de Examen en Línea
					</h3>
					<p class="login-box-msg">Ingresa tus credenciales para iniciar sesión</p>

					<div id="infoMessage" class="text-center"><?php echo $message; ?></div>

					<?= form_open("auth/cek_login", array('id' => 'login')); ?>
					<div class="form-group has-feedback">
						<?= form_input($identity); ?>
						<span class="fa fa-envelope form-control-feedback"></span>
						<span class="help-block"></span>
					</div>
					<div class="form-group has-feedback">
						<?= form_input($password); ?>
						<span class="glyphicon glyphicon-lock form-control-feedback"></span>
						<span class="help-block"></span>
					</div>
					<div class="row">
						<div class="col-xs-8">
							<div class="checkbox icheck">
								<label>
									<?= form_checkbox('remember', '', FALSE, 'id="remember"'); ?> Recuérdame
								</label>
							</div>
						</div>
						<!-- /.col -->
						<div class="col-xs-4">
							<?= form_submit('submit', lang('login_submit_btn'), array('id' => 'submit', 'class' => 'btn btn-success btn-block btn-flat')); ?>
						</div>
						<!-- /.col -->
					</div>
					<?= form_close(); ?>

					<a href="<?= base_url() ?>auth/forgot_password" class="text-center">Olvidaste tu contraseña?</a>

				</div>
			</div>
		</div>
	</div>



</div>


<script type="text/javascript">
	let base_url = '<?= base_url(); ?>';
</script>
<script src="<?= base_url() ?>assets/dist/js/app/auth/login.js"></script>