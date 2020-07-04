<?php
include_once '../app/Model/connection-pdo.php';
include_once '../app/Model/connection-mysqli.php';

//var que recebe os dados que o Js esta enviando                
$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
$valueStatus = "F";
$valueCor ="#28A745";

$sql = "update events set 
					status = '$valueStatus',
					cor = '$valueCor'
				where 
					id = '$id'";
								
mysqli_query($connectionDataBase, $sql) or die ("Erro na sql!") ;

header("Location: /agenda/eventos");