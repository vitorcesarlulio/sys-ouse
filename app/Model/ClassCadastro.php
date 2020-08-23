<?php

namespace Models;

class ClassCadastro extends ClassCrud
{

    #Realizará a inserção no banco de dados
    public function insertCad($arrVar)
    {
        $this->insertDB(
            "tb_usuario",
            "?,?,?,?,?,?,?",
            array(
                0,
                $arrVar['usu_login'],
                $arrVar['hashSenha'],
                $arrVar['usu_nome'],
                $arrVar['usu_sobrenome'],
                'user'
            )
        );

        // $this->insertDB(
        //     "confirmation",
        //         "?,?,?",
        //         array(
        //             0,
        //             $arrVar['email'],
        //             $arrVar['token']
        //         )
        // );
    }

    #Veriricar se já existe o mesmo email cadastro no db
    public function getIssetEmail($loginUser) //subst email por login 
    {
        // $b = $this->selectDB(
        //     "*",
        //     "tb_usuario",
        //     "where usu_login=?",
        //     array(
        //         $email
        //     )
        // );
        // return $r = $b->rowCount();

        $b = $this->selectDB(
            "*",
            "tb_usuario",
            "where usu_login=?",
            array(
                $loginUser
            )
        );
        return $r = $b->rowCount();
        
    }
}
