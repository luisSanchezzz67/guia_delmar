<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">Formulario <?= $titulo ?></h3>
        <div class="box-tools pull-right">
            <a href="<?= base_url('estudiante') ?>" class="btn btn-sm btn-flat btn-primary">
                <i class="fa fa-arrow-left"></i> Cancelar
            </a>
        </div>
    </div>
    <div class="box-body">
        <div class="row">
            <div class="col-sm-4 col-sm-offset-4">
                <?= form_open('estudiante/save', array('id' => 'estudiante'), array('method' => 'add')) ?>
                <div class="form-group">
                    <label for="nim">NIM</label>
                    <input autofocus="autofocus" onfocus="this.select()" placeholder="Std ID" type="text" name="nim" class="form-control">
                    <small class="help-block"></small>
                </div>
                <div class="form-group">
                    <label for="nombre">Nombre</label>
                    <input placeholder="Nombre de Estudiante" type="text" name="nombre" class="form-control">
                    <small class="help-block"></small>
                </div>
                <div class="form-group">
                    <label for="email">Correo</label>
                    <input placeholder="Correo" type="email" name="email" class="form-control">
                    <small class="help-block"></small>
                </div>
                <div class="form-group">
                    <label for="genero">Género</label>
<<<<<<< HEAD
                    <select name="genero" class="form-control select2">
=======
                    <select id="genero" name="genero" class="form-control select2">
>>>>>>> 0e5f70f971dcee42c3ff1ec837154ba13602edf4
                        <option value="">-- Seleccionar --</option>
                        <option value="M">Masculino</option>
                        <option value="F">Femenino</option>
                    </select>
                    <small class="help-block"></small>
                </div>
                <div class="form-group">
                    <label for="grupo">Grupo</label>
                    <select id="grupo" name="grupo" class="form-control select2">
                        <option value="" disabled selected>-- Seleccionar --</option>
                    </select>
                    <small class="help-block"></small>
                </div>
                <div class="form-group">
                    <label for="clase">Clase</label>
                    <select id="clase" name="clase" class="form-control select2">
                        <option value="">-- Seleccionar --</option>
                    </select>
                    <small class="help-block"></small>
                </div>
                <div class="form-group pull-right">
                    <button type="reset" class="btn btn-flat btn-default"><i class="fa fa-rotate-left"></i> Resetear</button>
                    <button type="submit" id="submit" class="btn btn-flat bg-purple"><i class="fa fa-save"></i> Guardar</button>
                </div>
                <?= form_close() ?>
            </div>
        </div>
    </div>
</div>

<script src="<?= base_url() ?>assets/dist/js/app/master/estudiante/add.js"></script>