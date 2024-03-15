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
                <?= form_open('estudiante/save', array('id' => 'estudiante'), array('method' => 'edit', 'id_estudiante' => $estudiante->id_estudiante)) ?>
                <div class="form-group">
                    <label for="nim">NIM</label>
                    <input value="<?= $estudiante->nim ?>" autofocus="autofocus" onfocus="this.select()" placeholder="NIM" type="text" name="nim" class="form-control">
                    <small class="help-block"></small>
                </div>
                <div class="form-group">
                    <label for="nombre">Nombre</label>
                    <input value="<?= $estudiante->nombre ?>" placeholder="Nombre" type="text" name="nombre" class="form-control">
                    <small class="help-block"></small>
                </div>
                <div class="form-group">
                    <label for="email">Correo</label>
                    <input value="<?= $estudiante->email ?>" placeholder="Correo" type="email" name="email" class="form-control">
                    <small class="help-block"></small>
                </div>
                <div class="form-group">
                    <label for="jenis_kelamin">Género</label>
                    <select name="jenis_kelamin" class="form-control select2">
                        <option value="">-- Seleccionar --</option>
                        <option <?= $estudiante->jenis_kelamin === "M" ? "selected" : "" ?> value="M">Male</option>
                        <option <?= $estudiante->jenis_kelamin === "F" ? "selected" : "" ?> value="F">Female</option>
                    </select>
                    <small class="help-block"></small>
                </div>
                <div class="form-group">
                    <label for="grupo">Departmento</label>
                    <select id="grupo" name="grupo" class="form-control select2">
                        <option value="" disabled selected>-- Seleccionar --</option>
                        <?php foreach ($grupo as $j) : ?>
                            <option <?= $estudiante->id_grupo === $j->id_grupo ? "selected" : "" ?> value="<?= $j->id_grupo ?>">
                                <?= $j->nombre_grupo ?>
                            </option>
                        <?php endforeach ?>
                    </select>
                    <small class="help-block"></small>
                </div>
                <div class="form-group">
                    <label for="clase">Clase</label>
                    <select id="clase" name="clase" class="form-control select2">
                        <option value="" disabled selected>-- Seleccionar --</option>
                        <?php foreach ($clase as $k) : ?>
                            <option <?= $estudiante->id_clase === $k->id_clase ? "selected" : "" ?> value="<?= $k->id_clase ?>">
                                <?= $k->nombre_clase ?>
                            </option>
                        <?php endforeach ?>
                    </select>
                    <small class="help-block"></small>
                </div>
                <div class="form-group pull-right">
                    <button type="reset" class="btn btn-flat btn-danger"><i class="fa fa-rotate-left"></i> Resetear</button>
                    <button type="submit" id="submit" class="btn btn-flat bg-green"><i class="fa fa-save"></i> Guardar</button>
                </div>
                <?= form_close() ?>
            </div>
        </div>
    </div>
</div>

<script src="<?= base_url() ?>assets/dist/js/app/master/estudiante/edit.js"></script>