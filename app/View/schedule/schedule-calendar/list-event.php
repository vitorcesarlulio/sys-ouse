<?php
include '../app/Model/connection-pdo.php';

$querySelectEvent = 
"SELECT even_codigo, 
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
on e.orca_numero = o.orca_numero";

$searchEvent = $connectionDataBase->prepare($querySelectEvent);
$searchEvent->execute();

$eventos = [];

while ($row_events = $searchEvent->fetch(PDO::FETCH_ASSOC)) {

    $id            = $row_events['even_codigo'];
    $title         = $row_events['even_titulo'];
    $color         = $row_events['even_cor'];
    $status        = $row_events['even_status'];
    $start         = $row_events['even_datahorai'];
    $end           = $row_events['even_datahoraf'];
    $observation   = $row_events['even_observacao'];

    $name   = $row_events['orca_nome'];
    $surname   = $row_events['orca_sobrenome'];
    $cellphone   = $row_events['orca_cel'];
    $telephone   = $row_events['orca_tel'];
    $email   = $row_events['orca_email'];

    $logradouro   = $row_events['orca_logradouro'];
    $number       = $row_events['orca_log_numero'];
    $bairro       = $row_events['orca_bairro'];
    $localidade   = $row_events['orca_cidade'];
    $uf           = $row_events['orca_estado'];
    $cep          = $row_events['orca_cep'];
    
    $edifice             = $row_events['orca_edificio'];
    $block               = $row_events['orca_bloco'];
    $apartment           = $row_events['orca_apartamento'];
    $streetCondominium   = $row_events['orca_logradouro_condominio'];
    
    $eventos[] = [
        'id'    => $id,
        'title' => $title,
        'color' => $color,
        'status' => $status,
        'start' => $start,
        'end'   => $end,
        'observation'   => $observation,

        'name'   => $name,
        'surname'   => $surname,
        'cellphone'   => $cellphone,
        'telephone'   => $telephone,
        'email'   => $email,

        'logradouro'   => $logradouro,
        'number'       => $number,
        'bairro'       => $bairro,
        'localidade'   => $localidade,
        'uf'           => $uf,
        'cep'          => $cep,
        
        'edifice'           => $edifice,
        'block'             => $block,
        'apartment'         => $apartment,
        'streetCondominium' => $streetCondominium,
        
    ];
}

echo json_encode($eventos);

