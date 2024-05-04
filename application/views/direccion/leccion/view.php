<?= form_open('leccion/view', array('id' => 'formleccion'), array('method' => 'edit', 'id_leccion' => $leccion[0]->id)); ?>
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
                <?php
                // var_dump($leccion);
                $i = 1;
                foreach ($leccion as $lec) : ?>

                    <div class="form-group">
                        <div class="panel panel-default">
                            <div class="panel-heading">Curso</div>
                            <div class="panel-body">
                                <?php foreach ($curso as $row) :
                                    if ($lec->id_curso == $row->id_curso) {
                                        echo $row->nombre_curso;
                                    }
                                endforeach; ?>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="panel panel-default">
                            <div class="panel-heading">Título de la lección</div>
                            <div class="panel-body">
                                <?= $lec->titulo ?>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="panel panel-default">
                            <div class="panel-heading">Video de la lección</div>
                            <div class="panel-body">
                                <a href="<?= $lec->video ?>"><?= $lec->video ?></a>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="panel panel-default">
                            <div class="panel-heading">Contenido</div>
                            <div class="panel-body">
                                <?= $lec->contenido ?>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="panel panel-default">
                            <div class="panel-heading">Estado</div>
                            <div class="panel-body">
                                <?= $lec->status ?>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="panel panel-default">
                            <div class="panel-heading">Fecha inicial</div>
                            <div class="panel-body">
                               <?php
                                $fecha_original = $lec->fecha_inicial;
                                $fecha = new DateTime($fecha_original);
                                echo $fecha->format('d-m-Y h:i:s A'); 
                                 ?>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="panel panel-default">
                            <div class="panel-heading">Fecha máxima</div>
                            <div class="panel-body">
                               <?php
                                $fecha_original = $lec->fecha_disponible;
                                $fecha = new DateTime($fecha_original);
                                echo $fecha->format('d-m-Y h:i:s A'); 
                                 ?>
                            </div>
                        </div>
                    </div>
                    
                <?php $i++;
                endforeach; ?>
                <div class="form-group pull-right">
                    <a href="<?= base_url() ?>leccion" class="btn btn-sm btn-flat btn-primary">
                        <i class="fa fa-arrow-left"></i> Atras
                    </a>

                </div>
            </div>
        </div>
    </div>
</div>
<?= form_close(); ?>

