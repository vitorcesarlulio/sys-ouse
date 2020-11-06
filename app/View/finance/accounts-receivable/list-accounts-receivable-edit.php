<?php
//if (isset($_POST['idAccountReceivable']) && !empty($_POST['idAccountReceivable'])) {

include '../app/Model/connection-pdo.php';

$idAccountReceivable = filter_input(INPUT_GET, 'idAccountReceivable', FILTER_SANITIZE_NUMBER_INT);

$querySelectAccountsReceivable = " SELECT 
crp_numero,
crp_parcela,
DATE_FORMAT(crp_emissao,'%d/%m/%Y') AS crp_emissao,
DATE_FORMAT(crp_vencimento,'%d/%m/%Y') AS crp_vencimento,
crp_valor,
DATE_FORMAT(crp_datapagto,'%d/%m/%Y') AS crp_datapagto,
crp_obs,
crp_ndoc, 
crp_status,

pess_nome,
pess_sobrenome,
pess_razao_social,

tpg_descricao,
crp.tpg_codigo,

cat_descricao,
crp.cat_codigo

FROM tb_receber_pagar crp

INNER JOIN tb_pessoas pess 
ON crp.pess_codigo = pess.pess_codigo 

INNER JOIN tb_tipo_pagamento tpg 
ON crp.tpg_codigo = tpg.tpg_codigo 

INNER JOIN tb_categoria cat 
ON crp.cat_codigo = cat.cat_codigo 

WHERE crp_numero = :crp_numero ";

$searchAccountsReceivable = $connectionDataBase->prepare($querySelectAccountsReceivable);
$searchAccountsReceivable->bindParam(':crp_numero', $idAccountReceivable);
$searchAccountsReceivable->execute();

$statusClass = [
    "ABERTO"     => '<span class="badge badge-warning badge-open">ABERTO</span>',
    "PAGO"       => '<span class="badge badge-success badge-pay">PAGO</span>',
    "CANCELADO"  => '<span class="badge badge-danger badge-pay">CANCELADO</span>',
    "NEGOCIADO"  => '<span class="badge badge-negotiated">NEGOCIADO</span>',
    "PROTESTADO" => '<span class="badge badge-protested">PROTESTADO</span>'
];

while ($rowAccountsReceivable = $searchAccountsReceivable->fetch(PDO::FETCH_ASSOC)) {

    $accountsReceivable[] = [
        'crp_numero'         => $rowAccountsReceivable['crp_numero'],
        'crp_parcela'        => $rowAccountsReceivable['crp_parcela'],
        'crp_emissao'        => $rowAccountsReceivable['crp_emissao'],
        'crp_vencimento'     => $rowAccountsReceivable['crp_vencimento'],
        'crp_valor'          => "R$ " . number_format($rowAccountsReceivable["crp_valor"], 2, ',', '.'),
        'crp_datapagto'      => $rowAccountsReceivable['crp_datapagto'],
        'crp_obs'            => $rowAccountsReceivable['crp_obs'],
        'crp_ndoc'        => $rowAccountsReceivable['crp_ndoc'],
        'crp_status'         => $rowAccountsReceivable['crp_status'],
        'crp_statusBadge'    => $statusClass[$rowAccountsReceivable['crp_status']],
        'cat_descricao'      => $rowAccountsReceivable['cat_descricao'],
        'pess_nome'          => $rowAccountsReceivable['pess_nome'],
        'pess_sobrenome'     => $rowAccountsReceivable['pess_sobrenome'],
        'pess_razao_social' => $rowAccountsReceivable['pess_razao_social'],
        'tpg_descricao'     => $rowAccountsReceivable['tpg_descricao'],
        'tpg_codigo'     => $rowAccountsReceivable['tpg_codigo'],
        'cat_codigo'     => $rowAccountsReceivable['cat_codigo'],
    ];
}

echo json_encode($accountsReceivable);
exit;
