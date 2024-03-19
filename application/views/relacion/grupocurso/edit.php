<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">Formulario <?= $titulo ?></h3>
        <div class="box-tools pull-right">
            <a href="<?= base_url() ?>grupocurso" class="btn btn-primary btn-flat btn-sm">
                <i class="fa fa-arrow-left"></i> Cancelar
            </a>
        </div>
    </div>
    <div class="box-body">
        <div class="row">
            <div class="col-sm-4 col-sm-offset-4">
                <?= form_open('grupocurso/save', array('id' => 'grupocurso'), array('method' => 'edit', 'curso_id' => $id_curso)) ?>
                <div class="form-group">
                    <label>Curso</label>
                    <input type="text" readonly="readonly" value="<?= $curso->nombre_curso ?>" class="form-control">
                    <small class="help-block text-right"></small>
                </div>
                <div class="form-group">
                    <label>Grupo</label>
                    <select id="grupo" multiple="multiple" name="grupo_id[]" class="form-control select2" style="width: 100%!important">
                        <?php
                        $sj = [];
                        foreach ($grupo as $key => $val) {
                            $sj[] = $val->id_grupo;
                        }
                        foreach ($all_grupo as $m) : ?>
                            <option <?= in_array($m->id_grupo, $sj) ? "selected" : "" ?> value="<?= $m->id_grupo ?>"><?= $m->nombre_grupo ?></option>
                        <?php endforeach; ?>
                    </select>
                    <small class="help-block text-right"></small>
                </div>
                <div class="form-group pull-right">
                    <button type="reset" class="btn btn-flat btn-default">
                        <i class="fa fa-rotate-left"></i> Resetear
                    </button>
                    <button id="submit" type="submit" class="btn btn-flat bg-purple">
                        <i class="fa fa-save"></i> Guardar
                    </button>
                </div>
                <?= form_close() ?>
            </div>
        </div>
    </div>
</div>

<script src="<?= base_url() ?>assets/dist/js/app/relacion/grupocurso/edit.js"></script>