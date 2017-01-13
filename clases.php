<?php
//Config de la pagina
require_once (dirname ( __FILE__ ) . '/conf.php');
$params = array ();
$PAGE->set_context ( $context );
$PAGE->set_url ( '/local/wellness/clases.php', $params );
$PAGE->set_pagelayout ( 'mydashboard' );
$PAGE->set_pagetype ( 'local-clases-index' );
$PAGE->blocks->add_region ( 'content' );
$PAGE->set_subpage ( $currentpage->id );
$PAGE->set_title ( get_string ( 'navclases', 'local_wellness' ) );
$PAGE->set_heading ( $header );
$PAGE->navbar->add ( get_string ( 'navclases', 'local_wellness' ), new moodle_url ( '/local/wellness/clases.php' ) );

//Header
echo $OUTPUT->header ();

//Capabilities para botones
if (has_capability ( "local/wellness:seebutton", $context )) {
	echo "<form action='../wellness/formulariofoto.php' method='POST'>";
	echo "<input type='submit' style='clear: left' name='Agregar' value='Agregar foto a clase'>";
	echo "<input type='submit' name='Cambiar' value='Cambiar foto a clase'>";
	echo "</form>";
}

//Query para las clases
$result = mysql_query ( "SELECT DISTINCT mcm.* , mc.* FROM mdl_course_modules as mcm
		INNER JOIN mdl_course as mc ON mcm.course = mc.id
		WHERE mcm.module = 9
		GROUP BY mc.fullname", $db );

if (! $result) {
	die ( "Error en la peticion SQL: " . mysql_error () );
}
$resultfoto = mysql_query ( "SELECT DISTINCT mc.* , pp.* FROM mdl_course as mc INNER JOIN imagenes as pp ON mc.fullname = pp.nombre", $db );

//Mostrar clases
$clases = array ();
$fotos = array ();
while ( $clase = mysql_fetch_assoc ( $result ) ) {
	$clases [] = $clase;
}
while ( $foto = mysql_fetch_assoc ( $resultfoto ) ) {
	$fotos [] = $foto;
}
foreach ( $clases as $clase ) {
	foreach ( $fotos as $foto ) {
		if ($clase ['fullname'] == $foto ['nombre']) {
			echo '<div class="img">';
			echo "<a href='/../../moodle/course/view.php?id=" . $clase ['course'] . "'>";
			echo "<img  src='/../../moodle/local/wellness/imagen.php?nombre=" . $clase ['fullname'] . "' alt=" . $clase ['fullname'] . "></img></a>";
			echo '<div class="desc">' . $clase ['fullname'] . '</div></div>';
		}
	}
}

//Footer
echo $OUTPUT->footer ();
?>
	
	