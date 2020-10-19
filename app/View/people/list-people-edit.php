<?php
if (isset($_POST['idPeopleEdit']) && !empty($_POST['idPeopleEdit'])) {

    include_once '../app/Model/connection-pdo.php';

    $idPeopleEdit = filter_input(INPUT_POST, 'idPeopleEdit', FILTER_SANITIZE_NUMBER_INT);
    $querySelectPeople = " SELECT * FROM tb_pessoas ";

    $parametros = [];
    if (isset($idPeopleEdit)) {
        $querySelectPeople = $querySelectPeople . " WHERE pess_codigo = :pess_codigo ";
        $parametros = [':pess_codigo' => intval($idPeopleEdit)];
    }

    $searchPeople = $connectionDataBase->prepare($querySelectPeople);
    $searchPeople->execute($parametros);

    while ($rowPeople = $searchPeople->fetch(PDO::FETCH_ASSOC)) {

        # Somente as Datas
        $dateInsertPeople = substr($rowPeople['pess_data_cadastro'], 0, 10);
        $dateInsertPeople = explode("-", $dateInsertPeople);
        $dateInsertPeople = $dateInsertPeople[2] . "/" . $dateInsertPeople[1] . "/" . $dateInsertPeople[0];

        $peoples[] = [
            'pess_codigo'                => $rowPeople['pess_codigo'],
            'pess_tipo'                  => $rowPeople['pess_tipo'],
            'pess_classificacao'         => $rowPeople['pess_classificacao'],
            'pess_nome'                  => $rowPeople['pess_nome'],
            'pess_razao_social'          => $rowPeople['pess_razao_social'],
            'pess_sobrenome'             => $rowPeople['pess_sobrenome'],
            'pess_nome_fantasia'         => $rowPeople['pess_nome_fantasia'],
            'pess_cpfcnpj'               => $rowPeople['pess_cpfcnpj'],
            'pess_cep'                   => $rowPeople['pess_cep'],
            'pess_logradouro'            => $rowPeople['pess_logradouro'],
            'pess_log_numero'            => $rowPeople['pess_log_numero'],
            'pess_bairro'                => $rowPeople['pess_bairro'],
            'pess_cidade'                => $rowPeople['pess_cidade'],
            'pess_estado'                => $rowPeople['pess_estado'],
            'pess_edificio'              => $rowPeople['pess_edificio'],
            'pess_bloco'                 => $rowPeople['pess_bloco'],
            'pess_apartamento'           => $rowPeople['pess_apartamento'],
            'pess_logradouro_condominio' => $rowPeople['pess_logradouro_condominio'],
            'pess_observacao'            => $rowPeople['pess_observacao'],
            'pess_data_cadastro'         => $dateInsertPeople,
        ];
    }

    echo json_encode($peoples);
    exit;
}
