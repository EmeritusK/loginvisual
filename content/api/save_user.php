<?php

include "conexion.php";

$cedula = $_POST['CEDULA'];
$nombre = $_POST['NOMBRE'];
$apellido= $_POST['APELLIDO'];
$edad= $_POST['EDAD'];
$telefono= $_POST['TELEFONO'];

$sql = "INSERT INTO ESTUDIANTES VALUES('$cedula','$nombre','$apellido','$edad','$telefono')";


if($conectar -> query($sql) === TRUE){
    echo json_encode("se inserto");
    exit();
}else{
    echo json_encode("no se inserto");
    exit();
}

?>