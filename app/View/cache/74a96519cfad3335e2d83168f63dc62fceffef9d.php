<?php $__env->startSection('title', '404 Página não encontrada'); ?>

<?php $__env->startSection('css'); ?>
<style>
</style>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="error-page">
  <h2 class="headline text-warning"> 404</h2>
  <div class="error-content">
    <h3><i class="fas fa-exclamation-triangle text-warning"></i> Oops! Página não encontrada.</h3>
    <p>
      Não foi possível encontrar a página que você estava procurando. Enquanto isso, você pode
      <a href="/home">retornar ao painel</a> ou contate o Administrador do Sistema.
    </p>
  </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('templates.default', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/sys-ouse/app/View/templates/404.blade.php ENDPATH**/ ?>