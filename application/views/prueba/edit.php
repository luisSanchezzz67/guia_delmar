<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title"><?= $subjudul ?></h3>
        <div class="box-tools pull-right">
            <a href="<?= base_url() ?>ujian/master" class="btn btn-sm btn-flat btn-primary">
                <i class="fa fa-arrow-left"></i> Cancelar
            </a>
        </div>
    </div>
    <div class="box-body">
        <div class="row">
            <div class="col-sm-4">
                <div class="alert bg-purple">
                    <h4>Curso <i class="fa fa-book pull-right"></i></h4>
                    <p><?= $matkul->nama_matkul ?></p>
                </div>
                <div class="alert bg-purple">
                    <h4>Profesor <i class="fa fa-address-book-o pull-right"></i></h4>
                    <p><?= $dosen->nama_dosen ?></p>
                </div>
            </div>
            <div class="col-sm-4">
                <?= form_open('ujian/save', array('id' => 'formujian'), array('method' => 'edit', 'dosen_id' => $dosen->id_dosen, 'matkul_id' => $matkul->matkul_id, 'id_ujian' => $ujian->id_ujian)) ?>
                <div class="form-group">
                    <label for="nama_ujian">Nombre de Examen</label>
                    <input value="<?= $ujian->nama_ujian ?>" autofocus="autofocus" onfocus="this.select()" placeholder="Nombre de Examen" type="text" class="form-control" name="nama_ujian">
                    <small class="help-block"></small>
                </div>
                <div class="form-group">
                    <label for="jumlah_soal">Número de Preguntas</label>
                    <input value="<?= $ujian->jumlah_soal ?>" placeholder="Número de Preguntas" type="number" class="form-control" name="jumlah_soal">
                    <small class="help-block"></small>
                </div>
                <div class="form-group">
                    <label for="tgl_mulai">Fecha de Inicio</label>
                    <input id="tgl_mulai" name="tgl_mulai" type="text" class="datetimepicker form-control" placeholder="Fecha de Inicio">
                    <small class="help-block"></small>
                </div>
                <div class="form-group">
                    <label for="tgl_selesai">Fecha de Terminación</label>
                    <input id="tgl_selesai" name="tgl_selesai" type="text" class="datetimepicker form-control" placeholder="Fecha de Terminación">
                    <small class="help-block"></small>
                </div>
                <div class="form-group">
                    <label for="waktu">Hora</label>
                    <input value="<?= $ujian->waktu ?>" placeholder="En minutos" type="number" class="form-control" name="waktu">
                    <small class="help-block"></small>
                </div>
                <div class="form-group">
                    <label for="jenis">Patrón de preguntas</label>
                    <select name="jenis" class="form-control">
                        <option value="" disabled selected>--- Escoger ---</option>
                        <option <?= $ujian->jenis === "Random" ? "selected" : ""; ?> value="Random">Preguntas aleatorias</option>
                        <option <?= $ujian->jenis === "Sort" ? "selected" : ""; ?> value="Sort">Ordenar preguntas</option>
                    </select>
                    <small class="help-block"></small>
                </div>

                <!----Documentos--->

                <div class="form-group">
                    <label for="soal" class="control-label">Instrucciones :</label>
                    <textarea name="soal" id="soal" class="form-control summernote"><?= $ujian->soal ?></textarea>
                    <small class="help-block" style="color: #dc3545"><?= form_error('soal') ?></small>
                </div>
                <div class="form-group">
                    <label for="enlace" class="control-label">Enlace de descarga: </label>
                    <input value="<?= $ujian->enlace ?>" autofocus="autofocus" onfocus="this.select()" placeholder="Enlace del archivo" type="text" class="form-control" name="enlace">
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
    var tgl_mulai = '<?= $ujian->tgl_mulai ?>';
    var terlambat = '<?= $ujian->terlambat ?>';
</script>

<script src="<?= base_url() ?>assets/dist/js/app/ujian/edit.js"></script>