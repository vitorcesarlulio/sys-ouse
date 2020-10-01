<?php
if (isset($_POST['idPeople']) && !empty($_POST['idPeople'])) {

    include_once '../app/Model/connection-pdo.php';

    $idPeople = filter_input(INPUT_POST, 'idPeople', FILTER_SANITIZE_NUMBER_INT);
    $querySelectContactPeople = " SELECT * FROM tb_contatos ";

    $parametros = [];
    if (isset($idPeople)) {
        $querySelectContactPeople = $querySelectContactPeople . " WHERE pess_codigo = :pess_codigo ";
        $parametros = [':pess_codigo' => intval($idPeople)];
    }

    $searchContactPeople = $connectionDataBase->prepare($querySelectContactPeople);
    $searchContactPeople->execute($parametros);

    $users = [];
    while ($rowContactPeople = $searchContactPeople->fetch(PDO::FETCH_ASSOC)) {

        # Mascaras Contato
        if (strlen($rowContactPeople['cont_contato']) == 11) {
            $contactFormatted = substr_replace($rowContactPeople['cont_contato'], '(', 0, 0);
            $contactFormatted = substr_replace($contactFormatted, ') ', 3, 0);
            $contactFormatted = substr_replace($contactFormatted, '-', 10, 0);
        } else if (strlen($rowContactPeople['cont_contato']) == 10) {
            $contactFormatted = substr_replace($rowContactPeople['cont_contato'], '(', 0, 0);
            $contactFormatted = substr_replace($contactFormatted, ') ', 3, 0);
            $contactFormatted = substr_replace($contactFormatted, '-', 9, 0);
        } else {
            $contactFormatted = $rowContactPeople['cont_contato'];
        }

        $users[] = [
            'cont_codigo'                => $rowContactPeople['cont_codigo'],
            'cont_tipo'                  => $rowContactPeople['cont_tipo'],
            'cont_responsavel'           => $rowContactPeople['cont_responsavel'],
            'cont_contato'               => $contactFormatted,
            'pess_codigo'                => $rowContactPeople['pess_codigo'],
        ];
    }

    echo json_encode($users, true);
}
