<?php 
include '../app/Model/connection-mysqli.php';

if(isset($_POST["id"]))
{
  $query = "DELETE FROM events where id = '".$_POST["id"]."'";
  if (mysqli_query($conn, $query)) 
  {
      echo 'Evento deletado';
  }
  
}

?>