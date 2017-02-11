<?php 

//moodleform is defined in formslib.php
require_once("$CFG->libdir/formslib.php");

class formulariofoto_form extends moodleform {
	//Add elements to form
	public function definition() {
		global $CFG, $DB;
		
		$sql= "SELECT DISTINCT mcm.* , mc.* FROM mdl_course_modules as mcm
				INNER JOIN mdl_course as mc ON mcm.course = mc.id
				WHERE mcm.module = 9 GROUP BY mc.fullname";
		$result= $DB-> get_recordset_sql($sql);
		$options= array();
		foreach($result as $rs){
			$options[$rs->fullname] = $rs->fullname;
		}
		
		$result->close();
		$mform = $this->_form; // Don't forget the underscore!
	
		$mform->addElement('header', 'header', 'Agregar una foto a clase');
		
		$mform->addElement('select', 'selectclases', 'Seleccione una clase: ',$options);
		
		$mform->addElement('filepicker', 'imagen','Subir imagen: *Este archivo debe ser .jpg, .jpeg, .png', null,array('maxbytes' => 512000, 'accepted_types' => array('*.png', '*.jpg', '*.jpeg')));
		
		$buttonarray=array();
		$buttonarray[] = &$mform->createElement('submit', 'submitbutton', 'Agregar foto');
		$buttonarray[] = &$mform->createElement('cancel', 'cancel', 'Cancelar');
		$mform->addGroup($buttonarray, 'buttonar', '', array(' '), false);
		$mform->addElement('hidden', 'end');
		$mform->closeHeaderBefore('end');


	}
	//Custom validation should be added here
	function validation($data, $files) {
		$error=array();
		$selectclases= $data['selectclases'];
		$imagen= $data['imagen'];
		if (empty($selectclases)){
			$error['selectclases']="No existe seleccion de clases";				
		}
		else if (empty($imagen)){
			$error['imagen']= "No se ingreso ninguna imagen";
		}
		return $error;
	}
}