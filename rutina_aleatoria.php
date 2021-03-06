﻿<?php
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
		$intensidada = $formsend->intensidad;
		echo html_writer::tag ( 'p', '<h1>Has elegido una rutina de nivel <u>'.$intensidada.'</u></h1>' );
		echo html_writer::tag ( 'p', '<h4>'.get_string('calentamiento','local_wellness').'</h4>');	
		
		// Tabla de calentamiento		
		//esto se hace haciendo 5 tablas diferentes, una de calentamiento donde muestres todos los calentamientos, despues las demas pero 5 diferentes separadas con titulo
		$ej = $DB->get_recordset_sql ( "SELECT `id`, `nombre`, `link_video`, `categoria`, `intensidad`, `zona`, `rep1`, `rep2`, `rep3`, `rep4`, `rep5` FROM `mdl_ejercicios` WHERE `categoria` = 'Calentamiento' GROUP BY `nombre`" );
		$table = new html_table ();
		$table->head = array (
				get_string ( 'opejercicio', 'local_wellness' ),
				get_string ( 'zona', 'local_wellness' ),
				get_string ( 'duracion', 'local_wellness' ),
				get_string ( 'linkvid', 'local_wellness' ) 
		);
		foreach ( $ej as $records ) {
			$nombre = $records->nombre;
			$zona = $records->zona;
			$rep1 = $records->rep1;
			$link = $records->link_video;
			$table->data [] = array (
					$nombre,
					$zona,
					$rep1,
					'<a href="' . $link . '">Ver Video</a>' 
			);
		}
		
		echo html_writer::table ( $table );
		
		$ej->close ();
		//Tabla de trabajo espec�fico		
		echo html_writer::tag ( 'p', '<h4>'.get_string('trabajoesp','local_wellness').'</h4>');
		echo html_writer::tag ( 'p', '<h4>'.get_string('infopesos','local_wellness').'</h4>');
		echo html_writer::tag ( 'p', '<h5><u>Trabajo General:</u></h5>' );
		$ej1 = $DB->get_recordset_sql ( "SELECT * FROM `mdl_ejercicios`
									     WHERE `intensidad`=? 
										 AND `categoria`='Trabajo General'
										 AND `zona` LIKE '%ant%' 
										 OR `zona` LIKE '%pos%'
										 ORDER BY RAND() LIMIT 2", array (
				$intensidada
		) );
		$tableespecifico = new html_table ();
		$tableespecifico->head = array (
				get_string ( 'ejercicio', 'local_wellness' ),
				get_string ( 'zona', 'local_wellness' ),
				get_string ( 'rep1', 'local_wellness' ),
				get_string ( 'rep2', 'local_wellness' ),
				get_string ( 'rep3', 'local_wellness' ),
				get_string ( 'rep4', 'local_wellness' ),
				get_string ( 'rep5', 'local_wellness' ),
				get_string ( 'linkvid', 'local_wellness' )
		);
		foreach ( $ej1 as $records ) {
			$nombre = $records->nombre;
			$zona = $records->zona;
			$rep1 = $records->rep1;
			$rep2 = $records->rep2;
			$rep3 = $records->rep3;
			$rep4 = $records->rep4;
			$rep5 = $records->rep5;
			$link = $records->link_video;
			$tableespecifico->data [] = array (
					$nombre,
					$zona,
					$rep1,
					$rep2,
					$rep3,
					$rep4,
					$rep5,
					'<a href="' . $link . '">Ver Video</a>'
			);
		}
		$ej1->close ();
		echo html_writer::table ( $tableespecifico );
		//Tabla de fuerza/resistencia
		echo html_writer::tag ( 'p', '<h5><u>Fuerza/Resistencia:</u></h5>' );
		$ej2 = $DB->get_recordset_sql ( "SELECT * FROM `mdl_ejercicios`
									     WHERE `intensidad`=?
										 AND `categoria`='Fuerza/Resistencia'
										 ORDER BY RAND() LIMIT 1", array (
												 		$intensidada
												 ) );
		$tablefuerza = new html_table ();
		$tablefuerza->head = array (
				get_string ( 'ejercicio', 'local_wellness' ),
				get_string ( 'zona', 'local_wellness' ),
				get_string ( 'rep1', 'local_wellness' ),
				get_string ( 'rep2', 'local_wellness' ),
				get_string ( 'rep3', 'local_wellness' ),
				get_string ( 'rep4', 'local_wellness' ),
				get_string ( 'rep5', 'local_wellness' ),
				get_string ( 'linkvid', 'local_wellness' )
		);
		foreach ( $ej2 as $records ) {
			$nombre = $records->nombre;
			$zona = $records->zona;
			$rep1 = $records->rep1;
			$rep2 = $records->rep2;
			$rep3 = $records->rep3;
			$rep4 = $records->rep4;
			$rep5 = $records->rep5;
			$link = $records->link_video;
			$tablefuerza->data [] = array (
					$nombre,
					$zona,
					$rep1,
					$rep2,
					$rep3,
					$rep4,
					$rep5,
					'<a href="' . $link . '">Ver Video</a>'
			);
		}
		
		$ej2->close ();
		echo html_writer::table ( $tablefuerza );
		
		//Tabla de aerobicos
		echo html_writer::tag ( 'p', '<h5><u>Aeróbico:</u></h5>' );
		$ej3 = $DB->get_recordset_sql ( "SELECT * FROM `mdl_ejercicios`
									     WHERE `intensidad`=?
										 AND `categoria`='Aeróbico'
										 ORDER BY RAND() LIMIT 1", array (
												 		$intensidada
												 ) );
		$tableaero = new html_table ();
		$tableaero->head = array (
				get_string ( 'ejercicio', 'local_wellness' ),
				get_string ( 'zona', 'local_wellness' ),
				get_string ( 'rep1', 'local_wellness' ),
				get_string ( 'rep2', 'local_wellness' ),
				get_string ( 'rep3', 'local_wellness' ),
				get_string ( 'rep4', 'local_wellness' ),
				get_string ( 'rep5', 'local_wellness' ),
				get_string ( 'linkvid', 'local_wellness' )
		);
		foreach ( $ej3 as $records1 ) {
			$nombre = $records1->nombre;
			$zona = $records1->zona;
			$rep1 = $records1->rep1;
			$rep2 = $records1->rep2;
			$rep3 = $records1->rep3;
			$rep4 = $records1->rep4;
			$rep5 = $records1->rep5;
			$link = $records1->link_video;
			$tableaero->data [] = array (
					$nombre,
					$zona,
					$rep1,
					$rep2,
					$rep3,
					$rep4,
					$rep5,
					'<a href="' . $link . '">Ver Video</a>'
			);
			
		}
		
		$ej3->close ();
		echo html_writer::table ( $tableaero );
		
		//Tabla CORE
		echo html_writer::tag ( 'p', '<h4>'.get_string('core','local_wellness').'</h4>');
		$ej4 = $DB->get_recordset_sql ( "SELECT * FROM `mdl_ejercicios`
									     WHERE `intensidad`=?
										 AND `categoria`='Core'
										 ORDER BY RAND() LIMIT 1
										 ", array (
												 		$intensidada
												 ) );
		$tablecore = new html_table ();
		$tablecore->head = array (
				get_string ( 'opejercicio', 'local_wellness' ),
				get_string ( 'zona', 'local_wellness' ),
				get_string ( 'rep1', 'local_wellness' ),
				get_string ( 'rep2', 'local_wellness' ),
				get_string ( 'rep3', 'local_wellness' ),
				get_string ( 'rep4', 'local_wellness' ),
				get_string ( 'rep5', 'local_wellness' ),
				get_string ( 'linkvid', 'local_wellness' )
		);
		foreach ( $ej4 as $records ) {
			$nombre = $records->nombre;
			$zona = $records->zona;
			$rep1 = $records->rep1;
			$rep2 = $records->rep2;
			$rep3 = $records->rep3;
			$rep4 = $records->rep4;
			$rep5 = $records->rep5;
			$link = $records->link_video;
			$tablecore->data [] = array (
					$nombre,
					$zona,
					$rep1,
					$rep2,
					$rep3,
					$rep4,
					$rep5,
					'<a href="' . $link . '">Ver Video</a>'
			);
		}
		
		$ej4->close ();
		echo html_writer::table ( $tablecore );
		
		echo html_writer::tag ( 'p', '<h4>'.get_string('vueltacalma','local_wellness').'</h4>');
		
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
		echo html_writer::tag ( 'p', get_string ( 'repnivel', 'local_wellness' ) );
		echo html_writer::table ( $table_rep );
		echo html_writer::tag ( 'a', get_string ( 'volver', 'local_wellness' ), array (
				'class' => 'btn',
				'onClick' => 'history.back();return true;'
		) );
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
				echo html_writer::tag ( 'br', '' );
				echo html_writer::tag ( 'a', get_string ( 'volver', 'local_wellness' ), array (
						'class' => 'btn',
						'onClick' => 'history.back();return true;'
				) );
				echo html_writer::tag ( 'br', '' );
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