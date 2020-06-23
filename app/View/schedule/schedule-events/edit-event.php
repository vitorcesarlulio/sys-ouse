<?php
session_start();

include_once '../app/Model/connection-pdo.php';
include_once '../app/Model/connection-mysqli.php';

//var que recebe os dados que o Js esta enviando                
$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

$sql = "select *, date_format(start,'%d/%m/%Y') as data  
		from events 
		where id = '$id'";
		
$sql = mysqli_query($conn, $sql) or die ("Erro na sql!") ;

$dados = mysqli_fetch_array($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<form name="frm_cliente" action="atualizar_cliente.php" method="post">
<div id="principal">
  <h1> Atualizar Clientes </h1>

    <label> Código </label>
    <input name="txt_codigo" type="text" class="input_01" value="<?php echo $dados['id']; ?>">

    <label> Nome </label>
    <input name="txt_nome" type="text" class="input_01" value="<?php echo $dados['start']; ?>">
    <label> Nome </label>
    <input name="txt_nome" type="text" class="input_01" value="<?php echo $dados['end']; ?>">
    
    <input name="btn_enviar" type="submit" value="Enviar" class="btn">
</div>
</form>
</body>
</html>