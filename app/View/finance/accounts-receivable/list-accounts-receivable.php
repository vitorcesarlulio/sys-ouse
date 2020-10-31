<?php
include_once '../app/Model/connection-mysqli.php';

$columns = [
    0 => 'orca_numero',
    1 => 'crp_numero',
    2 => 'pess_nome',
    3 => 'tpg_descricao',
    4 => 'crp_parcela',
    5 => 'crp_valor',
    6 => 'crp_emissao',
    7 => 'crp_vencimento',
    8 => 'crp_datapagto',
    9 => 'cat_descricao',
    10 => 'crp_status'
];

$query = " SELECT 
crp_numero,
orca_numero,
crp_parcela,
crp_valor,
DATE_FORMAT(crp_emissao,'%d/%m/%Y') AS crp_emissao,
DATE_FORMAT(crp_vencimento,'%d/%m/%Y') AS crp_vencimento,
DATE_FORMAT(crp_datapagto,'%d/%m/%Y') AS crp_datapagto,
crp_status,

pess_nome,
pess_sobrenome,
pess_razao_social,

tpg_descricao,

cat_descricao

FROM tb_receber_pagar crp

INNER JOIN tb_pessoas pess 
ON crp.pess_codigo = pess.pess_codigo 

INNER JOIN tb_tipo_pagamento tpg 
ON crp.tpg_codigo = tpg.tpg_codigo 

INNER JOIN tb_categoria cat 
ON crp.cat_codigo = cat.cat_codigo 

WHERE crp_tipo = 'R' AND ";

# Data de hoje 
$now = date('Y-m-d');
$today = new DateTime('now');

# Data de vencimento
if (isset($_POST['filterExpirationDate']) && !empty($_POST['filterExpirationDate'])) {
    $query .= ' crp_vencimento BETWEEN CAST("' . $_POST['filterStartDate'] . '" AS DATE) AND CAST("' . $_POST['filterEndDate'] . '" AS DATE) AND';
}

# Data de emissão 
if (isset($_POST['filterDateIssue']) && !empty($_POST['filterDateIssue'])) {
    $query .= ' crp_emissao BETWEEN CAST("' . $_POST['filterStartDate'] . '" AS DATE) AND CAST("' . $_POST['filterEndDate'] . '" AS DATE) AND';
}

# Data de pagamento 
if (isset($_POST['filterPayday']) && !empty($_POST['filterPayday'])) {
    $query .= ' crp_datapagto BETWEEN CAST("' . $_POST['filterStartDate'] . '" AS DATE) AND CAST("' . $_POST['filterEndDate'] . '" AS DATE) AND';
}

# Contas proximas ao vencimento -- ATENÇAO
if (isset($_POST['dateExperyNext']) && !empty($_POST['dateExperyNext'])) {
    $query .= ' crp_vencimento BETWEEN CAST("' . $now . '" AS DATE) AND CAST("' . $today->modify("+ 7 days")->format("Y-m-d") . '" AS DATE) AND crp_status != "PAGO" AND ';
}

# Contas vencidas -- ATENÇAO
if (isset($_POST['overdueAccounts']) && !empty($_POST['overdueAccounts'])) {
    $query .= ' crp_vencimento < "' . $now . '" AND crp_status != "PAGO" AND '; // crp_status = "A" AND
}

# Forma de Pagto
if (isset($_POST['filterAccountPayment']) && !empty($_POST['filterAccountPayment'])) {
    $query .= ' crp.tpg_codigo = "' . $_POST["filterAccountPayment"] . '" AND ';
}

# Status
if (isset($_POST['statusFilter']) && !empty($_POST['statusFilter'])) {
    $query .= ' crp_status = "' . $_POST["statusFilter"] . '" AND ';
}

# Categoria
if (isset($_POST['filterCategory']) && !empty($_POST['filterCategory'])) {
    $query .= ' crp.cat_codigo = "' . $_POST["filterCategory"] . '" AND ';
}

if (isset($_POST["search"]["value"])) {
    if (isset($_POST["search"]["value"])) {
        $query .= ' (
     pess_nome          LIKE "%' . $_POST["search"]["value"] . '%" 
     OR pess_sobrenome  LIKE "%' . $_POST["search"]["value"] . '%"  
     OR pess_razao_social  LIKE "%' . $_POST["search"]["value"] . '%"  
     OR tpg_descricao  LIKE "%' . $_POST["search"]["value"] . '%"  
     OR crp_valor  LIKE "%' . $_POST["search"]["value"] . '%"  
     OR date_format(crp_emissao,"%d/%m/%Y")  LIKE "%' . $_POST["search"]["value"] . '%"  
     OR date_format(crp_vencimento,"%d/%m/%Y")  LIKE "%' . $_POST["search"]["value"] . '%"  
     OR crp_status  LIKE "%' . $_POST["search"]["value"] . '%"  
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
    "ABERTO"     => '<span class="badge badge-warning badge-open">ABERTO</span>',
    "PAGO"       => '<span class="badge badge-success badge-pay">PAGO</span>',
    "CANCELADO"  => '<span class="badge badge-danger badge-pay">CANCELADO</span>',
    "NEGOCIADO"  => '<span class="badge badge-negotiated">NEGOCIADO</span>',
    "PROTESTADO" => '<span class="badge badge-protested">PROTESTADO</span>'
];

$data = [];
while ($row = mysqli_fetch_array($result)) {
    $subArray   = [];
    $subArray[] = $row["orca_numero"];
    $subArray[] = $row["crp_numero"];
    $subArray[] = $row["pess_nome"] . " " . $row["pess_sobrenome"] . " " . $row["pess_razao_social"];
    $subArray[] = $row["tpg_descricao"];
    $subArray[] = $row["crp_parcela"];
    $subArray[] = "R$ " . number_format($row["crp_valor"], 2, ',', '.');
    $subArray[] = $row["crp_emissao"];
    $subArray[] = $row["crp_vencimento"];
    $subArray[] = $row["crp_datapagto"];
    $subArray[] = $row["cat_descricao"];
    $subArray[] = $statusClass[$row["crp_status"]];
    $subArray[] = '<div class="btn-group btn-group-sm">
                     <button type="button" name="viewAccountsReceivable" class="btn btn-primary btn-view-accounts-receivable" id="viewAccountsReceivable" onclick="viewAccountsReceivable(' . $row["crp_numero"] . ');">
                        <i class="fas fa-eye"></i>
                     </button>

                     <button type="button" name="updatePaymentMethod" class="btn btn-warning btn-update-payment-method" id="updatePaymentMethod" onclick="updatePaymentMethod(' . $row["crp_numero"] . ');">
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
    $query  = " SELECT * FROM tb_receber_pagar WHERE crp_tipo = 'R' ";
    $result = mysqli_query($connectionDataBase, $query);
    return mysqli_num_rows($result);
}

$output = [
    "draw"            => intval($_POST["draw"]),
    "recordsTotal"    => getAllData($connectionDataBase),
    "recordsFiltered" => $numberFilteredRow,
    "data"            => $data,
    'total'    => number_format($total_order, 2, ',', '.')
];

echo json_encode($output);
