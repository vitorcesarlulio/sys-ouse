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


/* $dateEnd = str_replace('/', '-', $_POST['endDate']);
$convertDateEnd = date("Y-m-d", strtotime($dateEnd)); */
# Por Intervalo de Datas
if ($_POST['startDateExpiry'] !== "" && $_POST['endDateExpiry'] !== "") {
    $query .= ' crp_vencimento BETWEEN CAST("'.$_POST['startDateExpiry'].'" AS DATE) AND CAST("'.$_POST['endDateExpiry'].'" AS DATE) AND';
}

if ($_POST['startDateIssue'] !== "" && $_POST['endDateIssue'] !== "") {
    $query .= ' crp_emissao BETWEEN CAST("'.$_POST['startDateIssue'].'" AS DATE) AND CAST("'.$_POST['endDateIssue'].'" AS DATE) AND';
}

if (isset($_POST["search"]["value"])) {
    if (isset($_POST["search"]["value"])) {
        $query .= ' (
     pess_nome          LIKE "%' . $_POST["search"]["value"] . '%" 
     OR pess_sobrenome  LIKE "%' . $_POST["search"]["value"] . '%"  
     OR pess_nome_fantasia  LIKE "%' . $_POST["search"]["value"] . '%"  
     OR tpg_descricao  LIKE "%' . $_POST["search"]["value"] . '%"  
     OR crp_valor  LIKE "%' . $_POST["search"]["value"] . '%"  
     OR date_format(crp_emissao,"%d/%m/%Y")  LIKE "%' . $_POST["search"]["value"] . '%"  
     OR date_format(crp_vencimento,"%d/%m/%Y")  LIKE "%' . $_POST["search"]["value"] . '%"  
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

$total_order = 0;

$statusClass = [
    "Aberto" => '<span class="badge badge-danger">ABERTO</span>',
    "Pago" => '<span class="badge badge-success">PAGO</span>'
];

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
    $subArray[] =$statusClass[$row["crp_status"]];
    $subArray[] = $row["crp_classificacao"];
    $subArray[] = '<div class="btn-group btn-group-sm">
                     <button type="button" name="viewPaymentMethod" class="btn btn-primary btn-view-payment-method" id="viewPaymentMethod" onclick="viewPaymentMethod(' . $row["crp_numero"] . ');">
                        <i class="fas fa-eye"></i>
                     </button>

                     <button type="button" name="updatePaymentMethod" class="btn btn-warning btn-update-payment-method" id="updatePaymentMethod" onclick="updatePaymentMethod('.$row["crp_numero"] . ');">
                        <i class="fas fa-edit"></i>
                     </button>

                     <button type="button" name="deletePaymentMethod" class="btn btn-danger btn-delete-payment-method" id="deletePaymentMethod" onclick="confirmDeleteRecord(' . $row["crp_numero"] . ', `/financeiro/formas-de-pagamento/apagar`, `#listPaymentMethod`, `Sucesso: forma de pagamento deletada!`, `Erro: forma de pagamento não deletada!`);">
                        <i class="fas fa-trash"></i>
                     </button>
                  </div>';
    $total_order = $total_order + floatval($row["crp_valor"]);
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
    "data"            => $data,
    'total'    => number_format($total_order, 2)
];

echo json_encode($output);
