<?php
if (isset($_POST) && !empty($_POST)) {

    include_once '../app/Model/connection-pdo.php';

    if (isset($_POST['cpf']) && !empty($_POST['cpf'])) {

        $cpf = str_replace('.', '',  $_POST['cpf']);

        $queryCheckCpf = " SELECT pess_cpfcnpj FROM tb_pessoas WHERE pess_cpfcnpj=:pess_cpfcnpj ";
        $selectCpf = $connectionDataBase->prepare($queryCheckCpf);
        $selectCpf->bindParam("pess_cpfcnpj", $cpf);
        $selectCpf->execute();

        $countRow = 0;
        $countRow = $selectCpf->rowCount();

        # Rtorno para o ajax falso ou verdadeiro
        if ($countRow === 0) {
            $returnAjax = 'notFoundCpf';
        } else {
            $returnAjax = 'foundCpf';
        }
        
        header('Content-Type: application/json');
        echo json_encode($returnAjax);

    } else if (isset($_POST['cnpj']) && !empty($_POST['cnpj'])) {
        $cnpj = str_replace(['.', '/', '-'], '',  $_POST['cnpj']);

        $queryCheckCnpj = " SELECT pess_cpfcnpj FROM tb_pessoas WHERE pess_cpfcnpj=:pess_cpfcnpj ";
        $selectCnpj = $connectionDataBase->prepare($queryCheckCnpj);
        $selectCnpj->bindParam("pess_cpfcnpj", $cnpj);
        $selectCnpj->execute();

        $countRow = 0;
        $countRow = $selectCnpj->rowCount();

        # Rtorno para o ajax falso ou verdadeiro
        if ($countRow === 0) {
            $returnAjax = 'notFoundCnpj';
        } else {
            $returnAjax = 'foundCnpj';
        }

        header('Content-Type: application/json');
        echo json_encode($returnAjax);
    }
}
