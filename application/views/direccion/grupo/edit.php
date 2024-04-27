<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">Formulario <?= $titulo ?></h3>
        <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
            </button>
        </div>
    </div>
    <div class="box-body">
        <div class="row">
            <div class="col-sm-offset-3 col-sm-6 col-lg-offset-4 col-lg-4">
                <div class="my-2">
                    <div class="form-horizontal form-inline">
                        <a href="<?= base_url('grupo') ?>" class="btn btn-default btn-xs">
                            <i class="fa fa-arrow-left"></i> Cancelar
                        </a>
                        <div class="pull-right">
                            <span> Monto : </span><label for=""><?= count($grupo) ?></label>
                        </div>
                    </div>
                </div>
                <?= form_open('grupo/save', array('id' => 'grupo'), array('mode' => 'edit')) ?>
                <table id="form-table" class="table text-center table-condensed">


                    <thead>
                        <tr>
                            <th># No</th>
                            <th>Grupo</th>
                        </tr>
                    </thead>
                    <tbody>
                    

                        <?php
                        $no = 1;
                        
                        foreach ($grupo as $j) : ?>
                            <tr>
                                <td><?= $no ?></td>
                                <td>
                                    <div class="form-group">
                                        <?= form_hidden('id_grupo[' . $no . ']', $j->id_grupo) ?>
                                        <input autofocus="autofocus" onfocus="this.select()" autocomplete="off" value="<?= $j->nombre_grupo ?>" type="text" name="nombre_grupo[<?= $no ?>]" class="input-sm form-control">
                                        <small class="help-block text-right"></small>
                                    </div>
                                </td>
                            </tr>
                        <?php
                            $no++;
                        endforeach;
                        ?>

                    </tbody>

                </table>

                <div class="form-group">
                    
                    <label for="curso">Curso</label>
                    <select name="curso" id="curso" class="form-control select2" style="width: 100%!important">
                    

                        <option value="" disabled selected>Elegir Curso</option>
                        <?php 
                        foreach ($curso as $row) : ?>
                            <option <?= $grupo[0]->curso_id == $row->id_curso ? "selected" : "" ?> value="<?= $row->id_curso ?>"><?= $row->nombre_curso ?></option>
                        <?php  endforeach; ?>
                    </select>
                    <small class="help-block"></small>
                </div>
                <?php  //var_dump($grupo); ?>
                <button type="submit" class="mb-4 btn btn-block btn-flat bg-purple">
                    <i class="fa fa-save"></i> Guardar Cambios
                </button>
                <?= form_close() ?>
            </div>
        </div>
    </div>
</div>

<script src="<?= base_url() ?>assets/dist/js/app/master/grupo/edit.js"></script>
<script src="<?= base_url() ?>assets/dist/js/app/master/profesor/edit.js"></script>