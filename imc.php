<?php
// Config de la pagina
require_once (dirname ( __FILE__ ) . '/conf.php');
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
// Capabilities
if (has_capability ( 'local/wellness:seebutton', $context )) {
	require_once ('forms/add_imc_form.php');
	
	$addform = new add_imc_form ();
	
	if ($addform->is_cancelled ()) {
		$url = 'imc.php';
		redirect ( $url );
		echo get_string ( 'formcancel', 'local_wellness' );
		die ();
	} else if ($fromform = $addform->get_data ()) {
		$email = $fromform->email;
		$ano = $fromform->ano;
		$estatura = $fromform->estatura;
		$peso = $fromform->peso;
		$imc = $peso / (($estatura * $estatura) / 10000);
		
		$newimc = new stdClass ();
		$newimc->email = $email;
		$newimc->ano = $ano;
		$newimc->estatura = $estatura;
		$newimc->peso = $peso;
		$newimc->imc = $imc;
		$subir = $DB->insert_record ( "imc", $newimc, false );
		if ($subir) {
			echo get_string ( 'agrexito', 'local_wellness' );
		} else {
			echo get_string ( 'erroroc', 'local_wellness' );
			$addform->display ();
		}
	} else {
		$addform->display ();
	}
	
	require_once ('forms/search_imc_form.php');
	$formsearch = new search_imc_form ();
	
	if ($formsearch->is_cancelled ()) {
		$url = 'imc.php';
		redirect ( $url );
		echo get_string ( 'formcancel', 'local_wellness' );
		die ();
	}
	if ($datasearch = $formsearch->get_data ()) {
		$email = $datasearch->email;
		$result = $DB->get_records_sql ( "SELECT * FROM `mdl_imc` WHERE `email`=?", array (
				$email 
		) );
		
		$table = new html_table ();
		$table->head = array (
				get_string ( 'ano', 'local_wellness' ),
				get_string ( 'estatura', 'local_wellness' ),
				get_string ( 'peso', 'local_wellness' ),
				get_string ( 'imcm', 'local_wellness' ) 
		);
		foreach ( $result as $records ) {
			
			$ano = $records->ano;
			$imc = $records->imc;
			$estatura = $records->estatura;
			$peso = $records->peso;
			$table->data [] = array (
					$ano,
					$estatura,
					$peso,
					$imc 
			);
		}
		echo html_writer::table ( $table );
	} else {
		$formsearch->display ();
	}
}
//End Capabilities

else {
	//Tabla de IMC
	$result = $DB->get_records_sql ( "SELECT * FROM `mdl_imc` WHERE `email`=?", array (
			$usermail
	) );
	
	$tableu = new html_table ();
	$tableu->head = array (
			get_string ( 'ano', 'local_wellness' ),
			get_string ( 'estatura', 'local_wellness' ),
			get_string ( 'peso', 'local_wellness' ),
			get_string ( 'imcm', 'local_wellness' )
	);
	foreach ( $result as $records ) {
			
		$ano = $records->ano;
		$imc = $records->imc;
		$estatura = $records->estatura;
		$peso = $records->peso;
		$tableu->data [] = array (
				$ano,
				$estatura,
				$peso,
				$imc
		);
	}
	echo html_writer::table ( $tableu );
	
	if($result=NULL){
		echo html_writer::tag ( 'p', '<h1>'.get_string('noimc','local_wellness').'</h1>');
	}
}
echo "<img src='http://www.deporlovers.com/wp-content/uploads/2015/12/%C3%ADndice-de-masa-corporal.jpg'>";
?>
  </body>
</html>
<?php
// Footer
echo $OUTPUT->footer ();
?>