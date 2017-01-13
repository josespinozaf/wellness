<?php
// Configuracion de la pagina
require_once (dirname ( __FILE__ ) . '/conf.php');
$params = array ();
$PAGE->set_context ( $context );
$PAGE->set_url ( '/local/wellness/rutina_aleatoria.php', $params );
$PAGE->set_pagelayout ( 'mydashboard' );
$PAGE->set_pagetype ( 'local-wellness-rutina aleatoria' );
$PAGE->blocks->add_region ( 'content' );
$PAGE->set_subpage ( $currentpage->id );
$PAGE->set_title ( get_string ( 'navrutinaaleatoria', 'local_wellness' ) );
$PAGE->set_heading ( $header );
$PAGE->navbar->add ( get_string ( 'navrutinaaleatoria', 'local_wellness' ), new moodle_url ( '/local/wellness/rutina_aleatoria.php' ) );

// Header
echo $OUTPUT->header ();
?>
<html>
<body>
<?php
if (isset ( $_POST ['Rutina_Aleatoria'] )) {
	echo "<h4>Rutina Aleatoria</h4> <br>";
	$intensidad = $_REQUEST ['intensidad'];
	;
	?>
	<table class="tablerutal">
		<tr class="trrutal">
			<th class="thrutal">Ejercicio</th>
			<th class="thrutal">Categoria</th>
			<th class="thrutal">Link Video</th>
			<th class="thrutal">Intensidad</th>
		</tr>
<?php
	$ej = mysql_query ( "SELECT * FROM `ejercicios` WHERE `intensidad`='" . $intensidad . "' ORDER BY RAND() LIMIT 4" );
	while ( $ejercicios = mysql_fetch_array ( $ej ) ) {
		echo "<tr class='trrutal'> <td class='tdrutal'>" . $ejercicios ['nombre'] . "</td>";
		echo "<td class='tdrutal'>" . $ejercicios ['categoria'] . "</td>";
		echo "<td class='tdrutal'>" . $ejercicios ['link_video'] . "</td>";
		echo "<td class='tdrutal'>" . $ejercicios ['intensidad'] . "</td>";
		echo "</tr>";
	}
	echo "</table>";
	echo "<form><br><input type='button' value='Otra Rutina' onClick='javascript:document.location.reload();'><input type='button' value='Volver' onClick='history.back();return true;'></form>";
} else {
	?>
<h3 align="center">
			Para crear una rutina aleatoria
			<form method="POST">
<?php $result= mysql_query("SELECT DISTINCT `intensidad` FROM `ejercicios`")?>
<!-- 	Formulario para elegir la intensidad de la rutina -->
				<p>Qué intensidad quieres?:</p>
				<select name="intensidad">
<?php
	
	while ( $datos = mysql_fetch_array ( $result ) )
		echo "<option  value='" . $datos ['intensidad'] . "'>" . $datos ['intensidad'] . "</option>";
	?>
	</select> <input type="submit" value="Hacer Rutina"
					name="Rutina_Aleatoria" />
			</form>
		</h3>
<?php
}
if (is_siteadmin ()) {
	if (isset ( $_POST ['Agregar'] )) {
		?>
<!-- 	Formulario para agregar ejercicio a BD -->
		<form action='bdejercicios.php' method="POST">
			Nombre del ejercicio:<input type="text" name="nombre" /><br>
			Categoría:<input type="text" name="categoria" /><br> 
			Link Video:<input type="text" name="link_video" /><br> 
			Intensidad:<select name="intensidad">
<?php
		$result = mysql_query ( "SELECT DISTINCT `intensidad` FROM `ejercicios`" );
		while ( $datos = mysql_fetch_array ( $result ) )
			echo "<option  value='" . $datos ['intensidad'] . "'>" . $datos ['intensidad'] . "</option>";
		?>	</select><br> 
		<input type='submit' name='Agregar_ejercicio' value='Agregar ejercicio'> 
		<input type="button" value="Volver" onClick="history.back();return true;">
		</form>
<?php
	} else if (isset ( $_POST ['Eliminar'] )) {
		$result = mysql_query ( "SELECT * FROM ejercicios" )?>
		<form action='bdejercicios.php' method='POST'>
			Cuál desea borrar?<select name="nombre">
<?php
		while ( $datos = mysql_fetch_array ( $result ) )
			echo "<option  value='" . $datos ['nombre'] . "'>" . $datos ['nombre'] . "</option>";
		?>
	</select><br> 
	<input type="submit" name='Eliminar_ejercicio' value="Borrar" /> 
	<input type="button" value="Volver" onClick="history.back();return true;">
	</table>
	</form>
	<?php }else{?>
	<form action='#' method='POST'>
		<input type='submit' name='Agregar' value='Agregar ejercicio'> <input
			type='submit' name='Eliminar' value='Eliminar ejercicio'>
	</form>
<?php
	}
	?>
<!-- 	Tabla de ejercicios actuales -->
<h3>Ejercicios actuales:</h3>	
	<table class="tablerutal">
		<tr class="trrutal">
			<th class="thrutal">Ejercicio</th>
			<th class="thrutal">Intensidad</th>
			<th class="thrutal">Categoria</th>
			<th class="thrutal">Link Video</th>
		</tr>
<?php
//Datos de la tabla de ejercicios actuales
	$eje = mysql_query ( "SELECT DISTINCT * FROM `ejercicios` ORDER BY `ejercicios`.`intensidad` ASC" );
	while ( $ejercicios = mysql_fetch_array ( $eje ) ) {
		echo "<tr class='trrutal'> <td class='tdrutal'>" . $ejercicios ['nombre'] . "</td>";
		echo "<td class='tdrutal'>" . $ejercicios ['intensidad'] . "</td>";
		echo "<td class='tdrutal'>" . $ejercicios ['categoria'] . "</td>";
		echo "<td class='tdrutal'><a href=" . $ejercicios ['link_video'] . ">Link</a></td>";
		echo "</tr>";
	}
	echo "</table>";
?>
<?php 
}
echo $OUTPUT->footer ();
?>
</body>
</html>