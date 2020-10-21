<?php
require_once '../app/View/login/check-login.php';
# Primeiro e ultimo dia do mes atual para as SQLs
$dateStartMonth = mktime(0, 0, 0, date('m'), 1, date('Y'));
$dateStartMonth = date('Y-m-d', $dateStartMonth);
$dateEndMonth   = mktime(23, 59, 59, date('m'), date("t"), date('Y'));
$dateEndMonth   = date('Y-m-d', $dateEndMonth);

/**
 * Contas a receber em aberto
 */
$queryCountReceivableOpen = " SELECT SUM(crp_valor) FROM tb_receber_pagar WHERE crp_tipo = 'R' AND crp_status = 'Aberto' AND crp_vencimento BETWEEN CAST(:firts_day_month AS DATE) AND CAST(:end_day_month AS DATE) ";
$countReceivableOpen = $connectionDataBase->prepare($queryCountReceivableOpen);
$countReceivableOpen->bindParam(':firts_day_month', $dateStartMonth);
$countReceivableOpen->bindParam(':end_day_month', $dateEndMonth);
$countReceivableOpen->execute();
$countReceivableOpen = $countReceivableOpen->fetchAll(\PDO::FETCH_ASSOC);

/**
 * Eventos Hoje
 */
$queryCountTodayEvents = " SELECT COUNT(even_codigo) FROM tb_eventos WHERE even_status = 'P' AND even_datahorai = NOW() ";
$countTodayEvents = $connectionDataBase->prepare($queryCountTodayEvents);
$countTodayEvents->execute();
$countTodayEvents = $countTodayEvents->fetchAll(\PDO::FETCH_ASSOC);

/**
 * Eventos Atrasados
 */
$queryCountDelayedEvents = " SELECT COUNT(even_codigo) FROM tb_eventos WHERE even_status = 'P' AND even_datahorai < NOW() ";
$countDelayedEvents = $connectionDataBase->prepare($queryCountDelayedEvents);
$countDelayedEvents->execute();
$countDelayedEvents = $countDelayedEvents->fetchAll(\PDO::FETCH_ASSOC);

/**
 * Armazenamento utilizado
 */
function formatBytes($bytes)
{
    $base = log($bytes, 1024);
    return round(pow(1024, $base - floor($base)));
}
// Sabendo o espaço livre em disco em GB
$freeSpace =  formatBytes(disk_total_space(".")) - formatBytes(disk_free_space("."));
//Encontrando o percentual 
$percentualSpaceUsed = ($freeSpace / formatBytes(disk_total_space("."))) * 100; //% estao sendo usados
//Arredondando
$percentualSpaceUsed = round($percentualSpaceUsed, 1);
?>

<?php $__env->startSection('title', 'Home'); ?>

<?php $__env->startSection('head'); ?>
<!-- Ionicons -->
<link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('css'); ?>
<style>
    .progress-bar-striped {
        background-image: none !important;
        background-color: #8b008b !important;
    }

    sup {
        top: .0em !important;
    }

    .view-warning {
        background-color: #ffc107 !important;
    }

    .view-danger {
        background-color: #b11800 !important;
    }

    .view-success {
        background-color: #28a745 !important;
    }

    .view-primary {
        background-color: #3BA4BF !important;
    }

    .icon-warning {
        color: #ffc107 !important;
    }
</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<h4>Contas a receber</h4>
<div class="row">
    <div class="col-lg-3 col-6">
        <div class="small-box bg-light">
            <div class="inner">
                <p>Contas a receber (hoje)</p>
                <h3><sup style="font-size: 20px">R$&nbsp;</sup> </h3>
            </div>
            <div class="icon"><i class="ion ion-stats-bars" style="color: #3BA4BF !important;"></i></div>
            <a href="#" class="small-box-footer view-primary" style="color: #fff !important;">Ver mais</a>
        </div>
    </div>
    <div class="col-lg-3 col-6">
        <div class="small-box bg-light">
            <div class="inner">
                <b><p>Contas a receber (mês)</p></b>
                <h3><sup style="font-size: 20px">R$&nbsp;</sup><?= number_format($countReceivableOpen[0]['SUM(crp_valor)'], 2, ',', '.'); ?></h3>
            </div>
            <div class="icon"><i class="ion ion-stats-bars icon-warning"></i></div>
            <a href="#" class="small-box-footer view-warning">Ver mais</a>
        </div>
    </div>

    <div class="col-lg-3 col-6">
        <div class="small-box bg-light">
            <div class="inner">
                <p>Contas recebidas (mês)</p>
                <h3><sup style="font-size: 20px">R$&nbsp;</sup></h3>
            </div>
            <div class="icon" style="color: #28a745 !important;">
                <i class="ion ion-stats-bars"></i>
            </div>
            <a href="#" class="small-box-footer view-success" style="color: #fff !important;">Ver mais</a>
        </div>
    </div>

    <div class="col-lg-3 col-6">
        <div class="small-box bg-light">
            <div class="inner">
                <p>Contas a receber (atrasadas)</p>
                <h3><sup style="font-size: 20px">R$&nbsp;</sup></h3>
            </div>
            <div class="icon" style="color: #b11800 !important;">
                <i class="ion ion-stats-bars"></i>
            </div>
            <a href="#" class="small-box-footer view-danger" style="color: #fff !important;">Ver mais</a>
        </div>
    </div>
</div>
<h4>Contas a pagar</h4>
<div class="row">

</div>
<h4>Outros</h4>
<div class="row">
    <div class="col-lg-3 col-6">
        <div class="small-box bg-light">
            <div class="inner">
                <p>Eventos hoje</p>
                <h3><?= $countTodayEvents[0]['COUNT(even_codigo)']; ?><sup style="font-size: 20px">&nbsp;eventos</sup></h3>
            </div>
            <div class="icon" style="color: #3BA4BF !important;">
                <i class="fas fa-calendar-day"></i>
            </div>
            <a href="/agenda/eventos" class="small-box-footer view-primary" style="color: #fff !important;">Ver eventos</a>
        </div>
    </div>
    <div class="col-lg-3 col-6">
        <div class="small-box bg-light">
            <div class="inner">
                <p>Eventos atrasados</p>
                <h3><?= $countDelayedEvents[0]['COUNT(even_codigo)']; ?><sup style="font-size: 20px">&nbsp;eventos</sup></h3>
            </div>
            <div class="icon" style="color: #b11800 !important;">
                <i class="fas fa-calendar-times"></i>
            </div>
            <a href="/agenda/eventos" class="small-box-footer view-danger" style="color: #fff !important;">Ver eventos</a>
        </div>
    </div>
    <div class="col-lg-3 col-6">
        <div class="small-box bg-light space-disk">
            <div class="inner">
                <p>Armazenamento utilizado</p>
                <h3><?= $percentualSpaceUsed ?><sup style="font-size: 20px">&nbsp;%</sup></h3>
                <div class="progress progress-xs">
                    <div class="progress-bar bg-lightsucess progress-bar-striped" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width:<?= $percentualSpaceUsed ?>%"></div>
                </div>
            </div>
            <div class="icon"><i class="ion" style="color: #8b008b !important;">
                    <ion-icon name="cloud-outline"></ion-icon>
                </i></div>
            <a href="malito:boraousar@gmail.com" class="small-box-footer view-purple" style="background-color: #8b008b !important; color: #fff !important;" target="_blank">Adquira mais espaço</a>
        </div>
    </div>

    <a href="/backup" class="btn btn-app"><i class="fas fa-download"></i>Backup</a>

    Saldo do mes??
    
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
<script src="https://unpkg.com/ionicons@5.1.2/dist/ionicons.js"></script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('templates.default', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\sys-ouse\app\View/home/home.blade.php ENDPATH**/ ?>