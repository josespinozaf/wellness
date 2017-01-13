<?php 
//Conexion a la base de datos
$dbhost = "localhost";
$dbuser = "root";
$dbpass = "";
$dbname = "moodle";
$db = mysql_connect($dbhost,$dbuser,$dbpass) or die('No se puede conectar a la base de datos.');
mysql_select_db($dbname) or die('Problema al seleccionar la base de datos.');
?>