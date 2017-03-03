<?php
// Config de la pagina
require_once (dirname ( __FILE__ ) . '/conf.php');
require_once ('servicio.php');
$params = array ();
$PAGE->set_context ( $context );
$PAGE->set_url ( '/local/wellness/misasistencias.php', $params );
$PAGE->set_pagelayout ( 'mydashboard' );
$PAGE->set_pagetype ( 'local-wellness-imc' );
$PAGE->blocks->add_region ( 'content' );
$PAGE->set_subpage ( $currentpage->id );
$PAGE->set_title ( get_string ( 'navasistencias', 'local_wellness' ) );
$PAGE->set_heading ( $header );
$PAGE->navbar->add ( get_string ( 'navasistencias', 'local_wellness' ), new moodle_url ( '/local/wellness/misasistencias.php' ) );

// Header
echo $OUTPUT->header ();
echo html_writer::tag ( 'h4', get_string('navasistencias','local_wellness'));
$table = new html_table ();
$table->head = array (
		get_string ( 'fecha', 'local_wellness' ),
		get_string ( 'horainicio', 'local_wellness' ),
		get_string ( 'horatermino', 'local_wellness' ),
		get_string ( 'actividad', 'local_wellness' ),
		get_string ( 'asistencia', 'local_wellness' )
);

echo "Tienes ".$decoded['asistenciasValidas']." asistencias validas.";
foreach($decoded['asistencias'] as $valor){
	foreach($valor as $as){
		list($fechainicio, $horainicio) = explode("T", $as['HoraInicio']);
		list($fechatermino, $horatermino) = explode("T", $as['HoraTermino']);
		$actividad = $as['Deporte'];
		if($as['IsCastigo']==1){
			$asistencia= get_string ( 'fafacross', 'local_wellness' );
		}else{
			$asistencia= get_string ( 'fafacheck', 'local_wellness' );
		}
		$table->data [] = array (
				$fechainicio,
				$horainicio,
				$horatermino,
				$actividad,
				$asistencia
		);
	}
}
echo html_writer::table ( $table );
echo $OUTPUT->footer();
?>