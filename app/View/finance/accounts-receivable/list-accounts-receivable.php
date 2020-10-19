<?php
include_once '../app/Model/connection-mysqli.php';

$columns = [
    0 => 'crp_numero',
    1 => 'pess_nome',
    2 => 'tpg_descricao',
    3 => 'crp_parcela',
    4 => 'crp_valor',
    5 => 'crp_emissao',
    6 => 'crp_vencimento',
    7 => 'crp_status',
    8 => 'crp_classificacao',
];

$query = " SELECT 
crp_numero,
crp_parcela,
crp_valor,
DATE_FORMAT(crp_emissao,'%d/%m/%Y') AS crp_emissao,
DATE_FORMAT(crp_vencimento,'%d/%m/%Y') AS crp_vencimento,
crp_status,
crp_classificacao,

pess_nome,
pess_sobrenome,
pess_nome_fantasia,

tpg_descricao

FROM tb_receber_pagar crp

INNER JOIN tb_pessoas pess 
ON crp.pess_codigo = pess.pess_codigo 

INNER JOIN tb_tipo_pagamento tpg 
ON crp.tpg_codigo = tpg.tpg_codigo 
WHERE ";

if (isset($_POST["search"]["value"])) {
    if (isset($_POST["search"]["value"])) {
        $query .= ' (
     pess_nome          LIKE "%' . $_POST["search"]["value"] . '%" 
     OR pess_sobrenome  LIKE "%' . $_POST["search"]["value"] . '%"  
     OR pess_nome_fantasia  LIKE "%' . $_POST["search"]["value"] . '%"  
     OR tpg_descricao  LIKE "%' . $_POST["search"]["value"] . '%"  
     OR crp_valor  LIKE "%' . $_POST["search"]["value"] . '%"  
     OR crp_emissao  LIKE "%' . $_POST["search"]["value"] . '%"  
     OR crp_vencimento  LIKE "%' . $_POST["search"]["value"] . '%"  
     OR crp_status  LIKE "%' . $_POST["search"]["value"] . '%"  
     OR crp_classificacao  LIKE "%' . $_POST["search"]["value"] . '%"  
     ) ';
    }
}

if (isset($_POST["order"])) {
    $query .= ' ORDER BY ' . $columns[$_POST['order']['0']['column']] . ' ' . $_POST['order']['0']['dir'] . ' ';
} else {
    $query .= ' ORDER BY crp_numero DESC ';
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
    $subArray[] = $row["crp_numero"];
    $subArray[] = $row["pess_nome"] . " " . $row["pess_sobrenome"] . " " . $row["pess_nome_fantasia"];
    $subArray[] = $row["tpg_descricao"];
    $subArray[] = $row["crp_parcela"];
    $subArray[] = "R$ " . number_format($row["crp_valor"], 2, ',', '.');
    $subArray[] = $row["crp_emissao"];
    $subArray[] = $row["crp_vencimento"];
    $subArray[] = $row["crp_status"];
    $subArray[] = $row["crp_classificacao"];
    $subArray[] = '<div class="btn-group btn-group-sm">
                     <button type="button" name="deletePaymentMethod" class="btn btn-danger btn-delete-payment-method" id="deletePaymentMethod" onclick="confirmDeleteRecord(' . $row["crp_numero"] . ', `/financeiro/formas-de-pagamento/apagar`, `#listPaymentMethod`, `Sucesso: forma de pagamento deletada!`, `Erro: forma de pagamento não deletada!`);">
                     <i class="fas fa-trash"></i>
                     </button>
                  </div>';
    $data[]     = $subArray;
}

function getAllData($connectionDataBase)
{
    $query  = " SELECT * FROM tb_receber_pagar ";
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
