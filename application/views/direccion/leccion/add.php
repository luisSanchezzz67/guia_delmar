<?= form_open('leccion/save', array('id' => 'formleccion'), array('method' => 'add')); ?>
<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">Formulario <?= $subtitulo ?></h3>
        <div class="box-tools pull-right">
            <a href="<?= base_url() ?>leccion" class="btn btn-sm btn-flat btn-primary">
                <i class="fa fa-arrow-left"></i> Cancelar
            </a>
        </div>
    </div>
    <div class="box-body">
        <div class="row">
            <div class="col-sm-4 col-sm-offset-4">
                <div class="form-group">
                    <label for="curso">Curso</label>
                    <select name="curso" id="curso" class="form-control select2" style="width: 100%!important">
                        <option value="" disabled selected>Escoger Curso</option>
                        <?php foreach ($curso as $row) : ?>
                            <option value="<?= $row->id_curso ?>"><?= $row->nombre_curso ?></option>
                        <?php endforeach; ?>
                    </select>
                    <small class="help-block"></small>
                </div>
                <div class="form-group">
                    <label for="titulo_leccion">Título de la lección</label>
                    <input type="text" class="form-control" name="titulo_leccion" placeholder="Título">
                    <small class="help-block"></small>
                </div>
                <div class="form-group">
                    <label for="video_leccion">Video de la lección</label>
                    <input type="text" class="form-control" name="video_leccion" placeholder="Ejemplo: https://www.youtube.com/watch?v=cJ5QJ9oh8Ng">
                    <small class="help-block"></small>
                </div>
                <div class="form-group">
                    <label for="contenido_leccion">Contenido</label>
                    <textarea type="text" class="form-control" name="contenido_leccion"></textarea>
                    <small class="help-block"></small>
                </div>
                <div class="form-group">
                    <label for="estado_leccion">Estado</label>
                    <select name="estado_leccion" class="form-control">
                        <option value="" disabled selected>--- Seleccionar ---</option>
                        <option value="Random">Borrador</option>
                        <option value="Sort">Publicada</option>
                    </select>
                    <small class="help-block"></small>
                </div>
                <div class="form-group">
                    <label for="fecha_inicio">Fecha inicial</label>
                    <input name="fecha_inicio" type="text" class="datetimepicker form-control" placeholder="Fecha de Inicio">
                    <small class="help-block"></small>
                </div>
                <div class="form-group">
                    <label for="fecha_terminacion">Fecha máxima</label>
                    <input name="fecha_terminacion" type="text" class="datetimepicker form-control" placeholder="Fecha máxima">
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

<script src="<?= base_url() ?>assets/dist/js/app/master/leccion/add.js"></script>
