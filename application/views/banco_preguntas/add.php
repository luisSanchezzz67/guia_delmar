<div class="row">
    <div class="col-sm-12">
        <?= form_open_multipart('banco_preguntas/save', array('id' => 'formbanco_preguntas'), array('method' => 'add')); ?>
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title"><?= $subtitulo ?></h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-sm-8 col-sm-offset-2">
                        <div class="form-group col-sm-12">
                            <label>Profesor (Curso)</label>
                            <?php if ($this->ion_auth->is_admin()) : ?>
                                <select name="profesor_id" required="required" id="profesor_id" class="select2 form-group" style="width:100% !important">
                                    <option value="" disabled selected>Escoger Profresor</option>
                                    <?php foreach ($profesor as $d) : ?>
                                        <option value="<?= $d->id_profesor ?>:<?= $d->curso_id ?>"><?= $d->nombre_profesor ?> (<?= $d->nombre_curso ?>)</option>
                                    <?php endforeach; ?>
                                </select>
                                <small class="help-block" style="color: #dc3545"><?= form_error('profesor_id') ?></small>
                            <?php else : ?>
                                <input type="hidden" name="profesor_id" value="<?= $profesor->id_profesor; ?>">
                                <input type="hidden" name="curso_id" value="<?= $profesor->curso_id; ?>">
                                <input type="text" readonly="readonly" class="form-control" value="<?= $profesor->nombre_profesor; ?> (<?= $profesor->nombre_curso; ?>)">
                            <?php endif; ?>
                        </div>

                        <div class="col-sm-12">
                            <label for="banco_preguntas" class="control-label">Preguntas</label>
                            <div class="form-group">
                                <input type="file" name="file_banco_preguntas" class="form-control">
                                <small class="help-block" style="color: #dc3545"><?= form_error('file_banco_preguntas') ?></small>
                            </div>
                            <div class="form-group">
                                <textarea name="banco_preguntas" id="banco_preguntas" class="form-control summernote"><?= set_value('banco_preguntas') ?></textarea>
                                <small class="help-block" style="color: #dc3545"><?= form_error('banco_preguntas') ?></small>
                            </div>
                        </div>

                        <!-- 
                            Membuat perulangan A-E 
                        -->
                        <?php
                        $abjad = ['a', 'b', 'c', 'd', 'e'];
                        foreach ($abjad as $abj) :
                            $ABJ = strtoupper($abj); // Abjad Kapital
                        ?>

                            <div class="col-sm-12">
                                <label for="file">Respuesta <?= $ABJ; ?></label>
                                <div class="form-group">
                                    <input type="file" name="file_<?= $abj; ?>" class="form-control">
                                    <small class="help-block" style="color: #dc3545"><?= form_error('file_' . $abj) ?></small>
                                </div>
                                <div class="form-group">
                                    <textarea name="respuesta_<?= $abj; ?>" id="respuesta_<?= $abj; ?>" class="form-control summernote"><?= set_value('respuesta_a') ?></textarea>
                                    <small class="help-block" style="color: #dc3545"><?= form_error('respuesta_' . $abj) ?></small>
                                </div>
                            </div>

                        <?php endforeach; ?>

                        <div class="form-group col-sm-12">
                            <label for="respuesta" class="control-label">Respuesta Correcta</label>
                            <select required="required" name="respuesta" id="respuesta" class="form-control select2" style="width:100%!important">
                                <option value="" disabled selected>Escoger Respuesta Correcta</option>
                                <option value="A">A</option>
                                <option value="B">B</option>
                                <option value="C">C</option>
                                <option value="D">D</option>
                                <option value="E">E</option>
                            </select>
                            <small class="help-block" style="color: #dc3545"><?= form_error('respuesta') ?></small>
                        </div>
                        <div class="form-group col-sm-12">
                            <label for="peso" class="control-label">Peso Pregunta</label>
                            <input required="required" value="1" type="number" name="peso" placeholder="Peso Pregunta" id="peso" class="form-control">
                            <small class="help-block" style="color: #dc3545"><?= form_error('peso') ?></small>
                        </div>
                        <div class="form-group pull-right">
                            <a href="<?= base_url('banco_preguntas') ?>" class="btn btn-flat btn-default"><i class="fa fa-arrow-left"></i> Cancelar</a>
                            <button type="submit" id="submit" class="btn btn-flat bg-purple"><i class="fa fa-save"></i> Guardar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?= form_close(); ?>
    </div>
</div>