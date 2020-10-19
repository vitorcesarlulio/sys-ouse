<?php
include_once '../app/Model/connection-mysqli.php';

$columns = [
   0 => 'usu_nome',
   1 => 'usu_sobrenome',
   2 => 'usu_login',
   3 => 'usu_permissoes',
   4 => 'usu_status',
   5 => 'usu_data_cadastro'
];

$query = " SELECT usu_codigo, usu_login, DATE_FORMAT(usu_data_cadastro,'%d/%m/%Y %H:%i') AS usu_data_cadastro, usu_nome, usu_sobrenome, usu_permissoes, usu_status FROM tb_usuarios WHERE ";


# Filtros
$dateStart = str_replace('/', '-',  $_POST['startDate']);
$convertDateStart = date("Y-m-d", strtotime($dateStart));

$dateEnd = str_replace('/', '-', $_POST['endDate']);
$convertDateEnd = date("Y-m-d", strtotime($dateEnd));

# Por Intervalo de Datas
if ($_POST['startDate'] != "" && $_POST['endDate'] =! "") {
$query .= ' usu_data_cadastro BETWEEN "'.$convertDateStart.'" AND "'.$convertDateEnd.'" AND ';
}
# Por Status
if ($_POST['statusUser'] != "") {
   $query .= 'usu_status = "'.$_POST["statusUser"].'" AND ';
} 
# Por Nivel de Acesso
if ($_POST['accessLevel'] != "") {
   $query .= 'usu_permissoes = "'.$_POST['accessLevel'].'" AND ';
}

if ($_POST['filterLogin'] != "") {
   $query .= 'usu_codigo = "'.$_POST['filterLogin'].'" AND ';
}


if (isset($_POST["search"]["value"])) {
   $query .= ' (usu_login LIKE "%' . $_POST["search"]["value"] . '%" OR usu_nome LIKE "%' . $_POST["search"]["value"] . '%" OR usu_sobrenome LIKE "%' . $_POST["search"]["value"] . '%" OR usu_permissoes LIKE "%' . $_POST["search"]["value"] . '%" OR date_format(usu_data_cadastro,"%d/%m/%Y") LIKE "%' . $_POST["search"]["value"] . '%" ) ';
}

if (isset($_POST["order"])) {
   $query .= ' ORDER BY ' . $columns[$_POST['order']['0']['column']] . ' ' . $_POST['order']['0']['dir'] . ' ';
} else {
   $query .= ' ORDER BY usu_codigo DESC ';
}

$query1 = '';
if ($_POST["length"] != -1) {
   $query1 = ' LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
}

$numberFilteredRow = mysqli_num_rows(mysqli_query($connectionDataBase, $query));
$result = mysqli_query($connectionDataBase, $query . $query1);

$permitionUser = [
   "admin" => "Administrador",
   "user" => "Usuário"
];

$statusUser = [
   "A" => "Ativo",
   "I" => "Inativo"
];

$data = [];
while ($row = mysqli_fetch_array($result)) {
   $subArray   = [];
   $subArray[] = $row["usu_nome"] . " " . $row["usu_sobrenome"];
   $subArray[] = $row["usu_login"];
   $subArray[] = $permitionUser[$row["usu_permissoes"]];
   $subArray[] = $statusUser[$row["usu_status"]];
   $subArray[] = $row["usu_data_cadastro"];
   $subArray[] = '
   <div class="btn-group btn-group-sm">
      <button type="button" name="editUser" class="btn btn-warning btn-edit-user" id="' . $row["usu_codigo"] . '">
         <i class="fas fa-edit"></i>
      </button>    
      <button type="button" name="deleteUser" class="btn btn-danger btn-delete-user" id="deleteUser" onclick="confirmDeleteRecord(' . $row["usu_codigo"] . ', `/usuarios/apagar`, `#listUsers`, `Sucesso: usuário apagado!`, `Erro: usuário não apagado!`);">
         <i class="fas fa-trash"></i>
      </button>
   </div>';
   $data[]     = $subArray;
}

function getAllData($connectionDataBase) 
{
   $query  = " SELECT * FROM tb_usuarios ";
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
