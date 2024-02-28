<?= form_open('dosen/save', array('id' => 'formdosen'), array('method' => 'add')); ?>
<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">Formulario <?= $subjudul ?></h3>
        <div class="box-tools pull-right">
            <a href="<?= base_url() ?>dosen" class="btn btn-sm btn-flat btn-primary">
                <i class="fa fa-arrow-left"></i> Cancelar
            </a>
        </div>
    </div>
    <div class="box-body">
        <div class="row">
            <div class="col-sm-4 col-sm-offset-4">
                <div class="form-group">
                    <label for="nip">NIP</label>
                    <input autofocus="autofocus" onfocus="this.select()" type="number" id="nip" class="form-control" name="nip" placeholder="NIP">
                    <small class="help-block"></small>
                </div>
                <div class="form-group">
                    <label for="nama_dosen">Nombre Profesor</label>
                    <input type="text" class="form-control" name="nama_dosen" placeholder="Nombre Profesor">
                    <small class="help-block"></small>
                </div>
                <div class="form-group">
                    <label for="email">Correo Profesor</label>
                    <input type="text" class="form-control" name="email" placeholder="Correo Profesor">
                    <small class="help-block"></small>
                </div>
                <div class="form-group">
                    <label for="matkul">Curso</label>
                    <select name="matkul" id="matkul" class="form-control select2" style="width: 100%!important">
                        <option value="" disabled selected>Escoger Curso</option>
                        <?php foreach ($matkul as $row) : ?>
                            <option value="<?= $row->id_matkul ?>"><?= $row->nama_matkul ?></option>
                        <?php endforeach; ?>
                    </select>
                    <small class="help-block"></small>
                </div>
                <div class="form-group pull-right">
                    <button type="reset" class="btn btn-flat btn-default">
                        <i class="fa fa-rotate-left"></i> Resetear
                    </button>
                    <button type="submit" id="submit" class="btn btn-flat bg-purple">
                        <i class="fa fa-save"></i> Guardar
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
<?= form_close(); ?>

<script src="<?= base_url() ?>assets/dist/js/app/master/dosen/add.js"></script>