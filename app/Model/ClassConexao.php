<?php
namespace Models;

abstract class ClassConexao{

    protected function conectaDB()
    {
        try{
            $con=new \PDO("mysql:host=".HOST.";dbname=".DATABASE."","".USER."","".PASSWORD."");
            return $con;
        }catch (\PDOException $erro){
            return $erro->getMessage();
        }
    }
}