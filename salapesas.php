<?php

// Configuracion de la pagina
require_once (dirname ( __FILE__ ) . '/conf.php');
$params = array ();
$PAGE->set_context ( $context );
$PAGE->set_url ( '/local/wellness/salapesas.php', $params );
$PAGE->set_pagelayout ( 'mydashboard' );
$PAGE->set_pagetype ( 'local-salapesas-index' );
$PAGE->blocks->add_region ( 'content' );
$PAGE->set_subpage ( $currentpage->id );
$PAGE->set_title ( get_string ( 'navsalapesas', 'local_wellness' ) );
$PAGE->set_heading ( $header );
$PAGE->navbar->add ( get_string ( 'navsalapesas', 'local_wellness' ), new moodle_url ( '/local/wellness/salapesas.php' ) );

// Header
echo $OUTPUT->header ();

// Capabilities
if (has_capability ( "local/wellness:seebutton", $context )) {
	$url = 'salapesas.php';
	//boton al banco de rutinas
	echo html_writer::link ( '/mod/page/view.php?id=2', 'Editar rutinas sala de pesas', array (
			'class' => 'btn',
			'id' => 'editar_rutina',
			'name' => 'editar_rutina'
	), null ) . " ";
	
	// incluir formularios
	require_once ('forms/formulariofotorutinas_form.php');
	require_once ('forms/formulariofotorutinaseditar_form.php');
	
	// Crear instancias
	
	$formadd = new formulariofotorutinas_form ();
	$nombre_imagen = $formadd->get_new_filename ( 'imagen' );
	$imagen = $formadd->get_file_content ( 'imagen' );
	if ($dataadd = $formadd->get_data ()) {
		$nombre = $dataadd->selectrutinas;
		$newimg = new stdClass ();
		$newimg->nombre = $nombre;
		$newimg->imagen = $imagen;
		$newimg->nombre_imagen = $nombre_imagen;
		$subir = $DB->insert_record ( 'imagenes', $newimg );
		if ($subir) {
			echo get_string ( 'imgexito', 'local_wellness' ) . $nombre_imagen;
			redirect ( $url );
			die ();
		} else {
			echo get_string ( 'erroroc', 'local_wellness' );
			$formadd->display ();
		}
	} else {
		$formadd->display ();
	}
	
	$formeditar = new formulariofotorutinaseditar_form ();
	$nombre_imagen1 = $formeditar->get_new_filename ( 'imagen' );
	$imagen = $formeditar->get_file_content ( 'imagen' );
	if ($dataeditar = $formeditar->get_data ()) {
		$nombre = $dataeditar->selectrutinas;
		$sql = "UPDATE `imagenes` SET `imagen`=?,`nombre_imagen`=?
	 			WHERE `nombre`=?";
		$update = $DB->execute ( $sql, array (
				$imagen,
				$nombre_imagen1,
				$nombre 
		) );
		if (! $update) {
			echo get_string ( 'imgerror', 'local_wellness' );
			die ();
		} else {
			echo get_string ( 'imgactexito', 'local_wellness' ) . $nombre_imagen1;
			redirect ( $url );
			die ();
		}
	} else {
		$formeditar->display ();
	}
}
// Query
$result = $DB->get_recordset_sql ( "SELECT DISTINCT mp.* , im.*, cm.instance, cm.id FROM mdl_course_modules as cm
		INNER JOIN mdl_page as mp ON cm.instance = mp.id
		INNER JOIN mdl_imagenes as im ON mp.name = im.nombre
		WHERE mp.course = 2
		GROUP BY mp.name" );

foreach ( $result as $rs ) {
	$imagen = $rs->imagen;
	echo '<div class="img">';
	echo "<a href='../../mod/page/view.php?id=" . $rs->id . "'>";
	echo '<img src="data:image/jpeg;base64,' . base64_encode ( $imagen ) . '"/></img></a>';
	echo '<div class="desc">' . $rs->name . '</div></div>';
}

$result->close ();
// Footer
echo $OUTPUT->footer ();
?>