<?php

function Conexion(){
    $pass = "";
    $user = "root";
    $database = "bd_prueba_tecnica";
    try{
        $con = new PDO('mysql:host=localhost;dbname=' . $database, $user , $pass  );
        $con->query("set names utf8;");        
        $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $con;
    }catch(PDOException $pe){        
        die("Could not connect to the database $dbname :" . $pe->getMessage());
        return false;
    }
}

function ejecutarInsertar($sentencia,$conexion){
    try{
        $data = $conexion->prepare($sentencia);
        $data->execute();
        return true;
    }catch(Exception $e){
        return false;
    } 
    //$id = $base_de_datos->lastInsertId();
}
function ejecutarObtener($sentencia,$conexion){
    
    try{
        $data = $conexion->prepare($sentencia);
        $data->execute();
        
        return $data;

    }catch(Exception $e){
        return false;
    }

}


?>