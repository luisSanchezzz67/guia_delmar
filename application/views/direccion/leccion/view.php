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
                            <div class="panel-heading">Profesor</div>
                            <div class="panel-body">
                                <?= $profesor->nombre_profesor ?>
                            </div>
                        </div>
                    </div>
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

                                // Crear un arreglo con los nombres de los meses en español
                                $meses = [
                                    1 => 'enero', 2 => 'febrero', 3 => 'marzo', 4 => 'abril',
                                    5 => 'mayo', 6 => 'junio', 7 => 'julio', 8 => 'agosto',
                                    9 => 'septiembre', 10 => 'octubre', 11 => 'noviembre', 12 => 'diciembre'
                                ];

                                // Formatear la fecha según el formato español "8 de mayo del 2024"
                                $dia = $fecha->format('j'); // Día sin ceros iniciales
                                $mes = $meses[(int)$fecha->format('n')]; // Mes en español
                                $year = $fecha->format('Y'); // Año
                                $hora = $fecha->format('H:i'); // Hora y minutos en formato 24 horas

                                echo $dia . " de " . $mes . " del " . $year . " a las " . $hora;
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

                                // Crear un arreglo con los nombres de los meses en español
                                $meses = [
                                    1 => 'enero', 2 => 'febrero', 3 => 'marzo', 4 => 'abril',
                                    5 => 'mayo', 6 => 'junio', 7 => 'julio', 8 => 'agosto',
                                    9 => 'septiembre', 10 => 'octubre', 11 => 'noviembre', 12 => 'diciembre'
                                ];

                                // Formatear la fecha según el formato español "8 de mayo del 2024"
                                $dia = $fecha->format('j'); // Día sin ceros iniciales
                                $mes = $meses[(int)$fecha->format('n')]; // Mes en español
                                $year = $fecha->format('Y'); // Año
                                $hora = $fecha->format('H:i'); // Hora y minutos en formato 24 horas

                                echo $dia . " de " . $mes . " del " . $year . " a las " . $hora;
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