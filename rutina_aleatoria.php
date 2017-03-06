<?php
// Configuracion de la pagina
require_once (dirname ( __FILE__ ) . '/conf.php');
$params = array ();
$PAGE->set_context ( $context );
$PAGE->set_url ( '/local/wellness/rutina_aleatoria.php', $params );
$PAGE->set_pagelayout ( 'mydashboard' );
$PAGE->set_pagetype ( 'local-wellness-rutina aleatoria' );
$PAGE->blocks->add_region ( 'content' );
$PAGE->set_subpage ( $currentpage->id );
$PAGE->set_title ( get_string ( 'navrutinaaleatoria', 'local_wellness' ) );
$PAGE->set_heading ( $header );
$PAGE->navbar->add ( get_string ( 'navrutinaaleatoria', 'local_wellness' ), new moodle_url ( '/local/wellness/rutina_aleatoria.php' ) );

// Header
echo $OUTPUT->header ();
$url = 'rutina_aleatoria.php';
// Capabilities
if (! has_capability ( 'local/wellness:seebutton', $context )) {
	require_once ('forms/rutinaaleatoria_form.php');
	
	$form = new rutinaaleatoria_form ();
	
	if ($form->is_cancelled ()) {
		redirect ( $url );
		die ();
	}
	if ($formsend = $form->get_data ()) {
		echo html_writer::tag ( 'p', '<h4>Rutina Aleatoria</h4>' );
		echo html_writer::tag ( 'p', get_string('calentamiento','local_wellness'));
		$intensidad = $formsend->intensidad;
		$categoria = $formsend->categoria;
		// Tabla con rutina aleatoria
		
		//esto se hace haciendo 5 tablas diferentes, una de calentamiento donde muestres todos los calentamientos, despues las demas pero 5 diferentes separadas con titulo
		$ej = $DB->get_recordset_sql ( "SELECT * FROM `mdl_ejercicios` WHERE `intensidad`=? AND `categoria`=? ORDER BY RAND() LIMIT 4", array (
				$intensidad,
				$categoria 
		) );
		$table = new html_table ();
		$table->head = array (
				get_string ( 'calentamiento', 'local_wellness' ),
				get_string ( 'intensidad', 'local_wellness' ),
				get_string ( 'tren', 'local_wellness' ),
				get_string ( 'linkvid', 'local_wellness' ) 
		);
		foreach ( $ej as $records ) {
			$nombre = $records->nombre;
			$intensidad = $records->intensidad;
			$categoria = $records->categoria;
			$link = $records->link_video;
			$table->data [] = array (
					$nombre,
					$intensidad,
					$categoria,
					'<a href="' . $link . '">Ver Video</a>' 
			);
		}
		echo html_writer::table ( $table );
		echo html_writer::tag ( 'p', get_string('core','local_wellness'));
		echo html_writer::tag ( 'p', get_string('vueltacalma','local_wellness'));
		echo html_writer::tag ( 'p', get_string ( 'repnivel', 'local_wellness' ) );
		echo html_writer::tag ( 'a', get_string ( 'volver', 'local_wellness' ), array (
				'class' => 'btn',
				'onClick' => 'history.back();return true;' 
		) );
		
		// Tabla de trabajo según %
		$table_rep = new html_table ();
		$table_rep->head = array (
				get_string ( 'entrenamiento', 'local_wellness' ),
				get_string ( 'peso', 'local_wellness' ),
				get_string ( 'porcentaje', 'local_wellness' ),
				get_string ( 'repeticiones', 'local_wellness' ),
				get_string ( 'series', 'local_wellness' ),
				get_string ( 'descanso', 'local_wellness' ) 
		);
		$table_rep->data [] = array (
				get_string ( 'resistencia', 'local_wellness' ),
				get_string ( 'ligero', 'local_wellness' ),
				get_string ( 'cinsenpor', 'local_wellness' ),
				get_string ( 'doceaveinte', 'local_wellness' ),
				get_string ( 'tresacuatro', 'local_wellness' ),
				get_string ( 'veinteatreinta', 'local_wellness' ) 
		);
		$table_rep->data [] = array (
				get_string ( 'hipertrofia', 'local_wellness' ),
				get_string ( 'moderado', 'local_wellness' ),
				get_string ( 'setochpor', 'local_wellness' ),
				get_string ( 'ochoadoce', 'local_wellness' ),
				get_string ( 'tresacuatro', 'local_wellness' ),
				get_string ( 'treintaanoventa', 'local_wellness' ) 
		);
		$table_rep->data [] = array (
				get_string ( 'fuerza', 'local_wellness' ),
				get_string ( 'pesado', 'local_wellness' ),
				get_string ( 'ochciepor', 'local_wellness' ),
				get_string ( 'dosaseis', 'local_wellness' ),
				get_string ( 'unoaseis', 'local_wellness' ),
				get_string ( 'cientovadoscua', 'local_wellness' ) 
		);
		echo html_writer::table ( $table_rep );
	} else {
		$form->display ();
	}
} else {
	// Tabla de todos los ejercicios
	echo html_writer::link ( '?action=ver', 'Ver todos los ejercicios', array (
			'class' => 'btn',
			'id' => 'ver_ejercicios',
			'name' => 'ver_ejercicios' 
	), null ) . " ";
	$action = @$_GET ['action'];
	if ($action == 'ver') {
		echo html_writer::tag ( 'a', get_string ( 'volver', 'local_wellness' ), array (
				'class' => 'btn',
				'onClick' => 'history.back();return true;' 
		) );
		echo html_writer::tag ( 'br', '' );
		// Datos de la tabla de ejercicios actuales
		$eje = $DB->get_recordset_sql ( "SELECT DISTINCT * FROM `mdl_ejercicios` as e ORDER BY e.intensidad ASC" );
		$table = new html_table ();
		$table->head = array (
				get_string ( 'ejercicio', 'local_wellness' ),
				get_string ( 'intensidad', 'local_wellness' ),
				get_string ( 'categoria', 'local_wellness' ),
				get_string ( 'zona', 'local_wellness' ),
				get_string ( 'rep1', 'local_wellness' ),
				get_string ( 'rep2', 'local_wellness' ),
				get_string ( 'rep3', 'local_wellness' ),
				get_string ( 'rep4', 'local_wellness' ),
				get_string ( 'rep5', 'local_wellness' ),
				get_string ( 'linkvid', 'local_wellness' ) 
		);
		foreach ( $eje as $records ) {
			$nombre = $records->nombre;
			$intensidad = $records->intensidad;
			$categoria = $records->categoria;
			$zona= $records->zona;
			$rep1= $records->rep1;
			$rep2= $records->rep2;
			$rep3= $records->rep3;
			$rep4= $records->rep4;
			$rep5= $records->rep5;
			$link = $records->link_video;
			$table->data [] = array (
					$nombre,
					$intensidad,
					$categoria,
					$zona,
					$rep1,
					$rep2,
					$rep3,
					$rep4,
					$rep5,
					'<a href="' . $link . '">Ver Video</a>' 
			);
		}
		
		echo html_writer::table ( $table );
	} else {
		// formulario para agregar ejercicios
		require_once ('forms/add_ejercicios_form.php');
		
		$formej = new add_ejercicios_form ();
		
		if ($formej->is_cancelled ()) {
			redirect ( $url );
			die ();
		}
		if ($formsendej = $formej->get_data ()) {
			$nombre = $formsendej->nombre;
 			$categoria = $formsendej->categoria;
    		$intensidad = $formsendej->intensidad;
    		$zona = $formsendej->zona;
			$link = $formsendej->link;
			$rep1 = $formsendej->rep1;
			$rep2 = $formsendej->rep2;
			$rep3 = $formsendej->rep3;
			$rep4 = $formsendej->rep4;
			$rep5 = $formsendej->rep5;
			
			$newej = new stdClass ();
			$newej->nombre = $nombre;
			$newej->categoria = $categoria;
			$newej->intensidad = $intensidad;
			$newej->link_video = $link;
			$newej->zona = $zona;
			$newej->rep1 = $rep1;
			$newej->rep2 = $rep2;
			$newej->rep3 = $rep3;
			$newej->rep4 = $rep4;
			$newej->rep5 = $rep5;

			$subir = $DB->insert_record ( "ejercicios", $newej, false );
			if ($subir) {
				echo get_string ( 'agrexito', 'local_wellness' );
			} else {
				echo get_string ( 'erroroc', 'local_wellness' );
				redirect ( $url );
			}
		} else {
			$formej->display ();
		}
		// Formulario para eliminar ejercicio
		require_once ('forms/delete_ejercicios_form.php');
		
		$formdel = new delete_ejercicios_form ();
		
		if ($formdel->is_cancelled ()) {
			redirect ( $url );
			die ();
		}
		if ($formsenddel = $formdel->get_data ()) {
			$nombre = $formsenddel->nombre;
			$delete = $DB->delete_records_select ( 'ejercicios', '`nombre`=?', array (
					$nombre 
			) );
			if ($delete) {
				echo get_string ( 'elimexito', 'local_wellness' );
			} else {
				echo get_string ( 'erroroc', 'local_wellness' );
			}
			redirect ( $url );
		} else {
			$formdel->display ();
		}
	}
}
// Footer
echo $OUTPUT->footer ();
?>



