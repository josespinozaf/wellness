<?php

//moodleform is defined in formslib.php
require_once("$CFG->libdir/formslib.php");

class formulariofotoborrar extends moodleform {
	//Add elements to form
	public function definition() {
		global $CFG, $DB;
		$result = $DB->get_recordset_sql ( "SELECT DISTINCT mc.* , im.*, cm.instance, mc.id FROM mdl_course_modules as cm
		INNER JOIN mdl_course as mc ON cm.instance = mc.id-3
		INNER JOIN mdl_imagenes as im ON mc.fullname = im.nombre
		GROUP BY mc.id" );
	
		$options= array();
		foreach($result as $rs){
			$options[$rs->fullname] = $rs->fullname;
		}

		$result->close();
		$mform = $this->_form; // Don't forget the underscore!

		$mform->addElement('header', 'header', 'Borrar la foto de la clase');

		$mform->addElement('select', 'selectclases', 'Seleccione una clase: ',$options);


		$buttonarray=array();
		$buttonarray[] = &$mform->createElement('submit', 'submitbutton', 'Borrar foto');
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