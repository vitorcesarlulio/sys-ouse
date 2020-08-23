<?php

namespace Models;

class ClassCrud extends ClassConexao
{

    private $crud;

    #Responsável pela preparação da query e execução
    private function prepareExecute($prep, $exec)
    {
        $this->crud = $this->conectaDB()->prepare($prep);
        $this->crud->execute($exec);
    }

    #Seleção de dados
    public function selectDB($fields, $table, $where, $exec)
    {
        $this->prepareExecute("SELECT {$fields} FROM {$table} {$where}", $exec);
        return $this->crud;
    }

    #Inserção de dados
    public function insertDB($table, $values, $exec)
    {
        $this->prepareExecute("INSERT INTO {$table} VALUES ({$values})", $exec);
        return $this->crud;
    }

    #Delete de dados
    public function deleteDB($table, $where, $exec)
    {
        $this->prepareExecute("DELETE FROM {$table} WHERE {$where}", $exec);
        return $this->crud;
    }

    #Atualização de dados
    public function updateDB($table, $values, $where, $exec)
    {
        $this->prepareExecute("UPDATE {$table} SET {$values} WHERE {$where}", $exec);
        return $this->crud;
    }
}
