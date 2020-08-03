<?php
include '../app/Model/connection-pdo.php';

$querySelectEvent =
    " SELECT 
even_codigo, 
even_titulo, 
even_cor, 
even_status, 
even_datahorai, 
even_datahoraf, 
even_observacao, 
orca_nome, 
orca_sobrenome, 
orca_tel, 
orca_cel,
orca_email,
orca_logradouro,
orca_log_numero,
orca_bairro,
orca_cidade,
orca_estado,
orca_cep,
orca_edificio,
orca_bloco,
orca_apartamento,
orca_logradouro_condominio

FROM tb_eventos e 
INNER JOIN tb_orcamento o 
ON e.orca_numero = o.orca_numero ";

# Visualizar evento pela consulta Eventos (fora do calendario)
$parametros = [];

if (isset($_GET['id'])) {
    $querySelectEvent = $querySelectEvent . " WHERE even_codigo = :id ";
    $parametros = [':id' => intval($_GET['id'])];
}


$searchEvent = $connectionDataBase->prepare($querySelectEvent);
$searchEvent->execute($parametros);

$eventos = [];

while ($row_events = $searchEvent->fetch(PDO::FETCH_ASSOC)) {

    #Somente as Datas
    $dateStart = substr($row_events['even_datahorai'], 0, 10);
    $dateStart = explode("-", $dateStart);
    $dateStart = $dateStart[2] . "/" . $dateStart[1] . "/" . $dateStart[0];

    #Somente hora e minuto
    $hourStart = substr($row_events['even_datahorai'], 11, -3);
    $hourEnd   = substr($row_events['even_datahoraf'], 11, -3);

    #Mascara Celular
    if (strlen($row_events['orca_cel']) == 10) {
        $cellphoneFormatted = substr_replace($row_events['orca_cel'], '(', 0, 0);
        $cellphoneFormatted = substr_replace($cellphoneFormatted, '9', 3, 0);
        $cellphoneFormatted = substr_replace($cellphoneFormatted, ')', 3, 0);
    } else {
        $cellphoneFormatted = substr_replace($row_events['orca_cel'], '(', 0, 0);
        $cellphoneFormatted = substr_replace($cellphoneFormatted, ') ', 3, 0);
        $cellphoneFormatted = substr_replace($cellphoneFormatted, '-', 10, 0);
    }

    #Mascara Telefone
    if (strlen($row_events['orca_tel']) == 9) {
        $telephoneFormatted = substr_replace($row_events['orca_tel'], '(', 0, 0);
        $telephoneFormatted = substr_replace($telephoneFormatted, '9', 3, 0);
        $telephoneFormatted = substr_replace($telephoneFormatted, ')', 3, 0);
    } else {
        $telephoneFormatted = substr_replace($row_events['orca_tel'], '(', 0, 0);
        $telephoneFormatted = substr_replace($telephoneFormatted, ') ', 3, 0);
        $telephoneFormatted = substr_replace($telephoneFormatted, '-', 9, 0);
    }

    $row_events['orca_cep'] = substr_replace($row_events['orca_cep'], '-', 5, 0);


    $eventos[] = [
        'id'                => $row_events['even_codigo'],
        'title'             => $row_events['even_titulo'],
        'color'             => $row_events['even_cor'],
        'status'            => $row_events['even_status'],
        'start'             => $row_events['even_datahorai'],
        'end'               => $row_events['even_datahoraf'],
        'observation'       => $row_events['even_observacao'],
        'name'              => $row_events['orca_nome'],
        'surname'           => $row_events['orca_sobrenome'],
        'cellphone'         => $row_events['orca_cel'],
        'telephone'         => $row_events['orca_tel'],
        'email'             => $row_events['orca_email'],
        'logradouro'        => $row_events['orca_logradouro'],
        'number'            => $row_events['orca_log_numero'],
        'bairro'            => $row_events['orca_bairro'],
        'localidade'        => $row_events['orca_cidade'],
        'uf'                => $row_events['orca_estado'],
        'cep'               => $row_events['orca_cep'],
        'edifice'           => $row_events['orca_edificio'],
        'block'             => $row_events['orca_bloco'],
        'apartment'         => $row_events['orca_apartamento'],
        'streetCondominium' => $row_events['orca_logradouro_condominio'],

        'dateStart'         => $dateStart,
        'hourStart'         => $hourStart,
        'hourEnd'           => $hourEnd,
        'cellphoneFormatted' => $cellphoneFormatted,
        'telephoneFormatted' => $telephoneFormatted,
    ];
}

echo json_encode($eventos);
