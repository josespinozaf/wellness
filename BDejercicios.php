<?php
require_once (dirname ( __FILE__ ) . '/conf.php');

$params = array();
$PAGE->set_context($context);
$PAGE->set_url('/local/wellness/BDejercicios.php', $params);
$PAGE->set_pagelayout('mydashboard');
$PAGE->set_pagetype('local-wellness-BDejercicios');
$PAGE->blocks->add_region('content');
$PAGE->set_subpage($currentpage->id);
$PAGE->set_title(get_string('navrutinaaleatoria','local_wellness'));
$PAGE->set_heading($header);
$PAGE->navbar->add(get_string('navrutinaaleatoria','local_wellness'), new moodle_url('/local/wellness/rutina_aleatoria.php'));

echo $OUTPUT->header ();

if (is_siteadmin()){
	if (isset($_POST['Eliminar_ejercicio'])){
		$name= $_REQUEST['nombre'];
		$sql= "DELETE FROM `ejercicios` WHERE `nombre`='".$name."'";
		$result=mysql_query($sql) OR die("Error:".mysql_error());
		if($result){
			echo "Ha sido eliminado con éxito.";
		}
		else{
			echo "Ha ocurrido un error.";
				}
	}
	if (isset($_POST['Agregar_ejercicio'])){
		$name= $_REQUEST['nombre'];
		$category=$_REQUEST['categoria'];
		$link_video=$_REQUEST['link_video'];
		$intensity=$_REQUEST['intensidad'];
		$sql= "INSERT INTO `ejercicios`(`nombre`, `link_video`, `categoria`, `intensidad`)
				 VALUES ('".$name."','".$link_video."','".$category."','".$intensity."')";
		$result=mysql_query($sql) OR die("Error:".mysql_error());;
		if($result){
			echo "Ha sido agregado con éxito.";
		}
		else{echo "Ha ocurrido un error." ;}
		

}
echo "<form><input type='button' value='Volver' onClick='history.back();return true;'></form>";
}
echo $OUTPUT->footer;
?>
