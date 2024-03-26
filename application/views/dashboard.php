<?php if ($this->ion_auth->is_admin()) : ?>
    <div class="row">
        <?php foreach ($info_box as $info) : ?>
            <div class="col-lg-3 col-xs-6">
                <div class="card small-box bg-<?= $info->box ?>">
                    <div class="inner">
                        <h3><?= $info->total; ?></h3>
                        <p><?= $info->text; ?></p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-<?= $info->icon ?>"></i>
                    </div>
                    <a href="<?= base_url() . strtolower($info->title); ?>" class="small-box-footer">
                        Más información <i class="fa fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

<?php elseif ($this->ion_auth->in_group('Lecturer')) : ?>

    <div class="row">
        <div class="col-sm-4">
            <div class="box box-default">
                <div class="box-header with-border">
                    <h3 class="box-title">Account Information</h3>
                </div>
                <table class="table table-hover">
                    <tr>
                        <th>Name</th>
                        <td><?= $profesor->nombre_profesor ?></td>
                    </tr>
                    <tr>
                        <th>NIP</th>
                        <td><?= $profesor->nip ?></td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td><?= $profesor->email ?></td>
                    </tr>
                    <tr>
                        <th>Course</th>
                        <td><?= $profesor->nombre_curso ?></td>
                    </tr>
                    <tr>
                        <th>Class List</th>
                        <td>
                            <ol class="pl-4">
                                <?php foreach ($clase as $k) : ?>
                                    <li><?= $k->nombre_clase ?></li>
                                <?php endforeach; ?>
                            </ol>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

<?php else : ?>

    <div class="row">
        <div class="col-sm-4">
            <div class="box box-default">
                <div class="box-header with-border">
                    <h3 class="box-title">Account Information</h3>
                </div>
                <table class="table table-hover">
                    <tr>
                        <th>NIM</th>
                        <td><?= $estudiante->nim ?></td>
                    </tr>
                    <tr>
                        <th>Name</th>
                        <td><?= $estudiante->nombre ?></td>
                    </tr>
                    <tr>
                        <th>Gender</th>
                        <td><?= $estudiante->genero === 'M' ? "Masculino" : "Femenino"; ?></td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td><?= $estudiante->email ?></td>
                    </tr>
                    <tr>
                        <th>Grupo</th>
                        <td><?= $estudiante->nombre_grupo ?></td>
                    </tr>
                    <tr>
                        <th>Class</th>
                        <td><?= $estudiante->nombre_clase ?></td>
                    </tr>
                </table>
            </div>
        </div>

    </div>

<?php endif; ?>