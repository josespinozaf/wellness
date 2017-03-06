<?php
//moodleform is defined in formslib.php
require_once("$CFG->libdir/formslib.php");

class rutinaaleatoria_form extends moodleform {
	//Add elements to form
	public function definition() {
			global $CFG, $DB;	
		
		$mform = $this->_form; // Don't forget the underscore!
	
		$result= $DB->get_records_sql("SELECT DISTINCT `intensidad` FROM `mdl_ejercicios`");
		$result_tren= $DB->get_records_sql("SELECT DISTINCT `categoria`  FROM `mdl_ejercicios`");
		$options= array();
		foreach($result as $rs)
				$options[$rs->intensidad] = $rs->intensidad;
		
		$options_tren= array();
		foreach ($result_tren as $rst)
			$options_tren[$rst->categoria]= $rst->categoria;
		$mform->addElement('header', 'header', 'Para crear una rutina aleatoria');
		
		$mform->addElement('select', 'intensidad', '¿Qué intensidad quieres?:',$options);

		//$mform->addElement('select', 'categoria', '¿Qué tren de tu cuerpo quieres trabajar?:',$options_tren);
		
		
		$buttonarray=array();
		$buttonarray[] = &$mform->createElement('submit', 'submitbutton', 'Buscar rutina');
		$buttonarray[] = &$mform->createElement('reset', 'resetbutton', 'Resetear');
		$buttonarray[] = &$mform->createElement('cancel', 'cancel', 'Cancelar');
		$mform->addGroup($buttonarray, 'buttonar', '', array(' '), false);
		$mform->addElement('hidden', 'end');
		$mform->setType('end', PARAM_NOTAGS);
		$mform->closeHeaderBefore('end');
	}
	//Custom validation should be added here
	function validation($data, $files) {
		return array();
		$error=array();
		$intensidad= $data['intensidad'];
		$categoria= $data['categoria'];
		if (empty($intensidad)){
			$error['intensidad']="No existe intensidad ingresado";
		}
		else if (empty($categoria)){
			$error['categoria']= "No se ingreso la categoria";
		}
		return $error;
	}
}
?>