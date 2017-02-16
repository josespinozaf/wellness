<?php
// Configuracion de la pagina
require_once (dirname ( __FILE__ ) . '/conf.php');
$params = array ();
$PAGE->set_context ( $context );
$PAGE->set_url ( '/local/wellness/rutina_aleatoria.php', $params );
$PAGE->set_pagelayout ( 'mydashboard' );
$PAGE->set_pagetype ( 'local-wellness-rutina aleatoria' );
$PAGE->blocks->add_region ( 'content' );
$PAGE->set_subpage ( $currentpage->id );
$PAGE->set_title ( get_string ( 'navrutinaaleatoria', 'local_wellness' ) );
$PAGE->set_heading ( $header );
$PAGE->navbar->add ( get_string ( 'navrutinaaleatoria', 'local_wellness' ), new moodle_url ( '/local/wellness/rutina_aleatoria.php' ) );

// Header
echo $OUTPUT->header ();
$url = 'rutina_aleatoria.php' ;
if (!has_capability('local/wellness:seebutton', $context)){
require_once('forms/rutinaaleatoria_form.php');

$form = new rutinaaleatoria_form();

if ($form-> is_cancelled()){
	redirect($url);
	die;
}
if ($formsend = $form->get_data()){
	echo html_writer::tag('p','<h4>Rutina Aleatoria</h4>');
	$intensidad = $formsend->intensidad;
	$categoria = $formsend->categoria;
	// Tabla con rutina aleatoria
	$ej = $DB->get_recordset_sql("SELECT * FROM `ejercicios` WHERE `intensidad`=? AND `categoria`=? ORDER BY RAND() LIMIT 4", array($intensidad, $categoria));
	$table = new html_table();
	$table->head = array('Ejercicio','Intensidad', 'Tren', 'Link Video');
	foreach ($ej as $records) {
		$nombre = $records->nombre;
		$intensidad = $records->intensidad;
		$categoria = $records->categoria;
		$link = $records->link_video;
		$table->data[] = array($nombre, $intensidad, $categoria,'<a href="'.$link.'">View</a>');
	}
	echo html_writer::table($table);
	echo html_writer::tag('p', 'Las repeticiones son según tu nivel y son de 4 series, ve tu nivel de repeticiones más abajo.');
	echo html_writer::tag('a','Volver',array('class'=>'btn','onClick'=>'history.back();return true;'));
	
	// Tabla de trabajo según %
	$table_rep = new html_table();
	$table_rep->head = array('Entrenamiento','Peso', '% Del trabajo', 'Repeticiones', 'Series', 'Descanso entre series');
	$table_rep->data[] =array('Resistencia','Ligero','50% a 60%', '12 a 20', '3 a 4', '20 a 30 seg');
	$table_rep->data[] =array('Hipertrofia','Moderado','70% a 80%', '8 a 12', '3 a 4', '30 a 90 seg');
	$table_rep->data[] =array('Fuerza','Pesado','800% a 100%', '2 a 6 ', '1 a 6', '120 a 240 seg');
	echo html_writer::table($table_rep);
}
else{
	$form->display();
}
}
else {
	//Tabla de todos los ejercicios
	echo html_writer::link('?action=ver','Ver todos los ejercicios', array('class'=>'btn', 'id'=>'ver_ejercicios', 'name'=>'ver_ejercicios'),null)." ";
	$action=@$_GET['action'];
	if($action=='ver'){
		echo html_writer::tag('a','Volver',array('class'=>'btn','onClick'=>'history.back();return true;'));
		echo html_writer::tag('br','');
		//Datos de la tabla de ejercicios actuales
		$eje = $DB->get_recordset_sql("SELECT DISTINCT * FROM `ejercicios` ORDER BY `ejercicios`.`intensidad` ASC");
		$table = new html_table();
		$table->head = array('Ejercicio','Intensidad', 'Categoria', 'Link Video');
		foreach ($eje as $records) {
			$nombre = $records->nombre;
			$intensidad = $records->intensidad;
			$categoria = $records->categoria;
			$link = $records->link_video;
			$table->data[] = array($nombre, $intensidad, $categoria,'<a href="'.$link.'">View</a>');
		}
	
		echo html_writer::table($table);
	}
	else{
	//formulario para agregar ejercicios
	require_once ('forms/add_ejercicios_form.php');
	
	$formej= new add_ejercicios_form();
	
	if($formej->is_cancelled()){
		redirect($url);
		die;
	}
	if($formsendej= $formej->get_data()){
		$nombre = $formsendej->nombre;
		$categoria = $formsendej->categoria;
		$intensidad = $formsendej->intensidad;
		$link = $formsendej->link;
		
		$newej = new stdClass();
		$newej->nombre         = $nombre;
		$newej->categoria	   = $categoria;
		$newej->intensidad	   = $intensidad;
		$newej->link_video     = $link;
		$subir = $DB->insert_record("ejercicios", $newej, false);
		if($subir){
			echo "Se ha ingresado exitosamente.";
		}
		else{
			echo "Error con base de datos.";
			redirect($url);
		}
	}
	else{
		$formej->display();
	}
	//Formulario para eliminar ejercicio
	require_once('forms/delete_ejercicios_form.php');
	
	$formdel = new delete_ejercicios_form();
		
	if ($formdel-> is_cancelled()){
		redirect($url);
		die;
	}
	if ($formsenddel= $formdel->get_data()){
		$nombre = $formsenddel->nombre;	
		$delete = $DB->delete_records_select('ejercicios','`nombre`=?', array($nombre));
		if ($delete){
			echo "Eliminado con éxito";
			
		}else{
			echo "Error";
		}
		redirect($url);
	}
	else{
		$formdel->display();	
	}
	}
}





