<?php
namespace MyApp\Query;
use PDO;
use PDOException;
use MyApp\Data\Database;

class Ejecuta
{
    public function ejecutar($qry)
    {
        try
        {
            $cc = new Database("integradora1","root","");
            $objetoPDO= $cc->getPDO();
            $resultado = $objetoPDO->query($qry);
            
            $cc->desconectarDB();
            
        }
        catch(PDOException $e)
        {
            echo $e->getMessage();
        }
    }
}