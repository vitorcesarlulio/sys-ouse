<?php
include_once '../app/Model/connection-mysqli.php';

$columns = [
   0 => 'orca_nome',
   1 => 'orca_sobrenome'
];

$query = " SELECT orca_numero, orca_nome, orca_sobrenome FROM tb_orcamento WHERE ";

if (isset($_POST["search"]["value"])) {
   $query .= ' (orca_nome LIKE "%' . $_POST["search"]["value"] . '%" OR orca_sobrenome LIKE "%' . $_POST["search"]["value"] . '%") ';
} 

if (isset($_POST["order"])) {
   $query .= ' ORDER BY ' . $columns[$_POST['order']['0']['column']] . ' ' . $_POST['order']['0']['dir'] . ' ';
} else {
   $query .= ' ORDER BY orca_numero DESC ';
}

$query1 = '';
if ($_POST["length"] != -1) {
   $query1 = 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
}

$numberFilteredRow = mysqli_num_rows(mysqli_query($connectionDataBase, $query));
$result = mysqli_query($connectionDataBase, $query . $query1);

$data = [];
while ($row = mysqli_fetch_array($result)) {
   $subArray   = [];
   $subArray[] = $row["orca_nome"] . " " . $row["orca_sobrenome"];
   $subArray[] = '<div class="btn-group btn-group-sm"><a href="/orcamentos/editar?budget=' . $row["orca_numero"] . '" class="btn btn-warning btn-edit-budget"><i class="fas fa-edit"></i></a><button type="button" name="deleteBudget" class="btn btn-danger btn-delete-budget" id="' . $row["orca_numero"] . '"><i class="fas fa-trash"></i></button></div>';
   $data[]     = $subArray;
}

function getAllData($connectionDataBase) 
{
   $query  = " SELECT * FROM tb_orcamento ";
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
