<?php
global $USER, $CFG;
require_once(dirname(__FILE__) . '/../../config.php');
require_once($CFG->dirroot . '/my/lib.php');
include ("connect.php");

$userid= $USER->id;
$usermail= $USER->email;

echo $OUTPUT->header();

$result = mysql_query("SELECT DISTINCT cantasist.*, asistencias2.*, fitnessgram.*
		FROM asistencias2
		INNER JOIN cantasist
		INNER JOIN fitnessgram
		WHERE asistencias2.rut = fitnessgram.RUT AND fitnessgram.email = '$usermail' AND asistencias2.Periodo='S-SEM. 2012/1'", $db);

if (!$result) {
	die("Error en la peticion SQL: " . mysql_error());
}
while ($row = mysql_fetch_array($result)) {
	 
	echo 'Asitencias: '.$row['Asistencia'];
	echo "<br>";
	echo 'Semana: '.$row['semana'];
	echo "<br>";
	echo 'RUT: '.$row['RUT'];
	echo "<br>";
	echo 'Total necesario: '.$row['totalasistencias'];
	echo "<br>";
}	

echo $OUTPUT->footer();
	?>