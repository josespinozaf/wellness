<?php

//Configuracion de la pagina
require_once (dirname ( __FILE__ ) . '/conf.php');
$params = array();
$PAGE->set_context($context);
$PAGE->set_url('/local/wellness/salapesas.php', $params);
$PAGE->set_pagelayout('mydashboard');
$PAGE->set_pagetype('local-salapesas-index');
$PAGE->blocks->add_region('content');
$PAGE->set_subpage($currentpage->id);
$PAGE->set_title('Rutinas');
$PAGE->set_heading($header);
$PAGE->navbar->add(get_string('navrutinas','local_wellness'), new moodle_url('/local/wellness/salapesas.php'));

//Header
echo $OUTPUT->header ();

//Capabilities
if(has_capability("local/wellness:seebutton", $context) ){

	//include simplehtml_form.php
	require_once('forms/buttons_form.php');
	require_once('forms/formulariofotorutinas_form.php');
	
	//Instantiate simplehtml_form
	$mform = new buttons_form();
	
	if ($data = $mform->get_data()) {
		$submitagregar= $data->submitagregar;
		$submiteditar= $data->submiteditar;
		if(isset($submitagregar)){
			$formadd = new formulariofotorutinas_form();
			if ($dataadd = $formadd->get_data()){
				$nombre= $dataadd->selectrutinas;
				$imagen= $dataadd->imagen;
					
			}else{
				$formadd->display();
			}
		}
		if (isset($submiteditar)){
			$formeditar= new formulariofotorutinas_form();
			if ($dataeditar = $formeditar->get_data()){
				$nombre= $dataeditar->selectrutinas;
				$imagen= $dataeditar->imagen;
					
			}else{
				$formeditar->display();
			}
		}
	}
	else{
		$mform->set_data($toform);
	
		$mform->display();
	}
}

// //Query
// $resultfoto = $DB->get_recordset_sql("SELECT DISTINCT mp.* , pp.* FROM mdl_page as mp INNER JOIN imagenes as pp ON mp.name = pp.nombre");

// $result = $DB->get_recordset_sql("SELECT DISTINCT mp.* , mc.* FROM mdl_course_modules as mc
// 		INNER JOIN mdl_page as mp ON mc.course = mp.course AND mc.instance = mp.id
// 		WHERE mp.course = 5 and mc.module = 15
// 		GROUP BY mp.name");

$result = $DB->get_recordset_sql("SELECT DISTINCT mp.* , im.*, cm.instance, cm.id FROM mdl_course_modules as cm
		INNER JOIN mdl_page as mp ON cm.instance = mp.id
		INNER JOIN mdl_imagenes as im ON mp.name = im.nombre
		WHERE mp.course = 5
		GROUP BY mp.name");



foreach ($result as $rs)
{
	$imagen = $rs->imagen;
 	echo '<div class="img">';
 	echo "<a href='../../mod/page/view.php?id=".$rs->id."'>";
//	echo "<img src='/../../moodle/local/wellness/imagen.php?nombre=".$rs->name."' alt=". $rs->name."></img></a>";
	echo '<img src="data:image/jpeg;base64,'.base64_encode( $imagen ).'"/></img></a>';
// 	<img src="data:image/jpeg;base64,'.base64_encode( $imagen ).'"/>
 	echo '<div class="desc">'.$rs->name.'</div></div>';
		
}

$result->close();

echo $OUTPUT->footer();
?>