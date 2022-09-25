<?php
include_once "conexion.php";
?>
<?php
$conexion=Conexion();
$datos = json_decode(file_get_contents('php://input'),true);

if(  !empty($datos) ){
    $accion=$datos['accion'];         
    if($accion === 'nuevoPersonal'){            
        $res =agregarPersonal( $conexion,$datos );
        if($res=='ok'){
            obtenerPersonal($conexion,date("m"));
        }else{
            echo json_encode(['estado'=>'error']);
        }
    }
    else if($accion === 'mostrarPersonal'){
        obtenerPersonales($conexion );
    }             
    else if($accion === 'guardarVacacion'){
        $res =guardarVacacion($conexion,$datos);
        if($res=='ok'){
            $result= obtenerPersonal($conexion,date("m"));
        }else{
            echo json_encode(['estado'=>'error']);
        }        
    }
    else if( $accion === 'obtenerPersonalxmes'){
        $mes = $datos['mes'];
        obtenerPersonal($conexion,$mes);
    }
    else if( $accion === 'obtenerVacacion' ) {
        obtenerVacacion( $conexion, $datos );
    }
    else{                  
    }
    exit();
}

function agregarPersonal($conex,$data){
    $nombre=$data['nombre'];
    $apellido=$data['apellido'];
    $trahajo=$data['trabajo'];
    $sentencia= "INSERT INTO personal (nombre,apellido,area_trabajo) values ( '".$nombre."','".$apellido."','".$trahajo."' ) ";     
    $ejecutar = ejecutarInsertar($sentencia , $conex);
    if($ejecutar){            
        return 'ok';
    }else{
        return 'error';
    }

}

function obtenerPersonales($conex){
    $retorno=ejecutarObtener("SELECT * from personal",$conex);
    $results='';
    if($retorno->rowCount() > 0){
        $results = $retorno->fetchAll(PDO::FETCH_OBJ);
        echo json_encode(['datos'=>$results,'estado'=>'ok']);
    }else{
        $results=null;
        echo json_encode(['estado'=>'vacio']);
    }
    exit();
}

function  obtenerPersonal($conex,$mes){
    $retorno=ejecutarObtener("SELECT personal.id, vacacion.id as id_vac, personal.nombre,personal.apellido,personal.area_trabajo,vacacion.aprobado, CONCAT(vacacion.fecha_vacacion ,'-' , vacacion.fecha_fin_vacacion)  as fecha
    FROM personal left JOIN vacacion ON personal.id= vacacion.personal_id  WHERE MONTH(vacacion.fecha_vacacion)=".$mes,$conex);
    $results='';
    if($retorno->rowCount() > 0){
        $results = $retorno->fetchAll(PDO::FETCH_OBJ);
        echo json_encode(['datos'=>$results,'estado'=>'ok']);
    }else{
        $results=null;
        echo json_encode(['estado'=>'vacio']);
    }
    exit();
}

function guardarVacacion($conex,$data){
    $inicio=$data['inicio'];
    $fin=$data['fin'];
    $estado=$data['estado'];
    $idPersona = $data['idPersonal'];
    $sentencia= "INSERT INTO vacacion (fecha_vacacion,fecha_fin_vacacion,aprobado,personal_id) values ( '".$inicio."','".$fin."',".$estado.",".$idPersona." ) ";     
    $ejecutar = ejecutarInsertar($sentencia , $conex);
    if($ejecutar){            
        return 'ok';
    }else{
        return 'error';
    }
}

function obtenerVacacion($conex,$data){
    $id=$data['idPersona'];
    $sentencia= "SELECT *  FROM vacacion where id=".$id;     
    $retorno = ejecutarObtener($sentencia , $conex);
    if($retorno->rowCount() > 0){
        $results = $retorno->fetchAll(PDO::FETCH_OBJ);
        echo json_encode(['datos'=>$results,'estado'=>'ok']);
    }else{
        $results=null;
        echo json_encode(['estado'=>'vacio']);
    }
    exit();
}
?>