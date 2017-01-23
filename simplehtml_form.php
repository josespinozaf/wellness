<?php
global $DB;
//moodleform is defined in formslib.php
require_once("$CFG->libdir/formslib.php");

class simplehtml_form extends moodleform {
	//Add elements to form
	public function definition() {
		global $CFG;

		$mform = $this->_form; // Don't forget the underscore!

		$mform->addElement('submit', 'submitagregar','Agregar foto a clase');
		$mform->addElement('submit', 'submiteditar','Cambiar foto a clase');
		
	}
	//Custom validation should be added here
	function validation($data, $files) {
		return array();
	}
}
class form_formulariofoto_agregar extends moodleform {
	//Add elements to form
	public function definition() {
		global $CFG;

		$form = $this->_form; // Don't forget the underscore!
	
		$list= get_records_sql("SELECT DISTINCT mcm.* , mc.* FROM mdl_course_modules as mcm
		INNER JOIN mdl_course as mc ON mcm.course = mc.id
		WHERE mcm.module = 9
		GROUP BY mc.fullname");
		
		$select = $form->addElement('select', 'nombre', 'Selecciona el nombre de la clase:', $list);
		$select->setMultiple(true);
		
		$mform->addElement('file', 'imagen','Subir imagen:');
		
		$mform->addElement('submit', 'submiteditar','Subir');
	}
	//Custom validation should be added here
	function validation($data, $files) {
		return array();
	}
}