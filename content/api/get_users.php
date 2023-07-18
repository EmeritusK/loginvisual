<?php

include "conexion.php";

$sql = "SELECT * FROM ESTUDIANTES";
$respuesta = $conectar -> query($sql);
$resultado = array();

if($respuesta -> num_rows > 0){
    while($fila = $respuesta -> fetch_array()){        
      array_push($resultado, $fila);     
    }

    echo json_encode($resultado);

}else{
    $resultado = "No hay datos";
}

?>