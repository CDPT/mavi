<?php
//Configuracion de la conexion a base de datos
$bd_host = "localhost"; 
$bd_usuario = "root"; 
$bd_password = "12345"; //aqui va su contraseņa previamente configurada en el AppServ.
$bd_base = "bdmavi"; 
$con = mysql_connect($bd_host, $bd_usuario, $bd_password); 
mysql_select_db($bd_base, $con); 
?>