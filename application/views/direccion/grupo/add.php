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
                <div class="my-4">
                    <div class="form-horizontal form-inline">
                        <a href="<?= base_url('grupo') ?>" class="btn btn-default btn-xs">
                            <i class="fa fa-arrow-left"></i> Cancelar
                        </a>
                        <div class="pull-right">
                            <span> Monto : </span><label for=""><?= $lote ?></label>
                        </div>
                    </div>
                </div>
                <?= form_open('grupo/save', array('id' => 'grupo'), array('mode' => 'add')) ?>
                <table id="form-table" class="table text-center table-condensed">
                    <thead>
                        <tr>
                            <th># No</th>
                            <th>Grupo</th>
                        </tr>
                    </thead>
                    <tbody id="inputs">
                    </tbody>
                </table>
                <button type="submit" class="mb-4 btn btn-block bg-purple btn-flat">
                    <i class="fa fa-save"></i> Guardar
                </button>
                <?= form_close() ?>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    var inputs = '';
    var lote = '<?= $lote; ?>';
</script>
<script src="<?= base_url() ?>assets/dist/js/app/master/grupo/add.js"></script>