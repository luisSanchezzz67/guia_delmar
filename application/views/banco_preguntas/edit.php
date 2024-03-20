<div class="row">
    <div class="col-sm-12">
        <?= form_open_multipart('banco_preguntas/save', array('id' => 'formbanco_preguntas'), array('method' => 'edit', 'id_banco_preguntas' => $banco_preguntas->id_banco_preguntas)); ?>
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
                        <div class="row">
                            <div class="form-group col-sm-12">
                                <label for="profesor_id" class="control-label">Profesor (Curso)</label>
                                <?php if ($this->ion_auth->is_admin()) : ?>
                                    <select required="required" name="profesor_id" id="profesor_id" class="select2 form-group" style="width:100% !important">
                                        <option value="" disabled selected>Escoger Profesor</option>
                                        <?php
                                        $sdm = $banco_preguntas->profesor_id . ':' . $banco_preguntas->curso_id;
                                        foreach ($profesor as $d) :
                                            $dm = $d->id_profesor . ':' . $d->curso_id; ?>
                                            <option <?= $sdm === $dm ? "selected" : ""; ?> value="<?= $dm ?>"><?= $d->nombre_profesor ?> (<?= $d->nombre_curso ?>)</option>
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
                                <label for="banco_preguntas" class="control-label text-center">Preguntas</label>
                                <div class="row">
                                    <div class="form-group col-sm-3">
                                        <input type="file" name="file_banco_preguntas" class="form-control">
                                        <small class="help-block" style="color: #dc3545"><?= form_error('file_banco_preguntas') ?></small>
                                        <?php if (!empty($banco_preguntas->file)) : ?>
                                            <?= tampil_media('uploads/banco_preguntas/' . $banco_preguntas->file); ?>
                                        <?php endif; ?>
                                    </div>
                                    <div class="form-group col-sm-9">
                                        <textarea name="banco_preguntas" id="banco_preguntas" class="form-control summernote"><?= $banco_preguntas->banco_preguntas ?></textarea>
                                        <small class="help-block" style="color: #dc3545"><?= form_error('banco_preguntas') ?></small>
                                    </div>
                                </div>
                            </div>

                            <!-- 
                                Membuat perulangan A-E 
                            -->
                            <?php
                            $abjad = ['a', 'b', 'c', 'd', 'e'];
                            foreach ($abjad as $abj) :
                                $ABJ = strtoupper($abj); // Abjad Kapital
                                $file = 'file_' . $abj;
                                $opsi = 'opsi_' . $abj;
                            ?>

                                <div class="col-sm-12">
                                    <label for="respuesta_<?= $abj; ?>" class="control-label text-center">Respuesta <?= $ABJ; ?></label>
                                    <div class="row">
                                        <div class="form-group col-sm-3">
                                            <input type="file" name="<?= $file; ?>" class="form-control">
                                            <small class="help-block" style="color: #dc3545"><?= form_error($file) ?></small>
                                            <?php if (!empty($banco_preguntas->$file)) : ?>
                                                <?= tampil_media('uploads/banco_preguntas/' . $banco_preguntas->$file); ?>
                                            <?php endif; ?>
                                        </div>
                                        <div class="form-group col-sm-9">
                                            <textarea name="respuesta_<?= $abj; ?>" id="respuesta_<?= $abj; ?>" class="form-control summernote"><?= $banco_preguntas->$opsi ?></textarea>
                                            <small class="help-block" style="color: #dc3545"><?= form_error('respuesta_' . $abj) ?></small>
                                        </div>
                                    </div>
                                </div>

                            <?php endforeach; ?>

                            <div class="form-group col-sm-12">
                                <label for="respuesta" class="control-label">Respuesta Correcta</label>
                                <select required="required" name="respuesta" id="respuesta" class="form-control select2" style="width:100%!important">
                                    <option value="" disabled selected>Escoge Respuesta Correcta</option>
                                    <option <?= $banco_preguntas->respuesta === "A" ? "selected" : "" ?> value="A">A</option>
                                    <option <?= $banco_preguntas->respuesta === "B" ? "selected" : "" ?> value="B">B</option>
                                    <option <?= $banco_preguntas->respuesta === "C" ? "selected" : "" ?> value="C">C</option>
                                    <option <?= $banco_preguntas->respuesta === "D" ? "selected" : "" ?> value="D">D</option>
                                    <option <?= $banco_preguntas->respuesta === "E" ? "selected" : "" ?> value="E">E</option>
                                </select>
                                <small class="help-block" style="color: #dc3545"><?= form_error('respuesta') ?></small>
                            </div>
                            <div class="form-group col-sm-12">
                                <label for="peso" class="control-label">Valor Respuesta</label>
                                <input required="required" value="<?= $banco_preguntas->peso ?>" type="number" name="peso" placeholder="Peso de la Pregunta" id="peso" class="form-control">
                                <small class="help-block" style="color: #dc3545"><?= form_error('peso') ?></small>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group pull-right">
                                    <a href="<?= base_url('banco_preguntas') ?>" class="btn btn-flat btn-default"><i class="fa fa-arrow-left"></i> Cancelar</a>
                                    <button type="submit" id="submit" class="btn btn-flat bg-purple"><i class="fa fa-save"></i> Guardar</button>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?= form_close(); ?>
    </div>
</div>