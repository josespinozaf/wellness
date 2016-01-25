<?php
global $USER, $CFG;
require_once(dirname(__FILE__) . '/../../config.php');
require_once($CFG->dirroot . '/my/lib.php');
include ("connect.php");

$userid= $USER->id;
$usermail= $USER->email;

echo $OUTPUT->header();

$result = mysql_query("SELECT DISTINCT mp.* , mc.* FROM mdl_course_modules as mc
		INNER JOIN mdl_page as mp ON mc.course = mp.course AND mc.instance = mp.id WHERE mp.course = 1 and mc.module = 15 GROUP BY mp.name", $db);

if (!$result) {
	die("Error en la peticion SQL: " . mysql_error());
}
while ($row = mysql_fetch_array($result)) {
	 
	echo 'Module: '.$row['module'];
	echo "<br>";
	echo 'Name: '.$row['name'];
	echo "<br>";
	echo 'course: '.$row['course'];
	echo "<br>";
	echo 'id: '.$row['id'];
	echo "<br>";
	echo "<a href='/../../moodle/mod/page/view.php?id=".$row['id']."'>".$row['name']."</a>";
	echo "<br>";
	}	

echo $OUTPUT->footer();
	?>