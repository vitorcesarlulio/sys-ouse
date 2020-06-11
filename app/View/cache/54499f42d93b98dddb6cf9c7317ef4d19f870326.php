

<?php $__env->startSection('title', 'Eventos'); ?>

<?php $__env->startSection('head'); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('css'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card card-primary">
                <div class="card-header">
                    <h5 class="card-title">Monthly Recap Report</h5>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-tool" data-card-widget="remove">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
                <form role="form" id="quickForm" action="/cadastrar" novalidate="novalidate" autocomplete="off" method="post">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <label for="exampleInputNome1">Nome</label>
                                    <input type="text" name="name" class="form-control" id="exampleInputNome1" autofocus placeholder="Entre com o Nome">
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <label for="exampleInputSurname1">Sobrenome</label>
                                    <input type="text" name="surname" class="form-control" id="exampleInputSurname1" placeholder="Entre com o Sobrenome">
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="card-footer">
                    <button type="reset" class="btn btn-default" value="Limpar formulário"><i class="fas fa-times"></i></button>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-check"></i></button>
                </div>

            </div>
        </div>
    </div>

</div>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('script'); ?>


<?php $__env->stopSection(); ?>
<?php echo $__env->make('templates.default', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\sys-ouse\app\View/schedule/schedule-events/schedule-events.blade.php ENDPATH**/ ?>