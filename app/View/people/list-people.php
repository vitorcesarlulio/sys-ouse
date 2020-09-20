<?php
include_once '../app/Model/connection-mysqli.php';

$columns = [
   0 => 'pess_tipo',
   1 => 'pess_nome',
   2 => 'pess_sobrenome',
   3 => 'pess_cidade',
   4 => 'pess_cpfcnpj',
   5 => 'pess_logradouro'
];

 $query = " SELECT * FROM tb_pessoas WHERE ";



if (isset($_POST["search"]["value"])) {
   $query .= ' (pess_tipo LIKE "%' . $_POST["search"]["value"] . '%" OR pess_nome LIKE "%' . $_POST["search"]["value"] . '%" OR pess_sobrenome LIKE "%' . $_POST["search"]["value"] . '%" OR pess_logradouro LIKE "%' . $_POST["search"]["value"] . '%" OR pess_cidade LIKE "%' . $_POST["search"]["value"] . '%" ) ';
}

if (isset($_POST["order"])) {
   $query .= ' ORDER BY ' . $columns[$_POST['order']['0']['column']] . ' ' . $_POST['order']['0']['dir'] . ' ';
} else {
   $query .= ' ORDER BY pess_codigo DESC ';
}

$query1 = '';
if ($_POST["length"] != -1) {
   $query1 = ' LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
}

$numberFilteredRow = mysqli_num_rows(mysqli_query($connectionDataBase, $query));
$result = mysqli_query($connectionDataBase, $query . $query1);

$data = [];
while ($row = mysqli_fetch_array($result)) {
   $subArray   = [];
   $subArray[] = $row["pess_tipo"];
   $subArray[] = $row["pess_nome"] . " " . $row["pess_sobrenome"];
   $subArray[] = $row["pess_cidade"];
   $subArray[] = $row["pess_cpfcnpj"];
   $subArray[] = $row["pess_logradouro"];
   $subArray[] = '<div class="btn-group btn-group-sm"><button type="button" name="editPeople" class="btn btn-warning btn-edit-people" id="' . $row["pess_codigo"] . '"><i class="fas fa-edit"></i></button>     <button type="button" name="deletePeople" class="btn btn-danger btn-delete-people" id="' . $row["pess_codigo"] . '"><i class="fas fa-trash"></i></button></div>';
   $data[]     = $subArray;
}

function getAllData($connectionDataBase) 
{
   $query  = " SELECT * FROM tb_pessoas ";
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
