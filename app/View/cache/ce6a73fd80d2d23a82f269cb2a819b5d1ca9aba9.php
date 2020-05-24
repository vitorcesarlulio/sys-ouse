

<?php $__env->startSection('description', 'sistema ouse'); ?>
<?php $__env->startSection('keywords', 'sistema, ousadia'); ?>

<?php $__env->startSection('title', 'Cadastro'); ?>

<?php $__env->startSection('content'); ?>
<div class="col-12">
    <!-- Default box -->
    <div class="card">
        <div class="card-header">
            <a href="cadastro.php">
                <button type="button" class="btn btn-primary btn-flat"><i class="fas fa-plus"></i></i></button> </a>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                    <i class="fas fa-minus"></i></button>
                <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
                    <i class="fas fa-times"></i></button>
            </div>
            <div class="card-body">
                <form role="form">
                    <div class="row">
                        <div class="col-sm-2">
                            <div class="form-group">
                                <label>Tipo de Cadastro:</label>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="radio1" onclick="Mudarestado('minhaDiv')">
                                    <label class="form-check-label">Completo | Basico</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group">
                                <label>Nome:</label>
                                <input type="text" class="form-control" placeholder="Enter ..." autofocus required data-error="Informe seu CPF">
                            </div>
                        </div>
                        <div class="col-sm-1">
                            <div class="form-group">
                                <label>Sobrenome:</label>
                                <input type="text" class="form-control" placeholder="Enter ...">
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group">
                                <label>Email:</label>
                                <input type="text" class="form-control" placeholder="Enter ...">
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group">
                                <label>Celular:</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-mobile"></i></span>
                                    </div>
                                    <input type="text" class="form-control" data-inputmask="&quot;mask&quot;: &quot;(99) 9999-99999&quot;" data-mask="" im-insert="true" value="19">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group">
                                <label>Telefone:</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                    </div>
                                    <input type="text" class="form-control" data-inputmask="&quot;mask&quot;: &quot;(99) 9999-9999&quot;" data-mask="" im-insert="true" value="19">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-1">
                            <div class="form-group">
                                <label>CEP:&nbsp;&nbsp;&nbsp;&nbsp;</label>
                                <a href="cadastro.php"> <i class="fas fa-arrow-circle-right"></i> </a>
                                <input type="text" class="form-control" id="cep" maxlength="9" placeholder="Enter ...">
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group">
                                <label>Logradouro:</label>
                                <input type="text" class="form-control" id="logradouro" placeholder="Enter ..." disabled>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group">
                                <label>Bairro:</label>
                                <input type="text" class="form-control" id="bairro" placeholder="Enter ..." disabled>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group">
                                <label>Cidade:</label>
                                <input type="text" class="form-control" id="localidade" placeholder="Enter ..." disabled>
                            </div>
                        </div>
                        <div class="col-sm-1">
                            <div class="form-group">
                                <label>Estado:</label>
                                <input type="text" class="form-control" id="uf" placeholder="Enter ..." disabled="">
                            </div>
                        </div>
                        <div class="col-sm-1">
                            <div class="form-group">
                                <label>Número:</label>
                                <input type="text" class="form-control" id="numero" placeholder="Enter ...">
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group">
                                <label>Complemento:</label>
                                <input type="text" class="form-control" placeholder="Enter ...">
                            </div>
                        </div>
                        <div class="col-sm-2" id="minhaDiv" style="display:none">
                            <div class="form-group">
                                <label>CNPJ:</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-address-card"></i></span>
                                    </div>
                                    <input type="text" class="form-control" data-inputmask="'mask': ['99.999.999/9999-99']" data-mask="" im-insert="true">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-2" id="minhaDiv" style="display:none">
                            <div class="form-group">
                                <label>CPF:</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-address-card"></i></span>
                                    </div>
                                    <input type="text" class="form-control" data-inputmask="'mask': ['999.999.999.99']" data-mask="" im-insert="true">
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-2">
                            <div class="form-group">
                                <label>Cadastro:</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                    </div>
                                    <input type="text" class="form-control" data-inputmask-alias="datetime" data-inputmask-inputformat="dd/mm/yyyy" data-mask="" im-insert="false" value="<?php echo e(date('d/m/Y')); ?>">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group">
                                <label>Teste</label>
                                <select class="form-control select2bs4 select2-hidden-accessible" disabled="" style="width: 100%;">
                                </select>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- /.card -->
        <div class="card-footer">
            <button type="submit" class="btn btn-primary btn-flat float-right">Submit</button>
        </div>
    </div>

</div>


<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>
<script src="<?= DIRJS . 'busca-cep.js' ?>"></script>

<script>
    function Mudarestado(el) {
        var display = document.getElementById(el).style.display;
        if (display == "none")
            document.getElementById(el).style.display = 'block';
        else
            document.getElementById(el).style.display = 'none';
    }
</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('templates.default', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Apache24\htdocs\sys-ouse\app\View/cadastro/cadastro2.blade.php ENDPATH**/ ?>