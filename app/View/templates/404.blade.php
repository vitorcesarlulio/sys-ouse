@extends('templates.default')

@section('title', '404 Página não encontrada')

@section('css')
<style>
</style>
@endsection
@section('content')
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
@endsection