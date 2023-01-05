<?php

namespace Model\DAO;

use \PDO;

class sql
{
    public $con;


    public function __construct()
    {
        $this->setCon();
    }

    public function setCon()
    {
        $this->con = new \PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8', DB_USER, DB_PASS);
    }

    public function delete($table, $campo, $id)
    {
        $sql = "DELETE FROM $table where $campo=$id";
        $stmt = $this->con->prepare($sql);
        return $stmt->execute();
    }
    public function listAll($table)
    {
        $sql = "SELECT * FROM $table";
        $stmt = $this->con->prepare($sql);
        return $stmt->execute() ? $stmt->fetchAll() : $stmt->errorInfo();
    }
    public function listAllLike($table, $campo, $valor)
    {
        $sql = "SELECT * FROM $table WHERE $campo LIKE '%$valor%'  LIMIT 15";
        $stmt = $this->con->prepare($sql);
        //$stmt->bindParam(1, $valor);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    public function listOne($table, $campo, $valor)
    {
        $sql = "SELECT * FROM $table WHERE $campo=:valor";
        $stmt = $this->con->prepare($sql);
        $stmt->bindParam(':valor', $valor, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch();
    }
       
    public function listAllParam($table, $campo, $valor)
    {
        $sql = "SELECT * FROM $table WHERE $campo=:valor";
        $stmt = $this->con->prepare($sql);
        $stmt->bindParam(':valor', $valor, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    public function listOneToParam($table, $campo, $valor, $campo2, $valor2)
    {
        $sql = "SELECT * FROM $table WHERE $campo=:valor AND $campo2=:valor2 ";
        $stmt = $this->con->prepare($sql);
        $stmt->bindParam(':valor', $valor, PDO::PARAM_STR);
        $stmt->bindParam(':valor2', $valor2, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch();
    }
    public function listAllToParam($table, $campo, $args, $valor, $campo2, $args2, $valor2)
    {
        $sql = "SELECT * FROM $table WHERE $campo $args :valor AND $campo2 $args2 :valor2 ORDER BY $campo2 ASC";
        $stmt = $this->con->prepare($sql);
        $stmt->bindParam(':valor', $valor, PDO::PARAM_STR);
        $stmt->bindParam(':valor2', $valor2, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
   
    public function inserir($table, $dados)
    {

        $keys = '';
        $values = "";
        $valuekey = "";
        $arr = array();
        foreach ($dados as $key => $value) {
            $keys = $keys . " " . $key . ",";
            $values = $values . " :" . $key . ",";
            $arr[":" . $key] = $value;
        }
        $keys = substr($keys, 0, -1);
        $values = substr($values, 0, -1);

        //$stmt = $this->sql->conect()->prepare("INSERT INTO usuarios (idempresa, nome, responsavel, usuario, senha) 
        $stmt = $this->con->prepare("INSERT INTO $table ($keys) 
        VALUES($values)");

        return  $stmt->execute($arr) ? [true, $this->con->lastInsertId(), $stmt->rowCount()]  : $stmt->errorInfo();
    }

    public function update($table, $dados)
    {

        $sets = '';
        $i = 0;
        foreach ($dados as $key => $value) {
            if ($key != 'id') {
                $sets .= " " . $key . " = '" . $value . "',";
                $i++;
            }
        }
        $sets = substr($sets, 0, -1);
        $sql = "UPDATE " . $table . " set " . $sets . " where id= " . $dados['id'];
        $stmt = $this->con->prepare($sql);

        return $stmt->execute() ? true : $stmt->errorInfo();
    }
}
