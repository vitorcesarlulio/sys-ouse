<?php
require_once '../app/View/login/check-login.php';

function formatBytes($bytes)
{
    $base = log($bytes, 1024);
    return round(pow(1024, $base - floor($base)));
}

$unidade = ".";
//Sabendo o espaço livre em disco em GB
$freeSpace =  formatBytes(disk_total_space($unidade)) - formatBytes(disk_free_space($unidade));

$percentualSpaceUsed = ($freeSpace / formatBytes(disk_total_space($unidade))) * 100;
$percentualSpaceUsed = round($percentualSpaceUsed, 0); //% estao sendo usados

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
        background-color: #FE5000 !important;
    }

    sup {
        top: .0em !important;
    }
</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-lg-3 col-6">
        <div class="small-box bg-info">
            <div class="inner">
                <p>Armazenamento utilizado</p>
                <h3><?= $percentualSpaceUsed ?><sup style="font-size: 20px">%</sup></h3>
                <div class="progress progress-xs">
                    <div class="progress-bar bg-sucess progress-bar-striped" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width:<?= $percentualSpaceUsed ?>%">
                    </div>
                </div>
            </div>
            <div class="icon">
                <i class="ion">
                    <ion-icon name="cloud-outline"></ion-icon>
                </i>
                <!-- <i class="far fa-hdd"></i> -->
            </div>
            <a href="malito:boraousar@gmail.com" class="small-box-footer" target="_blank">Adquira mais espaço</a>
        </div>
    </div>

    <div class="card-body">
        <a href="/backup" class="btn btn-app">
            <i class="fas fa-download"></i> Backup
        </a>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
<script src="https://unpkg.com/ionicons@5.1.2/dist/ionicons.js"></script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('templates.default', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\sys-ouse\app\View/home/home.blade.php ENDPATH**/ ?>