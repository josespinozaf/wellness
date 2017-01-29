<?php
//moodleform is defined in formslib.php
require_once("$CFG->libdir/formslib.php");

class buttons_imc_form extends moodleform {
	//Add elements to form
	public function definition() {
		global $CFG;

		$mform = $this->_form; // Don't forget the underscore!
		$button=array();
		$button[] = &$mform->createElement('submit', 'submitadd', 'Agregar imc');
		$button[] = &$mform->createElement('submit', 'submitsearch','Buscar imc' );
		$mform->addGroup($button, 'buttonar', '', array(' '), false);
		
	}
	//Custom validation should be added here
	function validation($data, $files) {
		return array();
	}
}
?>