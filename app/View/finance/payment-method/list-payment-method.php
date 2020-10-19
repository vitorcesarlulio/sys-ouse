<?php
include_once '../app/Model/connection-mysqli.php';

$columns = [
    0 => 'tpg_codigo',
    1 => 'tpg_descricao',
    2 => 'tpg_parcelas',
    3 => 'tpg_observacao'
];

$query = " SELECT * FROM tb_tipo_pagamento WHERE ";

if (isset($_POST["search"]["value"])) {
    if (isset($_POST["search"]["value"])) {
        $query .= ' (
     tpg_codigo        LIKE "%' . $_POST["search"]["value"] . '%" 
     OR tpg_descricao  LIKE "%' . $_POST["search"]["value"] . '%" 
     OR tpg_parcelas   LIKE "%' . $_POST["search"]["value"] . '%"
     OR tpg_observacao LIKE "%' . $_POST["search"]["value"] . '%"  
     ) ';
    }
}

if (isset($_POST["order"])) {
    $query .= ' ORDER BY ' . $columns[$_POST['order']['0']['column']] . ' ' . $_POST['order']['0']['dir'] . ' ';
} else {
    $query .= ' ORDER BY tpg_codigo DESC ';
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
    $subArray[] = $row["tpg_codigo"];
    $subArray[] = $row["tpg_descricao"];
    $subArray[] = $row["tpg_parcelas"];
    $subArray[] = $row["tpg_observacao"];
    $subArray[] = '<div class="btn-group btn-group-sm">
                     <button type="button" name="deletePaymentMethod" class="btn btn-danger btn-delete-payment-method" id="deletePaymentMethod" onclick="confirmDeleteRecord(' . $row["tpg_codigo"] . ', `/financeiro/formas-de-pagamento/apagar`, `#listPaymentMethod`, `Sucesso: forma de pagamento deletada!`, `Erro: forma de pagamento não deletada!`);">
                     <i class="fas fa-trash"></i>
                     </button>
                  </div>';
    $data[]     = $subArray;
}

function getAllData($connectionDataBase)
{
    $query  = " SELECT * FROM tb_tipo_pagamento ";
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
