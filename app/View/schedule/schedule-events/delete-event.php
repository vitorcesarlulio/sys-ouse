<?php 
include_once '../app/Model/connection-pdo.php';
include '../app/Model/connection-mysqli.php';

$id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);

if(isset($id))
{
  $query = "DELETE FROM tb_eventos where even_codigo = '".$id."'";
  if (mysqli_query($connectionDataBase, $query)) 
  {
      echo 'Evento deletado';
  }
}

?>