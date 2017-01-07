<?php
global $USER, $CFG;
require_once(dirname(__FILE__) . '/../../config.php');
require_once($CFG->dirroot . '/my/lib.php');

redirect_if_major_upgrade_required();


$edit   = optional_param('edit', null, PARAM_BOOL);    // Turn editing on and off
$reset  = optional_param('reset', null, PARAM_BOOL);

require_login();

//** Configuración de la página **//
$params = array();
$PAGE->set_context($context);
$PAGE->set_url('/local/wellness/rutina_aleatoria.php', $params);
$PAGE->set_pagelayout('mydashboard');
$PAGE->set_pagetype('local-wellness-rutina aleatoria');
$PAGE->blocks->add_region('content');
$PAGE->set_subpage($currentpage->id);
$PAGE->set_title(get_string('navrutinaaleatoria','local_wellness'));
$PAGE->set_heading($header);
$PAGE->navbar->add(get_string('navrutinaaleatoria','local_wellness'), new moodle_url('/local/wellness/rutina_aleatoria.php'));

echo $OUTPUT->header ();
?>
<html>
<head>
<style>
table {
    font-family: arial, sans-serif;
    border-collapse: collapse;
    width: 100%;
}

td, th {
    border: 1px solid #dddddd;
    text-align: left;
    padding: 8px;
}

tr:nth-child(even) {
    background-color: #dddddd;
}
</style>
</head>
<body>
<?php 
include("connect.php");
if (isset($_POST['Rutina_Aleatoria'])){
	echo "<h4>Rutina Aleatoria</h4> <br>";
	$intensidad= $_REQUEST['intensidad'];;?>
	<table>
  <tr>
    <th>Ejercicio</th>
    <th>Categoria</th>
    <th>Link Video</th>
    <th>Intensidad</th>
  </tr>
<?php   $ej= mysql_query("SELECT * FROM `ejercicios` WHERE `intensidad`='".$intensidad."' ORDER BY RAND() LIMIT 4");
		while ($ejercicios=mysql_fetch_array($ej)){
  			echo "<tr> <td>".$ejercicios['nombre']."</td>";
  			echo "<td>".$ejercicios['categoria']."</td>";
  			echo "<td>".$ejercicios['link_video']."</td>";
			echo "<td>".$ejercicios['intensidad']."</td>";	
			echo "</tr>";
		}
		echo "</table>";
		echo "<br>Otra rutina? <a href='javascript:document.location.reload();' class='btn'>Click aquí</a><br>";
}else{
?>
<h3 align="center">Para crear una rutina aleatoria
<form method="POST">
<?php $result= mysql_query("SELECT DISTINCT `intensidad` FROM `ejercicios`")?>
<!-- 	Formulario para elegir la intensidad de la rutina -->
	 <p>Qué intensidad quieres?: </p><select name="intensidad">
	<?php while ($datos= mysql_fetch_array($result))
		echo "<option  value='".$datos['intensidad']."'>".$datos['intensidad']."</option>";?>
	</select>  
  <input type="submit" value="Hacer Rutina" name="Rutina_Aleatoria" />
  </form>
  </h3>
<?php }
if (is_siteadmin()){
	if (isset($_POST['Agregar'])){?>
<!-- 	Formulario para agregar ejercicio a BD -->
	<form action='bdejercicios.php' method='POST'>
	Nombre del ejercicio:<input type="text" name="nombre"/><br>
	Categoría:<input type="text" name="categoria"/><br>
	Link Video:<input type="text" name="link_video"/><br>
	Intensidad:<input type="text" name="intensidad"/><br>
	<input type='submit' name='Agregar_ejercicio' value='Agregar ejercicio'>
	<a href='../local/wellness/rutina_aleatoria.php' >Volver</a>
	</form>
	<?php 	}
	else if (isset($_POST['Eliminar'])){
	$result= mysql_query("SELECT * FROM ejercicios")?>
<!-- 	Formulario para eliminar un ejercicio de la BD		 -->
	<form action="bdejercicios.php" method='POST'>
	Cuál desea borrar?<select name="nombre">
	<?php while ($datos= mysql_fetch_array($result))
		echo "<option  value='".$datos['nombre']."'>".$datos['nombre']."</option>";?>
	</select><br>
	<input type="submit" name='Eliminar_ejercicio' value="Borrar" /></table>
	<a href='../../local/wellness/rutina_aleatoria.php'>Volver</a>
	</form>
	<?php }else{?>
	<form action='#' method='POST'>
	<input type='submit' name='Agregar' value='Agregar ejercicio'>
	<input type='submit' name='Eliminar' value='Eliminar ejercicio'>
	</form>
<?php 	
	}}
echo $OUTPUT->footer ();?>
</body>
</html>