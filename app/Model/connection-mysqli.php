<?php
	//Criar a conexao
	$connectionDataBase = mysqli_connect(HOST, USER, PASSWORD, DATABASE);
	
	if(!$connectionDataBase){
		die("Falha na conexao: " . mysqli_connect_error());
	}else{
		//echo '<div id="toast-container" class="toast-top-right"><div class="toast toast-success" aria-live="polite" style=""><div class="toast-message">Evento apagado com sucesso!</div></div></div>';
	}	
	
?>