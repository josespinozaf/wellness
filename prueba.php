<?php
// Config de la pagina
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

// Header
echo $OUTPUT->header ();

// Query para las clases
 $result = $DB->get_recordset_sql ( "SELECT DISTINCT mc.* , cm.* FROM mdl_course_modules as cm
 		INNER JOIN mdl_course as mc ON cm.instance = mc.id-3
 		GROUP BY mc.id" );

//$result = $DB->get_recordset_sql ( "SELECT * FROM mdl_course_modules" );

var_dump($result);
foreach ( $result as $rs ) {
	echo "</br>";
	echo "Nombre:";
	echo $rs->fullname;
	echo "</br>";
	echo "ID number:";
	echo $rs->id;
	echo "</br>";
	echo "Module:";
	echo $rs->module;
	echo "</br>";
	echo "Instance:";
	echo $rs->instance;
	echo "</br>";
	
}

$result->close ();
// Footer
echo $OUTPUT->footer ();
?>