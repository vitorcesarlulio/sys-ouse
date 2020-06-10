<?PHP
require_once("../app/Model/conexao2.php");

$name = $_REQUEST['name'];

$sql = "insert into tb_clientes (cli_nome) 
		values ('$name')";
	
mysqli_query($con, $sql) or die ("Erro na sql!");

//header("Location: /cadastro");
?>




<?php /**PATH C:\xampp\htdocs\sys-ouse\app\View/cadastro/cadastrar.blade.php ENDPATH**/ ?>