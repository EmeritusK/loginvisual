<?php

include "conexion.php";

$id = $_GET['id'];
$cedula = $_POST['CEDULA'];
$nombre = $_POST['NOMBRE'];
$apellido= $_POST['APELLIDO'];
$edad= $_POST['EDAD'];
$telefono= $_POST['TELEFONO'];

$sql = "UPDATE ESTUDIANTES
    SET NOMBRE = '$nombre',
    APELLIDO = '$apellido',
    EDAD = '$edad',
    TELEFONO = '$telefono'
    WHERE CEDULA = '$id'";


if($conectar -> query($sql) === TRUE){
    echo json_encode("se inserto");
    exit();
}else{
    echo json_encode("no se inserto");
    exit();
}

?>