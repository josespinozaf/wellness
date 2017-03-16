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

//Capabilities para botones
if (has_capability ( "local/wellness:seebutton", $context )) {
	// Inicio de formulario para agregar foto
	require_once ('forms/formulariofoto_form.php');
	$formadd = new formulariofoto_form ();
	// Url para redirección
	$url = 'clases.php';
	if ($formadd->is_cancelled ()) {
		die ();
	}
	$nombre_imagen = $formadd->get_new_filename ( 'imagen' );
	$imagen = $formadd->get_file_content ( 'imagen' );
	if ($dataadd = $formadd->get_data ()) {
		$nombre = $dataadd->selectclases;
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
	// Inicio de formulario para editar foto
	require_once ('forms/formulariofotoeditar_form.php');

	$formedit = new formulariofotoeditar_form ();
	$nombre_imagen1 = $formedit->get_new_filename ( 'imagen' );
	$imagen = $formedit->get_file_content ( 'imagen' );
	if ($dataedit = $formedit->get_data ()) {
		$nombre = $dataedit->selectclases;
		$sql = "UPDATE `mdl_imagenes` SET `imagen`=?,`nombre_imagen`=?
	 			WHERE `nombre`=?";
		$update = $DB->execute ( $sql, array (
				$imagen,
				$nombre_imagen1,
				$nombre
		) );
		if (! $update) {
			echo get_string ( 'imgerror', 'local_wellness' );
			redirect ( $url );
			die ();
		} else {
			echo get_string ( 'imgactexito', 'local_wellness' ) . $nombre_imagen1;
			redirect ( $url );
			die ();
		}
	} else {
		$formedit->display ();
	}
}
// Query para las clases
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
// Footer
echo $OUTPUT->footer ();
?>
	
	