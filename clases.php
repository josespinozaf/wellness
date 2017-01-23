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
$result = $DB->get_recordset_sql("SELECT DISTINCT mc.* , pp.* FROM mdl_course as mc INNER JOIN imagenes as pp ON mc.fullname = pp.nombre");

foreach ($result as $rs){
			echo '<div class="img">';
			echo "<a href='/../../moodle/course/view.php?id=".$rs->id."'>";
			echo "<img  src='/../../moodle/local/wellness/imagen.php?nombre=".$rs->fullname."' alt=". $rs->fullname."></img></a>";
			echo '<div class="desc">'.$rs->fullname.'</div></div>';
		}
$result->close();

//Footer
echo $OUTPUT->footer ();
?>
	
	