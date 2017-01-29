<?php
//moodleform is defined in formslib.php
require_once("$CFG->libdir/formslib.php");

class buttons_form extends moodleform {
	//Add elements to form
	public function definition() {
		global $CFG;

		$mform = $this->_form; // Don't forget the underscore!
		$buttonarray=array();
		$buttonarray[] = &$mform->createElement('submit', 'submitagregar', 'Agregar foto');
		$buttonarray[] = &$mform->createElement('submit', 'submiteditar','Editar foto' );
		$mform->addGroup($buttonarray, 'buttonar', '', array(' '), false);
		
	}
	//Custom validation should be added here
	function validation($data, $files) {
		return array();
	}
}
?>