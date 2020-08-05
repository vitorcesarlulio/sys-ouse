<?php
include_once '../app/Model/connection-mysqli.php';

$columns = [
   0 => 'usu_nome',
   1 => 'usu_sobrenome',
   2 => 'usu_login',
   3 => 'usu_data_cadastro'
];

$query = " SELECT usu_codigo, usu_login, DATE_FORMAT(usu_data_cadastro,'%d/%m/%Y') AS usu_data_cadastro,usu_nome, usu_sobrenome FROM tb_usuario WHERE ";

if (isset($_POST["search"]["value"])) {
   $query .= ' (usu_login LIKE "%' . $_POST["search"]["value"] . '%" OR usu_nome LIKE "%' . $_POST["search"]["value"] . '%" OR usu_sobrenome LIKE "%' . $_POST["search"]["value"] . '%" OR date_format(usu_data_cadastro,"%d/%m/%Y") LIKE "%' . $_POST["search"]["value"] . '%") ';
}

if (isset($_POST["order"])) {
   $query .= ' ORDER BY ' . $columns[$_POST['order']['0']['column']] . ' ' . $_POST['order']['0']['dir'] . ' ';
} else {
   $query .= ' ORDER BY usu_codigo DESC ';
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
   $subArray[] = $row["usu_nome"] . " " . $row["usu_sobrenome"];
   $subArray[] = $row["usu_login"];
   $subArray[] = $row["usu_data_cadastro"];
   $subArray[] = '<div class="btn-group btn-group-sm"><button type="button" name="editUser" class="btn btn-warning btn-edit-user" id="' . $row["usu_codigo"] . '"><i class="fas fa-edit"></i></button>     <button type="button" name="deleteUser" class="btn btn-danger btn-delete-user" id="' . $row["usu_codigo"] . '"><i class="fas fa-trash"></i></button></div>';
   $data[]     = $subArray;
}

function getAllData($connectionDataBase) 
{
   $query  = "SELECT * FROM tb_usuario";
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
