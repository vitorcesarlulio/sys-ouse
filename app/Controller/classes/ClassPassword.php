<?php
namespace Classes;

class ClassPassword{

    #Criar o hash da senha para salvar no banco de dados
    public function passwordHash($senha)
    {
        return password_hash($senha, PASSWORD_DEFAULT);
    }
}