<?php
	//Criar a conexao
	$connectionDataBase = mysqli_connect(HOST, USER, PASSWORD, DATABASE);
	
	if(!$connectionDataBase){
		die("Falha na conexao: " . mysqli_connect_error());
	}	
	
?>