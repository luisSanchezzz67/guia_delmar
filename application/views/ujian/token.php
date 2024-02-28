<div class="callout callout-info">
    <h4>Reglas del examen</h4>
    <p>No copiar, No copiar, No copiar, No copiar, No copiar, No copiar, No copiar, No copiar, No copiar, No copiar, No copiar, No copiar, No copiar, No copiar, No copiar, No copiar, No copiar, No copiar, No copiar, No copiar, No copiar, No copiar,</p>
</div>
<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">Confirm Data</h3>
    </div>
    <div class="box-body">
        <span id="id_ujian" data-key="<?= $encrypted_id ?>"></span>
        <div class="row">
            <div class="col-sm-6">
                <table class="table table-bordered">
                    <tr>
                        <th>Name</th>
                        <td><?= $mhs->nama ?></td>
                    </tr>
                    <tr>
                        <th>Lecturer</th>
                        <td><?= $ujian->nama_dosen ?></td>
                    </tr>
                    <tr>
                        <th>Class/Department</th>
                        <td><?= $mhs->nama_kelas ?> / <?= $mhs->nama_jurusan ?></td>
                    </tr>
                    <tr>
                        <th>Exam Name</th>
                        <td><?= $ujian->nama_ujian ?></td>
                    </tr>
                    <tr>
                        <th>Number of Questions</th>
                        <td><?= $ujian->jumlah_soal ?></td>
                    </tr>
                    <tr>
                        <th>Time</th>
                        <td><?= $ujian->waktu ?> Minute</td>
                    </tr>
                    <tr>
                        <th>Late</th>
                        <td>
                            <?= date('d M Y', strtotime($ujian->terlambat)) ?>
                            <?= date('h:i A', strtotime($ujian->terlambat)) ?>
                        </td>
                    </tr>
                    <tr>
                        <th style="vertical-align:middle">Token</th>
                        <td>
                            <input autocomplete="off" id="token" placeholder="Token" type="text" class="input-sm form-control">
                        </td>
                    </tr>
                </table>
            </div>
            <div class="col-sm-6">
                <div class="box box-solid">
                    <div class="box-body pb-0">
                        <div class="callout callout-info">
                            <p>
                            <?= $ujian->soal ?>
                            </p>
                        </div>
                        <div class="callout callout-info">
                            <a href="<?= $ujian->enlace ?>">Descargar PDF AQUÍ</a>
                        </div>
                        <div class="callout callout-info">
                            <p>
                                El momento para realizar el examen es cuando el botón "INICIAR" esté en verde.
                            </p>
                        </div>
                        <?php
                        $mulai = strtotime($ujian->tgl_mulai);
                        $terlambat = strtotime($ujian->terlambat);
                        $now = time();
                        if ($mulai > $now) :
                        ?>
                            <div class="callout callout-success">
                                <strong><i class="fa fa-clock-o"></i>El examen iniciará en</strong>
                                <br>
                                <span class="countdown" data-time="<?= date('Y-m-d H:i:s', strtotime($ujian->tgl_mulai)) ?>">00 Days, 00 Hours, 00 Minutes, 00 Seconds</strong><br />
                            </div>
                        <?php elseif ($terlambat > $now) : ?>
                            <button id="btncek" data-id="<?= $ujian->id_ujian ?>" class="btn btn-success btn-lg mb-4">
                                <i class="fa fa-pencil"></i> Inicio
                            </button>
                            <div class="callout callout-danger">
                                <i class="fa fa-clock-o"></i> <strong class="countdown" data-time="<?= date('Y-m-d H:i:s', strtotime($ujian->terlambat)) ?>">00 Days, 00 Hours, 00 Minutes, 00 Seconds</strong><br />
                                Tiempo de espera para presionar el botón de inicio.
                            </div>
                        <?php else : ?>
                            <div class="callout callout-danger">
                                El momento de presionar el <strong>botón de inicio</strong> Inicio<br />
                                Póngase en contacto con su profesor para poder realizar el examen SUSTITUTO.
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="<?= base_url() ?>assets/dist/js/app/ujian/token.js"></script>