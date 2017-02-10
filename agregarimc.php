<?php
//Configuracion de la pagina
require_once (dirname ( __FILE__ ) . '/conf.php');
$params = array();
$PAGE->set_context($context);
$PAGE->set_url('/local/wellness/imc.php', $params);
$PAGE->set_pagelayout('mydashboard');
$PAGE->set_pagetype('local-wellness-imc');
$PAGE->blocks->add_region('content');
$PAGE->set_subpage($currentpage->id);
$PAGE->set_title(get_string('imcs','local_wellness'));
$PAGE->set_heading($header);
$PAGE->navbar->add(get_string('imcs','local_wellness'), new moodle_url('/local/wellness/imc.php'));

//Header
echo $OUTPUT->header ();

if(has_capability('local/wellness:seebutton', $context)){
	require_once('forms/add_imc_form.php');
	$addform= new add_imc_form();
	
	if ($addform->is_cancelled()){
		$url='imc.php';
		redirect($url);
		echo 'El formulario se ha cancelado.';
		die;		
	}
	
	else if($fromform= $addform->get_data()){
		// 				print_r($fromform);
		$email=$fromform->email;
		$ano=$fromform->ano;
		$estatura=$fromform->estatura;
		$peso=$fromform->peso;
		$imc=$peso/(($estatura*$estatura)/10000);
			
		$newimc = new stdClass();
		$newimc->email         = $email;
		$newimc->ano		   = $ano;
		$newimc->estatura	   = $estatura;
		$newimc->peso		   = $peso;
		$newimc->imc		   = $imc;
		$subir = $DB->insert_record("imc", $newimc, false);
		if($subir){
			echo "Se ha ingresado exitosamente.";
		}
		else{
			echo "Error con base de datos.";
			$addform->display();
		}
	}
	else{
		$addform->display();
	}
}
echo "<img src='http://www.deporlovers.com/wp-content/uploads/2015/12/%C3%ADndice-de-masa-corporal.jpg'>";
?>
  </body>
</html>
<?php
echo $OUTPUT->footer();
?>