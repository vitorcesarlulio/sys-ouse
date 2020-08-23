<?php

namespace Classes;

use Models\ClassCadastro;

class ClassValidate
{

    private $erro = [];
    private $cadastro;

    public function __construct()
    {
        $this->cadastro = new ClassCadastro();
    }

    public function getErro()
    {
        return $this->erro;
    }

    public function setErro($erro)
    {
        array_push($this->erro, $erro);
    }


    #Validar se o email existe no banco de dados (action null para cadastro)
    public function validateIssetEmail($loginUser, $action = null) //colocar um login do lado do emial
    {
        //$b = $this->cadastro->getIssetEmail($email);
        $b = $this->cadastro->getIssetEmail($loginUser);

        if ($action == null) {
            if ($b > 0) {
                $this->setErro("Email já cadastrado!");
                return false;
            } else {
                return true;
            }
        } else { //login 
            if ($b > 0) {
                return true;
            } else {
                $this->setErro("Email não cadastrado!");
                return false;
            }
        }
    }

    #Verificação da senha digitada com o hash no banco de dados
    public function validateSenha($email, $senha)
    {

    }

}
