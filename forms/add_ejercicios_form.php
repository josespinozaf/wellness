<?php
// moodleform is defined in formslib.php
require_once ("$CFG->libdir/formslib.php");
class add_ejercicios_form extends moodleform {
	// Add elements to form
	public function definition() {
		global $CFG;
		
		$mform = $this->_form; // Don't forget the underscore!
		$mform->addElement ( 'header', 'header', 'Ingresar un nuevo ejercicio' );
		
		$mform->addElement ( 'text', 'nombre', 'Nombre del ejercicio:' );
		$mform->setType ( 'nombre', PARAM_NOTAGS );
		
		$optionsC = array (
				get_string ( 'oaerobico', 'local_wellness' ),
				get_string ( 'ocalentamiento', 'local_wellness' ),
				get_string ( 'ocore', 'local_wellness' ),
				get_string ( 'ofueres', 'local_wellness' ),
				get_string ( 'otgen', 'local_wellness' )
		);
		$mform->addElement ( 'select', 'categoria', 'Categoría:', $optionsC );
		// $mform->setType('categoria', PARAM_NOTAGS);
		
		$optionsI = array (
				get_string ( 'avan', 'local_wellness' ),
				get_string ( 'inter', 'local_wellness' ),
				get_string ( 'basico', 'local_wellness' )
		);
		$mform->addElement ( 'select', 'intensidad', 'Intensidad:', $optionsI );
		// $mform->setType('intensidad', PARAM_NOTAGS);
		
		$optionsZ = array (
				get_string ( 'tsup', 'local_wellness' ),
				get_string ( 'tsupantpos', 'local_wellness' ),
				get_string ( 'tsupant', 'local_wellness' ),
				get_string ( 'tsuppos', 'local_wellness' ),
				get_string ( 'tsupinf', 'local_wellness' ),
				get_string ( 'tinf', 'local_wellness' ),
				get_string ( 'tinfantpos', 'local_wellness' ),
				get_string ( 'tinfant', 'local_wellness' ),
				get_string ( 'tinfpos', 'local_wellness' ),
				get_string ( 'todocuerpo', 'local_wellness' ) 
		);
		$mform->addElement ( 'select', 'zona', 'Zona Muscular:', $optionsZ );
		
		$mform->addElement ( 'text', 'rep1', 'Repeticiones Serie 1:' );
		$mform->setType ( 'rep1', PARAM_NOTAGS );
		
		$mform->addElement ( 'text', 'rep2', 'Repeticiones Serie 2:' );
		$mform->setType ( 'rep2', PARAM_NOTAGS );
		
		$mform->addElement ( 'text', 'rep3', 'Repeticiones Serie 3:' );
		$mform->setType ( 'rep3', PARAM_NOTAGS );
		
		$mform->addElement ( 'text', 'rep4', 'Repeticiones Serie 4:' );
		$mform->setType ( 'rep4', PARAM_NOTAGS );
		
		$mform->addElement ( 'text', 'rep5', 'Repeticiones Serie 5:' );
		$mform->setType ( 'rep5', PARAM_NOTAGS );
		
		$mform->addElement ( 'text', 'link', 'Link del video:' );
		$mform->setType ( 'link', PARAM_RAW );
		
		$buttonarray = array ();
		$buttonarray [] = &$mform->createElement ( 'submit', 'submitbutton', 'Agregar ejercicio' );
		$buttonarray [] = &$mform->createElement ( 'reset', 'resetbutton', 'Resetear' );
		$buttonarray [] = &$mform->createElement ( 'cancel', 'cancel', 'Cancelar' );
		$mform->addGroup ( $buttonarray, 'buttonar', '', array (
				' ' 
		), false );
		$mform->addElement ( 'hidden', 'end' );
		$mform->setType ( 'end', PARAM_NOTAGS );
		$mform->closeHeaderBefore ( 'end' );
	}
	// Custom validation should be added here
	function validation($data, $files) {
		return array ();
		$error = array ();
		$nombre = $data ['nombre'];
		$link = $data ['link'];
		$intensidad = $data ['intensidad'];
		$categoria = $data ['categoria'];
		if (empty ( $intensidad )) {
			$error ['intensidad'] = "No existe intensidad ingresado";
		} else if (empty ( $categoria )) {
			$error ['categoria'] = "No se ingreso la categoria";
		} else if (empty ( $nombre )) {
			$error ['nombre'] = "No se ingreso el nombre";
		} else if (empty ( $link )) {
			$error ['link'] = "No se ingreso el link";
		}
		return $error;
	}
}
?>