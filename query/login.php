<?php
namespace MyApp\Config;
use PDO;
use PDOException;
use MyApp\Data\Database;

class login
{
    public function verificalogin($usuario,$contraseña)
    {
        try
        {
            $pase=0;
            $cc= new Database("workstack","root","admin");
            $objetoPDO = $cc->getPDO();
            $admin='1';
            $query="SELECT * FROM usuarios WHERE usuario='$usuario' and tipo_usuario='$admin'";
            $consulta=$objetoPDO->query($query);
            while($renglon=$consulta->fetch(PDO::FETCH_ASSOC))
            {
                if(password_verify($contraseña,$renglon['CONTRASEÑA']))
                {
                    $pase=1;
                }
            }
            if($pase>0)
            {
                session_start();
                $_SESSION["usuario"]=$usuario;
                echo "<div class='alet alet-succes'>";
                echo "<h2 align='center'>BIENVENIDO ADMINISTRADOR </h2>";
                echo"</div";
                header("refresh:2 ../views/administrador/index.php");
            }
            $cc->desconectarDB();
        }
        catch(PDOException $e)
        {
            echo $e->getMessage();
        }
    }
   public function verificaemple($usuario,$contraseña)
    {
        try
        {
            $pase=0;
            $cc= new Database("workstack","root","admin");
            $objetoPDO = $cc->getPDO();
            $emple='2';
            $query="SELECT * FROM usuarios WHERE usuario='$usuario' and tipo_usuario='$emple'";
            $consulta=$objetoPDO->query($query);
            while($renglon=$consulta->fetch(PDO::FETCH_ASSOC))
            {
                if(password_verify($contraseña,$renglon['CONTRASEÑA']))
                {
                    $pase=1;
                }
            }
            if($pase>0)
            {
                session_start();
                $_SESSION["usuario"]=$usuario;
                echo "<div class='alet alet-succes'>";
                echo "<h2 align='center'>BIENVENIDO Emplead@</h2>";
                echo"</div";
                header("refresh:2 ../views/empleado/index.php");
            }

            $cc->desconectarDB();
        }
        catch(PDOException $e)
        {
            echo $e->getMessage();
        }
        
    }
 
    public function error($usuario,$contraseña)
    {

        try
        {
            $pase=0;
            $cc= new Database("workstack","root","admin");
            $objetoPDO = $cc->getPDO();
            $query="SELECT* FROM usuarios WHERE usuario='$usuario'";
            $consulta=$objetoPDO->query($query);
            while($renglon=$consulta->fetch(PDO::FETCH_ASSOC))
            {
                if(password_verify($contraseña,$renglon['CONTRASEÑA']))
                {
                    $pase=1;
                }
            }
            while($pase=0)
            {
                echo "<div class='alert alert-danger'>";
                echo "<h2 align='center'>USUARIO O PASSWORD INCORRECTO...</h2>";
                echo"</div";
                header("refresh:2 ../index.php");
                
            }
        }
        catch(PDOException $e)
        {
            echo $e->getMessage();
        }
    
    }
    public function cerrarSesion()
    {
        session_start();
        session_destroy();
        header("Location: ../index.php");
    }
}