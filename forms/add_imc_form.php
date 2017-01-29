<?php
//moodleform is defined in formslib.php
require_once("$CFG->libdir/formslib.php");

class add_imc_form extends moodleform {
	//Add elements to form
	public function definition() {
		global $CFG;	
		
		$mform = $this->_form; // Don't forget the underscore!
	
		$mform->addElement('header', 'header', 'IMC Alumno');

 		$mform->addElement('text', 'email', 'Mail alumno:');
 		$mform->setType('email', PARAM_NOTAGS);
		
		$mform->addElement('text', 'ano', 'Año:','maxlength="4" size="4" ');
		$mform->setType('ano', PARAM_NOTAGS);
		
		$mform->addElement('text', 'estatura', 'Estatura en metros (1.11):');
		$mform->setType('estatura', PARAM_NOTAGS);
		
		$mform->addElement('text', 'peso', 'Peso en kg:');
		$mform->setType('peso', PARAM_NOTAGS);
		
		$this->add_action_buttons();
				
	}
	//Custom validation should be added here
	function validation($data, $files) {
		$error=array();
		$email= $data['email'];
		$estatura= $data['estatura'];
		$ano= $data['ano'];
		$peso= $data['peso'];
		if (empty($email)){
			$error['email']="No existe email ingresado";
		}
		else if (empty($estatura)){
			$error['estatura']= "No se ingreso la estatura";
		}
		else if (empty($peso)){
			$error['peso']="No se ingreso el peso.";
		}else {
			$error['ano']="No se ingreso el año.";
		}
		return $error;
	}
}
?>