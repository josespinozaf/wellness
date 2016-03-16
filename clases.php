<link rel="stylesheet" type="text/css" href="style.css" media="screen">
<?php
global $USER, $CFG;
require_once(dirname(__FILE__) . '/../../config.php');
require_once($CFG->dirroot . '/my/lib.php');
include ("connect.php");

$userid= $USER->id;
$usermail= $USER->email;

echo $OUTPUT->header();

$result = mysql_query("SELECT DISTINCT mp.* , mc.* FROM mdl_course_modules as mc
		INNER JOIN mdl_page as mp ON mc.course = mp.course AND mc.instance = mp.id
		WHERE mp.course = 1 and mc.module = 15
		GROUP BY mp.name", $db);

if (!$result) {
	die("Error en la peticion SQL: " . mysql_error());
}
$resultfoto = mysql_query("SELECT DISTINCT mp.* , pp.* FROM mdl_page as mp INNER JOIN page_pix as pp ON mp.id = pp.pageid", $db);
$clases = array();
$fotos = array();
while ($clase =  mysql_fetch_assoc($result))
{
	$clases[] = $clase;
}
while ($foto =  mysql_fetch_assoc($resultfoto))
{
	$fotos[] = $foto;
}
foreach ($clases as $clase)
{
	foreach ($fotos as $foto)
	{
	if 	($clase['name'] == $foto['name']){	
		echo '<div class="img">';	
		echo "<a href='/../../moodle/mod/page/view.php?id=".$clase['id']."'>";
		echo "<img  src=".$foto['pix']."  alt=".$clase['name']."></img></a>";
		echo '<div class="desc">'.$clase['name'].'</div></div>';
	}
	}
}
		?>
		
		<?php 
echo $OUTPUT->footer();
	?>