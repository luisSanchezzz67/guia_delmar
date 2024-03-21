<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title"><?= $subtitulo ?></h3>
        <div class="box-tools pull-right">
            <a href="<?= base_url() ?>prueba/master" class="btn btn-sm btn-flat btn-primary">
                <i class="fa fa-arrow-left"></i> Cancelar
            </a>
        </div>
    </div>
    <div class="box-body">
        <div class="row">
            <div class="col-sm-4">
                <div class="alert bg-purple">
                    <h4>Curso <i class="fa fa-book pull-right"></i></h4>
                    <p><?= $curso->nombre_curso ?></p>
                </div>
                <div class="alert bg-purple">
                    <h4>Profesor <i class="fa fa-address-book-o pull-right"></i></h4>
                    <p><?= $profesor->nombre_profesor ?></p>
                </div>
            </div>
            <div class="col-sm-4">
                <?= form_open('prueba/save', array('id' => 'formprueba'), array('method' => 'edit', 'profesor_id' => $profesor->id_profesor, 'curso_id' => $curso->curso_id, 'id_prueba' => $prueba->id_prueba)) ?>
                <div class="form-group">
                    <label for="nombre_prueba">Nombre de Examen</label>
                    <input value="<?= $prueba->nombre_prueba ?>" autofocus="autofocus" onfocus="this.select()" placeholder="Nombre de Examen" type="text" class="form-control" name="nombre_prueba">
                    <small class="help-block"></small>
                </div>
                <div class="form-group">
                    <label for="cantidad_banco_preguntas">Número de Preguntas</label>
                    <input value="<?= $prueba->cantidad_banco_preguntas ?>" placeholder="Número de Preguntas" type="number" class="form-control" name="cantidad_banco_preguntas">
                    <small class="help-block"></small>
                </div>
                <div class="form-group">
                    <label for="fecha_inicio">Fecha de Inicio</label>
                    <input id="fecha_inicio" name="fecha_inicio" type="text" class="datetimepicker form-control" placeholder="Fecha de Inicio">
                    <small class="help-block"></small>
                </div>
                <div class="form-group">
                    <label for="fecha_terminacion">Fecha de Terminación</label>
                    <input id="fecha_terminacion" name="fecha_terminacion" type="text" class="datetimepicker form-control" placeholder="Fecha de Terminación">
                    <small class="help-block"></small>
                </div>
                <div class="form-group">
                    <label for="tiempo">Hora</label>
                    <input value="<?= $prueba->tiempo ?>" placeholder="En minutos" type="number" class="form-control" name="tiempo">
                    <small class="help-block"></small>
                </div>
                <div class="form-group">
                    <label for="tipo">Patrón de preguntas</label>
                    <select name="tipo" class="form-control">
                        <option value="" disabled selected>--- Escoger ---</option>
                        <option <?= $prueba->tipo === "Random" ? "selected" : ""; ?> value="Random">Preguntas aleatorias</option>
                        <option <?= $prueba->tipo === "Sort" ? "selected" : ""; ?> value="Sort">Ordenar preguntas</option>
                    </select>
                    <small class="help-block"></small>
                </div>

                <!----Documentos--->

                <div class="form-group">
                    <label for="banco_preguntas" class="control-label">Instrucciones :</label>
                    <textarea name="banco_preguntas" id="banco_preguntas" class="form-control summernote"><?= $prueba->banco_preguntas ?></textarea>
                    <small class="help-block" style="color: #dc3545"><?= form_error('banco_preguntas') ?></small>
                </div>
                <div class="form-group">
                    <label for="enlace" class="control-label">Enlace de descarga: </label>
                    <input value="<?= $prueba->enlace ?>" autofocus="autofocus" onfocus="this.select()" placeholder="Enlace del archivo" type="text" class="form-control" name="enlace">
                    <small class="help-block"></small>
                </div>

                <!-----End documentos--->

                <div class="form-group pull-right">
                    <button type="reset" class="btn btn-default btn-flat">
                        <i class="fa fa-rotate-left"></i> Resetear
                    </button>
                    <button id="submit" type="submit" class="btn btn-flat bg-purple"><i class="fa fa-save"></i> Guardar</button>
                </div>
                <?= form_close() ?>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    var fecha_inicio = '<?= $prueba->fecha_inicio ?>';
    var tarde = '<?= $prueba->tarde ?>';
</script>

<script src="<?= base_url() ?>assets/dist/js/app/prueba/edit.js"></script>