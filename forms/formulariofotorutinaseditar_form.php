<?php 

//moodleform is defined in formslib.php
require_once("$CFG->libdir/formslib.php");

class formulariofotorutinaseditar_form extends moodleform {
	//Add elements to form
	public function definition() {
		global $CFG, $DB;

		$sql= "SELECT DISTINCT mp.* , mc.* FROM mdl_course_modules as mc
								  INNER JOIN mdl_page as mp ON mc.course = mp.course AND mc.instance = mp.id
								  WHERE mp.course = 5 and mc.module = 15
								  GROUP BY mp.name";
		$result= $DB-> get_recordset_sql($sql);
		$options= array();
		foreach($result as $rs){
			$options[$rs->name] = $rs->name;
		}
		$result->close();
		$mform = $this->_form; // Don't forget the underscore!

		$mform->addElement('header', 'header', 'Editar una foto a rutina');

		$mform->addElement('select', 'selectrutinas', 'Seleccione una rutinas: ', $options);

		$mform->addElement('filepicker', 'imagen','Subir imagen: *Este archivo debe ser .jpg, .jpeg, .png', null,array('maxbytes' => 512000, 'accepted_types' => array('*.png', '*.jpg', '*.jpeg')));
		
		$buttonarray=array();
		$buttonarray[] = &$mform->createElement('submit', 'submitbutton', 'Editar foto');
		$buttonarray[] = &$mform->createElement('cancel', 'cancel', 'Cancelar');
		$mform->addGroup($buttonarray, 'buttonar', '', array(' '), false);
		$mform->addElement('hidden', 'end');
		$mform->setType('end', PARAM_NOTAGS);
		$mform->closeHeaderBefore('end');
	}
	//Custom validation should be added here
	function validation($data, $files) {
		$error=array();
		$selectrutinas= $data['selectrutinas'];
		$imagen= $data['imagen'];
		if (empty($selectrutinas)){
			$error['selectrutinas']="No existe seleccion de rutina";
		}
		else if (empty($imagen)){
			$error['imagen']= "No se ingreso ninguna imagen";
		}
		return $error;
	}
}
?>