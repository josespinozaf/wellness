<?php
//moodleform is defined in formslib.php
require_once("$CFG->libdir/formslib.php");

class search_imc_form extends moodleform {
	//Add elements to form
	public function definition() {
		global $CFG;
		
		$mform = $this->_form; // Don't forget the underscore!
		$mform->addElement('header', 'header', 'Buscar IMC Alumno');
		$mform->addElement('text', 'email', 'Mail alumno:');
		$mform->setType('email', PARAM_NOTAGS);

		$buttonarray=array();
		$buttonarray[] = &$mform->createElement('submit', 'submitbutton', 'Buscar IMC');
		$buttonarray[] = &$mform->createElement('cancel', 'cancel', 'Cancelar');
		$mform->addGroup($buttonarray, 'buttonar', '', array(' '), false);
		$mform->addElement('hidden', 'end');
		$mform->setType('end', PARAM_NOTAGS);
		$mform->closeHeaderBefore('end');
	}
	//Custom validation should be added here
	function validation($data, $files) {
		$error=array();
		$email= $data['email'];
		if (empty($email)){
			$error['email']="No existe email para buscar.";
		}
		
	}
}
?>

