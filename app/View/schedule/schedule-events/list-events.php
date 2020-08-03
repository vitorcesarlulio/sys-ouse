<?php
include_once '../app/Model/connection-mysqli.php'; 

# Indice da coluna na tabela visualizar resultado => nome da coluna no banco de dados
$columns = [
   0 => 'even_titulo',
   1 => 'orca_nome',
   2 => 'even_datai',
   3 => 'even_horai',
   4 => 'even_horaf',
   5 => 'even_status'
];

# Query puxando os Eventos
$query =
"SELECT even_codigo, 
even_titulo, 
even_status, 
DATE_FORMAT(even_datahorai,'%d/%m/%Y') AS even_datai,
DATE_FORMAT(even_datahorai,'%H:%i') AS even_horai,
DATE_FORMAT(even_datahoraf,'%H:%i') AS even_horaf,

orca_nome, 
orca_sobrenome,

orca_cep

FROM tb_eventos e
INNER JOIN tb_orcamento o 
ON e.orca_numero = o.orca_numero WHERE ";

# Filtros
$dateStart = str_replace('/', '-',  $_POST['startDate']);
$convertDateStart = date("Y-m-d", strtotime($dateStart));

$dateEnd = str_replace('/', '-', $_POST['endDate']);
$convertDateEnd = date("Y-m-d", strtotime($dateEnd));

# Por Intervalo de Datas
if ($_POST['startDate'] != "" && $_POST['endDate'] =! "") {
$query .= ' even_datahorai BETWEEN "'.$convertDateStart.'" AND "'.$convertDateEnd.'" AND ';
}
# Por Status
if ($_POST['status'] != "") {
   $query .= 'even_status = "'.$_POST["status"].'" AND ';
}
# Por evento
if ($_POST['event'] != "") {
   $query .= 'even_titulo = "'.$_POST['event'].'" AND ';
}
#Por periodo
if ($_POST['period'] != "") {
   $today = date("Y-m-d");
   if ($_POST['period'] == "today") {
      $query .= 'even_datahorai LIKE "%'.$today.'%" AND ';
   }
   else if($_POST['period'] == "afterToday"){
      $query .= 'even_datahorai > NOW() AND ';
   }else{
      $query .= 'even_datahorai < NOW() AND ';
   }
}

# Filtros da caixa de pesquisa padrao do DataTable
if (isset($_POST["search"]["value"])) {
   $query .= ' (
    even_titulo                               LIKE "%' . $_POST["search"]["value"] . '%" 
    OR orca_nome                              LIKE "%' . $_POST["search"]["value"] . '%" 
    OR orca_sobrenome                         LIKE "%' . $_POST["search"]["value"] . '%"
    OR date_format(even_datahorai,"%d/%m/%Y") LIKE "%' . $_POST["search"]["value"] . '%" 
    OR date_format(even_datahorai,"%H:%i")    LIKE "%' . $_POST["search"]["value"] . '%" 
    OR date_format(even_datahoraf,"%H:%i")    LIKE "%' . $_POST["search"]["value"] . '%" 
    OR orca_cep                               LIKE "%' . $_POST["search"]["value"] . '%" 
    OR even_status                            LIKE "%' . $_POST["search"]["value"] . '%"  
    ) ';
}

if (isset($_POST["order"])) {
   $query .= ' ORDER BY ' . $columns[$_POST['order']['0']['column']] . ' ' . $_POST['order']['0']['dir'] . ' ';
   //$query .= 'ORDER BY ' . $columns[$_POST['order']['0']['column']] . ' DESC '; //SE DEIXAR ASSIM PRECISO DO CODIGO 
} else {
   $query .= ' ORDER BY even_codigo DESC ';
}

$query1 = '';
if ($_POST["length"] != -1) {
   $query1 = 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
}

$numberFilteredRow = mysqli_num_rows(mysqli_query($connectionDataBase, $query));
$result = mysqli_query($connectionDataBase, $query . $query1);

# Array que funciona como um if, verificando qual o status para trocar a cor
$checkStatus = [
   "P" => "Pendente",
   "R" => "Realizado"
];

# Array que funciona como um if, verificando qual o status para trocar a class com a cor referente
$checkStatusClass = [
   "P" => "badge badge-warning",
   "R" => "badge badge-success"
];

$data = [];
while ($row = mysqli_fetch_array($result)) {
   $sub_array = [];
   $sub_array[] = $row["even_titulo"];
   $sub_array[] = $row["orca_nome"] . " " . $row["orca_sobrenome"];
   $sub_array[] = $row["even_datai"];
   $sub_array[] = $row["even_horai"];
   $sub_array[] = $row["even_horaf"];
   $sub_array[] = '<a href="#" id="' . $row["even_codigo"] . '" class="span-update-status"><span class="' . $checkStatusClass[$row["even_status"]] . '">' . $checkStatus[$row["even_status"]] . '</span></a>';
   $sub_array[] = '<div class="btn-group btn-group-sm"><a href="#" class="btn btn-info btn-view-event" id="' . $row["even_codigo"] . '" name="viewEvent"><i class="fas fa-eye"></i></a><button type="button" name="deleteEvent" class="btn btn-danger btn-delete-event" id="' . $row["even_codigo"] . '"><i class="fas fa-trash"></i></button></div>';
   
   $data[] = $sub_array;
}

function getAllData($connectionDataBase){
   $query  = "SELECT * FROM tb_eventos";
   $result = mysqli_query($connectionDataBase, $query);
   return mysqli_num_rows($result);
}

$output = [
   "draw"            => intval($_POST["draw"]),
   "recordsTotal"    => getAllData($connectionDataBase),
   "recordsFiltered" => $numberFilteredRow,
   "data"            => $data
];

echo json_encode($output);
?>