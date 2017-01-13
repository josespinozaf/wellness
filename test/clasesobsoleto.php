<?php 
require_once (dirname ( __FILE__ ) . '/conf.php');
$params = array();
$PAGE->set_context($context);
$PAGE->set_url('/local/wellness/clases.php', $params);
$PAGE->set_pagelayout('mydashboard');
$PAGE->set_pagetype('local-clases-index');
$PAGE->blocks->add_region('content');
$PAGE->set_subpage($currentpage->id);
$PAGE->set_title('Clases');
$PAGE->set_heading($header);
$PAGE->navbar->add(get_string('navclases','local_wellness'), new moodle_url('/local/wellness/clases.php'));

$userid= $USER->id;
$usermail= $USER->email;



echo $OUTPUT->header();

if(has_capability("local/wellness:seebutton", $context) ){
	echo "<form action='/local/wellness/formulariofoto.php' method='POST'>";
	echo "<input type='submit' style='clear: left' name='Agregar' value='Agregar foto a clase'>";
	echo "<input type='submit' name='Cambiar' value='Cambiar foto a clase'>";
	echo "</form>";
}

$result = mysql_query("SELECT DISTINCT mp.* , mc.* FROM mdl_course_modules as mc
		INNER JOIN mdl_page as mp ON mc.course = mp.course AND mc.instance = mp.id
		WHERE mp.course = 4 and mc.module = 15
		GROUP BY mp.name", $db);

if (!$result) {
	die("Error en la peticion SQL: " . mysql_error());
}
$resultfoto = mysql_query("SELECT DISTINCT mp.* , pp.* FROM mdl_page as mp INNER JOIN imagenes as pp ON mp.name = pp.nombre", $db);
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
		echo "<img  src='/../../moodle/local/wellness/imagen.php?nombre=".$clase['name']."' alt=".$clase['name']."></img></a>";
		echo '<div class="desc">'.$clase['name'].'</div></div>';
	}
	}
} 

echo $OUTPUT->footer();
	?>
	
	