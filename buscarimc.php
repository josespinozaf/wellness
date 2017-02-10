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
	require_once('forms/search_imc_form.php');
	$formsearch = new search_imc_form();
	
	if ($formsearch->is_cancelled()){
		$url='imc.php';
		redirect($url);
		echo 'El formulario se ha cancelado.';
		die;	
	}
	if ($datasearch= $formsearch->get_data()){
		$email=$datasearch->email;
		$result= $DB->get_records_sql("SELECT * FROM `mdl_imc` WHERE `email`=?",array($email));
			
		$table = new html_table();
		$table->head = array('Año', 'Estatura (cm)','Peso (Kg)', 'IMC');
			foreach ($result as $records) {
					
			$ano = $records->ano;
			$imc = $records->imc;
			$estatura = $records->estatura;
			$peso = $records->peso;
			$table->data[] = array($ano, $estatura, $peso, $imc);
		}
	echo html_writer::table($table);
					
}

	else{
			$formsearch->display();
			}
}
 	echo "<img src='http://www.deporlovers.com/wp-content/uploads/2015/12/%C3%ADndice-de-masa-corporal.jpg'>";
 	?>
  </body>
</html>
<?php
echo $OUTPUT->footer();
?>