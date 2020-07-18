<?php
include '../app/Model/connection-mysqli.php';

# Indice da coluna na tabela visualizar resultado => nome da coluna no banco de dados
$columns = [
   0 => 'even_titulo',
   1 => 'orca_nome',
   2 => 'even_datahorai',
   3 => 'even_status',
];

#para puxar a hora tem que mudar esse date fomrat
$query =
   "SELECT even_codigo, 
even_titulo, 
even_status, 
date_format(even_datahorai,'%d/%m/%Y') as even_datahorai,

orca_nome, 
orca_sobrenome

FROM tb_eventos e
INNER JOIN tb_orcamento o 
on e.orca_numero = o.orca_numero WHERE ";

/*
$dateStart = str_replace('/', '-', $_POST["start_date"]);
$convertDateStart = date("Y-m-d", strtotime($dateStart));

$dateEnd = str_replace('/', '-', $_POST["end_date"]);
$convertDateEnd = date("Y-m-d", strtotime($dateEnd));


if($_POST["is_date_search"] == "yes")
{
 $query .= 'even_datahorai BETWEEN "'.$convertDateStart.'" AND "'.$convertDateEnd.'" AND '; 
}

if ($_POST["is_date_search"] == "yes"){
 $query .= 'even_status = "'.$_POST["status"].'" AND '; 
} */

//$query .= 'even_status = "P" AND '; 

//converter data para padrao br se nao a consulta tem que ser em americano
if (isset($_POST["search"]["value"])) {
   $query .= ' (
    even_titulo                               LIKE "%' . $_POST["search"]["value"] . '%" 
    OR orca_nome                              LIKE "%' . $_POST["search"]["value"] . '%" 
    OR orca_sobrenome                         LIKE "%' . $_POST["search"]["value"] . '%" 
    OR even_status                            LIKE "%' . $_POST["search"]["value"] . '%" 
    OR date_format(even_datahorai,"%d/%m/%Y") LIKE "%' . $_POST["search"]["value"] . '%" 
    )';
}

if (isset($_POST["order"])) {
   $query .= 'ORDER BY '.$columns[$_POST['order']['0']['column']].' '.$_POST['order']['0']['dir'].' ';
   //$query .= 'ORDER BY ' . $columns[$_POST['order']['0']['column']] . ' DESC '; //SE DEIXAR ASSIM PRECIO DO CODIGO 
} else {
   $query .= 'ORDER BY even_codigo DESC';
}

$query1 = '';

if ($_POST["length"] != -1) {
   $query1 = 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
}

$number_filter_row = mysqli_num_rows(mysqli_query($connectionDataBase, $query));

$result = mysqli_query($connectionDataBase, $query . $query1);

$data = array();

$checkStatus = [
   "P" => "Pendente",
   "R" => "Realizado"
];

$checkStatusClass = [
   "P" => "badge badge-warning",
   "R" => "badge badge-success"
];

while ($row = mysqli_fetch_array($result)) {
   $sub_array = array();
   $sub_array[] = $row["even_titulo"];
   $sub_array[] = $row["orca_nome"] . " " . $row["orca_sobrenome"];
   $sub_array[] = $row["even_datahorai"];
   //<div class="classStatus" style="cursor: pointer;"> <span class="'.$checkStatusClass[$row["even_status"]].'">'.$checkStatus[$row["even_status"]].'</span> </div>
   //<button type="button" class="badge badge-warning">Pendente </button>
   $sub_array[] =  '<a href="/agenda/eventos/mudar-status?id=' . $row["even_codigo"] . '"><span class="' . $checkStatusClass[$row["even_status"]] . '">' . $checkStatus[$row["even_status"]] . '</span></a>';
   $sub_array[] = '<div class="btn-group btn-group-sm"><a href="/agenda/eventos/editar?id=' . $row["even_codigo"] . '" class="btn btn-warning" name="viewEvent"><i class="fas fa-edit"></i></a><a href="#" class="btn btn-info" id="' . $row["even_codigo"] . '" name="viewEvent"><i class="fas fa-eye"></i></a>  <button type="button" name="deleteEvent" class="btn btn-danger btn-excluir-evento" id="' . $row["even_codigo"] . '"><i class="fas fa-trash"></i></button>  </div>';
   $data[] = $sub_array;
}

function get_all_data($connectionDataBase)
{
   $query = "SELECT * FROM tb_eventos";
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
