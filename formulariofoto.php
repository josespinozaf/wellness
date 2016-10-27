<?php 
global $USER, $CFG;
require_once(dirname(__FILE__) . '/../../config.php');
require_once($CFG->dirroot . '/my/lib.php');

include ('connect.php');
$result = mysql_query("SELECT DISTINCT mp.* , mc.* FROM mdl_course_modules as mc
		INNER JOIN mdl_page as mp ON mc.course = mp.course AND mc.instance = mp.id
		WHERE mp.course = 4 and mc.module = 15
		GROUP BY mp.name", $db);

$resultrutina = mysql_query("SELECT DISTINCT mp.* , mc.* FROM mdl_course_modules as mc
		INNER JOIN mdl_page as mp ON mc.course = mp.course AND mc.instance = mp.id
		WHERE mp.course = 5 and mc.module = 15
		GROUP BY mp.name", $db);

echo $OUTPUT->header(); 
if (isset($_POST['Agregar'])){
?>

<form action="subir.php" method="POST" enctype="multipart/form-data">
		<h3>Subir imagen de la clase:</h3>
		Nombre de la clase:
		<select name="nombre">
				  <?php
				  $clases = array();
				  while ($clase =  mysql_fetch_assoc($result))
				  {
				  	$clases[] = $clase;
				  }
				  foreach ($clases as $clase)
				  {
				  	echo "<option  value='".$clase['name'] ."'>".$clase['name'] ."</option>";
				  }
				  ?>
		</select><br>
		<label for="imagen">Imagen:* <input type="file" name="imagen" id="imagen" /></label>
		<p>*Este archivo debe ser .jpg, .jpeg, .gif, .png</p>
		<br>
		<input type="submit" name="subiragregar" value="Subir"/>
</form>
<?php }
if (isset($_POST['Cambiar'])){	
?>
		<form action="subir.php" method="POST" enctype="multipart/form-data">
		<h3>Cambiar imagen de la clase:</h3>
		Nombre de la clase:
		<select name="nombre">
				  <?php
				  $clases = array();
				  while ($clase =  mysql_fetch_assoc($result))
				  {
				  	$clases[] = $clase;
				  }
				  foreach ($clases as $clase)
				  {
				  	echo "<option  value='".$clase['name'] ."'>".$clase['name'] ."</option>";
				  }
				  ?>
		</select><br>
		<label for="imagen">Imagen:* <input type="file" name="imagen" id="imagen" /></label>
		<p>*Este archivo debe ser .jpg, .jpeg, .gif, .png</p>
		<br>
		<input type="submit" name="subircambiar" value="Subir"/>
</form>
<?php
} 
if (isset($_POST['AgregarRutina'])){
?>	
		<form action="subir.php" method="POST" enctype="multipart/form-data">
		<h3>Agregar imagen de la rutina:</h3>
		Nombre de la clase:
		<select name="nombre">
				  <?php
				  $rutinas = array();
				  while ($rutina =  mysql_fetch_assoc($resultrutina))
				  {
				  	$rutinas[] = $rutina;
				  }
				  foreach ($rutinas as $rutina)
				  {
				  	echo "<option  value='".$rutina['name'] ."'>".$rutina['name'] ."</option>";
				  }
				  ?>
		</select><br>
		<label for="imagen">Imagen:* <input type="file" name="imagen" id="imagen" /></label>
		<p>*Este archivo debe ser .jpg, .jpeg, .gif, .png</p>
		<br>
		<input type="submit" name="subiragregar" value="Subir"/>
</form>
<?php 
}
if (isset($_POST['CambiarRutina'])){
	?>
		<form action="subir.php" method="POST" enctype="multipart/form-data">
		<h3>Cambiar imagen de la rutina:</h3>
		Nombre de la clase:
		<select name="nombre">
				  <?php
				  $rutinas = array();
				  while ($rutina =  mysql_fetch_assoc($resultrutina))
				  {
				  	$rutinas[] = $rutina;
				  }
				  foreach ($rutinas as $rutina)
				  {
				  	echo "<option  value='".$rutina['name'] ."'>".$rutina['name'] ."</option>";
				  }
				  ?>
		</select><br>
		<label for="imagen">Imagen:* <input type="file" name="imagen" id="imagen" /></label>
		<p>*Este archivo debe ser .jpg, .jpeg, .gif, .png</p>
		<br>
		<input type="submit" name="subircambiar" value="Subir"/>
</form>
<?php 
}
echo $OUTPUT->footer();
?>
