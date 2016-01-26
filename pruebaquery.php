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

$resultfoto = mysql_query("SELECT DISTINCT mp.* , pp.* FROM mdl_page as mp
		INNER JOIN page_pix as pp ON mp.id = pp.pageid", $db);

$result1 = mysql_query("SELECT DISTINCT mp.* , mc.*,pp.* FROM mdl_course_modules as mc
		INNER JOIN mdl_page as mp ON mc.course = mp.course AND mc.instance = mp.id 
		INNER JOIN page_pix as pp ON mp.name = pp.name
		WHERE mp.course = 1 and mc.module = 15 GROUP BY mp.name", $db);

if (!$result1) {
	die("Error en la peticion SQL: " . mysql_error());
}

while ($row = mysql_fetch_array($result)) {
	 while ($row1 = mysql_fetch_array($resultfoto)){
	 	if ($row['name'] == $row1['name'] ){
	echo 'Name: '.$row['name'];
	echo "<br>";
	echo 'Foto: '.$row1['pix']; 	
	echo "<br>";
	echo 'course: '.$row['module'];
	echo "<br>";
	echo 'id: '.$row['id'];
	echo "<br>";
	//echo "<a href='/../../moodle/mod/page/view.php?id=".$row['id']."'>".$row['name']."</a>";
	echo "<a href='/../../moodle/mod/page/view.php?id=".$row['id']."'><img src=".$row1['pix']." border = '0' alt=".$row['name']." width='200' height='200'></img></a><br>";
	 	}}
	}	

echo $OUTPUT->footer();
	?>