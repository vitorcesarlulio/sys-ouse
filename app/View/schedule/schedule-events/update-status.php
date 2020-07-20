<?php
include_once '../app/Model/connection-pdo.php';
include_once '../app/Model/connection-mysqli.php';
            
$id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);

$valueStatus = "R";
$valueCor ="#28A745";

$sql = "update tb_eventos set 
even_status = '$valueStatus',
even_cor = '$valueCor'
				where 
				even_codigo = '$id'";
								
mysqli_query($connectionDataBase, $sql) or die ("Erro na sql!") ;

header("Location: /agenda/eventos");