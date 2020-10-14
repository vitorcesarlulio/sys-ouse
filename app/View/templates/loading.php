<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="utf-8">
  <title>Sys Ouse | Carregando...</title>
  <link rel="stylesheet" href="<?= DIRCSS . 'loading.min.css' ?>">
</head>
<body>
  <div class='container'>
    <div class='loader'>
      <div class='loader--dot'></div>
      <div class='loader--dot'></div>
      <div class='loader--dot'></div>
      <div class='loader--dot'></div>
      <div class='loader--dot'></div>
      <div class='loader--dot'></div>
      <div class='loader--text'></div>
    </div>
  </div>
  <script>
    setTimeout(function() {
      window.location.href = '/home';
    }, 3100);
  </script>
</body>
</html>