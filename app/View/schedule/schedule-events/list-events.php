<?php
include '../app/Model/connection-mysqli.php';

//Receber a requisão da pesquisa 

//Indice da coluna na tabela visualizar resultado => nome da coluna no banco de dados
$columns = array(
    0 => 'id',
    1 => 'title',
    2 => 'cor',
    3 => 'start',
    4 => 'end',
);

//para puxar a hora tem que mudar esse date fomrat
$query = "SELECT *, date_format(start,'%d/%m/%Y') as start, date_format(end,'%d/%m/%Y') as end FROM events WHERE ";

$dateStart = str_replace('/', '-', $_POST["start_date"]);
$convertDateStart = date("Y-m-d", strtotime($dateStart));

$dateEnd = str_replace('/', '-', $_POST["end_date"]);
$convertDateEnd = date("Y-m-d", strtotime($dateEnd));

if($_POST["is_date_search"] == "yes")
{
 $query .= 'start BETWEEN "'.$convertDateStart.'" AND "'.$convertDateEnd.'" AND '; 
}

if ($_POST["is_date_search"] == "yes"){
 $query .= 'status = "'.$_POST["status"].'" AND '; 
}

//converter data para padrao br se nao a consulta tem que ser em americano
if(isset($_POST["search"]["value"])){
 $query .= ' (
    id       LIKE "%'.$_POST["search"]["value"].'%" 
    OR title LIKE "%'.$_POST["search"]["value"].'%" 
    OR cor   LIKE "%'.$_POST["search"]["value"].'%" 
    OR start LIKE "%'.$_POST["search"]["value"].'%"  
    OR end   LIKE "%'.$_POST["search"]["value"].'%" )';
}

if(isset($_POST["order"])){
 $query .= 'ORDER BY '.$columns[$_POST['order']['0']['column']].' '.$_POST['order']['0']['dir'].' ';
 //$query .= 'ORDER BY '.$columns[$_POST['order']['0']['column']].' desc ';
}
else {
 $query .= 'ORDER BY id DESC';
}

$query1 = '';

if($_POST["length"] != -1)
{
 $query1 = 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
}

$number_filter_row = mysqli_num_rows(mysqli_query($connectionDataBase, $query));

$result = mysqli_query($connectionDataBase, $query . $query1);

$data = array();

while($row = mysqli_fetch_array($result))
{
 $sub_array = array();
 $sub_array[] = $row["id"];
 $sub_array[] = $row["title"];
 $sub_array[] = $row["cor"];
 $sub_array[] = $row["start"];
 $sub_array[] = $row["end"];
 $sub_array[] = '<a href="/agenda/eventos/mudar-status?id='.$row["id"].'"><span class=<?php if ($row["status"] == "A") {echo "badge badge-warning";} ?>>A fazer</span></a>';
 $sub_array[] = '<div class="btn-group btn-group-sm"><a href="/agenda/eventos/editar?id='.$row["id"].'" class="btn btn-warning" name="viewEvent"><i class="fas fa-edit"></i></a><a href="#" class="btn btn-info" id="'.$row["id"].'" name="viewEvent"><i class="fas fa-eye"></i></a><button type="button" name="deleteEvent" class="btn btn-danger" id="'.$row["id"].'"><i class="fas fa-trash"></i></button></div>';
 $data[] = $sub_array;
}

function get_all_data($connectionDataBase)
{
 $query = "SELECT * FROM events";
 $result = mysqli_query($connectionDataBase, $query);
 return mysqli_num_rows($result);
}

$output = array(
 "draw"    => intval($_POST["draw"]),
 "recordsTotal"  =>  get_all_data($connectionDataBase),
 "recordsFiltered" => $number_filter_row,
 "data"    => $data
);

echo json_encode($output);

?>

