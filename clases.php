<?php
//Config de la pagina
require_once (dirname ( __FILE__ ) . '/conf.php');
$params = array ();
$PAGE->set_context ( $context );
$PAGE->set_url ( '/local/wellness/clases.php', $params );
$PAGE->set_pagelayout ( 'mydashboard' );
$PAGE->set_pagetype ( 'local-clases-index' );
$PAGE->blocks->add_region ( 'content' );
$PAGE->set_subpage ( $currentpage->id );
$PAGE->set_title ( get_string ( 'navclases', 'local_wellness' ) );
$PAGE->set_heading ( $header );
$PAGE->navbar->add ( get_string ( 'navclases', 'local_wellness' ), new moodle_url ( '/local/wellness/clases.php' ) );

//Header
echo $OUTPUT->header ();

//Capabilities para botones
if (has_capability ( "local/wellness:seebutton", $context )) {
	//include simplehtml_form.php
	echo html_writer::tag('a','Agregar foto',array('href'=>'?action=agregar', 'class'=>'btn'));
	echo ' ';
	echo html_writer::tag('a','Buscar foto',array('href'=>'?action=buscar', 'class'=>'btn'));
	echo html_writer::tag('br');
	$action=$_GET['action']; 
	if ($action=='agregar'){
	require_once('forms/formulariofoto_form.php');
	//Instantiate simplehtml_form
	
	$formadd = new formulariofoto_form();
	if ($formadd->is_cancelled()){
		die;
	}
	if ($dataadd = $formadd->get_data()){

		$nombre= $dataadd->selectclases;
		$imagen= $dataadd->imagen;
		$tipo_imagen= $imagen['type'];
				
		$newimg= new stdClass();
		$newimg->nombre = $nombre;
		$newimg->imagen = $imagen;
		$newimg->tipo_imagen= $tipo_imagen;
		$subir = $DB->insert_record('imagenes',$newimg, false); 
		if($subir){
			echo "Se ha ingresado exitosamente.";
		}
		else{
			echo "Error con base de datos.";
			$formadd->display();
		}
	}else{		
		$formadd->display();
	}
	}
	if ($action=='buscar'){
	require_once('forms/formulariofotoeditar_form.php');

	$formedit= new formulariofotoeditar_form();
	
	if ($dataedit= $formedit->get_data()){
		$nombre= $dataadd->selectclases;
		$imagen= $dataadd->imagen;
	 	$tipo_imagen= $imagen['type'];
	 	 
	 	$id= $DB->get_record_sql('SELECT imagen_id FROM mdl_imagenes WHERE nombre=?',array($nombre));
	 	 
		$update_array = new stdClass();
		$update_array->imagen_id = $id;
		$update_array->nombre= $nombre;
		$update_array->imagen = $imagen;
		$update_array->tipo_imagen = $imagen['type'];
		$sql=$DB->update_record('imagenes',$update_array, false);
		if(!$sql)
		{
			echo "Could not update";
		}
		else
		{
			echo "Successful";
		}
		
	}
	else{
		$formedit->display();
	}
	}
}	
//Query para las clases
$result = $DB->get_recordset_sql("SELECT DISTINCT mc.* , pp.* FROM mdl_course as mc INNER JOIN mdl_imagenes as pp ON mc.fullname = pp.nombre");


foreach ($result as $rs){
			echo '<div class="img">';
			echo "<a href='../../course/view.php?id=".$rs->id."'>";
			echo "<img  src='../../local/wellness/imagen.php?nombre=".$rs->name."' alt=". $rs->fullname."></img></a>";
			echo '<div class="desc">'.$rs->fullname.'</div></div>';
		}
$result->close();
//Footer
echo $OUTPUT->footer ();
?>
	
	