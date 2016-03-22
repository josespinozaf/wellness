<?php 
global $USER, $CFG;
require_once(dirname(__FILE__) . '/../../config.php');
require_once($CFG->dirroot . '/my/lib.php');

include ('connect.php');
$result = mysql_query("SELECT DISTINCT mp.* , mc.* FROM mdl_course_modules as mc
		INNER JOIN mdl_page as mp ON mc.course = mp.course AND mc.instance = mp.id
		WHERE mp.course = 1 and mc.module = 15
		GROUP BY mp.name", $db);
echo $OUTPUT->header(); 

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
<input type="submit" name="subir" value="Subir"/>
</form>
<?php 
echo $OUTPUT->footer();
?>
