<?php
// Config de la pagina
require_once (dirname ( __FILE__ ) . '/pruebaconnect.php');
$params = array ();
$PAGE->set_context ( $context );
$PAGE->set_url ( '/local/wellness/imc.php', $params );
$PAGE->set_pagelayout ( 'mydashboard' );
$PAGE->set_pagetype ( 'local-wellness-imc' );
$PAGE->blocks->add_region ( 'content' );
$PAGE->set_subpage ( $currentpage->id );
$PAGE->set_title ( get_string ( 'navimc', 'local_wellness' ) );
$PAGE->set_heading ( $header );
$PAGE->navbar->add ( get_string ( 'navimc', 'local_wellness' ), new moodle_url ( '/local/wellness/imc.php' ) );

// Header
echo $OUTPUT->header ();

?>
<html>
<head>
</head>
<body>
<?php
$result = $DB->get_recordset_sql ( "SELECT DISTINCT mc.* , im.*, cm.instance, mc.id FROM mdl_course_modules as cm
		INNER JOIN mdl_course as mc ON cm.instance = mc.id-3
		INNER JOIN mdl_imagenes as im ON mc.fullname = im.nombre
		WHERE cm.module = 9
		GROUP BY mc.id" );

foreach ( $result as $rs ) {
	$imagen = $rs->imagen;
	echo '<div class="img">';
	echo "<a href='../../course/view.php?id=" . $rs->id . "'>";
	echo '<img src="data:image/jpeg;base64,' . base64_encode ( $imagen ) . '"/></img></a>';
	echo '<div class="desc">' . $rs->fullname . '</div></div>';
}

$result->close ();
?>
  </body>
</html>
<?php
// Footer
echo $OUTPUT->footer ();
?>