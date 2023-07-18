<?php

include "conexion.php";

$cedula = $_POST['CEDULA'];
echo $cedula;

$sql = "DELETE FROM ESTUDIANTES WHERE CEDULA = '$cedula'";



if($conectar -> query($sql) === TRUE){
    echo json_encode("se borro");
    exit();
}else{
    echo json_encode("no se borro");
    exit();
}

?>