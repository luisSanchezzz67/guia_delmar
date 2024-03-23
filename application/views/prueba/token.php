<div class="callout callout-info">
    <h4>Reglas del examen</h4>
    <p>No copiar, No copiar, No copiar, No copiar, No copiar, No copiar, No copiar, No copiar, No copiar, No copiar, No copiar, No copiar, No copiar, No copiar, No copiar, No copiar, No copiar, No copiar, No copiar, No copiar, No copiar, No copiar,</p>
</div>
<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">Confirm Data</h3>
    </div>
    <div class="box-body">
        <span id="id_prueba" data-key="<?= $encrypted_id ?>"></span>
        <div class="row">
            <div class="col-sm-6">
                <table class="table table-bordered">
                    <tr>
                        <th>Name</th>
                        <td><?= $mhs->nombre ?></td>
                    </tr>
                    <tr>
                        <th>Lecturer</th>
                        <td><?= $prueba->nombre_profesor ?></td>
                    </tr>
                    <tr>
                        <th>Class/Grupo</th>
                        <td><?= $mhs->nombre_clase ?> / <?= $mhs->nombre_grupo ?></td>
                    </tr>
                    <tr>
                        <th>Exam Name</th>
                        <td><?= $prueba->nombre_prueba ?></td>
                    </tr>
                    <tr>
                        <th>Number of Questions</th>
                        <td><?= $prueba->cantidad_banco_preguntas ?></td>
                    </tr>
                    <tr>
                        <th>Time</th>
                        <td><?= $prueba->tiempo ?> Minute</td>
                    </tr>
                    <tr>
                        <th>Late</th>
                        <td>
                            <?= date('d M Y', strtotime($prueba->tarde)) ?>
                            <?= date('h:i A', strtotime($prueba->tarde)) ?>
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
                            <?= $prueba->banco_preguntas ?>
                            </p>
                        </div>
                        <div class="callout callout-info">
                            <a href="<?= $prueba->enlace ?>">Descargar PDF AQUÍ</a>
                        </div>
                        <div class="callout callout-info">
                            <p>
                                El momento para realizar el examen es cuando el botón "INICIAR" esté en verde.
                            </p>
                        </div>
                        <?php
                        $comenzar = strtotime($prueba->fecha_inicio);
                        $tarde = strtotime($prueba->tarde);
                        $now = time();
                        if ($comenzar > $now) :
                        ?>
                            <div class="callout callout-success">
                                <strong><i class="fa fa-clock-o"></i>El examen iniciará en</strong>
                                <br>
                                <span class="countdown" data-time="<?= date('Y-m-d H:i:s', strtotime($prueba->fecha_inicio)) ?>">00 Days, 00 Hours, 00 Minutes, 00 Seconds</strong><br />
                            </div>
                        <?php elseif ($tarde > $now) : ?>
                            <button id="btncek" data-id="<?= $prueba->id_prueba ?>" class="btn btn-success btn-lg mb-4">
                                <i class="fa fa-pencil"></i> Inicio
                            </button>
                            <div class="callout callout-danger">
                                <i class="fa fa-clock-o"></i> <strong class="countdown" data-time="<?= date('Y-m-d H:i:s', strtotime($prueba->tarde)) ?>">00 Days, 00 Hours, 00 Minutes, 00 Seconds</strong><br />
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

<script src="<?= base_url() ?>assets/dist/js/app/prueba/token.js"></script>