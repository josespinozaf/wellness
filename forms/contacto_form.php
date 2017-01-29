<?php
//moodleform is defined in formslib.php
require_once("$CFG->libdir/formslib.php");

class contacto_form extends moodleform {
	//Add elements to form
	public function definition() {
		global $CFG;

		$mform = $this->_form; // Don't forget the underscore!

		$mform->addElement('header', 'header', 'Contacto Deportes UAI');

		$mform->addElement('text', 'first_name', 'Nombre alumno*','maxlength=50 size=30');
		$mform->setType('first_name', PARAM_NOTAGS);
		
		$mform->addElement('text', 'apellido', 'Apellido alumno*','maxlength=50 size=30');
		$mform->setType('first_name', PARAM_NOTAGS);
		
		$mform->addElement('text', 'email', 'Mail alumno*','maxlength=50 size=30');
		$mform->setType('email', PARAM_NOTAGS);

		$mform->addElement('textarea', 'comments', 'Comentarios/Preguntas*','maxlength=1000 cols=25 rows=6');
		$mform->setType('comments', PARAM_NOTAGS);
		
		$mform->addElement('submit', 'submit','Enviar');
		
	}
	//Custom validation should be added here
	function validation($data, $files) {
		$error=array();
		$email= $data['email'];
		$nombre=$data['first_name'];
		$apellido=$data['apellido'];
		$comments=$data['comments'];
		
		if (empty($email)){
			$error['email']="No existe email ingresado";
		}
		else if (empty($nombre)){
			$error['first_name']= "No se ingreso el primer nombre";
		}
		else if (empty($apellido)){
			$error['apellido']="No se ingreso el apellido.";
		}else if(empty($comments)){
			$error['comments']="No se ingreso el comentario";
		}
		return $error;
	}
}
?>