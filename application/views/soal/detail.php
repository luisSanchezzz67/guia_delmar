<div class="box">
    <div class="box-header with-header">
        <h3 class="box-title">Información de Pregunta</h3>
        <div class="pull-right">
            <a href="<?= base_url() ?>soal" class="btn btn-xs btn-flat btn-default">
                <i class="fa fa-arrow-left"></i> Volver
            </a>
            <a href="<?= base_url() ?>soal/edit/<?= $this->uri->segment(3) ?>" class="btn btn-xs btn-flat btn-primary">
                <i class="fa fa-edit"></i> Editar
            </a>
        </div>
    </div>
    <div class="box-body">
        <div class="row">
            <div class="col-sm-8 col-sm-offset-2">
                <h3 class="text-center">Pregunta</h3>
                <?php if (!empty($soal->file)) : ?>
                    <div class="w-50">
                        <?= tampil_media('uploads/bank_soal/' . $soal->file); ?>
                    </div>
                <?php endif; ?>
                <?= $soal->soal ?>
                <hr class="my-4">
                <h3 class="text-center">Respuesta</h3>

                <?php
                $abjad = ['a', 'b', 'c', 'd', 'e'];
                $benar = "<i class='fa fa-check-circle text-purple'></i>";

                foreach ($abjad as $abj) :

                    $ABJ = strtoupper($abj);
                    $opsi = 'opsi_' . $abj;
                    $file = 'file_' . $abj;
                ?>

                    <h4>Pregunta <?= $ABJ ?> <?= $soal->jawaban === $ABJ ? $benar : "" ?></h4>
                    <?= $soal->$opsi ?>

                    <?php if (!empty($soal->$file)) : ?>
                        <div class="w-50 mx-auto">
                            <?= tampil_media('uploads/bank_soal/' . $soal->$file); ?>
                        </div>
                    <?php endif; ?>

                <?php endforeach; ?>

                <hr class="my-4">
                <strong>Creado en:</strong> <?= date("M d, Y h:i A", ($soal->created_on)) ?>
                <br>
                <strong>Última Actualización:</strong> <?= date("M d, Y h:i A", ($soal->updated_on)) ?>
            </div>
        </div>
    </div>
</div>