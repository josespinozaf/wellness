<?php
global $USER, $CFG;
require_once(dirname(__FILE__) . '/../../config.php');
require_once($CFG->dirroot . '/my/lib.php');
include ("connect.php");

redirect_if_major_upgrade_required();

require_login();

$edit   = optional_param('edit', null, PARAM_BOOL);    // Turn editing on and off
$reset  = optional_param('reset', null, PARAM_BOOL);

$params = array();
$PAGE->set_context($context);
$PAGE->set_url('/local/wellness/clases.php', $params);
$PAGE->set_pagelayout('standard');
$PAGE->set_pagetype('local-clases-index');
$PAGE->blocks->add_region('content');
$PAGE->set_subpage($currentpage->id);
$PAGE->set_title(get_string('titleclases','local_wellness'));
$PAGE->set_heading($header);
$PAGE->navbar->add(get_string('navclases','local_wellness'), new moodle_url('/local/wellness/clases.php'));


echo $OUTPUT->header ();

$result = mysql_query("SELECT DISTINCT mp.* , mc.* FROM mdl_course_modules as mc
		INNER JOIN mdl_page as mp ON mc.course = mp.course AND mc.instance = mp.id WHERE mp.course = 1 and mc.module = 15 GROUP BY mp.name", $db);

if (!$result) {
	die("Error en la peticion SQL: " . mysql_error());
}
while ($row = mysql_fetch_array($result)) {

	
	echo "<a href='/../../moodle/mod/page/view.php?id=".$row['id']."'><img src='http://www.clubcamposevilla.com/news_images/section/201209191359370.Clasesdeportivas.jpg' border = '0' alt=".$row['name']." width='200' height='200'></img></a>";
	echo "  ";
}
//echo '<img src="http://espaciorosa.cl/construccion.jpg"></img>';


echo $OUTPUT->footer();
?>