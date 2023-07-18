<?php

$bd_link='localhost';
$bd_user='root';
$bd_password='';
$bd_name='bd';

$conectar = mysqli_connect($bd_link, $bd_user, $bd_password, $bd_name);

if(!$conectar){
     die("Connection failed: " . mysqli_connect_error());
}
?>