<?php
//moodleform is defined in formslib.php
require_once("$CFG->libdir/formslib.php");

class delete_ejercicios_form extends moodleform {
	//Add elements to form
	public function definition() {
			global $CFG, $DB;	
		
		$mform = $this->_form; // Don't forget the underscore!
	
		$result= $DB->get_records_sql("SELECT DISTINCT `nombre` FROM `mdl_ejercicios`");
		
		$options= array();
		foreach($result as $rs)
				$options[$rs->nombre] = $rs->nombre;

		$mform->addElement('header', 'header', 'Para eliminar un ejercicio:');
		
		$mform->addElement('select', 'nombre', '¿Cuál desea borrar?:',$options);		
		$buttonarray=array();
		$buttonarray[] = &$mform->createElement('submit', 'submitbutton', 'Eliminar');
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
		$nombre= $data['nombre'];
		if (empty($nombre)){
			$error['nombre']="No existe nombre ingresado";
		}
		
		return $error;
	}
}
?>
