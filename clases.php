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
	// Inicio de formulario para agregar foto
	require_once('forms/formulariofoto_form.php');
	$formadd = new formulariofoto_form();
	//Url para redirección 
	$url='clases.php';
	if ($formadd->is_cancelled()){
		die;
	}
	$nombre_imagen=$formadd->get_new_filename('imagen');
	if ($dataadd = $formadd->get_data()){
		$nombre= $dataadd->selectclases;
		$imagen= $dataadd->imagen;
		$newimg= new stdClass();
		$newimg->nombre = $nombre;
		$newimg->imagen = $imagen;
		$newimg->nombre_imagen= $nombre_imagen;
		$subir = $DB->insert_record('imagenes',$newimg); 
		if($subir){
			echo "Se ha ingresado exitosamente.";
			redirect($url);
			die;
		}
		else{
			echo "Error con base de datos.";
			$formadd->display();
		}
	}else{		
		$formadd->display();
	}
	// Inicio de formulario para editar foto
	require_once('forms/formulariofotoeditar_form.php');
	
	$formedit= new formulariofotoeditar_form();
	$nombre_imagen1=$formedit->get_new_filename('imagen');
	if ($dataedit= $formedit->get_data()){
		$nombre= $dataedit->selectclases;
		$imagen= $dataedit->imagen;
	 	$sql="UPDATE `mdl_imagenes` SET `imagen`=?,`nombre_imagen`=?
	 			WHERE `nombre`=?";
	 	$update=$DB->execute($sql,array($imagen,$nombre_imagen1,$nombre));
		if(!$update){
			echo "No se pudo actualizar.";
			redirect($url);
			die;				
		}
		else{
			echo "Éxito!";
			redirect($url);
			die;
		}
	}
	else{
		$formedit->display();
	}
}
//Query para las clases
$result = $DB->get_recordset_sql("SELECT DISTINCT mp.* , im.*, cm.instance, cm.id FROM mdl_course_modules as cm
		INNER JOIN mdl_page as mp ON cm.instance = mp.id
		INNER JOIN mdl_imagenes as im ON mp.name = im.nombre
		WHERE mp.course = 4
		GROUP BY mp.name");
		
		foreach ($result as $rs)
		{
			$imagen = $rs->imagen;
			echo '<div class="img">';
			echo "<a href='../../mod/page/view.php?id=".$rs->id."'>";
			echo '<img src="data:image/jpeg;base64,'.base64_encode( $imagen ).'"/></img></a>';
			echo '<div class="desc">'.$rs->name.'</div></div>';
		
		}
$result->close();
//Footer
echo $OUTPUT->footer ();
?>
	
	