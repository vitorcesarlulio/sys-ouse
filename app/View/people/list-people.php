<?php
include_once '../app/Model/connection-mysqli.php';

$columns = [
   0 => 'pess_nome',
   1 => 'pess_cpfcnpj',
   2 => 'pess_classificacao',
   3 => 'pess_logradouro',
   4 => 'pess_cep',
   5 => 'pess_observacao'
];

 $query = " SELECT * FROM tb_pessoas WHERE ";

# Filtros
$dateStart = str_replace('/', '-',  $_POST['startDate']);
$convertDateStart = date("Y-m-d", strtotime($dateStart));

$dateEnd = str_replace('/', '-', $_POST['endDate']);
$convertDateEnd = date("Y-m-d", strtotime($dateEnd));

# Por Intervalo de Datas
if ($_POST['startDate'] != "" && $_POST['endDate'] =! "") {
$query .= ' pess_data_cadastro BETWEEN "'.$convertDateStart.'" AND "'.$convertDateEnd.'" AND ';
}



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

$classificationPeople = [
   "C" => "Cliente",
   "F" => "Fornecedor"
];

$data = [];
while ($row = mysqli_fetch_array($result)) {
   $subArray   = [];
   $subArray[] = $row["pess_nome"] . " " . $row["pess_sobrenome"] . " " . $row["pess_razao_social"];
   $subArray[] = $row["pess_cpfcnpj"];
   $subArray[] = $classificationPeople[$row["pess_classificacao"]];;
   $subArray[] = $row["pess_logradouro"] . ", " . $row["pess_log_numero"] . " - " . $row["pess_bairro"];
   $subArray[] = $row["pess_cidade"]. ", " . $row["pess_estado"];
   $subArray[] = $row["pess_cep"];
   $subArray[] = '
   <div class="btn-group btn-group-sm">
      <button type="button" name="editPeople" class="btn btn-warning btn-edit-people" id="' . $row["pess_codigo"] . '"><i class="fas fa-edit"></i></button>     
      <button type="button" name="deletePeople" class="btn btn-danger btn-delete-people" id="deletePeople" onclick="confirmDeleteRecord(' . $row["pess_codigo"] . ', `/pessoas/apagar`, `#listPeople`, `Sucesso: pessoa e seus contatos apagados!`, `Erro: pessoa e seus contatos não apagada!`);">
         <i class="fas fa-trash"></i>
      </button>
   </div>';
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
