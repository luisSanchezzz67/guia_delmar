<div class="h-100 w-100 d-flex" id="login-main">
				<!-- /.login-logo -->
				<div class="login-box-body col-lg-3 col-md-4 col-sm-10 col-xs-12">
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